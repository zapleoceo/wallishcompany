<div class="buttons clearfix">
  <div class="pull-right">
    <?php foreach ($buttons as $button) { ?>
      <a href="<?php echo $button['link']; ?>" class="btn btn-primary"><span class="text"><?php echo $button['text']; ?></span></a>
    <?php } ?>
  </div>
</div>