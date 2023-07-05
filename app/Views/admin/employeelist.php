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
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Employee List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
						
			<a href="add_new_employee" class="btn btn-primary waves-effect waves-light">
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
			<?php if($pagination["getNbResults"] >0 ){ ?>
                            <div class="table-responsive">
                                <table  data-toggle="table" data-striped="true" class="table table-striped table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                            <th data-sortable="true" >SI. No.</th>                        
                            <th data-sortable="true" >Name</th>
                            <th data-sortable="true" >Email</th>
                            <th data-sortable="true" >Mobile No.</th>
			    <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php $i = 0;
                     foreach($results as $row){ ?>
                    <tr>
                    <th scope="row"><?php echo ++$i; ?></th>
                    <td> <?php echo $row->name;?> </td>								
		    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->mobileno; ?></td>
                    <td>

                       <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditEmployee?id='.$row->id); ?>">
                        <i class="fas fa-edit"></i></a>

                        <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('Employee_details?id='.$row->id); ?>">
                        <i class="ion ion-md-add-circle-outline"></i> </a>

                        <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('EmployeeDelete?id=' . $row->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                         <i class="fa fa-trash"></i> </a>
                     </td>
                   </tr>
                 <?php } ?>
              </tbody>
            </table>
                                <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
                    <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Employees', 'varExtra' => $searchArray)); ?>
                    <?php }?>
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

    
	
	
