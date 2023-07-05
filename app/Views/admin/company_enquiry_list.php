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
                        <h4 class="font-size-20">Company Feedback</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

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
                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Username, Company Name, Enquiry" >
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
                                            <th data-sortable="true" scope="col">Username</th>
											<th data-sortable="true" scope="col">City Code</th>
											<th data-sortable="true" scope="col">Mobile</th>
											<th data-sortable="true" scope="col">Gender</th>
                                            <th data-sortable="true" scope="col">Comapny Name</th>
                                            <th data-sortable="true" scope="col">Enquiry</th>
                                            <th data-sortable="true" scope="col">Date & Time</th>
                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                                  foreach($results as $kdata){ ?>
                                            <th scope="row"><?php echo $reverse--;?></th>
                                            <th><?php echo $kdata->name; ?></th>
											<th><?php echo $kdata->city_code; ?></th>
											<th><?php echo $kdata->mobile; ?></th>
											<th><?php echo $kdata->gender; ?></th>
                                            <td><?php echo $kdata->company_name; ?></td>
                                            <td><?php echo substr($kdata->ce_details,0,20); ?></td>                                      
                                            <td><?php echo $kdata->ce_createddate; ?></td>                                      
                                            <td>

                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('EnquiryDetails?id='.$kdata->ce_id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteEnquiry?id='.$kdata->ce_id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                              
                                            </td>                                            
                                        </tr>
                                        <?php } ?>
                                        
                                        
                                    </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                               <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'CompanyEnquiry', 'varExtra' => $searchArray)); ?>                                <?php } ?>
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

    