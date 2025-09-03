<div class="c-info c-info--step2 cart__c-info col-12">

  <div class="c-info__user-info-holder">

    <input class="c-info__core" type="radio" name="core" id="alreadyuser"<?= $sectred == 'login' ? ' checked' : ''; ?>/>
    <input class="c-info__core" type="radio" name="core" id="createuser"<?= $sectred == 'register' ? ' checked' : ''; ?>/>
    <input class="c-info__core" type="radio" name="core" id="anonim" />

    <label class="c-info__label c-info__label--user" for="alreadyuser" id="alreadyuser_label"><i class="icon"></i><span class="text"><?= $text_returning_customer; ?></span></label>
    <label class="c-info__label c-info__label--user" for="createuser" id="createuser_label"><i class="icon"></i><span class="text"><?= $text_new_customer; ?></span></label>
    <label class="c-info__label c-info__label--user" for="anonim" id="anonim_label"><i class="icon"></i><span class="text"><?= $text_guest; ?></span></label>


    <!-- BEGIN: login -->
    <div class="c-info__hidden-content login-block-checkout" id="alreadyuser_content">
      <form class="" action="<?= $action; ?>" method="post" id="loginUser">
        <input type="hidden" name="sect" value="login">
        <input type="hidden" name="return" value="1">
        <div class="row">
          <div class="col-12">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input" type="text" name="email" data-error=".error_0_1"/>
              <label class="has"><?= $entry_email; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_0_1"></div>
            </div>
          </div>
          <div class="col-12">
            <div class="contacts contacts__input-holder">
              <input id="login_pass" class="contacts__input" type="password" name="password" data-error=".error_0_2"/>
              <label class="has"><?= $entry_password; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_0_2"></div>
              <span id="passVisible1" class="contacts__pass-visible">
                                      <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="18.969" height="12" viewBox="0 0 18.969 12">
                                      <metadata>
                                        <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c142 79.160924, 2017/07/13-01:06:39        ">
                                              <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
                                                  <rdf:Description rdf:about=""/>
                                              </rdf:RDF>
                                          </x:xmpmeta>
                                        </metadata>
                                      <path id="eye" class="cls-1" d="M883.878,920.634c-0.169-.23-4.214-5.634-9.379-5.634s-9.209,5.4-9.379,5.634a0.615,0.615,0,0,0,0,.732c0.17,0.23,4.214,5.634,9.379,5.634s9.21-5.4,9.379-5.634A0.615,0.615,0,0,0,883.878,920.634Zm-9.379,5.125c-3.805,0-7.1-3.587-8.075-4.76,0.974-1.173,4.262-4.758,8.075-4.758s7.1,3.586,8.076,4.759C881.6,922.174,878.312,925.759,874.5,925.759Zm0-8.483A3.724,3.724,0,1,0,878.257,921,3.745,3.745,0,0,0,874.5,917.276Zm0,6.207A2.483,2.483,0,1,1,877.005,921,2.5,2.5,0,0,1,874.5,923.483Z" transform="translate(-865.031 -915)"/>
                                  </svg></i>
                                  </span>
                <a href="<?= $forgotten; ?>" class="forget-pass"><?= $text_forgotten; ?></a>
            </div>
          </div>
          <div class="c-info__btn-holder c-info__btn-holder--auth">
            <input id="button-login" type="submit"  class="btn btn--submit" value="<?php echo $button_login; ?>" />
          </div>
        </div>
      </form>
    </div>
    <!-- END: login -->

    <div class="c-info__hidden-content login-block-checkout" id="anonim_content">
      <form class="" method="post" action="#" id="anonimUser">
        <input type="hidden" name="sect" value="guest">
        <input type="hidden" name="return" value="1">

        <div class="row">
            <div class="col-12">
                <div class="contacts contacts--anonim contacts__input-holder" style="margin-bottom: 45px">
                    <input class="contacts__input" type="text" name="guest_name"/> <?php // HV-35 ?>
                    <label class="has">Ваше имя</label>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                </div>
            </div>
          <div class="col-12">
            <div class="contacts contacts--anonim contacts__input-holder">
              <input class="contacts__input" type="tel" name="telephone" data-error=".error_anonim_tel"/>
              <label class="has"><?= $entry_telephone; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error_anonim_tel"></div>
            </div>
          </div>
          <div class="c-info__btn-holder c-info__btn-holder--auth c-info__btn-holder--anonim">
            <input id="button-anonim" type="submit"  class="btn btn--submit" value="<?= $text_order_create; ?>" />
          </div>
        </div>
      </form>
    </div>