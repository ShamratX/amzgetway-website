# -*- coding: utf-8 -*-
"""
Sync HTML `data-cms="page.*"` text into Cloudflare D1 site_cms.

Why: Worker applies autoPages overrides on every HTML response. Editing HTML
and deploying alone does not change those overrides, so banner/copy stays old.
This script copies current HTML values into autoPages (+ pages.home for home)
so deploy and CMS can both drive live content (last write wins).

Usage (from this repo):
  python scripts/sync-cms-from-html.py --site-root "D:/path/to/frontend" --d1 YOUR_D1_NAME
  python scripts/sync-cms-from-html.py --site-root ../townloc --d1 townloc-leads --dry-run

Env:
  CMS_SITE_ROOT  frontend folder that contains index.html
  CMS_D1_NAME    D1 database name from wrangler.toml
"""
from __future__ import annotations

import argparse
import json
import os
import re
import subprocess
import sys
import tempfile
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parents[1]
WORKER = REPO_ROOT / "worker"

# Local HTML path (relative to --site-root) → autoPages key + optional pages.* bucket
PAGE_MAP = {
    "index.html": ("index.html", "home"),
}

TAG_RE = re.compile(
    r"<(?P<tag>h1|h2|h3|p|a|button|span)\b(?P<attrs>[^>]*\bdata-cms=\"page\.(?P<key>[^\"]+)\"[^>]*)>(?P<inner>.*?)</(?P=tag)>",
    re.I | re.S,
)


def strip_tags(html: str) -> str:
    text = re.sub(r"<[^>]+>", " ", html or "")
    return re.sub(r"\s+", " ", text).strip()


def extract_page_fields(html: str) -> dict[str, str]:
    out: dict[str, str] = {}
    for m in TAG_RE.finditer(html):
        key = m.group("key").strip()
        text = strip_tags(m.group("inner"))
        if key and text:
            out[key] = text
    return out


def stable_id(data_cms_key: str) -> str:
    safe = re.sub(r"[^a-z0-9._:-]+", "-", f"page.{data_cms_key}", flags=re.I)
    return f"text:s:{safe}"


def npx_cmd() -> str:
    return "npx.cmd" if sys.platform.startswith("win") else "npx"


def wrangler_json(d1_name: str, command: str) -> dict:
    proc = subprocess.run(
        [
            npx_cmd(),
            "wrangler",
            "d1",
            "execute",
            d1_name,
            "--remote",
            "--json",
            "--command",
            command,
        ],
        cwd=str(WORKER),
        capture_output=True,
        text=True,
        encoding="utf-8",
        shell=False,
    )
    if proc.returncode != 0:
        sys.stderr.write((proc.stdout or "") + "\n" + (proc.stderr or ""))
        raise SystemExit(f"wrangler failed ({proc.returncode})")
    payload = json.loads(proc.stdout)
    if isinstance(payload, list):
        return payload[0]
    return payload


def read_cms_doc(d1_name: str) -> dict:
    result = wrangler_json(d1_name, "SELECT data FROM site_cms WHERE id = 1;")
    rows = result.get("results") or []
    if not rows:
        raise SystemExit("site_cms row missing")
    raw = rows[0]["data"]
    return json.loads(raw) if isinstance(raw, str) else raw


def write_cms_doc(d1_name: str, doc: dict) -> None:
    raw = json.dumps(doc, ensure_ascii=False, separators=(",", ":"))
    sql_literal = raw.replace("'", "''")
    sql = f"UPDATE site_cms SET data = '{sql_literal}', updated_at = datetime('now') WHERE id = 1;"
    with tempfile.NamedTemporaryFile(
        "w", encoding="utf-8", suffix=".sql", delete=False, newline="\n"
    ) as fh:
        fh.write(sql)
        sql_path = Path(fh.name)
    try:
        proc = subprocess.run(
            [
                npx_cmd(),
                "wrangler",
                "d1",
                "execute",
                d1_name,
                "--remote",
                "--file",
                str(sql_path),
            ],
            cwd=str(WORKER),
            capture_output=True,
            text=True,
            encoding="utf-8",
            shell=False,
        )
        if proc.returncode != 0:
            sys.stderr.write((proc.stdout or "") + "\n" + (proc.stderr or ""))
            raise SystemExit(f"wrangler write failed ({proc.returncode})")
        out = (proc.stdout or "").encode("ascii", "replace").decode("ascii")
        print(out.strip() or "D1 update OK")
    finally:
        sql_path.unlink(missing_ok=True)


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument(
        "--site-root",
        default=os.environ.get("CMS_SITE_ROOT", ""),
        help="Frontend folder that contains index.html",
    )
    ap.add_argument(
        "--d1",
        default=os.environ.get("CMS_D1_NAME", ""),
        help="D1 database name (wrangler.toml)",
    )
    args = ap.parse_args()

    site_root = Path(args.site_root).resolve() if args.site_root else None
    if not site_root or not site_root.is_dir():
        raise SystemExit(
            "Set --site-root or CMS_SITE_ROOT to the frontend folder (with index.html)."
        )
    d1_name = (args.d1 or "").strip()
    if not d1_name:
        raise SystemExit("Set --d1 or CMS_D1_NAME to your D1 database name.")

    doc = read_cms_doc(d1_name)
    auto_pages = dict(doc.get("autoPages") or {})
    pages = dict(doc.get("pages") or {})
    changed: list[str] = []

    for rel, (auto_key, pages_key) in PAGE_MAP.items():
        html_path = site_root / rel
        if not html_path.is_file():
            print(f"skip missing {rel}")
            continue
        fields = extract_page_fields(html_path.read_text(encoding="utf-8"))
        if not fields:
            print(f"no page.* fields in {rel}")
            continue

        bucket = dict(auto_pages.get(auto_key) or {})
        page_bucket = dict(pages.get(pages_key) or {}) if pages_key else {}

        for key, text in fields.items():
            sid = stable_id(key)
            if bucket.get(sid) != text:
                changed.append(f"{auto_key}:{sid}")
                bucket[sid] = text
            if pages_key and page_bucket.get(key) != text:
                changed.append(f"pages.{pages_key}.{key}")
                page_bucket[key] = text

        auto_pages[auto_key] = bucket
        if pages_key:
            pages[pages_key] = page_bucket

        print(f"{rel}: synced {len(fields)} page.* fields")

    if not changed:
        print("No CMS changes needed (already in sync).")
        return

    print(f"Updating {len(changed)} values…")
    for c in changed[:30]:
        print(f"  - {c}")
    if len(changed) > 30:
        print(f"  … +{len(changed) - 30} more")

    doc["autoPages"] = auto_pages
    doc["pages"] = pages

    if args.dry_run:
        print("Dry run — not writing D1.")
        return

    write_cms_doc(d1_name, doc)
    print("Done. Hard-refresh the live site to see HTML page.* copy.")


if __name__ == "__main__":
    main()
