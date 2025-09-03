<!-- BEGIN: register -->
<div class="c-info__hidden-content register-block-checkout" id="createuser_content">
  <form class="" action="<?php echo $action; ?>" id="registerUser" method="post">
    <input type="hidden" name="sect" value="register">
    <input type="hidden" name="return" value="1">

    <div class="row">
      <div class="col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="firstname" data-error=".error1"/>
          <label class="has"><?= $entry_firstname; ?></label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error1"><?php echo $error_firstname; ?></div>
        </div>
      </div>
      <div class="col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="lastname" data-error=".error2"/>
          <label class="has"><?= $entry_lastname; ?></label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error2"><?php echo $error_lastname; ?></div>
        </div>
      </div>
      <div class="col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="tel" name="telephone" data-error=".error3"/>
          <label class="has"><?= $entry_telephone; ?></label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error3"><?php echo $error_telephone; ?></div>
        </div>
      </div>
      <div class="col-12">
        <div class="contacts contacts__input-holder">
          <input class="contacts__input" type="text" name="email" data-error=".error4"/>
          <label class="has"><?= $entry_email; ?></label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error4"><?php echo $error_email; ?></div>
        </div>
      </div>
      <div class="col-12">
        <div class="contacts contacts__input-holder">
          <input id="create_pass" class="contacts__input" type="password" name="password" data-error=".error5"/>
          <label class="has"><?= $entry_password; ?></label>
          <span class="highlight"></span>
          <span class="bar"></span>
          <div class="error5"><?php echo $error_password; ?></div>
          <span id="passVisible2" class="contacts__pass-visible">
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
        </div>
      </div>
      <div class="d-card__control-holder">
        <div class="checkbox checkbox--reg">
          <input id="subscribe-input_register" class="checkbox__core" name="newsletter" value="1" type="checkbox" checked/>
          <label for="subscribe-input_register" class="checkbox__control"><i class="icon"></i></label>
        </div>
        <p class="subscribe-text">
            <?= $text_newsletter; ?>
        </p>
      </div>
      <div class="c-info__btn-holder c-info__btn-holder--auth">
        <input type="submit"  class="btn btn--submit" value="<?= $text_register; ?>" />
      </div>
    </div>
  </form>
</div>
<!-- END: register -->


  </div>
</div>