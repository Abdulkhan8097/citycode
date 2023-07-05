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
                        <div class="col-8">
                            <h2 class="mb-4">Coupon Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Coupon Status</th>
                           <td>  <?php if($list[0]->status=='1'){ ?>
                                 <span class="badge badge-success">Active</span>

                           <?php }elseif($list[0]->status=='2'){ ?>
                          <span class="badge badge-warning">InActive</span>
                          

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
                           <th>Arabic Company Name</th>
                           <td><?php echo $list[0]->arb_coupon_name;?></td>
                        </tr>
                           <tr>
                           <th>Branch Name</th>
                           <td><?php echo $list[0]->branch_name;?></td>
                        </tr>
                        <tr>
                           <th>Coupon Name</th>
                           <td><?php echo $list[0]->coupon_name;?></td>
                        </tr>
                        <tr>
                           <th>Coupon Details</th>
                           <td><?php echo $list[0]->coupon_details;?></td>
                        </tr>
                         <tr>
                           <th>Arabic Coupon Details</th>
                           <td><?php echo $list[0]->arb_coupon_details;?></td>
                        </tr>
                        <tr>
                           <th>Coupon Amount</th>
                           <td><?php echo $list[0]->coupon_amount;?></td>
                        </tr>
                         <tr>
                           <th>Coupon Quantity</th>
                           <td><?php echo $list[0]->coupon_quantity;?></td>
                        </tr>
                        <tr>
                           <th>Coupon Price</th>
                           <td><?php echo $list[0]->coupon_price;?></td>
                        </tr>
                      
                         <tr>
                           <th>Created</th>
                           <td><?php echo $list[0]->created;?></td>
                        </tr>
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
