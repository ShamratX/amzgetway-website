/**
 * Bridge existing Contact Form 7 markup → backend POST /api/contact.
 * Does not remove CF7 markup; intercepts submit and maps fields.
 */
(function () {
  function val(form, names) {
    for (var i = 0; i < names.length; i++) {
      var el = form.querySelector('[name="' + names[i] + '"]');
      if (el && String(el.value || "").trim()) return String(el.value).trim();
    }
    return "";
  }

  function setStatus(form, text, ok) {
    var out = form.querySelector(".wpcf7-response-output");
    if (!out) return;
    out.textContent = text;
    out.setAttribute("aria-hidden", "false");
    out.classList.toggle("wpcf7-mail-sent-ok", !!ok);
    out.classList.toggle("wpcf7-validation-errors", !ok);
    out.style.display = "block";
  }

  function isSubscribe(form) {
    var submit = form.querySelector('input[type="submit"], button[type="submit"]');
    var label = ((submit && submit.value) || "").toUpperCase();
    return label.indexOf("SUBSCRIBE") !== -1;
  }

  function buildPayload(form) {
    var email = val(form, ["your-email", "Email", "email"]);
    var name = val(form, ["Name", "your-name", "clientName", "name"]);
    var phone = val(form, ["phone", "Phone", "your-phone", "tel"]);
    var listing = val(form, ["ListingLink", "mapsLink", "listing", "url"]);
    var message = val(form, ["Massage", "message", "Message", "your-message"]);
    var service = val(form, ["service", "Service"]);

    if (isSubscribe(form)) {
      return {
        clientName: name || (email ? email.split("@")[0] : "Subscriber"),
        email: email,
        phone: phone || "0000000000",
        businessName: "Newsletter",
        service: "Newsletter Subscribe",
        message: message || "Newsletter subscribe from site footer/form.",
        mapsLink: "",
        website2: val(form, ["website2"]),
      };
    }

    return {
      clientName: name || (email ? email.split("@")[0] : "Website lead"),
      email: email,
      phone: phone || "0000000000",
      businessName: listing || name || "AmzGetway inquiry",
      service: service || "Amazon / Walmart Services",
      message: message || "",
      mapsLink: listing && /^https?:\/\//i.test(listing) ? listing : "",
      website2: val(form, ["website2"]),
    };
  }

  async function onSubmit(e) {
    var form = e.target;
    if (!form || !form.classList || !form.classList.contains("wpcf7-form")) return;
    e.preventDefault();
    e.stopPropagation();

    var payload = buildPayload(form);
    if (!payload.email) {
      setStatus(form, "Please enter a valid email address.", false);
      return;
    }

    setStatus(form, "Sending…", true);
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
        setStatus(form, (data && data.message) || "Could not send. Please try again.", false);
        return;
      }
      setStatus(form, (data && data.message) || "Thank you — we received your message.", true);
      form.reset();
    } catch (err) {
      setStatus(form, "Network error. Please try again.", false);
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
