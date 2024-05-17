
//browser does not recognize the function name when it inside the jquery document.ready function. what i did was wrap it inside although it seems unconventional.
//https://stackoverflow.com/questions/8799733/jquery-function-not-defined
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
function updateProductCount(){
    var $productCount = 0;
    $('table#productTable tbody#productItemsHolder tr').each(function (i) {
        var $itemCount = parseInt($(this).find('.product_quantity').val());
        $productCount = $productCount + $itemCount;
    });
    if($productCount == 0){
        $('#product_count').val("");
    }else{
        $('#product_count').val($productCount);
    }

}
function updateTotal(){
    var $invoice_total =0;
    var $invoice_subtotal =0;
   $('table#productTable tbody#productItemsHolder tr').each(function (i) {
        var $product_line_total = parseInt($(this).find('.product_line_total').val().replace(/\./g,''));
        $invoice_subtotal = $invoice_subtotal+$product_line_total;
    });
    var $invoice_amount_off = parseInt($('table#productTable .invoice_amount_off').val().replace(/\./g,''));
    $invoice_amount_off = !$invoice_amount_off ? 0 : $invoice_amount_off;
    var $shipping_fee = parseInt($('table#productTable .shipping_fee').val().replace(/\./g,''));
    $shipping_fee = !$shipping_fee ? 0 : $shipping_fee;
    $invoice_total = $invoice_subtotal + $shipping_fee - $invoice_amount_off;
    $('table#productTable #invoice_subtotal').val($invoice_subtotal.toLocaleString("es-AR"));
    $('table#productTable #product_total').val($invoice_total.toLocaleString("es-AR"));
}


$(document).ready(function () {

// when changing date
$("input[name='invoice_date']").on('change', function(){
    // fill in input type hidden inorder to send request when submit form
    $("input[name='invoice_date_holder']").val($("input[name='invoice_date']").val());
})

// validate form before submit///only put it in page need it or it may cause some error
$.validator.setDefaults({ ignore: [''] }); // not ignore hidden field// should put in if hasClass to prevent error if page do not have form validate
$(function(){
    $("#invoice_form").validate({
        // Specify validation rules
        rules: {
            customer_id: {
                required: true
            },
            product_count: {
                required: true
            }
            },
        messages: {
            customer_id: {
                required: "!!! Hóa đơn chưa có khách hàng",
            },
            product_count: {
                required: "!!! Hóa đơn chưa có sản phẩm",
            }
            },
        errorPlacement: function (error, element) {

            var elId = element.attr('id');
            if(elId == 'customer_id')
            {
                $('#customerHolder').html('<div style="color:red;">' + error.text() + '</div>');
            }
            // else
            // if(elId == 'invoice_subtotal')
            // {
            //    $('#productItemsHolder').html('<div style="color:red;">' + error.text() + '</div>');
            // }
            else
            {
                $('.no_product_error').html('<div style="color:red;">' + error.text() + '</div>');
            }
        }
    });
    $("#customerForm").validate({
        // Specify validation rules
        rules: {
            customer_name: {
                required: true
            },
        },
        messages: {
            customer_name: {
                required: "Vui lòng điền tên khách hàng",
            },
        },
    });
    // another form if need
});




/* ---------------------------------------------
Autocomplete search product
--------------------------------------------- */
    $(function(){
        $("#product_search").length > 0 && ($("#product_search").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/invoices/ajax-search-product",
                    data: {_token: CSRF_TOKEN, term: request.term, maxResults: 10},
                    dataType: "json",
                    method:'post',
                    success: function (request) {
                        response($.map(request, function (request) {
                            return request
                        }))
                    }
                })
            },
            select: function (event, ui) {
                // var $newrow = '<p>' + ui.item.label +'</p>';
                var $newrow = `<tr style="background-color: #e2f6e7;">
                                    <td>
                                        <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  ui.item.id + `" type="hidden">
                                        <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  ui.item.SKU + `" type="hidden">
                                        `+ ui.item.SKU +`
                                    </td>
                                    <td style="width:25%; ">
                                        `+ ui.item.name +`
                                    </td>
                                    <td>
                                        <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + ui.item.sale_unit + `">
                                        ` + ui.item.sale_unit + `
                                    </td>
                                    <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                                    <td>
                                        <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  ui.item.price + `">
                                        ` +  ui.item.price + `
                                    </td>
                                    <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                                    <td >
                                        <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value="` +  ui.item.price + `">

                                    </td>
                                    <td >
                                        <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + ui.item.price + `" style="width:100%">

                                    </td>
                                    <td >
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`;
                $('#productItemsHolder').append($newrow);
                // delete message
                $('.no_product_error').html('');
                updateProductCount()
                updateTotal();
            }
        }).data("ui-autocomplete")._renderItem = function (request, response) {
            var n =
            `<a href="#" class="list-group-item list-group-item-action d-flex  align-items-center">
            <div class="w-100">
            <p class="mb-0 text-center"><i class="fab fa-product-hunt blue"></i>&nbsp;`+ response.name +
            `&nbsp;&nbsp;<i class="fas fa-layer-group blue"></i>&nbsp;`+ response.sale_unit +
            `&nbsp;&nbsp;<i class="fas fa-balance-scale blue"></i>&nbsp;`+ response.price +`</p>
            </div>
            <img class="d-block float-left img-thumbnail img-fluid" src="` + response.image +`" width="60" height="60" > </a>

        </div>`
            return $("<li></li>").data("ui-autocomplete-item", response).append(n).appendTo(request)
        })
    })
    // each product item row changed
    $("table#productTable").on('keyup change','.product_quantity, .product_amount_off', function(){

        var $row = $(this).closest('tr');

        //var $quantity = parseInt($(this).val());

        var $quantity = $row.find("input.product_quantity").val()

        var $price = parseInt($row.find("input.product_price").val().replace(/\./g,''));
        var $product_amount_off = $row.find("input.product_amount_off").val()!=''? parseInt($row.find("input.product_amount_off").val().replace(/\./g,'')) : 0;
        var $selling_price = $price - $product_amount_off;
        // fill in saleing_price
        $row.find("input.selling_price").val($selling_price.toLocaleString( "es-AR" ));
        var $product_line_total = ($price - $product_amount_off)*$quantity;
        // fill in line total
        $row.find("input.product_line_total").val($product_line_total.toLocaleString( "es-AR" ));
        updateProductCount()
        // fill in total
        updateTotal();
    })
    // shipping, invoice amount off changed
    $('table#productTable .invoice_amount_off, table#productTable shipping_fee').on('keyup change', function(){
        updateTotal();
    })

/* ---------------------------------------------
End Autocomplete search product
--------------------------------------------- */


/* ---------------------------------------------
Autocomplete search customer
--------------------------------------------- */
    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(function(){
        $("#customer_search").length > 0 && ($("#customer_search").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/admin/invoices/ajax-search-customer",
                    data: {_token: CSRF_TOKEN, term: request.term, maxResults: 10},
                    dataType: "json",
                    method:'post',
                    success: function (request) {
                        response($.map(request, function (request) {
                            return request
                        }))
                    }
                })
            },
            select: function (event, ui) {
                    var $newrow = fillHtmlCustomerRow(ui.item.id, ui.item.name, ui.item.phone, ui.item.address );
                $('#customerHolder').html($newrow);
                // append customer id into form
                appendCutomerId(ui.item.id);
            }
        }).data("ui-autocomplete")._renderItem = function (request, response) {
            //var n = response.name ;
            var n = '<p><i class="fas fa-user blue"></i>&nbsp;'
            +response.name+'&nbsp;&nbsp;&nbsp;<i class="fas fa-phone blue"></i>&nbsp;'
            +response.phone+'&nbsp;&nbsp;&nbsp;<i class="far fa-address-card blue"></i>&nbsp;'
            +response.address+'</p>'
            return $("<li></li>").data("ui-autocomplete-item", response).append(n).appendTo(request)
        })
    });
/* ---------------------------------------------
End Autocomplete search customer
--------------------------------------------- */
/* ---------------------------------------------
Append customer id into form
--------------------------------------------- */
function appendCutomerId($customer_id){
    $('.customer_id').val($customer_id);
}
/* ---------------------------------------------
Append customer id into form
--------------------------------------------- */

/* ---------------------------------------------
Create new customer
--------------------------------------------- */

    $('#customerForm').on('submit', function(e) {
        e.preventDefault();
        var $customerName = $('#customer_name').val();
        var $customerAddress = $('#customer_address').val();
        var $customerPhone = $('#customer_phone').val();
        $.ajax({
            type: "POST",
            url: "/admin/invoices/ajax-create-customer",
            data: {_token: CSRF_TOKEN, customerName: $customerName, customerAddress:$customerAddress, customerPhone:$customerPhone},
            dataType: "json",
            success: function( response ) {

                var $newrow = fillHtmlCustomerRow(response.id,response.name,response.phone, response.address);
                $('#customerHolder').html($newrow);
                // append customer id into form
                appendCutomerId(response.id);
                    //erase input field and hide modal
                $('#customer_name').val('');
                $('#customer_address').val('');
                $('#customer_phone').val('');
                $('#modal_insert_customer').modal('hide');
            }
        });

    });
/* ---------------------------------------------
End Create new customer
--------------------------------------------- */

/* ---------------------------------------------
Edit customer
--------------------------------------------- */
$("#customerHolder").on('submit','form#updateCutomerForm', function(e){
    e.preventDefault();
    var $customerID = $(this).find('input[name=customer_id]').val();
    var $customerName =  $(this).find('input[name=customer_name]').val();
    var $customerAddress = $(this).find('textarea#customer_address').val();
    var $customerPhone = $(this).find('input[name=customer_phone]').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "/admin/invoices/ajax-update-customer",
        data: {customerID: $customerID, customerName: $customerName, customerAddress:$customerAddress, customerPhone:$customerPhone},
        dataType: "json",
        success: function( response ) {

            var $newrow = fillHtmlCustomerRow(response.customer.id,response.customer.name,response.customer.phone, response.customer.address);

            $('#modal_update_customer').modal('hide');
            $('#customerHolder').html($newrow);
            toastr.success(response.message);
        }
    });
})

/* ---------------------------------------------
Fill html customer row
--------------------------------------------- */
    function fillHtmlCustomerRow(id,name, phone, address, email){
        $newrow =
        `<div class="col-md-3">
                <input id="customer_id" type="hidden" value="` + id + `">
                <div class="mb-3 position-relative">

                    <input disabled  value="` + name + `" class="form-control" type="hidden" >
                    <h5>` + name + `</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3 position-relative">

                    <input disabled value="` + phone + `" class="form-control" type="hidden" >
                    <h5>` + phone + `</h5>
                </div>
            </div>
            <div class="col-md-5">
                <div class="mb-3 position-relative">

                    <div class="input-group">
                        <h5> ` + address + `</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3 position-relative">

                    <button class="btn btn-outline-info waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center-2"><i class="fas fa-edit"></i></button>
                    <div id="modal_update_customer" class="modal fade bs-example-modal-center-2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <form action="" id="updateCutomerForm" >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Khách hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input name="customer_id" type="hidden" value="` + id + `">
                                                    <div class="row mb-3">
                                                        <label for="customer_name" class="col-sm-2 col-form-label">Tên khách hàng</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" value="` + name + `" type="text" id="customer_name" name="customer_name">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="customer_phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="tel" value="` + phone + `"  id="customer_phone" name="customer_phone">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <label for="customer_address" class="col-sm-2 col-form-label">địa chỉ</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control"  name="customer_address" id="customer_address" cols="30" rows="2">` + address + `</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Bỏ qua</button>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Cập nhật khách hàng</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </form>
                        </div><!-- /.modal -->
                </div>
            </div>`;
        return $newrow;
    };
/* ---------------------------------------------
End Fill html customer row
--------------------------------------------- */

/* ---------------------------------------------
Create new product
--------------------------------------------- */
    function preview() {
        imagePreview.src=URL.createObjectURL(event.target.files[0]);
    };

    $('.input-images-1').imageUploader({
        imagesInputName: 'photos',

        extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
        mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
        maxSize: 10000,
        maxFiles: 1,


    });
    // add new sale unit
    $('.add_item_btn').click(function(e){
        e.preventDefault();
        //var $saleUnitsJson = JSON.parse($("#sale_unit_lists").val());
        var $saleUnitsJson = JSON.parse($("#sale_unit_lists").val());
        //console.log($saleUnitsJson);
        var sale_unit_lists ='';
        $.each($saleUnitsJson, function(index, eletment){
            sale_unit_lists += '<option>'+eletment.title+'</option>';
        });
        var $newrow = `<div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3 position-relative">
                                                <input type="text" class="form-control" name="su_name[]" list="saleunit_list" >
                                                <datalist id="saleunit_list">`+
                                                    sale_unit_lists
                                                    +`
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 position-relative">
                                                <input type="text" class="form-control auto_formatting_input_value" name="su_price[]">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3 position-relative">
                                                <input type="text" class="form-control auto_formatting_input_value" name="su_original_price[]" >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3 ">
                                                <button type="button" class="btn btn-light waves-effect remove_saleunit_btn">
                                                    <i class="fas fa-trash-alt"></i>&nbspXóa
                                                </button>
                                            </div>
                                        </div>
                                    </div>`;
        $('#show_item').append($newrow);
    });
/* ---------------------------------------------
End Create new product
--------------------------------------------- */


/* ---------------------------------------------
Remove product
--------------------------------------------- */
$(document).on('click','.remove_item_btn',function(e){
    e.preventDefault();
    let $row = $(this).parent().parent();
    $row.remove();
    updateProductCount()
    updateTotal();
});


/* ---------------------------------------------
End Remove product
--------------------------------------------- */

/* ---------------------------------------------
Remove sale unit
--------------------------------------------- */
$(document).on('click','.remove_saleunit_btn',function(e){
    e.preventDefault();
    let $row = $(this).parent().parent().parent();
    $row.remove();
});
/* ---------------------------------------------
End Remove sale unit
--------------------------------------------- */
/* ---------------------------------------------
Prevent submit form when enter hitting
--------------------------------------------- */

$(window).keydown(function(event){
    if(event.keyCode == 13) {
    event.preventDefault();
    return false;
    }
});

/* ---------------------------------------------
End Prevent submit form when enter hitting
--------------------------------------------- */
});



