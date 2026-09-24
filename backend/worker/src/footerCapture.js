/**
 * Auto-capture structured footer fields from site HTML.
 * Supports master CMS class conventions AND WordPress/Avas widget footers
 * (AmzGetway export: .footer / #footer-top / widget-title / Skype·WA·contact).
 */

function stripFooterText(html) {
  return String(html || "")
    .replace(/<script[\s\S]*?<\/script>/gi, " ")
    .replace(/<style[\s\S]*?<\/style>/gi, " ")
    .replace(/<[^>]+>/g, " ")
    .replace(/&nbsp;/gi, " ")
    .replace(/&amp;/gi, "&")
    .replace(/&#038;/gi, "&")
    .replace(/&quot;/gi, '"')
    .replace(/&#39;/gi, "'")
    .replace(/&lt;/gi, "<")
    .replace(/&gt;/gi, ">")
    .replace(/\s+/g, " ")
    .trim();
}

function firstMatchInner(html, re) {
  const m = String(html || "").match(re);
  return m ? stripFooterText(m[1]) : "";
}

function allMatchInners(html, re) {
  const out = [];
  const src = String(html || "");
  let m;
  const r = new RegExp(re.source, re.flags.includes("g") ? re.flags : re.flags + "g");
  while ((m = r.exec(src))) out.push(stripFooterText(m[1]));
  return out;
}

/** Slice the live site footer block (WP `.footer` or semantic `<footer>`). */
export function footerRegionHtml(html) {
  const raw = String(html || "");
  const footerTag = raw.match(/<footer\b[^>]*>[\s\S]*?<\/footer>/i);
  if (footerTag) return footerTag[0];

  // Prefer exact class token "footer" (not menu-footer / footer-top / footer_bg)
  let open = null;
  const classDivRe = /<div\b[^>]*\bclass=["']([^"']*)["'][^>]*>/gi;
  let m;
  while ((m = classDivRe.exec(raw))) {
    const tokens = String(m[1] || "")
      .trim()
      .split(/\s+/)
      .filter(Boolean);
    if (tokens.includes("footer")) {
      open = m;
      break;
    }
  }

  if (!open) {
    // Fallback: from #footer-top through #footer sibling
    const top = raw.match(
      /<div\b[^>]*\bid=["']footer-top["'][^>]*>/i
    );
    const bottom = raw.match(
      /<div\b[^>]*\bid=["']footer["'][^>]*>/i
    );
    if (top && bottom && bottom.index > top.index) {
      // balance from footer-top, then extend through #footer close
      const start = top.index;
      let depth = 0;
      const re = /<\/?div\b[^>]*>/gi;
      re.lastIndex = start;
      let end = -1;
      let tm;
      while ((tm = re.exec(raw))) {
        if (/^<\/div/i.test(tm[0])) depth -= 1;
        else depth += 1;
        if (depth === 0) {
          end = tm.index + tm[0].length;
          break;
        }
      }
      // continue to include #footer if it sits after footer-top close
      if (end > 0 && bottom.index >= end) {
        depth = 0;
        re.lastIndex = bottom.index;
        while ((tm = re.exec(raw))) {
          if (/^<\/div/i.test(tm[0])) depth -= 1;
          else depth += 1;
          if (depth === 0) {
            end = tm.index + tm[0].length;
            break;
          }
        }
        return raw.slice(start, end);
      }
      if (end > 0) return raw.slice(start, end);
    }
    return "";
  }

  const start = open.index;
  let depth = 0;
  const re = /<\/?div\b[^>]*>/gi;
  re.lastIndex = start;
  let tm;
  while ((tm = re.exec(raw))) {
    if (/^<\/div/i.test(tm[0])) depth -= 1;
    else depth += 1;
    if (depth === 0) {
      return raw.slice(start, tm.index + tm[0].length);
    }
  }
  return raw.slice(start);
}

function extractConventionFooter(raw) {
  const footer = {};

  const tagline = firstMatchInner(
    raw,
    /<p\b[^>]*\bfooter-tagline\b[^>]*>([\s\S]*?)<\/p>/i
  );
  if (tagline) footer.tagline = tagline;

  const titles = allMatchInners(
    raw,
    /<p\b[^>]*\bfooter-col-title\b[^>]*>([\s\S]*?)<\/p>/i
  );
  if (titles[0]) footer.servicesTitle = titles[0];
  if (titles[1]) footer.contactTitle = titles[1];
  if (titles[2]) footer.companyTitle = titles[2];

  const contactBlock = raw.match(
    /<ul\b[^>]*\bfooter-contact\b[^>]*>([\s\S]*?)<\/ul>/i
  );
  if (contactBlock) {
    const labels = [];
    const liRe = /<li\b[^>]*>([\s\S]*?)<\/li>/gi;
    let li;
    while ((li = liRe.exec(contactBlock[1]))) {
      const span = li[1].match(/<span\b[^>]*>([\s\S]*?)<\/span>/i);
      const text = span ? stripFooterText(span[1]) : stripFooterText(li[1]);
      if (text) labels.push(text);
    }
    if (labels[0]) footer.contactEmail1 = labels[0];
    if (labels[1]) footer.contactEmail2 = labels[1];
    if (labels[2]) footer.contactPhone = labels[2];
    if (labels[3]) footer.contactWhatsapp = labels[3];
  }

  const gLabel = firstMatchInner(
    raw,
    /<p\b[^>]*\bfooter-guarantee-label\b[^>]*>([\s\S]*?)<\/p>/i
  );
  if (gLabel) footer.guaranteeLabel = gLabel;

  const gTextRaw = raw.match(
    /<p\b[^>]*\bfooter-guarantee-text\b[^>]*>([\s\S]*?)<\/p>/i
  );
  if (gTextRaw) {
    const gText = stripFooterText(
      String(gTextRaw[1]).replace(/<span\b[^>]*>\s*\|\s*<\/span>/gi, " | ")
    );
    if (gText) footer.guaranteeText = gText;
  }

  const bottom = raw.match(
    /<div\b[^>]*\bfooter-bottom\b[^>]*>([\s\S]*?)<\/div>/i
  );
  if (bottom) {
    const copyP = bottom[1].match(/<p\b[^>]*>([\s\S]*?)<\/p>/i);
    if (copyP) {
      let copy = stripFooterText(copyP[1]);
      copy = copy
        .replace(/^©\s*/u, "")
        .replace(/^\d{4}\s*/, "")
        .replace(/^year\s*/i, "")
        .trim();
      if (copy) footer.copyrightText = copy;
    }
    const cta = bottom[1].match(
      /<a\b[^>]*\bfooter-cta\b[^>]*>([\s\S]*?)<\/a>/i
    );
    if (cta) {
      const t = stripFooterText(cta[1]);
      if (t) footer.ctaText = t;
    }
  } else {
    const cta = firstMatchInner(
      raw,
      /<a\b[^>]*\bfooter-cta\b[^>]*>([\s\S]*?)<\/a>/i
    );
    if (cta) footer.ctaText = cta;
  }

  return footer;
}

function asideById(region, id) {
  const re = new RegExp(
    `<aside\\b[^>]*\\bid=["']${id}["'][^>]*>([\\s\\S]*?)<\\/aside>`,
    "i"
  );
  const m = region.match(re);
  return m ? m[1] : "";
}

function widgetTitle(asideInner) {
  return firstMatchInner(asideInner, /<h3\b[^>]*\bwidget-title\b[^>]*>([\s\S]*?)<\/h3>/i);
}

function textwidgetInner(asideInner) {
  const m = asideInner.match(
    /<div\b[^>]*\btextwidget\b[^>]*>([\s\S]*?)<\/div>/i
  );
  return m ? m[1] : "";
}

function parasWithIcon(textwidget, iconClass) {
  const out = [];
  const re = /<p\b[^>]*>([\s\S]*?)<\/p>/gi;
  let m;
  while ((m = re.exec(textwidget))) {
    if (new RegExp(`\\b${iconClass}\\b`, "i").test(m[1])) {
      const t = stripFooterText(m[1]);
      if (t) out.push(t);
    }
  }
  return out;
}

function extractWpFooter(raw) {
  const region = footerRegionHtml(raw);
  if (!region) return {};
  const footer = {};

  // Logo column tagline (#text-2): first substantial text <p> without an image
  const about = asideById(region, "text-2") || asideById(region, "text-3");
  const aboutTw = textwidgetInner(about);
  if (aboutTw) {
    const pRe = /<p\b[^>]*>([\s\S]*?)<\/p>/gi;
    let pm;
    while ((pm = pRe.exec(aboutTw))) {
      if (/<img\b/i.test(pm[1])) continue;
      if (/wpcf7|type=["']email["']/i.test(pm[1])) continue;
      const t = stripFooterText(pm[1]);
      if (t.length >= 20) {
        footer.tagline = t;
        break;
      }
    }
  }

  const servicesAside = asideById(region, "nav_menu-4") || asideById(region, "nav_menu-1");
  const servicesTitle = widgetTitle(servicesAside);
  if (servicesTitle) footer.servicesTitle = servicesTitle;

  // Skype & WhatsApp column
  let skypeAside =
    asideById(region, "avas_text-3") ||
    "";
  if (!skypeAside) {
    const m = region.match(
      /<aside\b[^>]*>([\s\S]*?(?:fa-skype|fa-whatsapp)[\s\S]*?)<\/aside>/i
    );
    skypeAside = m ? m[1] : "";
  }
  const skypeTitle = widgetTitle(skypeAside);
  if (skypeTitle) footer.companyTitle = skypeTitle;
  const skypeTw = textwidgetInner(skypeAside) || skypeAside;
  const skypes = parasWithIcon(skypeTw, "fa-skype");
  if (skypes[0]) footer.contactSkype1 = skypes[0];
  if (skypes[1]) footer.contactSkype2 = skypes[1];
  const was = parasWithIcon(skypeTw, "fa-whatsapp");
  if (was[0]) footer.contactWhatsapp = was[0];
  if (was[1]) footer.contactWhatsapp2 = was[1];

  // CONTACT DETAILS column
  let contactAside = asideById(region, "text-3");
  if (!contactAside || contactAside === about) {
    const m = region.match(
      /<aside\b[^>]*>([\s\S]*?(?:fa-envelope|fa-map-marker|fa-phone)[\s\S]*?)<\/aside>/i
    );
    if (m && !/fa-skype|fa-whatsapp/i.test(m[1])) contactAside = m[1];
    else if (m && /CONTACT/i.test(widgetTitle(m[1]) || "")) contactAside = m[1];
  }
  // Prefer aside whose title looks like contact
  const contactTitle = widgetTitle(contactAside);
  if (contactTitle && /contact/i.test(contactTitle)) {
    footer.contactTitle = contactTitle;
  } else if (contactTitle && !footer.contactTitle) {
    footer.contactTitle = contactTitle;
  }

  const contactTw = textwidgetInner(contactAside) || contactAside;
  const addr = parasWithIcon(contactTw, "fa-map-marker");
  if (addr[0]) footer.contactAddress = addr[0];
  const phones = parasWithIcon(contactTw, "fa-phone");
  if (phones[0]) footer.contactPhone = phones[0];
  const emails = [];
  const mailRe =
    /mailto:([^"'>\s]+)|([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,})/gi;
  let em;
  const seen = new Set();
  while ((em = mailRe.exec(contactTw))) {
    const v = String(em[1] || em[2] || "")
      .trim()
      .replace(/^mailto:/i, "");
    if (v && !seen.has(v.toLowerCase())) {
      seen.add(v.toLowerCase());
      emails.push(v);
    }
  }
  if (emails[0]) footer.contactEmail1 = emails[0];
  if (emails[1]) footer.contactEmail2 = emails[1];

  // Copyright
  const copy = region.match(
    /<div\b[^>]*\bcopyright\b[^>]*>[\s\S]*?<p\b[^>]*>([\s\S]*?)<\/p>/i
  );
  if (copy) {
    let t = stripFooterText(copy[1]);
    t = t
      .replace(/^copyright\s*/i, "")
      .replace(/^©\s*/u, "")
      .replace(/^&\s*copy;\s*/i, "")
      .trim();
    if (t) footer.copyrightText = t;
  }

  return footer;
}

/**
 * Capture logo + footer copy/contact from HTML using shared class names,
 * with WordPress/Avas footer fallback for AmzGetway-style exports.
 */
export function extractFooterFromHtml(html) {
  const raw = String(html || "");
  const convention = extractConventionFooter(raw);
  const wp = extractWpFooter(raw);
  // Convention wins when both present; WP fills gaps.
  const footer = { ...wp, ...convention };
  // Prefer WP titles/contacts when convention left them empty
  Object.keys(wp).forEach((k) => {
    if (!String(footer[k] || "").trim() && wp[k]) footer[k] = wp[k];
  });
  return footer;
}

export function extractLogoFromHtml(html) {
  const raw = String(html || "");
  const m =
    raw.match(
      /<img\b[^>]*\bsite-logo(?:-footer|-header)?\b[^>]*\bsrc=["']([^"']+)["']/i
    ) ||
    raw.match(
      /<img\b[^>]*\bsrc=["']([^"']+)["'][^>]*\bsite-logo(?:-footer|-header)?\b/i
    ) ||
    raw.match(
      /<a\b[^>]*\btx_logo\b(?![^>]*tx_sticky_logo)[^>]*>\s*<img\b[^>]*\bsrc=["']([^"']+)["']/i
    ) ||
    raw.match(
      /<img\b[^>]*\bsrc=["']([^"']*Footer\.png[^"']*)["']/i
    ) ||
    raw.match(
      /<img\b[^>]*\bsrc=["']([^"']*AMZgetway-Logo[^"']*)["']/i
    );
  return m ? normalizeSiteAssetUrl(m[1]) : "";
}

/**
 * Parse WP nav ULs into CMS menu item trees.
 * Returns { primary: items[], footer: items[] }.
 */
export function extractMenusFromHtml(html) {
  const raw = String(html || "");
  return {
    primary: parseWpMenuUl(raw, "main-menu"),
    footer: parseWpMenuUl(raw, "menu-footer-menu").length
      ? parseWpMenuUl(raw, "menu-footer-menu")
      : parseWpMenuUl(raw, "menu-footer-3"),
  };
}

function parseWpMenuUl(html, ulId) {
  const open = html.match(
    new RegExp(`<ul\\b[^>]*\\bid=["']${ulId}["'][^>]*>`, "i")
  );
  if (!open) return [];
  const start = open.index + open[0].length;
  const inner = sliceBalancedUlInner(html, start);
  return parseMenuLis(inner, null);
}

function sliceBalancedUlInner(html, start) {
  let depth = 1;
  let i = start;
  const re = /<\/?ul\b[^>]*>/gi;
  re.lastIndex = start;
  let m;
  while ((m = re.exec(html))) {
    if (/^<\/ul/i.test(m[0])) {
      depth -= 1;
      if (depth === 0) return html.slice(start, m.index);
    } else {
      depth += 1;
    }
    i = m.index + m[0].length;
  }
  return html.slice(start);
}

function parseMenuLis(inner, parentId) {
  const items = [];
  // Top-level <li> only: walk with depth tracking for nested ul
  let i = 0;
  const src = String(inner || "");
  while (i < src.length) {
    const liOpen = src.slice(i).match(/^\s*<li\b[^>]*>/i);
    if (!liOpen) {
      const next = src.slice(i).search(/<li\b/i);
      if (next < 0) break;
      i += next;
      continue;
    }
    const openEnd = i + liOpen[0].length;
    // find matching </li>
    let depth = 1;
    let j = openEnd;
    const tagRe = /<\/?li\b[^>]*>/gi;
    tagRe.lastIndex = openEnd;
    let tm;
    let liEnd = -1;
    while ((tm = tagRe.exec(src))) {
      if (/^<\/li/i.test(tm[0])) {
        depth -= 1;
        if (depth === 0) {
          liEnd = tm.index;
          break;
        }
      } else {
        depth += 1;
      }
    }
    if (liEnd < 0) break;
    const liInner = src.slice(openEnd, liEnd);
    const a = liInner.match(/<a\b[^>]*href=["']([^"']*)["'][^>]*>([\s\S]*?)<\/a>/i);
    if (a) {
      const id = `m_${items.length}_${Math.random().toString(36).slice(2, 7)}`;
      const label = stripFooterText(a[2]);
      let href = String(a[1] || "").trim() || "/";
      if (/^https?:\/\/(?:www\.)?amzgetway\.com/i.test(href)) {
        href = href.replace(/^https?:\/\/(?:www\.)?amzgetway\.com/i, "") || "/";
      }
      const childUl = liInner.match(/<ul\b[^>]*>([\s\S]*)<\/ul>\s*$/i);
      const item = {
        id,
        label,
        href,
        type: "custom",
        parentId: parentId || null,
      };
      items.push(item);
      if (childUl) {
        const kids = parseMenuLis(childUl[1], id);
        items.push(...kids);
      }
    }
    i = liEnd + 5;
  }
  return items;
}

/**
 * Site-relative asset paths must be root-absolute so nested pages
 * (/services/..., /blog/...) do not resolve to /services/assets/...
 */
export function normalizeSiteAssetUrl(url) {
  let u = String(url || "").trim();
  if (!u) return "";
  if (/^(https?:)?\/\//i.test(u) || /^data:/i.test(u) || /^blob:/i.test(u)) {
    return u;
  }
  const qIndex = u.indexOf("?");
  const query = qIndex >= 0 ? u.slice(qIndex) : "";
  let path = qIndex >= 0 ? u.slice(0, qIndex) : u;
  path = path.replace(/\\/g, "/").replace(/^\.\//, "");
  while (path.startsWith("../")) path = path.slice(3);
  if (!path.startsWith("/")) path = `/${path}`;
  return path + query;
}

/** Default placeholder titles from CMS_DEFAULTS — treat as empty for capture fill. */
const FOOTER_PLACEHOLDER = {
  servicesTitle: "Services",
  contactTitle: "Contact",
  companyTitle: "Company",
};

function isEmptyFooterVal(key, cur) {
  const v = String(cur || "").trim();
  if (!v) return true;
  if (FOOTER_PLACEHOLDER[key] && v === FOOTER_PLACEHOLDER[key]) return true;
  // Wipe leftover master-template / Townloc placeholders so WP capture can fill
  if (/townloc\.com/i.test(v)) return true;
  if (/^1234567890?$/i.test(v)) return true;
  if (/Get a Free Assessment/i.test(v)) return true;
  if (/Client Guarantee/i.test(v) && key === "guaranteeLabel") return true;
  if (/Local Google marketing/i.test(v)) return true;
  return false;
}

/** Fill only empty footer/branding keys from captured HTML values. */
export function mergeCapturedSiteChrome(doc, capturedFooter, capturedLogo) {
  const out = doc && typeof doc === "object" ? { ...doc } : {};
  let changed = false;

  const footer =
    out.footer && typeof out.footer === "object" ? { ...out.footer } : {};
  Object.keys(capturedFooter || {}).forEach((key) => {
    const next = String(capturedFooter[key] || "").trim();
    const cur = String(footer[key] || "").trim();
    if (next && isEmptyFooterVal(key, cur)) {
      footer[key] = next;
      changed = true;
    }
  });
  out.footer = footer;

  const branding =
    out.branding && typeof out.branding === "object" ? { ...out.branding } : {};
  const logo = normalizeSiteAssetUrl(capturedLogo || "");
  if (logo && !String(branding.logoUrl || "").trim()) {
    branding.logoUrl = logo;
    changed = true;
  }
  // Repair previously captured relative logo/favicon paths.
  if (branding.logoUrl) {
    const fixed = normalizeSiteAssetUrl(branding.logoUrl);
    if (fixed && fixed !== branding.logoUrl) {
      branding.logoUrl = fixed;
      changed = true;
    }
  }
  if (branding.faviconUrl) {
    const fixedFav = normalizeSiteAssetUrl(branding.faviconUrl);
    if (fixedFav && fixedFav !== branding.faviconUrl) {
      branding.faviconUrl = fixedFav;
      changed = true;
    }
  }
  // Prefer real site name from logo alt when still generic
  if (
    (!String(branding.name || "").trim() ||
      branding.name === "My Site" ||
      /townloc/i.test(branding.name)) &&
    capturedLogo
  ) {
    // leave name unless we have something better — set AmzGetway if logo path matches
    if (/AMZgetway/i.test(String(capturedLogo))) {
      branding.name = "AmzGetway";
      branding.mark = "A";
      changed = true;
    }
  }
  out.branding = branding;

  return { doc: out, changed };
}
