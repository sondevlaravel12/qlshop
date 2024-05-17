//Open dialog after 10s
$(function(){
    $('.offline_heading').click(function(){
        //Close popup
        if( $('#popup_chat').hasClass('popup_open') ){
            $('#popup_chat').removeClass('popup_open').addClass('popup_close');
            $('.toggle_popup').removeClass('fa-angle-down').addClass('fa-angle-up');
            return;
        }

        //Open popup
        if( $('#popup_chat').hasClass('popup_close') ){
            $('#popup_chat').removeClass('popup_close').addClass('popup_open');
            $('.toggle_popup').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    })

    setTimeout(function(){
        if( $('#popup_chat').hasClass('popup_close') ){
            $('.offline_heading').click();
            play_sound();
        }
    }, 120000);

    //Submit form
    $('#contactForm').submit(function(e){

        e.preventDefault();

        var hoten = $('#hoten').val();
        var dienthoai = $('#dienthoai').val();
        var diachi = $('#diachi').val();
        var sanphamdat = $('#sanphamdat').val();
        var submitInfo = $('#submitInfo').val();

        //Check validate
        if( !hoten || !dienthoai || !diachi || !sanphamdat ){
            alert('Vui lòng nhập thông tin');
            return false;
        }

        var form_data = $(this).serializeFormJSON();

        //Call Ajax
        $.post('/common/chat_place_order',form_data,function(data){
            var chat_url = $('#chat_url').val();
            chat_url = chat_url.replace('/index.php','');
            //Success
            $('#popup_chat .popup_body').html(" <a href='"+ chat_url +"'><img src='/asset/chat/dat-hang-thanh-cong.png' /></a> ");
        })
    })

})

function play_sound(){
    var audio = new Audio('/asset/chat/ting.mp3');
    audio.play();
}

(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);