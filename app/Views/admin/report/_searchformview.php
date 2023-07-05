
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
                                <div class="row">
                                    <label> Start Date </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="start_date" type="date" value="<?php  echo isset($searchArray['start_date']) ? $searchArray['start_date'] : "" ?>" placeholder="Search by start date" >
                                    </div>
                                </div>       
                            </div>								

                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> End Date </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="end_date" type="date" value="<?php echo isset($searchArray['end_date']) ? $searchArray['end_date'] :''; ?>" placeholder="Search by end date" >
                                    </div>
                                </div>       
                            </div>
                            
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Gender </label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="gender" >
                                            <option value="">- All-</option>
                                            <option value="Male" <?php echo   (isset($searchArray['gender']) &&  $searchArray['gender'] =='Male') ? "Selected" : ""; ?>> Male </option>
                                            <option value="Female" <?php echo   (isset($searchArray['gender']) &&  $searchArray['gender'] =='Female') ? "Selected" : ""; ?>> Female </option>
                                        </select>
                                    </div>
                                </div>       
                            </div>
                            
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> City Code </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="city_code" type="text" value="<?php echo !empty($searchArray['city_code']) ?   $searchArray['city_code'] : ""; ?>" placeholder="Search by city code" >
                                    </div>
                                </div>       
                            </div>
                        </div><!-- first row end here--> <br />

                        

                        <div class="row ">
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> V.I.P Code </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="vip_code" type="text" value="<?php echo !empty($searchArray['vip_code']) ?  $searchArray['vip_code'] : ""; ?>" placeholder="Search by v.i.p code" >
                                    </div>
                                </div>       
                            </div>
                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Governorate </label>
                                    <div class="col-md-12">
                                        <select name="stateid" id="state" class="form-control input-lg" >
                                            <option value="">- All -</option>
                                            <?php
                                            foreach ($states as $row) { ?>
                                                <option value="<?php echo $row['state_id'] ?>"  <?php echo   (isset($searchArray['stateid']) &&  $searchArray['stateid'] ==$row['state_id']) ? "Selected" : ""; ?> ><?php echo $row['state_name']; ?></option>

                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>       
                            </div>								

                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> State </label>
                                    <div class="col-md-12">
                                        <select name="cityid" id="city" class="form-control input-lg">
                                            <option value="">--All -- </option>

                                            <?php
                                            foreach ($cities as $row) { ?>
                                                <option value="<?php echo $row['city_id'] ?>"  <?php echo   (isset($searchArray['cityid']) &&  $searchArray['cityid'] ==$row['city_id']) ? "Selected" : ""; ?>><?php echo $row['city_name']; ?></option>

                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>       
                            </div><!-- third row end here-->

                            <div class="col-lg-3 ">
                                <div class="row">
                                    <label> Customer Mobile  </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="mobile" type="text" value="<?php echo !empty($searchArray['mobile']) ?   $searchArray['mobile'] : ""; ?>" placeholder="Search by customer mobile" >
                                    </div>
                                </div>       
                            </div>
                            
                            

                            <div class="col-lg-1">
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
                            </div>

                        </div>								
                    </div> <!-- end row --> 
                    
                    <!-- end row -->
                </div>
            </div><!-- end card -->
        </form> 
    </div>

<ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if($method == 'appViewCustomer'){ echo "active"; }?>" onclick="customersearch()" href="javascript::void(0);">Customer</a>
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
        $('#adminsearch').attr('action', "<?php echo site_url('appviewcutomer');?>");
         $("#adminsearch").submit();
    }
    
    
   
</script>
