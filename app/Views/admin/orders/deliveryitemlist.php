<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Delivery Item List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
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
                                            <th scope="col">(#) Id</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Medicine</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($allorders as $order) { ?>
                                           
                                        
                                        <tr>                                            
                                            <th scope="row"><?php echo $order->id ; ?></th>
                                            <td><?php echo $order->date_created ; ?></td>
                                            <td><?php echo $order->med_name ; ?></td>
                                            <td><?php echo $order->qty ; ?></td>
                                            <td><?php echo $order->status ; ?></td>
                                            <td>
                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('DeliveryDetails?orderid='.$order->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> View Details
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

    