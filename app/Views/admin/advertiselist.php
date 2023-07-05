
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
<?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">

 <?php if($session->get('company_name')) { ?>
       <h4 class="font-size-20">Banners List</h4>
<?php } else { ?>
       <h4 class="font-size-20">City Code Banners List</h4>
<?php } ?>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="add_new" class="btn btn-primary waves-effect waves-light">
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
                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Banner Type, Banner Name" >
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
                                            <th class="text-center" data-field="Sl. No." data-sortable="true">Sl. No.</th>
                                     
                                            <th class="text-center" data-field="Banner Type" data-sortable="true">Banner Type</th>
                                            <th class="text-center" data-field="Banner Name" data-sortable="true">Banner Name</th>
                                            <th class="text-center" data-field="Start Date" data-sortable="true">Start Date</th>
                                            <th class="text-center" data-field="End Date" data-sortable="true">End Date</th>
                                            <th class="text-center" data-field="Url" data-sortable="true">Url</th>
                        <th class="text-center"  data-field="Count" data-sortable="true">Count</th>
                                            <?php if($session->get('user_id')){?>
                                            <th class="text-center">Status</th> <?php } ?>

                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

 <tbody>
                                        <tr>
                                            <?php  
                                            if(!empty($lists)){ foreach($lists as $list){ ?>
                                            <th class="text-center"><?php echo $reverse--;?></th>                                           
                                              <td class="text-center"> <?php echo $list->banner_type;?> </td>
                                              <td class="text-center"> <?php echo $list->company_name;?> </td>
                                              <td class="text-center"> <?php echo $list->start_date;?></td>
                                              <td class="text-center"> <?php echo $list->end_date;?></td>
                                              <td class="text-center"> <?php echo substr($list->url,30);?></td>
					      <td class="text-center"> <?php echo $list->count;?></td>
                                              <?php if($session->get('user_id')){?><td class="text-center">
                                            <form method="post" class="change_userlevel" action="AdvertisementController/status" onclick="getConfirmation('<?php echo $list->id ; ?>')">
                                                                <input type="hidden" name="id" value="<?php echo $list->id; ?>">
                                            <?php if ($list->status == '1') { ?>
                                                                <button type="submit" class="btn btn-success" name="status" id="submit-p" value="0">Approve</button>
                                            <?php } else { ?>
                                            <button type="submit" class="btn btn-danger" name="status" id="submit-p" value="1">  Block  </button>
                                            <?php } ?>
                                                                </form>
                                             </td><?php } ?>
                                             <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditAdvertisement?id='.$list->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteAdvertisement?id='.$list->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>                               
                                            </td>                                            
                                        </tr>
                                        <?php } }?>
                                        
                                        
                                    </tbody>
                               </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                 <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Advertisement', 'varExtra' => $searchArray)); ?>
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
    <script type='text/javascript'>
          function getConfirmation(id)
          {
            if (id != '')
            {
                $.ajax({
                  url: "<?=site_url('/index.php/AdvertisementController/status');?>",
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

    </div>
    <!-- End Page-content -->  

    