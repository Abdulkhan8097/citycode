  <style>
/*
.for-mobile-laptop {
  margin: 0 100px;
}

@media only screen and (max-width: 600px) {
  .for-mobile-laptop {
     margin: 0;

  }
}


label {
    float: left
}
span {
    display: block;
    overflow: hidden;
    padding: 0 4px 0 6px
}
input {
    width: 100%
}

.mandatory {
display:inline;
color:red;
margin-bottom:20px;
}

.fa {
color:red !important;
}

.img-fluid{
    margin-top:20px;
}

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
                               <h4 class="card-title">Edit Banner</h4>
				                <?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="AdvertisementController/update" enctype='multipart/form-data'>
                                <input type="hidden" id="new_id" name="new_id" value="<?php echo $bannerdetails['id']; ?>">
                                    <div class="for-mobile-laptop">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Banner Type</label>
                                            <div class="col-sm-6">
                                                <select name="banner_type" class="form-control" >
                                                    <option value="">- Please Select -</option>
                                                    <option value="all" <?php echo ($bannerdetails['banner_type'] == 'all') ? 'selected="selected"' : ''; ?>>All</option>
                                                    <option value="arb" <?php echo ($bannerdetails['banner_type'] == 'arb') ? 'selected="selected"' : ''; ?>>Arabic</option>
                                                    <option value="english" <?php echo ($bannerdetails['banner_type'] == 'english') ? 'selected="selected"' : ''; ?>>English</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                           <label for="inputPassword" class="col-sm-2 col-form-label">Banner Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="company_name" value="<?php echo $bannerdetails['company_name']; ?>" placeholder="Enter Name" />
                                            </div>
                                       </div>


                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Governorate</label>     
                                       <div class="col-sm-6">
                                            <div class="row">
        							              <?php $gidz = explode(',', $bannerdetails['governorate']); ?>
            							              <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"
            								                <?php if(!empty($states)){
            								                if(count($states) == count($gidz)) { echo "checked" ; } } ?> >
                                                     </div>
        								          <div class="col-sm-10 border float-lg-right">Select All</div>
        								    </div>
        									 
                                           <?php if(!empty($states)) { foreach ($states as $row) { ?>
                                           <div class="row">
                                               <div class="col-sm-2 border float-left">
        								            <input type="checkbox" class="checkhour" required name="governorate[]" value="<?php echo $row['state_id']; ?>" <?php if (in_array($row['state_id'], $gidz)) {
                                                                echo "checked";
                                                            } ?>>
        								       </div>
                                               <div class="col-sm-10 border float-lg-right">
            								        <?php echo $row["state_name"].'/'.$row["arb_state_name"]; ?>
            								    </div>                                  
                                            </div>	 
                                            <?php } } ?> 
                                        </div> 
                                 </div>



                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="location" placeholder="Enter Location" value="<?php echo $bannerdetails['location'];?>" />
                                   </div>
                                 </div>


                             <div class="form-group row">
                               <label for="inputPassword" class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-6">
                                   <div class="row">
    								   <?php $gidz = explode(',', $bannerdetails['gender']); ?>
    								   
    							          <div class="col-sm-2 border float-left"><input type="checkbox" name="checkgender" id="checkgender"
    									   <?php if(count($genderarr) == count($gidz)) { echo "checked" ; }?> > </div>
								        <div class="col-sm-10 border float-lg-right">Select All</div>
								    </div>
									
                                   <?php  if($genderarr) { foreach ($genderarr as $gender) { ?>
                                   <div class="row">
                                        <div class="col-sm-2 border float-left">
								          <input type="checkbox" class="checkfirst" name="gender[]" 
										   value="<?php echo $gender; ?>" <?php if (in_array($gender, $gidz)) {
                                                        echo "checked";
                                                    } ?>>
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
                                        <input type="date" class="form-control" name="start_date" required value="<?php echo $bannerdetails['start_date'];?>"/>
                                   </div>
                                 </div>


                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">End Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="end_date" required value="<?php echo $bannerdetails['end_date'];?>" />
                                   </div>
                                 </div>


                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="url" value="<?php echo $bannerdetails['url'];?>"/>
                                   </div>
                                </div>
				 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Count</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="count" readonly value="<?php echo $bannerdetails['count'];?>" />
                                   </div>
                                </div>

				                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">In App</label>
                                    <div class="col-sm-1">
					                   <input type="checkbox" id="vipchekbox" name="in_app" value="true" <?php echo $bannerdetails['in_app'] == 'true' ? "checked" : "" ?>>  
                                   </div>                                 
                                 </div>	

								    <div id="vipdiv" style="display:none">
                                        <div class="true">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Company Name </label>
                                                <div class="col-sm-6">
                                                    <select name="company_id" class="form-control input-lg" id="company_id" >
                                                        <option value="">Please Select</option>                                        
                                                        <?php
                                                        foreach ($companies as $row) {
                                                            if ($row['id'] == $bannerdetails['company_id']) {
                                                                $selected = 'selected="selected"';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            ?>
                                                        <?php if (($row["company_name"]) && ($row["company_arb_name"])){ ?>
                                                            <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'].' / '.$row['company_arb_name'];?></option>
                                                        <?php } else if ($row["company_arb_name"]) { ?>
                                                            <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_arb_name'];?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'];?></option>                                                    
                                                            <?php } }  ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
								    </div>
					   

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Banners<span class="mandatory">*</span></label>
                                   
                                    <div class="col-sm-6">
                                       <?php if($banners) { foreach ($banners as $banner) { ?>
        				               <div class="col-sm-2 mandatory">
                    					     <img src="<?php echo base_url('advertisement/'.$banner->banner); ?>" height=90 width=90 class="img-fluid"> 
                    						<a href="<?php echo site_url('DeleteAdvBanner?id='.$banner->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                    					</div>
                    					<?php } } else { ?> <?php } ?>
                                        <input type="file" name="banner[]" class="form-control" multiple>
                                    </div>
                                </div>
							

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status"/>
                                        <?php if($bannerdetails['status'] == 1){ ?>
                                        <option selected value="1">Active</option>
                                        <option value ="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                        <option selected value ="0">Inactive</option>
                                        <?php } ?>
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
    $(document).ready(function () {
        $('#vipchekbox').click(function () {
             
         $("#vipdiv").toggle(); //for div hide show
         
         if($('#vipchekbox').prop("checked"))
         {
              $("#company_id").attr("required", "true");
         }
         else 
        {
             $("#company_id").removeAttr('required');
        }
        
        });
    });
<?php if ($bannerdetails['in_app'] == 'true') { ?>
        $("#vipdiv").toggle();
        
        $("#company_id").attr("required", "true");
<?php } ?>
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

