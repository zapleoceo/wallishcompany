<div class="geo-data-url" style="display: none;"><?= $action_city_search; ?></div>
<div class="geo-data-urlsave" style="display: none;"><?= $url_card_save; ?></div>
<div class="geo-data-url_get_np_adress" style="display: none;"><?= $url_get_np_adress; ?></div>
<div class="geo-data-url_get_cities" style="display: none;"><?= $url_get_cities; ?></div>
<div class="url-next-step" style="display: none;"><?= $next_step; ?></div>

<?php

  $country_uk = '';
  $country_inter = '';
  if (isset($default_adress['country']) && isset($default_adress['country']['id'])) {
    if ($default_adress['country']['id'] == $uk_country_id) {
      $country_uk = ' checked';
    } else {
      $country_inter = ' checked';
    }
  } else {
    $country_uk = ' checked';
  }

  $novapochtaDelivery = '';
  $curierDelivery = '';
  $selfDelivery = '';
  $interDelivery = '';

  if (isset($default_adress['custom_field'])) {
      if (isset($default_adress['custom_field']['shipping_type'])) {

        if ($default_adress['custom_field']['shipping_type'] == 'novaposhta.novaposhta') {
          $novapochtaDelivery = ' checked';
        }

        if ($default_adress['custom_field']['shipping_type'] == 'xshipping.xshipping2') {
          $curierDelivery = ' checked';
        }

        if ($default_adress['custom_field']['shipping_type'] == 'pickup.pickup') {
          $selfDelivery = ' checked';
        }

        if ($default_adress['custom_field']['shipping_type'] == 'xshipping.xshipping1') {
          $interDelivery = ' checked';
        }

      } else {
        $novapochtaDelivery = ' checked';
      }
  } else {
    $novapochtaDelivery = ' checked';
  }

?>

<div class="c-info c-info--ukr cart__c-info col-12">

  <div class="c-info__user-info-holder">

    <input class="c-info__core countryType" value="0" type="radio" name="coselect" id="ukraineDelivery"<?= $country_uk; ?>/>
    <input class="c-info__core countryType" value="1" type="radio" name="coselect" id="internationalDelivery"<?= $country_inter; ?>/>

    <label class="c-info__label c-info__label--step3" for="ukraineDelivery" id="label_step3_0"><i class="icon"></i><span class="text"><?= $text_delivery_ukraine; ?></span></label>
    <label class="c-info__label c-info__label--step3" for="internationalDelivery" id="label_step3_1"><i class="icon"></i><span class="text"><?= $text_delivery_other_internacional; ?></span></label>
    <!-- BEGIN: ukraine delivery -->
    <div class="c-info__hidden-content hidden-content--step3" id="hidden_content_0">
      <input class="c-info__core deliveryType" type="radio" name="shipping_type" id="novapochtaDelivery" value="novaposhta.novaposhta"<?= $novapochtaDelivery; ?>/>
      <input class="c-info__core deliveryType" type="radio" name="shipping_type" id="curierDelivery" value="xshipping.xshipping2"<?= $curierDelivery; ?>/>
      <input class="c-info__core deliveryType" type="radio" name="shipping_type" id="selfDelivery" value="pickup.pickup"<?= $selfDelivery; ?>/>

      <input class="c-info__core deliveryType" type="radio" name="shipping_type" value="xshipping.xshipping1"<?= $interDelivery; ?>/>

      <label class="c-info__label c-info__label--ukr" for="novapochtaDelivery" id="label_0_0"><i class="icon"></i><span class="text"><?= $text_delivery_to_np; ?></span></label>
      <label class="c-info__label c-info__label--ukr" for="curierDelivery" id="label_0_1"><i class="icon"></i><span class="text"><?= $text_delivery_to_kiev; ?></span></label>
      <label class="c-info__label c-info__label--ukr" for="selfDelivery" id="label_0_2"><i class="icon"></i><span class="text"><?= $text_delivery_to_samovivoz; ?></span></label>
      <!-- Content ################################################### -->
      <!-- BEGIN: novapochta delivery -->
      <div class="hidden-content hidden-content--ukr c-info__hidden-content" id="hidden_content_0_0">
        <form class="hidden-content__wrapper row save-step" id="novaPochtaContentForm">
          <div class="hidden-content__addresses col-12 adr-areas">
            <?php if(!empty($addresses['uk']) && !empty($addresses['uk']['novaposhta.novaposhta'])): ?>
            <?php foreach ($addresses['uk']['novaposhta.novaposhta'] as $adr): ?>
            <div class="holiday-radio data-block" data-address='<?= json_encode($adr); ?>'>
              <input id="address_<?= 'uk_np_'.$adr['address_id']; ?>" type="radio" class="holiday-radio__core" value="<?= $adr['address_id']; ?>" name="address_id"<?= $address_id == $adr['address_id'] ? ' checked': ''?>/>
              <label for="address_<?= 'uk_np_'.$adr['address_id']; ?>" class="holiday-radio__label<?= $address_id == $adr['address_id'] ? ' active': ''?>">
                <i class="holiday-radio__tumb"></i>
                <span class="holiday-radio__text"><?= $adr['address']; ?></span>
              </label>
              <span class="holiday-radio__edit editnova"><?= $entry_edit; ?></span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

          </div>
          <div class="hidden-content__add-address col-12">
            <button type="button" id="addNovaPochtaBtn" class="hidden-content__add-address-btn">
              <i class="icon"></i>
              <span class="text"><?= $entry_address_add_new; ?></span>
            </button>
          </div>
          <div class="col-12 hidden-content__comment">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="comment" data-error=".errorNova" value="<?= $comment; ?>"/>
              <label class="has"><?= $entry_comment_order; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="errorNova"></div>
            </div>
          </div>
          <p class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
            <?= $entry_delivery_np_free; ?>
          </p>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <button type="submit" class="btn btn--submit hidden-content__btn save-adress"><span class="text"><?= $entry_next; ?></span></button>
          </div>
        </form>

        <!-- BEGIN: add novapochta popup -->
        <div class="hidden-popup hidden-popup--ukrNova block-form" id="novaPochtaPopup">
          <form class="hidden-popup__wrapper row" action="#" id="novaPochtaForm">
            <input type="hidden" name="country" value="<?= $uk_country_id; ?>">
              <input name="id" value="0" type="hidden">
            <span class="close" id="closeNovaPopup"></span>



            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts">
                <div class="contacts__input-holder ">
                  <select class="contacts__input contacts__input--select" name="region" id="region" data-error=".error_0_0">
                    <option value="none"><?= $entry_zone_option; ?></option>
                    <?php foreach($regions as $region): ?>
                    <option value="<?= $region['country_id']; ?>"><?= $region['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="select has"><?= $entry_zone; ?></label>
                  <label class="control" for="region"><i class="icon"></i></label>
                  <span class="highlight"></span>
                  <span class="bar"></span>
                  <div class="error_0_0"></div>
                </div>
              </div>
            </div>


            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts">
                <div class="contacts__input-holder ">
                  <input type="hidden" name="city" value="">
                  <select class="contacts__input contacts__input--select" id="city" data-error=".error_0_0">
                    <option value="none"><?= $entry_city_option; ?></option>
                  </select>
                  <label class="select has"><?= $entry_city; ?></label>
                  <label class="control" for="city"><i class="icon"></i></label>
                  <span class="highlight"></span>
                  <span class="bar"></span>
                  <div class="error_0_0"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <select class="contacts__input contacts__input--select" name="npadress" id="deliveryNova" data-error=".error_0_1">
                  <option value="none"><?= $entry_np_option_default; ?></option>
                </select>
                <label class="select has"><?= $entry_np_num; ?></label>
                <label class="control" for="n-depart"><i class="icon"></i></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_0_1"></div>
              </div>
            </div>

            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="tel" value="<?= $customer_phone; ?>" name="phone" data-error=".error_0_2"/>
                <label class="has"><?= $entry_telephone; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_0_2"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" name="company" data-error=".error_0_3"/>
                <label class="has"><?= $entry_company; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_0_3"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12"></div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" value="<?= $customer_firstname; ?>" name="firstname" data-error=".error_0_6"/>
                <label class="has"><?= $entry_firstname; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_0_6"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" value="<?= $customer_lastname; ?>" name="lastname" data-error=".error_0_7"/>
                <label class="has"><?= $entry_lastname; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_0_7"></div>
              </div>
            </div>
            <div class="d-card__control-holder">
              <div class="checkbox">
                <input id="subscribe-input_nova_0" type="hidden" name="default" value="1" class="checkbox__core" type="checkbox"<?php if ($customer_is_guest == 0): ?> checked<?php endif; ?>/>
                <label id="subscribe-label_nova_0" for="subscribe-input_nova_0" class="checkbox__control checkbox__control--ukrNova active"><i class="icon icon--ukrNova"></i></label>
              </div>
              <p class="d-card__c-text d-card__c-text--editForm">
                <span class="text"><?= $entry_address_default; ?></span>
              </p>
            </div>
            <div class="d-card__control-holder">
              <div class="checkbox">
                <input id="subscribe-input_nova_1" type="checkbox" class="checkbox__core" value="1" name="sendcompany" type="checkbox"/>
                <label id="subscribe-label_nova_1" for="subscribe-input_nova_1" class="checkbox__control checkbox__control--ukrNova"><i class="icon icon--ukrNova"></i></label>
              </div>
              <p class="d-card__c-text d-card__c-text--editForm">
                <span class="text"><?= $entry_send_name_company; ?></span>
              </p>
            </div>
            <div class="hidden-popup__btn-holder">
              <button id="novaPochtaBtn" class="btn btn--submit save-form">
                <span class="text"><?= $entry_save; ?></span>
              </button>
            </div>
          </form>
        </div>
        <!-- END: add novapochta popup -->
      </div>
      <!-- END: novapochta delivery -->

      <!-- BEGIN: curier delivery -->
      <div class="hidden-content hidden-content--ukr c-info__hidden-content block-form" id="hidden_content_0_1">
        <form class="hidden-content__wrapper row " id="cuierForm">
          <div id="addresses" class="hidden-content__addresses col-12 adr-areas">

            <?php if (!empty($addresses['uk']) && !empty($addresses['uk']['free.free'])): ?>
            <?php foreach ($addresses['uk']['free.free'] as $adr): ?>
            <div class="holiday-radio data-block" data-address='<?= json_encode($adr); ?>'>
              <input id="address_<?= 'uk_free_'.$adr['address_id']; ?>" type="radio" class="holiday-radio__core" value="<?= $adr['address_id']; ?>" name="address_id" <?= $address_id == $adr['address_id'] ? ' checked': ''?>/>
              <label for="address_<?= 'uk_free_'.$adr['address_id']; ?>" class="holiday-radio__label<?= $address_id == $adr['address_id'] ? ' active': ''?>">
                <i class="holiday-radio__tumb"></i>
                <span class="holiday-radio__text"><?= $adr['address']; ?></span>
              </label>
              <span class="holiday-radio__edit editcurier"><?= $entry_edit; ?></span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="hidden-content__add-address col-12">
            <button type="button" class="hidden-content__add-address-btn" id="addCurierBtn">
              <i class="icon"></i>
              <span class="text"><?= $entry_address_add_new; ?></span>
            </button>
          </div>
          <div class="col-12 hidden-content__comment">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="comment" data-error=".errorCuier" value="<?= $comment; ?>"/>
              <label class="has"><?= $entry_comment_order; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="errorCuier"></div>
            </div>
          </div>
          <p class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
            <?= $entry_delivery_kiev_free; ?>
          </p>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <button type="submit" class="btn btn--submit hidden-content__btn save-adress"><span class="text"><?= $entry_next; ?></span></button>
          </div>
        </form>

        <!-- BEGIN: add curier popup -->
        <div class="hidden-popup hidden-popup--ukrCurier block-form" id="curierPopup">
          <form class="hidden-popup__wrapper hidden-popup__wrapper--step3 row" action="#" id="addCurierForm">
            <input type="hidden" name="country" value="<?= $uk_country_id; ?>">
            <input name="id" value="0" type="hidden">

            <span class="close" id="closeCurierPopup"></span>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" name="address" data-error=".error_1_1"/>
                <label class="has"><?= $entry_address_title; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_1_1"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="tel" value="<?= $customer_phone; ?>" name="phone" data-error=".error_1_2"/>
                <label class="has"><?= $entry_telephone; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_1_2"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" name="company" data-error=".error_1_3"/>
                <label class="has"><?= $entry_company; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_1_3"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" value="<?= $customer_firstname; ?>" name="firstname" data-error=".error_1_4"/>
                <label class="has"><?= $entry_firstname; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_1_4"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-12">
              <div class="contacts contacts__input-holder">
                <input class="contacts__input" type="text" value="<?= $customer_lastname; ?>" name="lastname" data-error=".error_1_5"/>
                <label class="has"><?= $entry_lastname; ?></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_1_5"></div>
              </div>
            </div>
            <div class="d-card__control-holder">
              <div class="checkbox">
                <input id="subscribe-input_curier" class="checkbox__core" name="default"  type="checkbox"<?php if ($customer_is_guest == 0): ?> checked<?php endif; ?>/>
                <label for="subscribe-input_curier" class="checkbox__control"><i class="icon"></i></label>
              </div>
              <p class="d-card__c-text d-card__c-text--editForm">
                <span class="text"><?= $entry_address_default; ?></span>
              </p>
            </div>
            <div class="hidden-popup__btn-holder">
              <button type="submit" class="btn btn--submit save-form">
                <span class="text"><?= $entry_save; ?></span>
              </button>
            </div>
          </form>
        </div>
        <!-- END: add curier popup -->
      </div>
      <!-- END: curier delivery -->

      <!-- BEGIN: self delivery -->
      <div class="hidden-content hidden-content--ukr c-info__hidden-content" id="hidden_content_0_2">
        <form class="hidden-content__wrapper row" id="selfDel">
          <div class="hidden-content__sd-label col-12">
            <span class="text"><?= $text_get_order_address; ?>:</span>
          </div>
          <div class="hidden-content__sd-address col-12">
            <span class="text"><?= $store_address; ?></span>
          </div>
          <div class="col-12 hidden-content__comment">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="comment" data-error=".errorSelf" value="<?= $comment; ?>"/>
              <label class="has"><?= $entry_comment_order; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="errorSelf"></div>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn--submit hidden-content__btn save-adress"><span class="text"><?= $entry_next; ?></span></button>
          </div>
        </form>
      </div>
      <!-- END: self delivery -->

    </div>
    <!-- END: ukraine delivery -->

    <!-- International delivery ################################################### -->
    <!-- BEGIN: international delivery -->
    <div class="c-info__hidden-content hidden-content--step3" id="hidden_content_1">
      <form class="hidden-content__wrapper row" action="#" id="internationalForm">
        <div id="addresses" class="hidden-content__addresses col-12 adr-areas">

          <?php if(!empty($addresses['inter'])): ?>
          <?php foreach ($addresses['inter'] as $adr): ?>

          <div class="holiday-radio data-block" data-address='<?= json_encode($adr); ?>'>
            <input id="address_<?= 'int_'.$adr['address_id']; ?>" type="radio" class="holiday-radio__core" value="<?= $adr['address_id']; ?>" name="address_id" <?= $address_id == $adr['address_id'] ? ' checked': ''?>/>
            <label for="address_<?= 'int_'.$adr['address_id']; ?>" class="holiday-radio__label<?= $address_id == $adr['address_id'] ? ' active': ''?>">
              <i class="holiday-radio__tumb"></i>
              <span class="holiday-radio__text"><?= $adr['address']; ?></span>
            </label>
            <span class="holiday-radio__edit editinter"><?= $entry_edit; ?></span>
          </div>

          <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <div class="hidden-content__add-address col-12">
          <button type="button" class="hidden-content__add-address-btn" id="addInternationalBtn">
            <i class="icon"></i>
            <span class="text"><?= $entry_address_add_new; ?></span>
          </button>
        </div>
        <div class="col-12 hidden-content__comment">
          <div class="contacts contacts__input-holder">
            <input class="contacts__input" type="text" name="comment" data-error=".error2" value="<?= $comment; ?>"/>
            <label class="has"><?= $entry_comment_order; ?></label>
            <span class="highlight"></span>
            <span class="bar"></span>
            <div class="error2"></div>
          </div>
        </div>
        <p class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 inter-comment">
          <?= $entry_information; ?>
        </p>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
          <button class="btn btn--submit hidden-content__btn save-adress"><span class="text"><?= $entry_next; ?></span></button>
        </div>
      </form>

      <!-- BEGIN: add international popup -->
      <div class="hidden-popup hidden-popup--international block-form" id="internationalPopup">
        <form class="hidden-popup__wrapper hidden-popup__wrapper--step3 row" id="internationalForm">
            <input name="id" value="0" type="hidden">
          <span class="close" id="closeInternationalPopup"></span>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts">
              <div class="contacts__input-holder ">
                <select class="contacts__input contacts__input--select" name="country" id="country" data-error=".error_2_0">
                  <?php foreach($countries as $country): ?>
                  <option value="<?= $country['id']; ?>"><?= $country['name']; ?></option>
                  <?php endforeach; ?>
                </select>
                <label class="select has"><?= $entry_country; ?></label>
                <label class="control" for="country"><i class="icon"></i></label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_2_0"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="state" data-error=".error_2_1"/>
              <label class="has"><?= $entry_region; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_1"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="city" data-error=".error_2_2"/>
              <label class="has"><?= $entry_city; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_2"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="address" data-error=".error_2_3"/>
              <label class="has"><?= $entry_address_1; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_3"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="zipcode" data-error=".error_2_4"/>
              <label class="has"><?= $entry_zipcode; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_4"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="tel" value="<?= $customer_phone; ?>" name="phone" data-error=".error_2_5"/>
              <label class="has"><?= $entry_telephone; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_5"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="company" data-error=".error_2_6"/>
              <label class="has"><?= $entry_company; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_6"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12"></div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" value="<?= $customer_firstname; ?>" name="firstname" data-error=".error_2_7"/>
              <label class="has"><?= $entry_firstname; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_7"></div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" value="<?= $customer_lastname; ?>" name="lastname" data-error=".error_2_8"/>
              <label class="has"><?= $entry_lastname; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_2_8"></div>
            </div>
          </div>
          <div class="d-card__control-holder">
            <div class="checkbox">
              <input id="subscribe-input_international" name="default" class="checkbox__core" type="checkbox"<?php if ($customer_is_guest == 0): ?> checked<?php endif; ?>/>
              <label for="subscribe-input_international" class="checkbox__control"><i class="icon"></i></label>
            </div>
            <p class="d-card__c-text d-card__c-text--editForm">
              <span class="text"><?= $entry_address_default; ?></span>
            </p>
          </div>
          <div class="hidden-popup__btn-holder">
            <button type="submit" class="btn btn--submit btn--edit Form save-form"><span class="text"><?= $entry_save; ?></span></button>
          </div>
        </form>
      </div>
      <!-- END: add international popup -->
    </div>
    <!-- END: international delivery -->

  </div>

</div>