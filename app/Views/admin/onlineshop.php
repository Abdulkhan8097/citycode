<style>
    .card-body {
        margin: 0 200px;
    }

    @media only screen and (max-width: 600px) {
        .card-body {
            margin: 0;
        }
    }

</style>


<script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php echo view('admin/_topmessage'); ?>
                <div class="card">
                    <div class="card-body">

                        <div class="col-sm-12" style="margin-left:25%;">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('EditCompany?id='.$details->id); ?>">
                                        <i class="ion ion-md-arrow-back"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>



                        <form class="ctustom-validation" method='post' action="CompanyController/update_onlineShop" enctype='multipart/form-data'>                           
                            <input type="hidden" id="company_id" name="company_id" value="<?php echo $details->id; ?>">
                           
                                <h2> Edit Online Shop Offer </h2>
                                <div id="city_field"> 

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="online_description" cols="6" rows="4" placeholder="Enter Description"><?php echo $details->online_description; ?></textarea> <br>
                                            <textarea class="form-control" name="online_arb_description" cols="6" rows="4" placeholder="Arebic Description"><?php echo $details->online_arb_description; ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="online_startdate" value="<?php if($details->online_startdate) { 
                                                echo date('Y-m-d', strtotime($details->online_startdate)); } ?>"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="online_enddate" value="<?php if($details->online_enddate) { 
                                                echo date('Y-m-d', strtotime($details->online_enddate)); } ?>"/>                                      
                                        </div></div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Online Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="online_link" value="<?php echo $details->online_link; ?>"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Play Store Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="online_playstore_link" value="<?php echo $details->online_playstore_link; ?>"/>                                      
                                        </div></div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">IOS Store Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="online_ios_link" value="<?php echo $details->online_ios_link; ?>"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Huawei Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="online_huawei_link" value="<?php echo $details->online_huawei_link; ?>"/>                                      
                                        </div>
                                    </div>
                                </div>                            
                       

                            <div class="form-group row mb-0" style="margin-top:50px;">
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>																
                    </div>
                </div>
            </div></div></div></div>



<!------- for city code -------------->

<script>
    function sum() {
        var txtFirstNumberValue = document.getElementById('txt1').value;
        var txtSecondNumberValue = document.getElementById('txt2').value;
        var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('txt3').value = result;
        }
    }
</script>

<!------ for famous ------------->

<script>
    function famsum() {
        var txtFirstNumberValue = document.getElementById('txt10').value;
        var txtSecondNumberValue = document.getElementById('txt20').value;
        var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('txt30').value = result;
        }
    }
</script>

<!---- for friday ----->

<script>
    function frisum() {
        var txtFirstNumberValue = document.getElementById('txt40').value;
        var txtSecondNumberValue = document.getElementById('txt50').value;
        var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('txt60').value = result;
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
                    url: "<?php echo base_url('/index.php/CompanyController/action'); ?>",
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

<!--------------- famous code -------------------------->

<script>

    $(document).ready(function () {

        $('#famstate').change(function () {

            var state_id = $('#famstate').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/CompanyController/action'); ?>",
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

                        $('#famcity').html(html);
                    }
                });
            } else
            {
                $('#famcity').val('');
            }

        });

    });

</script>

<!------------- friday code ------------------------------->

<script>

    $(document).ready(function () {

        $('#fristate').change(function () {

            var state_id = $('#fristate').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/CompanyController/action'); ?>",
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

                        $('#fricity').html(html);
                    }
                });
            } else
            {
                $('#fricity').val('');
            }

        });

    });

</script>

<script>
    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
</script>