$("#contactForm").validate({
    rules: {
        uname: {
            required: true,
            minlength: 3
        },
        surname: {
            required: true
        },
        email: {
            required: true,
            email:true
        },
        phone: {
            required: true,
            minlength: 12
        },
        password1: {
            required: true,
            minlength: 6
        },
        password2: {
            required: true,
            minlength: 6
        }
    },
    messages: {
        uname:{
            required: "Enter a your name",
            minlength: "Enter at least 3 characters"
        },
        surname: {
            required: "Enter a your surname",
        },
        email: {
            required: "Enter a your email address",
            email: "Enter a valid email address"
        },
        phone: {
            required: "Enter your phone number"
        },
        password1: {
            required: "Enter your password",
            minlength: "Enter at least 6 characters"
        },
        password2: {
            required: "Enter your password",
            minlength: "Enter at least 6 characters"
        }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});

$('#subscribe-input').click( function() {
    $('.account__pass').toggle(this.checked);
});

const toggleShowPass = (idLabel, inputId) => {
    $(idLabel).mousedown( function() {
        $(inputId).attr('type', 'text');
    });

    $(idLabel).mouseup( function() {
        $(inputId).attr('type', 'password');
    });

    $(idLabel).on('touchstart', function() {
        $(inputId).attr('type', 'text');
    });

    $(idLabel).on('touchend', function() {
        $(inputId).attr('type', 'password');
    });
};

function initForm() {
    var timeoutcard;

    $('#contactForm').on('submit', function(e){

        e.preventDefault();



        var $form = $(this);

        // check phone
        if (!check_phone($form)) {
            console.log('check_phone');
            return false;
        }

        // check phone
        if (!check_validate($form)) {
            console.log('check_validate');
            return false;
        }


        var url = $form.attr('action');
        var method = $form.attr('method');
        var $btn = $form.find('.contacts__btn');

        var data = {};

        if ($form.find('input[name=firstname]').length)
            data['firstname'] = $form.find('input[name=firstname]').val();

        if ($form.find('input[name=lastname]').length)
            data['lastname'] = $form.find('input[name=lastname]').val();

        if ($form.find('input[name="custom_field[1]"]').length) {
            if (typeof data['custom_field'] === 'undefined')
                data['custom_field'] = {};

            data['custom_field'][1] = $form.find('input[name="custom_field[1]"]').val();
        }

        if ($form.find('select[name="custom_field[2]"]').length) {
            if (typeof data['custom_field'] === 'undefined')
                data['custom_field'] = {};

            data['custom_field'][2] = $form.find('select[name="custom_field[2]"]').val();
        }

        if ($form.find('input[name="custom_field[3]"]').length) {
            if (typeof data['custom_field'] === 'undefined')
                data['custom_field'] = {};

            data['custom_field'][3] = $form.find('input[name="custom_field[3]"]').val();
        }

        if ($form.find('input[name=telephone]').length)
            data['telephone'] = $form.find('input[name=telephone]').intlTelInput('getNumber');

        if ($form.find('input[name=email]').length)
            data['email'] = $form.find('input[name=email]').val();

        if ($form.find('input[name=repass]').length) {

            if ($form.find('input[name=repass]').is(':checked')) {
                data['repass'] = 1;

                if ($form.find('input[name=password]').length)
                    data['password'] = $form.find('input[name=password]').val();

                if ($form.find('input[name=confirm]').length)
                    data['confirm'] = $form.find('input[name=confirm]').val();
            } else {
                data['repass'] = 0;
            }
        }

        $btn.prop('disabled', true);

        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            data: data,
            success: function (json) {
                $btn.prop('disabled', false);

                if (typeof json.ok == 'undefined')
                    location.reload();

                if (json.ok == true && json['success']) {
                    $('body .main h1').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                clearTimeout(timeoutcard);

                timeoutcard = setTimeout(function () {
                    $('.alert').fadeOut(1000, function () {
                        $(this).remove();
                    });
                }, 2000);

                if (json.ok == true && json['repass']) {
                    if ($('#contactForm .checkbox__core').is(':checked')) {
                        $('#contactForm .checkbox__core').click();
                    }
                }

                if (json.ok == false && json['error']) {

                    $.each(json['error'], function(k, v){
                        var errorblock = $form.find('[name='+k+']').attr('data-error');
                        $form.find(errorblock).html(v);
                    });
                }

            }
        });

        return false;
    });
}

var date = new Date();
$('#bday').on('show', function(){
  $('#bday').addClass('valid');
});

// Bootstrap Datepicker Implementation
// $('#bday').datepicker({
//     format: "dd.mm.yyyy",
//     language: "ru",
//     autoclose: true,
//     todayHighlight: true,
//     toggleActive: true,
//     endDate: date
// });

document.addEventListener('DOMContentLoaded', function () {
        if (screen.width <= 1024) {
            // For mobile OS Dependent datepicker
            $('#bday').attr('type', 'date');
        } else {
            $('#bday').datepicker({
                dateFormat: 'yyyy-mm-dd'
            });
            // For laptop Air Datepicker
        }
    }
);

$(document).ready(function(){
  inputPhoneValidate('#phone');
  toggleShowPass('#passVisible1', '#pass1');
  toggleShowPass('#passVisible2', '#pass2');
  initPopupSelect('#gender');
  toggleAccount();
  initPhoneMask();
  initForm();
});