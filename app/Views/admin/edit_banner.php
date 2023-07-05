<style>
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
}
</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
			     <div class="row">			   				
                    <h4 class="card-title">Edit Company Banner</h4>	
			     </div>

                <form class="custom-validation"  method='post' action="AboutCompany/update" enctype='multipart/form-data'>
                    <input type="hidden" id="banner_id" name="banner_id" value="<?php echo $bannerdetails['id']; ?>">
                        <div class="for-mobile-laptop">

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Picture <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                       <img src="<?php echo base_url('company/'.$bannerdetails['banner']); ?>" height=190 width=190 class="img-fluid"> <br><br>

                                        <input type="file" name="banner"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                <div class="form-group row mb-0">
                                  <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Update
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
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



