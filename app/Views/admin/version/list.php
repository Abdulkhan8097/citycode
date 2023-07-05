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

#side-bar img{
float:right !important; 
height:35x; 
width:35px;

}

.btn-primary-btn{
background:#FFFFFF;
border:none;
padding:1px;
}
.change_userlevel{
display:inline !important;}


</style>

   
<div class="page-content">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20"><?php echo $pagetitle; ?></h4>
                </div>
            </div>
               <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('addversion'); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Add Version
                            </a>
                        </div>
                    </div>
                </div>

            <div class="col-sm-8">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">

<!--                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Customer List
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="Customers">All Customer List</a>
                            <a class="dropdown-item" href="Customer_List">Customer List</a>
                            <a class="dropdown-item" href="VipCustomers">V.I.P Customer List</a>
                        </div>-->

                       <!--  <a href="AddCustomer" class="btn btn-primary waves-effect waves-light">
                            <i class="ion ion-md-add-circle-outline"></i> Add New Customer
                        </a> -->
<!-- 
                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                            <i class="ion ion-md-arrow-back"></i> Back
                        </a> -->

                    </div>
                </div>
            </div>
        </div>

        <!-------------------------------- search --------------------------->
       
       
                    
            </div>
              <div class="row">
        <form action="" id="adminsearch">
            <div class="col-xl-12">
                <div class="card">                  
                    <div class="card-body">                           
                        <!-- Search  row -->

                        <div class="row ">                             
                                                   
                            <div class="col-lg-5">
                                <div class="row">
                                    <label></label>
                                    <div class="col-md-12">
                                         <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search Version no" >
                                    </div>
                                </div>       
                            </div>
                            
                            <div class="col-lg-2">
                                <div class="row">
                                </div>
                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                        Submit
                                    </button>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <div class="row">
                                </div>
                                <div class="col-md-2">
                                    <a href="<?php echo site_url('listversion'); ?>">
                                        <button type="button" class="btn btn-primary waves-effect waves-light mr-1">
                                            Refresh
                                        </button></a>
                                </div>
                            </div>

                        </div>                              
                    </div> <!-- end row --> 
                    
                    <!-- end row -->
                </div>
            </div><!-- end card -->
        </form> 
    </div>
      
         

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
<?php echo view('admin/_topmessage'); ?>
                    <div class="card-body">
                       <?php if($pagination["getNbResults"] >0 ){ ?>
                        <div class="table-responsive">
                            <table  data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" data-sortable="true">Sl.No.</th>
                                      
                                        <th class="text-center"  data-sortable="true">Version no</th>
                                        <th class="text-center"  data-sortable="true">Created</th>
                                      
                                    
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                      
                                        $i=0;
                                        foreach ($list as $kdata) {
                                            // $sum+=$kdata->assign_amount;
                                            $i++
                                            ?>
                                            <th class="text-center"><?php echo $i; ?></th>
                                           
                                            <td class="text-center"><?php echo $kdata->version_no   ;?></td>
                                        
                                          
                                             <td class="text-center"><?php  echo $kdata->created;?></td>
                      
                           
                             
                                            <td class="text-center">
                                            
                                               


                                            <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('VersionControl/delete?id=' . $kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>  
                                                
                        
 
                                            </td>                                           
                                        </tr>
                            <?php } ?>


                                </tbody>
                            </table>
<?php if ($pagination['haveToPaginate']) { ?>
                                <br>
    <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'listversion', 'varExtra' => $searchArray)); ?>

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

