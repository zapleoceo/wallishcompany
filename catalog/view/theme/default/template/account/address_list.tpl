<?php echo $header; ?>
<div class="geo-data-url" style="display: none;"><?= $action_city_search; ?></div>
<div class="geo-data-urlsave" style="display: none;"><?= $url_card_save; ?></div>
<div class="geo-data-urlremove" style="display: none;"><?= $url_card_remove; ?></div>
<div class="geo-data-urldefault" style="display: none;"><?= $url_card_default; ?></div>
<div class="geo-data-url_get_np_adress" style="display: none;"><?= $url_get_np_adress; ?></div>
<div class="geo-data-url_get_cities" style="display: none;"><?= $url_get_cities; ?></div>


<main class="main">
  <!-- BEGIN: breadcrumb -->
  <div class="category container d-xl-block d-lg-block d-md-block d-none">
    <div class="row">
      <div class="col-12">

        <ul class="breadcrumb">
          <?php foreach($breadcrumbs as $bk => $br): ?>
          <?php if ($bk == (count($breadcrumbs)-1)): ?>
          <li class="breadcrumb__item last">
            <?= $br['text']; ?>
          </li>
          <?php else: ?>
          <li class="breadcrumb__item">
            <a href="<?= $br['href']; ?>" class="breadcrumb__link">
              <?= $br['text']; ?>
            </a>
          </li>
          <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- END: breadcrumb -->

  <!-- BEGIN: account -->
  <section class="account account--address container">
    <h1 class="account__title account__title--address"><?= $heading_title; ?></h1>
    <div class="row">

      <!-- BEGIN: sidebar-->
      <?= $account_menu; ?>
      <!-- END: sidebar -->

      <div class="col-xl-9 col-lg-10 col-12">

        <div class="row align area-adresses">

          <!-- BEGIN: left column -->
          <div class="delivery col-xl-5 col-lg-5 col-md-5 col-sm-6 col-12">
            <div class="row ukraine_set">
              <h4 class="delivery__title col-12"><?= $text_delivery_ukraine; ?></h4>
              <div class="delivery__btn-holder add_dilivery ukraine">
                <button id="addUkraineAdress" class="btn btn--delivery"><span class="text"><?= $text_add_delivery_ukraine; ?></span></button>
              </div>
              <!-- BEGIN: ukraine address -->
              <form class="delivery__data-holder" action="#" id="addDeliveryForm">
                  <input name="id" value="0" type="hidden">

                  <input type="hidden" name="country" value="<?= $uk_country_id; ?>">
                <div class="wrapper">
                  <span class="close" id="closeUkraineAdress"></span>
                  <div class="col-12">
                    <div class="contacts">
                      <div class="contacts__input-holder ">
                        <select class="contacts__input contacts__input--select" name="shipping_type" id="deliveryType" data-error=".error0">
                            <?php foreach($shipping_methods as $skey => $smet): $key = key($smet['quote']);
                              if ($key == 'xshipping1') continue;
                            ?>
                              <option value="<?= $smet['quote'][$key]['code']; ?>"><?= $smet['quote'][$key]['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="select has align--1"><?= $text_delivery_type; ?></label>
                        <label class="control" for="deliveryType"><i class="icon"></i></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <div class="error0"></div>
                      </div>
                    </div>
                  </div>


                    <div class="col-12">
                        <div class="contacts">
                            <div class="contacts__input-holder ">
                                <select class="contacts__input contacts__input--select" name="region" id="region" data-error=".error1">
                                    <option value="none"><?= $entry_zone_option; ?></option>
                                    <?php foreach($regions as $region): ?>
                                        <option value="<?= $region['country_id']; ?>"><?= $region['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label class="select has"><?= $entry_zone; ?></label>
                                <label class="control" for="region"><i class="icon"></i></label>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <div class="error1"></div>
                            </div>
                        </div>
                    </div>


                  <div class="col-12">
                    <div class="contacts">
                      <div class="contacts__input-holder ">
                        <input type="hidden" name="city" value="">
                        <select class="contacts__input contacts__input--select" id="city" name="city-select" data-error=".error1">
                            <option value="none"><?= $entry_city_option; ?></option>
                        </select>
                        <label class="select has"><?= $entry_city; ?></label>
                        <label class="control" for="city"><i class="icon"></i></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <div class="error1"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 hidden adress-field">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="address" data-error=".error2"/>
                      <label class="has"><?= $entry_address_1; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error2"></div>
                    </div>
                  </div>
                  <div class="col-12 visible novaposhta-field">
                    <div class="contacts contacts__input-holder">
                      <select class="contacts__input contacts__input--select" name="np_num" id="deliveryNova" data-error=".error3">
                        <option value="0"><?= $entry_npselect_option; ?></option>
                      </select>
                      <label class="select has"><?= $entry_npselect; ?></label>
                      <label class="control" for="deliveryNova"><i class="icon"></i></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error3"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="tel" value="<?= $customer_phone; ?>" name="phone" data-error=".error4"/>
                      <label class="has"><?= $entry_phone; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error4"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="company" data-error=".error5"/>
                      <label class="has"><?= $entry_company; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error5"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" value="<?= $customer_firstname; ?>" name="firstname" data-error=".error6"/>
                      <label class="has"><?= $entry_firstname; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error6"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" value="<?= $customer_lastname; ?>" type="text" name="lastname" data-error=".error7"/>
                      <label class="has"><?= $entry_lastname; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error7"></div>
                    </div>
                  </div>
                  <div class="d-card__control-holder">
                    <div class="checkbox checkbox--popup">
                      <input id="subscribe-input_4" class="checkbox__core" value="1" name="default" type="checkbox"/>
                      <label for="subscribe-input_4" class="checkbox__control"><i class="icon"></i></label>
                    </div>
                    <p class="d-card__c-text d-card__c-text--editForm">
                      <span class="text"><?= $entry_default; ?></span>
                    </p>
                  </div>
                  <div class="d-card__control-holder">
                    <div class="checkbox checkbox--popup">
                      <input id="subscribe-input_5" name="sendcompany" value="1" class="checkbox__core" type="checkbox"/>
                      <label for="subscribe-input_5" class="checkbox__control"><i class="icon"></i></label>
                    </div>
                    <p class="d-card__c-text d-card__c-text--editForm">
                      <span class="text"><?= $entry_send_company; ?></span>
                    </p>
                  </div>
                  <div class="delivery__btn-holder">
                    <a href="#" id="addDelivery" class="btn btn--editForm"><span class="text"><?= $entry_save; ?></span></a>
                  </div>
                </div>
              </form>
              <!-- END: ukraine address -->

              <!-- тут блоки украина -->
              <?php $is=1; if (!empty($addresses)): ?>
                <?php foreach ($addresses as $result): ?>
                  <?php if($result['data']['country_id'] == $uk_country_id): $is = 0; ?>

                    <!-- BEGIN: d-card -->
                    <div class="d-card delivery__d-card col-12 dcards" data-id="<?= $result['address_id']; ?>">
                        <div class="d-card__info-holder">
                          <div class="d-card__type"> <!-- тип доставки сюда -->
                              <span class="text"><?= $result['data']['city']; ?></span>
                            <!--<input class="text select_city" type="text" name="city" value="<?= $result['data']['city']; ?>" placeholder="City" readonly="true" autocomplete="off"/>
                            <input class="country-inp" type="hidden" value="<?= $result['data']['country']; ?>" name="country"/> -->
                          </div>
                            <div class="d-card__address data-block" data-address='<?= json_encode($result); ?>'></div>
                            <div class="d-card__company">
                                <span class="text"></span>
                            </div>
                          <div class="d-card__phone-holder">
                              <span class="text"><?= $result['address']; ?></span>
                            <!--<input class="text" type="text" value="<?= $result['data']['company']; ?>" placeholder="Phone" name="phone" readonly="true" />-->
                          </div>
                          <div class="d-card__name">
                              <span class="text"><?= $result['data']['firstname']; ?> <?= $result['data']['lastname']; ?></span>

                              <!--<input type="text" class="text" value="<?= $result['data']['firstname']; ?>" placeholder="Name" name="name" readonly="true"/>-->
                          </div>
                          </div>
                      <div class="d-card__control-holder">
                        <button class="d-control edit" data-id="<?= $result['address_id']; ?>" data-edit="" data-wait="" data-save=""><?= $entry_edit; ?></button>
                        <button class="d-control remove" data-id="<?= $result['address_id']; ?>" data-language=""><?= $entry_delete; ?></button>
                      </div>
                      <div class="d-card__control-holder">
                        <div class="checkbox">
                          <input name="default" value="1" id="subscribe-input_<?= $result['address_id']; ?>" class="checkbox__core is_default" type="checkbox"<?= ($default_adress_id == $result['address_id']) ? ' checked' : ''; ?>/>
                          <label for="subscribe-input_<?= $result['address_id']; ?>" class="checkbox__control checkbox__control--card"><i class="icon"></i></label>
                        </div>
                        <p class="d-card__c-text">
                          <span class="text"><?= $entry_default; ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- END: d-card -->


                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php if($is): ?>
                <div class="empty"><?= $text_empty; ?></div>
              <?php endif; ?>

            </div>
          </div>
          <!-- END: left column -->

          <!-- BEGIN: right column -->
          <div class="delivery col-xl-5 col-lg-5 col-md-5 col-sm-6 col-12">
            <div class="row other_set">
              <h4 class="delivery__title col-12"><?= $text_delivery_other; ?></h4>
              <div class="delivery__btn-holder add_dilivery">
                <button id="addInternayionalAdress" class="btn btn--delivery"><span class="text"><?= $text_add_delivery_other; ?></span></button>
              </div>

              <!-- BEGIN: international address -->
              <form class="delivery__data-holder" action="#" id="addInternationalDeliveryForm">
                <input name="id" value="0" type="hidden">
                <div class="wrapper">
                  <span class="close" id="closeInternationalAdress"></span>
                  <div class="col-12">
                    <div class="contacts">
                      <div class="contacts__input-holder ">
                        <select class="contacts__input contacts__input--select" name="country" id="country" data-error=".error_1_0">
                            <?php foreach($countries as $country): ?>
                            <option value="<?= $country['id']; ?>"><?= $country['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="select has align--1"><?= $entry_country; ?></label>
                        <label class="control" for="country"><i class="icon"></i></label>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <div class="error_1_0"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="state" data-error=".error_1_1"/>
                      <label class="has"><?= $entry_state; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_1"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="city" data-error=".error_1_2"/>
                      <label class="has"><?= $entry_city; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_2"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="address" data-error=".error_1_3"/>
                      <label class="has"><?= $entry_address_1; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_3"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="zipcode" data-error=".error_1_4"/>
                      <label class="has"><?= $entry_zipcode; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_4"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="tel" value="<?= $customer_phone; ?>" name="phone" data-error=".error_1_5"/>
                      <label class="has"><?= $entry_phone; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_5"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" name="company" data-error=".error_1_6"/>
                      <label class="has"><?= $entry_company; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1+6"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" type="text" value="<?= $customer_firstname; ?>" name="firstname" data-error=".error_1_7"/>
                      <label class="has"><?= $entry_firstname; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_7"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="contacts contacts__input-holder">
                      <input class="contacts__input" value="<?= $customer_lastname; ?>" type="text" name="lastname" data-error=".error_1_8"/>
                      <label class="has"><?= $entry_lastname; ?></label>
                      <span class="highlight"></span>
                      <span class="bar"></span>
                      <div class="error_1_8"></div>
                    </div>
                  </div>
                  <div class="d-card__control-holder">
                    <div class="checkbox">
                      <input id="subscribe-input_international" class="checkbox__core" name="default" value="1" type="checkbox"/>
                      <label for="subscribe-input_international" class="checkbox__control"><i class="icon"></i></label>
                    </div>
                    <p class="d-card__c-text d-card__c-text--editForm">
                      <span class="text"><?= $entry_default; ?></span>
                    </p>
                  </div>
                  <div class="delivery__btn-holder">
                    <a href="#" id="addDelivery" class="btn btn--editForm"><span class="text"><?= $entry_save; ?></span></a>
                  </div>
                </div>
              </form>
              <!-- END: international address -->

              <!-- тут блоки не украина -->
              <?php $is=1; if (!empty($addresses)): ?>
                <?php foreach ($addresses as $result): ?>
                  <?php if($result['data']['country_id'] != $uk_country_id): $is = 0; ?>

                    <!-- BEGIN: d-card -->
                    <div class="d-card delivery__d-card col-12 dcards" data-id="<?= $result['address_id']; ?>">

                        <div class="d-card__info-holder">
                            <div class="d-card__type"> <!-- тип доставки сюда -->
                              <span class="text"><?= $result['data']['city']; ?></span>
                              <!--<input class="text select_city" type="text" name="city" value="<?= $result['data']['city']; ?>" placeholder="City" readonly="true" autocomplete="off"/>
                              <input class="country-inp" type="hidden" value="<?= $result['data']['country']; ?>" name="country"/> -->
                          </div>
                          <div class="d-card__address data-block" data-address='<?= json_encode($result); ?>'></div>
                          <div class="d-card__company">
                              <span class="text"></span>
                          </div>
                          <div class="d-card__phone-holder">
                              <span class="text"><?= $result['address']; ?></span>
                              <!--<input class="text" type="text" value="<?= $result['data']['company']; ?>" placeholder="Phone" name="phone" readonly="true" />-->
                          </div>
                          <div class="d-card__name">
                              <span class="text"><?= $result['data']['firstname']; ?> <?= $result['data']['lastname']; ?></span>

                              <!--<input type="text" class="text" value="<?= $result['data']['firstname']; ?>" placeholder="Name" name="name" readonly="true"/>-->
                          </div>
                        </div>
                      <div class="d-card__control-holder">
                        <button class="d-control edit" data-id="<?= $result['address_id']; ?>" data-edit="" data-wait="" data-save=""><?= $entry_edit; ?></button>
                        <button class="d-control remove" data-id="<?= $result['address_id']; ?>" data-language=""><?= $entry_delete; ?></button>
                      </div>
                      <div class="d-card__control-holder">
                        <div class="checkbox">
                          <input name="default" value="1" id="subscribe-input_<?= $result['address_id']; ?>" class="checkbox__core is_default" type="checkbox"<?= ($default_adress_id == $result['address_id']) ? ' checked' : ''; ?>/>
                          <label for="subscribe-input_<?= $result['address_id']; ?>" class="checkbox__control checkbox__control--card"><i class="icon"></i></label>
                        </div>
                        <p class="d-card__c-text">
                          <span class="text"><?= $entry_default; ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- END: d-card -->

                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php if($is): ?>
                  <div class="empty"><?= $text_empty; ?></div>
              <?php endif; ?>
            </div>
          </div>
          <!-- END: left column -->

        </div>

      </div>


    </div>
  </section>
  <!-- END: account -->
</main>
<script>
    var lang = {
        'confirm_delete': 'Действительно удалить?',
    };
</script>
<?php echo $footer; ?>