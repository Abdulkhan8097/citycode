
<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                             <?php echo view('admin/_topmessage'); ?>
                             
                          <div class="row">
                            <div class="col-lg-3"> 
                               <h4 class="card-title">Edit Transaction</h4>     
                          </div>                        
                    </div>
                  <hr>
                 <form class="custom-validation"  method='post' action="ReportController/updatetransaction" enctype='multipart/form-data'>                              
                              <div class="for-mobile-laptop">
                           
                    
                              
                              <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Paid Amount<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['od_paidamount'] : ''; ?>" placeholder="Enter Paid Amount" name="od_paidamount"/>
                                   </div>
                                  </div>
                               </div>                             
                           </div>
                           <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Save Amount<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['od_saveamount'] : ''; ?>" placeholder="Enter Paid Amount" name="od_saveamount"/>
                                   </div>
                                  </div>
                               </div>                             
                           </div>

                         <div class="C selectt">
                          <div class="row">
                            <div class="col-md-10">
                              <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Commission</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="citycode_commission" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['citycode_commission'] : ''; ?>" placeholder ="Enter Comission" onKeyUp="numericFilter(this);"/>
                                    </div>
                                    </div>
                                   </div>
                                  </div>
                                </div>
                                <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Total Amount<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['od_totalamount'] : ''; ?>" placeholder="Enter Paid Amount" name="od_totalamount"/>
                                   </div>
                                  </div>
                               </div>                             
                           </div>
   <input type="hidden" name="od_id" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['od_id'] : ''; ?>" >
                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 ml-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                   
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
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
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>