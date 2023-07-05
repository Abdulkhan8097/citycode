  <style>

/*.for-mobile-laptop {
  margin: 0 100px;
}*/

/*@media only screen and (max-width: 600px) {
  .for-mobile-laptop {
     margin: 0;

  }
}*/


/*label {
    float: left
}*/
/*span {
    display: block;
    overflow: hidden;
    padding: 0 4px 0 6px
}
input {
    width: 100%
}*/



/*
.selectt {
display: none;
}*/

</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Add New Banners</h4>
							   <?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="AdvertisementController/add" enctype='multipart/form-data'>

                          <div class="for-mobile-laptop">

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Banner Type</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="banner_type">
                                        <option value="">- Please Select -</option>
 <option value="all"> All </option>

                                        <option value="arb"> Arabic </option>
                                        <option value="english"> English </option>
                                      </select> 
                                   </div>
                                 </div> 


                              <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Banner Name</label>
                               <div class="col-sm-6">
                                <input type="text" class="form-control" name="company_name" placeholder="Enter Name"/>
  
                                   </div>
                                </div> 

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Governorate</label>
                                   
                                    <div class="col-sm-6">
                                       <div class="row">
							       <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
								   <div class="col-sm-10 border float-lg-right">Select All</div>
								</div>
                                   <?php  foreach ($states as $row) { ?>
                                   <div class="row">
                                      <div class="col-sm-2 border float-left">
								        <input type="checkbox" name="governorate[]" class="checkhour" value="<?php echo $row["state_id"]; ?>" >
								      </div>
                                   <div class="col-sm-10 border float-lg-right">
								      <?php echo $row["state_name"].'/'.$row["arb_state_name"]; ?>
								    </div>                                  
                                  </div>	 
                                <?php }?> 
                                    </div> 
                                </div>


                                  <div class="form-group row">
                                    <label  class="col-sm-2 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location"/>
                                   </div>
                                 </div>

                             <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Gender</label>
                                  <div class="col-sm-6">
                                    <div class="row">
							            <div class="col-sm-2 border float-left"><input type="checkbox" name="checkgender" id="checkgender"> </div>
								        <div class="col-sm-10 border float-lg-right">Select All</div>
								    </div>
                                   <?php  if($genderarr) { foreach ($genderarr as $gender) { ?>
                                   <div class="row">
                                        <div class="col-sm-2 border float-left">
								          <input type="checkbox" name="gender[]" class="checkfirst" value="<?php echo $gender; ?>" >
								        </div>
                                       <div class="col-sm-10 border float-lg-right">
								         <?php echo $gender; ?>
								       </div>                                  
                                  </div>	 
                                <?php } } ?> 
                               </div>
                             </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Start Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="start_date" required/>
                                   </div>
                                 </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">End Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="end_date" required/>                                       
                                  </div>
                              </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" name="url" placeholder="Enter Url" />                                      
                                   </div>                                 
                                 </div>

                         <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">In App</label>
                                    <div class="col-sm-1">
					<!--<input type="checkbox" name="in_app" value="true">-->
					 <input type="checkbox" name="in_app" value="true">                                   
                                   </div>                                 
                                 </div>
								 
								 
								<div class="true selectt">
                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">Company Name</label>
                                    <div class="col-sm-6">
                                        <select name="company_id" class="form-control input-lg">
                                                    <option value="">- Please Select -</option>
                                                    <?php
                                                    foreach ($companies as $company) {
                                                        if (($company["company_name"]) && ($company["company_arb_name"])){
                                                        echo '<option value="' . $company["id"] . '">' . $company["company_name"].' / '.$company["company_arb_name"]. '</option>';
                                                    }
                                                       else if($company["company_arb_name"]){
                                                        echo '<option value="' . $company["id"] . '">' .$company["company_arb_name"]. '</option>';
                                                    }
                                                    else{
                                                        echo '<option value="' . $company["id"] . '">' .$company["company_name"]. '</option>';  
                                                    }
                                                }
                                            
                                                    ?>
                                                </select>
                                    </div>
                                 </div>
                               </div>
                            
				
				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Banners<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="file" name="banner[]" required class="form-control"  multiple >
                                  </div>
                                </div>
								


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status">
                                        <option value="1"> Active </option>
                                        <option value="0"> Inactive </option>
                                      </select> 
                                   </div>
                                 </div>


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Advertisement');?>">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div>
                           </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->    
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
	
	
	<script type="text/javascript">
			$(document).ready(function() {
				$('input[type="checkbox"]').click(function() {
					var inputValue = $(this).attr("value");
					$("." + inputValue).toggle();
				});
			});
</script>


<script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>

<script>
$("#checkgender").change(function () {
    $('.checkfirst').prop('checked', $(this).prop("checked"));
});
</script>

