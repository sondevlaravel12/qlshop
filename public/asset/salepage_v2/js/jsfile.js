//Cấm chuột phải
//var message = "";
//
//function clickIE() {
//    if (document.all) {
//        (message);
//        return false;
//    }
//}
//
//function clickNS(e) {
//    if (document.layers || (document.getElementById && !document.all)) {
//        if (e.which == 2 || e.which == 3) {
//            (message);
//            return false;
//        }
//    }
//}
//if (document.layers) {
//    document.captureEvents(Event.MOUSEDOWN);
//    document.onmousedown = clickNS;
//} else {
//    document.onmouseup = clickNS;
//    document.oncontextmenu = clickIE;
//    document.onselectstart = clickIE
//}
//document.oncontextmenu = new Function("return false")

//Copy từ trang chính qua
hs.graphicsDir = '/asset/salepage_v2/js/graphics/index.html';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.numberPosition = 'caption';
hs.dimmingOpacity = 0.75; // Add the controlbarif (hs.addSlideshow) hs.addSlideshow({//slideshowGroup: 'group1',interval: 5000,repeat: false,useControls: true,fixedControls: 'fit',overlayOptions: {opacity: .75,position: 'bottom center',hideOnMouseOut: true}});


function onScroll(e) {
    var o = $(document).scrollTop();
    $(".select-box ul li a").each(function () {
        var e = $(this), t = $(e.attr("href"));

        //Chinh Le comment
        t.position().top - 50 <= o && t.position().top - 50 + t.height() > o ? e.addClass("active-a") : e.removeClass("active-a")
    })
}
function ToggleClassM(e) {
    var o = $(e).attr("data-val"), t = $(e).attr("data-id"), n = $(e).attr("data-un");
    $(".anyarrow").html("Thu gọn" == $(".anyarrow").html() ? "Xem thêm" : "Thu gọn"), $(".anyarrow").toggleClass("arrowup"), $(".anyarrow").toggleClass("arrowdow"), $(".under-load").toggleClass("child-pos"), $("#" + o).slideToggle(), 0 == n ? ($(".a-thgon").addClass("show"), $(".a-thgon a").addClass(o + "2"), $(".anyarrow").addClass(o + "1"), $(e).attr("data-un", 1), $("." + o + "2").attr("data-un", 1)) : ($("." + o + "2").attr("data-un", 1), $("." + o + "1").attr("data-un", 0), $(".a-thgon").removeClass("show"), $(".anyarrow").removeClass(o + "1"), $(e).attr("data-un", 0), $(window).scrollTop($("#" + t).offset().top - 80))
}

//scroll to contact section
function scrolltoContact() {
    $("html, body").stop().animate({scrollTop: $('#' + section_contact_id).offset().top - 80}, "slow")
}

function RandomOnline() {
    setTimeout(function () {
        var e = localStorage.getItem("NumberOnline"), o = JSON.parse(e).number, t = Math.floor(4 * Math.random());
        if (t % 2) {
            var n = t + o;
            o > 356 && (n = o - t);
            var a = {number: n};
            localStorage.setItem("NumberOnline", JSON.stringify(a)), $("#onlinenumber").text(n), $(".phonering-alo-ph-img-circle").addClass("phonering-alo-ph-img-circle2")
        } else {
            n = o - t;
            o > 356 && (n = o - t), o < 200 && (n = o + t);
            a = {number: n};
            localStorage.setItem("NumberOnline", JSON.stringify(a)), $("#onlinenumber").text(n), $(".phonering-alo-ph-img-circle").addClass("phonering-alo-ph-img-circle2")
        }
        RandomOnline(), setTimeout(function () {
            $(".phonering-alo-ph-img-circle").removeClass("phonering-alo-ph-img-circle2")
        }, 1e3)
    }, 5e3)
}
$(window).scroll(function () {
    $(this).scrollTop() > 0 ? ($(".menu-fix").removeClass("hide"), $(".menu-fix").addClass("scroll-to-fixed")) : ($(".menu-fix").removeClass("scroll-to-fixed"), $(".menu-fix").removeClass("scroll-to-fixed-fixed")), $(this).scrollTop() > 0 ? $(".menu-fix").addClass("scroll-to-fixed-fixed") : ($(".menu-fix").removeClass("scroll-to-fixed"), $(".menu-fix").removeClass("scroll-to-fixed-fixed"))
}), $(document).ready(function () {
    $(document).on("scroll", onScroll), $('.select-box ul li a[href^="#"]').on("click", function (e) {
        e.preventDefault(), $(document).off("scroll");
        var o = $(this), t = $(o.attr("href")).selector.replace("#", "");
        $("#" + t).data("id");
        $(".select-box ul li a").removeClass("active-a"), o.addClass("active-a");
        var n = this.hash;
        $target = $(n), $("html, body").stop().animate({scrollTop: $target.offset().top - 40}, 600, "swing", function () {
            $(document).on("scroll", onScroll)
        })
    })
}), $(document).ready(function () {
    $("#fbFeedbackContent k").click(function (e) {
        var o = void 0 != window.screenLeft ? window.screenLeft : window.screenX, t = void 0 != window.screenTop ? window.screenTop : window.screenY, n = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width, a = "location=yes,height=570,width=720,scrollbars=yes,status=yes,top=" + ((window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height) / 2 - 285 + t) + ", left=" + (n / 2 - 360 + o);
        window.open("https://www.facebook.com/messages/t/hoadepdetrong", "_blank", a)
    })
});

    //Slide báo chí
    $(document).ready(function () {
        $("#clickrun").click(function () {
            $('html, body, form').animate({scrollTop: $("#order").offset().top}, 1000);
        });
        $(".baochiroll").owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            margin: 0,
            lazyLoad: true,
            autoplayTimeout: 13000,
            responsive: {
                0: {items: 1},
                320: {items: 2},
                400: {items: 2},
                600: {items: 2},
                991: {items: 3},
                1216: {items: 3}
            }
        });
        var owls = $('.baochiroll');
        $('.customNextBtn').click(function () {
            owls.trigger('next.owl.carousel');
        });
        $('.customPrevBtn').click(function () {
            owls.trigger('prev.owl.carousel');
        });
        $(".nhathuocroll").owlCarousel({
            items: 4,
            loop: true,
            autoplay: true,
            margin: 0,
            lazyLoad: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {items: 1},
                320: {items: 3},
                400: {items: 3},
                600: {items: 4},
                991: {items: 4},
                1024: {items: 4},
                1216: {items: 4}
            }
        });
        var owlsa = $('.nhathuocroll');
        $('.nhathuocNextBtn').click(function () {
            owlsa.trigger('next.owl.carousel');
        });
        $('.nhathuocPrevBtn').click(function () {
            owlsa.trigger('prev.owl.carousel');
        });
    });

    //Hiện bài salepage, sản phẩm cho tin tức
    $(function(){
        $(window).scroll(function () {

            //console.log( $(this).scrollTop() );
            //console.log( $(document).height() );

            //Hiện bài salepage khi scroll bottom
            if ($(this).scrollTop() >= 2000) {
                if ($('.footer_icon').is(":hidden")) {
                    $('.footer_icon').show();
                }

            }
        });
        })