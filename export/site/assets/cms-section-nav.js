/**
 * Optional: scroll to section when menus use data-cms-section="..."
 * Include after your main site script, e.g.:
 *   <script src="/assets/cms-section-nav.js" defer></script>
 */
(function () {
  function scrollToId(id) {
    if (!id) return;
    var el = document.getElementById(id);
    if (el && typeof el.scrollIntoView === "function") {
      el.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  }

  document.addEventListener(
    "click",
    function (e) {
      var a = e.target && e.target.closest ? e.target.closest("a[data-cms-section]") : null;
      if (!a) return;
      var section = a.getAttribute("data-cms-section");
      if (!section) return;
      var href = a.getAttribute("href") || "/";
      var here = location.pathname.replace(/\/$/, "") || "/";
      var targetPath = href.split("?")[0].replace(/\/$/, "") || "/";
      if (targetPath === here || targetPath === "/" && here === "") {
        e.preventDefault();
        scrollToId(section);
        if (history && history.replaceState) {
          history.replaceState(null, "", href.includes("#") ? href : href + "#" + section);
        }
      }
    },
    false
  );

  function onLoad() {
    var hash = (location.hash || "").replace(/^#/, "");
    if (hash) scrollToId(decodeURIComponent(hash));
  }
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", onLoad);
  } else {
    onLoad();
  }
})();
