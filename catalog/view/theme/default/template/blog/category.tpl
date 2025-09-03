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
  <section class="newsroom newsroom--article container">
    <h1 class="newsroom__title"><?php echo $heading_title; ?></h1>
    <!--seoshield_formulas--novosti-->

    <?php if ($articles): ?>
    <div class="row">
      <?php foreach ($articles as $article): ?>
      <div class="col-md-4 col-sm-6 col-12" onclick="location.href='<?= $article['href']; ?>';">
        <div class="item item--article ">
          <div class="item__picture-holder">
              <img class="item__picture" src="<?= $article['thumb']; ?>" alt="<?= $article['name']; ?>">
          </div>
          <div class="item__description">
            <a href="<?= $article['href']; ?>">
              <p class="item__title"><?= $article['name']; ?></p>
            </a>
            <p class="item__text"><?= $article['meta_description']; ?></p>
            <div class="item__get-more">
              <a href="<?= $article['href']; ?>" class="item__link">
                <span class="text"><?= $text_newsroom_more; ?></span>
                <i class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="5" height="9.031" viewBox="0 0 5 9.031">
                      <path id="arrow-mini" class="cls-1" d="M260.2,878.927l-3.773,3.885a0.6,0.6,0,0,1-.869,0,0.648,0.648,0,0,1,0-.895l3.339-3.438-3.338-3.438a0.645,0.645,0,0,1,0-.894,0.6,0.6,0,0,1,.869,0l3.772,3.885A0.646,0.646,0,0,1,260.2,878.927Z" transform="translate(-255.375 -873.969)"/>
                    </svg>
                </i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="category row">
      <!-- BEGIN: pagination top -->
      <nav class="col-auto offset-4">
        <?php echo $pagination; ?>
      </nav>
      <!-- END: pagination top -->
    </div>
    <?php endif; ?>
  </section>
  <!-- END: info -->
</main>
<?php echo $footer; ?>