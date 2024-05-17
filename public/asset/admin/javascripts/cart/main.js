//Validate phần thông tin chính sản phẩm
init.push(function () {
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'user-name': {
                required: true,
            },
            'user-phone': {
                required: true,
            },
            'user-address': {
                required: true,
            },
            'total': {
                required: true,
                number: true
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });
});