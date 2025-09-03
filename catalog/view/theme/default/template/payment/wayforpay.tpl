<form action="<?php echo $action ?>" method="post" id="wayforpaySubmit">
    <?php
    foreach ($fields as $k => $v) {
        if(is_array($v)){
            foreach ($v as $vv) {
                echo "<input type=\"hidden\" name=\"{$k}[]\" value=\"{$vv}\" />";
            }
        } else {
            echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />";
        }

    }
    ?>

<div class="buttons">
    <div class="pull-right">
        <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm-wayforpay" data-loading-text="<?php echo $text_loading; ?>" class="btn btn--submit btn-primary" />
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#button-confirm-wayforpay").click(function(event){
            $.ajax({
                type: 'GET',
                url: 'index.php?route=payment/wayforpay/confirm',
                success: function () {
                    $('#wayforpaySubmit').submit();
                }
            });
            return false;
        });
    });
</script>