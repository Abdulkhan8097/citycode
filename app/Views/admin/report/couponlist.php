<?php $session = session(); ?>

<style type="text/css">
    .table{
        width:36%!important;
    }
</style>
<div class="page-content">
    


        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20" style="color: black;">Coupon Report</h4>
                </div>
            </div>
        </div>



        <div class="container">
           
 <style>

    .nav-link{
        background-color:#fff !important;  
        color: #000 !important;
        font-size: 18px;
    }

    a.active{
        background-color:#F6D000 !important;  
        font-size: 18px;  
    }

    .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover{
    border-color: #e9ecef #e9ecef #ced4da;
    background-color: #f6d000!important;
}
.nav-tabs a.active {
    background-color: #f6d000!important;
}

</style>   
<?php

$router = service('router');
$method = $router->methodName();
?>
 

    <div class="row">
        <form action="" id="adminsearch">
            <div class="col-xl-12">
                <div class="card">                  
                    <div class="card-body">                           
                        <!-- Search  row -->

                        <div class="row ">                             
                            <div class="col-lg-3 ">
                                <div class="form-group">
                              
                                    <label> Start Date </label>
                                  
                                        <input class="form-control" name="start_date" type="date" value="<?php  echo isset($searchArray['start_date']) ? $searchArray['start_date'] : "" ?>" placeholder="Search by start date" >  
                                        </div>   
                            </div>                              

                            <div class="col-lg-3 ">
                                <div class="form-group">
                              
                                    <label> End Date </label>
                                  
                                        <input class="form-control" name="end_date" type="date" value="<?php echo isset($searchArray['end_date']) ? $searchArray['end_date'] :''; ?>" placeholder="Search by end date" >
                                    </div>
                                 
                            </div>
                              <?php if ($session->get('user_id')){ ?>

                            <div class="col-lg-3 ">
                                <div class="form-group">
                               
                                    <label> Company Name </label>
                                   
                                        <select class="form-control single" name="company_id" id="company_id" >
                                            
                                                <option value="">- Please Select -</option>
                                               
                                                <?php   foreach ($companies as $row) {  ?>
                                                <option value="<?php echo $row['id'] ?>"   <?php echo   (isset($searchArray['company_id']) && $row['id'] == $searchArray['company_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['company_arb_name'] ? $row['company_name'] . ' / ' . $row['company_arb_name'] : $row['company_name']; ?></option> 
                                                 <?php   }?>
                                        </select>  
                                    </div>
                                         
                            </div>
                             <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Branch Name </label>
                                    <div class="col-md-12" id="divbranch">
                                        <select class="form-control" name="branch_id" name="branch_id" >
                                                <option value="">- Please Select -</option>
                                                <?php   foreach ($branches as $row) {  ?>
                                                <option value="<?php echo $row['branch_id'] ?>"   <?php echo   (isset($searchArray['branch_id']) && $row['branch_id'] == $searchArray['branch_id']) ? "Selected" : ""; ?>>
                                                            <?php echo $row['arb_branch_name'] ? $row['branch_name'] . ' / ' . $row['arb_branch_name'] : $row['branch_name']; ?></option> 
                                                 <?php   }?>
                                                
                                        </select>  
                                    </div>
                                </div>       
                            </div>
                                   <?php } ?>

                            <div class="col-lg-3 ">
                                <div class="form-group">
                                
                                    <label> Coupon Name </label>
                                   
                                        <input class="form-control" name="coupon_name" type="text" value="<?php echo !empty($searchArray['coupon_name']) ?   $searchArray['coupon_name'] : ""; ?>" placeholder="Search by Coupon Name" >
                                    </div>
                                   
                                  
                            </div>
                             <div class="col-lg-3 ">
                                <div class="form-group">
                               
                                    <label> Coupon Amount  </label>
                                   
                                        <input class="form-control" name="coupon_amount" type="text" value="<?php echo !empty($searchArray['coupon_amount']) ?   $searchArray['coupon_amount'] : ""; ?>" placeholder="Search by Coupon Amount" >
                                    </div>
                                         
                            </div>

                                <div class="col-lg-3 " style="margin-top: 2.5%;">
                                <div class="form-group">
                                      <button type="submit" class="btn btn-3d btn-primary waves-effect waves-light"><i
                  class="fa fa-save"></i>
               Submit</button>&nbsp;&nbsp;&nbsp;
                               

               <a type="reset" class="btn btn-3d btn-primary waves-effect waves-light "  href="<?php echo site_url($pageurl); ?>"><i
                  class="fa fa-redo"></i>
               Reset</a>
             
           </div>
       </div>
                 
                            
                      
                            
                        </div><!-- first row end here--> 
                          <div class="row">
               <div class="text-center">
            
               </div>
               </div>

             

                       
             


                        <!--     <div class="col-lg-">
                                <div class="row">
                                </div><br />
                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                        Submit
                                    </button>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <div class="row">
                                </div><br />
                                <div class="col-md-2">
                                    <a href="<?php echo site_url($pageurl); ?>">
                                        <button type="button" class="btn btn-primary waves-effect waves-light mr-1">
                                            Refresh
                                        </button></a>
                                </div>
                            </div> -->

                                                     
                    </div> <!-- end row --> 
                    
                    <!-- end row -->
                </div>
            </div><!-- end card -->
        </form> 
    </div>

<ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a  id="Tab1" class="nav-link <?php if($method == 'clist'){ echo "active"; }?>" onclick="customersearch()" href="javascript::void(0);">Purchase Coupon</a>
                </li>
                <li class="nav-item">
                    <a id="Tab2" class="nav-link  <?php if($method == 'couponreportsredeem'){ echo "active"; }?>" onclick="companysearch()"   href="javascript::void(0);">Redeem Coupon</a>
                </li>
                 <li class="nav-item">
                    <a id="Tab2" class="nav-link  <?php if($method == 'couponreportexpire'){ echo "active"; }?>" onclick="couponexpire()"   href="javascript::void(0);">Expired Coupon</a>
                </li>
               
            </ul>
 

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


<script>
    
    function customersearch()
    {
        $('#adminsearch').attr('action', "<?php echo site_url('couponreports');?>");
         $("#adminsearch").submit();
    }
    
    function companysearch()
    { 
        $('#adminsearch').attr('action', "<?php echo site_url('couponreportsredeem');?>");
         $("#adminsearch").submit();
    }

     function couponexpire()
    { 
        $('#adminsearch').attr('action', "<?php echo site_url('couponreportexpire');?>");
         $("#adminsearch").submit();
    }
    
  
  
</script>

            <!-- Tab panes -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active">
                                <div class="card-body">
                                     <?php if($pagination["getNbResults"] >0 ){ ?>

                                    <div class="table-responsive">
                                        
                                           <table data-toggle="table" data-striped="true" class="table table-striped table-centered table-nowrap mb-1">
                                                <thead>
                                                    <tr>
                                                       <th data-sortable="true">Serial<br>No.</th>
                                                        <th  data-sortable="true">Customer<br>Name</th>
                                            <th  data-sortable="true" >company<br>Name</th>
                                            <th  data-sortable="true" >Branch<br>Name</th>
                                                        <th  data-sortable="true">Coupon<br>Name</th>
                                                        <th  data-sortable="true">Coupon<br>Amount</th>
                                                         <th  data-sortable="true">Coupon<br>Price</th>
                                                          <th  data-sortable="true">Coupon<br>Vat(5%)</th>
                                                        <th  data-sortable="true">Product<br>Price</th>
                                                       
                                                        <th  data-sortable="true">Paid<br>Amount</th>
                                                        
                                                        <th  data-sortable="true">Coupon<br>Status</th>
                                                        <th  data-sortable="true">Transaction<br>Date</th>
                                                       
                                                        
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   $i = 0;
                                                    $save_amt = 0;
                                                    $price = 0;
                                                    $paid_amt = 0;
                                                    $coamt = 0;
                                                  
                                                    foreach ($coupon_purchase as $kdata) { 
                                                        $percentage = 5;
                                                        $totalprice=$kdata->coupon_price;
                                                        $vat = ($percentage / 100) * $totalprice;

                                                     ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$startLimit ; ?></th>
                                                            <td><?php echo $kdata->name; ?></td>
                                                          
                                                        <td><?php echo $kdata->company_name; ?></td>
                                                        <td><?php echo $kdata->branch_name; ?></td>
                                                            <td><?php echo $kdata->coupon_name; ?></td>
                                                            <td><?php echo $kdata->coupon_amount; ?></td>
                                                            <td><?php echo isset($kdata->coupon_price)?$kdata->coupon_price:'0'; ?></td>
                                                            <td><?php echo isset($vat)?$vat:'0'; ?></td>
                                                            <td><?php echo isset($kdata->od_totalamount)?$kdata->od_totalamount:'0'; ?></td>
                                                             
                                                            <td><?php echo isset($kdata->od_paidamount)?$kdata->od_paidamount:'0'; ?></td>
                                                           
                                                            <td><?php echo $kdata->purchase_status; ?></td>
                                                            <td><?php echo $kdata->created; ?></td>
                                                          
                                                            
                                                            <td> 

                                                                <?php if ($kdata->purchase_status=='Expire'){ ?>
                                                                     <a class="btn btn-primary waves-effect waves-light"  href="<?php echo site_url('couponpreviewpurchase?id=' . $kdata->id.'&purchase_status='.$kdata->purchase_status); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                                </a> 
                                                                <?php } ?>
                                                                 <?php if ($kdata->purchase_status=='Used'){ ?>
                                                                     <a class="btn btn-primary waves-effect waves-light"  href="<?php echo site_url('couponpreviewpurchase?id='  . $kdata->id.'&purchase_status='.$kdata->purchase_status); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                                </a> 
                                                                <?php } ?>
                                                                 <?php if ($kdata->purchase_status=='Active'){ ?>
                                                                     <a class="btn btn-primary waves-effect waves-light"  href="<?php echo site_url('couponpreviewpurchase?id='  . $kdata->id.'&purchase_status='.$kdata->purchase_status); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                                </a> 
                                                                <?php } ?>
                                                              
                                                            </td>
                                                              <?php $coamt+=$kdata->coupon_amount;?>
                                                              <?php $i+=$kdata->od_totalamount;?>
                                                            <?php $price+=$kdata->coupon_price+$vat;?>
                                                            <?php $paid_amt+=$kdata->od_paidamount;?>
                                                         
                                                        </tr>
                                                    <?php } ?>
                                            
                                                </tbody>
                                            </table>
                                            <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
                                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => $pageurl, 'varExtra' => $searchArray)); ?>
                                            <?php }
                                         ?>
                                    </div>
                                    <?php }else{ ?>
                                    <?php echo view('admin/_noresult',array('noResult'=>array("description"=>"Please change search criteria and submit again"))); ?>
                                <?php } ?>
                                </div>
                            </div>	

                                    <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Total Coupon Amount</th>
                           <td><span style="color:green;"> <?php echo number_format($coamt, 3, '.', ''); ?> OMR</span></td>
                        </tr>
                          <tr>
                           <th>Total Coupon Price + vat(5%)</th>
                           <td><span style="color:green;"> <?php echo number_format($price, 3, '.', ''); ?> OMR</span></td>
                        </tr>
                        <tr>
                           <th>Total Product Price</th>
                           <td><span style="color:green;"> <?php echo number_format($i, 3, '.', ''); ?> OMR</span></td>
                        </tr>
                         <tr>
                           <th>Total Paid Amount</th>
                           <td><span style="color:green;"> <?php echo number_format($paid_amt, 3, '.', ''); ?> OMR</span></td>
                        </tr>
                      
                         
                      
                        
                         
                     </tbody>
                  </table>  					
                           
                            

                        </div>
                    </div>
                </div>
            </div> 
        </div> 


</div>
