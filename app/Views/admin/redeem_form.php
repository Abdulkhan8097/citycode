  <style>
.for-mobile-laptop {
  margin: 0 100px;
}

@media only screen and (max-width: 600px) {
  .for-mobile-laptop {
     margin: 0;

  }
}

.mandatory {
display:inline;
color:red;
}
</style> 

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Add Redeem Products</h4>
                               <form class="custom-validation"  method='post' action="RedeemController/add_new_product" enctype='multipart/form-data'>

                <div class="for-mobile-laptop">

                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Name <span class="mandatory">*</span></label>
                               <div class="col-sm-6">

                                <select name="company_id" class="form-control input-lg" required>
                                    <option value="">- Please Select -</option>
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
                                                    ?>
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
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Details <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" name="description" cols="6" rows="4" placeholder="Type Product Description" required></textarea>
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

                                
                           <div class="row">
                            <div class="col-md-6">
                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Redeeming Points<span class="mandatory">*</span></label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Type Redeeming Points" name="pr_redeempoint" id="pr_redeempoint" required onKeyUp="numericFilter(this);"/>
                                </div>
                             </div>
                           </div>
                    </div>

                             <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Type Product Price" name="price" id='price' onKeyUp="numericFilter(this);" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            
                        <div class="row">
                            <div class="col-md-6">
				                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Product Image<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="file" name="picture" required class="form-control">
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                 </div>


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
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

<script>
$(document).ready(function(){	
    $('#state').change(function(){
        var company_id = $('#state').val();
        var action = 'get_city';
        if(company_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/ProductController/action'); ?>",
                method:"POST",
                data:{company_id:company_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select Branch</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].branch_id+'">'+data[count].branch_name+'</option>';
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
<script type="text/javascript">
    $('#price').change(function() {
      var orgamt = $(this).val()||0;
     document.getElementById('price').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });

    /*$('#pr_redeempoint').change(function() {
      var orgamt = $(this).val()||0;
     document.getElementById('pr_redeempoint').value = parseFloat(orgamt).toFixed(3);
      //alert(orgamt);
    });*/
</script>

<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>