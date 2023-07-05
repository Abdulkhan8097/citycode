<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Product Details</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion ion-md-arrow-back"></i> Back
                            </a>                            
                            <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditProduct?id='.$product['id']); ?>">
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
                                                  if($company['id'] == $product['company_id'] ){
                                                  echo $company['company_name']; 
                                             } } ?>
                                         </p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Branch :  
                                            <?php foreach ($branches as $row) { 
                                                  if($row['branch_id'] == $product['branch_id'] ){
                                                  echo $row['branch_name']; 
                                             } } ?>
                                         </p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Product Name : <?php echo $product['product_name']; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Price : <?php echo ($product['price']); ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description : <?php echo ($product['description']); ?></p>
                                    </blockquote>            
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Status : <?php if($product['status'] == 1){ echo 'Active'; }
                                                   else { echo 'Inactive';} ?></p>
                                   </blockquote>                
                                </div>

                                <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Product Images : 
					<?php if($product['picture']) { ?>
<div class="col-6">
					<img src="<?php echo base_url('product/'.$product['picture']); ?>" height=90 width=90 class="img-fluid">
					</div>                                         
					<?php  } ?>
					</p>
                                    </blockquote>            
                                </div>
								
								
								
								 <div class="col-12">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Menu List : 
										<?php if($images){ foreach($images as $row) { ?>
										<div class="col-6" style="display:inline !important;">
										<img src="<?php echo base_url('product/'.$row->image_name); ?>" height=70 width=70 class="img-fluid">
										</div>                                         
										<?php } } ?>
										</p>
                                    </blockquote>            
                                </div>

                                <div class="col-12"> <h3> Arabic </h2>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Product Name : <?php echo $product['arb_product_name']; ?></p>
                                    </blockquote>             
                                </div>

                                <div class="col-6">
                                    <blockquote class="card-blockquote mb-0">
                                        <p>Description : <?php echo ($product['arb_description']); ?></p>
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