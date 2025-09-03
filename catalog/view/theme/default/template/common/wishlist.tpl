<div class="wishlist-wrapper dropcontent wishlist-set">
  <!-- wishlist.tpl -->
<?php if ($products) { ?>
  <!-- BEGIN: full wishlist -->
  <div class="wish-cart__detail fullwishlist">
      <section class="cart container container--smallDevice">
        <div class="row justify-content-center">
            <div class="c-info c-info--dropdown cart__c-info col-12">
              <div class="c-info__bucket-title"><?= $text_title; ?></div>
              <button type="button" class="close"><i class="icon"></i></button>
                <form action="#" id="formWishlist" method="post" enctype="multipart/form-data" data-simplebar data-simplebar-auto-hide="false" >
                    <!-- BEGIN: table-->
                    <table class="c-info__table">
                        <tbody class="c-info__content">
                        <?php foreach($products as $product): ?>
                        <tr>
                            <td class="c-info__product c-info__product--wishlist">
                                <figure class="t-product">
                                    <p class="t-product__pic-holder">
                                        <img class="t-product__pic" src="<?= $product['thumb']; ?>" alt="product picture" />
                                    </p>
                                    <div>
                                        <figcaption class="t-product__caption">
                                            <?= $product['name']; ?>
                                        </figcaption>
                                        <figcaption class="t-product__code">
                                            <?= $product['model']; ?>
                                        </figcaption>
                                    </div>
                                </figure>
                            </td>
                            <td class="c-info__like active" data-pid="<?= $product['product_id']; ?>">
                                <div class="wrapper-icon">
                                    <div class="icon"></div>
                                </div>
                            </td>
                            <td class="c-info__total-price c-info__total-price--wishlist">
                                <?php if ($product['special']): ?>
                                <span class="text" data-old="<?= $product['price']; ?>"><?= $product['special']; ?></span>
                                <?php else: ?>
                                <span class="text" data-old=""><?= $product['price']; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>

                <table style="padding-right: 18px;">
                  <tbody class="c-info__rezult">
                    <tr>
                        <td class="c-info__message c-info__message--wishlist after"><?= $text_total_wishlist;?></td>
                        <td class="c-info__general-price c-info__general-price--wishlist rez after"><?= $total; ?></td>
                    </tr>
                  </tbody>
                </table>
                <!-- END: table-->

                <!-- BEGIN: control step buttons -->
                <div class="c-info__footer row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <a href="/index.php?route=account/wishlist" class="c-info__continue c-info__continue--wishlist"><?= $text_go_list_wish;?></a>
                    </div>
                    <div class="c-info__btn-holder col-xl-6 col-lg-6 col-md-6 col-12">
                        <a href="<?= $add_cart_products; ?>" class="btn btn--wishlist"><span class="text"><?= $text_add_to_cart;?></span></a>
                    </div>
                </div>
                <!-- END: control step buttons -->
            </div>
        </div>
    </section>
  </div>
  <?php } else { ?>

  <!--#########################################################################################-->
  <!-- BEGIN: empty wishlist -->
  <div class="dropcontent wish-cart__detail emptywishlist">
    <p class="wish-cart__title"><?= $text_empty_wishlist;?></p>
    <p class="wish-cart__text"><?= $text_add_products_wishlist;?></p>
    <p class="wish-cart__icon"></p>

    <?php if (!$logged): ?>
        <p class="wish-cart__text wish-cart__text--large"><?= $text_is_yes_wishlist;?></p>
        <div class="wish-cart__btn-holder">
            <a class="btn btn--bucket" href="/login/"><span class="text"><?= $text_login;?></span></a>
        </div>
    <?php else: ?>
          <p class="wish-cart__text wish-cart__text--large"><?= $text_add_products_wishlist_min; ?></p>
          <div class="wish-cart__btn-holder">
              <a class="btn btn--bucket" href="/katalog/"><span class="text"><?= $text_katalog; ?></span></a>
          </div>
    <?php endif; ?>


  </div>

  <?php } ?>
</div>