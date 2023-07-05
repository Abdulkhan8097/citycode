<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

 <style>
.btn-primary:hover { 
    background-color: #F6D000 !important;
    border-color: #F6D000 ;
}

 .font-size-20 {
   color: #000;
}

.btn-primary{
color: #000 !important;
}
</style>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <div class="page-title-box">
                        <h4 class="font-size-20">V.I.P Customers List</h4>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                           <a href="VipCustomers" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> V.I.P Customer List
                            </a>


                           <a href="AddCelebrity" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> V.I.P Benefits
                            </a>

                            <a href="AddCustomer" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> Add New Customer
                            </a>

                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion-md-arrow-back"></i> Back
                            </a>

                       </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
                                            <th scope="col">V.I.P Code</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $i=0;
                                                  foreach($vip_customers as $kdata){ ?>
                                            <th scope="row"><?php echo ++$i;?></th>
                                            <td><?php echo $kdata->vip_code ; ?></td>
                                            <th><?php echo $kdata->name ; ?></th>
                                            <td><?php echo $kdata->mobile ; ?></td>
                                            <td>
                                              
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCelebrity?id='.$kdata->id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> 

                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CelebrityDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> View Details
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteCelebrity?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>  

                                            </td>                                            
                                        </tr>
                                        <?php } ?>
                                        
                                        
                                    </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content -->  

    