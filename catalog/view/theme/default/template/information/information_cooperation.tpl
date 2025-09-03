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
    <section class="cooperation container">
        <h1 class="cooperation__title"><?= $text_cooperation_0; ?></h1>
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-12">
                <p class="cooperation__text"><?= $text_cooperation_1; ?></p>
            </div>
            <div class="col-xl-9 col-lg-9 col-12"><span class="separator"></span></div>
            <div class="col-xl-9 col-lg-9 col-12">
                <div class="benefits">
                    <h4 class="benefits__title"><?= $text_cooperation_2; ?></h4>
                    <ul class="benefits__list">
                     <!--     <li class="benefits__item"><?= $text_cooperation_3; ?></li> -->
                        <li class="benefits__item"><?= $text_cooperation_4; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_5; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_6; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_7; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_8; ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-12"><span class="separator"></span></div>
            <div class="col-xl-9 col-lg-9 col-12">
                <div class="benefits">
                    <h4 class="benefits__title"><?= $text_cooperation_9; ?></h4>
                    <ul class="benefits__list">
                        <li class="benefits__item"><?= $text_cooperation_10; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_11; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_12; ?></li>
                        <li class="benefits__item"><?= $text_cooperation_13; ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-12"><span class="separator"></span></div>
            <div class="col-12 regards">
                <div class="regards__regard"><?= $text_cooperation_14; ?></div>
                <div class="regards__sub-regard"><?= $text_cooperation_15; ?></div>
            </div>
            <div class="cooperation__btn-holder col-12">
                <a href="<?= $catalog_link; ?>" class="btn cooperation__btn"><span class="text"><?= $text_go_catalog_big; ?></span></a>
            </div>
        </div>
    </section>
    <!-- END: info -->

    <!-- Begin: newsroom -->
    <?= !empty($newsroom) ? $newsroom : ''; ?>
    <!-- End: newsroom -->
</main>

<?php echo $footer; ?>