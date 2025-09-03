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

  <!-- BEGIN: order -->
  <section class="pa-wish account container">
    <h1 class="account__title account__title--wishlist"><?php echo $heading_title; ?></h1>
    <div class="row">

      <!-- BEGIN: sidebar-->
      <?= isset($account_menu)? $account_menu : ''; ?>
      <!-- END: sidebar -->

      <?php if(!empty($products)): ?>
      <div class="order-align order-align--wish">
        <div class="row pa-wish__header justify-content-xl-between justify-content-lg-between justify-content-md-between justify-content-center">
          <div class="col-xl-auto col-lg-auto col-md-auto col-12">
            <p class="pa-wish__title"><?= $text_wishlists_all; ?></p>
          </div>


          <div class="col-auto">
            <a href="<?= $add_cart_products; ?>" class="btn btn--pa-wish"><span class="text"><?= $text_push_backet; ?></span></a>
          </div>
        </div>

        <div class="category row">
          <!-- BEGIN: cards -->
          <?php foreach ($products as $prod): ?>
          <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
            <div class="card">

              <a href="<?= $prod['href']; ?>">
                <img class="card__image" src="<?= $prod['thumb']; ?>" alt="<?= $prod['name']; ?>">
              </a>


              <div data-pid="<?php echo $prod['product_id']; ?>" class="card__like active">
                <i class="icon">
                  <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                       viewBox="0 0 16 15" style="enable-background:new 0 0 16 15;" xml:space="preserve">
                                          <style type="text/css">
                                            .st0{fill:#17363D;}
                                          </style>
                    <title>like</title>
                    <desc>Created with Sketch.</desc>
                    <g id="Page-1">
                      <g id="_x30_1-main" transform="translate(-1799.000000, -34.000000)">
                        <g id="sss" transform="translate(1798.000000, 33.000000)">
                          <path id="Shape" class="st0" d="M4.8000002,9C5.9000001,10.3000002,8,12.5,9,13.6000004c0.5-0.5,0.8999996-1,1.3999996-1.5
                                                          c0.9000006-1,1.9000006-2,2.8000002-3.1000004C13.8999996,8.1000004,14.8000002,7,15,5.9000001
                                                          c0.1999998-1.2000003-0.6999998-2.5-1.8999996-2.8000002S10.8000002,3.7,10.3000002,4.5
                                                          c-0.6000004,0.9000001-2,0.9000001-2.6000004,0c-0.5-0.9000001-1.5999999-1.7-2.7999997-1.4000001
                                                          S2.9000001,4.6999998,3,5.9000001C3.2,7,4.0999999,8.1000004,4.8000002,9z M9,15.8000002
                                                          c-0.3999996,0-0.8000002-0.1999998-1.0999999-0.5c-1-1-3.3000002-3.6000004-4.6000004-5.1000004
                                                          c-0.8999999-1-2-2.3999996-2.3-4.0999999c-0.3-2.1999998,1.2-4.5,3.4000001-5C6.0999999,0.7,7.8000002,1.4,9,2.9000001
                                                          C10.1999998,1.4,11.8999996,0.7,13.6000004,1.2C15.8000002,1.8,17.2999992,4,17,6.1999998
                                                          c-0.2000008,1.7000003-1.3999996,3.1000004-2.3000002,4.1000004c-0.8999996,1.0999994-1.8999996,2.0999994-2.8000002,3.0999994
                                                          C11.3000002,14,10.6999998,14.6999998,10.1000004,15.3000002C9.8000002,15.6999998,9.3999996,15.8000002,9,15.8000002z"/>
                        </g>
                      </g>
                    </g>
                                          </svg>
                </i>
              </div>


              <?php if ($prod['sale']): ?>
              <div class="card__stock card__stock--sale"><span class="text">sale</span></div>
              <?php endif; ?>

              <?php if ($prod['new']): ?>
              <div class="card__stock card__stock--new"><span class="text">New</span></div>
              <?php endif; ?>

              <div class="card__body">
                <a href="<?= $prod['href']; ?>" class="card__text"><?= $prod['name']; ?></a>
                <p class="card__price-holder">
                  <?= ($prod['special']) ? '<p class="card__old-price">' . $prod['price'] . '</p><p class="card__new-price">' . $prod['special'] . '</p>' : '<p class="card__new-price">' . $prod['price'] . '</p>'; ?>
                </p>
                <p class="card__code"><?= $prod['sku']; ?></p>
              </div>
              <div class="card__footer">
                <button class="card__btn minus"></button>
                <div class="card__counter" data-min="<?php echo $prod['minimum']; ?>"><?php echo $prod['minimum']; ?></div>
                <button class="card__btn plus"></button>


                <a href="#" class="card__bucket" data-product-id="<?php echo $prod['product_id']; ?>">
                  <i class="icon">
                    <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve">
                                              <style type="text/css">
                                                .st0{fill:#17363D;}
                                              </style>
                      <title>cart</title>
                      <desc>Created with Sketch.</desc>
                      <g id="Page-1">
                        <g id="_x30_1-main" transform="translate(-1840.000000, -33.000000)">
                          <g id="cart" transform="translate(1840.000000, 33.000000)">
                            <path id="Shape" class="st0" d="M15.5,3.4000001C15.20263,3.123208,14.8057051,2.9788718,14.3999996,3H4.6999998L4.0999999,1.1
                                                              C3.924933,0.4660744,3.3573472,0.0201142,2.7,0H1.1c-0.5522848,0-1,0.4477153-1,1s0.4477153,1,1,1H2.3L5,11
                                                              c0.2215791,0.6301298,0.8331194,1.0378227,1.5,1h6.3000002c0.6573467-0.0201139,1.2249327-0.466074,1.3999996-1.1000004
                                                              l1.6999998-5.9999995C16.055891,4.3645186,15.9018211,3.7867582,15.5,3.4000001z M12.3000002,10h-5.5l-1.5-5h8.3999996
                                                              L12.3000002,10z"/>
                            <circle id="Oval" class="st0" cx="6.5" cy="14.5" r="1.5"/>
                            <circle id="Oval_1_" class="st0" cx="12.5" cy="14.5" r="1.5"/>
                          </g>
                        </g>
                      </g>
                                              </svg>
                  </i>
                </a>
              </div>

            </div>
          </div>
          <?php endforeach; ?>

          <!-- END: cards -->
        </div>

        <!-- BEGIN: pagination -->
        <div class="order category row justify-content-center">
          <nav class="d-xl-block d-lg-block d-md-block d-none col-auto">
              <?php echo $pagination; ?>
          </nav>
          <!-- <div class="btn-holder d-xl-none d-lg-none d-md-none d-block col-12">
            <button class="btn btn--pa-wish-more"><span class="text"><?= $text_more; ?></span></button>
          </div> -->
        </div>
        <!-- END: pagination -->
        <div class="row pa-wish__footer justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">
          <div class="col-auto">
            <a href="<?= $add_cart_products; ?>" class="btn btn--pa-wish btn--pa-wish-bottom"><span class="text"><?= $text_push_backet; ?></span></a>
          </div>
        </div>
        <?php else: ?>

        <div class="order-align col-xl-9 col-lg-9 col-12">
          <div class="order row">

            <h4 class="order__title"><?= $text_empty; ?></h4>

            <div>
              <a href='/katalog/' class="btn"><span class="text"><?= $gocatalog; ?></span></a>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </section>
  <!-- END: order -->
</main>
<?php echo $footer; ?>