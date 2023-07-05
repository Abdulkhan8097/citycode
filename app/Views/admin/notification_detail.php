<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Notification Details</h4>
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
                            <?php 
                            $session = session();
                            if (!$session->get('company_id')) {?>    
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p> <b>Interest :</b> <?php
                                         $gidz=explode(',',$row->interest);
                                  
                                         foreach ($interests as $item) { 
                                            if(in_array($item['cat_id'],$gidz)){ echo $item['cat_name'] ;?> ,
                                            
                                            <?php } } ?></p>
                                    </blockquote>              
                                </div>
                            <?php } ?>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Description :</b> <?php echo $row->description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Title :</b> <?php echo $row->title; ?></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Gender :</b> <?php echo $row->gender; ?></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Governorate :</b> <?php echo $row->state_name; ?></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>State :</b> <?php echo $row->city_name; ?></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>language :</b> <?php echo $row->language; ?></p>
                                    </blockquote>            
                                </div>
                                <div class="col-3">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Created Date :</b> <?php echo $row->created_date; ?></p>
                                    </blockquote>            
                                </div> 
                                <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Image Url :</b> <?php echo $row->image_url; ?></p>
                                    </blockquote>            
                                </div> 
                                <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                       
                                        <p><b>Image :</b><img src="<?php echo base_url('company/'.$row->image); ?>" height=90 width=90 class="img-fluid"></p>
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