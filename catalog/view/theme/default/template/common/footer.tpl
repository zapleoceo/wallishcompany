<?php $phones = explode(',', $telephone); ?>

<!-- Begin: footer -->
<footer class="footer">

  <style type="text/css">
    .span_h1_footer {
      font-family: "Gotham Pro Regular";
      font-size: 16px;
      text-align: center;
      text-transform: uppercase;
      font-weight: 600;
      margin-bottom: 30px;
      display: block;
    }
  </style>

  <?php if (!$nosubscribe): ?>
    <div class="footer__thanks-for-subscribe">
        <p>
          <label class="close"></label>
          <?= $text_sps_subscribe; ?>
        </p>
    </div>
    <div class="footer__separator"></div>
    <div class="container">
      <span class="footer__title span_h1_footer"><?= $text_subscribe_title; ?></span>
      <div class="footer__form-holder">
        <form method="post" id="footerSubscribe" action="/subscribe.php" class="row justify-content-center">
          <input class="footer__input" name="email" type="email" placeholder="<?= $text_you_email; ?>">
          <input class="footer__btn" type="submit" value="<?= $text_tosubscribe; ?>">
        </form>
      </div>
    </div>
  <?php endif; ?>

  <div class="footer__info-holder container-fluid">
    <div class="container">
      <div class="row">
        <div class="footer__list footer__list--1">
          <h4 class="footer__category"><?= $text_menu; ?></h4>
          <div class="list row">
            <?php foreach($this->registry->get('load')->controller('module/we_menu', array('module_id' => 39)) as $m): ?>
              <p class="list__item">
                <a href="<?= $m['url']; ?>"><?= $m['name']; ?></a>
              </p>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="footer__v-line"></div>
        <div class="footer__list footer__list--2">
          <h4 class="footer__category"><?= $text_catalog; ?></h4>
          <div class="list row">
            <?php foreach($this->registry->get('load')->controller('module/we_menu', array('module_id' => 40)) as $m): ?>
            <p class="list__item">
              <a href="<?= $m['url']; ?>"><?= $m['name']; ?></a>
            </p>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="footer__v-line"></div>
        <div class="footer__info">
          <div class="md-column-1">
            <div class="phone-group">
              <?php foreach($phones as $phone): ?>
              <a class="phone-group__number" href="tel:+<?= str_replace(array('+',' ', '-','(',')'),'', $phone); ?>">
                <?= $phone; ?>
              </a>
              <?php endforeach; ?>
            </div>
            <div class="footer__email">
              <a class="footer__email" href="mailto:<?= $email; ?>"><?= $email; ?></a>
            </div>
          </div>
          <div class="footer__v-line footer__v-line--show"></div>
          <div class="md-column-2">
            <div class="address-group">
              <a href="<?= $contact; ?>#map">
                <p class="address-group__address"><?= $store_address; ?></p>
              </a>
            </div>
            <div class="socials">
              <div class="socials__icon-holder facebook">
                <a href="<?= $link_facebook; ?>" class="socials__link">
                  <i class="socials__icon">
                      <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                      viewBox="0 0 4 8" style="enable-background:new 0 0 4 8;" xml:space="preserve">
                   <title>facebook</title>
                   <g id="Page-1">
                     <g id="_x30_1-main" transform="translate(-137.000000, -36.000000)">
                       <g id="_x30_06-facebook-letter-logo" transform="translate(137.000000, 36.000000)">
                         <path id="Facebook" class="st4" d="M0.8645788,1.5493453c0,0.2016033,0,1.1014433,0,1.1014433H0v1.3468492h0.8645788V8h1.7760285
                           V3.9977493h1.1917977c0,0,0.1116171-0.6458037,0.1657217-1.3519268c-0.1551199,0-1.3508036,0-1.3508036,0
                           s0-0.7835541,0-0.9208951c0-0.1376386,0.1936409-0.322781,0.38503-0.322781c0.1910305,0,0.5942149,0,0.9676468,0
                           C4,1.2187709,4,0.5851685,4,0C3.5014796,0,2.9343271,0,2.6843295,0C0.8206773-0.000093,0.8645788,1.3480954,0.8645788,1.5493453z
                           "/>
                       </g>
                     </g>
                   </g>
                   </svg>
                  </i>
                </a>
              </div>
              <div class="socials__icon-holder instagram">
                <a href="<?= $link_instagramm; ?>" class="socials__link">
                  <i class="socials__icon">
                      <svg version="1.1" id="Isolation_Mode" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                      y="0px" viewBox="0 0 7 7" style="enable-background:new 0 0 7 7;" xml:space="preserve">
                      <title>instagram</title>>
                   <g>
                     <path class="st4" d="M5.1086426,0H1.8913574C0.8484497,0,0,0.8484497,0,1.8913574v3.2172852C0,6.1515503,0.8484497,7,1.8913574,7
                       h3.2172852C6.1515503,7,7,6.1515503,7,5.1086426V1.8913574C7,0.8484497,6.1515503,0,5.1086426,0z M4.7045288,4.3933716
                       c-0.2386475,0.3217773-0.5883179,0.531311-0.9845581,0.5900879C3.6453857,4.9945679,3.5708618,5,3.4968262,5
                       C3.1774902,5,2.8677979,4.8982544,2.6065674,4.7045288c-0.3217163-0.2387085-0.53125-0.5883789-0.5900269-0.9846802
                       c-0.0587769-0.3962402,0.0402832-0.791748,0.2789307-1.1135254c0.2386475-0.3217163,0.5882568-0.531311,0.9845581-0.5900879
                       c0.1459351-0.0216675,0.2939453-0.0216675,0.4399414,0C4.0405884,2.0637817,4.3312378,2.210083,4.5604248,2.4393311
                       c0.229187,0.229187,0.3754883,0.5198364,0.4230347,0.8405151C5.0422363,3.6761475,4.9431763,4.0715942,4.7045288,4.3933716z
                        M5.8535767,1.8535767C5.760437,1.9466553,5.6315308,2,5.5,2S5.239563,1.9466553,5.1464233,1.8535767
                       C5.0533447,1.760437,5,1.6317749,5,1.5s0.0533447-0.260437,0.1464233-0.3535767C5.239563,1.0533447,5.3684692,1,5.5,1
                       s0.260437,0.0533447,0.3535767,0.1464233C5.9466553,1.239563,6,1.3684082,6,1.5
                       C6,1.6315308,5.9466553,1.760437,5.8535767,1.8535767z"/>
                   </g>
                   </svg>
                  </i>
                </a>
              </div>
              <div class="socials__icon-holder pinterest">
                <a href="<?= $link_pinterest; ?>" class="socials__link">
                  <i class="socials__icon">
                      <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                      viewBox="0 0 6 7" style="enable-background:new 0 0 6 7;" xml:space="preserve">
                   <title>pinterest</title>
                   <g id="Page-1">
                     <g id="_x30_1-main" transform="translate(-214.000000, -37.000000)">
                       <g id="_x30_03-pinterest" transform="translate(214.000000, 37.000000)">
                         <path id="XMLID_799_" class="st4" d="M5.2218575,0.7173191C4.696382,0.2547598,3.969182,0,3.1742227,0
                           C1.9598831,0,1.2130101,0.4564409,0.800302,0.8393257C0.291668,1.3111867,0,1.9377234,0,2.5583222
                           c0,0.7792029,0.3554381,1.3772697,0.9506664,1.599767c0.0399609,0.0150137,0.0801681,0.0225773,0.1195873,0.0225773
                           c0.1255704,0,0.2250665-0.0753398,0.2595369-0.1961951c0.0200912-0.069334,0.0666507-0.2403781,0.0868897-0.3146341
                           c0.0433341-0.1466382,0.0083221-0.217169-0.0861758-0.3192852C1.15835,3.1637719,1.078182,2.9429002,1.078182,2.6554489
                           c0-0.8538202,0.6933455-1.761261,1.9783986-1.761261c1.0196319,0,1.6530237,0.5313968,1.6530237,1.3867974
                           c0,0.5397954-0.1268015,1.0396972-0.3571124,1.407681C4.192451,3.9443519,3.9110255,4.2491426,3.4789896,4.2491426
                           c-0.1868291,0-0.3546503-0.0703731-0.4605479-0.1930566C2.9184039,3.9401073,2.8854356,3.7902858,2.9256673,3.6341429
                           c0.0454516-0.1764174,0.1074243-0.3604431,0.1674025-0.5383506c0.1093941-0.3249295,0.212805-0.6318197,0.212805-0.8766682
                           c0-0.4188049-0.2807853-0.7002057-0.6986394-0.7002057c-0.5310397,0-0.9470716,0.4945737-0.9470716,1.1259419
                           c0,0.3096447,0.0897459,0.5412402,0.1303716,0.6301715C1.7236384,3.5349391,1.326048,5.0801373,1.2506319,5.3715172
                           c-0.0436049,0.1700954-0.3062932,1.513545,0.1285003,1.6206732c0.4885181,0.1203585,0.9251831-1.1880736,0.9696252-1.3359313
                           C2.384779,5.5360136,2.5108171,5.0813336,2.5880551,4.8018293C2.8238814,5.0101256,3.2035964,5.150939,3.5730689,5.150939
                           c0.696522,0,1.322921-0.2874064,1.7638209-0.8092303C5.7644939,3.8355756,6,3.130132,6,2.355422
                           C6,1.7497691,5.7163587,1.1526955,5.2218575,0.7173191z"/>
                       </g>
                     </g>
                   </g>
                   </svg>
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer__rights-holder container">
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 f-order-2">
        <p class="footer__rights">© <?= date('Y'); ?>. <?= $text_copyrite; ?>
        made by ZAPLEOsoft
        </p> 
      </div>
    
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 f-order-1">
        <div class="row justify-content-lg-end justify-content-md-center justify-content-sm-end">
          <p class="footer__rights f-order-2 f-max-width"><?= $text_our_gift_wrapping; ?></p>
          <a href="http://wallishcompany.com/" class="f-order-1 f-max-width">
            <div class="footer__rights-logo f-order-1 f-max-width"></div>
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- End: footer -->
<script src="<?= STYLE_PATH; ?>airpicker/js/datepicker.js" type="text/javascript"></script>
<script src="<?= STYLE_PATH; ?>js/owl.carousel.min.js<?= CSSJS; ?>"></script>
<script src="<?= STYLE_PATH; ?>js/bootstrap.bundle.min.js<?= CSSJS; ?>"></script>
<script src="<?= STYLE_PATH; ?>js/swiper.jquery.js<?= CSSJS; ?>"></script>
<script src="<?= STYLE_PATH; ?>../javascript/common.js<?= CSSJS; ?>" type="text/javascript"></script>


<script src="<?= STYLE_PATH; ?>js/main.js<?= CSSJS; ?>"></script>
<script src="<?= STYLE_PATH; ?>js/simplebar.js"></script>
<script src="<?= STYLE_PATH; ?>js/select2.min.js"></script>
<script src="<?= STYLE_PATH; ?>js/d3.min.js"></script>
<script src="<?= STYLE_PATH; ?>js/reduction.js"></script>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

<?php foreach ($scripts as $script) { if (strpos($script, 'owl.carousel.min.js') !== false) continue; ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

<?php foreach ($scripts2 as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

</body>
</html>