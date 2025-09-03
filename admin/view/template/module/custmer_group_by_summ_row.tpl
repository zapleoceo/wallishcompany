<div class="form-group">

    <label class="control-label col-sm-2" for="cgbs_from_summ"><?php echo $entry_from_summ;?></label>
    <div class="col-sm-1">
        <input type="number" value="<?php echo $from_summ;?>" class="form-control" id="cgbs_from_summ" name="cgbs_from_summ[]">
    </div>

    <label class="control-label col-sm-2" for="cgbs_to_summ"><?php echo $entry_to_summ;?></label>
    <div class="col-sm-1">
        <input type="number" value="<?php echo $to_summ;?>" class="form-control" id="cgbs_to_summ" name="cgbs_to_summ[]">
    </div>


    <!--<label class="control-label col-sm-1" for="cgbs_group"> <?= $entry_sale; ?> </label>
    <div  class="col-sm-1">
        <select id="cgbs_group" name="cgbs_type[]" class="form-control">
            <option value="0"<?= ($type == 0) ? ' selected' : ''; ?>><?= $entry_proc; ?></option>
            <option value="1"<?= ($type == 1) ? ' selected' : ''; ?>><?= $entry_grn; ?></option>
        </select>
    </div>

    <div class="col-sm-1">
        <input type="number" value="<?= $sale; ?>" class="form-control" name="cgbs_sale[]">
    </div>
    -->
    <div class="col-sm-3">
        <div class="col-sm-4">
            <input type="number" value="<?= $sale; ?>" class="form-control" name="cgbs_sale[]">
        </div>

        <div class="col-sm-1">
            <label class="control-label" for="cgbs_to_summ">%</label>
        </div>
    </div>

    <!--<label class="control-label col-sm-2" for="cgbs_group"><?php echo $entry_group;?></label>
    <div  class="col-sm-3">
        <select id="cgbs_group" name="cgbs_group[]" class="form-control">
            <?php foreach($groups as $gr) { ?>
            <option 
                <?php if($group && $group==$gr['customer_group_id']) { ?> selected <?php } ?>


                value="<?php echo $gr['customer_group_id'];?>"><?php echo $gr['name'];?></option>
            <?php } ?>
        </select>
    </div>-->

    <div class="del_row col-sm-1"><i class="fa fa-close"></i></div>
</div>