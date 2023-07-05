<?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">


             <h4 class="font-size-20">Advertisement List List</h4>       </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="<?php echo site_url('dashboardaddnew');?>" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> Add New
                            </a>

                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion-md-arrow-back"></i> Back
                            </a>

                       </div>
                    </div>
                </div>
            </div>
<!-------------------------------- search --------------------------->
<form action="">
     <div class="col-xl-12">
         <div class="row">
                <div class="col-lg-4">
                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Name" >
                    </div>
																                              													
            <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                     Submit
                    </button>
            </div>
        </div>
     </div>
</form>
<br>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
			<?php if($pagination["getNbResults"] >0 ){ ?>
                            <div class="table-responsive">
                                 <table data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                   
                                     <thead>
                                        <tr>
                                            <th data-sortable="true" scope="col">Sl. No.</th>
                                            <th data-sortable="true" scope="col"> Name</th>
                                            <th data-sortable="true" scope="col">Url</th>
                                            <th class="text-center" data-sortable="true" scope="col">View</th>
                                         
                                            <th scope="col">Status</th> 

                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>

 <tbody>
                                        <tr>
                                            <?php  
                                            if(!empty($lists)){ foreach($lists as $list){ ?>
                                            <th scope="row"><?php echo $reverse--;?></th>  
                                              <td> <?php echo $list->add_name;?> </td>
                                              <td> <?php echo substr($list->url,0,40);?></td>
                                              <td class="text-center"> <?php echo $list->countview1;?> </td>
                                              <td> <?php echo $list->status =="1" ? "Active" : "Inactive";?></td>
                                              
                                             <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('editadd?id='.$list->add_id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('deladd?id='.$list->add_id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>                               
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                        
                                        
                                    </tbody>
                               </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                 <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'dashboardadd', 'varExtra' => $searchArray)); ?>
                                <?php } ?>                               
                            </div>
							<?php }else{ ?>
                            <?php echo view('admin/_noresult'); ?>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    

    </div>
    <!-- End Page-content -->  

    