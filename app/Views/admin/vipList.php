
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
                        <h4 class="font-size-20">V.I.P Code List</h4>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
<a href="addorganization" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> Add Organization
                            </a>


                            <a href="AddVipCode" class="btn btn-primary waves-effect waves-light">
                                <i class="ion ion-md-add-circle-outline"></i> Add New
                            </a>

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
                                        <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by V.I.P Code" >
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
                                <table data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th  data-field="Sl. No." data-sortable="true">Sl. No.</th>
                                            <th   data-field="V.I.P/Organization  Code" data-sortable="true" >V.I.P/Organization  Code</th>
                                            <th  data-field="Status" data-sortable="true">Status</th>
                                            <th   width="10%" class="text-center">Action</th>                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                                                               
                                           <tr>
                                            <?php foreach($lists as $kdata){ ?>
                                            <th  ><?php echo $reverse-- ; ?></th>
                                            <th ><?php echo $kdata->vip_code ; ?></th>
                                            <td ><?php if($kdata->status) { 
                                                 echo 'Unused'; } else { echo 'Used'; } ?></td>
                                            <td class="text-center">

                                                 <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('VipCodeDetails?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> 
                                                </a> 
                       &nbsp;&nbsp;
                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteVipCode?id='.$kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> 
                                                </a> 
 <?php if($kdata->type=='org'){?>
                                             <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('allorganization?id='.$kdata->id); ?>">
                                                    <i class="ion ion-md-aperture"></i> 
                                                </a>
                                                   <?php } ?>                                    
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
	
	
	<script>
$(document).ready(function(){
	
    $('#state').change(function(){

        var state_id = $('#state').val();

        var action = 'get_city';

        if(state_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/ReportController/action'); ?>",
                method:"POST",
                data:{state_id:state_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select State</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
                    }

                    $('#city').html(html);
                }
            });
        }
        else
        {
            $('#city').val('');
        }

    });

});

</script>

   
<script>
function showhideSearch()
{ 
    //alert($('#extrasearch').css("display"));
    
    if($('#extrasearch').css("display") == "none"){ 
        $('#searchupdownicon').removeClass( "fas fa-angle-down" );
         $('#searchupdownicon').addClass( "fas fa-angle-up" );
         
    }else {
       
        $('#searchupdownicon').removeClass( "fas fa-angle-up" );
         $('#searchupdownicon').addClass( "fas fa-angle-down" );
    }
    $('#extrasearch').toggle(1000);
}
</script>