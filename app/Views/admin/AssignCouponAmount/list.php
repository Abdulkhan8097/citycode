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
                    <h4 class="font-size-20"><?php //echo $title; ?>View Assign Coupon List</h4>
                </div>
            </div>
               <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('addcouponamt'); ?>">
                                <i class="ion ion-md-add-circle-outline"></i> Add Assign Coupon
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
                                                   
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Company Name </label>
                                    <div class="col-md-12">
                                        <select class="form-control single" name="company_id" id="company_id" >
                                            
                                                <option value="">- Please Select -</option>
                                                
                                                <?php   foreach ($companies as $row) {  ?>
                                                <option value="<?php echo $row['id'] ?>"   <?php echo   (isset($searchArray['company_id']) && $row['id'] == $searchArray['company_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['company_arb_name'] ? $row['company_name'] . ' / ' . $row['company_arb_name'] : $row['company_name']; ?></option> 
                                                 <?php   }?>
                                        </select>  
                                    </div>
                                </div>       
                            </div>
                            
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Branch Name </label>
                                    <div class="col-md-12" id="divbranch">
                                        <select class="form-control"  name="branch_id" >
                                                <option value="">- Please Select -</option>
                                                <?php     if ($branches) {
                                                foreach ($branches as $row) {  ?>
                                                <option value="<?php echo $row['branch_id'] ?>"   <?php echo   (isset($searchArray['branch_id']) && $row['branch_id'] == $searchArray['branch_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['arb_branch_name'] ? $row['branch_name'] . ' / ' . $row['arb_branch_name'] : $row['branch_name']; ?></option> 
                                                 <?php   }}?>
                                                
                                        </select>  
                                    </div>
                                </div>       
                            </div> <br><br><br><br>
                         
                       
                            <div class="col-lg-1">
                                <div class="row">
                                </div><br />
                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                        Submit
                                    </button>
                                </div>
                            </div>


                            <div class="col-lg-1">
                                <div class="row">
                                </div><br />
                                <div class="col-md-2">
                                    <a href="<?php echo site_url('viewcouponamt'); ?>">
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
                                      
                                        <th class="text-center"  data-sortable="true">Company Name</th>
                                        <th class="text-center"  data-sortable="true">Branch Name</th>
                                      
                                        <th class="text-center"  data-sortable="true">Assign Amount</th>
                                     
                                        <th class="text-center"  data-sortable="true">Balance Amount</th>
                                        <th class="text-center"  data-sortable="true">Coupon Amount<br>Assigned Date</th>
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        // echo"<pre>";
                                        // var_dump($total_balance);DIE;
                                        // $sum=0;
                                        $i=0;
                                        foreach ($list as $kdata) {
                                            // $sum+=$kdata->assign_amount;
                                            $i++
                                            ?>
                                            <th class="text-center"><?php echo $i; ?></th>
                                           
                                            <td class="text-center"><?php echo $kdata->company_name;?></td>
                                            <td class="text-center"><?php echo $kdata->branch_name;?></td>
                                            <td class="text-center"><?php echo $kdata->assign_amount;?></td>
                                             <td class="text-center"><?php  echo $kdata->bal_amount;?></td>
                                             <td class="text-center"><?php  echo $kdata->created;?></td>
                      
                           
                             
                                            <td class="text-center">
                                            
                                               

                                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('assigndetailscoupon?id=' . $kdata->id); ?>" title="view">
                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                </a>  
                                               <!--    <a class="btn btn-primary waves-effect waves-light" href="<?php //echo site_url('addcoupon?id=' . $kdata->id); ?>" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>  -->

                                            <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('Coupon/deletecoupon?id=' . $kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>  
                                                
                        
 
                                            </td>                                           
                                        </tr>
                            <?php } ?>


                                </tbody>
                            </table>
<?php if ($pagination['haveToPaginate']) { ?>
                                <br>
    <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'getorders', 'varExtra' => $searchArray)); ?>

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
                    url: "<?php echo site_url('OnlineShopping/getBranch'); ?>?company_id="+compant_id,
                    method: "GET",
                    dataType: "JSON",
                    success: function (data)
                    {
                        
                        var html = '<select class="form-control single"  name="branch_id" > <option value="">Select Branch</option>';

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


