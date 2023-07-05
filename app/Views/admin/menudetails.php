<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Menu Details</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>                            
                            <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditMenu?id='.$menurow['id']); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Edit
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        
                        <div class="card-body">                            
                            <div class="row">

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Company Name :  
                                            <?php foreach ($companies as $company) { 
                                                  if($company['id'] == $menurow['company_id'] ){
                                                  echo $company['company_name']; 
                                             } } ?>
                                         </p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch :  
                                            <?php foreach ($branches as $row) { 
                                                  if($row['branch_id'] == $menurow['branch_id'] ){
                                                  echo $row['branch_name']; 
                                             } } ?>
                                         </p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Start Date : <?php if(!empty($menurow['start_date'])) { 
								echo date('Y-m-d', strtotime($menurow['start_date'])); }?></p>
                                    </blockquote>            
                                </div>
								
								     <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>End Date : <?php if(!empty($menurow['end_date'])) { 
								echo date('Y-m-d', strtotime($menurow['end_date'])); } ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($menurow['status'] == 1){ echo 'Active'; }
                                                   else { echo 'Inactive';} ?></p>
                                   </blockquote>                
                                </div>

								
								
								 <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Menu List : 
										<?php if($images){ foreach($images as $row) { ?>
										<div class="col-6" style="display:inline !important;">
										<img src="<?php echo base_url('menulist/'.$row->menu_image); ?>" height=70 width=70 class="img-fluid">
										</div>                                         
										<?php } } ?>
										</p>
                                    </blockquote>            
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <br>                                        
                </div>            
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content --> 