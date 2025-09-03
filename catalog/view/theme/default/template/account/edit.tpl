<?php echo $header; ?>
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
  <section class="account container">
    <h1 class="account__title"><?php echo $text_my_account; ?></h1>
    <div class="row">

      <?= $account_menu; ?>

      <div class="account__content-holder col-xl-8 col-lg-9 col-12">
        <div class="account__line"></div>


        <?php if ($register_true) { ?>
        <div class="account__notification row">
          <p class="col-12"><?php echo $register_true; ?></p>
        </div>
        <?php } ?>

        <?php if ($error_warning) { ?>
          <div class="account__notification row">
            <p class="col-12"><?php echo $error_warning; ?></p>
          </div>
        <?php } ?>

        <div class="account__info-title row">
          <p class="col-12"><?= $text_change_profile_data; ?></p>
        </div>

        <form action="<?php echo $action; ?>" method="post" class="account__data-holder row" id="contactForm">
          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input<?= (isset($firstname) && !empty($firstname)) ? ' valid': ''?>" type="text" name="firstname" value="<?php echo $firstname; ?>" data-error=".error1"/>
              <label class="has"><?= $text_firstname; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error1"><?= isset($error_firstname) ? $error_firstname : ''; ?></div>
            </div>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input<?= (isset($lastname) && !empty($lastname)) ? ' valid': ''?>" type="text" name="lastname" value="<?php echo $lastname; ?>" data-error=".error2"/>
              <label class="has"><?= $text_lastname; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error2"><?= isset($error_lastname) ? $error_lastname : ''; ?></div>
            </div>
          </div>

          <?php foreach ($custom_fields as $custom_field) { ?>
            <?php if ($custom_field['location'] == 'account') { ?>
              <?php if ($custom_field['type'] == 'text') { ?>
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                  <div class="contacts contacts__input-holder">
                    <input class="contacts__input<?= isset($account_custom_field[$custom_field['custom_field_id']]) ? ' valid' : !empty($custom_field['value']) ? ' valid': ''; ?>" type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" data-error=".error_custom_<?php echo $custom_field['custom_field_id']; ?>"/>
                    <label class="has"><?php echo $custom_field['name']; ?></label>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <div class="error_custom_<?php echo $custom_field['custom_field_id']; ?>"><?= isset($error_custom_field[$custom_field['custom_field_id']]) ? $error_custom_field[$custom_field['custom_field_id']] : ''; ?></div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>

            <?php if ($custom_field['type'] == 'select') { ?>
              <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
                <div class="contacts">
                  <div class="contacts__input-holder ">
                    <select class="contacts__input contacts__input--select <?= (isset($custom_field['custom_field_value']) && !empty($custom_field['custom_field_value'])) ? ' valid' : ''; ?>" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="gender" data-error=".error_custom_<?php echo $custom_field['custom_field_id']; ?>">
                      <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                      <?php if (isset($account_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $account_custom_field[$custom_field['custom_field_id']]) { ?>
                      <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    <label class="select has align--1"><?php echo $custom_field['name']; ?></label>
                    <label class="control" for="gender"><i class="icon"></i></label>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <div class="error_custom_<?php echo $custom_field['custom_field_id']; ?>">
                      <?= isset($error_custom_field[$custom_field['custom_field_id']])? $error_custom_field[$custom_field['custom_field_id']]:''; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <?php if ($custom_field['type'] == 'date') { ?>
            <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
              <div class="contacts contacts__input-holder input-group ">
                <input id="bday" class="contacts__input form-control<?= isset($account_custom_field[$custom_field['custom_field_id']]) ? ' valid' : !empty($custom_field['value']) ? ' valid': ''; ?>" type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($account_custom_field[$custom_field['custom_field_id']]) ? $account_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" data-error=".error_custom_<?php echo $custom_field['custom_field_id']; ?>"/>
                <label class="has"><?php echo $custom_field['name']; ?></label>
                <label for="bday" class="calendar">
                  <i class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                      <path id="calendar" class="cls-1" d="M925,917h14v1H925v-1Zm0,13h14v1H925v-1Zm-1-13h1v14h-1V917Zm15,0h1v14h-1V917Zm-12,6h2v2h-2v-2Zm4,0h2v2h-2v-2Zm4,0h2v2h-2v-2Zm-8,3h2v2h-2v-2Zm4,0h2v2h-2v-2Zm4,0h2v2h-2v-2Zm-8-6h2v2h-2v-2Zm4,0h2v2h-2v-2Zm4,0h2v2h-2v-2Z" transform="translate(-924 -917)"/>
                    </svg>
                  </i>
                </label>
                <span class="highlight"></span>
                <span class="bar"></span>
                <div class="error_custom_<?php echo $custom_field['custom_field_id']; ?>">
                  <?= isset($error_custom_field[$custom_field['custom_field_id']])? $error_custom_field[$custom_field['custom_field_id']]:''; ?>
                </div>
              </div>
            </div>
            <?php } ?>

          <?php } ?>




          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="contacts contacts__input-holder">


                <input class="contacts__input<?= (isset($telephone) && !empty($telephone)) ? ' valid': ''?>" value="<?= $telephone; ?>" id="phone" type="tel" name="telephone" data-error=".error6"/>

              <label class="has"><?php echo $entry_telephone; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error6"><?= isset($error_telephone) ? $error_telephone : ''; ?></div>
            </div>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="contacts contacts__input-holder">
              <input class="contacts__input<?= (isset($email) && !empty($email)) ? ' valid': ''?>" type="email" name="email" value="<?php echo $email; ?>"  data-error=".error7"/>
              <label class="has"><?= $entry_email; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error7"><?= isset($error_email) ? $error_email : ''; ?></div>
            </div>
          </div>

          <?php $is_error = (!empty($error_password) || !empty($error_confirm)) ? 1 : 0; ?>
          <div class="contacts__input-holder col-12">
            <div class="row justify-content-between">
              <div class="contacts__c-holder col-12">
                <div class="checkbox">
                  <input id="subscribe-input" name="repass" value="1" class="checkbox__core" type="checkbox"<?= $is_error ? ' checked':''; ?>/>
                  <label for="subscribe-input" class="checkbox__control"><i class="icon"></i></label>
                </div>
                <p class="account__subscribe">
                  <?= $text_change_pass; ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="account__pass contacts contacts__input-holder contacts__input-holder--none"<?= $is_error ? ' style="display:block;"':''; ?>>
              <input id="pass1" class="contacts__input" type="password" name="password" data-error=".error8"/>
              <label class="has"><?= $text_password; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error8">
                <?php if ($error_password) { ?>
                <?php echo $error_password; ?>
                <?php } ?>
              </div>
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
            </div>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-6 col-sm-10 col-12 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-0">
            <div class="account__pass contacts contacts__input-holder contacts__input-holder--none"<?= $is_error ? ' style="display:block;"':''; ?>>
              <input id="pass2" class="contacts__input" type="password" name="confirm" data-error=".error9"/>
              <label class="has"><?= $entry_confirm; ?></label>
              <span class="highlight"></span>
              <span class="bar"></span>
              <div class="error9">
                <?php if ($error_confirm) { ?>
                  <?php echo $error_confirm; ?>
                <?php } ?>
              </div>
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
          <div class="contacts__input-holder col-xl-6 col-lg-6 col-md-6 col-12">
            <input class="btn btn--account" type="submit" value="<?= $text_save; ?>" />
          </div>
        </form>
      </div>

    </div>
  </section>
  <!-- END: account -->
</main>
<?php echo $footer; ?>
