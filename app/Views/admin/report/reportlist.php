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

<div class="page-content">
    


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

            <?php echo view('admin/report/_searchform'); ?>
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
    } else {
        ?>

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
    } else if ($session->get('company_id')) {
        ?>

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
                                        } else {
                                            ?>

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
                                                        <th>Commission (<?php echo $totalcommision; ?>)</th>
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
                                                    <td  colspan="6" style="font-weight: bold; color: black;"><?php //echo 'Total'   ?></td>
                                                    <td  style="font-weight: bold; color: black;"><?php //echo $total_amt   ?></td>
                                                </tr>  -->   
                                                </tbody>
                                            </table>
        <?php if (!empty($pagination4['haveToPaginate'])) { ?><br>
            <?php echo view('admin/_paging', array('paginate' => $pagination4, 'siteurl' => 'Reports', 'varExtra' => $searchArray)); ?>
        <?php }
    } else {
        ?>

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
