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

  <!-- BEGIN: info -->
  <section class="simple-info container">
    <h1 class="simple-info__title"><?php echo $heading_title; ?></h1>
    <div class="row">
      <div class="col-xl-9 col-lg-9 col-12">
        <!--seo_text_start-->
        <p class="simple-info__text">
          <?= $description; ?>
        </p>
        <!--seo_text_end-->
      </div>
      <div class="simple-info__date-holder col-xl-9 col-lg-9 col-12">
        <p class="simple-info__date"><?= $date_added; ?></p>
      </div>
    </div>
  </section>
  <!-- END: info -->

  <!-- Begin: newsroom -->
  <!--seoshield_formulas--novosti-->
  <?= !empty($newsroom) ? $newsroom : ''; ?>
  <!-- End: newsroom -->
</main>
<?php echo $footer; ?>