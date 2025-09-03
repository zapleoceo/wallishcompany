<?= $header; ?>
<!-- BEGIN: cart step 3 details -->
<section class="cart cart--bottom cart--page container">
    <h1 class="cart__title"><?= $text_title; ?></h1>
    <div class="row">
        <div class="col-12">
            <p class="cart__thanks" data-show='true'><?= $text_message; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-12">
            <a href="<?= $link_home; ?>" class="btn cart__to-home-btn"><span class="text"><?= $text_home; ?></span></a>
        </div>
        <div class="col-sm-6 col-12">
            <a href="<?= $link_catalog; ?>" class="btn cart__to-catalog-btn"><span class="text"><?= $text_catalog; ?></span></a>
        </div>
    </div>
</section>
<!-- END: cart step 3 details -->
<?= $footer; ?>