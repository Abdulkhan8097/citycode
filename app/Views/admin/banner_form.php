  <style>
/*.for-mobile-laptop {
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
                               <form class="custom-validation"  method='post' action="AboutCompany/add" enctype='multipart/form-data'>

                          <div class="for-mobile-laptop">
				
				            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Company Banners<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="file" name="banner[]" required class="form-control"  multiple >
                                  </div>
                                </div>

                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
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


