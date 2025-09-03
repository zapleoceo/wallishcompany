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

  <!-- BEGIN: order -->
  <section class="account container">
    <h1 class="account__title account__title--history"><?= $text_account; ?></h1>
    <div class="row">
      <!-- BEGIN: sidebar-->
      <?= isset($account_menu)? $account_menu : ''; ?>
      <!-- END: sidebar -->

      <div class="order-align col-xl-9 col-lg-9 col-12">

        <?php if(count($orders) != 0) {?>
        <!-- BEGIN: table -->
        <div class="order row">

          <h4 class="order__title"><?= $heading_title; ?> </h4>

          <table class="order__table">
            <thead>
            <tr>
              <th><?= $column_order_id; ?></th>
              <th><?= $column_date_added; ?></th>
              <th><?= $column_total; ?></th>
              <th><?= $text_payment_method; ?></th>
              <th><?= $text_shipping_method; ?></th>
              <th><?= $column_status; ?></th>
              <th><?= $text_products_add_cart; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
              <tr class="order__row">
                <td class="order__link-holder">
                  <a href="<?= $order['href']; ?>" class="order__link">№ <?php echo $order['order_id']; ?></a>
                </td>
                <td class="order__date">
                    <?php echo date('j', $order['date_origin']) .' '.$mounts[date('n', $order['date_origin'])]. ' ' .date('Y', $order['date_origin']).' '. date('H:i', $order['date_origin']); ?>
                </td>
                <td class="order__price">
                    <?php echo $order['total']; ?>
                </td>
                <td class="order__type">
                  <?= $order['payment_method']; ?>
                </td>
                <td class="order__delivery">
                    <?= $order['shipping_method']; ?>
                </td>
                <td class="order__status" data-status="<?= $order['status_code']; ?>">
                    <?php echo $order['status']; ?>
                  <a href="#" class="btn"><span class="text"><?= $text_pay; ?></span></a>
                </td>
                <td class="order__repeat-holder">
                  <a href="<?= $order['clone']; ?>" class="order__repeat"><i class="icon"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>

            <!--
            <tr class="order__row">
              <td class="order__link-holder">
                <a href="#" class="order__link">№ 97427148</a>
              </td>
              <td class="order__date">
                24 марта 2018   12:38
              </td>
              <td class="order__price">
                1 549 грн.
              </td>
              <td class="order__type">
                Наличные
              </td>
              <td class="order__delivery">
                Нова Пошта
              </td>
              <td class="order__status" data-status="canceled">
                Отменен
                <a href="#" class="btn"><span class="text">Оплатить</span></a>
              </td>
              <td class="order__repeat-holder">
                <a href="#" class="order__repeat"><i class="icon"></i></a>
              </td>
            </tr>

            <tr class="order__row">
              <td class="order__link-holder">
                <a href="#" class="order__link">№ 97427148</a>
              </td>
              <td class="order__date">
                24 марта 2018   12:38
              </td>
              <td class="order__price">
                1 549 грн.
              </td>
              <td class="order__type">
                Наличные
              </td>
              <td class="order__delivery">
                Нова Пошта
              </td>
              <td class="order__status " data-status="payed">
                оплачен
                <a href="#" class="btn"><span class="text">Оплатить</span></a>
              </td>
              <td class="order__repeat-holder">
                <a href="#" class="order__repeat"><i class="icon"></i></a>
              </td>
            </tr>

            <tr class="order__row">
              <td class="order__link-holder">
                <a href="#" class="order__link">№ 97427148</a>
              </td>
              <td class="order__date">
                24 марта 2018   12:38
              </td>
              <td class="order__price">
                1 549 грн.
              </td>
              <td class="order__type">
                Наличные
              </td>
              <td class="order__delivery">
                Нова Пошта
              </td>
              <td class="order__status " data-status="success">
                выполнен
                <a href="#" class="btn"><span class="text">Оплатить</span></a>
              </td>
              <td class="order__repeat-holder">
                <a href="#" class="order__repeat"><i class="icon"></i></a>
              </td>
            </tr>

            <tr class="order__row">
              <td class="order__link-holder">
                <a href="#" class="order__link">№ 97427148</a>
              </td>
              <td class="order__date">
                24 марта 2018   12:38
              </td>
              <td class="order__price">
                1 549 грн.
              </td>
              <td class="order__type">
                Наличные
              </td>
              <td class="order__delivery">
                Нова Пошта
              </td>
              <td class="order__status" data-status="none">
                <a href="#" class="btn"><span class="text">Оплатить</span></a>
              </td>
              <td class="order__repeat-holder">
                <a href="#" class="order__repeat"><i class="icon"></i></a>
              </td>
            </tr>
            -->
            </tbody>
          </table>
        </div>
        <!-- END: table -->

        <!-- BEGIN: pagination -->
        <div class="order category row justify-content-center">
          <nav class="d-xl-block d-lg-block d-md-block d-none col-auto">
            <?= $pagination; ?>
          </nav>
          <div class="btn-holder d-xl-none d-lg-none d-md-none d-block col-12">
            <button class="btn btn--history order__btn"><span class="text"><?= $text_more_view; ?></span></button>
          </div>
        </div>
        <!-- END: pagination -->
        <?php } else {?>
          <div class="order row">

            <h4 class="order__title"><?= $text_not_order; ?></h4>

            <div>
              <a href='/katalog/' class="btn"><span class="text"><?= $text_shop_now; ?></span></a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- END: order -->
</main>
<?php echo $footer; ?>