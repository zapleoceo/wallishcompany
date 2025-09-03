//################### show hide address input ukraine address 5/23/2018
var delivery_type;

function openAddForm (selector, popup) {
  $(selector).on('click', function(e) {
    $(popup).css('display', 'block');

    setTimeout( function() {
      $(popup).css('opacity', '1');
    }, 50);
  });
}

function closeAddForm (selector, popup) {
  $(selector).on('click', function(e) {
    $(popup).css('opacity', '0');
    setTimeout( function() {
      $(popup).css('display', 'none');
    }, 500);
  });
}

function openEditForm (selector, popup) {
  $(selector).on('click', function(e) {
    $(popup).css('display', 'block');
    setTimeout( function() {
      $(popup).css('opacity', '1');
    }, 50);


      //var addressData = JSON.parse($(e.target).closest('.data-block').attr('data-address'));
      var $form = $(e.target).closest('.c-info__hidden-content').find('.hidden-popup__wrapper');
      var addressData = JSON.parse($(e.target).closest('.data-block').attr('data-address'));
      var isuk = $('input[name=coselect]:checked')[0].value;


      // украина
      if (isuk == 0) {
          var $shipping_type = $form.find('select[name=shipping_type]');
          if ($shipping_type.length)
              $shipping_type.val(addressData.data.custom_field.shipping_type).change();

          if (addressData.data.custom_field.shipping_type == 'novaposhta.novaposhta') {

              setTimeout(function() {
                  var $region = $form.find('select[name=region]');
                  if ($region.length)
                      $region.val(addressData.loc_info.location.country_id).change();
              }, 100);

              setTimeout(function(){
                  var $city_select = $form.find('select#city');
                  if ($city_select.length)
                      $city_select.val(addressData.loc_info.city.zone_id).change();
              }, 300);

              setTimeout(function(){
                  var $np_num = $form.find('select[name=npadress]');
                  if ($np_num.length)
                      $np_num.val(addressData.data.address_1).change();
              }, 500);

          } else {
              var $region = $form.find('select[name=region]');
              if ($region.length)
                  $region.html('<option value="none">Выбрать</option>');

              var $city_select = $form.find('select[name=city-select]');
              if ($city_select.length)
                  $city_select.html('<option value="none">Выбрать</option>');

              var $address = $form.find('input[name=address]');
              if ($address.length)
                  $address.val(addressData.data.address_1).change();
          }
      }

      // не украина
      else {
          setTimeout(function() {
              var $country = $form.find('select[name=country]');
              if ($country.length)
                  $country.val(addressData.loc_info.country.id).change();
          }, 100);

          var $state = $form.find('input[name=state]');
          $state.addClass('valid');
          if ($state.length)
              $state.val(addressData.data.custom_field.state).change();

          var $city = $form.find('input[name=city]');
          $city.addClass('valid');
          if ($city.length)
              $city.val(addressData.data.city).change();

          var $address = $form.find('input[name=address]');
          $address.addClass('valid');
          if ($address.length)
              $address.val(addressData.data.address_1).change();

          var $zipcode = $form.find('input[name=zipcode]');
          $zipcode.addClass('valid');
          if ($zipcode.length)
              $zipcode.val(addressData.data.postcode).change();
      }

      // другие
      var $phone = $form.find('input[name=phone]');
      if ($phone.length)
          $phone.val(addressData.data.address_2).change();

      var $company = $form.find('input[name=company]');
      $company.addClass('valid');
      if ($company.length)
          $company.val(addressData.data.company).change();

      var $firstname = $form.find('input[name=firstname]');
      $firstname.addClass('valid');
      if ($firstname.length)
          $firstname.val(addressData.data.firstname).change();

      var $lastname = $form.find('input[name=lastname]');
      $lastname.addClass('valid');
      if ($lastname.length)
          $lastname.val(addressData.data.lastname).change();

      var $id = $form.find('input[name=id]');
      if ($id.length)
          $id.val(addressData.address_id);

      var $default = $form.find('input[name=default]');
      if ($default.length) {
          if (addressData.default == 1 ) {
              $default.prop('checked', true);
          } else {
              $default.prop('checked', false);
          }
      }

      var $company = $form.find('input[name=sendcompany]');
      if ($company.length) {
          if (addressData.data.custom_field.sendcompany == '1') {
              $company.prop('checked', true);
          } else {
              $company.prop('checked', false);
          }
      }




  });
}


function getDataSaveForm($form) {
    var data = {};

    if ($form.find('input[name=address_id]').length) {
        data['address_id'] = $form.find('input[name=address_id]:checked')[0].value;
    } else {
        data['address_id'] = 0;
    }

    data['type'] = $('input[name=coselect]:checked')[0].value;

    data['shipping_type'] = delivery_type;

    var $default = $form.find('input[name=default]');
    if (Number($form.attr('data-id'))  > 0) {
        data['id'] = Number($form.attr('data-id'));
    }

    if ($form.find('input[name=comment]').length) {
        data['comment'] = $form.find('input[name=comment]')[0].value;
    }

    var $default = $form.find('input[name=default]');
    if (Number($form.attr('data-id'))  > 0) {
        data['id'] = Number($form.attr('data-id'));
    }

    if ($default.is(':checked')) {
        data['default'] = 1;
    }

    return data;
}

function formSaveValidate($save) {
    var data = getDataSaveForm($save);

    var errors = [];
    if (data['shipping_type'] != 'pickup.pickup' && data['address_id'].length < 1)
        errors[errors.length] = 'address_id';

    if (errors.length > 0) {
        // console.log(errors);

        for(key in errors) {
            $save.find('input[name='+errors[key]+']').addClass('errorbak');
            $save.find('select[name='+errors[key]+']').addClass('errorbak');
        }

        return false;
    }

    return true;
}

function getDataForm($form) {
    var data = {};

    if ($('.countryType:checked').attr('id') == 'ukraineDelivery') {
        // для украины = 0

        data['type'] = 0;


        if (delivery_type == 'novaposhta.novaposhta') {
            data['country'] = $form.find('input[name=country]')[0].value;
            data['region'] = $form.find('select[name=region]')[0].value;
            data['city'] = $form.find('input[name=city]')[0].value;

            data['address'] = $form.find('select[name=npadress]')[0].value;

        } else {
            data['country'] = $form.find('input[name=country]')[0].value;
            data['region'] = 300009;
            data['city'] = 'Киев';

            data['address'] = $form.find('input[name=address]')[0].value;
        }

        data['phone'] = $form.find('input[name=phone]').intlTelInput('getNumber');
        data['firstname'] = $form.find('input[name=firstname]')[0].value;
        data['lastname'] = $form.find('input[name=lastname]')[0].value;
        data['shipping_type'] = delivery_type;

        $sendcompany = $form.find('input[name=sendcompany]');
        if ($sendcompany.is(':checked')) {
            data['sendcompany'] = 1;
            data['company'] = $form.find('input[name=company]')[0].value;
        } else {
            data['sendcompany'] = 0;
        }

    } else {
        data['type'] = 1;
        data['country'] = $form.find('select[name=country]')[0].value;
        data['state'] = $form.find('input[name=state]')[0].value;
        data['city'] = $form.find('input[name=city]')[0].value;
        data['address'] = $form.find('input[name=address]')[0].value;
        data['zipcode'] = $form.find('input[name=zipcode]')[0].value;
        data['phone'] = $form.find('input[name=phone]').intlTelInput('getNumber');
        data['company'] = $form.find('input[name=company]')[0].value;
        data['firstname'] = $form.find('input[name=firstname]')[0].value;
        data['lastname'] = $form.find('input[name=lastname]')[0].value;

        data['shipping_type'] = 'xshipping.xshipping1';
    }

    if (Number($form.find('input[name=id]')[0].value)  > 0) {
        data['id'] = Number($form.find('input[name=id]')[0].value);
    }

    var $default = $form.find('input[name=default]');
    if ($default.is(':checked')) {
        data['default'] = 1;
    }

    return data;
}

function formValidate($save) {
    var data = getDataForm($save);

    var errors = [];

    if (data['type'] == 0) {


        if (delivery_type == 'novaposhta.novaposhta') {
            if (data['region'].length < 1 || data['region'] == 'none')
                errors[errors.length] = 'region';

            if (data['city'].length < 1 || data['city'] == 'none')
                errors[errors.length] = 'city-select';

            if (data['address'].length < 1 || data['address'] == 'none')
                errors[errors.length] = 'np_num';
        } else {
            if (data['address'].length < 1)
                errors[errors.length] = 'address';
        }


        if (data['phone'].length < 1)
            errors[errors.length] = 'phone';

        if (data['sendcompany'] == 1 && data['company'].length < 1)
            errors[errors.length] = 'company';

        if (data['firstname'].length < 1)
            errors[errors.length] = 'firstname';

        if (data['lastname'].length < 1)
            errors[errors.length] = 'lastname';
    }

    if (data['type'] == 1) {
        if (data['country'].length < 1)
            errors[errors.length] = 'country';

        if (data['state'].length < 1)
            errors[errors.length] = 'state';


        if (data['city'].length < 1)
            errors[errors.length] = 'city';

        if (data['address'].length < 1)
            errors[errors.length] = 'address';

        if (data['zipcode'].length < 1)
            errors[errors.length] = 'zipcode';

        if (data['phone'].length < 1)
            errors[errors.length] = 'phone';

        if (data['company'].length < 1)
            errors[errors.length] = 'company';

        if (data['firstname'].length < 1)
            errors[errors.length] = 'firstname';

        if (data['lastname'].length < 1)
            errors[errors.length] = 'lastname';
    }

    if (errors.length > 0) {
        //console.log(errors);

        for(key in errors) {
            $save.find('input[name='+errors[key]+']').addClass('errorbak');
            $save.find('select[name='+errors[key]+']').addClass('errorbak');
        }

        return false;
    }

    return true;
}

function addresses_select() {

    $('.adr-areas').each(function(){
        var checked = $(this).find('input:checked');
        if (checked.length == 0) {
            var $inp = $(this).find('input:first');
            $inp.prop('checked', true);
            $inp.closest('.holiday-radio').find('label').addClass('active');
        }
    });
}

$("body").on('focus, change', 'input, select', function(e){
    $(this).css('border', 'none');
    $(this).css('border-bottom', '1px solid #f1f1f1');
});

$("body").on('submit', 'form', function(){
    return false;
});


$("body").on('click', '.save-adress', function(e){

    var $block = $(this).closest('form');

    // check phone
    if (!check_phone($block)) {
        console.log('check_phone');
        return false;
    }

    // check validate
    if (!check_validate($block)) {
        console.log('check_validate');
        return false;
    }

    if (!formSaveValidate($block)) {
        console.log('formSaveValidate');
        return false;
    }

    var dataparams = getDataSaveForm($block);

    $block.find('.save-adress').addClass('wait');
    $block.find('.hidden-content__add-address-btn').css('border', 'none');

    $.ajax({
        url: url_next_step,
        data: dataparams,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $block.find('.save-adress').removeClass('wait');

            if (typeof data.responseJSON == 'undefined')
                return;

            if(data.responseJSON.ok != true) {


                if (typeof data.responseJSON.error_address_id !== 'undefined' && data.responseJSON.error_address_id == 1) {
                    $block.find('.hidden-content__add-address-btn').addClass('error-adress');
                }

                if (typeof data.responseJSON.errors !== 'undefined')
                    for (ke in data.responseJSON.errors) {
                        if (typeof data.responseJSON.errors[ke] == 'undefined')
                            continue;

                        $block.find('input[name=' + data.responseJSON.errors[ke] + ']').addClass('error');
                        $block.find('select[name=' + data.responseJSON.errors[ke] + ']').addClass('error');
                    }

            } else {

                var url = location.href;
                url = url.replace('&step=3', '');
                url = url.replace('?step=3', '');

                url = url.replace('&step=4', '');
                url = url.replace('?step=4', '');
                location.href = url;
            }
        }
    });

    return false;


});

$("body").on('click', '.save-form', function(e){
    e.preventDefault();

    var $block = $(this).closest('.block-form');

    // check phone
    if (!check_phone($block)) {
        return false;
    }

    // check validate
    if (!check_validate($block)) {
        return false;
    }

    if (!formValidate($block))
        return false;


    var dataparams = getDataForm($block);

    $block.find('.save-form').addClass('wait');
    $.ajax({
        url: urlsave,
        data: dataparams,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $block.find('.save-form').removeClass('wait');

            if (typeof data.responseJSON == 'undefined')
                return;

            if(data.responseJSON.ok != true) {

                if (typeof data.responseJSON.errors != 'undefined')
                    for (ke in data.responseJSON.errors) {
                        if (typeof data.responseJSON.errors[ke] == 'undefined')
                            continue;

                        $block.find('input[name=' + data.responseJSON.errors[ke] + ']').addClass('errorbak');
                        $block.find('select[name=' + data.responseJSON.errors[ke] + ']').addClass('errorbak');
                    }

            } else {
                location.reload();
                // $block.attr('data-id', data.responseJSON.id);
                //$('#closeUkraineAdress,#closeInternationalAdress').click();
            }
        }
    });

    return false;
});


$('body').on('change', '.deliveryType', function(){
    delivery_type = $(this).val();

    if (delivery_type == 'novaposhta.novaposhta') {
        $('#city').change();

        //$('#addDeliveryForm .adress-field').hide();
        //$('#addDeliveryForm .novaposhta-field').show();
    } else if(delivery_type == 'free.free') {
        //$('#addDeliveryForm .adress-field').show();
        //$('#addDeliveryForm .novaposhta-field').hide();
    } else if(delivery_type == 'samovivoz') {

    }

    addresses_select();
});

$('body').on('change', '.countryType', function(){
    var type = $(this).val();

    if (type == 0) {
        var $checked = $('input[name=shipping_type]:checked');
        if ($checked.length == 0 || $checked.val() == 'xshipping.xshipping1')
            $('input[name=shipping_type]:first').prop('checked', true).change();
    }

    addresses_select();
});



$('body').on('change', '#city', function(){

    if ($(this).val() == 'none') {
        return;
    }

    var $form = $(this).closest('.block-form');

    var cityname = $(this).find('option[value=' + $(this).val() + ']')[0].text;
    $form.find('input[name=city]').val(cityname);

    if (delivery_type != 'novaposhta.novaposhta')
        return false;

    var $elem = $(this);
    $.getJSON( url_get_np_adress, {'zone_id' : $elem.val()}, function( data, status, xhr ) {
        if (data.ok != true) {
            $elem.addClass('errorbak');
            return;
        }

        $elem.css('border', 'none');
        $elem.css('border-bottom', '1px solid #f1f1f1');
        var options = '';
        $.each(data.items, function(k, v){
            options += '<option value="' + v.name + '">' + v.name + '</option>';
        });

        $form.find('#deliveryNova').html(options);
    });

});

$('body').on('change', '#region', function(){
    var $form = $(this).closest('.block-form');
    if ($(this).val() == 'none'){
        $form.find('#city').html('<option value="none">Выбрать город</option>');
        return;
    }


    //$('#addDeliveryForm input[name=city_name]').val($(this).val());

    var $elem = $(this);
    $.getJSON( url_get_cities, {'country_id' : $elem.val()}, function( data, status, xhr ) {
        if (data.ok != true) {
            $form.find('#city').html('<option value="none">Выбрать город</option>');
            //$elem.addClass('errorbak');
            return;
        }

        //$elem.css('border-bottom', '1px solid #f1f1f1');
        var options = '';
        $.each(data.items, function(k, v){
            options += '<option value="' + v.zone_id + '">' + v.name + '</option>';
        });

        $form.find('#city').html(options);
        $form.find('#city').change();
    });
});

function init() {
    api = $(".geo-data-api").text();
    url = $(".geo-data-url").text();
    urlsave = $(".geo-data-urlsave").text();
    url_get_np_adress = $(".geo-data-url_get_np_adress").text();
    url_get_cities = $(".geo-data-url_get_cities").text();
    url_next_step = $(".url-next-step").text();

    openAddForm('#addNovaPochtaBtn', '#novaPochtaPopup');
    openEditForm('.editnova', '#novaPochtaPopup');
    closeAddForm('#closeNovaPopup', '#novaPochtaPopup');

    openAddForm('#addCurierBtn', '#curierPopup');
    openEditForm('.editcurier', '#curierPopup');
    closeAddForm('#closeCurierPopup', '#curierPopup');

    openAddForm('#addInternationalBtn', '#internationalPopup');
    openEditForm('.editinter', '#internationalPopup');
    closeAddForm('#closeInternationalPopup', '#internationalPopup');

    $('.deliveryType').each(function(){
        if ($(this).is(':checked')) {
            $(this).change();
        }
    });

    $('#city').change();

    addresses_select();

    if ($('#internationalDelivery:checked').attr('id') == 'internationalDelivery') {
        $('.deliveryType').each(function(){
            $(this).prop('checked', false);
        });

        delivery_type = 'xshipping.xshipping1';

        $('.deliveryType[value="xshipping.xshipping1"]').attr('checked', 'checked');

    } else {

        if (typeof delivery_type !== 'undefined') {
            delivery_type = $('.deliveryType:checked').val();
        }
    }
}

$('#internationalDelivery').on('change', function(){

    if ($(this).attr('id') == 'internationalDelivery') {
        $('.deliveryType').each(function(){
            $(this).prop('checked', false);
        });

        $('.deliveryType[value="xshipping.xshipping1"]').prop('checked', true);

    } else {
        $('.deliveryType').each(function(){
            $(this).prop('checked', false);
        });

        $('.deliveryType:first').prop('checked', true);
    }

    delivery_type = $('.deliveryType:checked').val();
});

function closeAllPopup() {
  var $popups = $('div.c-info__user-info-holder').find('div.hidden-popup');
  $('div.c-info__user-info-holder').on('click', 'label.c-info__label', function(){
    $popups.hide();
  });
}
function ukrNovaCheck() {
  var $label0 = $('#subscribe-label_nova_0');
  var $label1 = $('#subscribe-label_nova_1');
  var $input0 = $('#subscribe-input_nova_0');
  var $input1 = $('#subscribe-input_nova_1');

  if($input0.attr('checked') === 'checked') {
    $label0.find('.icon').css('display', 'block');
  }
  if($input1.attr('checked') === 'checked') {
    $label1.find('.icon').css('display', 'block');
  }
  $label0.on('click', function(){
    toggleAttr($input0, $label0);
  });
  $label1.on('click', function(){
    toggleAttr($input1, $label1);
  });

  function toggleAttr(checkbox, label) {
    if(checkbox.attr('checked') === 'checked') {
      checkbox.removeAttr('checked');
      label.find('.icon').css('display', 'none');
    } else {
      checkbox.attr('checked', 'checked');
      label.find('.icon').css('display', 'block');
    }
  }
}
var url, api, urlsave, url_get_np_adress, url_next_step, url_get_cities;

function initCompanyToggle() {
  var $companyInput = $('input#subscribe-input_nova_1');
  var $wrapper = $('div#novaPochtaPopup');
  $wrapper.addClass('hide-company');
  var checked = $companyInput.is(':checked');
  $companyInput.on('change', function(e){
    console.log(e);
    $wrapper.toggleClass('hide-company');
  });
}

function initCartSelect(selector) {
  initPopupSelect(selector);
  $(selector).on('select2:open', function(e){
    $('.select2-results__options').addClass('cart');
  });
}

$(document).ready(function () {
    init();
    ukrNovaCheck();
    initRadioButtons();
    closeAllPopup();
    initCartSelect('#region');
    initCartSelect('#city');
    initCartSelect('#deliveryNova');
    initCartSelect('#country');
    initPhoneMask();

    // initPopupSelect('#region');
    // initPopupSelect('#city');
    // initPopupSelect('#deliveryNova');
    // initPopupSelect('#country');
    initCompanyToggle();
});