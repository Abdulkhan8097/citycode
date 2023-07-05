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
                        <h4 class="card-title">Add Transaction</h4>
                     </div>
                     
                  </div>
                  <form class="custom-validation" method="post" action="TransactionController/balanceAmount" enctype='multipart/form-data'>
                     <div class="for-mobile-laptop">
                          <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Start Date <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="date" class="form-control" name="order_start_date" value="<?php  echo isset($searchArray['start_date']) ? $searchArray['start_date'] : "" ?>" required/>
                                 </div>
                              </div>
                           </div>
                          
                        </div>
                            <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">End Date <span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="date" class="form-control" name="order_end_date" value="<?php echo isset($searchArray['end_date']) ? $searchArray['end_date'] :''; ?>" required/>
                                 </div>
                              </div>
                           </div>
                          
                        </div>
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
                                    <select name="company_id" id="company_id" class="form-control input-lg single"  required>
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
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Branch Name <span class="mandatory">*</span></label>
                                 <div class="col-sm-6 " id="divbranch">
                                    <select class="form-control"  name="branch_id" required >
                                                <option value="">- Please Select -</option>
                                                <?php   foreach ($branches as $row) {  ?>
                                                <option value="<?php echo $row['branch_id'] ?>"   <?php echo   (isset($searchArray['branch_id']) && $row['branch_id'] == $searchArray['branch_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['arb_branch_name'] ? $row['branch_name'] . ' / ' . $row['arb_branch_name'] : $row['branch_name']; ?></option> 
                                                 <?php   }?>
                                                
                                        </select>  
                                 </div>
                              </div>
                           </div>
                        </div>

                      
                     

                        <div class="form-group row mb-0">
                           <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-6">
                              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                              Current Balance
                              </button>
                             <!--  <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Products'); ?>">
                              <i class="ion ion ion-md-arrow-back"></i> Back
                              </a> -->
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

        $('#state').change(function () {

            var state_id = $('#state').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo site_url('ReportController/action'); ?>",
                    method: "POST",
                    data: {state_id: state_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option value="">Select State</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            html += '<option value="' + data[count].city_id + '">' + data[count].city_name + '</option>';
                        }

                        $('#city').html(html);
                    }
                });
            } else
            {
                $('#city').val('');
            }

        });
        
        
        $('#company_id').change(function () {

            var compant_id = $('#company_id').val();

            var action = 'getbranch';

            if (compant_id != '' && compant_id != 'city_code')
            {
                $.ajax({
                    url: "<?php echo site_url('OnlineShopping/getBranch'); ?>?company_id="+compant_id,
                    method: "GET",
                    dataType: "JSON",
                    success: function (data)
                    {
                        
                        var html = '<select class="form-control single"  name="branch_id" > <option value="">Select Branch</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            if(data[count].arb_branch_name)
                            {
                            html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name+"/"+data[count].arb_branch_name + '</option>';
                            }
                            else
                            {
                             html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + '</option>';
                            }
                        }
                    
                        $('#divbranch').html(html);
                    }
                });
            } else
            {
                $('#divbranch').val('');
            }

        });

    });

</script>
