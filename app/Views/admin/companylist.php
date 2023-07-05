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

    .tens{
        display:inline;
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20">Company List</h4>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">

                        <a href="AddCompany" class="btn btn-primary waves-effect waves-light">
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
            <div class="col-lg-5">
                <input class="form-control" name="txtsearch" type="text" value="<?php echo $txtsearch; ?>" placeholder="Search by Company Name, Mobile Number, Email" >
            </div>
            <div class="col-lg-3">
                <select class="form-control" name="search_priority" type="text">
                    <option value="">--Select Priority--</option>
                    <?php  foreach ($priorities as $key => $pvalue) {?>
                        <?php 
                        if ($pvalue == $search_priority) {?>
                            <option selected value="<?php echo $key;?>"><?php echo $pvalue;?></option>
                        <?php }else{?>
                            <option value="<?php echo $key;?>"><?php echo $pvalue;?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                 Submit
                </button>
                <a href="Company" class="btn btn-primary waves-effect waves-light mr-1">
                 Clear
                </a>
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
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                       
                                        foreach ($companylist as $kdata) {
                                            ?>
                                            <th scope="row"><?php echo $reverse--; ?></th>
                                            <th><?php echo $kdata['company_name']; ?></th>
                                            <td><?php echo $kdata['mobile']; ?></td>
                                            <td><?php echo $kdata['email']; ?></td>

                                          <?php if($session->get('employee_id')) { ?>
					   <td>   
					       <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CompanyDetails?id=' . $kdata['id']); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> 
                                                </a>  
					   </td> <?php } else { ?>
                                            <td>
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('EditCompany?id=' . $kdata['id']); ?>">
                                                    <i class="fas fa-edit"></i> 
                                                </a>
                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('CompanyDetails?id=' . $kdata['id']); ?>">
                                                    <i class="ion ion-md-add-circle-outline"></i> 
                                                </a>  

                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('DeleteCompany?id=' . $kdata['id']); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i> 
                                                </a> 

                                                <?php if ($kdata['vip_link'] == 'vip') { ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="getVipList('<?php echo $kdata['id']; ?>');">Link V.I.P Customer</button>                            
                                                <?php } else { ?> 
                                                <?php } ?>
                                            </td>  <?php } ?>                                          
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
                <h2 style="color:#000 !important;"> V.I.P Code </h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label tens" style="color:#000 !important;">&nbsp;&nbsp;Customer Name</label>
                <label for="inputPassword" class="col-sm-4 col-form-label tens" style="color:#000 !important;">V.I.P Code</label>
                <label for="inputPassword" class="col-sm-4 col-form-label tens" style="color:#000 !important;"> </label>
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
                            url : "<?php echo site_url('getvipcustomer?companyid='); ?>"+companyid,
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

