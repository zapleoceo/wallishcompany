<div class="row">
    <div class="stagger cart__stagger">
        <a href="<?= $link_step_1; ?>" class="stagger__link<?= $active == 'cart' ? ' active' : ''; ?>">
            <span class="stagger__text"><?= $text_steps_cart; ?></span>
        </a>
        <a href="<?= $link_step_2; ?>" class="stagger__link<?= $active == 'checkout' ? ' active' : ''; ?>">
            <span class="stagger__text"><?= $text_steps_login; ?></span>
        </a>
        <a href="<?= $link_step_3; ?>" class="stagger__link<?= $active == 'address' ? ' active' : ''; ?>">
            <span class="stagger__text"><?= $text_steps_shiping; ?></span>
        </a>
        <a href="<?= $link_step_4; ?>" class="stagger__link<?= $active == 'payment' ? ' active' : ''; ?>">
            <span class="stagger__text"><?= $text_steps_pay; ?></span>
        </a>
    </div>
</div>