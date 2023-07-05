<?php $session = session(); ?>
<style type="text/css">
    .card{
        border-radius: 2.75rem!important;
    }
    .table-bordered td, .table-bordered th{
    border: 2px solid #e9ecef !important;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                           <form method="POST" action="../TransactionController/save">
                            <h2 class="mb-4">Payment Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Start Date</th>
                           <td> <input type="text" class="form-control" name="order_start_date" value="<?php  echo isset($searchArray['start_date']) ? $searchArray['start_date'] : "" ?>" readonly required/></td>
                        </tr>
                        <tr>
                           <th>End Date</th>
                           <td><input type="text" class="form-control" name="order_end_date" value="<?php echo isset($searchArray['end_date']) ? $searchArray['end_date'] :''; ?>" readonly required/></td>
                        </tr>
                          <tr>
                           <th>Company Name</th>
                           <td>  <?php if ($session->get('company_id')){ ?>
                                    <input type="text" class="form-control" name="company_id" 
                                       value="<?php if (($session->get('company_name')) && $session->get('company_arb_name')) {
                                          echo ($session->get('company_name')).' / '. ($session->get('company_arb_name'));
                                          } else if ($session->get('company_arb_name')){
                                             echo ($session->get('company_arb_name'));
                                          } else{
                                             echo ($session->get('company_name'));
                                          } ?>" readonly/>
                                    <?php } else { ?>
                               <select class="form-control" name="company_id" id="company_id" >
                                            
                                                <option value="">- Please Select -</option>
                                              
                                                <?php   foreach ($companies as $row) {  ?>
                                                <option  value="<?php echo $row['id'] ?>"   <?php echo   (isset($searchArray['company_id']) && $row['id'] == $searchArray['company_id']) ? "Selected" : "disabled"; ?>>
                                                            <?php echo $row['company_arb_name'] ? $row['company_name'] . ' / ' . $row['company_arb_name'] : $row['company_name']; ?></option> 
                                                 <?php   }}?>
                                                  </select></td>
                        </tr>
                          <tr>
                           <th>Branch Name</th>
                           <td>  <select class="form-control"  name="branch_id" >
                                                <option value="">- Please Select -</option>
                                                <?php   foreach ($branches as $row) {  ?>
                                                <option  value="<?php echo $row['branch_id'] ?>"   <?php echo   (isset($searchArray['branch_id']) && $row['branch_id'] == $searchArray['branch_id']) ? "Selected" : "disabled"; ?>>
                                                            <?php echo $row['arb_branch_name'] ? $row['branch_name'] . ' / ' . $row['arb_branch_name'] : $row['branch_name']; ?></option> 
                                                 <?php   }?>
                                                
                                        </select>  </td>
                        </tr>
                        <?php 
                                        //echo"<pre>";
                                        //var_dump($list);DIE;
                                        $customerPay=0;
                                        $supplier=0;
                                        $citycodeCharge=0;
                                        $suppliervat_charges=0;
                                        $cityCodeVat_Charge=0;
                                        $appService_charge=0;
                                        $cityCode_benefits=0;
                                        $delivery_charge=0;
                                        $discount_offer_citycode=0;
                                        foreach ($list as $kdata) {?>
                                             
                                            <?php $customerPay+=$kdata->total_cost_mobile;?>
                                            <?php $cityCodeVat_Charge+=$kdata->cityCodeVat_Charge;?>
                                            <?php $appService_charge+=$kdata->appService_charge;?>
                                            <?php $cityCode_benefits+=$kdata->cityCode_benefits;?>
                                            <?php $delivery_charge+=$kdata->delivery_charge;?>
                                            <?php $suppliervat_charges+=$kdata->suppliervat_charges;?>

                                            <?php $supplier1+=$kdata->afterdiscount_price?>
                                             <?php $supplier=$supplier1+$suppliervat_charges;?>
                                             <?php $supplier=$supplier+$delivery_charge;?>
                                             <?php $discount_offer_citycode+=$kdata->discount_offer_citycode;?>
                                         
                                        <?php $citycodeCharge=$cityCodeVat_Charge+$appService_charge+$cityCode_benefits+$delivery_charge+$discount_offer_citycode?>
                                           
                                         <?php } ?>
                          <tr>
                           <th>Total Amount Paid By Customer</th>
                           <td> <input type="text" class="form-control" name="total_amount_paid_by_customer" value="<?php echo number_format($customerPay, 3, '.', ''); ?>" readonly required/></td>
                        </tr>
                          <tr>
                           <th>Total Supplier Amount (+supplier Vat+Delivery Charge)</th>
                           <td> <input type="text" class="form-control" name="total_supplier_amount" value="<?php echo number_format($supplier, 3, '.', ''); ?>" readonly required/></td>
                        </tr>
                        <tr>
                           <th>CityCode Charges Amount (+Discount (Public/ VIP/ Friday) for citycode +Citycode Vat +cityCode Benefits +App Service Charge)</th>
                           <td> <input type="text" class="form-control" name="total_citycode_charage" value="<?php echo number_format($citycodeCharge, 3, '.', ''); ?>" readonly required/></td>
                        </tr>
                          <tr>
                           <th>Request Payment to Supplier(Below this Amount <?php echo number_format($citycodeCharge, 3, '.', '')?>)</th>
                           <td>  <input type="text" onkeypress="numericFilter(this)"  id="paidamount"class="form-control" name="amount" value="" required/></td>
                        </tr>
                         
                     </tbody>
                  </table>
                    <div class="form-group row mb-0">
                        
                           <div class="col-sm-11">
                              <button type="submit" style="float: right;" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                              Request To Pay
                              </button>
                            
                           </div>
                        </div>
                        </form>
                    </div>
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
    $('#paidamount').change(function() {
     var paidamount = $(this).val()||0;
    document.getElementById('paidamount').value = parseFloat(paidamount).toFixed(3);
     //alert(orgamt);
   });
</script> 


