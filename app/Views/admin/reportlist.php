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

    label{
        color: #000 !important;}

    .tab-pane{
        background-color:#fff !important;
    }

    .nav-link{
        background-color:#fff !important;  
        color: #000 !important;
        font-size: 18px;
    }

    a.active{
        background-color:#F6D000 !important;  
        font-size: 18px;  
    }
    a.ion-md-add-circle-outline{
        color: #000 !important;  
    }

    .table td {
        padding: .30rem;
    }
</style>
<script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <form action="">
                <div class="col-xl-12">
                    <div class="card">                  
                        <div class="card-body">                           
                            <!-- Search  row -->

                            <div class="row ">	                           
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Start Date </label>
                                        <div class="col-md-12">
                                            <input class="form-control" name="start_date" type="date" value="<?php if (!empty($searchArray['start_date'])) {
    echo $searchArray['start_date'];
} ?>" placeholder="Search by start date" >
                                        </div>
                                    </div>       
                                </div>								

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> End Date </label>
                                        <div class="col-md-12">
                                            <input class="form-control" name="end_date" type="date" value="<?php if (!empty($searchArray['end_date'])) {
    echo $searchArray['end_date'];
} ?>" placeholder="Search by end adte" >
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Company Name </label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="company_name" >
                                                <?php if ($session->get('user_id')) { ?>
                                                    <option value="">- Please Select -</option>
                                                    <option value="city_code">City Code</option>
                                                    <?php
                                                    foreach ($companies as $row) {
                                                        if (!empty($searchArray['company_name'])) {
                                                            if ($row['company_name'] == $searchArray['company_name']) {
                                                                $selected = 'selected="selected"';
                                                            } else {
                                                                $selected1 = '';
                                                            }
                                                        }
                                                        ?>
                                                                <?php if (($row["company_name"]) && ($row["company_arb_name"])) { ?>
                                                            <option value="<?php echo $row['company_name'] ?>" 

                                                            <?php if (!empty($searchArray['company_name'])) {
                                                                if ($row['company_name'] == $searchArray['company_name']) {
                                                                    echo $selected;
                                                                } else {
                                                                    echo $selected1;
                                                                }
                                                            }
                                                            ?>>
                                                                    <?php echo $row['company_name'] . ' / ' . $row['company_arb_name']; ?></option>

                                                        <?php } else if ($row["company_arb_name"]) { ?>
                                                            <option value="<?php echo $row['company_name'] ?>" 
            <?php if (!empty($searchArray['company_name'])) {
                if ($row['company_name'] == $searchArray['company_name']) {
                    echo $selected;
                } else {
                    echo $selected1;
                }
            }
            ?>>
            <?php echo $row['company_arb_name']; ?></option>
        <?php } else if ($row["company_name"]) { ?>
                                                            <option value="<?php echo $row['company_name'] ?>" <?php if (!empty($searchArray['company_name'])) {
                if ($row['company_name'] == $searchArray['company_name']) {
                    echo $selected;
                } else {
                    echo $selected1;
                }
            }
            ?>><?php echo $row['company_name']; ?></option>                                                    
        <?php } else { ?>
        <?php }
    }
} else if ($session->get('company_id')) { ?>
                                                    <option value="<?php echo $session->get('company_name'); ?>" <?php echo $session->get('company_name'); ?>><?php echo $session->get('company_name'); ?></option> 
                                                <?php } ?>
                                            </select>  
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Customer Mobile  </label>
                                        <div class="col-md-12">
                                            <input class="form-control" name="mobile" type="text" value="<?php if (!empty($searchArray['mobile'])) {
                                                    echo $searchArray['mobile'];
                                                } ?>" placeholder="Search by customer mobile" >
                                        </div>
                                    </div>       
                                </div>
                            </div><!-- first row end here--> <br />

                            <div class="row ">
                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Gender </label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="gender" >
                                                <option value="">- Please Select -</option>
<?php
if (!empty($searchArray['gender'])) {
    if ($searchArray['gender'] == 'Male') {
        $male = 'selected="selected"';
    } else if ($searchArray['gender'] == 'Female') {
        $female = 'selected="selected"';
    }
}
?>
                                                <option value="Male" <?php if (!empty($male)) {
    echo $male;
} ?>> Male </option>
                                                <option value="Female" <?php if (!empty($female)) {
    echo $female;
} ?>> Female </option>
                                            </select>
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> City Code </label>
                                        <div class="col-md-12">
                                            <input class="form-control" name="city_code" type="text" value="<?php if (!empty($searchArray['city_code'])) {
                                                    echo $searchArray['city_code'];
                                                } ?>" placeholder="Search by city code" >
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> V.I.P Code </label>
                                        <div class="col-md-12">
                                            <input class="form-control" name="vip_code" type="text" value="<?php if (!empty($searchArray['vip_code'])) {
                                                    echo $searchArray['vip_code'];
                                                } ?>" placeholder="Search by v.i.p code" >
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Offer </label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="coupon_type" >
                                                <option value="">- Please Select -</option>
                                                <?php
                                                if (!empty($searchArray['coupon_type'])) {
                                                    if ($searchArray['coupon_type'] == 'city') {
                                                        $city = 'selected="selected"';
                                                    } else if ($searchArray['coupon_type'] == 'vip') {
                                                        $vip = 'selected="selected"';
                                                    } else if ($searchArray['coupon_type'] == 'friday') {
                                                        $vip = 'selected="selected"';
                                                    }
                                                }
                                                ?>
                                                <option value="city" <?php if (!empty($city)) {
                                                    echo $city;
                                                } ?>> Public Offer </option>
                                                <option value="vip" <?php if (!empty($vip)) {
                                                    echo $vip;
                                                } ?>> V.I.P Offer </option>
                                                <option value="friday" <?php if (!empty($friday)) {
                                                            echo $friday;
                                                        } ?>> Friday Offer </option>
                                            </select>                                    
                                        </div>
                                    </div>       
                                </div>											                               
                            </div> <!-- second row end here--> <br />	

                            <div class="row ">
                                <!--<div class="col-lg-3 ">
                                    <div class="row">
                                                                        <label> Online Shop </label>
                                            <div class="col-md-12">
                                                <input class="form-control" name="online_shop" type="text" value="<?php if (!empty($searchArray['online_shop'])) {
                                                            echo $searchArray['online_shop'];
                                                        } ?>" placeholder="Search by online shop" >
                                            </div>
                                        </div>       
                                    </div>-->		 


                                <div class="col-lg-3 ">
                                    <div class="row">
                                        <label> Governorate </label>
                                        <div class="col-md-12">
                                            <select name="stateid" id="state" class="form-control input-lg" >
                                                <option value="">- Please Select -</option>
                                                <?php
                                                foreach ($states as $row) {

                                                    if (!empty($searchArray['stateid'])) {
                                                        if ($row['state_id'] == $searchArray['stateid']) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected1 = '';
                                                        }
                                                    }
                                                    ?>


                                                    <option value="<?php echo $row['state_id'] ?>" 
    <?php if (!empty($searchArray['stateid'])) {
        if ($row['state_id'] == $searchArray['stateid']) {
            echo $selected;
        } else {
            echo $selected1;
        }
    }
    ?>><?php echo $row['state_name']; ?></option>

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
                                                <option value="">Select State</option>

<?php
foreach ($cities as $row) {
    if (!empty($searchArray['cityid'])) {
        if ($row['city_id'] == $searchArray['cityid']) {
            $selected = 'selected="selected"';
        } else {
            $selected1 = '';
        }
    }
    ?>

                                                    <option value="<?php echo $row['city_id'] ?>" 
    <?php if (!empty($searchArray['cityid'])) {
        if ($row['city_id'] == $searchArray['cityid']) {
            echo $selected;
        } else {
            echo $selected1;
        }
    }
    ?>><?php echo $row['city_name']; ?></option>

<?php } ?>
                                            </select> 
                                        </div>
                                    </div>       
                                </div><!-- third row end here-->



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
                                        <a href="<?php echo site_url('Reports'); ?>">
                                            <button type="button" class="btn btn-primary waves-effect waves-light mr-1">
                                                Refresh
                                            </button></a>
                                    </div>
                                </div>

                            </div>								
                        </div> <!-- end row --> 
                             <!-- Start row --> 
                            <div class="row" style="margin:8px;">
                                <!-- <div class="col-lg-4">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary float-left"> <b> Active Customer: <span style="text-success"><?php //echo $active_customer_count."/".$customer_count;?></span></b></button> -->
                                        <!--label class="font-size-16 "></label-->
                                  <!--   </div>
                                </div> -->
                                <div class="col-lg-4">
                                </div>
                                <div class="col-lg-4">
                                 <!--    <div class="col-md-12 align-right">
                                        <button type="button" class="btn btn-secondary float-right"><b>Active Company: <span style="text-success"><?php //echo $activecompanycount."/".$companycount;?></span></b></button></label>
                                    </div> -->
                                </div>
                            </div>
                        <!-- end row --> 
                         <!-- Start row --> 
                            <!-- class="row">
                                <div class="col-lg-4">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary float-left"> Active Customer <b><span style="text-success"><?php echo $active_customer_count."/".$customer_count;?></span></b></button>
                                    </div>
                                </div>
                            </div-->
                        <!-- end row -->
                    </div>
                </div><!-- end card -->

        </div>
        </form>  
    </div>  


<?php if ((!empty($searchArray['start_date'])) || (!empty($searchArray['end_date'])) || (!empty($searchArray['mobile'])) || (!empty($searchArray['gender'])) || (!empty($searchArray['city_code'])) || (!empty($searchArray['vip_code'])) || (!empty($searchArray['stateid'])) || (!empty($searchArray['cityid'])) || (!empty($searchArray['company_name'])) || (!empty($searchArray['coupon_type']))) { ?>
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20">Reports</h4>
                </div>
            </div>
        </div>



        <div class="container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">Company</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu3">Transaction</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
    <?php echo view('admin/_topmessage'); ?>
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active"><br>
                                <div class="card-body">

                                    <div class="table-responsive">
    <?php if ($session->get('user_id')) { ?>
                                            <table class="table table-striped table-centered table-nowrap mb-1">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($customers as $kdata) {
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>
                                                            <td><?php echo $kdata->name; ?></td>
                                                            <td><?php echo $kdata->email; ?></td>
                                                            <td><?php echo $kdata->mobile; ?></td>
                                                            <td> <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?id=' . $kdata->id); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i>
                                                                </a> </td>
                                                        </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
        <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
            <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Reports', 'varExtra' => $searchArray)); ?>
        <?php }
    } else { ?>

                                            <table class="table table-striped table-centered table-nowrap mb-1">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>

                                            </table>
    <?php } ?>
                                    </div>

                                </div>
                            </div>						
                            <!------------------------ third tab ------------------------->
                            <div id="menu1" class="container tab-pane fade"><br>
                                <div class="card-body">

                                    <div class="table-responsive">
    <?php if ($session->get('user_id')) { ?>
                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>
                                                        <th>Company Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
        <?php
        $i = 0;
        foreach ($companylist as $kdata) {
            ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>
                                                            <td><?php echo $kdata['company_name']; ?></td>
                                                            <td><?php echo $kdata['email']; ?></td>
                                                            <td><?php echo $kdata['mobile']; ?></td>
                                                            <td> <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?company_id=' . $kdata['id']); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i> </a> </td>
                                                        </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
        <?php if (!empty($pagination2['haveToPaginate'])) { ?><br>
            <?php echo view('admin/_paging', array('paginate' => $pagination2, 'siteurl' => 'Reports', 'varExtra' => $searchArray)); ?>
        <?php }
    } else if ($session->get('company_id')) { ?>

                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>
                                                        <th>Company Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>						
                                                <tbody>
        <?php $i = 0; ?>                                                         
                                                    <tr>
                                                        <th scope="row"><?php echo ++$i; ?></th>
                                                        <td><?php echo $session->get('company_name'); ?></td>
                                                        <td><?php echo $session->get('email'); ?></td>
                                                        <td><?php echo $session->get('mobile'); ?></td>
                                                        <td> <a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?company_id=' . $session->get('company_id')); ?>">
                                                                <i class="ion ion-md-add-circle-outline"></i> </a> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                <?php } ?>
                                    </div>

                                </div>
                            </div>


                            <!------------------------ second tab ------------------------->
                            <div id="menu2" class="container tab-pane fade"><br>
                                <div class="card-body">

                                    <div class="table-responsive">
    <?php if ($session->get('user_id')) { ?>
                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>

                                                        <th>Offer Type</th>
                                                        <th>Company Name</th>
                                                        <th>Branch Name</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($offers as $kdata) {
                                                ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>

                                                            <td><?php echo $kdata['coupon_type']; ?></td>
                                                            <td><?php echo $kdata['company_name']; ?></td>
                                                            <td><?php echo $kdata['branch_name']; ?></td>
                                                            <td><a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?offer_id=' . $kdata['id']); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i> </a></td>
                                                        </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
                                                    <?php if (!empty($pagination3['haveToPaginate'])) { ?><br>
                                                        <?php echo view('admin/_paging', array('paginate' => $pagination3, 'siteurl' => 'Reports', 'varExtra' => $searchArray)); ?>
                                                    <?php }
                                                } else { ?>

                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>

                                                        <th>Offer Type</th>
                                                        <th>Company Name</th>
                                                        <th>Branch Name</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
        <?php
        $i = 0;
        foreach ($offers as $kdata) {
            ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>

                                                            <td><?php echo $kdata['coupon_type']; ?></td>
                                                            <td><?php echo $kdata['company_name']; ?></td>
                                                            <td><?php echo $kdata['branch_name']; ?></td>
                                                            <td><a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?offer_id=' . $kdata['id']); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i> </a></td>
                                                        </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
    <?php } ?>
                                    </div>                   
                                </div>
                            </div>


                            <!------------------------ third tab ------------------------->
                            <div id="menu3" class="container tab-pane fade"><br>
                                <div class="card-body">

                                    <div class="table-responsive">
                                                <?php if ($session->get('user_id')) { ?>
                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>  
                                                                                    <!--<th>city code</th>-->                         
                                                        <th>Company Name</th>
                                                        <th>Branch Name</th>
                                                        <th>Totalamount</th>
                                                        <th>Saveamount</th>
                                                        <th>Paidamount</th>
                                                        <th>Commission (<?php echo $totalcommision;?>)</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $total_amt = 0;
                                                    foreach ($transactions as $kdata) {
                                                        $temp_amount = 0;
                                                        $temp_amount = $kdata->citycode_commission;
                                                        $total_amt = $total_amt + $temp_amount;
                                                        ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>
                                                                                <!--<td><?php echo $kdata->city_code; ?></td>-->
                                                            <td><?php echo $kdata->company_name; ?></td>
                                                            <td><?php echo $kdata->branch_name; ?></td>
                                                            <td><?php echo $kdata->od_totalamount; ?></td>
                                                            <td><?php echo $kdata->od_saveamount; ?></td>
                                                            <td><?php echo $kdata->od_paidamount; ?></td>
                                                            <td><?php echo $kdata->citycode_commission; ?></td>
                                                            <td><a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?od_id=' . $kdata->od_id); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i> </a></td>
                                                        </tr>
        <?php } ?>
                                                    <!-- <tr>
                                                        <td  colspan="6" style="font-weight: bold; color: black;"><?php //echo 'Total'  ?></td>
                                                        <td  style="font-weight: bold; color: black;"><?php //echo $total_amt  ?></td>
                                                    </tr>  -->   
                                                </tbody>
                                            </table>
        <?php if (!empty($pagination4['haveToPaginate'])) { ?><br>
            <?php echo view('admin/_paging', array('paginate' => $pagination4, 'siteurl' => 'Reports', 'varExtra' => $searchArray)); ?>
        <?php }
    } else { ?>

                                            <table class="table table-striped table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SI. No.</th>
                                                                                    <!--<th> city code </th> -->                        
                                                        <th>Company Name</th>
                                                        <th>Branch Name</th>
                                                        <th>Totalamount</th>
                                                        <th>Saveamount</th>
                                                        <th>Paidamount</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
        <?php
        $i = 0;

        foreach ($transactions as $kdata) {
            ?>
                                                        <tr>
                                                            <th scope="row"><?php echo ++$i; ?></th>
                                                                            <!--<td><?php echo $kdata->city_code; ?></td>-->
                                                            <td><?php echo $kdata->company_name; ?></td>
                                                            <td><?php echo $kdata->branch_name; ?></td>
                                                            <td><?php echo $kdata->od_totalamount; ?></td>
                                                            <td><?php echo $kdata->od_saveamount; ?></td>
                                                            <td><?php echo $kdata->od_paidamount; ?></td>
                                                            <td><a class="btn btn-primary waves-effect waves-light" href="<?php echo site_url('ReportDetails?od_id=' . $kdata->od_id); ?>">
                                                                    <i class="ion ion-md-add-circle-outline"></i> </a></td>
                                                        </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
    <?php } ?>


                                    </div>   
                                </div>
                            </div> <!---- end third tab --------->

                        </div>
                    </div>
                </div>
            </div> 
        </div> 

<?php } ?>
</div>


<script>
    $(document).ready(function () {

        $('#state').change(function () {

            var state_id = $('#state').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/ReportController/action'); ?>",
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

    });

</script>


<script>
    function showhideSearch()
    {
        //alert($('#extrasearch').css("display"));

        if ($('#extrasearch').css("display") == "none") {
            $('#searchupdownicon').removeClass("fas fa-angle-down");
            $('#searchupdownicon').addClass("fas fa-angle-up");

        } else {

            $('#searchupdownicon').removeClass("fas fa-angle-up");
            $('#searchupdownicon').addClass("fas fa-angle-down");
        }
        $('#extrasearch').toggle(1000);
    }
</script>
