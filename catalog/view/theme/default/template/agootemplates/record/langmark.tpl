<?php if (count($languages) > 1) { ?>
 <div class="language top-nav__language">
  <div class="language__holder select">
   <div class="selected">
    <span class="text"><?php foreach ( $languages as $lang ): ?><?php if ($lang['current']) { echo $lang['code']; } ?><?php endforeach; ?></span>
    <ul class="select-list">
     <?php foreach ( $languages as $lang ): ?>
     <li onclick="window.location = '<?php echo $lang['url']; ?>'"><?= $lang['name'] ?></li>
     <?php endforeach; ?>
    </ul>
   </div>
  </div>
 </div>
<?php } ?>
