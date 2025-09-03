<?php echo $header;
  $mounts = array(
    1 => $text_month_1,
    2 => $text_month_2,
    3 => $text_month_3,
    4 => $text_month_4,
    5 => $text_month_5,
    6 => $text_month_6,
    7 => $text_month_7,
    8 => $text_month_8,
    9 => $text_month_9,
    10 => $text_month_10,
    11 => $text_month_11,
    12 => $text_month_12,
);

?>
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

  <!-- BEGIN: order details -->
  <section class="account account--address account--order-d container">
    <h1 class="account__title account__title--history-info"><?= $text_account; ?></h1>
    <!-- <h1 class="account__title"><?php echo $text_order_detail; ?> № <?= $order_id; ?></h1> -->
    <div class="row">

      <!-- BEGIN: sidebar-->
      <?= isset($account_menu)? $account_menu : ''; ?>
      <!-- END: sidebar -->

      <div class="order-align order-align--info">
        <!-- BEGIN: back to list -->
        <div class="order align-product row">
          <div class="product-nav order__back-btn">
            <a href="<?= $continue; ?>" class="product-nav__prev">
              <i class="icon"></i>
              <span class="text"><?= $text_back_orders; ?></span>
            </a>
          </div>
        </div>
        <!-- END: back to list -->

        <!-- BEGIN: order-info -->
        <div class="order-details order-details--top row">
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-details__order-info">
              <p class="order-info__label"><?= $text_order_id; ?></p>
              <p class="order-info__text order-info__text--colorCyan"><?= $order_id; ?></p>
            </div>
          </div>
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-details__order-info">
              <p class="order-info__label"><?= $text_payment_method; ?></p>
              <p class="order-info__text"><?= $payment_method; ?></p>
            </div>
          </div>
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-details__order-info">
              <p class="order-info__label"><?= $text_date_added; ?></p>
              <p class="order-info__text">
                <?php echo date('j', $date_added) .' '.$mounts[date('n', $date_added)]. ' ' .date('Y', $date_added).' '. date('H:i', $date_added); ?>
              </p>
            </div>
          </div>
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-details__order-info">
              <p class="order-info__label"><?= $text_shipping_method; ?></p>
              <p class="order-info__text"><?= $shipping_method; ?></p>
            </div>
          </div>
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-details__order-info">
              <p class="order-info__label"><?= $column_status; ?></p>
              <p class="order-info__text" data-status="<?= $status_code; ?>"><?= $status; ?></p>
            </div>
          </div>
          <div class="order-details__padding col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="order-info order-info--center order-details__order-info">
              <form method="post" action="<?= $renderPDF; ?>" id="pdfform">
                <input type="hidden" name="pdforder" id="pdfContain" value="">
              </form>

              <a href="#" class="order-info__link toPdf">
                <p class="order-info__print-icon"></p>
                <p class="order-info__print-text"><?= $text_pdf_to_order; ?></p>
              </a>
            </div>
          </div>
        </div>
        <!-- END: order-info -->
        <!-- BEGIN: table -->
        <div class="order row">

          <table class="order__table order__table--list">
            <thead>
            <tr>
              <th><?= $column_name; ?></th>
              <th><?= $text_category_column; ?></th>
              <th><?= $column_model; ?></th>
              <th><?= $column_quantity; ?></th>
              <th><?= $column_price; ?></th>
              <th><?= $column_total; ?></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach($products as $prod): ?>
            <tr class="order__row">
              <td class="order__t-product">
                <figure class="t-product">
                  <p class="t-product__pic-holder">
                    <a href="<?= $prod['href']; ?>">
                      <img class="t-product__pic" src="<?= $prod['thumb']; ?>" alt="alt" />
                    </a>
                  </p>
                  <figcaption class="t-product__caption">
                    <a href="<?= $prod['href']; ?>">
                      <?= $prod['name']; ?>
                    </a>
                  </figcaption>
                </figure>
              </td>
              <td class="order__category">
                <a href="<?= $prod['category_href']; ?>">
                  <?= $prod['category']; ?>
                </a>
              </td>
              <td class="order__code"><?= $prod['model']; ?></td>
              <td class="order__quantity"><?= $prod['quantity']; ?> <?= $text_sht; ?></td>
              <td class="order__one-price"><?= $prod['price']; ?></td>
              <td class="order__price"><?= $prod['total']; ?></td>
            </tr>
            <?php endforeach; ?>

            </tbody>
          </table>

          <div class="order-details order-details--bottom col-12 d-md-block d-none">
            <div class="row">
              <div class="col-xl-5 col-lg-5 col-md-5 col-12 order-xl-1 order-lg-1 order-md-1 order-2">
                <div class="order-details__btn-holder">
                  <a href="<?= $clone; ?>" class="btn btn--order-info order-details__btn">
                    <span class="text"><?= $text_reorder; ?></span>
                  </a>
                </div>
              </div>
              <div class="col-xl-7 col-lg-7 col-md-7 col-12 order-xl-1 order-lg-1 order-md-1 order-1">
                <?php $tot = count($totals)-1; foreach($totals as $k => $total): ?>

                  <?php if ($tot == $k): ?>
                    <div class="order-details__info-holder">
                      <p class="order-details__name"><?php echo $total['title']; ?></p>
                      <p class="order-details__price"><?php echo $total['text']; ?></p>
                    </div>
                  <?php else: ?>
                    <div class="order-details__info-holder order-details__info-holder--small">
                      <p class="order-details__name"><?php echo $total['title']; ?></p>
                      <p class="order-details__price"><?php echo $total['text']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        <!-- END: table -->

      </div>

    </div>
  </section>
  <!-- END: order details -->
  <div class="order-details order-details--bottom d-md-none d-block" style="width: 100%">
    <div class="row">
      <div class="col-xl-5 col-lg-5 col-md-5 col-12 order-xl-1 order-lg-1 order-md-1 order-2">
        <div class="order-details__btn-holder">
          <a href="<?= $clone; ?>" class="btn btn--order-info order-details__btn">
            <span class="text"><?= $text_reorder; ?></span>
          </a>
        </div>
      </div>
      <div class="col-xl-7 col-lg-7 col-md-7 col-12 order-xl-1 order-lg-1 order-md-1 order-1">
        <?php $tot = count($totals)-1; foreach($totals as $k => $total): ?>

          <?php if ($tot == $k): ?>
            <div class="order-details__info-holder">
              <p class="order-details__name"><?php echo $total['title']; ?></p>
              <p class="order-details__price"><?php echo $total['text']; ?></p>
            </div>
          <?php else: ?>
            <div class="order-details__info-holder order-details__info-holder--small">
              <p class="order-details__name"><?php echo $total['title']; ?></p>
              <p class="order-details__price"><?php echo $total['text']; ?></p>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>
<?php echo $footer; ?>