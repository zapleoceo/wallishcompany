$('input.contacts__input').each((index, el) => {
    el.addEventListener('change', (e) => {
        //console.log(e.target.value.length);
        if (e.target.value.length === 0) {
            e.target.nextSibling.nextSibling.classList.add('empty');
            e.target.nextSibling.nextSibling.classList.remove('has');
        } else {
            e.target.nextSibling.nextSibling.classList.remove('empty');
            e.target.nextSibling.nextSibling.classList.add('has');
        }
    });
});

const toggleShowPass = (idLabel, inputId) => {
    $(idLabel).mousedown(() => {
        $(inputId).attr('type', 'text');
    });

    $(idLabel).mouseup(() => {
        $(inputId).attr('type', 'password');
    });

    $(idLabel).on('touchstart', () => {
        $(inputId).attr('type', 'text');
    });

    $(idLabel).on('touchend', () => {
        $(inputId).attr('type', 'password');
    });
};

toggleShowPass('#passVisible2', '#create_pass');
toggleShowPass('#passVisible1', '#login_pass');


/*

// Login
$(document).on('click', '#button-login', function() {
    if ($(this).closest('form').find('.error').length)
        return false;

    $.ajax({
        url: 'index.php?route=checkout/login/save',
        type: 'post',
        data: $('#hidden_content_0 :input'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-login').button('loading');
        },
        complete: function() {
            $('#button-login').button('reset');
        },
        success: function(json) {

            $('.alert, .text-danger').remove();
            //$('.form-group').removeClass('has-error');

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('.main h1').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // Highlight any found errors
                $('#loginUser input[name=\'email\']').parent().addClass('has-error');
                $('#loginUser input[name=\'password\']').parent().addClass('has-error');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
*/

function init() {

    // create user validators
    $("#registerUser").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 3
            },
            lastname: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            telephone: {
                required: true,
                minlength: 7
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            firstname: {
                required: "Enter a your name",
                minlength: "Enter at least 3 characters"
            },
            lastname: {
                required: "Enter a your surname",
            },
            email: {
                required: "Enter a your email address",
                email: "Enter a valid email address"
            },
            telephone: {
                required: "Enter your phone number",
                minlength: "Enter at least 7 characters"
            },
            password: {
                required: "Enter your password",
                minlength: "Enter at least 6 characters"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#loginUser").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Enter a your email address",
                email: "Enter a valid email address"
            },
            password: {
                required: "Enter your password"
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#anonimUser").validate({
        rules: {
            telephone: {
                required: true,
                minlength: 8
            },
            guest_name: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            telephone: {
                required: lg('anonimUser_telephone_required'),
                minlength: lg('anonimUser_telephone_minlength'),
            },
            guest_name: {
                required: lg('anonimUser_name_required'),
                minlength: lg('anonimUser_name_minlength')
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

}

$(document).ready(function () {
    init();
    initPhoneMask();
});

var timeoutcard0, timeoutcard1, timeoutcard2;

$('#registerUser').on('submit', function () {
    var action = 'index.php?route=account/login';
    var data = {};
    var $form = $(this);

    // check phone
    if (!check_phone($form)) {
        console.log('check_phone error');
        return false;
    }

    // check validate
    if (!check_validate($form)) {
        console.log('check_validate error');
        return false;
    }

    data['sect'] = $form.find('input[name=sect]').val();
    data['return'] = $form.find('input[name=return]').val();

    data['firstname'] = $form.find('input[name=firstname]').val();
    data['lastname'] = $form.find('input[name=lastname]').val();
    data['telephone'] = $form.find('input[name=telephone]').intlTelInput('getNumber');
    data['email'] = $form.find('input[name=email]').val();
    data['password'] = $form.find('input[name=password]').val();

    var newsletter = $form.find('input[name=newsletter]');
    if (newsletter.is(':checked')) {
        data['newsletter'] = 1;
    } else {
        data['newsletter'] = 0;
    }

    $('.errors-fields').each(function () {
        $(this).html('');
    });

    $('.register-block-checkout .alert').remove();

    $form.find('.error').removeClass('.error');
    $form.find('.c-info__btn-holder input').prop('disabled', true);

    $.ajax({
        url: action,
        data: data,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $form.find('.c-info__btn-holder input').prop('disabled', false);

            if (typeof data.responseJSON.ok === 'undefined')
                return;

            if (data.responseJSON.ok == true) {
                if (typeof data.responseJSON.redirect !== 'undefined') {
                    location.href = data.responseJSON.redirect;
                }
            }

            if (data.responseJSON.ok == false) {
                if (typeof data.responseJSON.error !== 'undefined') {

                    $.each(data.responseJSON.error, function (k, v) {
                        //console.log(k);
                        if (k == 'warning') {
                            $('.register-block-checkout').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                            clearTimeout(timeoutcard0);
                            timeoutcard0 = setTimeout(function () {
                                $('.alert').fadeOut(1000, function () {
                                    $(this).remove();
                                });
                            }, 2000);

                        } else {
                            $form.find('input[name=' + k + ']').addClass('error');

                            var error_class = $form.find('input[name=' + k + ']').attr('data-error');
                            $form.find(error_class).html(v);
                        }
                    });
                }
            }


        }
    });

    return false;
});

$('#loginUser').on('submit', function () {
    var action = 'index.php?route=account/login';
    var data = {};
    var $form = $(this);

    // check phone
    if (!check_phone($form)) {
        return false;
    }

    // check validate
    if (!check_validate($form)) {
        return false;
    }

    data['sect'] = $form.find('input[name=sect]').val();
    data['return'] = $form.find('input[name=return]').val();
    data['email'] = $form.find('input[name=email]').val();
    data['password'] = $form.find('input[name=password]').val();


    $('.errors-fields').each(function () {
        $(this).html('');
    });

    $('.login-block-checkout .alert').remove();

    $form.find('.error').removeClass('.error');
    $form.find('.contacts__btn').prop('disabled', true);

    $.ajax({
        url: action,
        data: data,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $form.find('.contacts__btn').prop('disabled', false);

            if (typeof data.responseJSON.ok === 'undefined')
                return;

            if (data.responseJSON.ok == true) {
                if (typeof data.responseJSON.redirect !== 'undefined') {
                    location.href = data.responseJSON.redirect;
                }
            }

            if (data.responseJSON.ok == false) {
                if (typeof data.responseJSON.error !== 'undefined') {

                    $.each(data.responseJSON.error, function (k, v) {
                        //console.log(k);
                        if (k == 'warning') {
                            $('.login-block-checkout').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                            clearTimeout(timeoutcard1);
                            timeoutcard1 = setTimeout(function () {
                                $('.alert').fadeOut(1000, function () {
                                    $(this).remove();
                                });
                            }, 2000);

                        } else {
                            $form.find('input[name=' + k + ']').addClass('error');

                            var error_class = $form.find('input[name=' + k + ']').attr('data-error');
                            $form.find(error_class).html(v);
                        }
                    });
                }
            }


        }
    });

    return false;
});

$('#anonimUser').on('submit', function (e) {
    e.preventDefault();

    var action = 'index.php?route=account/login';
    var data = {};
    var $form = $(this);

    // check phone
    if (!check_phone($form)) {
        return false;
    }

    // check validate
    if (!check_validate($form)) {
        return false;
    }

    // Check if fields are filled
    var guestName = $form.find('input[name=guest_name]').val();
    var telephone = $form.find('input[name=telephone]').val();

    if (guestName === '' || telephone === '') {
        return false;
    }

    data['sect'] = $form.find('input[name=sect]').val();
    data['return'] = $form.find('input[name=return]').val();
    data['guest_name'] = $form.find('input[name=guest_name]').val();
    data['telephone'] = $form.find('input[name=telephone]').intlTelInput('getNumber');


    $('.errors-fields').each(function () {
        $(this).html('');
    });

    $('.login-block-checkout .alert').remove();

    $form.find('.error').removeClass('.error');
    $form.find('.btn--submit').prop('disabled', true);

    $.ajax({
        url: action,
        data: data,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {

            $form.find('.btn--submit').prop('disabled', false);

            if (typeof data.responseJSON === 'undefined' || typeof data.responseJSON.ok === 'undefined')
                return;

            if (data.responseJSON.ok == true) {
                if (typeof data.responseJSON.redirect !== 'undefined') {
                    location.href = data.responseJSON.redirect;
                }
            }

            if (data.responseJSON.ok == false) {
                if (typeof data.responseJSON.error !== 'undefined') {

                    $.each(data.responseJSON.error, function (k, v) {
                        //console.log(k);
                        if (k == 'warning') {
                            $('.login-block-checkout').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                            clearTimeout(timeoutcard2);
                            timeoutcard2 = setTimeout(function () {
                                $('.alert').fadeOut(1000, function () {
                                    $(this).remove();
                                });
                            }, 2000);

                        } else {
                            $form.find('input[name=' + k + ']').addClass('error');

                            var error_class = $form.find('input[name=' + k + ']').attr('data-error');
                            $form.find(error_class).html(v);
                        }
                    });
                }
            }
        }
    });

    return false;
});