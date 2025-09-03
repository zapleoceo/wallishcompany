<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-pricer" data-toggle="tooltip" title="<?php echo $button_upload; ?>" class="btn btn-primary"><i class="fa fa-upload"></i></button>
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
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pricer" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category_id">
                            <option value="0" selected="selected"><?php echo $text_none; ?></option>
                            <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-operation"><span data-toggle="tooltip" title="<?php echo $help_operation; ?>"><?php echo $entry_operation; ?></span></label>
                    <div class="col-sm-10">
                        <select name="operation_id" id="input-operation" class="form-control">
                            <option value="0" selected="selected"><?php echo $text_none; ?></option>
                            <?php foreach ($operations as $operation) { ?>
                            <option value="<?php echo $operation['operation_id']; ?>"><?php echo $operation['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="price" value="" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_new; ?></label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="new" value="1" />
                            <?php echo $text_yes; ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="new" value="0" checked="checked" />
                            <?php echo $text_no; ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_sale; ?></label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="sale" value="1" />
                            <?php echo $text_yes; ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sale" value="0" checked="checked" />
                            <?php echo $text_no; ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_fete; ?></label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="fete" value="1" />
                            <?php echo $text_yes; ?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="fete" value="0" checked="checked" />
                            <?php echo $text_no; ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-discount-percentage"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount_percentage; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="discount" value="" placeholder="<?php echo $entry_discount_percentage; ?>" id="input-discount-percentage" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_result; ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_changes; ?></label>
                        <div class="col-sm-10">
                            <div class="well well-sm" style="min-height: 150px; overflow: auto;">
                                <?php print_r($changes); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>