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

  .circular_image {
    transition: transform .2s; 
    width: 50%;
  /*  height: 59px;*/
    margin-left: 24px;
  /*border-radius: 50%;*/
  overflow: hidden;
  background-color: blue;
 
  display:inline-block;
  vertical-align:middle;
    }
.circular_image:hover {
  transform: scale(2.2); 
    }

}


</style>

    <div class="page-content">
        <?php   $session = session(); ?>
         <?php if ($session->get('company_id')){ ?>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Company Banner</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">

                            <a href="AddBanner" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> Add New
                            </a>

                            <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                <i class="ion ion-md-arrow-back"></i> Back
                            </a>

                       </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
						<?php if($pagination > 0 ){ ?>
                            <div class="table-responsive">
                                <table data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center"  data-sortable="true">(#) Sl. No.</th>
                                            <th class="text-center"  data-sortable="true">Banner Type</th>
                                           <th class="text-center"  data-sortable="true">File Name</th> 
                                            <th class="text-center"  data-sortable="true">Company Banner</th>
                                            <th class="text-center" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <tr>
                                        <?php 
                                        $reverse =count($banners) ;
                                            foreach($banners as $kdata){ ?>
                                            <th class="text-center"><?php echo $reverse--;?></th>
                                            <th class="text-center">Company Banner</th>
                                      <td class="text-center"><?php echo $kdata->banner ; ?></td>                                              
                                            <td class="text-center"><img class=" user-avatar circular_image" alt="" src="<?php echo (isset($kdata->banner)) ? base_url('company').'/'. $kdata->banner : ''; ?>" height="70px;"></td>                                            
                                            <td class="text-center">
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditBanner?id='.$kdata->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>											

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('Delete?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a> 											 																					                               
                                            </td>                                            
                                        </tr>										
										 
                                        <?php } ?>                                                                                
                                </tbody>
                                </table>
                               <!--  <?php if ($pagination) { ?>
                                <br>
                                <?php //echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'adminlist', 'varExtra' => $searchArray)); ?>

                                <?php } ?>
                            </div>
							<?php //}else{ ?>
                            <?php //echo view('admin/_noresult'); ?>
                        <?php } ?> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content -->  
     <?php } else {?>
         <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Company Banner</h4>
                    </div>
                </div>

              
            </div>
            <!-------------------------------- search --------------------------->
<div class="container">
    <form action="">
         <div class="row"> 
            <div class="col-lg-4">
                <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Company Name" >
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
                        <?php if($pagination["getNbResults"] > 0 ){ ?>
                            <div class="table-responsive">
                               <table  data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0 ">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-sortable="true">(#) Sl. No.</th>
                                            <th scope="col" data-sortable="true">company name</th>
                                            <th scope="col" data-sortable="true">Type</th>
                                            <th scope="col" data-sortable="true">banner</th>
                                            <?php if($session->get('user_id')){?>
                                            <th scope="col" data-sortable="true">Status</th> <?php } ?>
                                            <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        <tr>
                                        <?php 
                                        $i=0;
                                            foreach($list as $kdata){ $i++?>
                                            <th scope="row"><?php echo $i;?></th>
                                            <th scope="row"><?php echo $kdata->company_name; ?></th>
                                            <th>Company Banner</th>
                                            <td><?php echo $kdata->banner; ?></td>                                            
                                             <?php if($session->get('user_id')){?><td  scope="row">
                                            <form method="post" class="change_userlevel" action="AboutCompany/status" onclick="getConfirmation('<?php echo $kdata->id ; ?>')">
                                                                <input type="hidden" name="id" value="<?php echo $kdata->id; ?>">
                                            <?php if ($kdata->b_status == '0') { ?>
                                                                <button type="submit" class="btn btn-success" name="status" id="submit-p" value="1">Approve</button>
                                            <?php } else { ?>
                                            <button type="submit" class="btn btn-danger" name="status" id="submit-p" value="0">  Block  </button>
                                            <?php } ?>
                                                                </form>
                                             </td><?php } ?>                                            
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditBanner?id='.$kdata->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>                                            

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('Delete?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>                                                                                                                                                               
                                            </td>                                            
                                        </tr>                                       
                                         
                                        <?php } ?>                                                                                
                                </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Banners', 'varExtra' => $searchArray)); ?>

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
       
    <?php    }?>

    <script type='text/javascript'>
          function getConfirmation(id)
          {
            if (id != '')
            {
                $.ajax({
                  url: "<?=site_url('/index.php/AboutCompany/status');?>",
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

