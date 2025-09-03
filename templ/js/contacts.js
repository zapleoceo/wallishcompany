$("#contactForm").validate({
    rules: {
        name: {
            required: true,
            minlength: 3
        },
        email: {
            required: true,
            email:true
        },
        phone: {
            required: true,
        },
        enquiry: {
            required: true,
        }
    },
    //For custom messages
    messages: {
        name:{
            required: lg('contactForm_name'),
            minlength: lg('contactForm_name_minlength')
        },
        email: {
            required: lg('contactForm_email')
        },
        phone: {
            required: lg('contactForm_phone')
        },
        enquiry: {
            required: lg('contactForm_enquiry')
        }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
       // $('.intl-tel-input').addClass('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});

function contactsSend(st) {

    if (st == 1) {

        // show alert
        var btn = $('#contactForm').find('.contacts__btn')
        btn.val('сообщение отправлено');
        btn.addClass('hover');
        setTimeout(function() {
          //$('#contactForm').find('textarea[name=enquiry]').val('');
          btn.val('отправить сообщение');
          btn.removeClass('hover');
        }, 3000);
    }

    if (st == 0) {
        // hide alert
    }
}

$('#contactForm').on('submit', function(){
    contactsSend(0);
console.log('send form');
    var action = 'index.php?route=information/contact';
    var data = {};
    var $form = $(this);

    // check phone
    if (!check_phone($form)) {
        return false;
    }

    // check phone
    if (!check_validate($form)) {
        return false;
    }

    data['name'] = $form.find('input[name=cl_name]').val();
    data['phone'] = $form.find('input[name=cl_phone]').intlTelInput('getNumber');
    data['email'] = $form.find('input[name=cl_email]').val();
    data['enquiry'] = $form.find('textarea[name=cl_enquiry]').val();


    $('.errors-fields').each(function(){
        $(this).html('');
    });

    $('.contacts-form .alert').remove();

    $form.find('.error').removeClass('.error');
    $form.find('.contacts__btn').prop('disabled', true);

    $.ajax({
        url: action,
        data: data,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $form.find('.contacts__btn').prop('disabled', false);

            if (typeof data.responseJSON === 'undefined')
                return;

            if (typeof data.responseJSON.ok === 'undefined')
                return;

            if (data.responseJSON.ok == true) {
                contactsSend(1);
            }

            if (data.responseJSON.ok == false) {
                if (typeof data.responseJSON.error !== 'undefined') {

                    $.each(data.responseJSON.error, function(k,v){
                        console.log(k);
                        if (k == 'warning') {
                            $('.contacts-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                        } else {
                            $form.find('input[name='+ k +']').addClass('error');

                            var error_class = $form.find('input[name='+ k +']').attr('data-error');
                            $form.find(error_class).html(v);

                            var error_class = $form.find('textarea[name='+ k +']').attr('data-error');
                            $form.find(error_class).html(v);
                        }
                    });
                }
            }
        }
    });

    return false;
});

inputPhoneValidate('input.contacts__input[type=tel]');


$(document).ready(function(){
  initPhoneMask();
});