<?php echo $header; ?>

<!--this_is_product-->
<!-- Begin: main -->
    <main class="main">
    <!-- BEGIN: breadcrumb -->
    <div class="category container d-xl-block d-lg-block d-md-block d-none">
        <div class="row">
            <div class="col-12">
                <ul class="breadcrumb">
                    <?php
                    $snippet_info = array();
                    ?>
                    <?php foreach($breadcrumbs as $bk => $br): ?>
                    <?php
                        $snippet_info[] = [
                            "@type" => "ListItem",
                            "position" => sizeof($snippet_info) + 1,
                            "name" => $br['text'],
                            "item" => $br['href'],
                        ];
                    ?>
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
                    <?php
                    if (sizeof($snippet_info) > 0){
                        ?>
                        <script type="application/ld+json">
                        {
                            "@context": "http://schema.org",
                            "@type": "BreadcrumbList",
                            "itemListElement": <?= json_encode($snippet_info); ?>
                        }
                        </script>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: breadcrumb -->

    <h3 class="category__title"><?php echo $category_title; ?></h3>

    <!-- BEGIN: category -->
    <section class="category category--product container">
        <!-- BEGIN: controls -->
        <div class="row d-none justify-content-xl-between">
            <div class="top-drop-w d-xl-none d-lg-none d-block">
                <div class="top-drop top-drop--product">
                    <span class="top-drop__title"><?= $text_categories; ?></span>
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
                                <span class="sidebar__link"><?= $cat['name']; ?></span>

                                <?php if (!empty($cat['children'])): ?>
                                <label class="sidebar__control"></label>
                                <ul class="sub-items sidebar__sub-items">
                                    <?php foreach($cat['children'] as $catch): ?>
                                      <li class="sub-items__item">
                                          <span class="sub-items__link"><?= $catch['name']; ?></span>
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
            <div class="top-drop-w d-xl-none d-lg-none d-md-none d-block">
                <!-- BEGIN: product navigation -->
                <div class="product-nav">
                    <a href="<?= $product_nav['prev']; ?>" class="product-nav__prev">
                        <i class="icon"></i>
                        <span class="text"><?= $text_prev_product; ?></span>
                    </a>
                    <a href="<?= $product_nav['next']; ?>" class="product-nav__next">
                        <span class="text"><?= $text_next_product; ?></span>
                        <i class="icon"></i>
                    </a>
                </div>
                <!-- END: product navigation -->
            </div>
        </div>
        <!-- BEGIN: controls -->
        <div class="row">
            <!-- BEGIN: category left sidebar -->
            <div class="holiday-sidebar  d-none col-lg-3 col-xl-2 col-auto"><!-- d-xl-block d-lg-block -->
                <h4 class="sidebar__title sidebar__title--item "><?= $text_categories ?></h4>
                <ul class="sale">
                    <li class="sale__item">
                        <a href="<?= $new_cat['href'] ?>" class="sale__link" style="color: #43b9d4"><?= $new_cat ['name'] ?></a>
                    </li>
                </ul>
                <ul class="sale">
                    <li class="sale__item sale__item--product">
                        <a href="<?= $sale_cat['href']; ?>" class="sale__link"><?= $sale_cat['name']; ?></a>
                    </li>
                </ul>
                <?php if ($fete_cat['count']): ?>
                <ul class="sale">
                    <li class="sale__item sale__item--product">
                        <a href="<?= $fete_cat['href']; ?>" class="sale__link"><?= $fete_cat['name']; ?></a>
                    </li>
                </ul>
                <?php endif; ?>
                <ul class="sidebar category__sidebar">
                    <?php foreach($categories as $cat): ?>
                      <li class="sidebar__item">
                          <span class="sidebar__link"><?= $cat['name']; ?></span>

                          <?php if (!empty($cat['children'])): ?>
                          <label class="sidebar__control sidebar__control--product"></label>
                          <ul class="sub-items sidebar__sub-items">
                              <?php foreach($cat['children'] as $catch): ?>
                                <li class="sub-items__item">
                                    <a href="<?= $catch['href']; ?>" class="sub-items__link"><?= $catch['name']; ?></a>
                                    <label class="sub-items__quantity sub-items__quantity--product"><?= $catch['count']; ?></label>
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
            <div class="col-xl-12 col-lg-12 col-12">
                <div class="row">
                    <div class="col-photo col-sm-auto col-12 left">
                        <?php /* if ($thumb || $images): */ ?>
                            <?php /* if ($thumb):*/ ?>
                              <img id="zoom_01" data-zoom-image="<?= $popup; ?>" class="product__photo" src="<?= $thumb; ?>" alt="<?= $heading_title; ?>" title="<?= $heading_title; ?>"/>
                            <?php /*endif;*/ ?>

                            <div class="slider-wrapper">
                            <?php if ($images): ?>
                            <!-- BEGIN: slider -->
                                <div class="product-slider animated">
                                    <div class="item" data-origin="<?= $popup; ?>">
                                        <img class="img thumb_image1" name="<?= $thumb; ?>" id="<?= $popup; ?>" data-zoom-image="<?= $popup; ?>" src="<?= $thumb; ?>" alt="<?= $heading_title; ?>"/>
                                    </div>

                                    <?php foreach ($images as $image): ?>
                                    <div class="item" data-origin="<?= $image['popup']; ?>">
                                        <img class="img thumb_image1" name="<?= $image['popup']; ?>" id="<?= $image['popup']; ?>" data-zoom-image="<?= $image['popup']; ?>" src="<?= $image['thumb']; ?>" alt="<?= $heading_title; ?>"/>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                          </div>
                            <!-- END: slider -->
                        <?php /* endif; */ ?>

                <!-- BEGIN: product navigation -->
                        <div class="product-nav d-xl-flex d-lg-flex d-md-flex d-none">
                            <a href="<?= $product_nav['prev']; ?>" class="product-nav__prev">
                                <i class="icon"></i>
                                <span class="text"><?= $text_prev_product; ?></span>
                            </a>
<!--                            --><?//= var_dump($product_nav) ?>
                            <a href="<?= $product_nav['next']; ?>" class="product-nav__next">
                                <span class="text"><?= $text_next_product; ?></span>
                                <i class="icon"></i>
                            </a>
                        </div>
                <!-- END: product navigation -->
                    </div>
                    <div class="col-info col-sm-auto col-12">
                        <!-- BEGIN: product-info -->
                        <div class="product-info">
                            <div class="product-info__main-holder">
                                <h1 class="product-info__title"><?php echo $heading_title; ?></h1>
                                <div class="product-info__price-holder">
                                    <?= ($special) ? '<div class="product-info__old">' . $price . '</div><div data-old="true" class="product-info__price">' . $text_price . $special . '</div>' : '<div class="product-info__price">' . $text_price . $price . '</div>'; ?>
                                </div>
                                <div class="product-info__code"><?= $model; ?></div>
                                <!--dg_prod_mpn:<?=str_replace("Code","",$model);?>-->
                                <!--seoshield_formulas--kartochka-tovara-->
                            </div>
                            <div class="product-controls product-info__product-controls">

                                <button class="product-controls__btn minus"></button>
                                <div class="product-controls__counter"><input data-min="<?php echo $minimum; ?>" type="text" value="<?php echo $minimum; ?>" /></div>
                                <button class="product-controls__btn plus"></button>

                                <button class="product-controls__btn like-product like<?= in_array($product_id, $user_wishlist) ? ' active': ''; ?>" data-pid="<?php echo $product_id ?>">
                                    <i class="icon">
                                        <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 16 15" style="enable-background:new 0 0 16 15;" xml:space="preserve">
                                        <style type="text/css">
                                            .stb{fill:#17363D;}
                                        </style>
                                        <g id="Page-1">
                                            <g id="_x30_1-main" transform="translate(-1799.000000, -34.000000)">
                                                <g id="sss" transform="translate(1798.000000, 33.000000)">
                                                    <path id="Shape" class="stb" d="M4.8000002,9C5.9000001,10.3000002,8,12.5,9,13.6000004c0.5-0.5,0.8999996-1,1.3999996-1.5
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
                                </button>
                                <a href="#" title="<?= $text_add_cart; ?>" class="product-controls__bucket" data-product-id="<?php echo $product_id; ?>" data-text-in-backet="<?= $text_to_backet; ?>">
                                    <i class="icon">
                                        <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve">

                                        <g id="Page-1">
                                            <g id="_x30_1-main" transform="translate(-1840.000000, -33.000000)">
                                                <g id="cart" transform="translate(1840.000000, 33.000000)">
                                                    <path id="Shape" class="stb" d="M15.5,3.4000001C15.20263,3.123208,14.8057051,2.9788718,14.3999996,3H4.6999998L4.0999999,1.1
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
                                    <span class="text"><?= $text_add_cart; ?></span>
                                </a>
                            </div>

                            <?php if ($attribute_groups): ?>
                            <div class="additional-info__title d-md-block d-none"><?= $text_adding_info; ?></div>
                            <table class="additional-info product-controls__additional-info d-md-block d-none">
                                <?php foreach($attribute_groups as  $group): ?>
                                       <?php foreach ($group['attribute'] as $attribute): ?>
                                       <tr>
                                            <td class="additional-info__name">
                                                <strong><?php echo $attribute['name']; ?>:&nbsp;</strong>
                                            </td>
                                            <td class="additional-info__text">
                                                <?php echo $attribute['text']; ?>
                                            </td>
                                        </tr>
                                       <?php endforeach; ?>
                                <?php endforeach; ?>
                            </table>
                            <?php endif; ?>
                    </div>
                </div>
                <!--<div class="col-md-12" style="display: none">
                    <?php if (isset($seo_text)) { ?>
                    <div id="seo_text_generator" class="seo_text_generator"><?php echo $seo_text; ?></div>
                    <div class="seo_more_generator" data-text-more="<?=$text_seo_more; ?>" data-text-hide="<?=$text_seo_hide; ?>"><?=$text_seo_more; ?></div>
                    <?php } ?>
                </div>-->
                <div class="col-md-12">
                    <!--seo_text_start--><!--seo_text_end-->
                </div>
                <!-- BEGIN: product-info -->
            </div>

            <div class="row" data-empty='<?= ($attribute_groups) ? 'false': 'true' ?>'>
                <div class="col-12 d-md-none d-sm-block">
                    <?php if ($attribute_groups): ?>
                    <div class="additional-info__title"><?= $text_adding_info; ?></div>
                    <ul class="additional-info product-controls__additional-info">
                        <?php foreach($attribute_groups as  $group): ?>
                            <?php foreach ($group['attribute'] as $attribute): ?>
                            <li class="additional-info__text">
                                <strong><?php echo $attribute['name']; ?>:&nbsp;</strong><?php echo $attribute['text']; ?>
                            </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
              </div>

              <div class="product-block-separator"></div>
                <?php if ($products): ?>
                <!-- BEGIN: similar-products__title -->
                <h3 class="similar-products"><?php echo $text_similar; ?></h3>
                <div class="animated" id="similar-products">
                    <?php foreach($products as $prod): ?>
                    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12"> -->
                        <div class="card">
                            <a href="<?= $prod['href']; ?>">
                                <img class="card__image" src="<?= $prod['thumb']; ?>" alt="<?= $prod['name']; ?>">
                            </a>

                            <div class="card__like<?= in_array($prod['product_id'], $user_wishlist) ? ' active': ''; ?>" data-pid="<?= $prod['product_id']; ?>">
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
                                <a href="" class="card__text"><?= $prod['name']; ?></a>
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
                    <!-- </div> -->
                    <?php endforeach; ?>
                </div>
                <!-- END: similar-products__title -->
                <?php endif; ?>
<script type="application/ld+json">
{
    "@context":"http://schema.org/",
    "@type":"Product",
    "name":"<!--place_h1_here-->",
    "image":[
        "<?= $popup; ?>"
    ],
    "description":"<!--place_description_here-->",
    "mpn":"<?= $model; ?>",
    "sku":"<?= $model; ?>",
    "brand":{
        "@type":"Thing",
        "name":"Wallishcompany"
    },
    "offers":{
        "@type":"Offer",
        "url":"<?= 'http'.(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] ? 's' : '') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>",
        "priceCurrency":"UAH",
        "price":"<?= rtrim(preg_replace('#[^0-9\.]#', '', $special ? $special : $price), '.'); ?>",
        "availability":"http://schema.org/InStock",
        "seller":{
            "@type":"Organization",
            "name":"Wallishcompany"
        }
    }
}
</script>
                <!-- BEGIN: pagination bottom -->
                <?php /*
                <div class="row">
                    <nav class="col-auto offset-xl-4 offset-lg-4 offset-md-4">
                        <ul class="pagination">
                            <li class="pagination__item"><a href="#" class="pagination__link"></a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link">01</a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link active">02</a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link">03</a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link">04</a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link">05</a></li>
                            <li class="pagination__item"><a href="#" class="pagination__link"></a></li>
                        </ul>
                    </nav>
                </div>
                */ ?>
                <!-- END: pagination bottom -->
            </div>
            <!-- END: category content -->
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($seo_text)) { ?>
                <div id="seo_text_generator" class="seo_text_generator"><?php echo $seo_text; ?></div>
                <div class="seo_more_generator" data-text-more="<?=$text_seo_more; ?>" data-text-hide="<?=$text_seo_hide; ?>"><?=$text_seo_more; ?></div>
                <?php } ?>
            </div>
        </div>
        </div>
    </section>
    <!-- END: category -->


</main>
<!-- End: main -->
<script type="text/javascript">

    $(document).ready(function() {

        $("#zoom_01").elevateZoom({zoomType: "inner"});
        $('.thumb_image1').click(function(){

            small_image = $(this).attr('name');
            large_image = $(this).attr('id');
            $('#zoom_01').attr('src',small_image);
            $('#zoom_01').attr('data-zoom-image',large_image);
            smallImage = small_image;
            largeImage = large_image;
            var ez =   $('#zoom_01').data('elevateZoom');
            ez.swaptheimage(smallImage, largeImage);

        });
    });
</script>
<?php echo $footer; ?>
