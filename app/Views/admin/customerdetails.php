<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
    .item{
        display:inline;
    }
</style>
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
                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Customers');?>">
                            <i class="ion ion ion-md-arrow-back"></i> Back
                        </a>                            
                        <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCustomer?id=' . $customer->id); ?>">
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
                                    <p>Name : <?php echo $customer->name; ?></p>
                                </blockquote>

                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Interest :  
                                    <?php
                                         $gidz=explode(',',$customer->interest);
                                  
                                         foreach ($interests as $item) { 
                                            if(in_array($item['cat_id'],$gidz)){ echo $item['cat_name'] ;?> ,
                                            
                                            <?php } } ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>City Code : <?php echo $customer->city_code; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>V.I.P Code : <?php echo $customer->vip_code; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>VIP Plus : <?php echo $customer->vip_plus; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Gender : <?php echo $customer->gender; ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Date Of Birth : <?php echo $customer->date_of_birth; ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Nationality : <?php foreach ($countries as $country) {
                                            if ($country['country_id'] == $customer->nationality) {
                                                ?>
        <?php echo $country['country_enName'] ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>



                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Governorate :  <?php foreach ($statedata as $row) {
    if ($row['state_id'] == $customer->stateid) {
        ?>
        <?php echo $row['state_name'] ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>State :  <?php foreach ($cities as $city) {
    if ($city['city_id'] == $customer->cityid) {
        ?>
        <?php echo $city['city_name']; ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Language : <?php echo Ucfirst($customer->language); ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Mobile : <?php echo $customer->mobile; ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Email : <?php echo $customer->email; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Status : <?php if ($customer->status == 1) {
                                                echo 'Active';
                                            } else {
                                                echo 'Inactive';
                                            }
                                            ?></p>
                                </blockquote>
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Profile Photo : 
                                   <?php if($customer->profile) { ?>
                                   <img src="<?php echo base_url('users/' . $customer->profile); ?>" height=150 width=150 class="img-fluid"> <br><br>
                                   <?php } ?></p>
                                </blockquote>            
                            </div>

                             <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>TotalPoint : <?php echo $customer->totalpoint;?></p>
                                </blockquote></div>

                               <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Device : <?php echo $customer->device;?></p>
                                </blockquote></div>

                                <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Operating System : <?php echo $customer->operating_system;?></p>
                                </blockquote></div>

                               <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Phone Model : <?php echo $customer->phone_model;?></p>
                                </blockquote></div>

                               <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Latitude : <?php echo $customer->latitude;?></p>
                                </blockquote></div>

                               <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Longitude : <?php echo $customer->longitude;?></p>
                                </blockquote></div>

                             <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Location : <?php echo $customer->location;?></p>
                                </blockquote></div>

                             <div class="col-6">
                                 <blockquote class="card-blockquote mb-0">
                                    <p>Registered Date : <?php echo $customer->created_date;?></p>
                                </blockquote></div>

                            
                            <h2> Arabic </h2> <hr style="margin-bottom:15px;">
                            <div class="col-6"></div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Interest :  
                                        <?php
                                         $gidz=explode(',',$customer->interest);
                                         foreach ($interests as $item) { 
                                            if(in_array($item['cat_id'],$gidz)){ echo $item['cat_arbname'] ; ?> ,
                                            
                                            <?php } } ?> </p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Gender : <?php if($customer->gender == 'Male') {
                                        echo 'الذكر'; 
                                    } else if($customer->gender == 'Female') {
                                        echo 'أنثى'; } ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Nationality : <?php foreach ($countries as $country) {
                                            if ($country['country_id'] == $customer->nationality) {
                                                ?>
        <?php echo $country['country_arName'] ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>



                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Governorate :  <?php foreach ($statedata as $row) {
    if ($row['state_id'] == $customer->stateid) {
        ?>
        <?php echo $row['arb_state_name'] ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>State :  <?php foreach ($cities as $city) {
    if ($city['city_id'] == $customer->cityid) {
        ?>
        <?php echo $city['city_arb_name']; ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- end row -->
        
    </div> 
</div>

