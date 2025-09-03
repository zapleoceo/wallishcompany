//################### show hide address input ukraine address 5/23/2018
function openAddForm (selector) {
  $(selector).on('click', e => {
    $('#addCardPopup').css('display', 'block');

    setTimeout( () => {
      $('#addCardPopup').css('opacity', '1');
    }, 50);
  });
}
function closeAddForm (selector) {
  $(selector).on('click', e => {
    $('#addCardPopup').css('opacity', '0');
  });
}
function openEditForm (selector) {
  $(selector).on('click', e => {
    $('#addCardPopup').css('display', 'block');
    setTimeout( () => {
      $('#addCardPopup').css('opacity', '1');
    }, 50);
  });
}

function init() {
  step4_action_save = $('.url-step4_action_save').text();
  url_checkout_confirm = $('.url_checkout_confirm').text();


  openAddForm('#addCard');
  openEditForm('.edit');
  closeAddForm('#closeCardEditing');
}


function getButton($content, payment, json) {

    $('.set-button').fadeOut(200);

    $.ajax({
        url: 'index.php?route=checkout/payment_method/getform',
        dataType: 'json',
        complete: function () {
            $('#button-payment-method').button('reset');
        },
        success: function (json) {
            // console.log(json);


            if (typeof json['ok'] == 'undefined' || json['ok'] == false)
                return false;

            if (typeof json['redirect'] != 'undefined')
                location.href = json.redirect;


            $('.set-button').html(json['html']);
            $('.set-button').fadeIn(200);

            // тут ставим disabled по ситуации
            //$('.confirm-but').addClass('disabled');

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


function createOrder($content, payment, json) {

    $.ajax({
        url: 'index.php?route=checkout/confirm',
        dataType: 'html',
        complete: function() {
            getButton($content, payment, json);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });


    //if (payment.val() == 'privat24' || payment.val() == 'wayforpay') { // wayforpay,privat24


   /* } else {


        if (is == false) {
            $.ajax({
                //url: 'index.php?route=checkout/confirm',
                url: 'index.php?route=checkout/payment_method/getform',
                dataType: 'json',
                complete: function () {
                    $('#button-payment-method').button('reset');
                },
                success: function (json) {
                    if (typeof json['ok'] == 'undefined' || json['ok'] == false)
                        return false;

                    if (typeof json['redirect'] != 'undefined')
                        location.href = json.redirect;


                    $insertBlock.html(json['html']);
                    $insertBlock.show();

                    $('.confirm-but').addClass('disabled');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } else {
            $('.confirm-but').removeClass('disabled');
        }

    }*/


}









function paymentSave($content, payment) {



    $.ajax({
        url: step4_action_save,
        data: {'payment_method' : payment.val(), 'agree': 1},
        method: 'POST',
        dataType: 'json',
        success: function(json) {
            $('.alert, .text-danger').remove();
            //$('.confirm-but').removeClass('wait');


            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('.main h1').after('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {

                createOrder($content, payment, json);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });



}

function getFormPay($content) {
    var payment = $('#payment input[name=payment]:checked');
    if (payment.length == 0) return false;

    paymentSave($content, payment);
}

$('body').on('click', '.confirm-but', function(e){
  e.preventDefault();

  var payment = $('#payment input[name=payment]:checked');
  if (payment.length == 0) return false;

  location.href = 'index.php?route=checkout/confirm/result';
  return false;
});

var step4_action_save, url_checkout_confirm;
$(document).ready(function(){
  init();
  togglePayment();
});

const togglePayment = () => {
    function handlerChange(selector) {
        const $id = $(selector).attr('id');
        const $content =  $(`div[aria-controls=${$id}]`);

        $('#payment').find('.activeStep4').removeClass('activeStep4');
        $('#payment').find('.activeStepLabel4').removeClass('activeStepLabel4');

        /*if ($id != 'pay_kievnal' && $id != 'pay_postponepayment' && $id != 'pay_pbcassa') {
            $content.addClass('activeStep4');
            getFormPay($content);
        } else {
            getFormPay($content, true);
        }*/

        getFormPay($content);

        //console.log($id);
        $('#' + $id + '_label').addClass('activeStepLabel4');
    }

    $('#payment').on('change', 'input.c-info__core', function(){
        if ($(this).is(':checked')) {
            handlerChange(this);
        }
    });

    const paymentMethods = $('#payment').find('input.c-info__core:checked');
    if (!paymentMethods.length)
        return false;

    handlerChange(paymentMethods);
}