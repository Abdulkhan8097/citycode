<style>
.mandatory {
     display:inline;
     color:red;
 }
  
.col-sm-4 { 
   color: #000;
}
.col-sm-8{ 
   color: #000;
}
.font-size-20{
color: #000;
}
label{
color: #000 !important;
}
 .btn-primary{
color: #000 !important;
}
.table td {
padding: .30rem;
</style>

<script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
<?php $session = session(); ?>
	
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">                  
                    <div class="card-body"> 
			             <?php echo view('admin/_topmessage'); ?>
                         <form class="custom-validation"  method='post' action="CustomOfferController/AddCustomOffer" enctype='multipart/form-data'>	
					
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Custom Offer<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Custom Offer"  class="form-control" name="st_name" cols="6" rows="4" required></input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Arabic Custom Offer<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Arabic Custom Offer "  class="form-control" name="st_arb_name" cols="6" rows="4" required></input>
                                </div>
                            </div>

                			 <div class="form-group row mb-0">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                                Submit
                                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('MallDetails');?>">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1">Clear</button>
                                    </a>
                                </div>
                          </div>								      
                       </form>					
    		       </div> 
                </div>
           </div>  
        </div> 
    </div>
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-20">Custom Offer List</h4>
            </div>
        </div>
   </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">            
        	      <div class="tab-content">
            	       <div class="card-body">
                            <div class="table-responsive">
                			   <table data-toggle="table" data-striped="true" class="table table-striped table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true">SI. No.</th>
                                            <?php if (!$session->get('company_id')) {  ?>                        
                                                <th data-sortable="true">Custom Offer</th>
                                                <th data-sortable="true">Arabic Custom Offer</th>
                                            <?php } ?>
                			                 <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        foreach($results as $row){ ?>
                                            <tr>
                                                <th scope="row"><?php echo ++$i; ?></th>
                                               
                                                <td><?php echo substr($row->st_name,0,40); ?></td>
                            		            <td><?php echo substr($row->st_arb_name,0,40); ?></td>
                                                <td>
                                                    <a class="btn btn-dark waves-effect waves-light"  href="<?php echo site_url('EditCustomOffer?id='.$row->st_id); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CustomOffer_Details?id='.$row->st_id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> </a>
                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('CustomOfferDelete?id=' . $row->st_id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table> 
                                <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Notifications', 'varExtra' => $searchArray)); ?>
                                <?php }?>
                            </div>                   
                        </div>
            	   </div>
                </div>
    	    </div>
        </div>
    </div> 
</div>
<script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>
