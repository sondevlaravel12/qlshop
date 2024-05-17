//Validate phần thông tin chính sản phẩm
init.push(function () {
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'post_title': {
                required: true,
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });
});