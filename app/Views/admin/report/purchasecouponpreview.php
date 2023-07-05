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
                            <?php if ($preview->purchase_status=='Active'){ ?>
                                <h2 class="mb-4">Purchase Coupon Details</h2>
                            <?php } ?>
                            <?php if ($preview->purchase_status=='Used'){ ?>
                                <h2 class="mb-4">Redeem Coupon Details</h2>
                            <?php } ?>
                            <?php if ($preview->purchase_status=='Expire'){ ?>
                                <h2 class="mb-4">Expire Coupon Details</h2>
                            <?php } ?>
                            
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                          <tr>
                           <th>Customer Name</th>
                           <td><?php echo $preview->name;?></td>
                        </tr>
                        <tr>
                           <th>Customer CityCode</th>
                           <td><?php echo $preview->city_code;?></td>
                        </tr>

                        <tr>
                           <th>Coupon Start Date</th>
                           <td><?php echo date('d F Y', strtotime($preview->start_date));?></td>
                          

                        </tr>
                        <tr>
                           <th>Coupon Expire Date</th>
                           <td><?php echo date('d F Y', strtotime($preview->end_date));?></td>
                        </tr>
                         <tr>
                           <th>Transaction Date</th>
                           <td><?php echo date('d F Y', strtotime($preview->created));?></td>
                        </tr>

                          <tr>
                           <th>Coupon Name</th>
                           <td><?php echo $preview->coupon_name;?></td>
                        </tr>
                         <tr>
                           <th>Coupon Amount</th>
                           <td><?php echo $preview->coupon_amount;?></td>
                        </tr>
                          <tr>
                           <th>Coupon Price</th>
                           <td><?php echo $preview->coupon_price;?></td>
                        </tr>

                         <tr>
                           <th>Total Product Price</th>
                           <td><?php echo $preview->od_totalamount;?></span></td>
                        </tr>
                         <tr>
                           <th>Total Paid Amount</th>
                           <td><?php echo $preview->od_paidamount;?></span></td>
                        </tr>
                        <tr>
                           <th>Total Save Amount</th>
                           <td><?php echo $preview->od_saveamount;?></span></td>
                        </tr>



                      <tr>
                           <th>Coupon Status</th>
                           <td><?php echo $preview->purchase_status;?></td>
                        </tr>  
                      
                          <tr>
                           <th>Company Name</th>
                           <td><?php echo $preview->company_name;?></td>
                        </tr>
                          <tr>
                           <th>Branch Name</th>
                           <td><?php echo $preview->branch_name;?></td>
                        </tr>
                        
           
                          
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
