
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
                         <form class="custom-validation"  method='post' action="NotificationController/add_notification" enctype='multipart/form-data'>	
                            <?php if (!$session->get('company_id')) {?>
                               <div class="form-group row">
                                    <label  class="col-sm-2 ml-4 col-form-label">Interest<span class="mandatory">*</span></label>
                                    <div class="col-sm-8">
                        				<div class="row">
                            				<div class="col-sm-1 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
                            				<div class="col-sm-8 border float-lg-right">Select all</div>
                        				</div>
                                        <?php  foreach ($interests as $item) { ?>
                                           <div class="row">
                                               <div class="col-sm-1 border float-left"><input type="checkbox" required name="interest[]" class="checkhour" value="<?php echo $item['cat_id']; ?>" ></div>
                                               <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_name']; ?></div>
                                               <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_arbname']; ?></div>                                   
                                           </div>	 
                                        <?php }?>   
                                    </div>
                                </div>
    					    <?php } ?>
                             
                             <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="gender" >
                                            <option value="">- All-</option>
                                            <option value="Male" > Male </option>
                                            <option value="Female" > Female </option>
                                        </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">Governorate</label>
                                <div class="col-sm-6">
                                    <select name="stateid" id="state" class="form-control input-lg" >
                                            <option value="">- All -</option>
                                            <?php
                                            foreach ($states as $row) { ?>
                                                <option value="<?php echo $row['state_id'] ?>"  <?php echo   (isset($searchArray['stateid']) &&  $searchArray['stateid'] ==$row['state_id']) ? "Selected" : ""; ?> ><?php echo $row['state_name']; ?></option>

                                            <?php } ?>
                                        </select> 
                                </div>
                            </div>
                             
                             <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-6">
                                    <select name="cityid" id="city" class="form-control input-lg">
                                            <option value="">--All -- </option>

                                            <?php
                                            foreach ($cities as $row) { ?>
                                                <option value="<?php echo $row['city_id'] ?>"  <?php echo   (isset($searchArray['cityid']) &&  $searchArray['cityid'] ==$row['city_id']) ? "Selected" : ""; ?>><?php echo $row['city_name']; ?></option>

                                            <?php } ?>
                                        </select> 
                                </div>
                            </div>
                              <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">language</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="language" >
                                            <option value="">- All-</option>
                                            <option value="english" > English </option>
                                            <option value="arabic" > Arabic </option>
                                        </select>
                                </div>
                            </div>
					
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Title<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  class="form-control" name="title" cols="6" rows="4" required></input>
                                </div>
                            </div>
                              <div class="form-group row">
                           <label for="inputPassword" class="col-sm-2 col-form-label">In App</label>
                           <div class="col-sm-1">
                              <!--<input type="checkbox" name="in_app" value="true">-->
                              <input type="checkbox" name="in_app" value="true" onclick="javascript:yesnoCheck(); " id="yesCheck">                                   
                           </div>
                        </div>

                            <div class=" form-group row"  id="ifYes" style="visibility:hidden">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Company Name<span class="mandatory"></span></label>
                                <div class="col-sm-6">
                                   <select name="company_id" class="form-control input-lg">
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

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Image<span class="mandatory"></span></label>
                                <div class="col-sm-6">
                                    <input type="file" name="notifyimage[]"  class="form-control">
                                </div>
                            </div>
                             
                             <div class="form-group row">
                                <label  class="col-sm-2 col-form-label">Image Url</label>
                                <div class="col-sm-6">
                                    <input type="text"  class="form-control" name="imageurl" cols="6" rows="4" ></input>
                                </div>
                            </div>

                                       <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Description<span class="mandatory"></span></label>
                                <div class="col-sm-6">
                                 <textarea class="form-control" name="description" cols="6" rows="4" ></textarea> 



<!--Include the JS & CSS-->
<!-- <link rel="stylesheet" href="<?php //echo base_url('admin/richtexteditor/rte_theme_default.css'); ?>" />
<script type="text/javascript" src="<?php //echo base_url('admin/richtexteditor/rte.js');?>"></script>
<script type="text/javascript" src="<?php //echo base_url('admin/richtexteditor/plugins/all_plugins.js');?>"></script>
 <textarea id="div_editor1" name="description" ></textarea>

<script>
    var editor1cfg = {}
    editor1cfg.toolbar = "basic";
    var editor1 = new RichTextEditor("#div_editor1", editor1cfg);
</script> -->

                                </div>
                            </div>   
							  
                			 <div class="form-group row mb-0">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                                Submit
                                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('Notifications');?>">
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
                <h4 class="font-size-20">Notifications</h4>
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
                                            <th data-sortable="true" >SI. No.</th>
                                            <?php if (!$session->get('company_id')) {  ?>                        
                                                <th data-sortable="true">Interest</th>
                                            <?php } ?>
                                            <th data-sortable="true">Title</th>
                                            <th data-sortable="true">Description</th>
                                            <?php if (!$session->get('company_id')) {  ?>                        
                                                <th data-sortable="true">Status</th>
                                            <?php } ?>
                                            <th data-sortable="true">Date</th>
                			                 <th scope="col" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        helper('text');
                                        foreach($results as $row){ ?>
                                            <tr>
                                                <th scope="row"><?php echo ++$i; ?></th>
                                                <?php if (!$session->get('company_id')) {  ?>                        
                                                    <td> <?php $gidz=explode(',',$row->interest);
                                                        $k=1;
                                                        foreach ($interests as $item) { 
                                                            if ($k <= 4) {
                                                                if(in_array($item['cat_id'],$gidz)){
                                                                    echo character_limiter($item['cat_name'],10) ;?>, <?php 
                                                                }
                                                            }else{
                                                                break;
                                                            }
                                                            $k++;
                                                        }?> 
                                                    </td>
                                                <?php } ?>
                                                <td><?php echo substr($row->title,0,20); ?></td>
                            		            <td><?php echo character_limiter($row->description,10); ?></td>

                                                <?php if(!$session->get('company_id')){?><td>
                                                        <form method="post" class="change_userlevel" action="NotificationController/status"onclick="getConfirmation('<?php echo $row->id ; ?>')">
                                                                            <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                                        <?php if ($row->aprove_status == '1') { ?>
                                                                            <button type="submit" class="btn btn-success" name="status" id="submit-p" value="0">Approve</button>
                                                        <?php } else { ?>
                                                        <button type="submit" class="btn btn-danger" name="status" id="submit-p" value="1">  Block  </button>
                                                        <?php } ?>
                                                    </form>
                                                </td><?php } ?>
                        								
                                                <td><?php echo $row->created_date; ?></td>
                                                <td>
                                                    <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('Notification_details?id='.$row->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> </a>
                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('NotificationDelete?id=' . $row->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
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
<script type='text/javascript'>
  function getConfirmation(id)
  {
    if (id != '')
    {
        $.ajax({
          url: "<?=site_url('/index.php/NotificationController/status');?>",
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
<script>
    $(document).ready(function () {

        $('#state').change(function () {

            var state_id = $('#state').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo site_url('ReportController/action'); ?>",
                    method: "POST",
                    data: {state_id: state_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option value="">Select State</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            html += '<option value="' + data[count].city_id + '">' + data[count].city_name + '</option>';
                        }

                        $('#city').html(html);
                    }
                });
            } else
            {
                $('#city').val('');
            }

        });
        
        
        $('#company_id').change(function () {

            var compant_id = $('#company_id').val();

            var action = 'getbranch';

            if (compant_id != '' && compant_id != 'city_code')
            {
                $.ajax({
                    url: "<?php echo site_url('ReportController/getBranch'); ?>?company_id="+compant_id,
                    method: "GET",
                    dataType: "JSON",
                    success: function (data)
                    {
                        
                        var html = '<select class="form-control" name="branch_id" name="branch_id" > <option value="">Select Branch</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            if(data[count].arb_branch_name)
                            {
                            html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name+"/"+data[count].arb_branch_name + '</option>';
                            }
                            else
                            {
                             html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + '</option>';
                            }
                        }
                    
                        $('#divbranch').html(html);
                    }
                });
            } else
            {
                $('#divbranch').val('');
            }

        });

    });

</script>

<script type="text/javascript">
    function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
        document.getElementById('ifYesno').style.visibility = 'hidden';
    }
    else document.getElementById('ifYes').style.visibility = 'hidden';
    document.getElementById('ifYesno').style.visibility = 'visible';

}
</script>
