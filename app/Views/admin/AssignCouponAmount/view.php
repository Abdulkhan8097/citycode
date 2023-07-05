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
                            <h2 class="mb-4">Assign Coupon Details</h2>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                     
                        
                      
                          <tr>
                           <th>Company Name</th>
                           <td><?php echo $list[0]->company_name;?></td>
                        </tr>
                           <tr>
                           <th>Branch Name</th>
                           <td><?php echo $list[0]->branch_name;?></td>
                        </tr>
                        <tr>
                           <th>Assign Amount</th>
                           <td><?php echo $list[0]->assign_amount;?></td>
                        </tr>
                        <tr>
                           <th>Balance Amount</th>
                           <td><?php echo $list[0]->bal_amount;?></td>
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
