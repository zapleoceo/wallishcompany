  <!-- Begin: newsroom -->
  <?php if (!empty($newsroom)): ?>
  <section class="newsroom">

    <style>
    .span_h1_blog {
      font-family: "Futura Pt Light";
      font-size: 38px;
      margin-bottom: 70px;
      text-align: center;
      display:block;
      font-weight: 500;
    }
    </style>

    <div class="newsroom__background">
      <span class="span_h1_blog newsroom__title"><?= $text_newsroom_title; ?></span>
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
            <div class="owl-carousel owl-theme" id="slideshow_newsroom">
              <?php foreach($newsroom as $nroom): ?>
              <div class="item">
                <div class="item__picture-holder">
                  <?php if ($nroom['image'] == ''): ?>
                  <a href="<?= $nroom['url']; ?>">
                      <img class="item__picture" src="" alt="<?= $nroom['name']; ?>">
                  </a>
                  <?php else: ?>
                  <a href="<?= $nroom['url']; ?>">
                    <img class="item__picture" src="/image/<?= $nroom['image']; ?>" alt="<?= $nroom['name']; ?>">
                  </a>
                  <?php endif ?>
                </div>
                <div class="item__description">
                  <a href="<?= $nroom['url']; ?>">
                    <p class="item__title"><?= $nroom['name']; ?></p>
                  </a>
                  <p class="item__text"><?= $nroom['meta_description']; ?></p>
                  <div class="item__get-more">
                    <a href="<?= $nroom['url']; ?>" class="item__link">
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
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a class="btn" href="/newsroom/"/><span class="text"><?= $text_view_other_big; ?></span></a>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- End: newsroom -->
  <?php endif; ?>