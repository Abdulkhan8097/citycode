<style>
.mandatory {
     display:inline;
     color:red;
 }
  
.col-sm-4 { 
   color: #000;
}
.col-sm-8{ 
   color: #000;
}
.font-size-20{
color: #000;
}
label{
color: #000 !important;
}
 .btn-primary{
color: #000 !important;
}
.table td {
padding: .30rem;
}
</style>

   <script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
		
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">                  
                        <div class="card-body"> 
			             <?php echo view('admin/_topmessage'); ?>
						 <div class="row">
                            <div class="col-lg-3"> 
                               <h4 class="card-title">New Notification</h4>     
                          </div>                        
                    </div>
                  <hr>
                         <form class="custom-validation"  method='post' action="NotificationController/add_notification" enctype='multipart/form-data'>	
						 				
                           <div class="form-group row">
                            <label  class="col-sm-2 ml-4 col-form-label">Interest<span class="mandatory">*</span></label>
                               <div class="col-sm-8">
				<div class="row">
				<div class="col-sm-1 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
				<div class="col-sm-8 border float-lg-right">Select all</div>
				</div>
                                   <?php  foreach ($interests as $item) { ?>
                                   <div class="row">
                                   <div class="col-sm-1 border float-left"><input type="checkbox" required name="interest[]" class="checkhour" value="<?php echo $item['cat_id']; ?>" ></div>
                                   <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_name']; ?></div>
                                   <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_arbname']; ?></div>                                   
                                   </div>	 
                                <?php }?>   
                                </div>
                              </div>
					
					
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Description<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                 <textarea class="form-control" name="description" cols="6" rows="4" required></textarea>
                                </div>
                              </div> 
							  
			 <div class="form-group row mb-0">
                              <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <a href="<?php echo site_url('Notifications');?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mr-1">
                                    Clear
                        </button></a>
                                       
                        </div>
                      </div>								      
                   </form>					
		</div> 
             </div>
           </div>  
        </div> 
     </div>
	 </div>
	 
	 <script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>
