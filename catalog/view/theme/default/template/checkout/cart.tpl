<?php echo $header; ?>
<script>
    // scroll window to remembered in /cart.js
    let window_position_before_refresh = sessionStorage.getItem('scrollTop_cart');
    window.scrollTo(0, window_position_before_refresh);
</script>
<div class="overCart" style="display: none;position: fixed; width: 100%; height: 100%;top: 0;left: 0;background: rgba(255,255,255,0.3);z-index: 10000;justify-content: center;align-items: center;">
    <div class="loading"><img src="//www.primebldg.com/wp-content/uploads/2017/09/ajax-loader.gif" alt="" style="width: 40px; height: 40px; display: block;"></div>
</div>
<main class="main">
    <!-- BEGIN: breadcrumb -->
    <div class="category container d-xl-block d-lg-block d-md-block d-none">
        <div class="row">
            <div class="col-12">

                <ul class="breadcrumb contacts__breadcrumb">
					<?php foreach ( $breadcrumbs as $bk => $br ): ?>
						<?php if ( $bk == ( count( $breadcrumbs ) - 1 ) ): ?>
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

    <!-- BEGIN: cart -->
    <section class="cart cart--page cart--sec container">
        <h1 class="cart__title"><?php echo $heading_title; ?></h1>

		<?php if ( $attention ) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
		<?php } ?>
		<?php if ( $success ) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
		<?php } ?>
		<?php if ( $error_warning ) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
		<?php } ?>


        <div class="row justify-content-center">

            <!-- BEGIN: cart content -->
            <div class="col-xl-7 col-lg-9 col-12">
                <!-- BEGIN: cart stagger -->
				<?= $topmenu; ?>
                <!-- END: cart stagger -->

            </div>
            <!-- END: cart content -->

        </div>
    </section>
    <?php if ( $attention_trigger ) { ?>
    <div class="attention">
        <div class="check_cart"><?= $text_check_cart; ?></div>
    </div>
    <?php } ?>
    <section id="cartContainer" class="cart cart-page cart--sec cart--bottom container container--smallDevice">
        <div class="row justify-content-center">
            <div class="c-info cart__c-info col-xl-7 col-lg-9 col-12">

                <form action="<?php echo $action; ?>" id="formCart" method="post" enctype="multipart/form-data">
                    <!-- BEGIN: table-->
                    <table class="c-info__table">
                        <thead>
                        <tr>
                            <th><?php echo $column_name; ?></th>
                            <th><?= $text_column_category; ?></th>
                            <th><?php echo $column_quantity; ?></th>
                            <th><?php echo $column_price; ?></th>
                            <th><?php echo $column_total; ?></th>
                        </tr>
                        </thead>
                        <tbody class="c-info__content">
						<?php foreach ( $products as $product ): ?>
                            <tr data-productId="<?php echo $product["cart_id"]; ?>">
                                <td class="c-info__product">
                                    <figure class="t-product">
                                        <p class="t-product__pic-holder">
                                            <a href="<?= $product['href']; ?>">
                                                <img class="t-product__pic" src="<?= $product['thumb']; ?>" alt="alt"/>
                                            </a>
                                        </p>
                                        <div>
                                            <a href="<?= $product['href']; ?>">
                                                <figcaption class="t-product__caption">
													<?= $product['name']; ?>
                                                </figcaption>
                                            </a>
                                            <figcaption class="t-product__code">
												<?= $product['model']; ?>
                                            </figcaption>
                                        </div>
                                    </figure>
                                </td>
                                <td class="c-info__category">
                                    <a href="<?= $product['category_href']; ?>">
										<?= $product['category']; ?>
                                    </a>
                                </td>
                                <td class="c-info__quantity">
                                    <div class="quantity">
                                        <button type="button" class="quantity__minus"></button>
                                        <p class="quantity__text">
                                            <input data-min="<?php echo $product['minimum']; ?>" type="text"
                                                   name="quantity[<?php echo $product['cart_id']; ?>]"
                                                   data-key="<?= $product['cart_id'] ?>"
                                                   value="<?php echo $product['quantity']; ?>"/>
                                        </p>
                                        <button type="button" class="quantity__plus"></button>
                                    </div>
                                </td>
                                <td class="c-info__price">
									<?php echo $product['price']; ?>
                                </td>
                                <td class="c-info__total-price">
                                    <span class="text" data-old=""><?php echo $product['total']; ?></span>
                                    <label data-id="<?php echo $product["cart_id"]; ?>" class="remove">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17">
                                                <path id="cross-big" class="cls-1"
                                                      d="M448,858.526l-0.529-.53-7.974,7.973L431.526,858l-0.529.53,7.973,7.973L431,874.473l0.529,0.53,7.974-7.975L447.474,875l0.529-.53L440.03,866.5Z"
                                                      transform="translate(-431 -858)"/>
                                            </svg>
                                        </i>
                                    </label>
                                </td>
                            </tr>
						<?php endforeach; ?>


                        </tbody>
                        <tbody class="c-info__rezult c-info__rezult--step1">

						<?php /*
            <!-- BEGIN: TODO -->
            <tr>
              <td colspan="3" class="c-info__message c-info__message--step1 after">
                  <?php if ($disable_order && $k == (count($totals) -1) ): ?>
                  <label class="icon" aria-hidden=""></label>
                  <span class="text" aria-hidden="">
                      <?= $text_min_summ_order; ?> <strong><?= $min_order_str; ?></strong> 
                      <?= $text_adding; ?> <strong><?= $min_order_str_adding; ?></strong><?= $text_to_order; ?>
                  </span>
                  <?php endif; ?>
              </td>
              <td colspan="" class="c-info__name after">Общая сумма</td>
              <td class="c-info__general-price after">998 грн.</td>
            </tr>

            <tr>
              <td colspan="2" class="c-info__message c-info__message--step1 after">
                  <span class="icon"></span>
                  <a href="#">
                      <span class="text text--grey">Oтменить заказ</span>
                  </a>
              </td>
              <td colspan="2" class="c-info__name after">Скидка</td>
              <td class="c-info__general-price after">50 грн.(18%)</td>
            </tr>
          <!-- END: TODO -->
            */ ?>

						<?php foreach ( $totals as $k => $total ): ?>
                            <tr>
                                <td colspan="3" class="c-info__message after">

									<?php if ( $disable_order && $k == 0 ): ?>

                                        <div class="mess">
                                            <span class="icon"></span>
                                            <span class="text"><?= $text_min_summ_order; ?>
                                                <strong><?= $min_order_str; ?></strong><?= $text_adding; ?>
                                                <strong><?= $min_order_str_adding; ?></strong><?= $text_to_order; ?>
                                            </span>
                                        </div>

									<?php elseif ( ( count( $totals ) - 2 ) == $k ): ?>

                                        <div class="cancel-order">
                                            <span class="icon"></span>
                                            <span class="text"><?= $text_not_order; ?></span>
                                        </div>

									<?php endif; ?>

                                </td>
                                <td class="c-info__name c-info__name--rez after"><?php echo $total['title']; ?></td>
                                <td class="c-info__general-price c-info__general-price--rez after">
									<?php echo $total['text']; ?>
									<?php if ( $total['code'] == 'sale_total' ): ?>
                                        (<?= $total['percent']; ?>%)
									<?php endif; ?>
                                </td>
                            </tr>
						<?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
                <!-- END: table-->
                <!-- BEGIN: table rez only smal devices-->
                <div class="c-info__rezult-hidden">

					<?php if ( $disable_order ): ?>
                        <div class="c-info__message-hidden">
                            <span class="icon"></span>
                            <span class="text">
              <?= $text_min_summ_order; ?> <strong><?= $min_order_str; ?></strong>
								<?= $text_adding; ?>
                                <strong><?= $min_order_str_adding; ?></strong><?= $text_to_order; ?></span>
                        </div>
					<?php endif; ?>

                    <div class="c-info__message-hidden">
                        <span class="icon"></span>
                        <a href="#">
                            <span class="text"><?= $text_not_order; ?></span>
                        </a>
                    </div>

                    <!-- BEGIN: TODO -->
                    <table>
						<?php /*
              <tr>
                <td class="c-info__name--mobile">Общая сумма</td>
                <td class="c-info__price--mobile">330 грн.</td>
              </tr>
              <tr>
                <td class="c-info__name--mobile">Скидка</td>
                <td class="c-info__price--mobile">50 грн. (18%)</td>
              </tr>
            */ ?>
						<?php foreach ( $totals as $k => $total ): ?>
                            <tr>
                                <td class="c-info__name--mobile"><?php echo $total['title']; ?></td>
                                <td class="c-info__price--mobile"><?php echo $total['text']; ?></td>
                            </tr>
						<?php endforeach; ?>
                    </table>
                </div>
                <!-- END: TODO -->
                <!-- END: table rez only smal devices-->
                <!-- BEGIN: control step buttons -->
                <div class="c-info__footer row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                        <a href="<?= $link_catalog; ?>" class="c-info__continue"><?= $text_continue_bay; ?></a>
                    </div>
                    <div class="c-info__btn-holder col-xl-4 col-lg-4 col-md-4 col-12">
                        <a href="<?= $link_step_2; ?>" class="btn btn--submit c-info__btn"
                           aria-disabled="<?= $disable_order ? 'true' : 'false'; ?>"><span
                                    class="text"><?= $text_steps_more; ?></span></a>
                    </div>
                </div>
                <!-- END: control step buttons -->
            </div>
        </div>
    </section>
    <!-- END: cart -->
</main>
<?php echo $footer; ?>
