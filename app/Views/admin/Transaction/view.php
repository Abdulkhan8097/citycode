<style type="text/css">
    .card{
        border-radius: 2.75rem!important;
    }
    .table-bordered td, .table-bordered th{
    border: 2px solid #e9ecef !important;
    }
</style>
<?php $session = session();
$admin = $session->get('user_id');
 ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-8">
                            <h2 class="mb-4">Transaction Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Payment Status</th>
                           <td>  <?php if($list[0]->payment_status=='1'){ ?>
                                 <span class="badge badge-success">Approved & paid</span>
                          
                        <?php }elseif($list[0]->payment_status=='2'){ ?>
                          <span class="badge badge-danger">Bill Generate</span>
                           <?php }elseif($list[0]->payment_status=='0'){ ?>
                          <span class="badge badge-warning">Pending</span>
                           <?php }elseif($list[0]->payment_status=='3'){ ?>
                          <span class="badge badge-secondary">Cancelled</span>

                        <?php }?></td>
                        </tr>
                        <tr>
                           <th>Start Date</th>
                           <td><?php echo $list[0]->start_date;?></td>
                        </tr>
                        <tr>
                           <th>End Date</th>
                           <td><?php echo $list[0]->end_date;?></td>
                        </tr>
                          <tr>
                           <th>Company Name</th>
                           <td><?php echo $list[0]->company_name;?></td>
                        </tr>
                           <tr>
                           <th>Branch Name</th>
                           <td><?php echo $list[0]->branch_name;?></td>
                        </tr>
                        <tr>
                           <th>Total Amount Paid Customer</th>
                           <td><?php echo $list[0]->total_amount_paid_by_customer;?></td>
                        </tr>
                        <tr>
                           <th>Total Supplier Amount</th>
                           <td><?php echo $list[0]->total_supplier_amount;?></td>
                        </tr>
                        <tr>
                           <th>Total CityCode Amount</th>
                           <td><?php echo $list[0]->total_citycode_charage;?></td>
                        </tr>
                        <tr>
                           <th>Amount raised to supplier</th>
                           <td><?php echo $list[0]->amount;?></td>
                        </tr>
                         <tr>
                           <th>Created</th>
                           <td><?php echo $list[0]->created;?></td>
                        </tr>


<?php if($admin){
if(intval($list[0]->cpaid_amount)>0 || $list[0]->payment_mode!= ''){ ?>
                <tr>
                   <th>Company Paid Amount</th>
                   <td><b><?php echo $list[0]->cpaid_amount ?></b></td>
                </tr>
                <tr>
                   <th>Company Payment Mode</th>
                   <td><b><?php echo $list[0]->payment_mode ?></b></td>
                </tr>
                   <tr>
                   <th>Company Payment Transaction No.</th>
                   <td><b><?php echo $list[0]->txn_no ?></b></td>
                </tr>
                 <tr>
                   <th>Company Remark</th>
                   <td><b><?php echo $list[0]->remark ?></b></td>
                </tr>
            <?php }} ?>



                        <?php if(!$admin){ ?>
                            <form action="TransactionController/companySave" method="post">
                           <tr>
                           <th>Paid Amount</th>
                           <td><input type="text" class="form-control form-control-lg" onkeypress="numericFilter(this)" id="cpaid_amount" name="cpaid_amount" value="<?php echo (isset($list) && !empty($list)) ? $list[0]->cpaid_amount : ''; ?>" required></td>
                        </tr>
                         <tr>
                           <th>Payment Mode</th>
                           <td>
                           <select name="payment_mode" class="form-control form-control-lg" required>
                                            <option value=""> - Payment Mode -</option>
                                            <option  value="Bank" <?php echo ($list[0]->payment_mode =="Bank") ? "selected" : ''; ?> >Bank</option>
                                            <option  value="Online" <?php echo ($list[0]->payment_mode =="Online") ? "selected" : ''; ?>
                                               >Online</option>
                                                 <option  value="Cash" <?php echo ($list[0]->payment_mode =="Cash") ? "selected" : ''; ?>
                                                >Cash</option>
                                                 <option  value="Cheque" <?php echo ($list[0]->payment_mode =="Cheque") ? "selected" : ''; ?>
                                                >Cheque</option>

                                        </select>
                           </td>
                        </tr>
                          <tr>
                           <th>Transaction No.</th>
                           <td><input type="text" class="form-control form-control-lg" name="txn_no" value="<?php echo (isset($list) && !empty($list)) ? $list[0]->txn_no : ''; ?>"></td>
                        </tr>
                        <tr>
                           <th>Remark</th>
                           <td>
<textarea class="form-control form-control-lg" name="remark" ><?php echo (isset($list) && !empty($list)) ? $list[0]->remark : ''; ?></textarea>
                           </td>
                        </tr>
                         <tr>
                           <th></th>
                           <td> <input type="hidden" name="id" value="<?php echo $list[0]->id;?>">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button></td>
                        </tr>
                        </form>

                        <?php } ?>
                     </tbody>
                  </table>
                   
                    </div>
                     
                     </tbody>
                  </table>
                   
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
<script >
   function numericFilter(txb) {
       txb.value = txb.value.replace(/[^\0-9]/ig, "");
   }
   $('#cpaid_amount').change(function() {
     var cpaid_amount = $(this).val()||0;
    document.getElementById('cpaid_amount').value = parseFloat(cpaid_amount).toFixed(3);
     //alert(orgamt);
   });
</script> 
