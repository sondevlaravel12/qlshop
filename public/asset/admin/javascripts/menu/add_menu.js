init.push(function () {
    var menu_form = '#menu-form-add';
    // Setup validation
    $(menu_form).validate({
        focusInvalid: false,
        rules: {
            'menu-title': {
                required: true
            },
            'menu-route': {
                required: true
            },
            'menu-active':{
                required:true
            },
            'menu-display':{
                required:true
            }
        },
        messages: {
        }
    });
});

init.push(function () {
    var parents = jQuery('#menu-list').parents('li');
    parents.eq(0).addClass('active');
    parents.eq(1).addClass('open active');
});