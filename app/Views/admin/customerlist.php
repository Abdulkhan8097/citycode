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
            <div class="col-sm-4">
                <div class="page-title-box">
                    <h4 class="font-size-20"><?php echo $title; ?></h4>
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

                        <a href="AddCustomer" class="btn btn-primary waves-effect waves-light">
                            <i class="ion ion-md-add-circle-outline"></i> Add New Customer
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
                    <div class="col-lg-5">
                        <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by V.I.P Code, City Code, Full Name, Mobile, Email" >
                    </div>

                    <div class="col-lg-3">
                        <?php $customer_type = isset($searchArray['customer_type']) ? $searchArray['customer_type'] : ""; ?>
                        <select class="form-control" name="customer_type">
                            <option value="">-All Customers Type-</option>
                            <?php foreach ($customertype as $key => $value) { ?>
                                <option value="<?php echo $key ?>" <?php if ($customer_type == $key) {
                                echo "selected";
                            } ?>>
                                <?php echo $value; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-3">
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
                            <table class="table table-hover table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Sl. No.</th>
                                        <th scope="col">City Code</th>
                                        <th scope="col">VIP Code</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Mobile Number</th>
										<th scope="col">Gender</th>
										<th scope="col">Governorate</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        foreach ($customers as $kdata) {
                                            ?>
                                            <th scope="row"><?php echo $reverse-- ; ?></th>
                                            <td><?php echo $kdata->city_code; ?></td>
                                            <td><?php echo $kdata->vip_code; ?></td>
                                            <th><?php if ($kdata->name) {
                                                echo $kdata->name;
                                            } else if ($kdata->arb_name) {
                                                echo $kdata->arb_name;
                                            }
                                            ?></th>

                                            <td><?php echo $kdata->mobile; ?></td>
					    <td><?php echo $kdata->gender; ?></td>
					    <td>
                                            <?php foreach ($states as $row) {
                                                 if ($row['state_id'] == $kdata->stateid) { 
						 echo $row['state_name'] . ' / ' . $row["arb_state_name"]; } } ?>
				            </td>

                                           <?php if($session->get('employee_id')) { ?>
					     <td>   
						 <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CustomerDetails?id=' . $kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a>  
					   </td> <?php } else { ?> 

                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCustomer?id=' . $kdata->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a> 

                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CustomerDetails?id=' . $kdata->id); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a>  

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteCustomer?id=' . $kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a> 
												
						<?php if($customer_type == 'vip') { ?>
						    <button type="button" id="side-bar" class="btn btn-primary-btn" data-toggle="modal" data-target="#myModal" onclick="getVipList('<?php echo $kdata->id; ?>');"><img src="<?php echo base_url('companylist.jpg'); ?>"></button>
           
                                              <form method="post" class="change_userlevel" action="CustomerController/vip_plus" onclick="getConfirmation('<?php echo $kdata->id ; ?>')">
                                                <input type="hidden" name="id" value="<?php echo $kdata->id; ?>">

                                                <?php if ($kdata->vip_plus == 'true') { ?>
                                                   <a href="#" data-toggle="tooltip" title="VIP Plus Active"> 
                                                   <button type="submit" class="btn btn-primary-btn" name="vip_plus" id="side-bar" value="false">
                                                   <img src="<?php echo base_url('after-vip-plus.jpg'); ?>"></button> </a>
					        <?php } else { ?>
                                                     <a href="#" data-toggle="tooltip" title="No VIP Plus">
					             <button type="submit" class="btn btn-primary-btn" name="vip_plus" id="side-bar" value="true">
                                                      <img src="<?php echo base_url('befor-vip-plus.jpg'); ?>"></button></a>
                                                <?php } ?>
                                               </form>
                                            <?php } ?>
 
                                            </td> <?php } ?>                                            
                                        </tr>
                            <?php } ?>


                                </tbody>
                            </table>
<?php if ($pagination['haveToPaginate']) { ?>
                                <br>
    <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Customers', 'varExtra' => $searchArray)); ?>

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

<!------------ Modal ------------------->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="color:#000 !important;"> Company Name </h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form class="custom-validation" id ="edit_model" method='post' action="CompanyController/add_vip" enctype='multipart/form-data'>		 
                <input type="hidden" id="id" name="id" >

                <div class="modal-body" id="divListvip">
                    
                </div> <!-- end modal body-->
                
                <center><button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                        Submit
                    </button></center> <br>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- end modal content-->    
    </div><!-- modal-dialog -->
</div><!-- modal fade -->

<script>   
     function getVipList(companyid)
        { 
                     var request = $.ajax( {
                            url : "<?php echo site_url('getvipcompany?companyid='); ?>"+companyid,
                            cache: false,
                            contentType: false,
                            processData: false,
                            async: false,
                            type: 'GET',
                            
                            success: function(res) {
                            
                                $('#divListvip').html(res); 
                              
                            },
                            fail: function(res) {
                                errorFlag = true;
                                console.log(res);
                                
                            },
                            error: function(xhr, status, error) {
                                errorFlag = true;
                                var errorMessage = xhr.status + ': ' + xhr.statusText;
                                console.log('Error - ' + errorMessage);
                                
                            }
                        })

        }
        
        
    function assigncompany(comid)
    {
        $('#companyid').val(comid);
    }
    $(document).ready(function () {
        
        $('#editmodel').on('show.bs.modal', function (e) {
            if (e.namespace === 'bs.modal') {
                var opener = e.relatedTarget;
                var id = $(opener).attr('data-id');


                $('#edit_model').find('[name="id"]').val(id);

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
          url: "<?=site_url('/index.php/CustomerController/vip_plus');?>",
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

