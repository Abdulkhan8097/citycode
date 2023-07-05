
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Advertisement</h4>
                        <?php echo view('admin/_topmessage'); ?>
                        <form class="custom-validation"  method='post' action="<?php echo site_url('dashboardaddcreate'); ?>" enctype='multipart/form-data'>

                            <div class="for-mobile-laptop">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label"> Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="add_name" required="" placeholder="Enter Name"/>

                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="url" placeholder="Enter Url" />                                      
                                    </div>                                 
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Banners<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="file" name="banner" required class="form-control"  >
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
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('dashboardadd'); ?>">
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