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

    <!-- BEGIN: reduction -->
    <section class="discont container">
        <h1 class="discont__title"><?php echo $heading_title; ?></h1>
    </section>

    <div class="discont__wrapper">
        <section class="discont container">
            <div class="row">
                  <div class="col-12">
                      <p class="discont__sub-title">
                          <?= $text_discount_2; ?>
                      </p>
                  </div>

                  <div class="dis-table-origin__wrapper">
                    <table class="dis-table-origin">
                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 2000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">2 %</td>
                      </tr>

                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 3000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">3 %</td>
                      </tr>

                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 4000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">4 %</td>
                      </tr>

                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 5000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">5 %</td>
                      </tr>

                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 6000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">6 %</td>
                      </tr>

                      <tr>
                        <td class="dis-table-origin__name"><?= $ot; ?> 10000 <?= $text_grn; ?></td>
                        <td class="dis-table-origin__number">7 %</td>
                      </tr>
                    </table>
                  </div>

                  <div class="pie-chart__wrapper">
                    <div id="pie-chart"></div>
                  </div>

                  <div class="col-12">
                    <p class="discont__after-table-text"><?= $text_no_sale_prods; ?></p>
                    <p class="discont__after-table-text"><?= $text_no_sale_prods1; ?></p>
                  </div>
            </div>
        </section>
      </div>
        <section class="discont container">
            <div class="row">
                <div class="discont__footer col-12">
                    <p class="discont__pre-btn-text">
                        <?= $text_discount_3; ?>
                    </p>
                    <a href="<?= $catalog_link; ?>" class="btn discont__btn"><span class="text"><?= $text_go_catalog_big; ?></span></a>
                </div>
            </div>
        </section>

    <!-- END: reduction -->


    <!-- Begin: newsroom -->
    <?= !empty($newsroom) ? $newsroom : ''; ?>
    <!-- End: newsroom -->
</main>

<?php echo $footer; ?>