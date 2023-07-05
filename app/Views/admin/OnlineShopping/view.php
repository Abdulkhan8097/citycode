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
                            <h2 class="mb-4">Product Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Product Name</th>
                           <td><?php echo $list[0]->product_name;?></td>
                        </tr>
                        <tr>
                           <th>Company Name</th>
                           <td><?php echo $list[0]->company_name;?></td>
                        </tr>
                          <tr>
                           <th>Branch Name</th>
                           <td><?php echo $list[0]->branch_name;?></td>
                        </tr>
                     </tbody>
                  </table>
                   
                    </div>
                      <div class="col-8">
                            <h2 class="mb-4">Customer Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Customer Name</th>
                           <td><?php echo $list[0]->name;?></td>
                        </tr>
                         <tr>
                           <th>Customer City Code</th>
                           <td><?php echo $list[0]->city_code;?></td>
                        </tr>
                        <tr>
                           <th>Customer V.I.P Code</th>
                           <td><?php echo $list[0]->vip_code;?></td>
                        </tr>
                         
                     </tbody>
                  </table>
                   
                    </div>
                       <div class="col-8">
                            <h2 class="mb-4">Order Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Order ID</th>
                           <td><?php echo $list[0]->order_id;?></td>
                        </tr>
                        <tr>
                           <th>Payment Status</th>
                           <td>  <?php if($list[0]->payment_status=='1'){ ?>
                                 <span class="badge badge-success">Success</span>
                          
                        <?php }elseif($list[0]->payment_status=='0'){ ?>
                          <span class="badge badge-danger">Failed</span>
                           <?php }elseif($list[0]->payment_status=='2'){ ?>
                            <span class="badge badge-warning">Pending</span>
                           <?php }elseif($kdata->payment_status=='3'){ ?>
                          <span class="badge badge-secondary">Cancelled</span>
                        <?php } ?></td>
                        </tr>
                        <tr>
                           <th>Transaction Reference Number</th>
                           <td><?php echo $list[0]->transaction_id;?></td>
                        </tr>
                        <tr>
                           <th>Quantity</th>
                           <td><?php echo $list[0]->qty;?></td>
                        </tr>
                        
                        <tr>
                           <th>Product Actual Price</th>
                           <td><?php echo $list[0]->actual_price;?></td>
                        </tr>
                        <tr>
                           <th>Product Discount (Percent)</th>
                           <td><?php echo $list[0]->discount_percent;?></td>
                        </tr>
                        
                        <tr>
                           <th>Product After Discount Price</th>
                           <td><?php echo $list[0]->afterdiscount_price;?></td>
                        </tr>
                          <tr>
                           <th>CityCode Benefit</th>
                           <td><?php echo $list[0]->cityCode_benefits;?></td>
                        </tr>
                        
                        <tr>
                           <th>CityCode Vat</th>
                           <td><?php echo $list[0]->citycode_vat;?></td>
                        </tr>
                      
                        <tr>
                           <th>App Service Charge</th>
                           <td><?php echo $list[0]->service_charge;?></td>
                        </tr>
                        <tr>
                           <th>Supplier VAT</th>
                           <td><?php echo $list[0]->supplierVat_charges;?></td>
                        </tr>
                        <tr>
                           <th>Product Delivery Charge</th>
                           <td><?php echo $list[0]->delivery_charge;?></td>
                        </tr>
                        <tr>
                           <th>Product Delivery Charge (Per KM)</th>
                           <td><?php echo $list[0]->delivery_km;?></td>
                        </tr>
                        <tr>
                           <th>Final Product Amount</th>
                           <td><?php echo $list[0]->total_amount;?></td>
                        </tr>
                          <tr>
                           <th>Mobile Display Price</th>
                           <td><?php echo $list[0]->product_cost_mobile;?></td>
                        </tr>
                         <tr>
                           <th>Mobile Display Discounted Price</th>
                           <td><?php echo $list[0]->product_discount_mobile;?></td>
                        </tr>
                        <tr>
                           <th>Product Image</th>
                           <td><img src="<?php echo base_url('product/'.$list[0]->picture); ?>" height=150 width=150 class="img-fluid"></td>
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
