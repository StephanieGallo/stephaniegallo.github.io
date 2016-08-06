"use strict";
var contactForm, headerHeight, init, openMobileMenu;
openMobileMenu = function() {
    return $(".open-mobile-menu").on("click", function(e) {
        return e.stopPropagation(), $(".nav").hasClass("menu-opened") ? $(".nav").removeClass("menu-opened") : ($(".nav").addClass("menu-opened"), $(document).one("click", function() {
            return $(".nav").removeClass("menu-opened")
        }))
    })
}, $.fn.smoothMenu = function() {
    var e, n, s;
    return n = this, this.on("click", function(e) {
        var n;
        return e.preventDefault(), n = $(this.getAttribute("href")), n.length ? $("body, html").animate({
            scrollTop: n.offset().top
        }, 1e3) : void 0
    }), e = $(".section, .sub-section, .header, .container"), (s = function() {
        var t, o, i, a;
        for (t = 0, o = e.length; o > t; t++) a = e[t], window.scrollY > a.offsetTop - 100 && window.scrollY < a.offsetTop + a.clientHeight && (i = n.filter(".nav [href='#" + a.id + "']"), i.hasClass("active") || i.addClass("active").parent().siblings().find("a").removeClass("active"));
        return requestAnimationFrame(s)
    })()
}, contactForm = function() {
    return $(".contacts").on("submit", function(e) {
        return e.preventDefault(), $.ajax({
            type: "post",
            url: "sendmail.php",
            data: $(this).serializeArray(),
            success: function(e) {
                return function() {
                    return $(e).find(".alerts-wrap").append('<div class="alert alert-success alert-dismissible"> <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button> <p>Message sent successfully</p> </div>')
                }
            }(this)
        })
    })
}, headerHeight = function() {
    var e;
    return e = $(".top-bar").height(), $(".header-section").css({
        paddingTop: $(".top-bar").height()
    }), window.scrollY > e ? $(".top-bar").addClass("waypoint") : $(".top-bar").removeClass("waypoint"), requestAnimationFrame(headerHeight)
}, init = function() {
    $(".site-wrapper").addClass("in"), openMobileMenu(), headerHeight(), $("[data-countdown]").each(function() {
        return $(this).countdown($(this).data("countdown"), function(e) {
            return $(this).html(e.strftime("<div><span>%D</span><span>days</span></div><div><span>%H</span><span>hours</span></div><div><span>%M</span><span>min</span></div> <div><span>%S</span><span>sec</span></div>"))
        })
    }), $(".smooth-scrolling").smoothMenu(), $(".slider").slick({
        arrows: !1,
        dots: !0,
        slidesToShow: 1,
        adaptiveHeight: !0
    }), $(".slider-gallery").slick({
        arrows: !1,
        dots: !0,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    }), $(".testimonials-slider").slick({
        arrows: !1,
        dots: !0,
        slidesToShow: 1
    }), $.isFunction($.mmenu) && $(".canvas-off-nav").mmenu({
        canvasOff: !1
    }), new WOW({
        mobile: !1
    }).init(), window.sr = new scrollReveal({
        easing: "hustle",
        mobile: !0
    })
}, $(window).on("load", function() {
    return setTimeout(init, 1e3), $(".loader").addClass("up"), $("body").removeClass("no-scroll")
});
