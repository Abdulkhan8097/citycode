<?php $session = session(); ?>
<style>
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
}.fa {
color:red !important;
}
</style> 

<style>
select {
  width: 400px;
  padding: 8px 16px;
}
select option {
  font-size: 14px;
  padding: 8px 8px 8px 28px;
  position: relative;

}
select option:before {
  content: "";
  position: absolute;
  height: 18px;
  width: 18px;
  top: 0;
  bottom: 0;
  margin: auto;
  left: 0px;
  border: 1px solid #ccc;
  border-radius: 2px;
  z-index: 1;
}
select option:checked:after {
  content: attr(data[count]);
  background: #fff;
  color: black;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 8px 8px 8px 28px;
  border: none;
}
select option:checked:before {
  border-color: blue;
  content: "\2713";
 height:20px;
  background-size: 10px;
  background-repeat: no-repeat;
  background-position: center;
}
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                    <?php echo view('admin/_topmessage'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Edit Product</h4>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="card-title">Arabic</h4>
                            </div>
                        </div><br>

                        <form class="custom-validation"  method='post' action="ProductController/update" enctype='multipart/form-data'>
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="for-mobile-laptop">
                                
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Company Name <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                            <?php if ($session->get('company_id')){ ?>
                                                    <input type="text" class="form-control" name="company_id" 
                                                    value="<?php if (($session->get('company_name')) && $session->get('company_arb_name')) {
                                                                    echo ($session->get('company_name')).' / '. ($session->get('company_arb_name'));
                                                                } else if ($session->get('company_arb_name')){
                                                                    echo ($session->get('company_arb_name'));
                                                                } else{
                                                                    echo ($session->get('company_name'));
                                                                 } ?>" readonly/>
                                                <?php } else { ?>
                                                    
                                                <select name="company_id" class="form-control input-lg" id="state" required>
                                                    <option value="">Please Select</option>                                        
                                                    <?php
                                                    foreach ($companies as $row) {
                                                        if ($row['id'] == $product['company_id']) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                    <?php if (($row["company_name"]) && ($row["company_arb_name"])){ ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'].' / '.$row['company_arb_name'];?></option>
                                                    <?php } else if ($row["company_arb_name"]) { ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_arb_name'];?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'];?></option>                                                    
                                                        <?php } } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Get Offer Details-->
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group row">
                                         <label for="inputPassword" class="col-sm-4 col-form-label">Offer Type<?php echo $product['coupon_type'];?> <span class="mandatory">*</span></label>
                                         <div class="col-sm-6">
                                            <select name="offer_Type" class="form-control input-lg" id="offer_Type" required onClick="">
                                               <option value="">-- Please Select --</option>
                                               <option value="city" 
                                               <?php if($product['coupon_type']=='city')
                                                { echo 'selected';}else {echo "";}?>>Public Offer / العرض العام</option>
                                               <option value="vip" <?php if($product['coupon_type']=='vip')
                                                { echo 'selected';}else {echo "";}?>>V.I.P Offer / عرض V.I.P</option>
                                               <option value="friday" <?php if($product['coupon_type']=='friday')
                                                { echo 'selected';}else {echo "";}?>>Friday Offer / عرض الجمعة</option>
                                            </select>
                                         </div>
                                      </div>
                                   </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Discount Offer (%)<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">                                                
                                                <select name="discount_offer" class="form-control input-lg" id="discount_offer" required>
                                                    <option value="">Please Select</option>   
                                                   
                                                    <?php echo "<option value='".$discount_offer['discount_offer']."' selected>".$discount_offer['discount_offer']."</option> " ;?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--End Offer Details-->

                                <div class="row">
                                    <div class="col-md-6">   
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>                                  
                                            <div class="col-sm-6">
                                <?php if ($session->get('company_id')){ ?>
											
            						<div class="row">
            						   <div class="col-sm-1"> </div>		
            						      <?php $gidz = explode(',', $product['branch_id']); ?>
            						       <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"
            							 <?php if(count($results) == count($gidz)) { echo "checked" ; } ?> > </div>
            						     <div class="col-sm-8 border float-lg-right">Select All</div>
            						  </div>
                                        <?php
                                            $gidz = explode(',', $product['branch_id']);
                                            //echo "<pre>";print_r($results);exit;
                                            foreach ($results as $row) { ?>
                                             <div class="row">
                            				        <div class="col-sm-1"></div>
                                                    <div class="col-sm-2 border float-left">
                                    					<input type="checkbox" class="checkhour" required name="branch_id[]" value="<?php echo $row->branch_id; ?>"<?php if (in_array($row->branch_id, $gidz)) { echo "checked"; } ?>>
                                                    </div>
                                                    <div class="col-sm-8 border float-lg-right"><?php echo $row->branch_name; ?></div>
                                            </div>	 
                                            <?php } } else { ?>
                                                <select name="branch_id[]" id="city" class="form-control input-lg" multiple="multiple" required>
                                                    <option value="">Select Branch</option>
                                                    <?php
                        							$gidz = explode(',', $product['branch_id']);
                        							foreach ($results as $row) { 
                            							if(in_array($row->branch_id, $gidz)){$selected = 'selected="selected"';} 
                                                        else {
                                                            $selected = '';
                                                         }?>
                                                       <option value="<?php echo $row->branch_id?>" <?php echo $selected ?>><?php echo $row->branch_name.'/'.$row->arb_branch_name; ?></option>
                                                   <?php } ?>
                                               </select>  <?php } ?>   
                                            </div> 
                                        </div>
                                    </div>
                                </div>
								
				                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Name <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" required  name="product_name" value="<?php echo $product['product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="arb_product_name" value="<?php echo $product['arb_product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Description <span class="mandatory"></span></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description" cols="6" rows="4" ><?php echo $product['description']; ?></textarea>
                                                
                                            </div></div> </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="arb_description" cols="6" rows="4" ><?php echo $product['arb_description']; ?></textarea>
                                                
                                            </div></div> </div> 
                                </div>
                             
                        <!-- <div class="row">
                           <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Picture List <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                       <?php //if($product_img) { foreach ($product_img as $product1) { ?>
					                        <img src="<?php //echo base_url('product/'.$product1->product_image_name); ?>" height=90 width=90 class="img-fluid"> 
                                            <a href="<?php //echo site_url('Deletepimage?id='.$product1->img_id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                         <?php //} } else { ?> <?php //} ?> <br> <br>
                                            <input type="file"  name="picture[]" accept="image/*" multiple /> 
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                   <div class="row  form-group ">
                               <div class="col-lg-4 ">
                                   <h5 class="text-center headercolor">Product Image 1</h5>
                                 <div class="col-ting">
                                    <div class="control-group file-upload" id="file-upload1">
                                       <div class="image-box text-center">
                                          <!-- <p>Upload Image</p> -->
                                          <img src="<?php echo (isset($product['picture']) && !empty($product['picture'])) ? base_url('product/').'/'.$product['picture'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray;"></img>
                                       </div>
                                       <div class="controls" style="display: none;">
                                          <input type="file" accept="image/*"  name="picture" value="<?php echo (isset($product) && !empty($product)) ? $product['picture'] : ''; ?>"  />
                                       </div>
                                    </div>
                                 </div>

                               </div>
                                    
                                    <div class="col-lg-4 ">
                                        <h5 class="text-center headercolor">Product Image 2</h5>
                                       <div class="col-ting">
                                          <div class="control-group file-upload" id="file-upload1">
                                             <div class="image-box2 text-center">
                                                <!-- <p>Upload Image</p> -->
                                                <img src="<?php echo (isset($product['picture_2']) && !empty($product['picture_2'])) ? base_url('product/').'/'.$product['picture_2'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                             </div>
                                             <div class="controls" style="display: none;">
                                                <input type="file" accept="image/*"  name="picture_2" value="<?php echo (isset($product) && !empty($product)) ? $product['picture_2'] : ''; ?>" >
                                             </div>
                                          </div>
                                       </div>

                                    </div>
                            </div>
                            <div class="row  form-group">
                               <div class="col-lg-4 ">
                                   <h5 class="text-center headercolor">Product Image 3</h5>
                                 <div class="col-ting">
                                    <div class="control-group file-upload" id="file-upload1">
                                       <div class="image-box3 text-center">
                                          <!-- <p>Upload Image</p> -->
                                          <img src="<?php echo (isset($product['picture_3']) && !empty($product['picture_3'])) ? base_url('product/').'/'.$product['picture_3'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                       </div>
                                       <div class="controls" style="display: none;">
                                          <input type="file" accept="image/*"  name="picture_3" value="<?php echo (isset($product) && !empty($product)) ? $product['picture_3'] : ''; ?>">
                                       </div>
                                    </div>
                                 </div>

                               </div>
                                    
                                    <div class="col-lg-4 ">
                                        <h5 class="text-center headercolor">Product Image 4</h5>
                                       <div class="col-ting">
                                          <div class="control-group file-upload" id="file-upload1">
                                             <div class="image-box4 text-center">
                                                <!-- <p>Upload Image</p> -->
                                                <img src="<?php echo (isset($product['picture_4']) && !empty($product['picture_4'])) ? base_url('product/').'/'.$product['picture_4'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                             </div>
                                             <div class="controls" style="display: none;">
                                                <input type="file" accept="image/*"  name="picture_4"  value="<?php echo (isset($product) && !empty($product)) ? $product['picture_4'] : ''; ?>">
                                             </div>
                                          </div>
                                       </div>

                                    </div>
                            </div>
<?php if ($session->get('user_id')){ ?>
              <!--               <div class="row">
                  <div class="col-lg-6 ">
                  <div class="form-group row">
                     <label for="" class="col-sm-4 col-form-label">supplier Vat</label>              
                  &nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="myRadios" id="myRadios" checked='checked' onchange="doalert(this)"> 
                  </div>
               </div>
               </div> -->
           <?php } ?>


                                 <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Original Price <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" id="org_price" value="<?php echo $product['original_price']?>" class="form-control" placeholder="Original Price" name="original_price" onKeyUp="numericFilter(this, sum());" required/>
                                 </div>
                              </div>
                           </div>
                        </div>

<!--                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Discount<span class="mandatory"></span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="discount_per" placeholder="Discount percentage" name="discount_per"  value="<?php echo $product['discount_per'];?>" onKeyUp="numericFilter(this, caldicount());" />
                                            </div>
                                            %
                                        </div>
                                    </div>
                                </div>-->
                             <?php if ($session->get('user_id')){ ?>
                                 <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">After Discount <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" id="after_discount" value="<?php echo $product['after_discount']?>" class="form-control" placeholder="after_discount" name="after_discount" readonly  onKeyUp="numericFilter(this);" required/>
                                 </div>
                              </div>
                           </div>
                        </div>
                              <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">App Service Charge    
</label>
                                 <div class="col-sm-6">
                                    <input type="text" id="commisson"  onKeyUp="numericFilter(this,sum());"  name="service_charge" value="<?php echo $product['service_charge']?>" class="form-control" placeholder="commisson Price"  />
                                 </div>
                              </div>
                           </div>
                         

                        </div>
                           <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Citycode VAT    
</label>
                                 <div class="col-sm-6">
                                    <input type="text" id="cityb"  name="cityb" class="form-control" value="<?php echo $product['citycode_vat']?>" placeholder="Citycode VAT Price" readonly />
                                 </div>
                              </div>
                           </div>
                          <!--  <p>Citycode VAT :- Is the (citycode benefits + App service charge ) 5% = <span id="cityb"></span>          
</p> -->

                        </div>
                            <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Supplier VAT <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Supplier VAT" value="<?php echo $product['supplierVat_charges']?>" name="Supplier" id="Supplier" readonly  onKeyUp="numericFilter(this);" required/>
                                 </div>
                              </div>
                           </div>
                            
                                
                                </div>
                        </div>
                      
                                 <div  >
                              
                                </div>
                                 <div >
                                 <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Delivery Charge </label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Enter Amount" name="d_charges" value="<?php echo $product['delivery_charge']?>" onKeyUp="numericFilter(this, sum());" id="d_charges"/>
                                 </div>
                                 &nbsp;&nbsp;&nbsp;&nbsp;OR
                              </div>

                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control"  placeholder="Set Price per KM(kilometre)" value="<?php echo $product['delivery_km']?>" name="d_km"onKeyUp="numericFilter(this, sum());" id="set_km"/>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <br>
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Discounted Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Price" name="price" id="price" onKeyUp="numericFilter(this);" required readonly value="<?php echo $product['price'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
								
						     <div class="row">
                                <div class="col-md-6">
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Menu List</label>
									
                     <div class="col-sm-6">
                                     <?php if($images) { foreach ($images as $img) { ?>
					  <div class="col-sm-2 mandatory">
					     <img src="<?php echo base_url('product/'.$img->image_name); ?>" height=60 width=60 class="img-fluid" style="margin-top:10px;"> 
						<a href="<?php echo site_url('DeleteProductImage?id='.$img->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
					  </div>
					<?php } } else { ?> <?php } ?>
                                        <input type="file" name="image_name[]" class="form-control" multiple>
                                    </div>
                                </div>
							</div>
						</div>
								

<!--                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" required name="status"/>
<?php if ($product['status'] == 1) { ?>
                                                    <option selected value="1">Active</option>
                                                    <option value ="0">Inactive</option>
<?php } else { ?>
                                                    <option value="1">Active</option>
                                                    <option selected value ="0">Inactive</option>
<?php } ?>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> -->
                            </div>

                            <div class="form-group row mb-0">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Update
                                    </button>
                                    <a class="btn btn-secondary waves-effect waves-light" onclick="history.back()">
                                        <i class="ion ion ion-md-arrow-back"></i> Back
                                    </a>
                                </div>
                            </div>
                    </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->    
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


<script>
   $(document).ready(function () {
       $('#state1').change(function () {
           var company_id = $('#state').val();
           var action = 'get_city';
           if (company_id != '')
           {
               $.ajax({
                   url: "<?php echo base_url('/index.php/ProductController/action'); ?>",
                   method: "POST",
                   data: {company_id: company_id, action: action},
                   dataType: "JSON",
                   success: function (data)
                   {
                       var html = '<option> Select All </option>';
   
                       for (var count = 0; count < data.length; count++)
                       {
                           html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + ' / ' + data[count].arb_branch_name + '</option>';
                       }
                       $('#city').html(html);
                   }
               });
           } else
           {
               $('#city').val('');
           }
       });

       $('#state').change(function () {
           var company_id = $('#state').val();
           if (company_id != '')
           {
              $('#city').val('');
              //$('.checkhour').prop('checked', $(this).prop("checked"));
           }
       });

       $('#offer_Type').change(function () {
           var company_id = $('#state').val();
           var offer_Type = $('#offer_Type').val();
           var action = 'get_Offer';
           //alert(offer_Type);
           if (company_id != '')
           {
            //alert(company_id);
               $.ajax({
                   url: "<?php echo base_url('/index.php/ProductController/getDiscount'); ?>",
                   method: "POST",
                   data: {company_id: company_id, action: action, offer_Type: offer_Type},
                   dataType: "JSON",
                   success: function (data)
                   {
                     //console.log('Success: '+ data[0]);
                     //alert(data.length);
                       var html = '<option> Select All </option>';
   
                       for (var count = 0; count < data.length; count++)
                       {
                           html += '<option value="' + data[count].customer_discount + '">' + data[count].customer_discount + '</option>';
                       }
                       $('#discount_offer').html(html);

                   }
               });
           } else
           {
               $('#discount_offer').val('');
           }
       });

       //---------------Get Branch
       $('#discount_offer').change(function () {
           var company_id = $('#state').val();
           var offer_Type = $('#offer_Type').val();
           var action = 'get_city';
           if (company_id != '')
           {
               $.ajax({
                   url: "<?php echo base_url('/index.php/ProductController/action'); ?>",
                   method: "POST",
                   data: {company_id: company_id, action: action, offer_Type: offer_Type},
                   dataType: "JSON",
                   success: function (data)
                   {
                       var html = '<option> Select All </option>';
   
                       for (var count = 0; count < data.length; count++)
                       {
                           html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + ' / ' + data[count].arb_branch_name + '</option>';
                       }
                       $('#city').html(html);
                         for (var count = 0; count < data.length; count++)
                       {
                        $r='<option value="' + data[count].comission + '">' + data[count].comission + '</option>';
                       }
                       $('#cc').html($r);
                   }
               });
           } else
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
<script>
   $('option').mousedown(function(e) {
       e.preventDefault();
       var originalScrollTop = $(this).parent().scrollTop();
       console.log(originalScrollTop);
       $(this).prop('selected', $(this).prop('selected') ? false : true);
       var self = this;
       $(this).parent().focus();
       setTimeout(function() {
           $(self).parent().scrollTop(originalScrollTop);
       }, 0);
       //alert(originalScrollTop);
       return false;
   });
</script>
<script>
   $(function() {
     var filter = $('#city');
     filter.on('change', function() {
       if (this.selectedIndex) return; //not `Select All`
       filter.find('option:gt(0)').prop('selected', true);
       filter.find('option').eq(0).prop('selected', false);
     });
   });
</script>
<!-- <script type="text/javascript">
   function sum() {
       var final_org_amount = 0;
       var txtFirstNumberValue = document.getElementById('org_price').value||0;
   
       var txtSecondNumberValue = $('#discount_offer').val()||0;
       var result = parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
       final_org_amount =parseFloat(txtFirstNumberValue)-parseFloat(result);
       //alert(final_org_amount);
       if (!isNaN(final_org_amount)) {
           document.getElementById('price').value = final_org_amount.toFixed(3);
       }
   }
   
   $('#discount_offer').change(function() {
      var txtSecondNumberValue = $(this).val()||0;
     var txtFirstNumberValue = document.getElementById('org_price').value||0;
     var result = parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
     final_org_amount =parseFloat(txtFirstNumberValue)-parseFloat(result);
     if (!isNaN(final_org_amount)) {
            document.getElementById('price').value = final_org_amount.toFixed(3);
        }
      //alert(orgamt);
    });
   
   $('#org_price').change(function() {
     var orgamt = $(this).val()||0;
    document.getElementById('org_price').value = parseFloat(orgamt).toFixed(3);
     //alert(orgamt);
   });
   
   
</script> -->

<script type="text/javascript">
  function sum() {
       var final_org_amount = 0;
       var txtFirstNumberValue = document.getElementById('org_price').value||0;
       var d_charges = document.getElementById('d_charges').value||0;
       var set_km = document.getElementById('set_km').value||0;
        if($("input:checkbox[name='myRadios']").is(":checked")) {
     var txtcommisionValue = $('#commisson').val()||0;
      var percentToGet = 5;
    
       var cc = $('#cc').val()||0;
     

   
       var txtSecondNumberValue = $('#discount_offer').val()||0;
       // var txtFirstNumberValue = parseFloat(txtFirstNumberValue)+parseFloat(txtcommisionValue);

       var result = parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
       var final_org_amount =parseFloat(txtFirstNumberValue)-parseFloat(result);
         var final_org_amount = parseFloat(final_org_amount)+parseFloat(txtcommisionValue);

       if(txtcommisionValue == 0 || txtcommisionValue !== ''){
         var test = parseFloat(cc)+parseFloat(txtcommisionValue);
         if(cc==0){
           var test1=(percentToGet / 100) *parseFloat(test);
         }else{
            var test1=parseFloat(test)*parseFloat(cc)/100;
         }
       }
       document.getElementById('cityb').value = test1.toFixed(3);
         var cityVate = $('#cityb').val();
       var re_discount=parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
       var final_discount_amount=parseFloat(txtFirstNumberValue)-parseFloat(re_discount);
      
         var supplier_vat=(percentToGet / 100) *parseFloat(final_discount_amount);
    
       var final_org_amount=parseFloat(final_org_amount)+parseFloat(supplier_vat)+parseFloat(d_charges)+parseFloat(set_km)+parseFloat(cityVate);


       // var supplier=parseFloat(price)/100;



       //alert(final_org_amount);
       if (!isNaN(final_org_amount)) {
          
           document.getElementById('price').value = final_org_amount.toFixed(3);
           document.getElementById('after_discount').value = final_discount_amount.toFixed(3);
           document.getElementById('Supplier').value = supplier_vat.toFixed(3);

           // document.getElementById('cityb').textContent = test1.toFixed(3);
          
           document.getElementById('Supplier').textContent = supplier.toFixed(3);
       }
  }else{    
  

       var txtcommisionValue = $('#commisson').val()||0;
      var percentToGet = 5;
    
       var cc = $('#cc').val()||0;
     

   
       var txtSecondNumberValue = $('#discount_offer').val()||0;
       // var txtFirstNumberValue = parseFloat(txtFirstNumberValue)+parseFloat(txtcommisionValue);

       var result = parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
       var final_org_amount =parseFloat(txtFirstNumberValue)-parseFloat(result);
         var final_org_amount = parseFloat(final_org_amount)+parseFloat(txtcommisionValue);

       if(txtcommisionValue == 0 || txtcommisionValue !== ''){
         var test = parseFloat(cc)+parseFloat(txtcommisionValue);
         if(cc==0){
           var test1=(percentToGet / 100) *parseFloat(test);
         }else{
            var test1=parseFloat(test)*parseFloat(cc)/100;
         }
       }
       document.getElementById('cityb').value = test1.toFixed(3);
         var cityVate = $('#cityb').val();
       var re_discount=parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
       var final_discount_amount=parseFloat(txtFirstNumberValue)-parseFloat(re_discount);
      
         var supplier_vat='0';
    
       var final_org_amount=parseFloat(final_org_amount)+parseFloat(supplier_vat)+parseFloat(d_charges)+parseFloat(set_km)+parseFloat(cityVate);


       // var supplier=parseFloat(price)/100;



       //alert(final_org_amount);
       if (!isNaN(final_org_amount)) {
          
           document.getElementById('price').value = final_org_amount.toFixed(3);
           document.getElementById('after_discount').value = final_discount_amount.toFixed(3);
           document.getElementById('Supplier').value = supplier_vat.toFixed(3);

           // document.getElementById('cityb').textContent = test1.toFixed(3);
          
           document.getElementById('Supplier').textContent = supplier.toFixed(3);
       }
   }
}


   
   // $('#discount_offer').change(function() {
   //    var txtSecondNumberValue = $(this).val()||0;
   //   var txtFirstNumberValue = document.getElementById('org_price').value||0;
   //   var result = parseFloat(txtFirstNumberValue)*parseFloat(txtSecondNumberValue)/100;
   //   final_org_amount =parseFloat(txtFirstNumberValue)-parseFloat(result);
   //   if (!isNaN(final_org_amount)) {
   //          document.getElementById('price').value = final_org_amount.toFixed(3);
   //      }
   //    //alert(orgamt);
   //  });
   
 $('#org_price').change(function() {
     var orgamt = $(this).val()||0;
    document.getElementById('org_price').value = parseFloat(orgamt).toFixed(3);
     //alert(orgamt);
   });
   $('#commisson').change(function() {
     var commisson = $(this).val()||0;
    document.getElementById('commisson').value = parseFloat(commisson).toFixed(3);
     //alert(orgamt);
   });
    $('#cityb').change(function() {
     var cityb = $(this).val()||0;
    document.getElementById('cityb').value = parseFloat(cityb).toFixed(3);
     //alert(orgamt);
   });
       $('#d_charges').change(function() {
     var d_charges = $(this).val()||0;
    document.getElementById('d_charges').value = parseFloat(d_charges).toFixed(3);
     //alert(orgamt);
   });
        $('#set_km').change(function() {
     var set_km = $(this).val()||0;
    document.getElementById('set_km').value = parseFloat(set_km).toFixed(3);
     //alert(orgamt);
   });


   
   
</script>
<script>
   $("#checkall").change(function () {
       $('.checkhour').prop('checked', $(this).prop("checked"));
   });


</script>
<script type="text/javascript">
    function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    else document.getElementById('ifYes').style.display = 'none';

}
</script>
<script type="text/javascript">
    function yesnoCheck1() {
    if (document.getElementById('yesCheck1').checked) {
        document.getElementById('ifYes1').style.display = 'block';
    }
    else document.getElementById('ifYes1').style.display = 'none';

}
</script>
<script type="text/javascript">
    function yesnoCheck2() {
    if (document.getElementById('yesCheck2').checked) {
        document.getElementById('ifYes2').style.display = 'block';
    }
    else document.getElementById('ifYes2').style.display = 'none';

}
</script>


<script type="text/javascript">
function doalert(checkboxElem) {
  if (checkboxElem.checked) {

  } else {
  
    var myinput = document.getElementById('org_price');
   var final_org_amount=document.getElementById('price');
       var after_discount  = document.getElementById('after_discount');


        var cityb =document.getElementById('cityb');
 var txtcommisionValue = document.getElementById('commisson');
var txtSecondNumberValue = document.getElementById('discount_offer');
  var d_charges = document.getElementById('d_charges');
       var set_km = document.getElementById('set_km');
     var  sup=document.getElementById('Supplier');


     myinput.value = myinput.defaultValue;
    final_org_amount.value = final_org_amount.defaultValue;
    after_discount.value = after_discount.defaultValue;
    cityb.value = cityb.defaultValue;
    txtcommisionValue.value = txtcommisionValue.defaultValue;
    txtSecondNumberValue.value = txtSecondNumberValue.defaultValue;
    d_charges.value = d_charges.defaultValue;
    set_km.value = set_km.defaultValue;
    sup.value = sup.defaultValue;

}
}
</script>

<script type="text/javascript">
   
   $(".image-box").click(function(event) {
   var previewImg = $(this).children("img");
   
   $(this)
       .siblings()
       .children("input")
       .trigger("click");
   
   $(this)
       .siblings()
       .children("input")
       .change(function() {
           var reader = new FileReader();
   
           reader.onload = function(e) {
               var urll = e.target.result;
               $(previewImg).attr("src", urll);
               previewImg.parent().css("background", "transparent");
               previewImg.show();
               previewImg.siblings("p").hide();
           };
           reader.readAsDataURL(this.files[0]);
       });
   });
   
</script>
<script type="text/javascript">
   
   $(".image-box2").click(function(event) {
   var previewImg = $(this).children("img");
   
   $(this)
       .siblings()
       .children("input")
       .trigger("click");
   
   $(this)
       .siblings()
       .children("input")
       .change(function() {
           var reader = new FileReader();
   
           reader.onload = function(e) {
               var urll = e.target.result;
               $(previewImg).attr("src", urll);
               previewImg.parent().css("background", "transparent");
               previewImg.show();
               previewImg.siblings("p").hide();
           };
           reader.readAsDataURL(this.files[0]);
       });
   });
   
</script>
<script type="text/javascript">
   
   $(".image-box3").click(function(event) {
   var previewImg = $(this).children("img");
   
   $(this)
       .siblings()
       .children("input")
       .trigger("click");
   
   $(this)
       .siblings()
       .children("input")
       .change(function() {
           var reader = new FileReader();
   
           reader.onload = function(e) {
               var urll = e.target.result;
               $(previewImg).attr("src", urll);
               previewImg.parent().css("background", "transparent");
               previewImg.show();
               previewImg.siblings("p").hide();
           };
           reader.readAsDataURL(this.files[0]);
       });
   });
   
</script>
<script type="text/javascript">
   
   $(".image-box4").click(function(event) {
   var previewImg = $(this).children("img");
   
   $(this)
       .siblings()
       .children("input")
       .trigger("click");
   
   $(this)
       .siblings()
       .children("input")
       .change(function() {
           var reader = new FileReader();
   
           reader.onload = function(e) {
               var urll = e.target.result;
               $(previewImg).attr("src", urll);
               previewImg.parent().css("background", "transparent");
               previewImg.show();
               previewImg.siblings("p").hide();
           };
           reader.readAsDataURL(this.files[0]);
       });
   });
   
</script>
