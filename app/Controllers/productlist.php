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

.btn-success{
    background:#228B22;
}

</style>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Product List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="AddProduct" class="btn btn-primary waves-effect waves-light">
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

<div class="container">
<form method="post" action="ProductController/import" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-3"> 
            <div class="form-group"> 
			<?php if ($session->get('company_id')){ ?>
			<input type="text" class="form-control input-lg" name="company_id" value="<?php echo ($session->get('company_name')); ?>" />		
		     <?php } else { ?>			
                <select name="company_id" class="form-control input-lg" required id="state">
                    <option value="">- Select Company -</option>
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
		<?php } ?>
    </div>
</div>



                 <div class="col-lg-3">
                   <div class="form-group">
	                <?php if($session->get('company_id')) { ?>
	                  <select name="branch_id"  class="form-control input-lg" required>
                           <option value="">- Select Branch -</option>
                                <?php
                                foreach($branchdata as $branch)
                                {
                                  if(($branch->branch_name) && ($branch->arb_branch_name)){
                                  echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.' / '.$branch->arb_branch_name.'</option>';
                                  }
                                  else if($branch->arb_branch_name){
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->arb_branch_name.'</option>';
                                  }
                                  else{
                                    echo '<option value="'.$branch->branch_id.'">'.$branch->branch_name.'</option>';
                                  }
                                }
                                ?>                                    
                           </select>
	               <?php } else { ?>
                <select name="branch_id" id="city" class="form-control input-lg" required>
                     <option value="">Select Branch</option>
                </select>   <?php } ?>                                              
             </div> 
         </div>                                 
                                
        <div class="col-lg-2">
			<div class="form-group">
				<input type="file" name="file" id="file" class="form-control">
			</div>
        </div>

     <div class="col-lg-2"> 
		<div class="form-group">
			<input type="submit" name="submit" value="Upload CSV" class="btn btn-primary" />
		</div>
    </div>
</form>
<div class="col-lg-2 text-right"> 
		<div class="form-group">
        <a href="<?php echo base_url();?>/admin/csv/example.csv" download="example.csv" class="btn btn-primary" role="button"> Format </a>
		</div>
    </div>
    </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
						<?php if($pagination["getNbResults"] >0 ){ ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
                                            <th scope="col">Company Name</th>
                    
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Percentage</th>
                                            <?php if($session->get('user_id')){?>
											<th scope="col">Status</th> <?php } ?>
                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <?php  
                                            foreach($allproduct as $kdata){ ?>
                                            <th scope="row"><?php echo $reverse--;?></th>
                                            <th><?php echo $kdata->company_name ; ?></th>
                                            
                                            <td><?php echo $kdata->product_name ; ?></td>
                                            <td><?php echo $kdata->discount_per ; ?></td>
					<?php if($session->get('user_id')){?><td>
					<form method="post" class="change_userlevel" action="ProductController/status" onclick="getConfirmation('<?php echo $kdata->id ; ?>')">
                                        <input type="hidden" name="id" value="<?php echo $kdata->id; ?>">
					<?php if ($kdata->status == '1') { ?>
                                        <button type="submit" class="btn btn-success" name="status" id="submit-p" value="0">Approve</button>
					<?php } else { ?>
					<button type="submit" class="btn btn-danger" name="status" id="submit-p" value="1">  Block  </button>
					<?php } ?>
                                        </form>
					 </td><?php } ?>

                                          <?php if($session->get('employee_id')) { ?>
					   <td>   
						<a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ProductDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a> 
					   </td> <?php } else { ?> 

                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditProduct?id='.$kdata->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ProductDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a>  

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteProduct?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>                                
                                            </td> <?php } ?>                                           
                                        </tr>
                                        <?php } ?>
                                        
                                        
                                    </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                 <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Products', 'varExtra' => $searchArray)); ?>


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

    <script>
    $(document).ready(function () {
        $('#state').change(function () {
            var company_id = $('#state').val();
            var action = 'get_city';
            if (company_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/ProductController/action'); ?>",
                    method: "POST",
                    data: {company_id: company_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option value="">Select Branch</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + ' / ' + data[count].arb_branch_name + '</option>';
                        }
                        $('#city').html(html);
                    }
                });
            } else
            {
                $('#city').val('');
            }
        });
    });
</script>


<script type='text/javascript'>
  function getConfirmation(id)
  {
    if (id != '')
    {
        $.ajax({
          url: "<?=site_url('/index.php/ProductController/status');?>",
          type: "post",
          data: {'id' : id},
          success: function (response) {
            alert('success');
           location.reload();              
          }
      });
    }

}
</script>