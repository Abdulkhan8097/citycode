<?php $session = session(); ?>
<style>
/*   @media only screen and (max-width: 600px) {
   .for-mobile-laptop {
   margin: 0;
   }
   }*/
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
                        <h4 class="card-title"><?php echo $pagetitle; ?></h4>
                        <?php echo view('admin/_topmessage'); ?>
                     </div>
                     <div class="col-sm-6">
                     
                     </div>
                  </div>
                  <form class="custom-validation"  method='post' action="Coupon/save" enctype='multipart/form-data' name="ProductForm">
                     <div class="for-mobile-laptop">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label"> Start Date <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                     <input class="form-control" name="start_date" type="date" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['start_date'] : ''; ?>" placeholder="Search by start date" required>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Get Offer Details-->
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">End Date<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                   <input class="form-control" name="end_date" type="date" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['end_date'] : ''; ?>" placeholder="Search by end date" required>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Company Name<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                  <select class="form-control single" name="company_id" id="company_id" required>
                                            
                                                <option value="">- Please Select -</option>
                                             
                                                <?php   foreach ($companies as $row) {  ?>
                                                <option value="<?php echo $row['id'] ?>"   <?php echo   (isset($edit['company_id']) && $row['id'] == $edit['company_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['company_arb_name'] ? $row['company_name'] . ' / ' . $row['company_arb_name'] : $row['company_name']; ?></option> 
                                                 <?php   }?>
                                        </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                      
                       <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>                                  
                                 <div class="col-sm-6">
                                   
                                    <select name="branch_id[]" id="city"   class="form-control input-lg c_branch_id" multiple="multiple" required>
                                       <option value="">Select Branch</option>
                                          <?php
                                             $gidz = explode(',', $edit['branch_id']);
                                              if (isset($results) && !empty($results)) {
                                             foreach ($results as $row) { 
                                                if(in_array($row->branch_id, $gidz)){$selected = 'selected="selected"';} 
                                                        else {
                                                            $selected = '';
                                                         }?>
                                                          <option value="<?php echo $row->branch_id?>" <?php echo $selected ?>><?php echo $row->branch_name.'/'.$row->arb_branch_name; ?></option>
                                                   <?php } }?>
                                    </select>

                                 </div>
                              </div>
                           </div>
                            <span class="mandatory d-none" id="emsg" style="font-size: 33px;">*Please Select another Branch*</span>
                        </div>
                        <br>
                            <div class="row ">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Balance Amount</label>
                                 <div class="col-sm-6">
                                    <input type="text" name="bal_amount" id="bal_amount" onkeypress="numericFilter(this)" placeholder="Balance Amount"  class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['bal_amount'] : '0'; ?>" readonly>
                                 </div>
                              </div>
                           </div>
                        </div>

                   

         
                        
                        <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Coupon Name <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Coupon Name" name="coupon_name" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['coupon_name'] : ''; ?>" required/>
                                 </div>
                              </div>
                           </div>
                          
                        </div>
                         <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Arabic Coupon Name </label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Arabic Coupon Name" name="arb_coupon_name" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['arb_coupon_name'] : ''; ?>" />
                                 </div>
                              </div>
                           </div>
                          
                        </div>
                         <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Coupon Details <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" placeholder="Coupon Details" name="coupon_details"  ><?php echo (isset($edit) && !empty($edit)) ? $edit['coupon_details'] : ''; ?></textarea>
                                   <!--  <input type="text" class="form-control" placeholder="Coupon Details" name="coupon_details" value="<?php //echo (isset($edit) && !empty($edit)) ? $edit['coupon_details'] : ''; ?>" required/> -->
                                 </div>
                              </div>
                           </div>
                          
                        </div>

                        <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Arabic Coupon Details </label>
                                 <div class="col-sm-6">
                                    <textarea class="form-control" placeholder="Arabic Coupon Details" name="arb_coupon_details" ><?php echo (isset($edit) && !empty($edit)) ? $edit['arb_coupon_details'] : ''; ?></textarea>
                               
                                 </div>
                              </div>
                           </div>
                          
                        </div>
                  
                        <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Coupon Amount <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="coupon_amount" id="coupon_amount" onkeypress="numericFilter(this)" placeholder="Coupon Amount" required class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['coupon_amount'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Coupon Quantity <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="coupon_quantity"  onkeypress="numericFilter(this)" placeholder="Coupon Quantity" required class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['coupon_quantity'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Coupon Price <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="coupon_price" id="coupon_price" onkeypress="numericFilter(this)" placeholder="Coupon Price" required class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['coupon_price'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                         <div class="row fhide">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Status<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                   <select name="status" class="form-control">
                                            
                                            <option value="1" <?php echo (isset($edit) && !empty($edit) && $edit['status']=='1') ? 'selected' : ''; ?>> Active</option>
                                                Active</option>
                                            <option value="2"<?php echo (isset($edit) && !empty($edit) && $edit['status']=='2') ? 'selected' : ''; ?>>In Active</option>

                                        </select>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="form-group row mb-0">
                           <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-6">
                              <input type="hidden" name="id" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['id'] : ''; ?>">
                              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 " id="owner-submit-btn">
                              Submit
                              </button>
                              <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('viewcoupon'); ?>">
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
   function numericFilter(txb) {
       txb.value = txb.value.replace(/[^\0-9]/ig, "");
   }
    $('#coupon_price').change(function() {
     var coupon_price = $(this).val()||0;
    document.getElementById('coupon_price').value = parseFloat(coupon_price).toFixed(3);
     //alert(orgamt);
   });
   $('#coupon_amount').change(function() {
     var coupon_amount = $(this).val()||0;
    document.getElementById('coupon_amount').value = parseFloat(coupon_amount).toFixed(3);
     //alert(orgamt);
   });
</script>

<script>
    $(document).ready(function () {

       
        $('#company_id').change(function () {

            var compant_id = $('#company_id').val();

            var action = 'getbranch';

            if (compant_id != '' && compant_id != 'city_code')
            {
                $.ajax({
                    url: "<?php echo site_url('Coupon/getBranchasscoupon'); ?>?company_id="+compant_id,
                    method: "GET",
                    dataType: "JSON",
                    success: function (data)
                    {
                        
                         var html = '<option class="d-none"> Select Branch </option>';
                         // var html = '<option> Select All </option>';
   
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
        $('.c_branch_id').change(function () {

            var branch_id = $('.c_branch_id').val();
            var company_id = $('#company_id').val();
         
          


            var action = 'getbranch';

            if (branch_id != '' && branch_id != 'city_code' && company_id != '')
            {
                $.ajax({
                    url: "<?php echo site_url('Coupon/getBalance'); ?>?branch_id="+branch_id+"&company_id="+encodeURIComponent(company_id),
                    method: "GET",
                    dataType: "JSON",
                    success: function (data)
                    {
                       
                       var bal= $('#bal_amount').val(data.toFixed(3));

                       if (data=='0') {
                       $(".fhide").addClass("d-none");
                       $("#owner-submit-btn").attr("disabled", true);
                       $("#emsg").removeClass("d-none");
                    }else{
                     $(".fhide").removeClass("d-none");
                     $("#emsg").addClass("d-none");
                     $("#owner-submit-btn").attr("disabled", false);
                    }

                        
                    }
                });
            } else
            {
                $('#bal_amount').val('0');
            }

        });

    });
</script>
<!-- <script>
   $(function() {
     var filter = $('#city');
     filter.on('change', function() {
       if (this.selectedIndex) return; //not `Select All`
       filter.find('option:gt(0)').prop('selected', true);
       filter.find('option').eq(0).prop('selected', false);
     });
   });
</script> -->