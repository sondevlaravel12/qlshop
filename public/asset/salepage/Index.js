$(function () {
    var note = $('#note'), ts = new Date(2016, 4, 15, 00, 00, 00);
    if ((new Date()) > ts) { ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000; }
    $('#countdownincontent').countdownincontent({
        timestamp: ts,
        callback: function (days, hours, minutes, seconds) {
            var message = "";
            message += days + " Ngày" + ", ";
            message += hours + " Giờ" + ", ";
            message += minutes + " Phút" + ", ";
            message += seconds + " Giây" + " <br />";
            note.html(message);
        }
    });
});
 //Top 
        $(document).ready(function () {

            // hide #back-top first
            $("#back-top").hide();

            // fade in #back-top
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 100) {
                        $('#back-top').fadeIn();
                    } else {
                        $('#back-top').fadeOut();
                    }
                });

                // scroll body to 0px on click
                $('#back-top a').click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
            });
        });

        //popup

        $(function () {


            $('#try-1').click(function (e) {
                $(".abc").lightbox_me();
            });

            $('#try-2').click(function (e) {
                $(".abc2").lightbox_me();
            });



        });

       $(window).load(function(){
            $window = $(window);
            $window.scroll(function(event) {
                scrollTop = $window.scrollTop();
                if( scrollTop >= 5 ){
                    $('.tm-hotline').addClass('box-shadow');
                }else {
                    $('.tm-hotline').removeClass('box-shadow');
                }
            });
        });//]]>

