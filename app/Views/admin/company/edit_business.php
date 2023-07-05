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
.files {
display:inline;
}
.btn-primary{
color:#000 !important;
}
hr {
border:4px solid !importnat;
color:#000;
}
.percent{
display:inline !important;
}
.fa {
color:red !important;
}
.img-fluid{
    margin-top:20px;
}
.nav-item{
margin-right: 0px;
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
                                    <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('EditCompany?id='.$businessdata->company_id); ?>">
                                        <i class="ion ion-md-arrow-back"></i> Back
                                    </a>
                               </div>
                            </div>
                        </div>
                    
                        <form class="custom-validation"  method='post' action="CompanyController/update_business" enctype='multipart/form-data'>
                       
                        <input type="hidden" id="branch_id" name="business_id" value="<?php echo $businessdata->id; ?>">
                        <input type="hidden" id="home_business" name="home_business" value="<?php echo 'home_business' ?>">
                        <?php if(!empty($businessdata)) { ?>
					
                        <h2> Edit Home Business </h2>						   
                          <div id="business_field">
                             
                          <div class="row">
                            <div id="add_to_me"> 
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Image</label>
                                            <div class="col-sm-7">
                                                <?php if($h_images) { foreach ($h_images as $dice) { ?>
                                                    <div  class="col-sm-2 files">
                                                        <img src="<?php echo base_url('company/'.$dice->doc); ?>" height=90 width=90 class="img-fluid">
                                                        <a href="<?php echo site_url('DeleteBimages?id='.$dice->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                    </div>
                                                <?php } } else { ?> <?php } ?>
                                                <input type="file"name="business[]" class="form-control"  multiple>
                                          </div>
                                    </div>


                                   
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                        <div class="col-sm-6">
                                           <textarea class="form-control" name="b_description" cols="6" rows="4" placeholder="Enter Description"><?php echo $businessdata->description; ?></textarea><br>
                                           <textarea class="form-control" name="b_arb_description" cols="6" rows="4" placeholder="Arabic Description" ><?php echo $businessdata->arb_description; ?></textarea>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Mobile No. <span class="mandatory"></span></label>
                                        <div class="col-sm-6">
                                          <input type="text" name="b_mobile_no" class="form-control" placeholder="Contact number"  value="<?php echo $businessdata->h_mobile_no; ?>" /><br>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Whatsapp No.</label>
                                        <div class="col-sm-6">
                                          <input type="text" name="b_whatsapp_no" value="<?php echo $businessdata->h_whatsapp_no; ?>" class="form-control" placeholder="WhatsApp Number"/><br>
                                        </div>
                                    </div>

                                   <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Instagram</label>
                                        <div class="col-sm-6">
                                          <input type="text" name="instagram" value="<?php echo $businessdata->h_instagram; ?>" class="form-control" placeholder=""/><br>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Email Id <span class="mandatory"></span></label>
                                        <div class="col-sm-6">
                                          <input type="email" name="b_email" class="form-control" placeholder="Enter Email" value="<?php echo $businessdata->h_email; ?>"  /><br>
                                          <input type="hidden" name="company_id" class="form-control" placeholder="" value="<?php echo $businessdata->company_id; ?>"  />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4 col-form-label">Location</label>
                                        <div class="col-sm-6">
                                         <input type="text" class="form-control" placeholder="Enter location" name="b_location"  value="<?php echo $businessdata->h_location; ?>" /><br>
                                         <input type="text" class="form-control" placeholder="Arebic location" name="b_arb_location" value="<?php echo $businessdata->h_arab_location; ?>"/>
                                      </div>
                                    </div>

                                   <!--  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-7">
                                         <select class="form-control" required name="status"/>
                                        <?php// if($companydetails->status == 1){ ?>
                                        <option selected value="1">Active</option>
                                        <option value ="0">Inactive</option>
                                        <?php //} else { ?>
                                            <option value="1">Active</option>
                                        <option selected value ="0">Inactive</option>
                                        <?php// } ?>
                                    </select>
                                   </div>
                                 </div> -->

                            <?php }  ?>
							 
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
$(document).ready(function(){
	
    $('#state').change(function(){

        var state_id = $('#state').val();
        var action = 'get_city';

        if(state_id != '')
        {
            $.ajax({
                url:"<?php echo base_url('/index.php/CompanyController/action'); ?>",
                method:"POST",
                data:{state_id:state_id, action:action},
                dataType:"JSON",
                success:function(data)
                {
                    var html = '<option value="">Select State</option>';

                    for(var count = 0; count < data.length; count++)
                    {
                     html += '<option value="' + data[count].city_id + '">' + data[count].city_name + ' / ' + data[count].city_arb_name + '</option>';
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

