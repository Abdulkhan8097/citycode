<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Comapny FeedBack Details</h4>
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
                                        <p> Username : <?php echo $row->name; ?></p>
                                    </blockquote>              
                                </div>
								
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p> City Code : <?php echo $row->city_code; ?></p>
                                    </blockquote>              
                                </div>
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p> Mobile : <?php echo $row->mobile; ?></p>
                                    </blockquote>              
                                </div>
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p> Gender : <?php echo $row->gender; ?></p>
                                    </blockquote>              
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Name : <?php echo $row->company_name; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Enquiry : <?php echo $row->ce_details; ?></p>
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