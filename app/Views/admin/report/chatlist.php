<?php $session = session(); ?>


<div class="page-content">
    


        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20">Chat Reports</h4>
                </div>
            </div>
        </div>



        <div class="container">
            <?php echo view('admin/report/_searchformchat'); ?>
            <!-- Tab panes -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active">
                                <div class="card-body">
                                     <?php if($pagination["getNbResults"] >0 ){ ?>

                                    <div class="table-responsive">
                                        
                                            <table class="table table-striped table-centered table-nowrap mb-1">
                                                <thead>
                                                    <tr>
                                                       <th>SI. No.</th>
                                                       <th>Company name</th>
                                                        <th>Branch name</th>
                                                        
                                                        <th>Customer name</th>
                                                        <th>Date & Time</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($customers as $kdata) {   ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$startLimit ; ?></th>
                                                            <td><?php echo $kdata->company_name; ?></td>
                                                            <td><?php echo $kdata->branch_name; ?></td>

                                                            
                                                            <td><?php echo $kdata->name; ?></td>

                                                            <td><?php echo $kdata->created_date; ?></td>
                                                            
                                                            <td> <a class="btn btn-primary waves-effect waves-light"  href="<?php echo site_url('chatdetail?sender_id=' . $kdata->sender_id."&receiver_id=".$kdata->receiver_id); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                                </a> </td>
                                                        </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
                                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => $pageurl, 'varExtra' => $searchArray)); ?>
                                            <?php }
                                         ?>
                                    </div>
                                    <?php }else{ ?>
                                    <?php echo view('admin/_noresult',array('noResult'=>array("description"=>"Please change search criteria and submit again"))); ?>
                                <?php } ?>
                                </div>
                            </div>						
                           
                            

                        </div>
                    </div>
                </div>
            </div> 
        </div> 


</div>
