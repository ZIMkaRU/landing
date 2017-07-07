/**
 * Created by voronkov_vs on 12.03.2016.
 */
"use strict";

// Libs, plugins
import 'bootstrap.min'
import 'jquery.animateNumber.min'
import 'jquery.onscreen.min'
import 'jquery-migrate-1.2.1.min'
import 'slick.min'
import 'jquery-mousewheel'
import 'malihu-custom-scrollbar-plugin'

// Styles
import './styles/bootstrap.css'
import './styles/font-awesome.min.css'
import './styles/slick.css'
import './styles/slick-theme.css'
import 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'
import './styles/app.css'// init

// Modules

// Templates


//start - Анимация чисел
var AnimNumbers = {
    runState: false,
    init: function (container) {
        if (!this.runState) {
            this.runState = true;
            container.find(".number_js").each(function () {
                var $this = $(this);
                //Запуск плагина анимации чисел
                $this.animateNumber(
                    {
                        number: Number($this.text()),//Числа которые будем анимировать, считываем их из html

                        // optional custom step function
                        // using here to keep '%' sign after number
                        numberStep: function (now, tween) {
                            var floored_number = Math.floor(now),
                                target = $(tween.elem);

                            target.text(floored_number + '');
                        }
                    },
                    3000
                );
            });
        }
    }
};
//end - Анимация чисел

function getCoords(elem) { // кроме IE8-
    var box = elem.getBoundingClientRect();

    return {
        top: box.top + pageYOffset,
        left: box.left + pageXOffset
    };
}

$(window).on("load", function () {
    var container = $('.numbers_js'),
    //Узнаем отступ от верха целевого контейнера
        heightContStart = Number(container.find(".numbers-item_js").css("height").slice(0, -2)) +
            Number(container.find(".wrap-numbers-item_js").css("padding-top").slice(0, -2));

    $("body").mCustomScrollbar({
        theme: "dark-2",
        documentTouchScroll: true,
        autoExpandScrollbar: true,
        autoHideScrollbar: true,
        //mouseWheel: { enable: true },
        //scrollInertia: 0,
        scrollButtons: {
            enable: true
        },
        callbacks: {
            whileScrolling: function () {
                //Инициализация плагина срабатывания анимации при скроллинге на целевой контецнер
                if((getCoords(document.querySelector('.numbers_js')).top + heightContStart) <= document.documentElement.clientHeight) {
                    AnimNumbers.init(container);
                }
            }
        }
    });
});

// Document ready
$(function () {
    //start - Scrolling
    $('html')
        .on('click', ".proposition-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.proposition');
        })
        .on('click', ".features-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.features');
        })
        .on('click', ".numbers-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.numbers');
        })
        .on('click', ".gallery-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.gallery');
        })
        .on('click', ".contacts-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.contacts');
        })
        .on('click', ".feedback-btn", function (e) {
            e.preventDefault();
            $(this).find('body').mCustomScrollbar('scrollTo', '.feedback-bottom');
        });
    //end - Scrolling

    //start - validation
    $('.js_validate input[type="submit"]').on("click", function () {
        return validate($(this).parents(".js_validate"));
    });
    //end - validation

    //start - slider
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.slider-nav',
        adaptiveHeight: true
    });
    $('.slider-nav').slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '.slider-for',
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '0px',
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 5
            }

        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 3
            }

        }]
    });
    //end - slider

    //start - portfolio
    $(".portfolio").on("mouseenter", ".portfolio-item_js", function () {
        var $this = $(this);
        $this.off("endSlideLabelAnim");
        $this.find(".label-portfolio").addClass("slideLabelAnim");
        setTimeout(function () {
            $this.find(".label-portfolio").removeClass("slideLabelAnim");
            $this.trigger("endSlideLabelAnim");
        }, $(".slideLabelAnim").css("animation-duration").slice(0, -1) * 1000);
    }).on("mouseleave", ".portfolio-item_js", function () {
        var $thisTop = $(this);
        $thisTop.on("endSlideLabelAnim", function () {
            var $this = $(this);
            $this.off("endSlideLabelAnim");
            $this.find(".label-portfolio").addClass("slideLabelOutAnim");
            setTimeout(function () {
                $this.find(".label-portfolio").removeClass("slideLabelOutAnim");
            }, $(".slideLabelOutAnim").css("animation-duration").slice(0, -1) * 1000);
        });
    });
    //end - portfolio

});

/*================================start-validation==========================*/
function validate(form) {
    var error_class = "has-error";
    var norma_class = "has-success";
    var item = form.find("[required], .validation-val");
    var e = 0;
    var reg = undefined;
    var pass = form.find('.password').val();
    var pass_1 = form.find('.password_1').val();

    function mark(object, expression) {
        if (expression) {
            object.parent('div').addClass(error_class).removeClass(norma_class).find('.error_text').show();
            object.attr("placeholder", object.parent('div').find('.error_text').text());
            e++;
        } else
            object.parent('div').addClass(norma_class).removeClass(error_class).find('.error_text').hide();
    }

    item.each(function () {
        switch ($(this).attr("data-validate")) {
            case undefined:
                mark($(this), $.trim($(this).val()).length === 0);
                break;
            case "email":
                reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                mark($(this), !reg.test($.trim($(this).val())));
                break;
            case "phone":
                reg = /[0-9 -()+]{10}$/;
                mark($(this), !reg.test($.trim($(this).val())));
                break;
            case "phone_null":
                reg = /[0-9 -()+]{10}$/;
                mark($(this), ($(this).val() == "") ? false : !reg.test($.trim($(this).val())));
                break;
            default:
                reg = new RegExp($(this).attr("data-validate"), "g");
                mark($(this), !reg.test($.trim($(this).val())));
                break;
            case "pass":
                reg = /^[a-zA-Z0-9_-]+$/;
                mark($(this), !reg.test($.trim($(this).val())));
                break;
            case "pass1":
                mark($(this), pass_1 != pass);
                break
        }
    });
    $('.js_valid_radio').each(function () {
        var inp = $(this).find('[type="radio"]');
        var rezalt = 0;
        for (var i = 0; i < inp.length; i++) {

            if ($(inp[i]).is(':checked') === true) {
                rezalt = 1;
                break;
            } else {
                rezalt = 0;
            }
        }

        if (rezalt === 0) {
            $(this).addClass(error_class).removeClass(norma_class).find('.error_text').css('display', 'block');
            e = 1;
        } else {
            $(this).addClass(norma_class).removeClass(error_class).find('.error_text').css('display', 'none');
        }
    });
    if (e == 0) {
        return true;
    }
    else {
        form.find("." + error_class + " input:first").focus();
        return false;
    }
}
/*================================end-validation==========================*/