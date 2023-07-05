
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php $session = session(); ?>
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
                        <h4 class="font-size-20">Redeem Products List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="AddRedeem_Products" class="btn btn-primary waves-effect waves-light">
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
<div class="container">
  <form action="">     
         <div class="row">
                <div class="col-lg-4">
                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Company Name, Product Name" >
                    </div>
																                              													
            <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                     Submit
                    </button>
            </div>
        </div>     
</form>
</div>
<br>

<!---------------- import ------------------------>
<?php if ($session->get('user_id')){ ?>
<div class="container">
<form method="post" action="RedeemController/import" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-3"> 
            <div class="form-group"> 
                <select name="company_id" class="form-control input-lg" required id="state">
                    <option value="">- Please Select -</option>
                <?php
                foreach ($companies as $company) {
                    if (($company["company_name"]) && ($company["company_arb_name"])){
                        echo '<option value="' . $company["id"] . '">' . $company["company_name"].' / '.$company["company_arb_name"]. '</option>';
                    }
                     else if($company["company_arb_name"]){
                        echo '<option value="' . $company["id"] . '">' .$company["company_arb_name"]. '</option>';
                    }
                     else{
                     echo '<option value="' . $company["id"] . '">' .$company["company_name"]. '</option>';  
                     }
                }
           ?>
        </select>
    </div>
</div>                                
                                
        <div class="col-lg-3">
			<div class="form-group">
				<input type="file" name="file" id="file" class="form-control">
			</div>
        </div>

     <div class="col-lg-3"> 
		<div class="form-group">
			<input type="submit" name="submit" value="Upload CSV" class="btn btn-primary" />
		</div>
    </div>
</form>
<div class="col-lg-3 text-right"> 
		<div class="form-group">
        <a href="<?php echo base_url();?>/admin/csv/redeem-example.csv" download="redeem-example.csv" class="btn btn-primary"> Format </a>
		</div>
    </div>
</div>
<?php } ?>
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
                                            <th scope="col" data-field="Sl. No." data-sortable="true">Sl. No.</th>
                                            <th scope="col" data-field="Company Name" data-sortable="true">Company Name</th>
                                            <th scope="col" data-field="Product Name" data-sortable="true">Product Name</th>
                                            <th scope="col" data-field="Points" data-sortable="true">Points</th>
                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>

 <tbody>
                                        <tr>
                                            <?php  
                                            if(!empty($lists)){ foreach($lists as $list){ ?>
                                            <th scope="row"><?php echo $reverse--;?></th>                                           
                                             
                                              <td> <?php echo $list->company_name;?> </td>
                                              <td> <?php echo $list->product_name;?></td>
                                              <td> <?php echo $list->pr_redeempoint;?></td>

                                          <?php if($session->get('employee_id')) { ?>
					   <td>   
					       <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('RedeemProductDetails?id='.$list->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a>  
					   </td> <?php } else { ?>

                                             <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditRedeem_Products?id='.$list->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('RedeemProductDetails?id='.$list->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a> 

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteRedeem_Products?id='.$list->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>                               
                                            </td> <?php } ?>                                           
                                        </tr>
                                        <?php } }?>
                                        
                                        
                                    </tbody>
                               </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                 <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Redeem_Products', 'varExtra' => $searchArray)); ?>
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

    