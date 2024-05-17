//Validate phần thông tin chính sản phẩm
init.push(function () {
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'product-title': {
                required: true,
            },
            'product-price': {
                required: true,
                number: true
            },
            'product-discount': {
                required: true,
                number: true
            },
            'seo_title': {
                required: true,
                number: true
            },
            'hvnet-product-id': {
                number: true
            }

        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });
});

//Multiple select2
init.push(function () {
    // Catalog select
    var select_catalog = $("#select_catalog");
    select_catalog.select2({
        allowClear: true,
        placeholder: "Select a catalog"
    });
    select_catalog.on("select2:unselecting", function(e){
         var unselected_value = $('#mySelect').val();
         alert(unselected_value);
    }).trigger('change');

    // Multiple TAG select
    select_tag = $("#select_tag");
    select_tag.select2({
        allowClear: true,
        placeholder: "Select a tag"
    });
    select_tag.on('select2-open', function (e) {
        //get_tag();
    });

    //Load danh sách tag
    $('#load_tag').click(function(){
        get_tag();
    })
})

function get_tag(){
    var select_open = $('#select_tag_open').val();
    if( select_open == '1' ){
        return;
    }

    //Đợi
    $('#load_tag').text('Vui lòng đợi');

    //Add option to select tag
    var url = '/admincp/product_tab/ajax_get_tag';
    $.get(url,function( data ){

        var option = [];

        //console.log(data[0]);

        $.each(data,function(i, item){
            //console.log(item);
            option[i] = new Option(item.title, item.id, false, false);
            select_tag.append(option).trigger('change');
        });

        $('#select_tag_open').val('1');

        //Xong
        $('#load_tag').text('Load tag xong.');
    });
}