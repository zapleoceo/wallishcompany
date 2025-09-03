<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="cgbs" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">

        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="cgbs" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="cgbs_status" id="input-status" class="form-control">
                                <?php if ($cgbs_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <?php 
                    if(isset($rows)) { 
                    echo $rows;
                    } else { 
                    echo $row;
                    } 
                    ?>

                </form>
                <div class='btn btn-default' id='add_row' ><i class="fa fa-plus"></i> <?php echo $entry_add_row;?></div>
                <!--
                <div class='btn btn-default' id='regroup_customer' >
                    <i class="fa fa-refresh"></i>
                    <?php echo $entry_regroup_customer;?>
                </div>
                -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $("#add_row").click(function () {
            $("#cgbs").append('<?php echo preg_replace( "/\r|\n/", "", $row);?>');
        });

        $("#cgbs").on("click", ".del_row", function () {
            $(this).parents('.form-group').remove();
        });

        
        /*$("#regroup_customer").click(function () {
            var btn=this;
            $(btn).html('<i class="fa fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: 'index.php?route=module/custmer_group_by_summ/regroup_customers&token=<?php echo $token; ?>',
                success: function(msg){
                    
                    $(btn).html(msg);
                }
            });
        });*/

    });

</script>
<?php echo $footer; ?>