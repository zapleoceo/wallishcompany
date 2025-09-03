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
    <section class="about container">
        <h1 class="about__title"><?= $text_about_0; ?></h1>
        <div class="row">
            <div class="about__wrapper-info">
                <p class="about__text"><?= $text_about_1; ?></p>
                <picture class="about__pic-holder">
                    <img class="about__pic" src="<?= STYLE_PATH; ?>img/1920/about.png" alt="img" />
                </picture>
                <div class="about__btn-holder">
                    <a href="<?= $catalog_link; ?>" class="btn about__btn"><span class="text"><?= $text_go_catalog_big; ?></span></a>
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