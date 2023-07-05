
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

label{
color: #000 !important;}
</style>

   <script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
		
     <div class="page-content">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-20">Notification View User List</h4>
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


	               <form action="">
<div class="col-xl-12">
<div class="row">

 <div class="col-lg-4">
                                    <div class="row">					
                                        <div class="col-md-12">
                                        <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Name CityCode" >
                                        </div>
                                    </div>       
                                </div>	
																                              													
                                <div class="col-lg-2">
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                  
                                    </div></div></form><br>	 
 
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="card-body">
 
                        <?php if($pagination["getNbResults"] >0 ){ ?>
                            <div class="table-responsive">
                                <table data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap ">
                                    <thead>
                                        <tr>
                                            <th   data-sortable="true">Sl. No.</th>
                                            <th   data-sortable="true" >Customer Name</th>
                                            <th   data-sortable="true" >CityCode</th>
                                            <th data-sortable="true">Notification Title</th>
                                            <th data-sortable="true">Notification description</th>
                                            <th   width="10%" class="text-center">Action</th>                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                                                               
                                           <tr>
                                            <?php helper('text');
                                            foreach($results as $kdata){ ?>
                                            <th  ><?php echo $reverse-- ; ?></th>
                                            <th ><?php echo $kdata->name ; ?></th>
                                            <th ><?php echo $kdata->city_code ; ?></th>  
                                            <th ><?php echo $kdata->title ; ?></th>
                                            <th ><?php echo $kdata->description ; ?></th>
                                        
                                            <td class="text-center">

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('NotificationController/viewnoticationdelete?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> 
                                                </a> 
                                
                                            </td>                                            
                                        </tr> 
                                       <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($pagination['haveToPaginate']) { ?>
                                <br>
                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => $action, 'varExtra' => $searchArray)); ?>

                                <?php } ?>
                            </div>
                        <?php }else{ ?>
                            <?php echo view('admin/_noresult'); ?>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </div>
	
	

   
