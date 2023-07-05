<style>
/*
.for-mobile-laptop {
  margin: 0 100px;
}

@media only screen and (max-width: 600px) {
  .for-mobile-laptop {
     margin: 0;

  }
}*/


/*label {
    float: left
}
span {
    display: block;
    overflow: hidden;
    padding: 0 4px 0 6px
}*/
/*input {
    width: 100%
}

.mandatory {
display:inline;
color:red;
}*/

.btn-primary{
color:#000 !important;
}

.percent{
display:inline !important;
}
</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Add New Company</h4>
							   <?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="CompanyController/add_company" enctype='multipart/form-data'>

                          <div class="for-mobile-laptop">

                      <div class="row">
                        <div class="col-md-6">
						              <div class="form-group row">
                             <label for="inputPassword" class="col-sm-4 col-form-label">Category<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                 <select class="form-control" name="category" required>
                                  <?php  
                                    foreach ($categories as $catg) { ?>
                                    <option value="<?php echo $catg['cat_id']?>"> <?php echo $catg['cat_name'].' / '.$catg['cat_arbname'];?> </option>
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
                                     <input type="text" class="form-control" required placeholder="Enter name" name="company_name"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic Company name" name="company_arb_name"/>
                                  </div>
                                </div>
                              </div>
                            </div>

				                    <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">CR Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" required placeholder="Enter CR Number" name="cr_number"/>
                                  </div>
                                </div>

                            <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter Username" name="username"/>
                                  </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Arabic Username" name="arb_username"/>
                                  </div>
                                </div>
                              </div>
                            </div>			

                               <div class="form-group row">                                               
                                    <label for="inputPassword" class="col-sm-2 col-form-label">EMail Id<span class="mandatory">*</span></label>
                                     <div class="col-sm-7">
                                        <input type="email" class="form-control" required
                                                parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail"/>
                                    </div>
                                    <div class="text-danger" id="email-exist-error-msg">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
									                    <input type="password" id="pass2" class="form-control" required placeholder="Password" name="password"/>
                                  </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Re-Type Password<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                      <input type="password" class="form-control" required data-parsley-equalto="#pass2" placeholder="Re-Type Password" name="rep_password"/>
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Authorized Contact<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                    <input type="text" class="form-control" required placeholder="Enter authorized contact" name="auth_contact"/>
                                 </div>
                               </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Mobile Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" required placeholder="Enter mobile Number" name="mobile"/>
                                  </div>
                                </div>

                            <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Location<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter location" name="c_location"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic location" name="arb_location"/>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <label for="inputPassword" class="col-sm-4 col-form-label">Display Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter display name" name="display_name" required/>
                                  </div>
                                </div>
                              </div>
                                    
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Arabic display name" name="display_arb_name"/>
                                  </div>
                                </div>
                              </div>
                          </div>

                        <div class="row">
                          <div class="col-md-6">								  
			                        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control"  placeholder="Enter Address" name="address"/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">								  
			                          <div class="form-group row"> 
                                  <div class="col-sm-6">
                                     <input type="text" class="form-control"  placeholder="Arabic Address" name="arb_address"/>
                                  </div>
                                </div>
                              </div>
                            </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Profile Picture</label>
                                   
                                    <div class="col-sm-6">
                                        <input type="file" name="picture" /> 
                                    </div>
                                </div>																

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Views</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="views"/>
                                  </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Website</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="website"/>
                                  </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Instagram</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="instagram"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="twitter"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="facebook"/>
                                  </div>
                                </div>


                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Snapchat</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="snapchat"/>
                                  </div>
                                </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">WhatsApp</label>
                                    <div class="col-sm-7">
                                     <input type="text" class="form-control" name="whatsapp"/>
                                  </div>
                                </div>
								
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-7">
                                      <select class="form-control" name="status">
                                        <option value="1"> Active </option>
                                        <option value="0"> Inactive </option>
                                      </select> 
                                   </div>
                                 </div>
								
				                      <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Company Banners</label>
                                    <div class="col-sm-7">
                                     <input type="file" name="banner[]" class="form-control"  multiple>
                                  </div>
                                </div>
								
				                      <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Company Douments</label>
                                    <div class="col-sm-7">
                                     <input type="file" name="doc[]" class="form-control"  multiple>
                                  </div>
                                </div>	


					
 

 <div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>

                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div>

 <!--<div class="form-group row">
        <label for="inputPassword" class="col-sm-3 col-form-label"> 
       <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalbranch">Create Branch</button>
      </label>
</div>   
                           

<div class="form-group row">			
        <label for="inputPassword" class="col-sm-3 col-form-label">
          <button ONCLICK="ShowAndHide()" type="button" class="btn btn-primary btn-lg">Discount Type</button>
      </label>
</div>-->
				     <div class="col-sm-12">
								<div class="form-group row" ID="SectionName" STYLE="display:none">
                    <label for="inputPassword" class="col-sm-3 col-form-label"> 
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">City Code Offer</button></label>
                </div>
								
									<div class="form-group row" ID="SectionName1" STYLE="display:none">
                                    <label for="inputPassword" class="col-sm-3 col-form-label"> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalfamous">V.I.P Code Offer</button></label>
                  </div>

								<div class="form-group row" ID="SectionName2" STYLE="display:none">
                                    <label for="inputPassword" class="col-sm-3 col-form-label"> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalfriday">Friday Offer</button></label>

                </div>

                <div class="form-group row" ID="SectionName3" STYLE="display:none">
                      <label for="inputPassword" class="col-sm-3 col-form-label"> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalshop">Online Shop Offer</button></label>
                </div>

			</div> <br /> <br />


<!-------------- branch form start here ------------------------>

<div class="modal fade" id="myModalbranch" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> Branch Name </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                            <div class="modal-body">
                               <div id="famous_field"> 

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Branch" name="branch_name[]"/>
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Governorate</label>
                               <div class="col-sm-6">
                                     <select name="state[]" id="state" class="form-control input-lg" >
                                     <option value="">- Please Select -</option>
                                <?php
                                foreach($states as $row)
                                {
                                  echo '<option value="'.$row["state_id"].'">'.$row["state_name"].'</option>';
                                }
                                ?>                                    

                                    </select>
                                 </div> 
                             </div>


                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">State</label>                                  
                                  <div class="col-sm-6">
                                        <select name="village[]" id="city" class="form-control input-lg">
                                         <option value="">Select State</option>
                                        </select>  
                                  </div> 
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter location" name="location[]"/>
                                  </div>
                                </div>
 
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Username" name="branch_username[]"/>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                                    <div class="col-sm-6">
				                                <input type="password" id="pass22" class="form-control" placeholder="Password" name="branch_password[]"/>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Re-Type Password</label>
                                    <div class="col-sm-6">
                                      <input type="password" class="form-control" data-parsley-equalto="#pass22" placeholder="Re-Type Password" name="branch_rep_password[]"/>
                                  </div>
                                </div>									
                           </div> <!-- dynamic_field -->


                           <!--<button type="button" id ="add_branch" class="btn btn-success" onclick="addCode()">Add More</button>-->
                             <button type="button" name="famous_add" id="famous_add" class="btn btn-success">Add More</button>

						                	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->
		
								
<!------------------------------------------------------------------- city code ----------------------------------------------------------->
								
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> City code </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                            <div class="modal-body">
                               <div id="city_field"> 

                              <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Branch" name="c_branch"/>
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

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="c_disc_detail" >
                                        <option value="">- Please Select -</option>
                                        <option value="Buy 1 Get 1">Buy 1 Get 1</option>
                                        <option value="All Items">All Items</option>
                                        <option value="Selected Items">Selected Items</option>  	
                                  </select>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="c_description" cols="6" rows="4" placeholder="Enter Description"></textarea>
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
                           </div> <!-- dynamic_field -->
						   	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
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
			<div id="famous_field">

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Branch" name="fam_branch"/>
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

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fam_disc_detail" >
                                        <option value="">- Please Select -</option>
                                        <option value="Buy 1 Get 1">Buy 1 Get 1</option>
                                        <option value="All Items">All Items</option>
                                        <option value="Selected Items">Selected Items</option>  	
                                  </select>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="fam_description" cols="6" rows="4" placeholder="Enter Description"></textarea>
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
                             </div> <!-- famous_field -->
							 
								<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
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
			 <div id="friday_field">

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch</label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Branch" name="fri_branch"/>
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

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fri_disc_detail" >
                                        <option value="">- Please Select -</option>
                                        <option value="Buy 1 Get 1">Buy 1 Get 1</option>
                                        <option value="All Items">All Items</option>
                                        <option value="Selected Items">Selected Items</option>  	
                                  </select>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="fri_description" cols="6" rows="4" placeholder="Enter Description"></textarea>
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
                          </div> <!-- friday_field -->
						  
						  	<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                            </div>
								
              </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->
  
<!------------------------------------ online shop -------------------------------------------------->
						 
   <div class="modal fade" id="myModalshop" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h2> Online Shop </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                            <div class="modal-body">

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                     <textarea class="form-control" name="shop_description" cols="6" rows="4" placeholder="Enter Description"></textarea>
                                  </div>
                                </div>

				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Start Date / Time </label>
                                    <div class="col-sm-6">
                                     <input type="date" class="form-control" name="shop_start"/>
                                  </div>
                                </div>


				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> End Date / Time </label>
                                    <div class="col-sm-6">
                                     <input type="date" class="form-control" name="shop_end"/>
                                  </div>
                                </div>


								
				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Online Link </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Online Link" name="online_link"/>
                                  </div>
                                </div>

				<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Play Store Link </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Play Store Link" name="playstore_link" />
                                  </div>
                                </div>


                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> IOS Store Link </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter IOS Store Link" name="ios_link"/>
                                  </div>
                                </div>

                              <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Huawei Link </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Huawei Link" name="huawai_link"/>
                                  </div>
                                </div>
								
							<div class="form-group row mb-0" style="margin-top:50px;">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                         
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
  </div><!-- modal fade -->
                     
<!----------------------------------------------- Online shop end here ------------------------------------>                               
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->    
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->



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
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
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

<!--------------- for branch form -------------------------->



<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>


<script type="text/javascript">
    $(document).ready(function(){
	
	    $(document).on('change','#branchstate',function(){
        var state_id = $('#branchstate').val();
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
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
                    }
                    $('#branchcity').html(html);
                }
            });
        }
        else
        {
            $('#branchcity').val('');
        }

    });
	      
      var i=1;  

      $('#famous_add').click(function(){  
           i++;  
           $('#famous_field').append('<div id="row'+i+'" class="dynamic-added"><hr><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Branch</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter Branch" name="branch_name[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Governorate</label><div class="col-sm-6"><select name="state" id="branchstate" class="form-control input-lg"><option value="">- Please Select -</option><?php foreach($states as $row){ echo '<option value="'.$row["state_id"].'">'.$row["state_name"].'</option>';}?></select></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">State</label><div class="col-sm-6"><select name="village" id="branchcity" class="form-control input-lg"><option value="">Select State</option></select></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="location[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Username</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter Username" name="branch_username[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Password</label> <div class="col-sm-6"><input type="password" id="pass1" class="form-control" placeholder="Password" name="branch_password[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-4 col-form-label">Re-Type Password</label><div class="col-sm-6"><input type="password" class="form-control" data-parsley-equalto="#pass1" placeholder="Re-Type Password" name="branch_rep_password[]"/></div></div><div class="form-group row" style="float:right; margin-top:-40px;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>'); 
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
   });  
</script>


