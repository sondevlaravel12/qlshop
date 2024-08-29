
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


// $(document).ready(function () {

// when changing date
$("input[name='invoice_date']").on('change', function(){
    // fill in input type hidden inorder to send request when submit form
    $("input[name='invoice_date_holder']").val($("input[name='invoice_date']").val());
})

/* ---------------------------------------------
validate form before submit
--------------------------------------------- */
//only put it in page need it or it may cause some error
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
            customer_phone: {
                required: true
            },
            zones: {
                required: true
            },
            customer_address:{
                required: true
            }
        },
        messages: {
            customer_name: {
                required: "Vui lòng điền tên khách hàng",
            },
            customer_phone: {
                required: 'Vui lòng điền sdt'
            },
            zones: {
                required: 'Vui lòng chọn khu vực'
            },
            customer_address:{
                required: 'Vui lòng điền địa chỉ'
            }
        },
    });
    $("#productForm").validate({
        // Specify validation rules
        rules: {
            name: {
                required: true
            },
            price: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Tên sản phẩm không được bỏ trống",
            },
            price: {
                required: "vui lòng điền giá bán sản phẩm",
            },
        },
    });
    // another form if need
});


/* ---------------------------------------------
End validate form before submit
--------------------------------------------- */

/* ---------------------------------------------
Autocomplete search product
--------------------------------------------- */
    $(function(){
        $("#product_search").length > 0 && ($("#product_search").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/api/invoices/search-product",
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
                // var $newrow = `<tr style="background-color: #e2f6e7;">
                //                     <td>
                //                         <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  ui.item.id + `" type="hidden">
                //                         <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  ui.item.SKU + `" type="hidden">
                //                         `+ ui.item.SKU +`
                //                     </td>
                //                     <td style="width:25%; ">
                //                         `+ ui.item.name +`
                //                     </td>
                //                     <td>
                //                         <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + ui.item.sale_unit + `">
                //                         ` + ui.item.sale_unit + `
                //                     </td>
                //                     <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                //                     <td>
                //                         <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  ui.item.price + `">
                //                         ` +  ui.item.price + `
                //                     </td>
                //                     <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                //                     <td >
                //                         <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value="` +  ui.item.price + `">

                //                     </td>
                //                     <td >
                //                         <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + ui.item.price + `" style="width:100%">

                //                     </td>
                //                     <td >
                //                         <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                //                             <i class="fas fa-trash-alt"></i>
                //                         </button>
                //                     </td>
                //                 </tr>`;
                var $newrow = fillHtmlProductRow(ui.item);
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
    $("table#productTable").on('keyup change','.product_quantity, .product_amount_off, .selling_price', function(){
        $class = $(this).attr('class');
        var $row = $(this).closest('tr');
        var $quantity = $row.find("input.product_quantity").val()

        var $price = parseInt($row.find("input.product_price").val().replace(/\./g,''));
        if($class.indexOf('product_amount_off')>=0){
            console.log($class);
            // changed on giamgia
            // var $product_amount_off = $row.find("input.product_amount_off").val()!=''? parseInt($row.find("input.product_amount_off").val().replace(/\./g,'')) : 0;
            $product_amount_off = $(this).val()!=''?parseInt($(this).val().replace(/\./g,'')) : 0;
            $selling_price = $price - $product_amount_off;
            // fill in saleing_price
            $row.find("input.selling_price").val($selling_price.toLocaleString( "es-AR" ));
            $product_line_total = ($price - $product_amount_off)*$quantity;

        }else if($class.indexOf('selling_price')>=0){
            // changed on gia ban
            $selling_price = $(this).val()!=''?parseInt($(this).val().replace(/\./g,'')) : 0;
            if($selling_price >= $price ){
                $row.find("input.product_amount_off").val('');

            }else{
                $product_amount_off = $price-$selling_price;
                $row.find("input.product_amount_off").val($product_amount_off.toLocaleString( "es-AR" ));
            }
        }else if($class.indexOf('product_quantity')>=0){
            // changed on quantity
            $selling_price = $('input.selling_price').val()!=''?parseInt($('input.selling_price').val().replace(/\./g,'')) : 0;
            $product_amount_off = $('input.product_amount_off').val()!=''?parseInt($('input.product_amount_off').val().replace(/\./g,'')) : 0;
            console.log($product_amount_off);

        }
        $product_line_total = $selling_price*$quantity;
        // fill in line total
        $row.find("input.product_line_total").val($product_line_total.toLocaleString( "es-AR" ));
        updateProductCount()
        // fill in total
        updateTotal();
    })
    // shipping, invoice amount off changed
    $('table#productTable .invoice_amount_off, table#productTable .shipping_fee').on('keyup change', function(){
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
                    url: "/api/invoices/search-customer",
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
                // append new row display customer
                var $newrow = fillHtmlCustomerRow(ui.item.id, ui.item.name, ui.item.phone, ui.item.address );
                $('#customerHolder').html($newrow);
                // fill in customer modal edit/update
                $zoneName ='';
                $warName = '';
                $zoneShortname ='';
                $zoneId ='';
                $warCode ='';
                $districtCode='';

                // if customer has address relationship
                if(ui.item.addresses.length>0){
                    $address = ui.item.addresses[0].name;
                    $zoneName = ui.item.addresses[0].zone.name;
                    $zoneShortname =ui.item.addresses[0].zone.short_name;
                    $zoneId =ui.item.addresses[0].zone.id;
                    $warName = ui.item.addresses[0].ward?ui.item.addresses[0].ward.name:'';
                    $warCode = ui.item.addresses[0].ward?ui.item.addresses[0].ward.code:'';
                    $districtCode = ui.item.addresses[0].zone?ui.item.addresses[0].zone.district_code:'';

                }else{
                    $address = ui.item.address;
                }
                fillCustomerEditModal(ui.item.id, ui.item.name, ui.item.phone, $address, $zoneName, $warName, $zoneShortname, $zoneId, $warCode, $districtCode);
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
Append customer id into invoice form
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
        var $zoneShortName = $('#zone-short-name').val();
        var $zoneId = $('#zone-id').val();
        var $wardCode = $('#ward-code').val();
        var $wards = $('#wards').val();
        var $address = $('#customer_address').val();
        var $customerAddress;
        if($wards!=''){
            $customerAddress = $address +', ' + $wards +', ' + $zoneShortName;
        }else{
            $customerAddress = $address + ', ' + $zoneShortName;
        }
        var $customerPhone = $('#customer_phone').val();
        $.ajax({
            type: "POST",
            url: "/api/invoices/create-customer",
            data: {_token: CSRF_TOKEN,wardCode: $wardCode, zoneId:$zoneId, address:$address, customerName: $customerName, customerAddress:$customerAddress, customerPhone:$customerPhone},
            dataType: "json",
            success: function( response ) {
                $zone = response.addresses[0].zone;
                $ward = response.addresses[0].ward;
                // fillCustomerEditModal(response.id, response.name, response.phone, response.address, $zoneName, $warName, $zoneShortname, $zoneId, $warCode, $districtCode);
                fillCustomerEditModal(response.id, response.name, response.phone, response.addresses[0].name, $zone.name, $ward.name, $zone.short_name, $zone.id, $ward.code, $zone.district_code );
                var $newrow = fillHtmlCustomerRow(response.id,response.name,response.phone, response.address);
                $('#customerHolder').html($newrow);
                // append customer id into form
                appendCutomerId(response.id);
                    //erase input field and hide modal
                $('#customer_name').val('');
                $('#customer_address').val('');
                $('#customer_phone').val('');
                $('#zones').val('');
                $('#wards').val('');
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
$("#modal_update_customer").on('submit','form#updateCutomerForm', function(e){
    e.preventDefault();
    var $customerID = $(this).find('input[name=customer_id]').val();
    var $customerName =  $(this).find('input[name=customer_name]').val();
    var $customerPhone = $(this).find('input[name=customer_phone]').val();
    $zoneShortName = $(this).find('#zone-short-name').val();
    $zoneId = $(this).find('#zone-id').val();
    $wardCode = $(this).find('#ward-code').val();
    $wards = $(this).find('#wards').val();

    $address = $(this).find('#customer_address').val();
    $customerAddress='';
    if($wards!=''){
        $customerAddress = $address +', ' + $wards +', ' + $zoneShortName;
    }else{
        $customerAddress = $address + ', ' + $zoneShortName;
    }

    $.ajax({
        type: "POST",
        url: "/api/invoices/update-customer",
        data: {wardCode: $wardCode, zoneId:$zoneId, customerID: $customerID, customerName: $customerName, customerAddress:$customerAddress, customerPhone:$customerPhone, address:$address},
        dataType: "json",
        success: function( response ) {

            var $newrow = fillHtmlCustomerRow(response.customer.id,response.customer.name,response.customer.phone, response.customer.address);
            //erase input field and hide modal
            // $modalForm = $('form#updateCutomerForm');
            // $modalForm.find('#customer_name').val('');
            // $modalForm.find('#customer_address').val('');
            // $modalForm.find('#customer_phone').val('');
            // $modalForm.find('#zones').val('');
            // $modalForm.find('#wards').val('');

            $('#modal_update_customer').modal('hide');
            $('#customerHolder').html($newrow);
            toastr.success(response.message);
        }
    });
});
//load customer
$customer_id = $('#customerHolder #customer_id').val();
if($customer_id){
    $.ajax({
        type: "get",
        url: "/api/customer/getCustomerById",
        data: {customerId:$customer_id},
        dataType: "json",
        success: function (response) {
            // fill in customer modal edit/update
            $zoneName ='';
            $warName = '';
            $zoneShortname ='';
            $zoneId ='';
            $warCode ='';
            $districtCode='';

            // if customer has address relationship
            if(response.addresses.length>0){
                $address = response.addresses[0].name;
                $zoneName = response.addresses[0].zone.name;
                $zoneShortname =response.addresses[0].zone.short_name;
                $zoneId =response.addresses[0].zone.id;
                $warName = response.addresses[0].ward?response.addresses[0].ward.name:'';
                $warCode = response.addresses[0].ward?response.addresses[0].ward.code:'';
                $districtCode = response.addresses[0].zone?response.addresses[0].zone.district_code:'';

            }else{
                $address = response.address;
            }
            // $zone = response.addresses[0].zone;
            // $ward = response.addresses[0].ward;
            // fillCustomerEditModal(response.id, response.name, response.phone, response.address, $zoneName, $warName, $zoneShortname, $zoneId, $warCode, $districtCode);
            fillCustomerEditModal(response.id, response.name, response.phone, $address, $zoneName, $warName, $zoneShortname, $zoneId, $warCode, $districtCode );
        }

    });
}

// submit invoice form
$("#productForm").submit(function(e) {

    //prevent Default functionality
    e.preventDefault();
    //get the action-url of the form
    var actionurl = e.currentTarget.action;
    //do your own request an handle the results
    $.ajax({
            url: actionurl,
            type: 'post',
            dataType: 'json',
            data: $("#productForm").serialize(),
            success: function(response) {
                //alert(response.name);
                // console.log(response.name);
                var $newrow = `<tr style="background-color: #e2f6e7;">
                                <td>
                                    <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  response.id + `" type="hidden">
                                    <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  response.SKU + `" type="hidden">
                                    `+ response.SKU +`
                                </td>
                                <td style="width:25%; ">
                                    `+ response.name +`
                                </td>
                                <td>
                                    <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + response.sale_unit + `">
                                    ` + response.sale_unit + `
                                </td>
                                <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                                <td>
                                    <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  response.price + `">
                                    ` +  response.price + `
                                </td>
                                <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                                <td >
                                    <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value="` +  response.price + `">

                                </td>
                                <td >
                                    <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + response.price + `" style="width:100%">

                                </td>
                                <td >
                                    <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>`;
                    //alert($newrow);
                $('#productItemsHolder').append($newrow);
                $('#modal_insert_product').removeData();
                $('#modal_insert_product').modal('hide');

            }
    });

});

/* ---------------------------------------------
End Edit customer
--------------------------------------------- */

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

                </div>
            </div>`;
        return $newrow;
    };
/* ---------------------------------------------
End Fill html customer row
--------------------------------------------- */

/* ---------------------------------------------
Fill customer edit modal
--------------------------------------------- */
    function fillCustomerEditModal(id,name, phone, address, zoneName, wardName, zoneShortName, zoneId, warCode, districtCode) {

        $customerEditModal = $('#modal_update_customer');
        $customerEditModal.find("input[name*='customer_id']").val(id);
        $customerEditModal.find('#customer_name').val(name);
        $customerEditModal.find('#customer_phone').val(phone);
        $customerEditModal.find('#customer_address').val(address);
        $customerEditModal.find('#zones').val(zoneName);
        if(wardName==''){
            $customerEditModal.find('.wards-holder').addClass('invisible');
            $customerEditModal.find('#wards').val('');
        }else{
            $customerEditModal.find('.wards-holder').removeClass('invisible');
            $customerEditModal.find('#wards').val(wardName);
        }
        // fill hidden iput
        $customerEditModal.find('#zone-short-name').val(zoneShortName);
        $customerEditModal.find('#zone-id').val(zoneId);
        $customerEditModal.find('#ward-code').val(warCode);
        $customerEditModal.find('#district_code').val(districtCode);

        // show wards
        $wardSelected = $('div#modal_update_customer .wards');
        $zonesRow = $('div#modal_update_customer .zones').closest('.zones-row')
        showWards(districtCode, $wardSelected,$zonesRow);

        // $customerEditModal.find('#customer_name').val(name);
     }
/* ---------------------------------------------
End Fill customer edit modal
--------------------------------------------- */

/* ---------------------------------------------
Create new product
--------------------------------------------- */

    $('.input-images-1').imageUploader({
        imagesInputName: 'photos',

        extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
        mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
        // maxSize: 10000,For a maximum size of 2 megabytes, you can set this option as 2 * 1024 * 1024 bytes.
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
    // submit create product form
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        // $(this).find('.input-images-1').html('');
        // $('.input-images-1').imageUploader({
        //                 imagesInputName: 'photos',

        //                 extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
        //                 mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
        //                 // maxSize: 10000,For a maximum size of 2 megabytes, you can set this option as 2 * 1024 * 1024 bytes.
        //                 maxFiles: 1,


        //             });
        // console.log('done');



        $.ajax({
            type: "POST",
            url: "/api/invoices/create-product",
            processData: false, contentType: false,
            data: formData,
            dataType: "json",
            success: function( response ) {

                var $newrow = fillHtmlProductRow(response);

                $('#productItemsHolder').append($newrow);
                // delete message
                $('.no_product_error').html('');
                updateProductCount()
                updateTotal();
                //erase input field and hide modal
                document.getElementById("productForm").reset();
                $('#productForm .input-images-1').empty();
                $('#productForm #show_item').empty();
                $('.input-images-1').imageUploader({
                    imagesInputName: 'photos',

                    extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
                    mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
                    // maxSize: 10000,For a maximum size of 2 megabytes, you can set this option as 2 * 1024 * 1024 bytes.
                    maxFiles: 1,


                });
                $('#modal_insert_product').modal('hide');
            }
        });
    })
    /* ---------------------------------------------
    Fill html product row
    --------------------------------------------- */
    function fillHtmlProductRowOld(response){
        var $newrow = `<tr style="background-color: #e2f6e7;">
                                    <td>
                                        <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  response.id + `" type="hidden">
                                        <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  response.SKU + `" type="hidden">
                                        `+ response.SKU +`
                                    </td>
                                    <td style="width:25%; ">
                                        `+ response.name +`
                                    </td>
                                    <td>
                                    <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + response.sale_unit + `">
                                    ` + response.sale_unit + `
                                    </td>
                                    <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                                    <td>
                                        <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  response.price + `">
                                        ` +  response.price + `
                                    </td>
                                    <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                                    <td >
                                        <input type="readonly" class="form-control selling_price" readonly name="selling_price[]"  value="` +  response.price + `">

                                    </td>
                                    <td >
                                        <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + response.price + `" style="width:100%">

                                    </td>
                                    <td >
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`;

        return $newrow;
    };
    function fillHtmlProductRow(response){
        var $newrow = `<tr style="background-color: #e2f6e7;">
                                    <td>
                                        <input  class="form-control"  id="product_id" name="product_id[]"  value="` +  response.id + `" type="hidden">
                                        <input  class="form-control"  id="product_sku" name="product_sku[]"  value="` +  response.SKU + `" type="hidden">
                                        `+ response.SKU +`
                                    </td>
                                    <td style="width:25%; ">
                                        `+ response.name +`
                                    </td>
                                    <td>
                                    <input  class="form-control"  type="hidden" id="product_sale_unit[]" name="product_sale_unit[]"  value="` + response.sale_unit + `">
                                    ` + response.sale_unit + `
                                    </td>
                                    <td ><input class="form-control product_quantity" id="" name="product_quantity[]" type="number" value="1" min="1"></td>
                                    <td>
                                        <input type="hidden" class="form-control product_price" readonly name="product_price[]"  value="` +  response.price + `">
                                        ` +  response.price + `
                                    </td>
                                    <td ><input style="color:red;" class="form-control product_amount_off auto_formatting_input_value" name="product_amount_off[]" type="text" value=""></td>
                                    <td >
                                        <input type="text" class="form-control selling_price auto_formatting_input_value" name="selling_price[]"  value="` +  response.price + `">

                                    </td>
                                    <td >
                                        <input class="form-control product_line_total"  readonly  name="product_line_total[]"  value="  ` + response.price + `" style="width:100%">

                                    </td>
                                    <td >
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light remove_item_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`;

        return $newrow;
    };
    /* ---------------------------------------------
    End Fill html customer row
    --------------------------------------------- */
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
// });

$("div#modal_insert_customer .zones").autocomplete({
    source: function( request, response ) {
        searchZones(request, response);
    },
    minLength: 3,
    select: function( event, ui ) {
            event.preventDefault();
            // var $selectedZone = ui.item.name;
            $(this).val(ui.item.name);
            // fill hidden iput, for what?
            // $('#zone-short-name').val(ui.item.short_name);
            $(this).siblings('#zone-short-name').val(ui.item.short_name); // for display short address
            $(this).siblings('#zone-id').val(ui.item.id); // for saving relationship with customer
            $(this).siblings('#district_code').val(ui.item.district_code);// for fillter ward
            // fill modal edit with this customer information

    }
}).data("ui-autocomplete")._renderItem = function (ul, item) {
        var n = '<p>'+item.name+'</p>';
        return $("<li></li>").data("ui-autocomplete-item", item).append(n).appendTo($(ul))
};

$("div#modal_update_customer .zones").autocomplete({
    source: function( request, response ) {
        searchZones(request, response);
    },
    minLength: 1,
    select: function( event, ui ) {
            event.preventDefault();
            // var $selectedZone = ui.item.name;
            $(this).val(ui.item.name);
            // fill hidden iput
            $(this).siblings('#zone-short-name').val(ui.item.short_name);
            $(this).siblings('#zone-id').val(ui.item.id);
            $(this).siblings('#district_code').val(ui.item.district_code);
    }
}).data("ui-autocomplete")._renderItem = function (ul, item) {
        var n = '<p>'+item.name+'</p>';
        return $("<li></li>").data("ui-autocomplete-item", item).append(n).appendTo($(ul))
};

function searchZones(request, response){
    $.ajax( {
        url: "/api/invoices/getZones",
        data: {_token: CSRF_TOKEN, term: request.term, maxResults: 10},
        dataType: "json",
        success: function (request) {
            response($.map(request, function (request) {
                return request
            }))
        }
      } );
}

// show or hide wards input
$(document).on('change',"div#modal_insert_customer .zones, div#modal_update_customer .zones", function(){
    $wardsRow = $(this).closest('.zones-row').siblings('.wards-holder');
    $zonesRow = $(this).closest('.zones-row');
    $wardSelected = $wardsRow.find('.wards');

    // hidden field
    $districtCodeHidField = $(this).siblings('#district_code');
    $zoneShortNameHidField = $(this).siblings('#zone-short-name');
    $zoneIdHidField = $(this).siblings('#zone-id');
    $wardCodeHidField = $(this).siblings('#ward-code');

    if($(this).val().length < 3){// type in not enough zone or remove zone
        $wardsRow.addClass('invisible');
        $wardSelected.val('');
        $districtCodeHidField.val('');
        // console.log($zoneShortNameHidField.val());
        $zoneShortNameHidField.val('');
        $zoneIdHidField.val('');
        $wardCodeHidField.val('');
    }else{
        $wardsRow.removeClass('invisible');
        if($districtCodeHidField.val()){
            showWards($districtCodeHidField.val(), $wardSelected,$zonesRow);
        }
    }
});
function showWards(districtCode, wardSelected, zonesRow){
    wardSelected.autocomplete({
    source: function( request, response ) {
        $.ajax( {
        url: "/api/invoices/getWardsByZone",
        data: {_token: CSRF_TOKEN, term: request.term, districtCode: districtCode},
        dataType: "json",
        success: function (request) {
            response($.map(request, function (request) {
                return request
            }))
        }
        } );
    },
    minLength: 1,
    select: function( event, ui ) {
            event.preventDefault();
            zonesRow.find('#ward-code').val(ui.item.code);
            $(this).val(ui.item.name);
    }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        var n = '<p>'+item.name+'</p>';
        return $("<li></li>").data("ui-autocomplete-item", item).append(n).appendTo($(ul))
    };
}
// remove hidden field ward-code when input wards has been clear
$(document).on('keyup',"div#modal_insert_customer .wards, div#modal_update_customer .wards", function(){
    if($(this).val().length < 1){
        $(this).closest('.wards-holder').siblings('.zones-row').find('#ward-code').val('');
    }
});



