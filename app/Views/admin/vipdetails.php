<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                      <?php if($vipdetails[0]->vip){?>
                        <h4 class="font-size-18">Organzation Details</h4>
                    <?php }else{ ?>
                         <h4 class="font-size-18">V.I.P Details</h4>
                    <?php } ?>
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

<?php foreach ($vipdetails as $details) { ?>
					  <?php if($details->vip){?>
                                     <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Organization Code : <?php echo $details->vip_code; ?></b></p>
                                    </blockquote>            
                                </div>
                                <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Organization Mobile no : <?php echo $details->org_phone; ?></b></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Organization Name : <?php echo $details->org_name; ?></b></p>
                                    </blockquote>            
                                </div>
				 <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Organization Name(arabic) : <?php echo $details->arb_name; ?></b></p>
                                    </blockquote>            
                                </div>
                                 <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p><b>Organization Email : <?php echo $details->org_email; ?></b></p>
                                    </blockquote>            
                                </div>
                            <?php }else{ ?>
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>V.I.P Code: <?php echo $details->vip_code; ?></p>
                                    </blockquote>            
                                </div>

                               <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>City Code : <?php echo $details->city_code; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Full Name : <?php echo $details->name; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Family Name : <?php echo $details->family_name; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Mobile : <?php echo $details->mobile; ?></p>
                                    </blockquote>             
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Email : <?php echo $details->email; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Gender : <?php echo ($details->gender); ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Date Of Birth : <?php echo ($details->date_of_birth); ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Picture : <?php echo $details->profile; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Language : <?php echo $details->language; ?></p>
                                    </blockquote>             
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Nationality : <?php  foreach ($countries as $country) { 
                                                   if($country['country_id'] == $details->nationality){ ?>
                                                    <?php echo $country['country_name'] ?> <?php } } ?>
                                                </p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Governorate :  <?php  foreach ($statedata as $row) { 
                                                   if($row['state_id'] == $details->governorate ){ ?>
                                                    <?php echo $row['state_name'] ?> <?php } } ?>
                                               </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>State :  <?php foreach ($cities as $city) { 
                                                   if($city['city_id'] == $details->state ){ ?>
                                                    <?php echo $city['city_name']; ?> <?php } } ?>
                                               </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($details->status == 1){ echo 'Active'; }
                                                   else { echo 'Inactive';} ?></p>
                                   </blockquote>                
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Craete Date : <?php echo $details->created_date; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Updated Date : <?php echo $details->updated_date; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Picture : <img src="<?php echo base_url('images/'.$details->profile); ?>" height=150 width=150 class="img-fluid" alt="Responsive image"> <br><br></p>
                                    </blockquote>            
                                </div>

<?php } ?>
 <?php } ?>

                               

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