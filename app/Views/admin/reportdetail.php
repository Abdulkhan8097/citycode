<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>

hr{
border:#999999 1px solid; 
width:90%;
}
    .item{
        display:inline;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <?php if(!empty($customer)) { ?>
                    <h4 class="font-size-18">Customer Details</h4>
                    <?php } else if(!empty($companydetails)) { ?>
                        <h4 class="font-size-18">Company Details</h4>
                    <?php } else if(!empty($code_details)) { ?>
                        <h4 class="font-size-18">Offer Details</h4>
                    <?php } else if(!empty($order)){?>
					    <h4 class="font-size-18">Transaction Details</h4>
						<?php } ?>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">
                        <a class="btn btn-secondary waves-effect waves-light" onClick="history.go(-1);">
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
<?php if(!empty($customer)) { ?>					
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
                                    <p>Profile Photo : <img src="<?php echo base_url('users/' . $customer->profile); ?>" height=150 width=150 class="img-fluid" alt="Responsive image"> <br><br></p>
                                </blockquote>            
                            </div>

                             <div class="col-6"></div>

                            
                            <h2> Arebic </h2>
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
        <?php echo $city['city_name']; ?> <?php }
} ?>
                                    </p>
                                </blockquote>            
                            </div>
						
                        </div> <?php } ?><!--- end row ----->
<!-------------------------- company detail ----------------------------------->						
						
				<?php if(!empty($companydetails)) { ?>					
                    <div class="row">
 
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Category : <?php echo $companydetails->cat_name.' / '.$companydetails->cat_arbname; ?></p>
                                    </blockquote>             
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Name : <?php echo $companydetails->company_name; ?></p>
                                    </blockquote>             
                                </div>

                            <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>CR Number : <?php echo $companydetails->cr_number; ?></p>
                                    </blockquote>             
                                </div>

                            <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Username : <?php echo $companydetails->username; ?></p>
                                    </blockquote>             
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Authorized Contact : <?php echo $companydetails->auth_contact; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Display Name: <?php echo ($companydetails->display_name); ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Mobile: <?php echo ($companydetails->mobile); ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Email : <?php echo ($companydetails->email); ?></p>
                                    </blockquote>            
                                </div>
								
						         <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Address : <?php echo $companydetails->address; ?></p>
                                    </blockquote>             
                                </div>		

                          <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Location : <?php echo $companydetails->c_location; ?></p>
                                    </blockquote>             
                                </div>
								
								


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Views : <?php echo $companydetails->views; ?></p>
                                    </blockquote>            
                                </div>


                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Website : <?php echo $companydetails->website; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Instagram : <?php echo $companydetails->instagram; ?></p>
                                    </blockquote>            
                                </div>

                              <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Twitter : <?php echo $companydetails->twitter; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Facebook : <?php echo $companydetails->facebook; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Snapchat : <?php echo $companydetails->snapchat; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($companydetails->status == 1){ echo 'Active'; }
                                                   else { echo 'Inactive';} ?></p>
                                   </blockquote>                
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Picture : <?php if($companydetails->picture) { ?>
                                              <img src="<?php echo base_url('company/'.$companydetails->picture); ?>" height=150 width=150 class="img-fluid"> 
                                             <?php } ?> <br><br></p>
                                    </blockquote>            
                                </div>

                            <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                    </blockquote>            
                                </div> <br>
								
								
								  <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Banner : 
										<?php if($banners){ foreach($banners as $row) { ?>
										<div class="col-6" style="display:inline !important;">
										<img src="<?php echo base_url('company/'.$row->banner); ?>" height=90 width=90 class="img-fluid">
										</div>                                         
										<?php } } ?>
										</p>
                                    </blockquote>            
                                </div>
								
								<div class="col-12">
                                    <blockquote class="card-blockquote mb-0 inn">
                                        <p>Company Document : 										
										<?php if($docss){ foreach($docss as $row) { ?>
										<div class="col-6" style="display:inline !important;">
										<img src="<?php echo base_url('company/'.$row->doc); ?>" height=90 width=90 class="img-fluid">
										</div>                                         
										<?php } } ?></p>
                                    </blockquote>            
                                </div>

                            <div class="col-12">  <h4> Arebic:- </h4> </div>

                            <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Name : <?php echo $companydetails->company_arb_name; ?></p>
                                    </blockquote>             
                                </div>
								
								    <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Username : <?php echo $companydetails->arb_username; ?></p>
                                    </blockquote>             
                                </div>
								
								  <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Location : <?php echo $companydetails->arb_location; ?></p>
                                    </blockquote>             
                                </div>
								
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Display Name: <?php echo ($companydetails->display_arb_name); ?></p>
                                    </blockquote>            
                                </div>
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Address : <?php echo $companydetails->arb_address; ?></p>
                                    </blockquote>             
                                </div>


<!----------------------------- branch name ----------------------->
<hr>
<div class="col-12">  <h2> Branch Name </h2> </div>
<?php if(empty($branch_details)) { ?> <hr> <?php } ?>
<?php if($branch_details) { foreach ($branch_details as $branch) { ?>
																
								  <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch Name: <?php echo $branch->branch_name; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch Username: <?php echo $branch->branch_username; ?></p>
                                    </blockquote>            
                                </div>

                               <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Governorate : <?php foreach ($statedata as $row) { 
                                                   if($row['state_id'] == $branch->state){ ?>
                                                    <?php echo $row['state_name']; ?> <?php } } ?>
                                        </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>State: <?php foreach ($cities as $city) { 
                                                   if($city['city_id'] == $branch->city){ ?>
                                                   <?php echo $city['city_name']; ?> <?php } } ?></p>
                                    </blockquote>            
                                </div> 
                                
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Location: <?php echo $branch->location; ?></p>
                                    </blockquote>            
                                </div>
                                <div class="col-12">  <h4> Arebic:- </h4> </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch Name: <?php echo $branch->arb_branch_name; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch Username: <?php echo $branch->arb_branch_username; ?></p>
                                    </blockquote>            
                                </div>

                               <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Governorate : <?php foreach ($statedata as $row) { 
                                                   if($row['state_id'] == $branch->state){ ?>
                                                    <?php echo $row['arb_state_name']; ?> <?php } } ?>
                                        </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>State: <?php foreach ($cities as $city) { 
                                                   if($city['city_id'] == $branch->city){ ?>
                                                   <?php echo $city['city_arb_name']; ?> <?php } } ?></p>
                                    </blockquote>            
                                </div> 
                                
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Location: <?php echo $branch->arb_branch_location; ?></p>
                                    </blockquote>            
                                </div>
                                <hr />
                            <?php } } ?> 

                              <div class="col-12">  <h2> City Code </h2> </div>
                              <?php if($offer_details) { foreach ($offer_details as $details) { ?>
                                <?php }} ?> <?php if ($details->coupon_type  != 'city')  { ?>
                                <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } ?>

                                 <?php if($offer_details) { foreach ($offer_details as $details) { if ($details->coupon_type == 'city') { ?>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch :  
                                            <?php 
                                            if(($details->branch_name) && ($details->arb_branch_name)){
                                             echo $details->branch_name.' / '.$details->arb_branch_name;
                                            } else if($details->arb_branch_name){
                                                echo $details->arb_branch_name;   
                                             } 
                                             else {
                                                echo $details->branch_name;  
                                             }
                                             ?>
                                             </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Discount: <?php echo $details->company_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>CodeApp Comission: <?php echo $details->comission; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Customer Discount: <?php echo $details->customer_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Discount Details : <?php  foreach ($discount_items as $item) { 
                                                                 if($item->st_id == $details->discount_detail){ 
																 echo $item->st_name.' / '.$item->st_arb_name; } }?></p>
                                    </blockquote>            
                                </div>
								
								 <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description : <?php echo $details->description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Arebic Description : <?php echo $details->arb_description; ?></p>
                                    </blockquote>            
                                    </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date / Time : <?php if($details->start_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->start_date)); } ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date / Time: 
                                    <?php if($details->end_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->end_date)); } ?></p>
                                    </blockquote>            
                                </div>                                

                             <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">           
                                    </blockquote>            
                                </div> <hr />

                         <?php }  } } ?>

                              <div class="col-12">  <h2> V.I.P Code </h2> </div>
                              <?php if($offer_details) { foreach ($offer_details as $details) { ?>
                                <?php }} ?> <?php if ($details->coupon_type  != 'vip')  { ?>
                                <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } ?>

                              <?php if($offer_details) { foreach ($offer_details as $details) { if ($details->coupon_type == 'vip') { ?>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Branch : 
                                        <?php 
                                            if(($details->branch_name) && ($details->arb_branch_name)){
                                             echo $details->branch_name.' / '.$details->arb_branch_name;
                                            } else if($details->arb_branch_name){
                                                echo $details->arb_branch_name;   
                                             } 
                                             else {
                                                echo $details->branch_name;  
                                             }
                                             ?>
                                             </p>
                                    </blockquote>            
                                </div>

                              <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Discount: <?php echo $details->company_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>CodeApp Comission: <?php echo $details->comission; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Customer Discount: <?php echo $details->customer_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Discount Details : <?php  foreach ($discount_items as $item) { 
                                                                 if($item->st_id == $details->discount_detail){ 
																 echo $item->st_name.' / '.$item->st_arb_name; } }?></p>
                                    </blockquote>            
                                </div>
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description : <?php echo $details->description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Arebic Description : <?php echo $details->arb_description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date / Time : 
                                        <?php if($details->start_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->start_date)); } ?>
                                        </p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date / Time:
                                        <?php if($details->end_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->end_date)); } ?></p>
                                    </blockquote>            
                                </div>                                

                             <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">           
                                    </blockquote>            
                                </div> <hr />

                         <?php } } } ?>

                              <div class="col-12">  <h2> Friday Code </h2> </div>
                              <?php if($offer_details) { foreach ($offer_details as $details) { ?>
                                <?php }} ?> <?php if ($details->coupon_type  != 'friday')  { ?>
                                <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } ?>

                              <?php if($offer_details) { foreach ($offer_details as $details) { if ($details->coupon_type == 'friday') { ?>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch :  
                                            <?php 
                                            if(($details->branch_name) && ($details->arb_branch_name)){
                                             echo $details->branch_name.' / '.$details->arb_branch_name;
                                            } else if($details->arb_branch_name){
                                                echo $details->arb_branch_name;   
                                             } 
                                             else {
                                                echo $details->branch_name;  
                                             }
                                             ?>
                                             </p>
                                    </blockquote>            
                                </div>

                              <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Discount: <?php echo $details->company_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>CodeApp Comission: <?php echo $details->comission; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Customer Discount: <?php echo $details->customer_discount; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Discount Detail : <?php  foreach ($discount_items as $item) { 
                                                                 if($item->st_id == $details->discount_detail){ 
																 echo $item->st_name.' / '.$item->st_arb_name; } }?></p>
                                    </blockquote>            
                                </div>
								
								<div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description : <?php echo $details->description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Arebic Description : <?php echo $details->arb_description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date / Time : <?php if($details->start_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->start_date)); } ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date / Time:  <?php if($details->end_date == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($details->end_date)); } ?></p>
                                    </blockquote>            
                                </div>

                                

                             <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">           
                                    </blockquote>            
                                </div> <hr />

                         <?php } } } ?>


<div class="col-12">  <h2> Online Shop </h2> </div>

<?php if($companydetails->online_shop == '1') { ?>
																
								  <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description: <?php echo $companydetails->online_description; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date / Time: <?php if($companydetails->online_startdate == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($companydetails->online_startdate)); } ?></p>
                                    </blockquote>            
                                </div>
								
								   <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date / Time: <?php if($companydetails->online_enddate == '0000-00-00 00:00:00') {
                                          echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($companydetails->online_enddate)); } ?></p>
                                    </blockquote>            
                                </div>

                          <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Online Link: <?php echo $companydetails->online_link; ?></p>
                                    </blockquote>            
                                </div>

                          <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Play Store Link: <?php echo $companydetails->online_playstore_link; ?></p>
                                    </blockquote>            
                                </div>


                          <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>IOS Store Link: <?php echo $companydetails->online_ios_link; ?></p>
                                    </blockquote>            
                                </div>


                          <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Huawei Link: <?php echo $companydetails->online_huawei_link; ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description: <?php echo $companydetails->online_arb_description; ?></p>
                                    </blockquote>            
                                </div>

                         <?php } ?>  
                        </div>                
				<?php } ?>
<!---------------------------- company detail end here ------------------------>	


<?php if(!empty($code_details)) { ?>					
                        <div class="row">						
                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Company Name : <?php echo $code_details->company_name; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Arabic Company Name : <?php echo $code_details->company_arb_name; ?></p>
                                </blockquote>
                            </div>
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Branch Name : <?php echo $code_details->branch_name; ?></p>
                                </blockquote>
                            </div>
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Arabic Branch Name : <?php echo $code_details->arb_branch_name; ?></p>
                                </blockquote>
                            </div>
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Coupon Type : <?php echo $code_details->coupon_type; ?></p>
                                </blockquote>
                            </div>
							
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Company Discount : <?php echo $code_details->company_discount; ?></p>
                                </blockquote>
                            </div>
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Comission : <?php echo $code_details->comission; ?></p>
                                </blockquote>
                            </div>
							
							 <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Customer Discount : <?php echo $code_details->customer_discount; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p> Discount Detail : <?php echo $code_details->discount_detail; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Description : <?php echo $code_details->description; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Arb Description : <?php echo $code_details->arb_description; ?></p>
                                </blockquote>
                            </div>
							
							
							
							                  						
                        </div> <?php } ?>

<!--------------------------- transaction start here --------------------->
<?php if(!empty($order)) { ?>					
                        <div class="row">						
                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Username : <?php echo $order->username; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>City Code : <?php echo $order->city_code; ?></p>
                                </blockquote>
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>V.I.P Code : <?php echo $order->vip_code; ?></p>
                                </blockquote>
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Company Name : <?php echo $order->company_name; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Branch Name : <?php echo $order->branch_name; ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Order Number : <?php echo $order->od_number; ?></p>
                                </blockquote>            
                            </div>
                           
                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Totalamount : <?php echo $order->od_totalamount; ?></p>
                                </blockquote>            
                            </div>

                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Saveamount : <?php echo $order->od_saveamount; ?></p>
                                </blockquote>            
                            </div>


                            <div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>paidamount : <?php echo $order->od_paidamount; ?></p>
                                </blockquote>            
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>point : <?php echo $order->od_point; ?></p>
                                </blockquote>            
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                    <p>Description : <?php echo $order->od_description; ?></p>
                                </blockquote>            
                            </div>
							
							<div class="col-6">
                                <blockquote class="card-blockquote mb-0">
                                     <p>Recieptphoto :<img src="<?php echo base_url('company/' . $order->receiptimg); ?>" height=150 width=150 class="img-fluid" alt="image"> <br><br></p>
                                </blockquote>            
                            </div>                   						
                        </div> <?php } ?>
<!--------------------------- transaction end here --------------------->
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- end row -->       
    </div> 
</div>
