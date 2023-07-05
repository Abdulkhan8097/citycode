<style>

.for-mobile-laptop {
  margin: 0 100px;
}

@media only screen and (max-width: 600px) {
  .for-mobile-laptop {
     margin: 0;

  }
}
label {
    float: left
}
span {
    display: block;
    overflow: hidden;
    padding: 0 4px 0 6px
}
input {
    width: 100%
}
.mandatory {
display:inline;
color:red;
}
.files {
display:inline;
}
.btn-primary{
color:#000 !important;
}
hr {
border:4px solid !importnat;
color:#000;
}
.percent{
display:inline !important;
}
.fa {
color:red !important;
}
.img-fluid{
    margin-top:20px;
}
.nav-item{
margin-right: 0px;
}
</style> 


<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Edit Company</h4>
							   <?php echo view('admin/_topmessage'); ?>
                 <form class="custom-validation"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
                    <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>">
                       <div class="for-mobile-laptop">
                         
                       
                      <div class="row">
                        <div class="col-md-6">
						  		        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Category<span class="mandatory">*</span></label>
                               <div class="col-sm-6">
                                    <select class="form-control" name="category" required>
                                    <option value="">- Please Select -</option>
                                      <?php  foreach ($categories as $catg) { 
                                                   if($catg['cat_id'] == $companydetails->category){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $catg['cat_id'] ?>" <?php echo $selected ?>><?php echo $catg['cat_name'].' / '.$catg['cat_arbname'] ?></option>
                                           <?php } ?> 
                                  </select>    
                                   </div>
                                </div> 
                               </div>
                              </div> 
                               
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter name" name="company_name" value="<?php echo $companydetails->company_name;?>"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic company name" name="company_arb_name" value="<?php echo $companydetails->company_arb_name;?>"/>
                                  </div>
                                </div>
                              </div>
                       </div>
								
								<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">CR Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" required placeholder="Enter CR Number" name="cr_number" value="<?php echo $companydetails->cr_number;?>"/>
                                  </div>
                                </div>

                      <div class="row">
                          <div class="col-md-6">
								               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter Username" name="username" value="<?php echo $companydetails->username;?>"/>
                                  </div>
                                </div>
                           </div>


                           <div class="col-md-6">
								               <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic Username" name="arb_username" value="<?php echo $companydetails->arb_username;?>"/>
                                  </div>
                                </div>
                           </div>
                         </div>

                               <div class="form-group row">                   
                                    <label for="inputPassword" class="col-sm-2 col-form-label">EMail Id<span class="mandatory">*</span></label>
                                     <div class="col-sm-7">
                                        <input type="email" class="form-control" required
                                                parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail" value="<?php echo $companydetails->email;?>"/>
                                    </div>
                                    <div class="text-danger" id="email-exist-error-msg">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-7">
									<input type="password" id="pass2" class="form-control" placeholder="Password" name="password" value="****" />

                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Re-Type Password</label>
                                    <div class="col-sm-7">
                                      <input type="password" class="form-control" data-parsley-equalto="#pass2" placeholder="Re-Type Password" name="rep_password" value="****"/>
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Authorized Contact<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                    <input type="text" class="form-control" required placeholder="Enter authorized contact" name="auth_contact" value="<?php echo $companydetails->auth_contact;?>"/>
                                 </div>
                               </div>
								
								             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Mobile Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" required placeholder="Enter mobile Number" name="mobile" value="<?php echo $companydetails->mobile;?>"/>
                                  </div>
                                </div>
								
                    <div class="row">
                        <div class="col-md-6">
								               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Location<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter location" name="location" value="<?php echo $companydetails->c_location;?>"/>
                                  </div>
                                </div>
                             </div>

                             <div class="col-md-6">
								               <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic location" name="arb_location" value="<?php echo $companydetails->arb_location;?>"/>
                                  </div>
                                </div>
                             </div>
                           </div>

                           <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Display Name</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter display name" name="display_name" value="<?php echo $companydetails->display_name;?>"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic display name" name="display_arb_name" value="<?php echo $companydetails->display_arb_name;?>"/>
                                  </div>
                                </div>
                              </div>
                             </div>
								
                         <div class="row">
                            <div class="col-md-6">
								               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?php echo $companydetails->address;?>"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
								               <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic Address" name="arb_address" value="<?php echo $companydetails->arb_address;?>"/>
                                  </div>
                                </div>
                              </div>
                           </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Profile Picture</label>
                                   
                                    <div class="col-sm-7">
                                        <?php if (!empty($companydetails->picture)) { ?>
					<img src="<?php echo base_url('company/'.$companydetails->picture);?>" height=190 width=190 class="img-fluid"> 
                                         <?php } else { ?> <?php } ?> <br> <br>
                                        <input type="file" name="picture" /> 
                                    </div>
                                </div>
							
															
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Views</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="views" value="<?php echo $companydetails->views;?>"/>
                                  </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Website</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="website" value="<?php echo $companydetails->website;?>"/>
                                  </div>
                                </div>





                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Instagram</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="instagram" value="<?php echo $companydetails->instagram;?>"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="twitter" value="<?php echo $companydetails->twitter;?>"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="facebook" value="<?php echo $companydetails->facebook;?>"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Snapchat</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="snapchat" value="<?php echo $companydetails->snapchat;?>"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">WhatsApp</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="whatsapp" value="<?php echo $companydetails->whatsapp;?>"/>
                                  </div>
                                </div>
								
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-7">
                                         <select class="form-control" required name="status"/>
                                        <?php if($companydetails->status == 1){ ?>
                                        <option selected value="1">Active</option>
                                        <option value ="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                        <option selected value ="0">Inactive</option>
                                        <?php } ?>
                                    </select>
                                   </div>
                                 </div>


								
				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Company Banners</label>
                                    <div class="col-sm-7">
					<?php if($banners) { foreach ($banners as $banner) { ?>
					    <div class="col-sm-2 mandatory">
						<img src="<?php echo base_url('company/'.$banner->banner); ?>" height=90 width=90 class="img-fluid">
						<a href="<?php echo site_url('DeleteBanner?id='.$banner->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                            </div>
				      <?php } } else { ?> <?php } ?>
                                     <input type="file" name="banner[]" class="form-control"  multiple>
									 
                                  </div>
                                </div>
								
								
			                     <div class="form-group row">
                                     <label for="inputPassword" class="col-sm-2 col-form-label">Company Douments</label>
                                        <div class="col-sm-7">
                					<?php if($docss) { foreach ($docss as $dice) { ?>
                					    <div class="col-sm-2 files">
                						<img src="<?php echo base_url('company/'.$dice->doc); ?>" height=90 width=90 class="img-fluid">
                						<a href="<?php echo site_url('DeleteDocument?id='.$dice->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                					    </div>
                				    <?php } } else { ?> <?php } ?>
                                        <input type="file" name="doc[]" class="form-control"  multiple>
                                      </div>
                                </div>
								
								
								 <div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>

                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div>
								
								
				<!--<button type="button" class="btn btn-primary btn-lg">Discount Type</button>-->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalbranch">Create New Branch</button>
        <h1> Discount Type </h1><br /> <br />

  <ul class="nav nav-tabs col-sm-12"  role="tablist">
        <li class="nav-item col-sm-2">
          <a class="nav-link active " data-toggle="tab" href="#city_code">Public Offer</a>
        </li>
        <li class="nav-item col-sm-2">
          <a class="nav-link " data-toggle="tab" href="#vip_code">V.I.P Code Offer</a>
        </li>
        <li class="nav-item col-sm-2">
          <a class="nav-link" data-toggle="tab" href="#friday_code">Friday Offer</a>
        </li>

        <li class="nav-itemcol-sm-2">
          <a class="nav-link" data-toggle="tab" href="#online_shop">Online Shop Offer</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#home_business">Home Business</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#branch_code">Branch Name</a>
        </li>


  </ul>
 							
								
<div class="tab-content">
    <div id="city_code" class="container tab-pane active"><br>
      <h3> Public Offer </h3> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add New</button></label>
  <!---- start row ------------->
	   <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
											<th scope="col">Type</th>
                                            <th scope="col">Branch</th>
                                            
                                            <th scope="col">Percentage</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                                  foreach($results as $kdata){ if($kdata->coupon_type == 'city') {?>
                                            <th scope="row"><?php echo ++$i;?></th>
                                            <td><?php echo $kdata->start_date; ?></td>
                                            <td><?php echo $kdata->end_date; ?></td>
											<td><?php echo $kdata->coupon_type; ?></td>
                                            <td><?php foreach($branches as $bnch) { 
                                                    if ($bnch->branch_id == $kdata->branch_id) { 
                                              echo $bnch->branch_name; } } ?></td>
                                              <td><?php echo $kdata->customer_discount.' %'; ?></td>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light"  href="<?php echo site_url('EditOffer?id='.$kdata->id.'&&'.'company_id='.$kdata->company_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteOffer?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>  
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                                <?php //if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php //} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>
	
    <div id="vip_code" class="container tab-pane fade"><br>
      <h3> V.I.P Code Offer </h3> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalfamous">Add New</button>
<!---- start row ------------->
	   <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
											<th scope="col">Type</th>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Percentage</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                                  foreach($results as $kdata){ if($kdata->coupon_type == 'vip') {?>
                                            <th scope="row"><?php echo ++$i;?></th>
											<td><?php echo $kdata->coupon_type; ?></td>
                                            <td>
                                              <?php foreach($branches as $bnch) { 
                                                    if ($bnch->branch_id == $kdata->branch_id) { 
                                                     echo $bnch->branch_name; } } 
                                              ?></td>
                                              <td><?php echo $kdata->customer_discount.' %'; ?></td>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditOffer?id='.$kdata->id.'&&'.'company_id='.$kdata->company_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteOffer?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>  
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                                <?php //if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php //} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>
	
    <div id="friday_code" class="container tab-pane fade"><br>
      <h3> Friday Offer </h3> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalfriday">Add New</button>
<!---- start row ------------->
	   <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
											<th scope="col">Type</th>
                                            <th scope="col">Branch</th>
                                             <th scope="col">Percentage</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                                  foreach($results as $kdata){ if($kdata->coupon_type == 'friday') {?>
                                            <th scope="row"><?php echo ++$i;?></th>
											<td><?php echo $kdata->coupon_type; ?></td>
                                           <td>
                                              <?php foreach($branches as $bnch) { 
                                                    if ($bnch->branch_id == $kdata->branch_id) { 
                                                     echo $bnch->branch_name; } } 
                                              ?></td>
                                              <td><?php echo $kdata->customer_discount.' %'; ?></td>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditOffer?id='.$kdata->id.'&&'.'company_id='.$kdata->company_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteOffer?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>  
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                                <?php //if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php //} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>

    <!--------- online offer ----------->
	
    <div id="online_shop" class="container tab-pane fade"><br>
      <h3> Online Shop Offer </h3> 

      <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('editonlineshop?company_id='.$companydetails->id); ?>">
        <i class="fas fa-edit"></i> Edit
      </a>

      <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('delete_onlineshop?company_id='.$companydetails->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
          <i class="fas fa-trash"></i> Delete
      </a>  
	   <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">                            
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Description : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_description;?>  
                            </div>
                          </div>

                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Arabic Description : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_arb_description;?>  
                            </div>
                          </div>

                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time : </label>
                            <div class="col-sm-6">  
                            <?php //echo date('Y-m-d', strtotime($companydetails->online_startdate)); ?>
                            <?php if($companydetails->online_startdate == '0000-00-00 00:00:00') {
                                   echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($companydetails->online_startdate)); } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time : </label>
                            <div class="col-sm-6">  
                            <?php //echo date('Y-m-d', strtotime($companydetails->online_enddate)); ?>
                            <?php if($companydetails->online_enddate == '0000-00-00 00:00:00') {
                                   echo ''; }else { ?> <?php  echo date('Y-m-d', strtotime($companydetails->online_enddate)); } ?>
                            </div>
                          </div>


                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Online Link : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_link;?>  
                            </div>
                          </div>

                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Play Store Link : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_playstore_link;?>  
                            </div>
                          </div>

                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">IOS Store Link : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_ios_link;?>  
                            </div>
                          </div>

                          <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Huawei Link : </label>
                            <div class="col-sm-6">  
                              <?php echo $companydetails->online_huawei_link;?>  
                            </div>
                          </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<!---------------- branch list ------------------->

    <div id="branch_code" class="container tab-pane fade"><br>
      <h3> Branch Name </h3> 
       <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalbranch">Add New</button>
  <!---- start row ------------->
	   <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
											                     
                                            <th scope="col">Branch Name</th>
                                            <th scope="col">Arabic Branch Name</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                                  foreach($branches as $bnch){ ?>
                                            <th scope="row"><?php echo ++$i;?></th>
                                            <td><?php echo $bnch->branch_name ; ?></td>
                                            <td><?php echo $bnch->arb_branch_name ; ?></td>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditBranch?id='.$bnch->branch_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteBranch?id='.$bnch->branch_id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>  
                                            </td>                                            
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <?php //if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php //} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>
     <div id="home_business" class="container tab-pane fade"><br>
      <h3> Home Business </h3> 
       <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalbusiness">Add New</button>
  <!---- start row ------------->
       <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                     <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                            foreach($results as $kdata){ if($kdata->coupon_type == 'homebusiness') {?>
                                            <th scope="row"><?php echo ++$i;?></th>
                                            <td><?php echo substr($kdata->description,0,20);?></td>
                                            <td><?php echo $kdata->h_email; ?></td>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light"  href="<?php echo site_url('EditBusiness?id='.$kdata->id.'&&'.'company_id='.$kdata->company_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteOffer?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>  
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                                <?php //if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php //} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
    </div>   
    </div>

<!-------------- branch form start here ------------------------>


		
<!----------------------- branch name end here ------------------------>	
							


                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->    
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

<!------------------------------------------------------------------- city_code ----------------------------------------------------------->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> City code </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>		 		 
            <div class="modal-body">
							 <form class="custom-validation" id="company_form"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
               <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>">
                             <div id="city_field"> 

                              <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Branch<span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <select name="c_branch"  class="form-control input-lg" required>
                                      <option value="">- Please Select -</option>
                                <?php
                                foreach($branches as $branch)
                                {
                                  if(($branch->branch_name) && ($branch->arb_branch_name)){
                                  echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.' / '.$branch->arb_branch_name.'</option>';
                                  }
                                  else if($branch->arb_branch_name){
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->arb_branch_name.'</option>';
                                  }
                                  else{
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.'</option>';
                                  }
                                }
                                ?>                                    
                                  </select>
                                </div>
                              </div>
 
                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="company_discount" id="txt1"  onKeyUp="numericFilter(this, sum());" /> 
                                  </div> <div class="col-sm-1">%</div>
                                </div>

								
				 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="comission" id="txt2"  onKeyUp="numericFilter(this, sum());" />
                                  </div> <div class="col-sm-1">%</div>
                                </div>
								
								<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">

                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="customer_discount" id="txt3" readonly/>
                                  </div> <div class="col-sm-1">%</div>
                                </div>


                                

                               <div class="form-group row" id="discount_item_p">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="c_disc_detail" >
                                 <option value="">- Please Select -</option>
                                   <?php foreach ($discount_items as $item) {       
                                    echo '<option value="'.$item['st_id'].'">'.$item['st_name'].' / '.$item['st_arb_name'].'</option>';
                                  } ?>

                                  </select>                           
                                  </div>
                                </div>


                                <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="offer_p"  cols="6" rows="4"  name="offer_p" value="Yes">
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_p" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name" name="offer_name" cols="6" rows="4" placeholder="Offer Name"/><br>
                                       <input type="text" class="form-control" id="offer_name_arabic" name="offer_name_arabic" cols="6" rows="4" placeholder="Arabic Offer Name "/>
                                  </div>
                                </div>

                                

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="c_description" cols="6" rows="4" placeholder="Enter Description"></textarea><br>
                                       <textarea class="form-control" name="c_arb_description" cols="6" rows="4" placeholder="Arabic Description"></textarea>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="c_start"/>
                                   </div>
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_end"/>                                      
                                   </div>        
                                 </div>
								 
						<!------------------------------------- priority start here------------------------->
						
							<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">   								  
					               <select name="c_priority"  class="form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($priorities) { foreach ($priorities as $prio) { ?>
                                        <option value="<?php echo $prio; ?>"> <?php echo $prio; ?> </option>
                                        <?php } } ?>
                                  </select>
                                </div>
                              </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_priority_start"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_priority_end"/>                                      
                                   </div>        
                                 </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_p"  cols="6" rows="4"  name="mall" value="Yes">
                                  </div>
                                </div>

                                <div class="form-group row" id="mall_div1" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div  2" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic"   cols="6" rows="4"  name="mall_name_arabic">
                                  </div>
                                </div> -->
								 
	                       <!------------------------------------- priority end here------------------------->
                           <!-- dynamic_field -->
						   
						   	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
								
								</form>
								</div>
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->

							
<!-------------------------------------------------------------------------v.i.p code -------------------------------------------------->

  <div class="modal fade" id="myModalfamous" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> V.I.P Code </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
            <div class="modal-body">
             <form class="custom-validation"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
               <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>">          
		                 	<div id="famous_field">
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Branch<span class="mandatory">*</span></label>
                            <div class="col-sm-6">
                              <select name="fam_branch"  class="form-control input-lg" required>
                                 <option value="">- Please Select -</option>
                                <?php
                                foreach($branches as $branch)
                                {
                                  if(($branch->branch_name) && ($branch->arb_branch_name)){
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.' / '.$branch->arb_branch_name.'</option>';
                                    }
                                    else if($branch->arb_branch_name){
                                      echo '<option value="'.$branch->branch_id.'">'.$branch->arb_branch_name.'</option>';
                                    }
                                    else{
                                      echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.'</option>';
                                    }                                
                                  }
                                ?>                                    
                                  </select> 
                                </div>
                             </div>                        
								
				                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="fam_company_discount" id="txt10" onKeyUp="numericFilter(this, famsum());" />
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="fam_comission" id="txt20" onKeyUp="numericFilter(this, famsum());" />

                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="fam_customer_discount" id="txt30" readonly/>
                                  </div><div class="col-sm-1">%</div>
                                </div>

                               <div class="form-group row" id="discount_item_v">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fam_disc_detail" >
                                        <option value="">- Please Select -</option>
                                        <?php foreach ($discount_items as $item) {       
                                    echo '<option value="'.$item['st_id'].'">'.$item['st_name'].' / '.$item['st_arb_name'].'</option>';
                                  } ?>	
                                  </select>
                                  </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="offer_v"  cols="6" rows="4"  name="offer_p" value="Yes">
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_v" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name1" name="offer_name" cols="6" rows="4" placeholder="Offer Name"/><br>
                                       <input type="text" class="form-control" id="offer_name_arabic1" name="offer_name_arabic" cols="6" rows="4" placeholder="Arabic Offer Name "/>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="fam_description" cols="6" rows="4" placeholder="Enter Description"></textarea><br>
                                       <textarea class="form-control" name="fam_arb_description" cols="6" rows="4" placeholder="Arabic Description"></textarea>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="fam_start"/>
                                   </div>
                                 </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_end"/>                                      
                                     </div> 
                                   </div>
								   
								   	<!------------------------------------- priority start here------------------------->
						
							<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">
                                    <select name="fam_priority"  class="form-control input-lg">
                                      <option value="">- Please Select -</option>
                                        <?php if($priorities) { foreach ($priorities as $prio) { ?>
                                        <option value="<?php echo $prio; ?>"> <?php echo $prio; ?> </option>
                                        <?php } } ?>                      
                                  </select>
                                </div>
                              </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_priority_start"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_priority_end"/>                                      
                                   </div>        
                                 </div>

                                 <div class="form-group row" >
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_v"  cols="6" rows="4"  name="mall" value="Yes">
                                  </div>
                                </div>

                                <!-- <div class="form-group row" id="mall_div3" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name1"  cols="6" rows="4"  name="mall_name">
                                  </div>
                                </div> -->

                                <div class="form-group row" id="mall_div3" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div4" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic1"  cols="6" rows="4"  name="mall_name_arabic">
                                  </div>
                                </div> -->
								 
	                       <!------------------------------------- priority end here------------------------->
	   
     <div class="form-group row mb-0" style="margin-top:50px;">
                     <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                Submit
                            </button>
                        </div>
                    </div>
  </form>
</div>
         </div> <!-- end modal body-->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div><!-- end modal content-->    
</div><!-- modal-dialog -->
</div><!-- modal fade -->

  
<!-----------------------------------------------------------------friday code ----------------------------------------------------------->

<div class="modal fade" id="myModalfriday" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> Friday Code </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <div class="modal-body">
					<form class="custom-validation"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
                       <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>"> 
			                  <div id="friday_field">
                           <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Branch<span class="mandatory">*</span></label>
                              <div class="col-sm-6">
                                <select name="fri_branch"  class="form-control input-lg" required>
                                      <option value="">- Please Select -</option>
                                <?php
                                foreach($branches as $branch)
                                {
                                  if(($branch->branch_name) && ($branch->arb_branch_name)){
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.' / '.$branch->arb_branch_name.'</option>';
                                    }
                                    else if($branch->arb_branch_name){
                                      echo '<option value="'.$branch->branch_id.'">'.$branch->arb_branch_name.'</option>';
                                    }
                                    else{
                                      echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.'</option>';
                                    }
                                }
                                ?>                                    
                                  </select>                                  
                                </div>
                              </div>
                                  											
			          	<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="fri_company_discount" id="txt40"  onKeyUp="numericFilter(this, frisum());" />
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="fri_comission" id="txt50"  onKeyUp="numericFilter(this, frisum());" />
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="fri_customer_discount" id="txt60" readonly/>
                                  </div><div class="col-sm-1">%</div>
                                </div>

                               <div class="form-group row" id="discount_item_c">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fri_disc_detail" >
                                        <option value="">- Please Select -</option>
                                        <?php foreach ($discount_items as $item) {       
                                    echo '<option value="'.$item['st_id'].'">'.$item['st_name'].' / '.$item['st_arb_name'].'</option>';
                                  } ?>	
                                  </select>
                                  </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="offer_c"  cols="6" rows="4"  name="offer_p" value="Yes">
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_c" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name2" name="offer_name" cols="6" rows="4" placeholder="Offer Name"/><br>
                                       <input type="text" class="form-control" id="offer_name_arabic2" name="offer_name_arabic" cols="6" rows="4" placeholder="Arabic Offer Name "/>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="fri_description" cols="6" rows="4" placeholder="Enter Description"></textarea><br>
                                       <textarea class="form-control" name="fri_arb_description" cols="6" rows="4" placeholder="Arabic Description"></textarea>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="fri_start"/>
                                   </div>
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_end"/>                                      
                                   </div>                                       
                                 </div>
								 
								 	<!------------------------------------- priority start here------------------------->
						
							<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">
                                    <select name="fri_priority"  class="form-control input-lg">
                                      <option value="">- Please Select -</option>
                                        <?php if($priorities) { foreach ($priorities as $prio) { ?>
                                        <option value="<?php echo $prio; ?>"> <?php echo $prio; ?> </option>
                                        <?php } } ?>                      
                                  </select>
                                </div>
                              </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_priority_start"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_priority_end"/>                                      
                                   </div>        
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_f"  cols="6" rows="4"  name="mall" value="Yes">
                                  </div>
                                </div>

                                <!-- <div class="form-group row" id="mall_div5" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name2"  cols="6" rows="4"  name="mall_name">
                                  </div>
                                </div> -->
                                
                                <div class="form-group row" id="mall_div5" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div6" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic2"  cols="6" rows="4"  name="mall_name_arabic">
                                  </div>
                                </div> -->
								 
	                       <!------------------------------------- priority end here------------------------->
							 
							 	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                          </div> <!-- friday_field -->
						</form>
								
              </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->

<!------------------ branch start from here ----------------------->

<div class="modal fade" id="myModalbranch" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
	       	<h2> Branch Name </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                    <div class="modal-body">
                    <form class="custom-validation"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
                            <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>">
                               <div id="add_to_me"> 
                              
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                      <input type="text" name="branch_name" class="form-control" placeholder="Enter Branch Name"/><br>
                                      <input type="text" name="arb_branch_name" class="form-control" placeholder="Arabic Branch Name"/>
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobileno" class="col-sm-4 col-form-label">Authorized No. <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Mobile No" name="brach_atho_no"/ required><br>
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Governorate <span class="mandatory">*</span></label>
                               <div class="col-sm-6">
                                     <select name="state" id="state" class="form-control input-lg" required>
                                     <option value="">- Please Select -</option>
                                <?php
                                foreach($states as $row)
                                {
                                  echo '<option value="'.$row["state_id"].'">'.$row["state_name"].' / '.$row["arb_state_name"].'</option>';
                                }
                                ?>                                   
                                    </select>
                                 </div> 
                             </div>


                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">State <span class="mandatory">*</span></label>                                  
                                  <div class="col-sm-6">
                                        <select name="city" id="city" class="form-control input-lg" required>
                                         <option value="">Select State</option>
                                        </select>  
                                  </div> 
                                </div>
                                

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter location" name="location"/><br>
                                     <input type="text" class="form-control" placeholder="Arabic location" name="arb_branch_location"/>
                                  </div>
                                </div>
 
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Username" name="branch_username"/><br>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                                    <div class="col-sm-6">
				                                <input type="password" id="pass22" class="form-control" placeholder="Password" name="branch_password"/>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Re-Type Password</label>
                                    <div class="col-sm-6">
                                      <input type="password" class="form-control" data-parsley-equalto="#pass22" placeholder="Re-Type Password" name="branch_rep_password"/>
                                  </div>
                                </div>                            
                           </div> <!-- dynamic_field -->


                           <!--<button type="button" id ="add_branch" class="btn btn-success" onclick="addCode()">Add More</button>-->

						                	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
							</form>
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->



  <!------------------ business start from here ----------------------->

<div class="modal fade" id="myModalbusiness" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h2> Home Business</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                    <div class="modal-body">
                    <form class="custom-validation"  method='post' action="CompanyController/update" enctype='multipart/form-data'>
                            <input type="hidden" id="new_id" name="new_id" value="<?php echo $companydetails->id; ?>">
                            <input type="hidden" id="home_business" name="home_business" value="<?php echo 'home_business' ?>">
                               <div id="add_to_me"> 
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Image<span class="mandatory"></span></label>
                                        <div class="col-sm-6">
                                            <input type="file" name="business[]"  class="form-control"  multiple >
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                        <div class="col-sm-6">
                                           <textarea class="form-control" name="b_description" cols="6" rows="4" placeholder="Enter Description"></textarea><br>
                                           <textarea class="form-control" name="b_arb_description" cols="6" rows="4" placeholder="Arabic Description"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Mobile No. <span class="mandatory"></span></label>
                                        <div class="col-sm-6">
                                          <input type="text" name="b_mobile_no"  class="form-control" placeholder="Contact number"/><br>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Whatsapp No.</label>
                                        <div class="col-sm-6">
                                          <input type="text" name="b_whatsapp_no" class="form-control" placeholder="WhatsApp Number"/><br>
                                        </div>
                                    </div>

                                   <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Instagram</label>
                                        <div class="col-sm-6">
                                          <input type="text" name="instagram" class="form-control" placeholder=""/><br>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Email Id <span class="mandatory"></span></label>
                                        <div class="col-sm-6">
                                          <input type="email" name="b_email" class="form-control" placeholder="Enter Email"/><br>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Location</label>
                                        <div class="col-sm-6">
                                         <input type="text" class="form-control" placeholder="Enter location" name="b_location"/><br>
                                         <input type="text" class="form-control" placeholder="Arabic location" name="b_arb_location"/>
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                         <select class="form-control" required name="status"/>
                                        <?php if($companydetails->status == 1){ ?>
                                        <option selected value="1">Active</option>
                                        <option value ="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                        <option selected value ="0">Inactive</option>
                                        <?php } ?>
                                    </select>
                                   </div>
                                 </div>
                                </div> <!-- dynamic_field -->


                           <!--<button type="button" id ="add_branch" class="btn btn-success" onclick="addCode()">Add More</button>-->

                                            <div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->

<!------------------ branch form end here -------------------------->

<!------- for city code -------------->

<script>
function sum() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
            }
        }
</script>

<script>
function sum1() {
            var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt22').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt33').value = result;
            }
        }
</script>

<!------ for famous ------------->

<script>
function famsum() {
            var txtFirstNumberValue = document.getElementById('txt10').value;
            var txtSecondNumberValue = document.getElementById('txt20').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt30').value = result;
            }
        }
</script>

<script>
function famsum1() {
            var txtFirstNumberValue = document.getElementById('txt100').value;
            var txtSecondNumberValue = document.getElementById('txt200').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt300').value = result;
            }
        }
</script>

<!---- for friday ----->

<script>
function frisum() {
            var txtFirstNumberValue = document.getElementById('txt40').value;
            var txtSecondNumberValue = document.getElementById('txt50').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt60').value = result;
            }
        }
</script>

<script>
function frisum1() {
            var txtFirstNumberValue = document.getElementById('txt400').value;
            var txtSecondNumberValue = document.getElementById('txt500').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt600').value = result;
            }
        }
</script>
<!----- for online shop --------------->



<SCRIPT>
function ShowAndHide() {
    var x = document.getElementById('SectionName');
    if (x.style.display == 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
	
	    var x1 = document.getElementById('SectionName1');
    if (x1.style.display == 'none') {
        x1.style.display = 'block';
    } else {
        x1.style.display = 'none';
    }
	
	var x2 = document.getElementById('SectionName2');
    if (x2.style.display == 'none') {
        x2.style.display = 'block';
    } else {
        x2.style.display = 'none';
    }
	
	var x3 = document.getElementById('SectionName3');
    if (x3.style.display == 'none') {
        x3.style.display = 'block';
    } else {
        x3.style.display = 'none';
    }
	

}
</SCRIPT>

<script>
$(document).ready(function(){
	
    $('#state').change(function(){

        var state_id = $('#state').val();
        var action = 'get_city';

        if(state_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/CompanyController/action'); ?>",
                method:"POST",
                data:{state_id:state_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select State</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="' + data[count].city_id + '">' + data[count].city_name + ' / ' + data[count].city_arb_name + '</option>';
                    }

                    $('#city').html(html);
                }
            });
        }
        else
        {
            $('#city').val('');
        }

    });

});

</script>

<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>

<script type="text/javascript">
    $(document).ready(function(){

	      
      var i=1;  

      $('#add_branch').click(function(){  
           i++;  
           $('#add_to_me').append('<div id="row'+i+'" class="dynamic-added"><hr><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Branch</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter Branch" name="branch_name[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Username</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter Username" name="branch_username[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Password</label> <div class="col-sm-6"><input type="password" id="pass1" class="form-control" placeholder="Password" name="branch_password[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Re-Type Password</label><div class="col-sm-6"><input type="password" class="form-control" data-parsley-equalto="#pass1" placeholder="Re-Type Password" name="branch_rep_password[]"/></div></div><div class="form-group row" style="float:right; margin-top:-40px;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });
       
      
      $(document).on('click', '#mall_p', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div1").show();
            $("#mall_div2").show();
            $("#mall_name").attr("required", "required");
            $("#mall_name_arabic").attr("required", "required");
           
            
        }else{
            $("#mall_div1").hide();
            $("#mall_div2").hide();
            $('#mall_name').removeAttr("required","");
            $('#mall_name_arabic').removeAttr("required","");
        }
      });

      $(document).on('click', '#mall_v', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div3").show();
            $("#mall_div4").show();
            $("#mall_name1").attr("required", "required");
            $("#mall_name_arabic1").attr("required", "required");
           
            
        }else{
            $("#mall_div3").hide();
            $("#mall_div4").hide();
            $('#mall_name1').removeAttr("required","");
            $('#mall_name_arabic1').removeAttr("required","");
        }
      });

      $(document).on('click', '#mall_f', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div5").show();
            $("#mall_div6").show();
            $("#mall_name2").attr("required", "required");
            $("#mall_name_arabic2").attr("required", "required");
            
        }else{
            $("#mall_div5").hide();
            $("#mall_div6").hide();
            $('#mall_name2').removeAttr("required","");
            $('#mall_name_arabic2').removeAttr("required","");
        }
      });


      $(document).on('click', '#offer_p', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_p").show();
            $("#discount_item_p").hide();
            $("#offer_name").attr("required", "required");
            $("#offer_name_arabic").attr("required", "required");
        }else{
            $("#offer_ctsmise_p").hide();
            $("#discount_item_p").show();
            $('#offer_name').removeAttr("required","");
            $('#offer_name_arabic').removeAttr("required","");
        }
      });
      $(document).on('click', '#offer_v', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_v").show();
            $("#discount_item_v").hide();
            $("#offer_name1").attr("required", "required");
            $("#offer_name_arabic1").attr("required", "required");
        }else{
            $("#offer_ctsmise_v").hide();
            $("#discount_item_v").show();
            $('#offer_name1').removeAttr("required","");
            $('#offer_name_arabic1').removeAttr("required","");
        }
      });
      $(document).on('click', '#offer_c', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_c").show();
            $("#discount_item_c").hide();
            $("#offer_name2").attr("required", "required");
            $("#offer_name_arabic2").attr("required", "required");
        }else{
            $("#offer_ctsmise_c").hide();
            $("#discount_item_c").show();
            $('#offer_name2').removeAttr("required","");
            $('#offer_name_arabic2').removeAttr("required","");
        }
      });

   });  
</script>


