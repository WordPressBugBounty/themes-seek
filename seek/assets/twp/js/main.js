(function (e) {
    "use strict";
    var n = window.TWP_JS || {};
    n.navigation = function () {
        //added arrow
        e("ul#primary-menu>li,div#primary-menu>ul>li").has("ul").addClass("down-arrow");
        e("ul#primary-menu>li>ul li,div#primary-menu>ul>li>ul li").has("ul").addClass("right-arrow");
        e("#search,#search-close").on("click", function () {
            e("#search-field").slideToggle();
            e("#nav-latest-news-field").slideUp();
        });
        e("#nav-latest-news,#latest-news-close").on("click", function () {
            e("#nav-latest-news-field").slideToggle();
            e("#search-field").slideUp();
        });
    },
    n.stickyHeader = function () {
        var header = document.getElementById("site-navigation");
        var stickyNav = document.getElementById("sticky-nav-menu");
        var scrollTop = document.getElementById("scroll-top");
        var sticky = stickyNav.offsetTop;
        if (window.pageYOffset > sticky) {
            scrollTop.classList.add("show");
        } else {
            scrollTop.classList.remove("show");
        }
        if (e("body").hasClass("sticky-header")) {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    },
    n.mobileMenu = function () {
        e("#twp-menu-icon").on("click", function () {
            e(".twp-mobile-menu").addClass("show");
            e("#primary-nav-menu,#primary-menu").clone().appendTo(".twp-mobile-menu");
            e("#overlay").toggleClass("show");
            e("body").css("overflow", "hidden");
        });
        e("#twp-mobile-close,#overlay").on("click", function () {
            e(".twp-mobile-menu").removeClass("show");
            e(".twp-mobile-menu #primary-nav-menu,.twp-mobile-menu #primary-menu").remove();
            e("#overlay").toggleClass("show");
            e("body").css("overflow", "visible");
        });
    },
        //progress bar and newsletter
    n.progressBar = function () {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        var progressBarId = document.getElementById("progressbar");
        if (scrolled >= 50) {
            e("#newsletter").addClass("show");
        } else {
            e("#newsletter").removeClass("show");
        }
        if (progressBarId == null) {
        } else {
            progressBarId.style.width = scrolled + "%";
        }
    },
    n.newsletter_close = function () {
        e("#newsletter-close").on("click", function () {
            e("#newsletter").removeClass("twp-newsletter-active");
        });
    },
    // SCROLL UP //
    n.scroll_up = function () {
        e("#scroll-top").on("click", function () {
            e("html, body").animate({
                scrollTop: 0
            }, 700);
            return false;
        });
    },
    // tab widget
    n.tab_posts = function () {
        e(".twp-tab li").on("click", function () {
            var tabClass = e(this).attr("class");
            e(this).addClass("active").siblings().removeClass("active");
            e(this).closest(".section-head").next(".twp-tab-content").children("#" + tabClass).addClass("active").siblings().removeClass("active");
        });
    },
    n.DataBackground = function () {
        var pageSection = e(".data-bg");
        pageSection.each(function (indx) {
            if (e(this).attr("data-background")) {
                e(this).css("background-image", "url(" + e(this).data("background") + ")");
            }
        });
        e(".bg-image").each(function () {
            var src = e(this).children("img").attr("src");
            e(this).css("background-image", "url(" + src + ")").children("img").hide();
        });
    },
    n.slider = function () {
        var rtled = false;
        if (e('body').hasClass('rtl')) {
            rtled = true;
        }
        e(".twp-ticket-pin-slider").each(function () {
            e(this).slick({
                speed: 3000,
                autoplay: true,
                autoplaySpeed: 0,
                cssEase: "linear",
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                swipeToSlide: true,
                centerMode: true,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        });
        e(".twp-banner-slider").each(function () {
            e(this).slick({
                autoplay: true,
                infinite: true,
                speed: 300,
                arrow: false,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
        e("figure.wp-block-gallery.has-nested-images.columns-1, .wp-block-gallery.columns-1 ul.blocks-gallery-grid, .gallery-columns-1").each(function () {
            e(this).slick({
                autoplay: true,
                infinite: true,
                speed: 300,
                arrow: false,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: rtled
            });
        });
        e(".twp-featured-post-slider").each(function () {
            e(this).slick({
                cssEase: "linear",
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: false,
                infinite: true,
                arrow: false,
                dots: false,
                centerMode: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 2,
                            centerMode: false,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            centerMode: false,
                        }
                    }
                ]
            });
        });
    },
    n.galleryMagnificPopUp = function () {
        e(".wp-block-gallery,.gallery").each(function () {
            e(this).magnificPopup({
                delegate: "a",
                type: "image",
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: "mfp-with-zoom mfp-img-mobile",
                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return item.el.attr("title");
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) {
                        return element.find("img");
                    }
                }
            });
        });
    },
    n.twp_sticky_sidebar = function () {
        e(".widget-area").theiaStickySidebar({
            additionalMarginTop: 30
        });
    },
    e(window).on("load", function () {
        e("#status").fadeOut();
        e("#preloader").delay(350).fadeOut("slow");
        e("body").delay(350).css({"overflow": "visible"});
    });
    e(document).ready(function () {
        n.DataBackground(),
            n.navigation(),
            n.mobileMenu(),
            n.slider(),
            n.tab_posts(),
            n.scroll_up(),
            n.newsletter_close(),
            n.twp_sticky_sidebar(),
            n.galleryMagnificPopUp();
    });
    e(window).scroll(function () {
        n.stickyHeader(),
            n.progressBar();
    });
})(jQuery);