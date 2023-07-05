<style>
    .card-body {
        margin: 0 200px;
    }
    @media only screen and (max-width: 600px) {
        .card-body {
            margin: 0;
        }
    }
    .mandatory {
        display:inline;
        color:red;
    }
</style>

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
                                    <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('EditCompany?id=' . $branchdata['company_id']); ?>">
                                        <i class="ion ion-md-arrow-back"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>

                        <form class="custom-validation"  method='post' action="CompanyController/update_branch" enctype='multipart/form-data'>
                            <input type="hidden" id="branch_id" name="branch_id" value="<?php echo $branchdata['branch_id']; ?>">
                            <?php if (!empty($branchdata)) { ?>

                                <h2> Edit Branch </h2>						   
                                <div id="city_field">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Enter Branch" name="branch_name" value="<?php echo $branchdata['branch_name'] ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Enter Branch" name="arb_branch_name" value="<?php echo $branchdata['arb_branch_name'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mobileno" class="col-sm-2 col-form-label">Authorized No. <span class="mandatory">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="Enter Mobile No" name="brach_atho_no" value="<?php echo $branchdata['branch_autho_no'] ?>" required><br>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Governorate <span class="mandatory">*</span></label>
                                        <div class="col-sm-7">
                                            <select name="state" id="state" class="form-control input-lg" required>
                                                <option value="">- Please Select -</option>
                                                <?php
                                                foreach ($states as $row) {
                                                    if ($row['state_id'] == $branchdata['state']) {
                                                        $selected = 'selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $row['state_id'] ?>" <?php echo $selected ?>><?php echo $row['state_name'] . ' / ' . $row['arb_state_name']; ?></option>
    <?php } ?>

                                            </select>
                                        </div> 
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">State <span class="mandatory">*</span></label>                                  
                                        <div class="col-sm-7">
                                            <select name="city" id="city" class="form-control input-lg" required>
                                                <option value="">Select State</option>

                                                <?php
                                                foreach ($city_cities as $row) {
                                                    if ($row->city_id == $branchdata['city']) {
                                                        $selected = 'selected="selected"';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $row->city_id ?>" <?php echo $selected ?>><?php echo $row->city_name ?></option>
    <?php } ?>


                                            </select>  
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Location</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Enter Location" name="location" value="<?php echo $branchdata['location'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Arebic Location" name="arb_branch_location" value="<?php echo $branchdata['arb_branch_location'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Username</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Enter Username" name="branch_username" value="<?php echo $branchdata['branch_username'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" id="pass22" class="form-control" placeholder="Password"  value="1111"; name="branch_password"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Re-Type Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control"  value="1111" data-parsley-equalto="#pass22" placeholder="Re-Type Password" name="branch_rep_password"/>
                                        </div>
                                    </div>								  								            
                                </div>                            
<?php } ?>

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
                    url: "<?php echo base_url('/index.php/CompanyController/action'); ?>",
                    method: "POST",
                    data: {state_id: state_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option value="">Select State</option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            html += '<option value="' + data[count].city_id + '">' + data[count].city_name + ' / ' + data[count].city_arb_name + '</option>';
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

