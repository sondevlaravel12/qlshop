//Validate phần thông tin chính sản phẩm
init.push(function () {
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'username': {
                required: true
            },
            'password': {
                required: true
            },
            'email': {
                required: true
            },
            'description': {
                required: true
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });
});