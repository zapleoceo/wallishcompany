//################### show hide address input ukraine address 5/23/2018
function openAddForm (selector) {
    $(selector).on('click', function(e) {
        var target = e.target;
        var row = target.closest('.row');
        $(row).addClass('min-height');
        var children = [].slice.call(e.target.closest('.row').children);
        var editForm = children[2];
        var wrapper = editForm.children.item(0);
        var dCards = children.slice(3, children.length);
        $(dCards).css('opacity', '0');
        $(editForm).css('display', 'block');
        $(editForm).css('height', 'initial');
        $(wrapper).css('opacity', '1');
    });
}
function closeAddForm (selector) {
    $(selector).on('click', function(e) {
        var row = this.closest('.row');
        $(row).removeClass('min-height');
        var children = [].slice.call(e.target.closest('.row').children);
        var editForm = children[2];
        var dCards = children.slice(3, children.length);
        var wrapper = editForm.children.item(0);
        $(dCards).css('opacity', '1');
        $(wrapper).css('opacity', '0');

        setTimeout( function() {
            $(editForm).css('height', '0px');
            $(editForm).css('display', 'none');
        }, 300);
    });
}

function openEditForm (selector) {
    $(selector).on('click', function(e) {

        const $block = $(e.target).closest('.delivery');
        $block.find('form').css({'display': 'block', 'height': 'initial'});
        $block.find('.wrapper').css('opacity', '1');
        $block.find('.d-card').css('opacity', '0');

        //var id = $(e.target).data('id');

        var addressData = JSON.parse($(e.target).closest('.dcards').find('.data-block').attr('data-address'));
        var $form = $block.find('form');
        // console.log(addressData);

        var isuk = $block.find('.ukraine_set').length;

        // украина
        if (isuk == 1) {
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
                    var $city_select = $form.find('select[name=city-select]');
                    if ($city_select.length)
                        $city_select.val(addressData.loc_info.city.zone_id).change();
                }, 500);

                setTimeout(function(){
                    var $np_num = $form.find('select[name=np_num]');
                    if ($np_num.length)
                        $np_num.val(addressData.data.custom_field.address_id).change();
                }, 900);

            } else {
                var $region = $form.find('select[name=region]');
                if ($region.length)
                    $region.html('<option value="none">Выбрать</option>');

                var $city_select = $form.find('select[name=city-select]');
                if ($city_select.length)
                    $city_select.html('<option value="none">Выбрать</option>');

                var $address = $form.find('input[name=address]');
                if ($address.length) {
                  $address.addClass('valid');
                  $address.val(addressData.data.address_1).change();
                }
            }

            $('input[name=sendcompany]').change();
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
        //console.log(addressData.data.address_2);

        if ($phone.length) {
            //console.log('csdcsdc' + addressData.data.address_2);
            $phone[0].value = addressData.data.address_2;
            //console.log($phone[0].value);

            $phone.intlTelInput('setNumber', addressData.data.address_2);

            //initPhones();
        }

        var $company = $form.find('input[name=company]');
        $company.addClass('valid');
        if ($company.length)
            $company.val(addressData.data.company).change();

        var $firstname = $form.find('input[name=firstname]');
        if ($firstname.length)
            $firstname.val(addressData.data.firstname).change();

        var $lastname = $form.find('input[name=lastname]');
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


function getDataForm($form) {
    var data = {};

    if ($form.attr('id') == 'addDeliveryForm') {
        // для украины = 0

        data['type'] = 0;
        var shipping_type = $form.find('select[name=shipping_type]')[0].value;
        if (shipping_type == 'novaposhta.novaposhta') {
            data['country'] = $form.find('input[name=country]')[0].value;
            data['city'] = $form.find('input[name=city]')[0].value;
            data['address'] = $('select[name=np_num] option:selected').text();

            data['region_id'] = $form.find('select[name=region]')[0].value;
            data['city_id'] = $form.find('select[name=city-select]')[0].value;
            data['address_id'] = $form.find('select[name=np_num]')[0].value;
        } else {

            data['region'] = 300009;
            data['city'] = 'Киев';

            data['country'] = $form.find('input[name=country]')[0].value;
            data['address'] = $form.find('input[name=address]')[0].value;
        }

        data['phone'] = $form.find('input[name=phone]').intlTelInput('getNumber');
        data['firstname'] = $form.find('input[name=firstname]')[0].value;
        data['lastname'] = $form.find('input[name=lastname]')[0].value;
        data['shipping_type'] = $form.find('select[name=shipping_type]')[0].value;

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

        var shipping_type = $save.find('select[name=shipping_type]')[0].value;
        if (shipping_type == 'novaposhta.novaposhta') {
            if (data['address'].length < 1 || data['address'] == 'none')
                errors[errors.length] = 'np_num';

            if (data['region_id'].length < 1 || data['region_id'] == 'none')
                errors[errors.length] = 'region';

            if (data['city'].length < 1 || data['city'] == 'none')
                errors[errors.length] = 'city-select';

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

$("body").on('focus, change', '.delivery__data-holder input, .delivery__data-holder select', function(e){
    $(this).css('border', 'none');
    $(this).css('border-bottom', '1px solid #f1f1f1');
});

$("body").on('change', '.is_default', function(){
    var $block = $(this).closest('.dcards');
    var id = Number($block.attr('data-id'));
    if (!id) {
        return;
    }

    if(!$(this).is(':checked')) {
        $(this).prop('checked', true);
        return;
    }

    $('.area-adresses .is_default').prop('checked', false);
    $(this).prop('checked', true);
    $('div.dcards').find('p.d-card__c-text.by-defualt').removeClass('by-defualt');
    $block.find('p.d-card__c-text').addClass('by-defualt');
    $.ajax({
        url: urldefault,
        data: {'id': id },
        method: 'POST',
    });
});

$("body").on('click', '.remove', function(){
    if (!confirm(lang['confirm_delete']))
        return false;

    var $block = $(this).closest('.dcards');
    var id = Number($block.attr('data-id'));
    if (!id) {
        $block.hide(500, function(){
            $(this).remove();
        });

        return false;
    }

    $.ajax({
        url: urlremove,
        data: {'id': id },
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            //$(e.target).prop('disabled', false);

            if (typeof data.responseJSON == 'undefined') {
                return;
            }

            if(data.responseJSON.ok == true || data.responseJSON.ok == 'true' || data.responseJSON.ok) {

                $block.hide(500, function () {
                    $(this).remove();
                });
            }

            if (typeof data.responseJSON.warning != 'undefined') {
                alert(data.responseJSON.warning);
            }
        }
    });

});

$("body").on('click', '#addDelivery', function(e){
    e.preventDefault();

    var $block = $(this).closest('.delivery__data-holder');

    // check phone
    if (!check_phone($block)) {
        return false;
    }

    // check phone
    if (!check_validate($block)) {
        return false;
    }

    if (!formValidate($block))
        return false;

    var dataparams = getDataForm($block);
    $block.find('#addDelivery').addClass('wait');
    $.ajax({
        url: urlsave,
        data: dataparams,
        method: 'POST',
        dataType: 'json',
        complete: function (data) {
            $block.find('#addDelivery').removeClass('wait');

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
});

function init() {
    api = $(".geo-data-api").text();
    url = $(".geo-data-url").text();
    urlsave = $(".geo-data-urlsave").text();
    urlremove = $(".geo-data-urlremove").text();
    urldefault = $(".geo-data-urldefault").text();
    url_get_np_adress = $(".geo-data-url_get_np_adress").text();
    url_get_cities = $(".geo-data-url_get_cities").text();


    openAddForm('#addUkraineAdress');
    openAddForm('#addInternayionalAdress');
    openEditForm('.edit');

    closeAddForm('#closeUkraineAdress');
    closeAddForm('#closeInternationalAdress');

    $('#deliveryType').change();
    $('#city').change();
}


$('input[name=sendcompany]').on('change', function(){
    if($(this).is(':checked')) {
        $(this).closest('form').find('input[name=company]').closest('.col-12').show();
    } else {
        $(this).closest('form').find('input[name=company]').closest('.col-12').hide();
    }
});

$('#deliveryType').on('change', function(){
    if ($(this).val() == 'novaposhta.novaposhta') {
        $('#city').change();

        $('#addDeliveryForm .adress-field').hide();
        $('#addDeliveryForm .novaposhta-field').show();
    } else {
        $('#addDeliveryForm .adress-field').show();
        $('#addDeliveryForm .novaposhta-field').hide();
    }

    if ($(this).val() == 'free.free' || $(this).val() == 'pickup.pickup') {
        $('#addDeliveryForm #region').closest('.col-12').hide();
        $('#addDeliveryForm #city').closest('.col-12').hide();
    } else {
        $('#addDeliveryForm #region').closest('.col-12').show();
        $('#addDeliveryForm #city').closest('.col-12').show();
    }

    //$('#region').change();
});

$('#city').on('change', function(){
    if ($(this).val() == 'none') {

        if ($('#deliveryType').val() == 'novaposhta.novaposhta'){
            $('#deliveryNova').html('<option value="none">Выбрать отделение</option>');
        }

        return;
    }

    var cityname = $(this).find('option[value=' + $(this).val() + ']')[0].text;
    $('#addDeliveryForm input[name=city]').val(cityname);

    if ($('#deliveryType').val() != 'novaposhta.novaposhta')
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
            options += '<option value="' + v.city_id + '">' + v.name + '</option>';
        });

        $('#deliveryNova').html(options);
    });

});

$('#region').on('change', function(){
    if ($(this).val() == 'none'){
        $('#city').html('<option value="none">Выбрать город</option>');
        return;
    }


    //$('#addDeliveryForm input[name=city_name]').val($(this).val());

    var $elem = $(this);
    $.getJSON( url_get_cities, {'country_id' : $elem.val()}, function( data, status, xhr ) {
        if (data.ok != true) {
            $('#city').html('<option value="none">Выбрать город</option>');
            //$elem.addClass('errorbak');
            return;
        }

        //$elem.css('border-bottom', '1px solid #f1f1f1');
        var options = '';
        $.each(data.items, function(k, v){
            options += '<option value="' + v.zone_id + '">' + v.name + '</option>';
        });

        $('#city').html(options);
    });

});

var url, api, urlsave, urlremove, url_get_np_adress;

function defAddressColor(container) {
  var $cont = $(container).find('input.checkbox__core:checked');
  $(container).find('p.d-card__c-text.by-defualt').removeClass('by-defualt');
  if($cont) {
    $cont.closest('div.d-card__control-holder').find('p.d-card__c-text').addClass('by-defualt');
  }
}

function setAddress() {
  var address = $('footer.footer .address-group__address').text();
  var street = '';
  var $adrInput = $('#addDeliveryForm input[name=address]');
  if(address.indexOf('ул') !== -1) {
    street = address.slice(address.indexOf('ул'), address.length);
    street = street.replace('\n', ' ');
  }
  $('#deliveryType').on('select2:select', function(){
    if($(this).val() === 'pickup.pickup') {
      $adrInput.val(street);
      $adrInput.addClass('valid');
    } else {
      $adrInput.removeClass('valid');
      $adrInput.val('');
    }
  });
}

$(document).ready(function () {
    init();
    setAddress();
    toggleAccount();
    defAddressColor('div.dcards');
    initPopupSelect('#deliveryType');
    initPopupSelect('#country');
    initPopupSelect('#region');
    initPopupSelect('#city');
    initPopupSelect('#deliveryNova');
    inputPhoneValidate('input.contacts__input[type=tel]');

    $('input[name=sendcompany]').change();
});

