
<div class="form-group row">								  

    <?php foreach ($listss as $list) { ?>


        <label class="col-sm-4 col-form-label tens" style="color:#000 !important;"><?php echo $list->org_name; ?></label>
         

        <label  class="col-sm-4 col-form-label tens" style="color:#000 !important;"><?php echo $list->vip_code; ?></label>
          <div class="col-sm-4">
            <input type="checkbox" name="org[]" class="individual" value="<?php echo $list->org_id; ?>" <?php if(in_array($list->org_id, $companyVipCustomer)){ echo "checked"; } ?>>                                      
            </div> 
       

    <?php }; ?>   
     
        <input type="hidden" name="companyid" value="<?php echo $companyid; ?>">
</div>  