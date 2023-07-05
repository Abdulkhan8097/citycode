
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Edit Banner</h4>
				                <?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="<?php echo site_url('updateadd');?>" enctype='multipart/form-data'>
                                <input type="hidden" id="new_id" name="add_id" value="<?php echo $bannerdetails['add_id']; ?>">
                                    <div class="for-mobile-laptop">
                                        
                                        <div class="form-group row">
                                           <label for="inputPassword" class="col-sm-2 col-form-label"> Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="add_name" value="<?php echo $bannerdetails['add_name']; ?>" required="" placeholder="Enter Name" />
                                            </div>
                                       </div>
                                        
                                        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="url" value="<?php echo $bannerdetails['url']; ?>"  placeholder="Enter Url" />                                      
                                    </div>                                 
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Advertisement<span class="mandatory">*</span></label>
                                   
                                    <div class="col-sm-6">
                                       <?php if($bannerdetails['add_image']) {  ?>
        				               <div class="col-sm-2 mandatory">
                    					     <img src="<?php echo base_url('advertisement/'.$bannerdetails['add_image']); ?>" height=90 width=90 class="img-fluid"> 
                    						<a href="<?php echo site_url('deladdimage?add_id='.$bannerdetails['add_id']); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                    					</div>
                    					<?php  }  ?> 
                                        <input type="file" name="banner" class="form-control" >
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
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('dashboardadd');?>">
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