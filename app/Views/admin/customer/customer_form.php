
<style>
/*  .for-mobile-laptop {
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
 .checkbox
 {
  display: inline-block;
}

.selectt {
display: none;
}*/

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
                               <h4 class="card-title">Add New Customer</h4>     
                          </div>                        
                    </div>
                  <hr>
                 <form class="custom-validation"  method='post' action="CustomerController/create_newcustomer" enctype='multipart/form-data'>                              
                              <div class="for-mobile-laptop">
                             <div class="row ">
                              <div class="col-md-8">
                                 <div class="form-group row">
                                    <label  class=" col-sm-3 col-form-label">Make V.I.P Customer</label>
                                    <div class="col-sm-2  float-left">
                                        <input type="checkbox" name="colorCheckbox" value="C">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    
                              
                              <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Full Name<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Full Name" name="name"/>
                                   </div>
                                  </div>
                               </div>                             
                           </div>

                       <div class="C selectt">
                        <div class="row">
                         <div class="col-md-10">
                          <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">V.I.P Code</label>
                              <div class="col-sm-6">
                                  <select class="form-control single" name="vip_code">                                      
                                     <option value="">- Please Select -</option>
                                     <?php foreach($values as $val) { ?>
                                        <option value="<?php echo $val['vip_code']?>"> <?php echo $val['vip_code'];?> </option>
                                    <?php } ?>
                                  </select>
                                 </div>
                               </div>
		                         </div>
                           </div>
                        </div>

                        <div class="C selectt"><div class="row">
                         <div class="col-md-10">
                           <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Start Date</label>
                                    <div class="col-sm-6">
                                         <input type="date" class="form-control" name="start_date"/> <span>
                                    </div>
                                 </div>
                                </div>
                              </div></div>

                              <div class="C selectt"><div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">End Date</label>
                                    <div class="col-sm-6">
                                         <input type="date" class="form-control" name="end_date"/> <span>
                                    </div>
                                 </div>
                               </div>
                            </div>
                         </div>
                        
                         <div class="C selectt">
                          <div class="row">
                            <div class="col-md-10">
                              <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Commission</label>
                                 <div class="col-sm-6">
                                    <input type="text" class="form-control" name="commission" placeholder ="Enter Comission" onKeyUp="numericFilter(this);"/>
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
							       <div class="col-sm-1 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
								   <div class="col-sm-8 border float-lg-right">Select all</div>
								</div>
                                   <?php  foreach ($interests as $item) { ?>
                                   <div class="row">
                                   <div class="col-sm-1 border float-left"><input type="checkbox" required name="interest[]" class="checkhour" value="<?php echo $item['cat_id']; ?>" ></div>
                                   <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_name']; ?></div>
                                   <div class="col-sm-4 border float-lg-right"><?php echo $item['cat_arbname']; ?></div>                                   
                                   </div>	 
                                <?php }?>   
                                </div>
                    </div>
                 </div>
             </div>

                            <div class="row">
                               <div class="col-md-10">
                                  <div class="form-group row">                                               
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">E-Mail</label>
                                     <div class="col-sm-6">
                                        <input type="email" class="form-control" 
                                                parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail"/>
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
                                                placeholder="Enter only digits" maxlength="10" name="mobile"/>
                                    </div>
                                </div> 
                              </div>
                            </div>

                              <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                   <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Gender<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <select class="form-control" name="gender" required>
                                        <option value="">- Please Select -</option>
                                        <?php if($genderarr) { foreach ($genderarr as $gender) { ?>
                                        <option value="<?php echo $gender; ?>"> <?php echo $gender; ?> </option>
                                        <?php } } ?>
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
                                         <input type="date" class="form-control" name="date_of_birth"/> <span>
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
                                           <option value="">- Please Select -</option>
                                <?php
                                foreach($countries as $country)
                                {
                                  echo '<option value="'.$country["country_id"].'">'.$country["country_enName"].' / '.$country["country_arName"].'</option>';
                                }
                                ?>
                                    </select>
                                    </div> 
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Governorate<span class="mandatory">*</span></label>
                                   
                                    <div class="col-sm-6">
                                       <select name="stateid" id="state" class="form-control input-lg" required>
                                           <option value="">- Please Select -</option>
                                <?php
                                foreach($states as $row)
                                {
                                  echo '<option value="'.$row["state_id"].'">'.$row["state_name"].' / '.$row["arb_state_name"].'</option>';
                                }
                                ?>
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
                                         <option value="">- Please Select -</option>
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
                                      <select class="form-control" name="language" required>
                                        <option value="">- Please Select -</option>
                                        <option value="arabic"> Arabic </option>
                                        <option value="english"> English </option>
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
                                        <input type="file" name="profile" required/> 
                                    </div>
                                </div> 
                              </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 ml-4 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                      <select class="form-control" name="status">
                                        <option value="1"> Active </option>
                                        <option value="0"> Inactive </option>
                                  </select> 
                             </div>
                          </div> 
                        </div> 
                      </div>


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 ml-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Customers');?>">
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
                    var html = '<option value="">- Please Select -</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                      html += '<option value="'+data[count].city_id+'">'+data[count].city_name+' / '+data[count].city_arb_name+'</option>';
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

<script type="text/javascript">
			$(document).ready(function() {
				$('input[type="checkbox"]').click(function() {
					var inputValue = $(this).attr("value");
					$("." + inputValue).toggle();
				});
			});
</script>

<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>

<script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>