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

                              <h4 class="card-title"Edit Customer</h4>
                               <form class="custom-validation"  method='post' action="CustomerController/update_celebrity" enctype='multipart/form-data'>

                               <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customers['id']; ?>">

                                  <div class="for-mobile-laptop">

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Full Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" required placeholder="Enter Forename" name="name" value="<?php echo $customers['name']; ?>"/>
                                </div> </div>

                                 <!--<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Family Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" required placeholder="Enter Family Name" name="family_name" value="<?php echo $customers['family_name']; ?>"/>
                                </div> </div>-->

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">City Code<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" required placeholder="Enter City Code" name="city_code" value="<?php echo $customers['city_code']; ?>"/>
                                </div> </div>

<div class="form-group row">
 <label for="inputPassword" class="col-sm-2 col-form-label">Interest</label>
 <div class="col-sm-6">
 <?php 
$numbers= 'Medical, Hotel, Food, Beauty, Clothing, Perfume, Furniture & Lighting, Gadgets & Appliance, Insurance, Gym, Laundry, Flower, Entertainment, Other';

$array =  explode(',', $numbers); 

foreach ($array as $item) { 
 ?>
			<?php $gidz=explode(',',$customers['interest']);?>	
			
		             <input type="checkbox" name="interest[]" value="<?php echo $item; ?>" <?php if(in_array($item,$gidz)){ echo "checked"; }?>> <?php echo $item; ?>	 
			<?php }?>                                                                              
</div></div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">E-Mail</label>
                                   <div class="col-sm-6">
                                        <input type="email" class="form-control" parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail" value="<?php echo $customers['email']; ?>"/>
                                    </div>

                                    <div class="text-danger" id="email-exist-error-msg">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="date_of_birth" value="<?php echo $customers['date_of_birth']; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">V.I.P code</label>
                                     <div class="col-sm-6">
                                       <input type="text" readonly class="form-control" required name="vip_code" value="<?php echo $customers['vip_code']; ?>"/>
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Mobile Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input data-parsley-type="digits" type="text"
                                                class="form-control" required
                                                placeholder="Enter only digits" name="mobile" value="<?php echo $customers['mobile']; ?>"/>
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Gender<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                               <select name="gender" class="form-control" required>
                                 <option value="male" <?php echo ($customers['gender'] == 'male') ? 'selected="selected"' : ''; ?>>Male</option>
                                 <option value="female" <?php echo ($customers['gender'] == 'female') ? 'selected="selected"' : ''; ?>>Female</option>                                                                                       
                                 <option value="others" <?php echo ($customers['gender'] == 'others') ? 'selected="selected"' : ''; ?>>Others</option>
                               </select>  
                                   </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Start Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" required name="start_date" value="<?php echo $customers['start_date']; ?>"/>
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">End Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" required name="end_date" value="<?php echo $customers['end_date']; ?>"/>
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Nationality</label>
                                    <div class="col-sm-6">
                                       <select name="nationality" class="form-control input-lg">
                                            <option value="">Select Nationality</option>
                                        
                                             <?php  foreach ($countries as $country) { 
                                                   if($country['country_id'] == $customers['nationality'] ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $country['country_id'] ?>" <?php echo $selected ?>><?php echo $country["country_name"] ?></option>
                                           <?php } ?>
                                       </select>
                                    </div>
                                </div>


                             <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Governorate<span class="mandatory">*</span></label>
                                   <div class="col-sm-6">

                                 <select name="governorate" id="state" class="form-control input-lg" required>
                                   <option value="">Select State</option>                                       
                                     <?php  foreach ($statedata as $row) { 
                                                   if($row['state_id'] == $customers['governorate'] ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $row['state_id'] ?>" <?php echo $selected ?>><?php echo $row['state_name'] ?></option>
                                           <?php } ?>
                                       </select>
                                    </div>
                                </div>


                             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">State</label>
                            <div class="col-sm-6">
                                <select name="state" id="city" class="form-control input-lg">
                                     <option value="">Select Village</option>
                                           <?php  foreach ($all_cities as $row) { 
                                                   if($row['city_id'] == $customers['state'] ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $row['city_id'] ?>" <?php echo $selected ?>><?php echo $row['city_name'] ?></option>
                                           <?php } ?>
                                    </select> 
                                </div>
                           </div>

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Language<span class="mandatory">*</span></label>
                            <div class="col-sm-6">
                                  <select name="language" class="form-control" required>
                                 <option value="arabic" <?php echo ($customers['language'] == 'arabic') ? 'selected="selected"' : ''; ?>>Arabic</option>
                                 <option value="english" <?php echo ($customers['language'] == 'english') ? 'selected="selected"' : ''; ?>>English</option> 
                        
                               </select>
                             </div>
                          </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Commission<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required name="commission" value="<?php echo $customers['commission']; ?>" onKeyUp="numericFilter(this);"/>
                                    </div>
                                </div> 

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Profile<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                       <img src="<?php echo base_url('images/'.$customers['profile']); ?>" height=190 width=190 class="img-fluid" alt="Responsive image"> <br><br>

                                        <input type="file" name="profile" />
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
<div class="col-sm-6">
                                    <select class="form-control" name="status"/>
                                        <?php if($customers['status'] == 1){ ?>
                                        <option selected value="1">Active</option>
                                        <option value ="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                        <option selected value ="0">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div> </div>

                                <div class="form-group row mb-0"><label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Update
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div> </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->    
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->



<script>

$(document).ready(function(){

    $('#country').change(function(){

        var country_id = $('#country').val();

        var action = 'get_state';

        if(country_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/CustomerController/action'); ?>",
                method:"POST",
                data:{country_id:country_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select State</option>';

                    for(var count = 0; count < data.length; count++)
                    {

                        html += '<option value="'+data[count].state_id+'">'+data[count].state_name+'</option>';

                    }

                    $('#state').html(html);
                }
            });
        }
        else
        {
            $('#state').val('');
        }
        $('#city').val('');
    });

    $('#state').change(function(){

        var state_id = $('#state').val();

        var action = 'get_city';

        if(state_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/CustomerController/action'); ?>",
                method:"POST",
                data:{state_id:state_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select Village</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
                    }

                    $('#city').html(html);
                }
            });
        }
        else
        {
            $('#city').val('');
        }

    });

});

</script>

<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>
