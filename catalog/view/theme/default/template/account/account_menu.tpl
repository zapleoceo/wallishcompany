<div class="col-xl-2 col-lg-2 col-md-8 col-12 offset-xl-0 offset-lg-0 offset-md-2">
    <ul class="sidebar-nav sidebar-nav--brdr-none account__sidebar-nav row">
        <label id="sidebar-nav__control" class="sidebar-nav__control">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="5" viewBox="0 0 9 5">
                    <path id="arrow-mini-down" class="cls-1" d="M231.056,880.819l-3.87-3.774a0.6,0.6,0,0,1,0-.869,0.643,0.643,0,0,1,.892,0l3.424,3.339,3.424-3.339a0.641,0.641,0,0,1,.891,0,0.6,0.6,0,0,1,0,.869l-3.87,3.774A0.641,0.641,0,0,1,231.056,880.819Z" transform="translate(-227 -876)"/>
                </svg>
            </i>
        </label>
        <li class="sidebar-nav__item hidden"></li>
        <li class="sidebar-nav__item <?= ($active == 'account') ? ' active' : ''?>"><a href="<?php echo $edit; ?>" class="sidebar-nav__link"><?= $heading_title; ?></a></li>
        <li class="sidebar-nav__item <?= ($active == 'address') ? ' active' : ''?>"><a href="<?php echo $address; ?>" class="sidebar-nav__link"><?= $text_address; ?></a></li>
        <li class="sidebar-nav__item <?= ($active == 'order') ? ' active' : ''?>"><a href="<?php echo $order; ?>" class="sidebar-nav__link"><?= $text_order; ?></a></li>
        <li class="sidebar-nav__item <?= ($active == 'wishlist') ? ' active' : ''?>"><a href="<?php echo $wishlist; ?>" class="sidebar-nav__link"><?php echo $text_wishlist; ?></a></li>

        <?php /*
        <li class="sidebar-nav__item col-12<?= ($active == 'mycards') ? ' active' : ''?>">
            <a href="<?php echo $mycards; ?>" class="sidebar-nav__link"><?= $text_mycards; ?></a>
        </li>
        */ ?>

        <li class="sidebar-nav__item col-12">
            <a href="<?= $logout; ?>" class="sidebar-nav__link"><?= $text_logout; ?></a>
        </li>
    </ul>
</div>