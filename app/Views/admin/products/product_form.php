<?php $session = session(); ?>
<style>
   @media only screen and (max-width: 600px) {
   .for-mobile-laptop {
   margin: 0;
   }
   }
   .mandatory {
   display:inline;
   color:red;
   }
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
                  <div class="row">
                     <div class="col-sm-6">
                        <h4 class="card-title">Add New Product</h4>
                     </div>
                     <div class="col-sm-6">
                        <h4 class="card-title">Arebic</h4>
                     </div>
                  </div>
                  <form class="custom-validation"  method='post' action="ProductController/add_new_product" enctype='multipart/form-data' name="ProductForm">
                     <div class="for-mobile-laptop">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Company Name <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                   <?php if ($session->get('company_id')){ ?>
                                   

                                           <select name="company_id" class="form-control input-lg" id="state" required>
                                      <!--  <option value="">-- Please Select --</option> -->
                                        <option value="<?php echo ($session->get('company_id'))?>"><?php echo $session->get('company_name') ?></option>
                                       
                                    </select>
                                    <?php }  else { ?>
                                    <select name="company_id" class="form-control input-lg" id="state" required>
                                       <option value="">-- Please Select --</option>
                                       <?php
                                          foreach ($companies as $company) {
                                              if (($company["company_name"]) && ($company["company_arb_name"])){
                                                    echo '<option value="' . $company["id"] . '">' . $company["company_name"].' / '.$company["company_arb_name"]. '</option>';
                                                }
                                                else if($company["company_arb_name"]){
                                                   echo '<option value="' . $company["id"] . '">' .$company["company_arb_name"]. '</option>';
                                                }
                                                else{
                                                    echo '<option value="' . $company["id"] . '">' .$company["company_name"]. '</option>';  
                                                }
                                             }
                                          }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Get Offer Details-->
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Offer Type <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <select name="offer_Type" class="form-control input-lg" id="offer_Type" required onClick="">
                                       <option value="">-- Please Select --</option>
                                       <option value="city">Public Offer / العرض العام</option>
                                       <option value="vip">V.I.P Offer / عرض V.I.P</option>
                                       <option value="friday">Friday Offer / عرض الجمعة</option>
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
                                       <option value="">-- Please Select --</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--End Offer Details-->
                      <!--    <div class="row">
                              <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" name="cityCode_benefits" class="col-sm-4 col-form-label">City Code Benefits<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <select name="cc" class="form-control input-lg" id="cc" >
                                       
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div> -->


                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>                                  
                                 <div class="col-sm-6">
                                    <?php if($session->get('company_id')){?>
                                    <div class="row">
                                       <div class="col-sm-1"></div>
                                       <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
                                       <div class="col-sm-8  border float-lg-right">Select all</div>
                                    </div>
                                    <?php  foreach ($results as $row) { ?>
                                    <div class="row">
                                       <div class="col-sm-1"></div>
                                       <div class="col-sm-2 border float-left"><input type="checkbox"  name="branch_id[]" class="checkhour" value="<?php echo $row->branch_id; ?>" ></div>
                                       <div class="col-sm-8 border float-lg-right"><?php echo $row->branch_name; ?></div>
                                    </div>
                                    <?php } } else { ?>
                                    <select name="branch_id[]" id="city" class="form-control input-lg" multiple="multiple" >
                                       <option value="">Select Branch</option>
                                    </select>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>



         
                        
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Product Name <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Product Name" name="product_name" required/>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="arb_product_name"/>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Product Description <span class="mandatory"></span></label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" name="description" cols="6" rows="4" ></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <textarea class="form-control" name="arb_description" cols="6" rows="4"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                      <!--   <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Picture <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="file" name="picture[]" accept="image/*" required class="form-control" multiple>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Picture <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="file" name="picture[]" accept="image/*" required class="form-control" multiple>
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
                                          <img src="<?php echo (isset($edit['picture']) && !empty($edit['picture'])) ? base_url(PUBLIC_FOLDER .'uploads').'/'.$edit['picture'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray;"></img>
                                       </div>
                                       <div class="controls" style="display: none;">
                                          <input type="file" accept="image/*"  name="picture" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['picture'] : ''; ?>"  />
                                       </div>
                                    </div>
                                 </div>

                               </div>
                                    
                                    <div class="col-lg-4 ">
                                        <h5 class="text-center headercolor">Product Image 2</h5>
                                       <div class="col-ting">
                                          <div class="control-group file-upload" id="file-upload1">
                                             <div class="image-box text-center">
                                                <!-- <p>Upload Image</p> -->
                                                <img src="<?php echo (isset($edit['picture_2']) && !empty($edit['picture_2'])) ? base_url(PUBLIC_FOLDER .'uploads').'/'.$edit['picture_2'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                             </div>
                                             <div class="controls" style="display: none;">
                                                <input type="file" accept="image/*"  name="picture_2" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['picture_2'] : ''; ?>" >
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
                                       <div class="image-box text-center">
                                          <!-- <p>Upload Image</p> -->
                                          <img src="<?php echo (isset($edit['picture_3']) && !empty($edit['picture_3'])) ? base_url(PUBLIC_FOLDER .'uploads').'/'.$edit['picture_3'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                       </div>
                                       <div class="controls" style="display: none;">
                                          <input type="file" accept="image/*"  name="picture_3" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['picture_3'] : ''; ?>">
                                       </div>
                                    </div>
                                 </div>

                               </div>
                                    
                                    <div class="col-lg-4 ">
                                        <h5 class="text-center headercolor">Product Image 4</h5>
                                       <div class="col-ting">
                                          <div class="control-group file-upload" id="file-upload1">
                                             <div class="image-box text-center">
                                                <!-- <p>Upload Image</p> -->
                                                <img src="<?php echo (isset($edit['picture_4']) && !empty($edit['picture_4'])) ? base_url(PUBLIC_FOLDER .'uploads').'/'.$edit['picture_4'] : base_url('/admin/b_img/blank_user.png'); ?>" id="display_image_here" style="height: 100px; width: 100px; border: 2px solid gray; ">
                                             </div>
                                             <div class="controls" style="display: none;">
                                                <input type="file" accept="image/*"  name="picture_4"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['picture_4'] : ''; ?>">
                                             </div>
                                          </div>
                                       </div>

                                    </div>
                            </div>
<!-- checked='checked' -->
                   <div class="row">
                  <div class="col-lg-6 ">
                  <div class="form-group row">
                     <label for="" class="col-sm-4 col-form-label">supplier Vat</label>              
                   <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yes <input type="radio" name="myRadios"   >  -->&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="myRadios" id="myRadios" checked='checked' onchange="doalert(this)"> 
                  </div>
               </div>
               </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Original Price <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" id="org_price" value="0" class="form-control" placeholder="Original Price" name="original_price" onKeyUp="numericFilter(this, sum());" required/>
                                 </div>
                              </div>
                           </div>
                        </div>
<!--                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Discount (%)<span class="mandatory"></span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" id="discount_per" placeholder="Discount percentage" value="0" name="discount_per" onKeyUp="numericFilter(this, sum());" />
                                 </div>
                              </div>
                           </div>
                        </div>-->
                        
<!--                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Discount (%)<span class="mandatory"></span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" id="discount_per" placeholder="Discount percentage" value="0" name="discount_per" onKeyUp="numericFilter(this, sum());" />
                                 </div>
                              </div>
                           </div>
                        </div>-->
                      
                        <?php if($session->get('user_id')){  ?>
                           <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">After Discount <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" id="after_discount" value="0" class="form-control" placeholder="after_discount" name="after_discount" readonly  onKeyUp="numericFilter(this);" required/>
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
                                    <input type="text" id="commisson"  onKeyUp="numericFilter(this,sum());"  name="service_charge" value="0" class="form-control" placeholder="commisson Price"  />
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
                                    <input type="text" id="cityb"  name="cityb" class="form-control" value="0" placeholder="Citycode VAT Price" readonly />
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
                                    <input type="text" class="form-control" placeholder="Supplier VAT" name="Supplier" id="Supplier" readonly  onKeyUp="numericFilter(this);" required/>
                                 </div>
                              </div>
                           </div>
                            
                                
                                </div>
                        </div>
                        <div class="row  form-group">
                                <div class="col-lg-5 ">
                                    <label>Online Payment <span style="visibility:hidden">spacing row</span></label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yes <input type="radio" onclick="javascript:yesnoCheck();"  name="yesno" id="yesCheck"> &nbsp;&nbsp;&nbsp;
                                        No <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" checked='checked'> 

                                    </div>
                                </div>
                                 <div id="ifYes" style="display:none">
                                 <div class="row  form-group">
                                <div class="col-lg-5 ">
                                    <label>Delivery Charge <span style="visibility:hidden">spacing row</span></label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        Yes <input type="radio" onclick="javascript:yesnoCheck1();"  name="yesno" id="yesCheck1">
                                         &nbsp;&nbsp;&nbsp;
                                        No <input type="radio" onclick="javascript:yesnoCheck1();" name="yesno" id="noCheck" checked='checked'> 

                                    </div>
                                </div>
                                </div>
                                 <div id="ifYes1" style="display:none">
                                 <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Enter Amount </label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Enter Amount" name="d_charges"  onKeyUp="numericFilter(this, sum());" id="d_charges"/>
                                 </div>
                                 &nbsp;&nbsp;&nbsp;&nbsp;OR
                              </div>

                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control"  placeholder="Set Price per KM(kilometre)"  name="d_km"onKeyUp="numericFilter(this, sum());" id="set_km"/>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <br>
                   

                           </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Discount Price <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Price" name="price" id="price" readonly  onKeyUp="numericFilter(this);" required/>
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
                                       <select class="form-control" name="status">
                                           <option value="1"> Active </option>
                                           <option value="0"> Inactive </option>
                                       </select> 
                                   </div>
                               </div>
                           </div>
                           </div>-->
                        <div class="form-group row mb-0">
                           <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-6">
                              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                              Submit
                              </button>
                              <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Products'); ?>">
                              <i class="ion ion ion-md-arrow-back"></i> Back
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->    
   </div>
   <!-- container-fluid -->
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
<!-- <script type="text/javascript">
  
function handleClick() {
   
    var myRadio12 = document.getElementById('myRadios').value ||0;
     var cc = $('#Supplier').reset();
  
          // document.getElementById('price').value = final_org_amount.toFixed(3);
         
           document.getElementById('Supplier').value = myRadio12.toFixed(3); 
}
// </script> -->
<!-- <script type="text/javascript">
   $(':radio').mousedown(function(e){
  var $self = $(this);
  if( $self.is(':checked') ){
    var uncheck = function(){
      setTimeout(function(){$self.removeAttr('checked');},0);
    };
    var unbind = function(){
      $self.unbind('mouseup',up);
    };
    var up = function(){
      uncheck();
      unbind();
    };
    $self.bind('mouseup',up);
    $self.one('mouseout', unbind);
  }
});
</script> -->
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