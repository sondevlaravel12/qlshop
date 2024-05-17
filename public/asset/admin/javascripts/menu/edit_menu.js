init.push(function () {
    var menu_form = '#menu-form-edit';
    // Setup validation
    $(menu_form).validate({
        focusInvalid: false,
        rules: {
            'menu-title': {
                required: true
            },
            'menu-route': {
                required: true
            }
        },
        messages: {
        }
    });
});