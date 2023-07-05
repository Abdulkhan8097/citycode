<<<<<<< HEAD
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
}.fa {
color:red !important;
}

.img-fluid{
    margin-top:20px;
}
</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Edit Redeem Product</h4>
				<?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="RedeemController/update" enctype='multipart/form-data'>
                                <input type="hidden" id="new_id" name="new_id" value="<?php echo $result['id']; ?>">
 
                          <div class="for-mobile-laptop">

                   <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-4 col-form-label">Company Name<span class="mandatory">*</span></label>
                            <div class="col-sm-6">
                                      <select name="company_id" class="form-control input-lg"  required>
                                         <option value="">Please Select</option>                                        
                                            <?php  foreach ($companies as $row) { 
                                                   if($row['id'] == $result['company_id'] ){
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
                                            <?php } } ?>
                                         </select>
                                    </div>
                                 </div>
                                 </div>
                                 </div>

                                 <div class="row">
                        <div class="col-md-6">
                             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Name <span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Product Name" name="product_name" required value="<?php echo $result['product_name'];?>"/>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="arb_product_name" value="<?php echo $result['arb_product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                             </div>

                             <div class="row">
                        <div class="col-md-6">
                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Redeeming Points<span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Redeeming Points" name="pr_redeempoint" required value="<?php echo $result['pr_redeempoint'];?>" onKeyUp="numericFilter(this);"/>
                                </div>
                             </div>
                             </div>
                             </div>

                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Type Product Price" name="price" id="price" onKeyUp="numericFilter(this);" required value="<?php echo $result['price'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                             <div class="row">
                        <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Details <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" name="description" cols="6" rows="4" placeholder="Type Product Description" required><?php echo $result['description'];?></textarea>
                                </div>
                             </div> 
                             </div>

                             <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="arb_description" cols="6" rows="4" ><?php echo $result['arb_description']; ?></textarea>
                                                
                                            </div></div> </div> 
                             </div> 
                            
                    
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Product Image<span class="mandatory">*</span></label>                                  
                    <div class="col-sm-6">
                        <?php if (!empty($result['picture'])) { ?>
					        <img src="<?php echo base_url('product/'.$result['picture']);?>" height=190 width=190 class="img-fluid"> 
                        <?php } else { ?> <?php } ?> <br> <br>
                    <input type="file" name="picture" /> 
                </div>
            </div>
                                                               							
                    <div class="row">
                        <div class="col-md-6">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status"/>
                                       
                                        <option  value="1" <?php if($result['status'] == 1){ echo "selected"; } ?>>Active</option>
                                        <option value ="0" <?php if($result['status'] == 0){ echo "selected"; } ?>>Inactive</option>
                                    </select>
                                   </div>
                                 </div>
                                 </div>
                                 </div>
                             <div class="col-md-6 d-none">
                             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Redeem </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Redeem" name="redeem"  value="<?php echo $redeemc[0]['redeem'];?>"/>
                    <input type="hidden"  name="p_company_id" value="<?php echo $result['company_id'];?>">
                                </div>
                             </div>
                             </div>



                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Update
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
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

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#city_add').click(function(){  
           i++;  
           $('#city_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="c_location[]"/></div></div> <div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="company_discount[]" id="txt11"  onkeyup="sum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="comission[]" id="txt22"  onkeyup="sum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="customer_discount[]" id="txt33"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="c_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="c_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="c_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#famous_add').click(function(){  
           i++;  
           $('#famous_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="fam_location[]"/></div></div><div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="fam_company_discount[]" id="txt100"  onkeyup="famsum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="fam_comission[]" id="txt200"  onkeyup="famsum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="fam_customer_discount[]" id="txt300"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="fam_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fam_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fam_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#friday_add').click(function(){  
           i++;  
           $('#friday_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="fri_location[]"/></div></div><div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="fri_company_discount[]" id="txt400"  onkeyup="frisum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="fri_comission[]" id="txt500"  onkeyup="frisum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="fri_customer_discount[]" id="txt600"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="fri_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fri_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fri_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<!------- for city code -------------->



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

<script>
function frisum1() {
            var txtFirstNumberValue = document.getElementById('txt400').value;
            var txtSecondNumberValue = document.getElementById('txt500').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt600').value = result;
            }
        }


    $('#price').change(function() {
    var orgamt = $(this).val()||0;
    document.getElementById('price').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });



    $(document).ready(function(){
        var orgamt = $('#price').val()||0;
        document.getElementById('price').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });

</script>

<!------ for famous yaha se------------->

<script>
    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
=======
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
}.fa {
color:red !important;
}

.img-fluid{
    margin-top:20px;
}
</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Edit Redeem Product</h4>
				<?php echo view('admin/_topmessage'); ?>
                               <form class="custom-validation"  method='post' action="RedeemController/update" enctype='multipart/form-data'>
                                <input type="hidden" id="new_id" name="new_id" value="<?php echo $result['id']; ?>">
 
                          <div class="for-mobile-laptop">

                   <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-4 col-form-label">Company Name<span class="mandatory">*</span></label>
                            <div class="col-sm-6">
                                      <select name="company_id" class="form-control input-lg" required>
                                         <option value="">Please Select</option>                                        
                                            <?php  foreach ($companies as $row) { 
                                                   if($row['id'] == $result['company_id'] ){
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
                                            <?php } } ?>
                                         </select>
                                    </div>
                                 </div>
                                 </div>
                                 </div>

                                 <div class="row">
                        <div class="col-md-6">
                             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Name <span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Product Name" name="product_name" required value="<?php echo $result['product_name'];?>"/>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="arb_product_name" value="<?php echo $result['arb_product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                             </div>

                             <div class="row">
                        <div class="col-md-6">
                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Redeeming Points<span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Redeeming Points" name="pr_redeempoint" required value="<?php echo $result['pr_redeempoint'];?>" onKeyUp="numericFilter(this);"/>
                                </div>
                             </div>
                             </div>
                             </div>

                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Type Product Price" name="price" id="price" onKeyUp="numericFilter(this);" required value="<?php echo $result['price'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                             <div class="row">
                        <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Details <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" name="description" cols="6" rows="4" placeholder="Type Product Description" required><?php echo $result['description'];?></textarea>
                                </div>
                             </div> 
                             </div>

                             <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="arb_description" cols="6" rows="4" ><?php echo $result['arb_description']; ?></textarea>
                                                
                                            </div></div> </div> 
                             </div> 
                            
                    
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Product Image<span class="mandatory">*</span></label>                                  
                    <div class="col-sm-6">
                        <?php if (!empty($result['picture'])) { ?>
					        <img src="<?php echo base_url('product/'.$result['picture']);?>" height=190 width=190 class="img-fluid"> 
                        <?php } else { ?> <?php } ?> <br> <br>
                    <input type="file" name="picture" /> 
                </div>
            </div>
                                                               							
                    <div class="row">
                        <div class="col-md-6">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status"/>
                                        <?php if($result['status'] == 1){ ?>
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
                                 </div>


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Update
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
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

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#city_add').click(function(){  
           i++;  
           $('#city_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="c_location[]"/></div></div> <div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="company_discount[]" id="txt11"  onkeyup="sum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="comission[]" id="txt22"  onkeyup="sum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="customer_discount[]" id="txt33"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="c_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="c_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="c_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#famous_add').click(function(){  
           i++;  
           $('#famous_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="fam_location[]"/></div></div><div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="fam_company_discount[]" id="txt100"  onkeyup="famsum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="fam_comission[]" id="txt200"  onkeyup="famsum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="fam_customer_discount[]" id="txt300"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="fam_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fam_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fam_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      $('#friday_add').click(function(){  
           i++;  
           $('#friday_field').append('<div id="row'+i+'" class="dynamic-added"><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Location</label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter location" name="fri_location[]"/></div></div><div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Company Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Company Discount" name="fri_company_discount[]" id="txt400"  onkeyup="frisum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">CodeApp Commission </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter CodeApp Commission" name="fri_comission[]" id="txt500"  onkeyup="frisum1();" /></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label"> Customer Discount </label><div class="col-sm-6"><input type="text" class="form-control" required placeholder="Enter Customer Discount" name="fri_customer_discount[]" id="txt600"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Discount Details </label><div class="col-sm-6"><input type="text" class="form-control" placeholder="Enter discount details" name="fri_disc_detail[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">Start Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fri_start[]"/></div></div><div class="form-group row"><label for="inputPassword" class="col-sm-2 col-form-label">End Date / Time</label><div class="col-sm-6"><input type="date" class="form-control" name="fri_end[]"/></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><div>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

   });  
</script>

<!------- for city code -------------->



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

<script>
function frisum1() {
            var txtFirstNumberValue = document.getElementById('txt400').value;
            var txtSecondNumberValue = document.getElementById('txt500').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt600').value = result;
            }
        }


    $('#price').change(function() {
    var orgamt = $(this).val()||0;
    document.getElementById('price').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });



    $(document).ready(function(){
        var orgamt = $('#price').val()||0;
        document.getElementById('price').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });

</script>
<script>
$(document).ready(function(){
   $("#dropDownId").change(function(){
      window.location.reload(true);
   });
});
</script>

<!------ for famous yaha se------------->

<script>
    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
>>>>>>> af379bd964cd1d427d46f7085db5eb64385e36d5
</script>