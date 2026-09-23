(function($) {'use strict';
$.fn.topProgressBar = function(options) {
    var opts = $.extend({}, {
    }, options);
    var bar = getTopProgressBar(opts);
    $(bar).prependTo(document.body);
    $(window).on("scroll", function() {
        var p = getScrollPercent();
        $(bar).css("width", p);
    });
}
function getTopProgressBar(opts) {
    var bar = document.createElement("div")
    bar.className = "tx-scroll-progress-bar";
    return bar;
}
function getScrollPercent() {
    var h = document.documentElement,
        b = document.body,
        st = 'scrollTop',
        sh = 'scrollHeight';
    return parseInt((h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100) + "%";
}

})(jQuery);