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

                                        <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Location <span class="mandatory">*</span></label>                                  
                                        <div class="col-sm-7">
                                           <input type="text" class="form-control input-lg" id="loc"  placeholder="Enter Location" name="location" value="<?php echo $branchdata['location'] ?>" required/>

                                               

                                            </select>  
<span style="color:red;"> (Copy the link of address selected on Google Map from the address bar and paste the link over here. for e.g https://www.google.com/maps/place/Oman/@21.2175191,47.366597,6z/data=!3m1!4b1!4m9!1m2!2m1!1sT+BROAST!3m5!1s0x3dd69f66a9d59bbf:0x3a064c7665b1a817!8m2!3d21.4735329!4d55.975413!16zL20vMDVsOHk)</span>
                                        </div> 

                                    </div>

                                      <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">latitude <span class="mandatory">*</span></label>                                  
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control input-lg" placeholder="latitude" value="<?php echo $branchdata['latitude']; ?>" name="latt" id="latt" required readonly>

                                               

                                            </select>  
                                        </div> 
                                    </div>
                                       <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">longitude <span class="mandatory">*</span></label>                                  
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control input-lg" placeholder="longitude" name="lngg" value="<?php echo $branchdata['longitude']; ?>" id="lngg" required readonly> 

                                               

                                            </select>  
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
                                    <?php if ($branchdata['fast_delivery_charges'] || $branchdata['special_delivery_charges']){ ?>
                                         <div class="form-group row">
                                       <label for="inputPassword" class="col-sm-4 col-form-label">Delivery</label>
                                        <div class="col-sm-7">
                                              Yes &nbsp;<input type="checkbox" onclick="javascript:yesnoCheck();"  checked='checked' name="yesno" id="yesCheck"> &nbsp;&nbsp;
                                        </div>
                                    </div>  
                                        
                                    <?php }else{ ?>
                                               <div class="form-group row">
                                       <label for="inputPassword" class="col-sm-4 col-form-label">Delivery</label>
                                        <div class="col-sm-7">
                                              Yes &nbsp;<input type="checkbox" onclick="javascript:yesnoCheck();"  name="yesno" id="yesCheck"> &nbsp;&nbsp;
                                        </div>
                                    </div>  
                                    <?php } ?>
                                   

                                    <div class="form-group row d-none"  id="ifYes">
                                       <label for="inputPassword" class="col-sm-4 col-form-label">Fast Delivery Charges</label>
                                        <div class="col-sm-7">
                                              <input type="text" class="form-control" value="<?php echo (isset($branchdata) && !empty($branchdata)) ? $branchdata['fast_delivery_charges'] : ''; ?>" placeholder="Enter Amount" name="fast_delivery"/>
                                        </div>
                                    </div>
                                    <div class="form-group row d-none"  id="ifYes1">
                                      <label for="inputPassword" class="col-sm-4 col-form-label">Special Delivery Charges</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" value="<?php echo (isset($branchdata) && !empty($branchdata)) ? $branchdata['special_delivery_charges'] : ''; ?>" placeholder="Enter Amount" name="special_delivery"/>
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
     if (document.getElementById('yesCheck').checked) {
    document.getElementById('ifYes').classList.remove('d-none');
    document.getElementById('ifYes1').classList.remove('d-none');
  }

       });
</script>
<script type="text/javascript">
   function yesnoCheck() {
  if (document.getElementById('yesCheck').checked) {
    document.getElementById('ifYes').classList.remove('d-none');
    document.getElementById('ifYes1').classList.remove('d-none');
  } else {
    document.getElementById('ifYes').classList.add('d-none');
    document.getElementById('ifYes1').classList.add('d-none');
  }
}

</script>

<!------------------ branch start from here ----------------------->

<div class="modal fade" id="myModalbranch" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h2>Location </h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
                    <div class="modal-body">
                                   <div class="form-group row">
                                    <!-- <label for="inputPassword" class="col-sm-4 col-form-label">Get map Link</label> -->
                                    <div class="col-sm-6">
                                   <!--  <a href="https://www.google.com/maps/d/viewer?mid=1mrXqNcraAXEG7mIrml0CXGDzkko&hl=en_US&ll=21.26518172286571%2C56.43106311478722&z=6">choose Location</a> -->
                                   <div id="map" style="height:400px; width: 500px; margin-left: -17px;" class="my-3"></div>
                                  </div>
                                </div>
                                   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">latitude</label>
                                    <div class="col-sm-6">
                                   <input type="text" class="form-control" placeholder="lat" name="lat" id="lat" required>
                                  </div>
                                </div>
                                   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">longitude</label>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="long" name="long" id="lng" required>
                                  </div>
                                </div>                         
                           </div> <!-- dynamic_field -->

                                            <div class="form-group row mb-0" style="margin-top:5px; text-align: center;" >
                                 <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="button" style="margin-bottom: 17px;" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn closemodal" data-dismiss="modal">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                     </div> <!-- end modal body-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- end modal content-->    
    </div>
  </div>

  <script type="text/javascript">
    $('#closemodal').modal('hide');
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
 <script>
                    let map;
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: { lat: 19.95532, lng: 56.278639 },
                            zoom: 18,
                            scrollwheel: true,
                        });
                        const uluru = { lat: 19.95532, lng: 56.278639 };
                        let marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            draggable: true
                        });
                        google.maps.event.addListener(marker,'position_changed',
                            function (){
                                let lat = marker.position.lat()
                                let lng = marker.position.lng()
                               $('#lat').val(lat)
                              $('#lng').val(lng)

                               $("#latt").val(lat);
                               $("#lngg").val(lng);
                            })
                        google.maps.event.addListener(map,'click',
                        function (event){
                            pos = event.latLng
                            marker.setPosition(pos)
                        })
                    }
                </script>
               <!--  <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
                        type="text/javascript"></script> -->



                        <script>
    $(document).ready(function () {

        $('#loc').change(function () {

            var url = $('#loc').val();
           
// Split the URL string by the '@' symbol
var splitUrl = url.split('@');

// Get the second element in the splitUrl array (which contains the latitude and longitude)
var latLong = splitUrl[1];

// Split the latitude and longitude string by the ',' symbol
var latLongArr = latLong.split(',');

// Get the latitude and longitude values
var latitude = latLongArr[0];
var longitude = latLongArr[1];

 $("#latt").val(latitude);
$("#lngg").val(longitude);
          

           

        });

    });

</script>



