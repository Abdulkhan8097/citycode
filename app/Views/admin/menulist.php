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

.btn-success{
    background:#228B22;
}

</style>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Menu List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="AddMenu" class="btn btn-primary waves-effect waves-light">
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
                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Company Name, Product Name" >
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
                            <div class="table-responsive">
                                <table data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-field="Sl. No." data-sortable="true">Sl. No.</th>
                                            <th scope="col" data-field="Company Name" data-sortable="true">Company Name</th>
                                           
                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <?php  $i=0; 
                                            foreach($allmenus as $kdata){ ?>
                                            <th scope="row"><?php echo ++$i;?></th>
                                            <th><?php echo $kdata->company_name ; ?></th>
                                            
				
                                            <td>

                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditMenu?id='.$kdata->id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('MenuDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> View Details
                                                </a>  

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteMenu?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>                                
                                            </td>                                            
                                        </tr>
                                        <?php } ?>
                                        
                                        
                                    </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                 <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Products', 'varExtra' => $searchArray)); ?>


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