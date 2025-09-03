<?php echo $header; ?>
<!-- Begin: main -->
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
  <h1 class="category__title"><?php echo $heading_title; ?></h1>

  <!-- BEGIN: category -->
  <section class="category container">
    <!-- BEGIN: category content controls -->
    <div class="row justify-content-xl-between justify-content-lg-between">
      <div class="col-md-5 col-sm-7 col-xs-12 col-12 d-xl-none d-lg-none d-block">
        <div class="top-drop">
          <a href="/katalog/" class="top-drop__title"><?= $text_categories; ?></a>
          <label class="top-drop__control top-drop__control--close">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="5" viewBox="0 0 9 5">
              <path id="arrow-mini-down" class="cls-1" d="M231.056,880.819l-3.87-3.774a0.6,0.6,0,0,1,0-.869,0.643,0.643,0,0,1,.892,0l3.424,3.339,3.424-3.339a0.641,0.641,0,0,1,.891,0,0.6,0.6,0,0,1,0,.869l-3.87,3.774A0.641,0.641,0,0,1,231.056,880.819Z" transform="translate(-227 -876)"/>
            </svg>

          </label>
          <div class="top-drop__wrapper animated">
            <ul class="sale">
              <li class="sale__item">
                <a href="<?= $sale_cat['href']; ?>" class="sale__link"><?= $sale_cat['name']; ?></a>
                <label class="sub-items__quantity">(<?= $sale_cat['count']; ?>)</label>
              </li>
            </ul>
            <ul class="sidebar category__sidebar">
              <?php foreach($categories as $cat): ?>
              <li class="sidebar__item">
                <a href="<?= $cat['href']; ?>" class="sidebar__link"><?= $cat['name']; ?></a>

                <?php if (!empty($cat['children'])): ?>
                <label class="sidebar__control"></label>
                <ul class="sub-items sidebar__sub-items">
                  <?php foreach($cat['children'] as $catch): ?>
                  <li class="sub-items__item">
                    <a href="<?= $catch['href']; ?>" class="sub-items__link"><?= $catch['name']; ?></a>
                    <label class="sub-items__quantity"><?= $catch['count']; ?></label>
                  </li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

      </div>
      <div class="col-xl-auto col-lg-auto col-md-auto col-sm-auto col-xs-12 col-12 offset-xl-2 offset-lg-3 offset-0">
        <div class="btn-holder">
          <input type="checkbox" class="shares" id="sharesNew" data-filter='new'/>
          <input type="checkbox" class="shares" id="sharesSale" data-filter='sale'/>
          <a href="<?= $filter_new; ?>">
          </a>
          <label for="sharesNew" class="btn btn--new">
            <i class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12">
                <path class="cls-1" d="M496.772,830.492l-3.579-3.762L492,827.984,496.772,833,507,822.253,505.806,821Z" transform="translate(-492 -821)"/>
              </svg>
            </i>
            <span class="text">new</span>
          </label>
          <a href="<?= $filter_sale; ?>">

          </a>
          <label for="sharesSale" class="btn btn--sale">
            <i class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12">
                <path id="check-big" class="cls-1" d="M496.772,830.492l-3.579-3.762L492,827.984,496.772,833,507,822.253,505.806,821Z" transform="translate(-492 -821)"/>
              </svg>
            </i>
            <span class="text">sale</span>
          </label>
        </div>
      </div>
      <!-- BEGIN: pagination top -->
      <nav class="d-xl-block d-lg-block d-none col-auto">
        <ul class="pagination">
          <?php echo $pagination; ?>
        </ul>
      </nav>
      <!-- END: pagination top -->
      <div class="col-auto d-xl-block d-lg-block d-md-block d-none">
        <div class="btn-holder btn-holder--2">
          <a href="<?= $limit_all; ?>" class="allprod-link">

          </a>
          <input type="checkbox" class="allprod" id="allprod" />
          <label for="allprod" class="control btn btn--category">
            <i class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12">
                <path class="cls-1" d="M496.772,830.492l-3.579-3.762L492,827.984,496.772,833,507,822.253,505.806,821Z" transform="translate(-492 -821)"/>
              </svg>
            </i>
            <span class="text"><?= $text_all_products_page; ?></span>
          </label>
          <div class="select">
            <select name="limit" id="" class="select-size" style="display: none;">
              <?php foreach($limits as $lim): ?>
              <option value="<?= $lim['href'];?>"<?= ($limit == $lim['value'])? ' selected': '';?>><?= $lim['text'];?></option>
              <?php endforeach; ?>
            </select>
            <div class="selected selected--category">
              <span class="text"></span>
              <ul class="select-list select-list--category"></ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: category content controls -->
    <div class="row">
      <!-- BEGIN: category left sidebar -->
      <div class="d-xl-block d-lg-block d-none col-xl-2 col-3">
        <h4 class="sidebar__title"><?= $text_categories ?></h4>
        <ul class="sale">
          <li class="sale__item">
            <a href="<?= $sale_cat['href']; ?>" class="sale__link"><?= $sale_cat['name']; ?></a>
            <label class="sub-items__quantity">(<?= $sale_cat['count']; ?>)</label>
          </li>
        </ul>
        <ul class="sidebar category__sidebar">
          <?php foreach($categories as $cat): $activesub = ''; ?>

          <?php foreach($cat['children'] as $catch2): if ($category_id == $catch2['category_id']) { $activesub = ' act'; break; }  endforeach;?>


          <li class="sidebar__item<?= $activesub. ($cat['category_id'] == $category_id)? ' act':''; ?>">
            <a href="<?= $cat['href']; ?>" class="sidebar__link"><?= $cat['name']; ?></a>

            <?php if (!empty($cat['children'])): ?>
            <label class="sidebar__control"></label>
            <ul class="sub-items sidebar__sub-items">
              <?php foreach($cat['children'] as $catch): ?>
              <li class="sub-items__item<?= ($catch['category_id'] == $category_id)? ' act':''; ?>">
                <a href="<?= $catch['href']; ?>" class="sub-items__link"><?= $catch['name']; ?></a>
                <label class="sub-items__quantity"><?= $catch['count']; ?></label>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- END: category left sidebar -->
      <!-- BEGIN: category content -->
      <div class="col-xl-10 col-lg-9 col-12">
        <div class="row">

          <?php foreach ($products as $prod): ?>
          <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
            <div class="card animated fadeIn">
              <a href="<?= $prod['href']; ?>">
                <img class="card__image" src="<?= $prod['thumb']; ?>" alt="<?= $prod['name']; ?>">
              </a>
              <div data-pid="<?php echo $prod['product_id']; ?>" class="card__like<?= in_array($prod['product_id'], $user_wishlist) ? ' active': ''; ?>">
                <i class="icon">
                  <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                       viewBox="0 0 16 15" style="enable-background:new 0 0 16 15;" xml:space="preserve">
                                          <style type="text/css">
                                            .st0{fill:#17363D;}
                                          </style>
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
                <p class="card__code"><?= $prod['model']; ?></p>
              </div>
              <div class="card__footer">
                <button class="card__btn minus"></button>
                <div class="card__counter" data-min="<?php echo $prod['minimum']; ?>"><input type="text" value="<?php echo $prod['minimum']; ?>"></div>
                <button class="card__btn plus"></button>


                <a href="#" title="<?= $text_add_cart; ?>" class="card__bucket" data-product-id="<?php echo $prod['product_id']; ?>">
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

          <!-- BEGIN: pagination bottom -->
          <nav class="col-12 d-xl-block d-lg-block d-md-block d-none">
            <div class="row justify-content-center">
              <div class="col-auto">
                <?php echo $pagination; ?>
              </div>
            </div>
          </nav>
          <!-- END: pagination bottom -->
        </div>
      </div>
      <!-- END: category content -->
    </div>
  </section>
  <!-- END: category -->

</main>
<!-- End: main -->
<?php echo $footer; ?>
