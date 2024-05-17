$(function() {
    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

    //Validate password form
    $("#login-form").validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            email: {
                required: true,
                email: true
            }
        }
    });

    $("#register-form").validate({
        rules: {
            fullname: {
                required: true,
            },
            email: {
                required: true,
                email:true
            },
            phone: {
                required: true,
            },
            address: {
                required: true,
            },
            password: {
                required: true,
                equalTo: "#repassword",
                minlength: 6,
                maxlength: 25
            }
        }
    });

    //Validate password form
    $("#password_update").validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            new_password: {
                required: true,
                equalTo: "#renew_password",
                minlength: 6,
                maxlength: 25
            },
            renew_password: {
                required: true,
                minlength: 6,
                maxlength: 25
            }
        }
    });
    //Validate profile
    $("#profile_update").validate({
        rules: {
            fullname: {
                required: true,
            },
            email: {
                required: true,
                email:true
            },
            phone: {
                required: true,
            },
            address: {
                required: true,
            }
        }
    });
});