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
                     </div>
                     <div class="col-sm-6">
                     
                     </div>
                  </div>
                  <form class="custom-validation"  method='post' action="Coupon/saveAssignAmount" enctype='multipart/form-data' name="ProductForm">
                     <div class="for-mobile-laptop">
                       

                    

                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Select Company Name<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                  <select class="form-control single" name="company_id" id="company_id" >
                                            
                                                <option value="">- Please Select -</option>
                                                <option value="city_code" <?php echo   (isset($searchArray['company_id']) && 'city_code' == $searchArray['company_id']) ? "Selected" : ""; ?>>City Code</option>
                                                <?php   foreach ($companies as $row) {  ?>
                                                <option value="<?php echo $row['id'] ?>"   <?php echo   (isset($edit['company_id']) && $row['id'] == $edit['company_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['company_arb_name'] ? $row['company_name'] . ' / ' . $row['company_arb_name'] : $row['company_name']; ?></option> 
                                                 <?php   }?>
                                        </select>
                                 </div>
                              </div>
                           </div>
                        </div>

                     <!--    <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Select Branch Name<span class="mandatory">*</span></label>                                  
                                 <div class="col-sm-6" id="divbranch">
                                   
                                       <select class="form-control"  name="branch_id" >
                                                <option value="">- Please Select -</option>
                                                <?php   //foreach ($branches as $row) {  ?>
                                                <option value="<?php //echo $row['branch_id'] ?>"   <?php //echo   (isset($edit['branch_id']) && $row['branch_id'] == $edit['branch_id']) ? "Selected" : ""; ?>>
                                                            <?php //echo $row['arb_branch_name'] ? $row['branch_name'] . ' / ' . $row['arb_branch_name'] : $row['branch_name']; ?></option> 
                                                 <?php  // }?>
                                                
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
                                   
                                    <select name="branch_id[]" id="city"   class="form-control input-lg c_branch_id" multiple="multiple" required>
                                       <option value="">Select Branch</option>
                                    </select>
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Add Amount<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="add_amount" id="coupon_amount" onkeypress="numericFilter(this)" placeholder="Add Amount" required class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['assign_amount'] : ''; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Balance Amount<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="bal_amount" id="bal_amount" onkeypress="numericFilter(this)" placeholder="Balance Amount"  class="form-control"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['bal_amount'] : '0'; ?>" readonly>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row mb-0">
                           <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-6">
                              <input type="hidden" name="id" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['assign_id'] : ''; ?>">
                              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                              Submit
                              </button>
                              <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('viewcouponamt'); ?>">
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
   $("#checkall").change(function () {
       $('.checkhour').prop('checked', $(this).prop("checked"));
   });
</script>  
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
                    url: "<?php echo site_url('Coupon/getBranch'); ?>?company_id="+compant_id,
                    method: "GET",
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
                       
                         $('#bal_amount').val(data.toFixed(3));
                        
                    }
                });
            } else
            {
                $('#bal_amount').val('0');
            }

        });

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
