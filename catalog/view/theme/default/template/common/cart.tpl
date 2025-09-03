<div class="fullcart-set dropcontent">

	<?php if ( $products || $vouchers ) { ?>
        <div class="bucket-empty__detail fullcart">

            <section class="cart container container--smallDevice">
                <div class="row justify-content-center">
                    <div class="c-info c-info--dropdown cart__c-info col-12">
                        <button type="button" class="close"><i class="icon"></i></button>
                        <div class="c-info__bucket-title"><?= $text_backet_title; ?></div>
                        <form action="<?php echo $action; ?>" id="formCartTop" method="post"
                              enctype="multipart/form-data" class="scroll-container">
                            <input type="hidden" name="top" value="1">
                            <script>
                                console.log('loaded');
                                document.getElementsByClassName('scroll-container')[0].scrollTop = parseInt(sessionStorage.getItem('scrollTop-dropdown-cart'));
                            </script>
                            <style>
                                .c-info--dropdown form {
                                    overflow-y: scroll;
                                }

                                /* width */

                                .c-info--dropdown form::-webkit-scrollbar {
                                    width: 5px;
                                }

                                /* Track */

                                .c-info--dropdown form::-webkit-scrollbar-track {
                                    background: #f1f1f1;
                                }

                                /* Handle */

                                .c-info--dropdown form::-webkit-scrollbar-thumb {
                                    background: #c0c0c0;
                                }

                                /* Handle on hover */

                                .c-info--dropdown form::-webkit-scrollbar-thumb:hover {
                                    background: #555;
                                }
                            </style>
                            <table class="c-info__table" style="padding-right: 10px;">
                                <tbody class="c-info__content">
								<?php foreach ( $products as $product ): ?>
                                    <tr>
                                        <td class="c-info__product cart-product-id"
                                            data-product-id="<?= $product['product_id']; ?>">
                                            <figure class="t-product">
                                                <p class="t-product__pic-holder">
                                                    <a href="<?= $product['href']; ?>">
                                                        <img class="t-product__pic" src="<?= $product['thumb']; ?>"
                                                             alt="alt"/>
                                                    </a>
                                                </p>
                                                <div>
                                                    <figcaption class="t-product__caption">
                                                        <a href="<?= $product['href']; ?>">
															<?= $product['name']; ?>
                                                        </a>
                                                    </figcaption>
                                                    <figcaption class="t-product__code">
														<?= $product['model']; ?>
                                                    </figcaption>
                                                </div>
                                            </figure>
                                        </td>
                                        <td class="c-info__quantity" style="padding-right: 10px;">
                                            <div class="quantity">
                                                <button type="button" class="quantity__minus"></button>
                                                <p class="quantity__text">
                                                    <input data-min="<?php echo $product['minimum']; ?>" type="text"
                                                           name="quantity[<?php echo $product['cart_id']; ?>]"
                                                           data-key="<?php echo $product['cart_id']; ?>"
                                                           value="<?php echo $product['quantity']; ?>"/>
                                                </p>
                                                <button type="button" class="quantity__plus"></button>
                                            </div>
                                        </td>
                                        <td class="c-info__total-price c-info__total-price--cart" style="padding-left: 10px;">
                                            <span class="text" data-old=""><?php echo $product['total']; ?></span>
                                            <label onclick="cart.remove('<?php echo $product["cart_id"]; ?>');"
                                                   class="remove">
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
                            </table>
                        </form>

                        <!-- BEGIN: TODO -->

                        <table style="padding-right: 18px;">
                            <tbody class="c-info__rezult">
							<?php /*

                            <tr>
                              <td class="c-info__message c-info__message--cart c-info__message--dropdown after">

                              </td>
                              <td class="c-info__name c-info__name--cart after">Общая сумма</td>
                              <td class="c-info__general-price c-info__general-price--cart after">998 грн</td>
                            </tr>
                            <tr>
                              <td class="c-info__message c-info__message--cart c-info__message--dropdown after">

                              </td>
                              <td class="c-info__name c-info__name--cart after">Скидка1</td>
                              <td class="c-info__general-price c-info__general-price--cart after">50 грн. (18%)</td>
                            </tr>
                            */
							?>

							<?php foreach ( $totals as $k => $total ): ?>
                                <tr>

									<?php if ( $disable_order && $k == ( count( $totals ) - 1 ) ): ?>
                                        <td colspan="4"
                                            class="c-info__message c-info__message--popup c-info__message--dropdown after">
											<?= $text_min_summ_order; ?> <strong><?= $min_order_str; ?></strong>
											<?= $text_adding; ?> <strong><?= $min_order_str_adding; ?></strong>
											<?= $text_to_order; ?>
                                        </td>
									<?php else: ?>
                                        <td colspan="4" class="c-info__name c-info__name--cart c-info__name--popup after"><?= $total['title']; ?></td>
									<?php endif; ?>
                                    <td class="c-info__general-price c-info__general-price--popup c-info__general-price--rez after
                                <?php echo ( ! $disable_order && $k == ( count( $totals ) - 1 ) ) ? 'more1k' : '' ?>">
										<?= $total['text']; ?>
										<?php if ( $total['code'] == 'sale_total' ): ?>
                                            (<?= $total['percent']; ?>%)
										<?php endif; ?>
                                    </td>
                                </tr>
							<?php endforeach; ?>
                            <!-- END: TODO -->
                            </tbody>
                        </table>
                        <!-- END: table-->

                        <!-- BEGIN: control step buttons -->
                        <div class="c-info__footer row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                <a href="<?= $link_catalog; ?>" class="c-info__continue"><?= $text_continue_buy; ?></a>
                            </div>
                            <div class="c-info__btn-holder col-xl-6 col-lg-6 col-md-6 col-12">
                                <a href="<?= $link_step_2; ?>" class="btn c-info__btn btn--dropdown"
                                   aria-disabled="<?= $disable_order ? 'true' : 'false'; ?>"><span
                                            class="text"><?= $text_oformit_zakaz; ?></span></a>
                            </div>
                        </div>
                        <!-- END: control step buttons -->
                    </div>
                </div>
            </section>


        </div>
	<?php } else { ?>

        <div class="dropcontent bucket-empty__detail emptycart">
            <p class="bucket-empty__title"><?= $text_pustaya_korzina; ?></p>
            <div class="bucket-empty__icon"></div>
            <p class="bucket-empty__text"><?= $text_zapolni_ee; ?></p>
            <div class="bucket-empty__btn-holder">
                <a class="btn btn--bucket" href="<?= $catalog_link; ?>">
                    <span class="text">
                        <?= $text_gocatalog; ?>
                    </span>
                </a>
            </div>
        </div>

	<?php } ?>
</div>
