<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
hr{
border:#999999 1px solid; 
width:90%;
}

.card{
color:#000;
}
.page-title-box{
color:#000;
}

</style>

<?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Company Details</h4>
                    </div>
                </div>

 <?php if(!$session->get('company_name')) { ?>
                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>                            
                            <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCompany?id='.$companydetails->id); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Edit
                            </a> 
                        </div>
                    </div>
                </div>
<?php } ?>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        
                        <div class="card-body">                            
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
                                        <p>WhatsApp : <?php echo $companydetails->whatsapp; ?></p>
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

                            <div class="col-12">  <h4> Arabic:- </h4> </div>

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
<hr />								
<!-------------------------- branch name------------------------->

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
                                        <p>State: <?php foreach ($all_cities as $city) { 
                                                   if($city['city_id'] == $branch->city){ ?>
                                                   <?php echo $city['city_name']; ?> <?php } } ?></p>
                                    </blockquote>            
                                </div> 
                                
                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Location: <?php echo $branch->location; ?></p>
                                    </blockquote>            
                                </div>
                                <div class="col-12">  <h4> Arabic:- </h4> </div>

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
                                        <p>State: <?php foreach ($all_cities as $city) { 
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
                                <?php if ($details->coupon_type  != 'city')  { ?>
                              <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } } } ?>
								
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
                                        <p>Discount Details :  <?php  foreach ($discount_items as $item) { 
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
                                        <p>Arabic Description : <?php echo $details->arb_description; ?></p>
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
                                 <?php if ($details->coupon_type  != 'vip')  { ?>
                                                             <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } }}?>

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
                                        <p>Arabic Description : <?php echo $details->arb_description; ?></p>
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
                                 <?php if ($details->coupon_type  != 'friday')  { ?>
                                                            <hr><?php } else if(empty($offer_details)) { ?> <hr> <?php } } } ?>

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
                                        <p>Arabic Description : <?php echo $details->arb_description; ?></p>
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
                    </div>
                </div>
            <br>
        </div>
    </div>
 <!-- end row -->
</div> <!-- container-fluid -->
</div>

