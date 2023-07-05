<div class="row">
    <div class="col-xl-12">
        <div class="card">								          
            <?php foreach ($VipCompany as $list) { ?>
                  <label class="col-sm-4 col-form-label tens" style="color:#000 !important;"><?php echo $list->company_name; ?></label>
            <?php } ?>                                           
             <input type="hidden" name="companyid" value="<?php echo $companyid; ?>">
      </div>  
   </div>
</div>