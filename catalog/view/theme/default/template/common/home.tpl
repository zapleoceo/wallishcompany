<?= $header; ?>
<!-- Begin: main -->
<main class="main">
  <!-- Begin: banners -->
  <section class="banners d-none">
    <div class="container">
      <div class="banners__backImage" style="display:none;">
        <img class="banners__widder-banner" src="<?= $text_2['image']; ?>" alt="adsgf" />

        <div class="banners__on-photo-holder">
            <span style="font-weight: 500;" class="banners__title"><?= $text_2['name']; ?></span>
            <a href="/oplaata-i-dostavka" class="banners__btn btn"><span class="text"><?= $text_view_other_big; ?></span></a>
        </div>
      </div>


      <div class="banners__banner-holder row">
        <div class="banner banners__banner">
          <div class="banner__photo-holder">
            <img class="banner__photo" src="/image/<?= $text_3['image']; ?>" alt="">
          </div>
          <p class="banner__text"><?= $text_3['name']; ?></p>
          <a href="katalog/korobki/prjamougolnie-/" class="link"><?= $text_go_catalog_big; ?>
            <img class="link__icon" src="<?= STYLE_PATH; ?>img/icons/arrow-mini-home.svg" alt="arrow" />
          </a>
        </div>
        <div class="banner banner--paddingleft banners__banner">
          <div class="banner__photo-holder">
            <img class="banner__photo" src="<?= $text_4['image']; ?>" alt="">
          </div>
          <p class="banner__text"><?= $text_4['name']; ?></p>
          <a href="/katalog/tegi/s-gljancevim-/" class="link"><?= $text_go_catalog_big; ?>
            <img class="link__icon" src="<?= STYLE_PATH; ?>img/icons/arrow-mini-home.svg" alt="arrow" />
          </a>
        </div>
          <?php if ( $language_code == 'en' ) {
              $banner_second = $banner_second_en;
          } ?>
          <?php if ( $language_code == 'uk' ) {
              $banner_second = $banner_second_uk;
          } ?>
        <?php if (isset($banner_second['banners']) && !empty($banner_second['banners'])): ?>
        <div class="banner banner--wider banners__banner">
          <div class="banner__photo-holder">
            <img class="banner__photo" src="/image/<?= $banner_second['banners'][0]['image']; ?>" alt="">
          </div>
          <p class="banner__text"><?= $banner_second['banners'][0]['title']; ?></p>
          <a href="<?= $banner_second['banners'][0]['link']; ?>" class="link"><?= $text_view_other; ?>
            <img class="link__icon" src="<?= STYLE_PATH; ?>img/icons/arrow-mini-home.svg" alt="arrow" />
          </a>
        </div>
        <?php endif; ?>
        <!-- <div class="banner banner--paddingleft banners__banner">
          <div class="banner__photo-holder">
            <img class="banner__photo" src="/image/<?= $text_6['image']; ?>" alt="">
          </div>
          <p class="banner__text"><?= $text_6['name']; ?></p>
          <a href="<?= $text_6['url']; ?>" class="link"><?= $text_view_other; ?>
            <img class="link__icon" src="<?= STYLE_PATH; ?>img/icons/arrow-mini.svg" alt="arrow" />
          </a>
        </div> -->
      </div>

    </div>
  </section>
  <!-- End: banners -->

  <!-- BEGIN: category children -->
  <section class="category container">
    <?php if (isset($category_children)): ?>
    <div class="category__title"><?= $text_view_product_category; ?></div>
    <div class="row">
      <?php foreach ( $category_children as $cat_child ): ?>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
        <div class="card child_cat">
          <a href="<?= $cat_child['href']; ?>">
            <img class="card__image" src="<?= $cat_child['thumb']; ?>" alt="<?= $cat_child['name']; ?>" title="<?= $cat_child['name']; ?>">
          </a>
          <div class="card__title"><a href="<?= $cat_child['href']; ?>" class="text"><?= $cat_child['name']; ?></a></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </section>
  <!-- END: category children -->

  <!-- Begin: newsroom -->
  <?= !empty($newsroom) ? $newsroom : ''; ?>
  <!-- End: newsroom -->

  <!-- Begin: main-text -->
  <section class="main-text container">
    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-9">
        <h1 class="main-text__title"><?= $text_7['name']; ?></h1>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-xl-9 col-lg-11 col-md-12 col-sm-12 col-xs-12 col-12">
        <div id="seo_text_place" class="seo_text_place"><!--seo_text_start--><?= htmlspecialchars_decode($text_7['description']); ?><!--seo_text_end--></div>
        <div class="seo_more_place" data-text-more="..." data-text-hide="^^^">...</div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 d-lg-block d-none">
        <a href="/katalog/greeting-cards-handmade/muzhskie/" class="main-text__btn btn"><span class="text"><?= $text_go_catalog_big; ?></span></a>
      </div>
    </div>
  </section>
  <!-- End: main-text -->
</main>
<!-- End: main -->
<?php echo $footer; ?>

