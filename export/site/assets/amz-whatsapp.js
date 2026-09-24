/**
 * AmzGetway — floating WhatsApp live support (replaces Tawk.to)
 * Arc "Live Support" text above icon; no appear animation.
 */
(function () {
  var PHONE = "8801985453254";
  var PREFILL = "Hi AmzGetway, I need help.";
  var HREF =
    "https://wa.me/" +
    PHONE +
    "?text=" +
    encodeURIComponent(PREFILL);

  function mount() {
    if (document.getElementById("amz-wa-float")) return;

    var a = document.createElement("a");
    a.id = "amz-wa-float";
    a.href = HREF;
    a.target = "_blank";
    a.rel = "noopener noreferrer";
    a.setAttribute("aria-label", "WhatsApp Live Support");
    a.title = "WhatsApp Live Support";
    a.innerHTML =
      '<svg class="amz-wa-arc" viewBox="0 0 72 72" aria-hidden="true" focusable="false">' +
      "<defs>" +
      '<path id="amz-wa-arc-path" d="M 10 42 A 26 26 0 0 1 62 42" fill="none"/>' +
      "</defs>" +
      '<text class="amz-wa-arc-text">' +
      '<textPath href="#amz-wa-arc-path" xlink:href="#amz-wa-arc-path" startOffset="50%" text-anchor="middle">Live Support</textPath>' +
      "</text>" +
      "</svg>" +
      '<span class="amz-wa-icon" aria-hidden="true">' +
      '<svg viewBox="0 0 32 32" width="28" height="28" focusable="false">' +
      '<path fill="#fff" d="M16.01 3C9.39 3 4 8.39 4 15.01c0 2.39.7 4.61 1.91 6.48L4 29l7.73-1.86A11.94 11.94 0 0 0 16.01 27C22.63 27 28 21.61 28 15.01 28 8.39 22.63 3 16.01 3zm0 21.82c-2.05 0-3.96-.56-5.6-1.53l-.4-.24-4.58 1.1 1.12-4.46-.26-.42A9.7 9.7 0 0 1 6.2 15c0-5.41 4.4-9.81 9.81-9.81s9.81 4.4 9.81 9.81-4.4 9.82-9.81 9.82zm5.39-7.35c-.29-.15-1.73-.85-2-.95-.27-.1-.46-.15-.66.15-.2.29-.76.95-.93 1.15-.17.2-.34.22-.63.07-.29-.15-1.22-.45-2.32-1.43-.86-.77-1.44-1.71-1.61-2-.17-.29-.02-.45.13-.6.13-.13.29-.34.43-.51.15-.17.2-.29.29-.49.1-.2.05-.37-.02-.52-.07-.15-.66-1.59-.9-2.18-.24-.58-.48-.5-.66-.51h-.56c-.2 0-.52.07-.79.37-.27.29-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.73-.71 1.97-1.39.24-.68.24-1.27.17-1.39-.07-.12-.26-.2-.55-.34z"/>' +
      "</svg></span>";

    document.body.appendChild(a);
  }

  // Mount ASAP so it does not pop in after paint
  if (document.body) mount();
  else document.addEventListener("DOMContentLoaded", mount);
})();
