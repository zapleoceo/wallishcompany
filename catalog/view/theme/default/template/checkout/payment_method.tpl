<div class="url-step4_action_save" style="display: none;"><?= $step4_action_save; ?></div>
<div class="url_checkout_confirm" style="display: none;"><?= $url_checkout_confirm; ?></div>

<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>

<div class="c-info c-info--pay cart__c-info col-12" id="payment">
  <?php
    $checked = !empty($payment_method) ? $payment_method['code'] : 'first';
    $f=0;
    foreach ($payment_methods as $k => $payment_method):
      $check = ($checked == 'first') ? ($f==0) ? ' checked':'' : ($checked == $payment_method['code']) ? ' checked': '';
      $f++;
  ?>
    <input class="c-info__core" value="<?= $payment_method['code']; ?>" type="radio" name="payment" id="pay_<?= $payment_method['code']; ?>"<?= $check; ?>/>
  <?php endforeach; ?>

  <?php foreach ($payment_methods as $payment_method): ?>
    <div class="payBlock">
      <label class="c-info__label c-info__label--pay" for="pay_<?= $payment_method['code']; ?>" id="pay_<?= $payment_method['code']; ?>_label">
        <i class="icon icon--marginNone"></i>
        <span class="text"><?= $payment_method['title']; ?></span>
      </label>

       <!-- BEGIN: payment content -->
       <div class="payForm hidden-content hidden-content--pay c-info__hidden-content" id="pay_<?= $payment_method['code']; ?>_content" aria-controls="pay_<?= $payment_method['code']; ?>">
        <!-- BEGIN: online payment content -->
        <div class="row">
          <div class="col-12 area">
          </div>
        </div>
        <!-- END: online payment content -->
      </div>
    </div>
  <!-- END: payment content -->
  <?php endforeach; ?>



   <!-- BEGIN: online payment by card контент для оплаты онлайн-->
   <div class="hidden-content hidden-content--pay c-info__hidden-content" id="pay_<?= $payment_method['code']; ?>_content">
    <!-- BEGIN: online payment content -->
    <div class="hidden-content__wrapper row">
      <!-- BEGIN: cards radio -->
      <div id="cards" class="hidden-content__cards col-12">
        <div class="holiday-radio">
          <input id="address_" type="radio" class="holiday-radio__core" name="address" checked/>
          <label for="address_" class="holiday-radio__label">
            <i class="holiday-radio__tumb"></i>
            <span class="holiday-radio__text">holiday-radio</span>
          </label>
          <span class="holiday-radio__edit edit">Редактировать</span>
        </div>
        <div class="holiday-radio">
          <input id="address_1" type="radio" class="holiday-radio__core" name="address"/>
          <label for="address_1" class="holiday-radio__label active">
            <i class="holiday-radio__tumb"></i>
            <span class="holiday-radio__text">holiday-radio</span>
          </label>
          <span class="holiday-radio__edit edit">Редактировать</span>
        </div>
      </div>
      <!-- END: cards radio -->
      <div class="hidden-content__add-card col-12">
        <button id="addCard" class="hidden-content__add-address-btn">
          <i class="icon"></i>
          <span class="text">Добавить новую карту</span>
        </button>
      </div>
    </div>
    <!-- END: online payment content -->
  </div>
  <!-- END: online payment by card попап для оплаты онлайн-->
  <!-- BEGIN: add card popup -->
  <div class="hidden-popup hidden-popup--card" id="addCardPopup">
    <form class="hidden-popup__wrapper hidden-popup__wrapper--step4 row" action="#" id="addCardForm">
      <span class="close" id="closeCardEditing"></span>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts">
          <div class="contacts__input-holder ">
            <select class="contacts__input contacts__input--select" name="cardType" id="cardType" data-error=".error0">
              <option value="visa">Visa</option>
              <option value="mastercard" selected>Mastercard</option>
            </select>
            <label class="select has">Выбрать тип карты</label>
            <label class="control" for="cardType"><i class="icon"></i></label>
            <span class="highlight"></span>
            <span class="bar"></span>
            <div class="error0"></div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="cardNumber" data-error=".error1"/>
          <label class="has">Номер карточки</label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error1"></div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="cardDate" data-error=".error2"/>
          <label class="has">Дата действия карты</label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error2"></div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="cvvcode" data-error=".error3"/>
          <label class="has">CVV код</label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error3"></div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="uname" data-error=".error4"/>
          <label class="has">Имя</label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error4"></div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="surname" data-error=".error5"/>
          <label class="has">Фамилия</label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error5"></div>
        </div>
      </div>
      <div class="d-card__control-holder">
        <div class="checkbox">
          <input id="subscribe-input_card" class="checkbox__core" type="checkbox"/>
          <label for="subscribe-input_card" class="checkbox__control"><i class="icon"></i></label>
        </div>
        <p class="d-card__c-text d-card__c-text--editForm">
          <span class="text">Установить картой по умолчанию</span>
        </p>
      </div>
      <div class="hidden-popup__btn-holder">
        <button id="addCard" class="btn btn--submit"><span class="text">Сохранить</span></button>
      </div>
    </form>
    <!-- END: add card popup -->
  </div>
  <!-- END: add card popup -->

  <div class="c-info__accept set-button">
    <a href="#" class="btn btn--submit confirm-but"><span class="text"><?= $button_confirm; ?></span></a>
  </div>
</div>

