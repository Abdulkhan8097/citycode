<div class="form-group row">								  

    <?php foreach ($lists as $list) { ?>
        <label class="col-sm-4 col-form-label tens" style="color:#000 !important;"><?php echo $list->name; ?></label>

        <label  class="col-sm-4 col-form-label tens" style="color:#000 !important;"><?php echo $list->vip_code; ?></label>

        <div class="col-sm-4">
            <input type="checkbox" name="vip[]" class="individual" value="<?php echo $list->id; ?>" <?php if(in_array($list->id, $companyVipCustomer)){ echo "checked"; } ?>/>                                      
        </div> 
    <?php } ?>     
        <input type="hidden" name="companyid" value="<?php echo $companyid; ?>">
</div>  