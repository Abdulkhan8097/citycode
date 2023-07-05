<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Delivery Details</h4>
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
                        <div class="card-header">
                            Delivery Details
                        </div>
                        <div class="card-body">                            
                            <div class="row">
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Order ID : <?php echo $orderdetails['id']; ?></p>
                                    </blockquote>                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Order Date : <?php echo $orderdetails['date_created']; ?></p>
                                    </blockquote>                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Customer Name : <?php echo $orderdetails['username']; ?></p>
                                    </blockquote>                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Mobile : <?php echo $orderdetails['mobile']; ?></p>
                                    </blockquote>
                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Source : <?php echo $orderdetails['source']; ?></p>
                                    </blockquote>                                               
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Destination : <?php echo $orderdetails['destination']; ?></p>
                                    </blockquote>
                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            Medicine
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Medicine Name : <?php echo $orderdetails['med_name']; ?></p>
                                    </blockquote>
                                </div>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Quantity : <?php echo $orderdetails['qty']; ?></p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>

              
            </div>


            <!-- end row -->
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content --> 