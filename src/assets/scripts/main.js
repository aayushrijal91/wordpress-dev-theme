// ie: Engine.ui.misc();
jQuery(function ($) {
    "use strict";
    var Engine = {
        ui: {
            misc: function () {
                AOS.init({
                    duration: 1500,
                });
                $(document).ready(function () {

                    var $nav = $(".topbar-nav"),
                        $slideLine = $("#marker"),
                        $currentItem = $(".current-menu-item");

                    $(window).load(function () {

                        // Menu has active item
                        if ($currentItem[0]) {
                            $slideLine.css({
                                "width": $currentItem.outerWidth(),
                                "left": $currentItem.position().left + 16
                            });
                        }

                        // Underline transition
                        $($nav).find("li").hover(
                            // Hover on
                            function () {
                                $slideLine.css({
                                    "width": $(this).outerWidth(),
                                    "left": $(this).position().left + 16
                                });
                            },
                            // Hover out
                            function () {
                                if ($currentItem[0]) {
                                    // Go back to current
                                    $slideLine.css({
                                        "width": $currentItem.outerWidth(),
                                        "left": $currentItem.position().left + 16
                                    });
                                } else {
                                    // Disapear
                                    $slideLine.width(0);
                                }
                            }
                        );
                    });

                    $('.megamenu').on('mouseover', function (event) {
                        $('.mega-dropdown-menu').show();
                    })
                    $('.megamenu').on('mouseout', function (event) {
                        $('.mega-dropdown-menu').hide();
                    });

                    $('li.megamenu a').append('<span class="dropdown-arrow"></span>');

                    $('.card .card-header').click(function (e) {
                        $('.active').removeClass('active');
                        //add the active class to the link we clicked
                        $(this).addClass('active');
                        //Load the content
                        //e.g.
                        //load the page that the link was pointing to
                        //$('#content').load($(this).find(a).attr('href'));      
                        event.preventDefault();
                    });

                    $('.logoicon-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: true,
                        autoplay: true,
                        slidesToShow: 8,
                        slidesToScroll: 1,
                        responsive: [{
                                breakpoint: 1500,
                                settings: {
                                    slidesToShow: 4,
                                }
                            },
                            {
                                breakpoint: 1100,
                                settings: {
                                    slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }
                        ]
                    });

                    $('.banner-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        adaptiveHeight: true,
                    });

                    $('.cta-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: false,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        responsive: [{
                                breakpoint: 1100,
                                settings: {
                                    slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                    dots: true,
                                }
                            }
                        ]
                    });

                    $('.testimonials-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: false,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        responsive: [{
                                breakpoint: 1100,
                                settings: {
                                    slidesToShow: 2,
                                    adaptiveHeight: true,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                    dots: true,
                                    adaptiveHeight: true,
                                }
                            }
                        ]
                    });

                    $('.sps-work-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: false,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        responsive: [{
                                breakpoint: 1100,
                                settings: {
                                    slidesToShow: 2,
                                    adaptiveHeight: true,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                    dots: true,
                                    adaptiveHeight: true,
                                }
                            }
                        ]
                    });

                    $('.service-icon-slider').slick({
                        arrows: false,
                        dots: false,
                        infinite: false,
                        slidesToShow: 7,
                        slidesToScroll: 1,
                        responsive: [{
                                breakpoint: 800,
                                settings: {
                                    slidesToShow: 6,
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 3,
                                }
                            }
                        ]
                    });

                    $(document).on("click", ".collapse-menu h6", function (e) {
                        $(this).parents(".collapse-menu").find(".menu-collapse-wrap").slideToggle("slow"), $(this).parents(".collapse-menu").toggleClass("menushow");
                    });

                    changePickupStoreMenu();

                    function changePickupStoreMenu() {

                        var body = $('body'),
                            mask = $('<div class="mask"></div>'),
                            toggleSlideLeft = document.querySelector(".toggle-slide-left"),
                            slideMenuLeft = document.querySelector(".slide-menu-left"),
                            activeNav = '';;
                        $('body').append(mask);

                        /* slide menu left */
                        toggleSlideLeft.addEventListener("click", function () {
                            $('body').addClass("smr-open");
                            $('.mask').fadeIn();
                            activeNav = "smr-open";
                        });

                        /* hide active menu if close menu button is clicked */
                        $(document).on('click', ".close-menu, .mask, .coupons", function (el, i) {
                            $('body').removeClass(activeNav);
                            activeNav = "";
                            $('.mask').fadeOut();
                        });

                    }

                    var $btns = $('.alphabet').click(function () {
                        if (this.id == 'all') {
                            $('.arealist > ul > li').fadeIn(450);
                        } else {
                            var $el = $('.' + this.id).fadeIn(450);
                            $('.arealist > ul > li').not($el).hide();
                        }
                        $btns.removeClass('active');
                        $(this).addClass('active');
                        if ($(".arealist > ul > li:visible").length)
                            $(".noresult").hide();
                        else
                            $(".noresult").show();
                    })
                    AOS.refresh();

                    $('.droplist > .caption').on('click', function () {
                        $(this).parent().toggleClass('open');
                    });

                    $('.droplist > .list > .item').on('click', function () {
                        $('.droplist > .list > .item').removeClass('active selected');
                        $(this).addClass('selected').parent().parent().removeClass('open').children('.caption').text($(this).text());
                    });

                });
            }, // end misc
        }, // end ui
        //utils: {

        //}, // end utils
    };
    Engine.ui.misc();
    //Engine.utils.sliders();
});

jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 1000) {
        jQuery('#back-top').fadeIn();
        jQuery("#back-top").addClass('active');
    } else {
        jQuery('#back-top').fadeOut();
        jQuery("#back-top").removeClass('active');
    }
});
jQuery('#back-top').click(function () {
    jQuery('body,html').animate({
        scrollTop: 0
    }, 1000);
    return false;
});