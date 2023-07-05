<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Celebrity Details</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>                            
                            <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCelebrity?id='.$customer['id']); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Edit
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
                                        <p>Name : <?php echo $celebrity['name']; ?></p>
                                    </blockquote>
                                               
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Family Name : <?php echo $celebrity['family_name']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Interest :  
<?php 
$numbers= 'Restaurants,Perfumes,Health & Beauty,Hotels,Furniture & House Holds,Cars,Clothes & Shops,Travel & tourism';
$array =  explode(',', $numbers); 
foreach ($array as $item) { 
$gidz=explode(',',$celebrity['interest']);
 if(in_array($item,$gidz)){ echo $item;?> , <?php }}?> </p>
</div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>City Code : <?php echo $celebrity['city_code']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>V.I.P Code : <?php echo $celebrity['vip_code']; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Gender : <?php echo $celebrity['gender']; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Date Of Birth : <?php echo $celebrity['date_of_birth']; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                          <p>Nationality : <?php  foreach ($countries as $country) { 
                                              if($country['country_id'] == $celebrity['nationality']){ ?>
                                                <?php echo $country['country_name'] ?> <?php } } ?>
                                           </p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Governorate :  <?php  foreach ($statedata as $row) { 
                                                   if($row['state_id'] == $celebrity['governorate']){ ?>
                                                    <?php echo $row['state_name'] ?> <?php } } ?>
                                               </p>
                                    </blockquote>            
                                </div>


                              <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>State :  <?php foreach ($cities as $city) { 
                                                   if($city['city_id'] == $celebrity['state']){ ?>
                                                    <?php echo $city['city_name']; ?> <?php } } ?>
                                               </p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Language : <?php echo Ucfirst($celebrity['language']); ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Mobile : <?php echo $celebrity['mobile']; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Email : <?php echo $celebrity['email']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date : <?php echo $celebrity['start_date']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date : <?php echo $celebrity['end_date']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Craete Date : <?php echo $celebrity['created_date']; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Updated Date : <?php echo $celebrity['updated_date']; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Profile : <img src="<?php echo base_url('images/'.$celebrity['profile']); ?>" height=150 width=150 class="img-fluid" alt="Responsive image"> <br><br></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($celebrity['status'] == 1){ echo 'Active'; }
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