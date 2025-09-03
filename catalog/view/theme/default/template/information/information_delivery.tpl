<?php echo $header; ?>

<main class="main">
    <!-- BEGIN: breadcrumb -->
    <div class="category container d-xl-block d-lg-block d-md-block d-none">
            <div class="row">
                <div class="col-12">

                    <ul class="breadcrumb contacts__breadcrumb">
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
    <!-- BEGIN: info -->
    <section class="payment container">
        <h1 class="payment__title"><?= $text_delivery_0; ?></h1>
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12">
                <p class="payment__text"><?= $text_delivery_1; ?></p>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12"><span class="separator"></span></div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12">
                <div class="benefits">
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_2; ?></h6>
                    <ul class="benefits__list">
                        <li class="benefits__item"><?= $text_delivery_3; ?></li>
                        <li class="benefits__item"><?= $text_delivery_4; ?></li>
                        <li class="benefits__item"><?= $text_delivery_5; ?></li>
                        <li class="benefits__item"><?= $text_delivery_6; ?></li>
                    </ul>
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_7; ?></h6>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12"><span class="separator"></span></div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12">
                <div class="benefits">
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_8; ?></h6>
                    <ul class="benefits__list">
                        <li class="benefits__item"><?= $text_delivery_9; ?></li>
                        <li class="benefits__item"><?= $text_delivery_10; ?></li>
                        <li class="benefits__item"><?= $text_delivery_11; ?></li>
                    </ul>
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_12; ?></h6>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12"><span class="separator"></span></div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-10 col-12">
                <div class="benefits">
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_13; ?></h6>
                    <ul class="benefits__list">
                        <li class="benefits__item"><?= $text_delivery_14; ?></li>
                        <li class="benefits__item"><?= $text_delivery_15; ?></li>
                        <li class="benefits__item"><?= $text_delivery_16; ?></li>
                        <li class="benefits__item"><?= $text_delivery_17; ?></li>
                    </ul>
                    <h6 class="benefits__title benefits__title--bold"><?= $text_delivery_18; ?></h6>
                </div>
            </div>
        </div>
    </section>
    <!-- END: info -->

    <!-- Begin: newsroom -->
    <?= !empty($newsroom) ? $newsroom : ''; ?>
    <!-- End: newsroom -->
</main>

<?php echo $footer; ?>