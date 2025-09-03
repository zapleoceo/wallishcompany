
function isEmpty(obj) {


    return Object.keys(obj).length === 0;
}

function findPlaceholder($input) {
    var count = 0;
    var int = setInterval(function() {
        count++;

        var placehold = $input.attr('placeholder');

        if (count > 200) {
          clearInterval(int);
          return true;
        }

        if (typeof placehold !== 'undefined') {
            setPlaceholder($input, placehold);
            clearInterval(int);
        }
    }, 50);
}

function setPlaceholder($input, placeholder) {
    placeholder = placeholder.replace(/\d/g, '9');
    //$input.inputmask(placeholder);
}

function changeCountryInput($input) {
    $input.on("countrychange", function(e, countryData) {
        var placehold = $input.attr('placeholder');
        placehold = placehold.replace(/\d/g, '9');
        $input.inputmask(placehold);
    });
}

function validateChekToplace($input, placehold) {
    var val = $input.val();

    placehold = placehold.replace(/\d/g, '9');
    val = val.replace(/\d/g, '9');

    if (val == placehold) {
        $input.removeClass('error');
        $input.change();
        return true;
    }

    return false;
}

function validateFindPlaceholder($input) {

    var count = 0;
    var int2 = setInterval(function() {
        count++;

        var placehold = $input.attr('placeholder');

        if (count > 200) {
            clearInterval(int2);
            return true;
        }

        if (typeof placehold !== 'undefined') {
            validateChekToplace($input, placehold);

            clearInterval(int2);
        }
    }, 100);
}

function validateMy() {
    setInterval(function(){
        if ($('.phone_input_checked').length) {
            $('.phone_input_checked').each(function () {
                if ($(this).hasClass('error')) {
                    validateFindPlaceholder($(this));
                }
            });
        }
    }, 100);
}

function initPhones() {
    var telInputs = $("#phone,[name=phone],[name=telephone]");

    $(telInputs).each(function () {
        var telInput = $(this);

        telInput.addClass('phone_input_checked');

        //telInput.intlTelInput("destroy");

        // initialise plugin
        telInput.intlTelInput({
            utilsScript: "/templ/intelmaska/build/js/utils.js"
        }).then(function(){
            var intId = setInterval(function(){
              var placehold = telInput.attr('placeholder');
              if(placehold) {
                placehold = placehold.replace(/\d/g, '9');
                telInput.inputmask(placehold);
                clearInterval(intId);
              }
            }, 50);
            changeCountryInput(telInput);
        });

        var reset = function () {
            telInput.removeClass("error");
            telInput.closest('.intl-tel-input').removeClass('phone-error');
            //errorMsg.addClass("hide");
            //validMsg.addClass("hide");
        };
        telInputs.on('change', function() {
          var error = telInputs.attr('aria-invalid');
          if(error === 'true') {
            telInputs.closest('.intl-tel-input').addClass('phone-error');
          } else {
            telInputs.closest('.intl-tel-input').removeClass('phone-error');
          }
        });
        telInputs.focus(function(){
          telInputs.closest('.intl-tel-input').addClass('focused');
        });
        telInputs.focusout(function(){
          telInputs.closest('.intl-tel-input').removeClass('focused');
        });
        /*// on blur: validate
        telInput.blur(function () {
            reset();
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    //telInput.removeClass("error");
                } else {
                    //telInput.addClass("error");
                }
            }
        });*/

        // on keyup / change flag: reset
        telInput.on("keyup change", reset);


        /*return;


        telInput.on('change', function () {
            var phone = $(this).val();
            var code = $(this).closest('.intl-tel-input').find('.country-list .active').attr('data-dial-code');
            if (typeof code === 'undefined')
                code = '';

            $(this).closest('.intl-tel-input').find('.phone_valid').val('+' + code + phone);
            // console.log('change');
        });

        // hidden phone valid
        ///setTimeout(function () {
        var valid_name = telInput.attr('name');

        if (!telInput.hasClass('phone_input_checked'))
            telInput.addClass('phone_input_checked');

        telInput.removeAttr('name');

        telInput.after('<input class="phone_valid" type="hidden" name="' + valid_name + '" value="">');

        telInput.change();

        addScrollToPhone(telInput);*/
        //}, 0);

    });
}

$(document).ready(function() {
    initPhones();
    // validateMy();
});