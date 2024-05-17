//Validate phần thông tin chính sản phẩm
init.push(function () {
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'site_name': {
                required: true,
            },
            'site_description': {
                required: true,
            }		
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });

    //Tạo file google remarketing
    $('#download_gg_remarketing').click(function(){
        $.ajax({
            url: "/admincp/common/download_gg_remarketing",
            asyn: false,
            dataType: "html",
            success: function (data) {
                alert('Tạo file google thành công');
                console.log('Tạo file google thành công');
            }
        })
    });

    //Tạo file google remarketing
    $('#download_fb_remarketing').click(function(){
        $.ajax({
            url: "/admincp/common/download_fb_remarketing",
            asyn: false,
            dataType: "html",
            success: function (data) {
                alert('Tạo file facebook thành công');
                console.log('Tạo file facebook thành công');
            }
        })
    });

});
