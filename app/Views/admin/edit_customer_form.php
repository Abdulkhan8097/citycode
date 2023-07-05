<style>

.for-mobile-laptop {
  margin: 0 100px;
}

    @media only screen and (max-width: 600px) {
        .for-mobile-laptop {
            margin: 0;

        }
    }

    label {
        float: left
    }
    span {
        display: block;
        overflow: hidden;
        padding: 0 4px 0 6px
    }
    input {
        width: 100%
    }

    .mandatory {
        display:inline;
        color:red;
    } 
    .selectt {
        display: none;
    }
</style> 


<script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo view('admin/_topmessage'); ?>

                        <div class="row">
                            <div class="col-lg-3"> 
                                <h4 class="card-title">Edit Customer</h4>     
                            </div>
                        </div>
                        <hr>

                        <form class="custom-validation"  method='post' action="CustomerController/update" enctype='multipart/form-data'>

                            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customers->id; ?>">

                            <div class="for-mobile-laptop">
                                <div class="row ">
                                    <div class="col-md-8">
                                        <div class="form-group row">
                                            <label  class=" col-sm-3 col-form-label">Make V.I.P Customer</label>
                                            <div class="col-sm-2  float-left">
                                                <input type="checkbox" id="vipchekbox" name="colorCheckbox" value="C" <?php echo $customers->vip_code ? "checked" : "" ?>>
                                            </div>
                                        </div> 
                                    </div>
                                </div>                          

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Full name<span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Enter Full name" name="name" required value="<?php echo $customers->name; ?>"/>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">City Code<span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Enter City Code" name="city_code" value="<?php echo $customers->city_code; ?>"/>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div id="vipdiv" style="display:none">
                                <div class="C">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">V.I.P Code ( <?php echo $customers->vip_code; ?> ) </label>
                                                <div class="col-sm-6">
                                                    <select name="vip_code" class="form-control input-lg">
                                                        <option value="">- Please Select -</option>                                        
                                                        <?php
                                                        foreach ($values as $val) {
                                                            if ($val['vip_code'] == $customers->vip_code) {
                                                                $selected = 'selected="selected"';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $val['vip_code'] ?>" <?php echo $selected ?>><?php echo $val["vip_code"] ?></option>
<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="C ">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Start Date</label>
                                                <div class="col-sm-6">
                                                    <input type="date" class="form-control" name="start_date" value="<?php echo $customers->start_date; ?>"/> <span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="C ">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">End Date</label>
                                                <div class="col-sm-6">
                                                    <input type="date" class="form-control" name="end_date" value="<?php echo $customers->end_date; ?>"/> <span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="C ">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <label  class="col-sm-2 ml-4 col-form-label">Commission</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="commission" placeholder ="Enter Comission" onKeyUp="numericFilter(this);" value="<?php echo $customers->commission; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                                <div class="row ">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label  class="col-sm-2 ml-4 col-form-label">Interest<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
											<div class="row">
											<?php $gidz = explode(',', $customers->interest); ?>
							       <div class="col-sm-1 border float-left"><input type="checkbox" name="checkall" id="checkall"
								   <?php if(count($interests) == count($gidz)) { echo "checked" ; } ?> > </div>
								   <div class="col-sm-8 border float-lg-right">Select All</div>
								</div>
                                                <?php
                                                $gidz = explode(',', $customers->interest);
                                                foreach ($interests as $item) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-1 border float-left"><input type="checkbox" class="checkhour" required name="interest[]" value="<?php echo $item['cat_id']; ?>" <?php if (in_array($item['cat_id'], $gidz)) {
                                                        echo "checked";
                                                    } ?>></div>
                                                        <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_name']; ?></div>
                                                        <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_arbname']; ?></div>

                                                    </div>	 
<?php } ?>   
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">E-Mail</label>
                                            <div class="col-sm-6">
                                                <input type="email" class="form-control" parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail" value="<?php echo $customers->email; ?>"/>
                                            </div>
                                            <div class="text-danger" id="email-exist-error-msg">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Mobile Number<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input data-parsley-type="digits" type="text"
                                                       class="form-control" required
                                                       placeholder="Enter only digits" name="mobile" value="<?php echo $customers->mobile; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Gender<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <select name="gender" class="form-control" required>
                                                    <?php
                                                    foreach ($genderarr as $gender) {
                                                        if ($gender == $customers->gender) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $gender; ?>" <?php echo $selected ?>><?php echo $gender; ?></option>
<?php } ?>
                                                </select>  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">           
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Date Of Birth</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" name="date_of_birth" value="<?php echo $customers->date_of_birth; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Nationality</label>
                                            <div class="col-sm-6">
                                                <select name="nationality" class="form-control input-lg">
                                                    <option value="">Select Nationality</option>                                        
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        if ($country['country_id'] == $customers->nationality) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $country['country_id'] ?>" <?php echo $selected ?>><?php echo $country["country_enName"] . ' / ' . $country["country_arName"]; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">                
                                        <div class="form-group row">
                                            <label  class="col-sm-2 ml-4 col-form-label">Governorate<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">

                                                <select name="stateid" id="state" class="form-control input-lg" required>
                                                    <option value="">Select State</option>                                       
                                                    <?php
                                                    foreach ($statedata as $row) {
                                                        if ($row['state_id'] == $customers->stateid) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $row['state_id'] ?>" <?php echo $selected ?>><?php echo $row['state_name'] . ' / ' . $row["arb_state_name"]; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">State</label>
                                            <div class="col-sm-6">
                                                <select name="cityid" id="city" class="form-control input-lg">
                                                    <option value="">Select Village</option>

                                                    <?php
                                                    foreach ($all_cities as $row) {
                                                        if ($row['city_id'] == $customers->cityid) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $row['city_id'] ?>" <?php echo $selected ?>><?php echo $row['city_name'] . ' / ' . $row["city_arb_name"]; ?></option>
<?php } ?>

                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Language<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <select name="language" class="form-control" required>
                                                    <option value="arabic" <?php echo ($customers->language == 'arabic') ? 'selected="selected"' : ''; ?>>Arabic</option>
                                                    <option value="english" <?php echo ($customers->language == 'english') ? 'selected="selected"' : ''; ?>>English</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Profile<span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <img src="<?php echo base_url('users/' . $customers->profile); ?>" height=190 width=190 class="img-fluid"> <br><br>

                                                <input type="file" name="profile" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Totalpoint</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Enter Totalpoint" name="totalpoint" value="<?php echo $customers->totalpoint; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Status</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" required name="status">
                                                    <?php if ($customers->status == 1) { ?>
                                                        <option selected value="1">Active</option>
                                                        <option value ="0">Inactive</option>
<?php } else { ?>
                                                        <option value="1">Active</option>
                                                        <option selected value ="0">Inactive</option>
<?php } ?>
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0"><label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Update
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Customers'); ?>">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div> 
                        </div>
					</form>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->    
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
</div>


<script>

    $(document).ready(function () {

        $('#state').change(function () {

            var state_id = $('#state').val();

            var action = 'get_city';

            if (state_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/CustomerController/action'); ?>",
                    method: "POST",
                    data: {state_id: state_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option value="">- Please Select -</option>';

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

<script type="text/javascript">
    $(document).ready(function () {
        $('#vipchekbox').click(function () {
         $("#vipdiv").toggle(); //for div hide show
        });
    });
<?php if ($customers->vip_code) { ?>
        $("#vipdiv").toggle();
<?php } ?>
</script>

<script>
    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
</script>

<script>
/*var clicked = false;
$(".checkall").on("click", function() {
  $(".checkhour").prop("checked", !clicked);
  clicked = !clicked;
  this.innerHTML = clicked ? 'Deselect' : 'Select';
});*/

$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>


