<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Delivery Boy List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>
                            <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('AddDeliveryBoy'); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Add
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
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Mob Number</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php foreach($deliveryboylist as $kdata){ ?>
                                            <th scope="row"><?php echo $kdata->id ; ?></th>
                                            <th><?php echo $kdata->fname ; ?></th>
                                            <td><?php echo $kdata->lname ; ?></td>
                                            <td><?php echo $kdata->email ; ?></td>
                                            <td><?php echo $kdata->phone ; ?></td>
                                            <td>
                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('DeliveryboyDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> View Details
                                                </a>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('editDeliveryBoy?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> Edit
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

    