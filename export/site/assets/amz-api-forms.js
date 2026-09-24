/**
 * CF7 → POST /api/contact
 * Modern success/error dialog. Blocks fake emails.
 */
(function () {
  var STYLE_ID = "amz-form-dialog-css";
  var DIALOG_ID = "amz-form-dialog";

  var FAKE_LOCAL = {
    test: 1,
    testing: 1,
    fake: 1,
    asdf: 1,
    asdfg: 1,
    qwerty: 1,
    abc: 1,
    abcd: 1,
    admin: 1,
    user: 1,
    username: 1,
    email: 1,
    mail: 1,
    none: 1,
    null: 1,
    undefined: 1,
    example: 1,
    sample: 1,
    demo: 1,
    xxx: 1,
    aaa: 1,
    bbb: 1,
    noemail: 1,
    notreal: 1,
  };

  var FAKE_DOMAINS = {
    "test.com": 1,
    "testing.com": 1,
    "fake.com": 1,
    "email.com": 1,
    "mail.com": 1,
    "example.com": 1,
    "example.org": 1,
    "example.net": 1,
    "domain.com": 1,
    "asdf.com": 1,
    "abc.com": 1,
    "xxx.com": 1,
    "mailinator.com": 1,
    "guerrillamail.com": 1,
    "tempmail.com": 1,
    "temp-mail.org": 1,
    "10minutemail.com": 1,
    "yopmail.com": 1,
    "trashmail.com": 1,
    "sharklasers.com": 1,
    "guerrillamailblock.com": 1,
    "throwawaymail.com": 1,
    "getnada.com": 1,
    "jmailservice.com": 1,
    "mailservice.com": 1,
    "fakemail.com": 1,
    "temp-mail.io": 1,
    "dispostable.com": 1,
    "mailnesia.com": 1,
    "maildrop.cc": 1,
    "moakt.com": 1,
    "emailondeck.com": 1,
    "fakeinbox.com": 1,
  };

  function ensureStyles() {
    if (document.getElementById(STYLE_ID)) return;
    var css = document.createElement("style");
    css.id = STYLE_ID;
    css.textContent =
      "#amz-form-dialog{position:fixed;inset:0;z-index:100000;display:flex;align-items:center;justify-content:center;padding:20px;box-sizing:border-box;opacity:0;visibility:hidden;pointer-events:none;transition:opacity .22s ease,visibility .22s ease}" +
      "#amz-form-dialog.is-open{opacity:1;visibility:visible;pointer-events:auto}" +
      "#amz-form-dialog .amz-fd-bg{position:absolute;inset:0;background:rgba(12,18,36,.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px)}" +
      "#amz-form-dialog .amz-fd-card{position:relative;width:min(400px,100%);background:#fff;border-radius:16px;box-shadow:0 24px 64px rgba(0,0,0,.28);padding:28px 24px 22px;text-align:center;font-family:Josefin Sans,Rajdhani,sans-serif;transform:translateY(12px) scale(.97);transition:transform .22s ease}" +
      "#amz-form-dialog.is-open .amz-fd-card{transform:none}" +
      "#amz-form-dialog .amz-fd-icon{width:56px;height:56px;margin:0 auto 14px;border-radius:50%;display:flex;align-items:center;justify-content:center}" +
      "#amz-form-dialog.is-ok .amz-fd-icon{background:#e8f7ee}" +
      "#amz-form-dialog.is-err .amz-fd-icon{background:#fdecea}" +
      "#amz-form-dialog.is-wait .amz-fd-icon{background:#fff4e8}" +
      "#amz-form-dialog .amz-fd-icon svg{width:28px;height:28px;display:block}" +
      "#amz-form-dialog.is-ok .amz-fd-icon svg{stroke:#1b8a4a}" +
      "#amz-form-dialog.is-err .amz-fd-icon svg{stroke:#c62828}" +
      "#amz-form-dialog.is-wait .amz-fd-icon svg{stroke:#F28B15}" +
      "#amz-form-dialog .amz-fd-title{margin:0 0 8px;font-size:20px;font-weight:700;color:#1a1a1a;line-height:1.25}" +
      "#amz-form-dialog .amz-fd-text{margin:0 0 20px;font-size:15px;font-weight:500;color:#556;line-height:1.5}" +
      "#amz-form-dialog .amz-fd-btn{appearance:none;border:0;cursor:pointer;background:#F28B15;color:#fff;font:inherit;font-size:14px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;padding:12px 28px;border-radius:8px;transition:background .15s ease,transform .15s ease}" +
      "#amz-form-dialog .amz-fd-btn:hover{background:#d9780f}" +
      "#amz-form-dialog .amz-fd-btn:active{transform:scale(.98)}" +
      "#amz-form-dialog .amz-fd-close{position:absolute;top:10px;right:12px;width:32px;height:32px;border:0;background:transparent;color:#889;font-size:22px;line-height:1;cursor:pointer;border-radius:8px}" +
      "#amz-form-dialog .amz-fd-close:hover{background:#f2f2f2;color:#333}" +
      "#amz-form-dialog.is-wait .amz-fd-btn{display:none}" +
      "@keyframes amz-fd-spin{to{transform:rotate(360deg)}}" +
      "#amz-form-dialog.is-wait .amz-fd-icon svg{animation:amz-fd-spin .8s linear infinite}";
    document.head.appendChild(css);
  }

  function icons(kind) {
    if (kind === "ok") {
      return '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>';
    }
    if (kind === "wait") {
      return '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M12 3v3M12 18v3M4.9 4.9l2.1 2.1M17 17l2.1 2.1M3 12h3M18 12h3M4.9 19.1l2.1-2.1M17 7l2.1-2.1"/></svg>';
    }
    return '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>';
  }

  function ensureDialog() {
    ensureStyles();
    var root = document.getElementById(DIALOG_ID);
    if (root) return root;
    root = document.createElement("div");
    root.id = DIALOG_ID;
    root.setAttribute("aria-hidden", "true");
    root.innerHTML =
      '<div class="amz-fd-bg" data-amz-fd-close="1"></div>' +
      '<div class="amz-fd-card" role="dialog" aria-modal="true" aria-labelledby="amz-fd-title" aria-describedby="amz-fd-text">' +
      '<button type="button" class="amz-fd-close" data-amz-fd-close="1" aria-label="Close">&times;</button>' +
      '<div class="amz-fd-icon"></div>' +
      '<h3 class="amz-fd-title" id="amz-fd-title"></h3>' +
      '<p class="amz-fd-text" id="amz-fd-text"></p>' +
      '<button type="button" class="amz-fd-btn" data-amz-fd-close="1">OK</button>' +
      "</div>";
    document.body.appendChild(root);

    root.addEventListener("click", function (e) {
      var t = e.target;
      if (t && t.getAttribute && t.getAttribute("data-amz-fd-close")) closeDialog();
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && root.classList.contains("is-open")) closeDialog();
    });
    return root;
  }

  function closeDialog() {
    var root = document.getElementById(DIALOG_ID);
    if (!root) return;
    root.classList.remove("is-open", "is-ok", "is-err", "is-wait");
    root.setAttribute("aria-hidden", "true");
  }

  function showDialog(opts) {
    var kind = opts.kind || "ok";
    var root = ensureDialog();
    root.className = "is-open is-" + kind;
    root.setAttribute("aria-hidden", "false");
    root.querySelector(".amz-fd-icon").innerHTML = icons(kind);
    root.querySelector(".amz-fd-title").textContent = opts.title || "";
    root.querySelector(".amz-fd-text").textContent = opts.text || "";
    var btn = root.querySelector(".amz-fd-btn");
    if (btn) btn.textContent = opts.btn || "OK";
    if (kind !== "wait") {
      setTimeout(function () {
        try {
          btn.focus();
        } catch (_) {}
      }, 50);
    }
  }

  function hideCf7Output(form) {
    var out = form.querySelector(".wpcf7-response-output");
    if (!out) return;
    out.textContent = "";
    out.setAttribute("aria-hidden", "true");
    out.style.cssText =
      "display:none!important;border:0!important;margin:0!important;padding:0!important;height:0!important;overflow:hidden!important;";
  }

  function clearOldInline(form) {
    var old = form.querySelectorAll(".amz-form-msg");
    for (var i = 0; i < old.length; i++) old[i].remove();
  }

  function val(form, names) {
    for (var i = 0; i < names.length; i++) {
      var el = form.querySelector('[name="' + names[i] + '"]');
      if (el && String(el.value || "").trim()) return String(el.value).trim();
    }
    return "";
  }

  function isValidRealEmail(email) {
    email = String(email || "").trim().toLowerCase();
    if (!email) return false;
    if (email.length > 180) return false;
    if (!/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/i.test(email)) return false;
    if (email.indexOf("..") !== -1) return false;
    if (email.indexOf(".@") !== -1 || email.indexOf("@.") !== -1) return false;

    var parts = email.split("@");
    if (parts.length !== 2) return false;
    var local = parts[0];
    var domain = parts[1];

    if (!local || local.length < 2) return false;
    if (!domain || domain.indexOf(".") === -1) return false;
    if (local.charAt(0) === "." || local.charAt(local.length - 1) === ".") return false;

    var localBase = local.split("+")[0].replace(/[0-9._\-]/g, "");
    if (FAKE_LOCAL[local] || FAKE_LOCAL[localBase]) return false;
    if (/^(test|fake|asdf|qwer|abc|xxx|aaa|user|mail|email)\d*$/i.test(local)) return false;
    if (/^(.)\1{3,}$/.test(local)) return false;

    if (FAKE_DOMAINS[domain]) return false;
    // Disposable / fake-looking domain patterns (e.g. jmailservice.com)
    if (
      /mailservice|tempmail|trashmail|throwaway|guerrillamail|fakeinbox|mailnesia|disposable|temp-mail|fakemail|yopmail|getnada|maildrop|moakt|emailondeck|sharklasers/i.test(
        domain
      )
    ) {
      return false;
    }
    var domRoot = domain.replace(/\.(com|net|org|info|xyz|co|io)$/i, "");
    if (/^(test|fake|asdf|example|temp|mail|email|xxx|abc|jmail)$/i.test(domRoot)) return false;

    var domainLabel = domain.split(".")[0];
    if (local === domainLabel) return false;
    if (localBase && localBase === domainLabel) return false;

    var tld = domain.split(".").pop();
    if (!tld || tld.length < 2) return false;

    return true;
  }

  function phoneDigits(phone) {
    return String(phone || "").replace(/\D/g, "");
  }

  function isValidRealPhone(phone) {
    var digits = phoneDigits(phone);
    if (digits.length < 10 || digits.length > 15) return false;
    if (/^(\d)\1{9,}$/.test(digits)) return false; // 0000000000, 1111111111…
    if (/^0{10,}$/.test(digits)) return false;
    return true;
  }

  function formHasPhoneField(form) {
    return !!form.querySelector(
      '[name="PhoneNumber"],[name="phone"],[name="Phone"],[name="your-phone"],[name="tel"],[name="telephone"],[type="tel"]'
    );
  }

  function isSubscribe(form) {
    var submit = form.querySelector('input[type="submit"], button[type="submit"]');
    var label = ((submit && submit.value) || "").toUpperCase();
    return label.indexOf("SUBSCRIBE") !== -1;
  }

  function buildPayload(form) {
    var email = val(form, ["your-email", "Email", "email"]);
    var name = val(form, ["Name", "your-name", "clientName", "name"]);
    if (!name) {
      var first = val(form, ["FirstName", "first-name", "first_name"]);
      var last = val(form, ["LastName", "last-name", "last_name"]);
      name = [first, last].filter(Boolean).join(" ").trim();
    }
    var phone = val(form, [
      "PhoneNumber",
      "phone",
      "Phone",
      "your-phone",
      "tel",
      "telephone",
    ]);
    var listing = val(form, ["ListingLink", "mapsLink", "listing", "url"]);
    var message = val(form, ["Massage", "message", "Message", "your-message"]);
    var service = val(form, ["service", "Service"]);

    if (isSubscribe(form)) {
      return {
        clientName: name || (email ? email.split("@")[0] : "Subscriber"),
        email: email,
        phone: phone || "",
        businessName: "Newsletter",
        service: "Newsletter Subscribe",
        message: message || "Newsletter subscribe from site footer/form.",
        mapsLink: "",
        website2: val(form, ["website2"]),
        _kind: "subscribe",
        _requirePhone: false,
      };
    }

    return {
      clientName: name || (email ? email.split("@")[0] : "Website lead"),
      email: email,
      phone: phone || "",
      businessName: listing || name || "AmzGetway inquiry",
      service: service || "Amazon / Walmart Services",
      message: message || "",
      mapsLink: listing && /^https?:\/\//i.test(listing) ? listing : "",
      website2: val(form, ["website2"]),
      _kind: "contact",
      _requirePhone: formHasPhoneField(form),
    };
  }

  async function onSubmit(e) {
    var form = e.target;
    if (!form || !form.classList || !form.classList.contains("wpcf7-form")) return;
    e.preventDefault();
    e.stopPropagation();

    hideCf7Output(form);
    clearOldInline(form);

    var payload = buildPayload(form);
    var kind = payload._kind;
    var requirePhone = !!payload._requirePhone;
    delete payload._kind;
    delete payload._requirePhone;

    if (!isValidRealEmail(payload.email)) {
      showDialog({
        kind: "err",
        title: "Invalid email",
        text: "Please enter a real email address.",
        btn: "Try again",
      });
      var emailEl = form.querySelector('[name="your-email"],[name="Email"],[name="email"]');
      if (emailEl) emailEl.focus();
      return;
    }

    if (requirePhone && !isValidRealPhone(payload.phone)) {
      showDialog({
        kind: "err",
        title: "Phone required",
        text: "Please enter a valid phone number (at least 10 digits).",
        btn: "Try again",
      });
      var phoneEl = form.querySelector(
        '[name="PhoneNumber"],[name="phone"],[name="Phone"],[name="your-phone"],[name="tel"],[type="tel"]'
      );
      if (phoneEl) phoneEl.focus();
      return;
    }

    if (payload.phone && !isValidRealPhone(payload.phone)) {
      showDialog({
        kind: "err",
        title: "Invalid phone",
        text: "Please enter a valid phone number.",
        btn: "Try again",
      });
      return;
    }

    var submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    showDialog({
      kind: "wait",
      title: "Sending…",
      text: "Please wait a moment.",
    });

    try {
      var res = await fetch("/api/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify(payload),
      });
      var data = {};
      try {
        data = await res.json();
      } catch (_) {}

      if (!res.ok || data.success === false) {
        showDialog({
          kind: "err",
          title: "Couldn’t send",
          text: (data && data.message) || "Please try again in a moment.",
          btn: "Try again",
        });
        return;
      }

      showDialog({
        kind: "ok",
        title: kind === "subscribe" ? "You're subscribed!" : "Message sent!",
        text:
          kind === "subscribe"
            ? "Thanks — we'll keep you updated."
            : "Thank you — we received your message and will get back to you soon.",
        btn: "Done",
      });
      form.reset();
    } catch (err) {
      showDialog({
        kind: "err",
        title: "Network error",
        text: "Please check your connection and try again.",
        btn: "Try again",
      });
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  }

  document.addEventListener(
    "submit",
    function (e) {
      if (e.target && e.target.classList && e.target.classList.contains("wpcf7-form")) {
        onSubmit(e);
      }
    },
    true
  );
})();
