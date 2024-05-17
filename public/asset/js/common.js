active = false;
function active_url(){
    var current = location.pathname; // /gioi-thieu /lien-he
    $('ul.navbar-nav li a').each(function(){
        var $this = $(this);
        var li = $this.parent('li');

        if( active == true ){
            return;
        }

        //If current is home
        if( current == '/' ){
            li.addClass('active');
            active = true;
        }

        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            li.addClass('active');
            active = true;
        }
    })
}


if( $('.navbar-nav').length > 0 ){
    active_url();
    if( current_page ){
        if( active == false ){
            $('.navbar-nav #'+current_page).addClass('active');
        }
    }
}


 /* ---------------------------------------------
     Lazy load image
     --------------------------------------------- */
$(function() {
    $('.lazy').Lazy();
});



/* ---------------------------------------------
     Hiện bài salepage, sản phẩm cho tin tức
     --------------------------------------------- */

$(function(){
    $(window).scroll(function () {

        //Detect mobile
        if( $(document).width() <= 1000 ){
            my_height = 4000;
        }else{
            my_height = 2000;
        }

        //Hiện bài salepage khi scroll bottom
        if( $(this).scrollTop() > ($(document).height() - my_height) )
        {

            if( $('.salepage_ajax').html() != ''){
                return;
            }

            var salepage_id = $('#salepage_id').val();
            var product_id = $('#product_id').val();

            $.ajax({
                url: "/common/get_salepage_product",
                async: false,
                data: {
                    salepage_id: salepage_id,
                    product_id: product_id
                },
                dataType: "json",
                success: function (data) {
                    $('.salepage_ajax').html(data.html);
                }
            })
        }
    });
})


$(function(){
    // $('.navbar-nav #'+current_page).addClass('active');

    //Cộng trừ số lượng sản phẩm
    var t = parseInt($("#product_qty").val());
    $(".sub-btn").click(function () {
        t >= 2 && (t--, $("#product_qty").val(t))
    }), $(".add-btn").click(function () {
        50 >= t && (t++, $("#product_qty").val(t))
    })

})


/* ---------------------------------------------
     Ẩn hiện giỏ hàng sidebar
     --------------------------------------------- */

$(document).mouseup(function(e) {
    var container = $(".cart-sidebar");

    if (!container.is(e.target) // if the target of the click isn't the container...
        &&
        container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        $('body').removeClass('cart-opened');
        $('.cart-sidebar').removeClass('opened');
    }

    //Menu trên smartphone
    var menu_smartphone = $('.menu-mobile');
    if (!menu_smartphone.is(e.target) // if the target of the click isn't the container...
        &&
        menu_smartphone.has(e.target).length === 0) // ... nor a descendant of the container
    {
        $('html,body').removeClass('menu-opened');
        $('.menu-mobile').removeClass('opened');
    }
});

/* ---------------------------------------------
     Autocomplete search
     --------------------------------------------- */
     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(function(){
    $("#autosearch").length > 0 && ($("#autosearch").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/san-pham/ajax-tim-kiem",
                data: {_token: CSRF_TOKEN, term: request.term, maxResults: 10},
                dataType: "json",
                success: function (request) {
                    response($.map(request, function (request) {
                        return request
                    }))
                }
            })
        }, select: function (request, response) {
            return !1
        }
    }).data("ui-autocomplete")._renderItem = function (request, response) {
        var n = '<a href="' + response.id + '"><div class="list_item_container"><div class="image"><img src="' + response.avatar + '"></div><div class="description">' + response.label + '</div></div></a><hr class="search-hr"/>';
        return $("<li></li>").data("ui-autocomplete-item", response).append(n).appendTo(request)
    })
})


/* ---------------------------------------------
     Them san pham vao gio hang
     --------------------------------------------- */

jQuery(function(){
    //Trang danh muc san pham
    jQuery('#view-product-list').on("click",'.add-to-cart',function(){
        add_to_cart( $(this) );
    });

    //Link add to cart
    jQuery('.link-add-to-cart').click(function(){
        add_to_cart( $(this) );
    })

    //Trang home, san pham chi tiet
    jQuery('.add-to-cart').click(function(){
        add_to_cart( $(this) );
    });

    // update cart intems in cart side bar

    $('div#cart_sidebar_html').on('change', '.quantity-changed', function(e){
        e.preventDefault();
        update_cart_items_in_cart_side_bar($(this));
    });

     // update cart intems in cart main
    $(document).on('change',"#cartindex-quantity-changed",function(e){
        e.preventDefault();
        update_cart_items_in_cart_main($(this));
    });

    // remove cart Item in cart side bar
    $('div#cart_sidebar_html').on('click', '.btn-item-delete', function(e){
        e.preventDefault();
        remove_cart_item_sidebar($(this));
    });
     // remove cart Item in cart main
    $('section.tiki-cart').on('click', '.btn-item-delete-main', function(e){
        e.preventDefault();
        remove_cart_item_main($(this));
    });


})

// add to cart in index page
function add_to_cart(current){

    // if( current.hasClass('list_product') ){
    //     product_id = current.attr('product_id');
    // }
    var product_id = current.hasClass('list_product') ? current.attr('product_id') : jQuery('#product_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.ajax({
        url:  "/addcart-response",
        data: {"id":product_id},
        type: 'POST',
        dataType: 'json',
        success: function(data){
            if( data.status == 1 ){
                //Fill html vô cart sidebar

                $('#cart_sidebar_html').html( data.html ).promise().done(function(){

                    //Hiện cart sidebar
                    $('body').addClass('cart-opened');
                    $('.cart-sidebar').addClass('opened');

                    $(".icon_gio_hang").html(data.html_icon_gio_hang);
                    $('.notify').html(data.total_items);

                });
            }

        }
    });
}

// remove cart item
function remove_cart_item_sidebar(current){
    var rowId = current.data('row-id');

    // call ajax send rowid to CartController
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url:  "gio-hang-sidebar/xoa-san-pham",
        data: {"rowId":rowId, "page":"cart_side_bar_page"},
        type: 'POST',
        dataType: 'json',
        success: function(data){
            if( data.status == 1 ){

                //Fill html vô cart sidebar
                $('#cart_sidebar_html').html( data.html ).promise().done(function(){
                    //Hiện cart sidebar

                    $('body').addClass('cart-opened');
                    $('.cart-sidebar').addClass('opened');

                    $(".icon_gio_hang").html(data.html_icon_gio_hang);
                    $('.notify').html(data.total_items);
                });
            }
        }
    });
}
function remove_cart_item_main(current){
    var rowId = current.data('row-id');

    // call ajax send rowid to CartController
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery.ajax({
        url:  "gio-hang-main/xoa-san-pham",
        data: {"rowId":rowId,"page":"cart_main_page"},
        type: 'POST',
        dataType: 'json',
        success: function(data){
            if( data.status == 1 ){
                $('section').html( data.html );
                $(".icon_gio_hang").html(data.html_icon_gio_hang);
                $('.notify').html(data.total_items);
            }
        }
    });
}

// update cart items
function update_cart_items_in_cart_main(current){
    var rowId = current.attr('data-id');
    var quantity = current.val();

    // call ajax send rowid and quantity to CartController
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //console.log(csrf_token());
    jQuery.ajax({
        url:  "gio-hang/cap-nhat-main",
        data: {"rowId":rowId,"quantity":quantity},
        type: 'POST',
        dataType: 'json',
        success: function(data){
            if( data.status == 1 ){
                $('#cart-main-content').html( data.html );
                $(".icon_gio_hang").html(data.html_icon_gio_hang);
                $('.notify').html(data.total_items);
            }
        }
    });
}
function update_cart_items_in_cart_side_bar(current){
        var rowId = current.attr('data-id');
        var quantity = current.val();

        // call ajax send rowid and quantity to CartController
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        jQuery.ajax({
            url:  "/gio-hang/cap-nhat",
            data: {"rowId":rowId,"quantity":quantity},
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if( data.status == 1 ){
                        console.log('fill now');
                        $('#cart_sidebar_html').html( data.html ).promise().done(function(){

                        //     //Hiện cart sidebar
                             $('body').addClass('cart-opened');
                             $('.cart-sidebar').addClass('opened');

                            $(".icon_gio_hang").html(data.html_icon_gio_hang);
                            $('.notify').html(data.total_items);

                        });
                    // }

                }
            }
        });
}

// hide cart in mobile devices
function hideCart(){
    //hide cart sidebar
    $('body').removeClass('cart-opened');
    $('.cart-sidebar').removeClass('opened');
}
//not use
function add_to_cartold(current){
        var mua_nhanh = false;
        if( current.hasClass('mua-nhanh') ){
            mua_nhanh = true;
        }

        if( current.hasClass('list_product') ){
            product_id = current.attr('product_id');
            qty = current.attr('product_qty');
        }else{
            product_id = jQuery('#product_id').val();
            qty = parseInt( jQuery('#product_qty').val() );
        }

        if( parseInt(qty) <= 0 || isNaN(qty) ){
            qty = 1;
        }

        //Product option
        private_option = $('input[name=private_option]:checked').val();
        public_option = $(".cart_area input:checkbox:checked").map(function(){
            return $(this).val();
        }).get() + "";

        //Lấy option số lượng
        var quality = '';
        jQuery.each( $('.option_quality'),function(){
            var id = $(this).attr('rel');
            var val = $(this).val();
            quality = quality.concat( ","+id+":"+val );

        } );
        //console.log(quality);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url:  "/gio-hang/them-san-pham",
            data: {"id":product_id,"qty":qty,"private_option":private_option,"public_option":public_option,"public_option_quality":quality},
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if( data.status == 1 ){

                    //Redirect mua nhanh page
                    if( mua_nhanh == true ){
                        window.location.href = '/thanh-toan-don-hang';
                    }
                    else{
                        //Fill html vô cart sidebar
                        console.log('fill now');
                        $('#cart_sidebar_html').html( data.html ).promise().done(function(){

                            //Hiện cart sidebar
                            $('body').addClass('cart-opened');
                            $('.cart-sidebar').addClass('opened');

                            $(".icon_gio_hang").html(data.html_icon_gio_hang);
                            $('.notify').html(data.total_item);

                        });
                    }

                }
            }
        });
}

