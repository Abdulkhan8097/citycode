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
                               <h4 class="card-title">Add New Celebrity</h4>
                               <form class="custom-validation"  method='post' action="CustomerController/create_celebrity" enctype='multipart/form-data'>

                            <div class="for-mobile-laptop">
                               
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Full Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" required placeholder="Enter Full Name" name="name"/>
                                  </div>
                                </div>

                                 <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Family Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" required placeholder="Enter Family Name" name="family_name"/>
                                </div></div>-->

                                 <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Interest</label>
                                    <div class="col-sm-6">

<input type="checkbox" id="row1" name="interest[]" value="Restaurants">
<label for="row1"> Restaurants </label>
 
<input type="checkbox" id="row2" name="interest[]" value="Perfumes">                 
<label for="row2"> Perfumes </label>

<input type="checkbox" id="row3" name="interest[]" value="Health & Beauty">
<label for="row3"> Health & Beauty </label> 
                                                                                 
<input type="checkbox" id="row4" name="interest[]" value="Hotels">
<label for="row4"> Hotels </label>  

<input type="checkbox" id="row5" name="interest[]" value="Furniture & House Holds">
<label for="row5"> Furniture & House Holds </label>
 
<input type="checkbox" id="row6" name="interest[]" value="Cars">                 
<label for="row6"> Cars </label>

<input type="checkbox" id="row7" name="interest[]" value="Clothes & Shops">
<label for="row7"> Clothes & Shops </label> 
                                                                                 
<input type="checkbox" id="row8" name="interest[]" value="Travel & tourism">
<label for="row8"> Travel & tourism </label>                                                                                
</div></div>-->


<div class="form-group row">
 <label for="inputPassword" class="col-sm-2 col-form-label">Interest<span class="mandatory">*</span></label>
 <div class="col-sm-6">
 <?php 
$numbers= 'Medical, Hotel, Food, Beauty, Clothing, Perfume, Furniture & Lighting, Gadgets & Appliance, Insurance, Gym, Laundry, Flower, Entertainment, Other';

$array =  explode(',', $numbers); 

foreach ($array as $item) { 
 ?>				
     <input type="checkbox" required name="interest[]" value="<?php echo $item; ?>"> <?php echo $item; ?>	 
<?php }?>                                                                              
</div></div>

                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">V.I.P Code<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <select class="form-control" name="vip_code" required>                                      
                                     <option value="">- Please Select -</option>
                                   <?php foreach($values as $val) { ?>
                                        <option value="<?php echo $val['vip_code']?>"> <?php echo $val['vip_code'];?> </option>
                                    <?php } ?>
                                  </select>
                                      </div>
                                 </div>


                                  <div class="form-group row">
                                               
                                    <label for="inputPassword" class="col-sm-2 col-form-label">E-Mail</label>
                                     <div class="col-sm-6">
                                        <input type="email" class="form-control" parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail"/>
                                    </div>

                                    <div class="text-danger" id="email-exist-error-msg">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">Date Of Birth</label>
                                    <div class="col-sm-6">
                                         <input type="date" class="form-control" name="date_of_birth"/> <span>
                                    </div>
                                 </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Mobile Number<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input data-parsley-type="digits" type="text"
                                                class="form-control" required
                                                placeholder="Enter only digits" name="mobile"/>
                                    </div>
                                </div>


                                 <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">Gender<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <select class="form-control" name="gender" required>
                                        <option value="">- Please Select -</option>
                                        <option value="male"> Male </option>
                                        <option value="female"> Female </option>
                                        <option value="female"> Others </option> 
                                  </select>
                                      </div>
                                 </div>

                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">Start Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                         <input type="date" class="form-control" required name="start_date"/> <span>
                                    </div>
                                 </div>

                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">End Date<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                         <input type="date" class="form-control" required name="end_date"/> <span>
                                    </div>
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Nationality</label>                                   
                                      <div class="col-sm-6"> 
                                        <select name="nationality" class="form-control input-lg">
                                           <option value="">- Please Select -</option>
                                <?php
                                foreach($countries as $country)
                                {
                                    echo '<option value="'.$country["country_id"].'">'.$country["country_name"].'</option>';
                                }
                                ?>
                                       </select>
                                    </div> 
                                </div>


                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Governorate<span class="mandatory">*</span></label>                                   
                                      <div class="col-sm-6">
                                       <select name="governorate" id="state" class="form-control input-lg" required>
                                         <option value="">- Please Select -</option>
                                <?php
                                foreach($states as $row)
                                {
                                    echo '<option value="'.$row["state_id"].'">'.$row["state_name"].'</option>';
                                }
                                ?>
                                       </select>
                                    </div> 
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">State</label>
                                    
                                    <div class="col-sm-6">
                                        <select name="state" id="city" class="form-control input-lg">
                                         <option value="">- Please Select -</option>
                                        </select>  
                                  </div> 
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Language<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="language" required>
                                        <option value="">- Please Select -</option>
                                        <option value="arabic"> Arabic </option>
                                        <option value="english"> English </option>

                                  </select> 
                             </div>
                          </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Commission<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required name="commission" placeholder ="Enter Comission" onKeyUp="numericFilter(this);"/>
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Profile<span class="mandatory">*</span></label>
                                   
                                    <div class="col-sm-6">
                                        <input type="file" name="profile" required/> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status">
                                        <option value="1"> Active </option>
                                        <option value="0"> Inactive </option>

                                  </select> 
                             </div>
                          </div>


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
                                    </div>
                                </div>
                           </div>
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
