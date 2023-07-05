<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Customer Details</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        
                        <div class="card-body">                            
                            <div class="row">
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Name : <?php echo $custdetails['fname']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Id : <?php echo $custdetails['id']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Mobile : <?php echo $custdetails['phone']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Email : <?php echo $custdetails['email']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Created On : <?php echo $custdetails['user_created']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($custdetails['user_status'] == 1){ echo 'Active'; }
                                                            else { echo 'Inactive';} ?></p>
                                    </blockquote>
                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    
                </div>

              
            </div>


            <!-- end row -->
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content --> 