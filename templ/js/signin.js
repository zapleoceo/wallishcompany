function initPasswordShowToggle(id, inputId) {
  $(id).on('click', function() {
    if($(inputId).attr('type') === 'password' ) {
        $(inputId).attr('type', 'text');
        $(id).addClass('visible');
    } else {
        $(inputId).attr('type', 'password');
        $(id).removeClass('visible');
    }
  });
}

function initloginRegisterToggle() {
  $('body').on('click', '#createUserButton, #loginUserButton', function(){
    var $main = $('body').find('main.main.main--contacts');
    if(this.id === 'createUserButton') {
      $main.addClass('translatedLeft');
      $('footer.footer').removeClass('fix-contacts-footer-height');
    }
    if(this.id === 'loginUserButton') {
      $main.removeClass('translatedLeft');
      $('footer.footer').addClass('fix-contacts-footer-height');
    }
  });
}
function fixFooterHeight() {
  $('footer.footer').addClass('fix-contacts-footer-height');
}

function onSubmits() {
    $('#contactFormRegister').on('submit', function(){
        
        $(this).find('input').each(function(i, el){
            var input = $(el).val();
            input = input.trim();
            if(input === '') {
                $(el).addClass('error empty');
                $(el).closest('.intl-tel-input').addClass('error');
            }
        });

        $(this).find('input').each(function(i, el){
            if( $(el).hasClass('error') ) {
                console.log('has errors');
                return false;
            }
        });

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


        $('.errors-fields').each(function(){
            $(this).html('');
        });

        $('.contacts--register .alert').remove();

        $form.find('.error').removeClass('.error');
        $form.find('.btn--register').prop('disabled', true);

        var timeoutcard2;

        $.ajax({
            url: action,
            data: data,
            method: 'POST',
            dataType: 'json',
            complete: function (data) {
                $form.find('.btn--register').prop('disabled', false);

                if (typeof data.responseJSON.ok === 'undefined')
                    return;

                if (data.responseJSON.ok == true) {
                    if (typeof data.responseJSON.redirect !== 'undefined') {
                        location.href = data.responseJSON.redirect;
                    }
                }

                if (data.responseJSON.ok == false) {
                    if (typeof data.responseJSON.error !== 'undefined') {

                        $.each(data.responseJSON.error, function(k,v){
                            //console.log(k);
                            if (k == 'warning') {
                                $('.contacts--register').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                                clearTimeout(timeoutcard2);
                                timeoutcard2 = setTimeout(function () {
                                    $('.alert').fadeOut(1000, function () {
                                        $(this).remove();
                                    });
                                }, 2000);

                            } else {
                                $form.find('input[name='+ k +']').addClass('error');

                                var error_class = $form.find('input[name='+ k +']').attr('data-error');
                                $form.find(error_class).html(v);
                            }
                        });
                    }
                }
            }
        });

        return false;
    });

    var timeoutcard;
    $('#contactForm').on('submit', function(){
        
        $(this).find('input').each(function(i, el){
            var input = $(el).val();
            input = input.trim();
            if(input === '') $(el).addClass('error empty');
        });

        $(this).find('input').each(function(i, el){
            if( $(el).hasClass('error') ) {
                console.log('has errors');
                return false;
            }
        });

        var action = 'index.php?route=account/login';
        var data = {};
        var $form = $(this);

        // check validate
        if (!check_validate($form)) {
            return false;
        }

        data['sect'] = $form.find('input[name=sect]').val();
        data['email'] = $form.find('input[name=email]').val();
        data['password'] = $form.find('input[name=password]').val();


        $('.errors-fields').each(function(){
            $(this).html('');
        });

        $('.contacts--login .alert').remove();

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

                        $.each(data.responseJSON.error, function(k,v){
                            //console.log(k);
                            if (k == 'warning') {
                                $('.contacts--login').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + v + '</div>');

                                clearTimeout(timeoutcard);

                                timeoutcard = setTimeout(function () {
                                    $('.alert').fadeOut(1000, function () {
                                        $(this).remove();
                                    });
                                }, 2000);

                            } else {
                                $form.find('input[name='+ k +']').addClass('error');

                                var error_class = $form.find('input[name='+ k +']').attr('data-error');
                                $form.find(error_class).html(v);
                            }
                        });
                    }
                }



            }
        });

        return false;
    });
}

$(document).ready(function() {
  fixFooterHeight();
  initloginRegisterToggle();
  initPasswordShowToggle('#passVisible','#pass');
  initPasswordShowToggle('#r-passVisible','#registerPass');
  inputPhoneValidate('#phone');
  initPhoneMask();
  ckeckInputValue();

  $("#contactForm").validate({
    rules: {
        email: {
            email:true,
            required: true
        }
    },
    submitHandler: function(form) {
        var inputs = $(form).find("input");
        inputs.each(function(i, el){
            if($(el).val() === '') {
                $(el).addClass('error empty');
                $(el).removeClass('valid');
            }
        });
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    },
    showErrors: function (errorMap, errorList) { 
        //console.log(this); 
        if(errorList.length !== 0) {
            if(errorList[0].method !== "required") {
                this.defaultShowErrors();
            } 
        } else {
            if(this.toHide.length !== 0) this.toHide[0].remove();
            this.currentElements.removeClass('error');
        }    
    },
  });

  $("#contactFormRegister").validate({
        rules: {
            email : {
                required: true,
                email: true
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
        },
        submitHandler: function(form) {
            //console.log(form);
            var inputs = $(form).find("input");
            console.log(form);
            inputs.each(function(i, el){
                if($(el).val() === '') {                  
                    $(el).addClass('error empty');
                    $(el).removeClass('valid');
                }
            });
        },
        showErrors: function (errorMap, errorList) { 
            //console.log(errorList); 
            if(errorList.length !== 0) {
                if(errorList[0].method !== "required") {
                    this.defaultShowErrors();
                } 
            } else {
                if(this.toHide.length !== 0) this.toHide[0].remove();
                this.currentElements.removeClass('error');
            }    
        },
    });

  onSubmits();

});

