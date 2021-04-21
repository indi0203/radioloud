! function() {
    "use strict";
    if ("querySelector" in document && "addEventListener" in window) {
        var e = function(e, t) {
            if (e.preventDefault(), !t) t = this;
            var a = t.closest("nav");
            t.getAttribute("data-nav") && (a = document.querySelector(this.getAttribute("data-nav")));
            var s = a.querySelector(".inside-navigation .search-form"),
                c = document.querySelectorAll('a[href], area[href], input:not([disabled]):not(.search-form), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]');
            if (s.classList.contains("nav-search-active")) {
                t.classList.remove("close-search"), t.classList.remove("active"), document.activeElement.blur(), t.classList.remove("sfHover"), s.classList.remove("nav-search-active"), t.style.float = "";
                for (var i = 0; i < c.length; i++) c[i].closest(".inside-navigation .search-form") || c[i].closest(".search-item") || c[i].removeAttribute("tabindex")
            } else {
                t.classList.add("active"), s.classList.add("nav-search-active"), s.querySelector(".search-field").focus();
                for (i = 0; i < c.length; i++) c[i].closest(".inside-navigation .search-form") || c[i].closest(".search-item") || c[i].setAttribute("tabindex", "-1");
                setTimeout(function() {
                    t.classList.add("sfHover")
                }, 50), document.body.classList.contains("nav-aligned-center") ? (t.style.opacity = 0, setTimeout(function() {
                    t.classList.add("close-search"), t.style.opacity = 1, document.body.classList.contains("rtl") ? t.style.float = "left" : t.style.float = "right"
                }, 250)) : t.classList.add("close-search")
            }
        };
        if (document.body.classList.contains("nav-search-enabled")) {
            for (var t = document.querySelectorAll(".search-item"), a = 0; a < t.length; a++) t[a].addEventListener("click", e, !1);
            document.addEventListener("click", function(t) {
                if (document.querySelector(".inside-navigation .search-form.nav-search-active") && !t.target.closest(".inside-navigation .search-form") && !t.target.closest(".search-item"))
                    for (var a = document.querySelectorAll(".search-item.active"), s = 0; s < a.length; s++) e(t, a[s])
            }, !1), document.addEventListener("keydown", function(t) {
                if (document.querySelector(".inside-navigation .search-form.nav-search-active") && 27 === (t.which || t.keyCode))
                    for (var a = document.querySelectorAll(".search-item.active"), s = 0; s < a.length; s++) e(t, a[s])
            }, !1)
        }
    }
}();
