<?php $session = session(); ?>
<style>

.for-mobile-laptop {
  margin: 0 200px;
}
    @media only screen and (max-width: 600px) {
        .for-mobile-laptop {
            margin: 0;
        }
    }
    .mandatory {
        display:inline;
        color:red;
    }
	
	select {
  width: 400px;
  padding: 8px 16px;
}
select option {
  font-size: 14px;
  padding: 8px 8px 8px 28px;
  position: relative;
}
select option:before {
  content: "";
  position: absolute;
  height: 18px;
  width: 18px;
  top: 0;
  bottom: 0;
  margin: auto;
  left: 0px;
  border: 1px solid #ccc;
  border-radius: 2px;
  z-index: 1;
}
select option:checked:after {
  content: attr(data[count]);
  background: #fff;
  color: black;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 8px 8px 8px 28px;
  border: none;
}
select option:checked:before {
  border-color: blue;
  content: "\2713";
 height:20px;
  background-size: 10px;
  background-repeat: no-repeat;
  background-position: center;
}
</style> 

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Add New Menu</h4>
                            </div>
                        </div>

                        <form class="custom-validation"  method='post' action="MenuController/add_new_menu" enctype='multipart/form-data'>
                            <div class="for-mobile-laptop">

                              
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Company Name <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <?php if ($session->get('company_id')){ ?>
                                                    <input type="text" class="form-control" name="company_id" 
                                                    value="<?php if (($session->get('company_name')) && $session->get('company_arb_name')) {
                                                                    echo ($session->get('company_name')).' / '. ($session->get('company_arb_name'));
                                                                } else if ($session->get('company_arb_name')){
                                                                    echo ($session->get('company_arb_name'));
                                                                } else{
                                                                    echo ($session->get('company_name'));
                                                                 } ?>" readonly/>
                                                <?php } else { ?>
                                                <select name="company_id" class="form-control input-lg" id="state" required>
                                                    <option value="">- Please Select -</option>
                                                    <?php
                                                    foreach ($companies as $company) {
                                                        if (($company["company_name"]) && ($company["company_arb_name"])){
                                                        echo '<option value="' . $company["id"] . '">' . $company["company_name"].' / '.$company["company_arb_name"]. '</option>';
                                                    }
                                                       else if($company["company_arb_name"]){
                                                        echo '<option value="' . $company["id"] . '">' .$company["company_arb_name"]. '</option>';
                                                    }
                                                    else{
                                                        echo '<option value="' . $company["id"] . '">' .$company["company_name"]. '</option>';  
                                                    }
                                                }
                                            }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Branch <span class="mandatory">*</span></label>                                  
                                            <div class="col-sm-6">

                                    <?php if($session->get('company_id')){?>
									
							  <div class="row">
								   <div class="col-sm-1"></div>
							       <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"> </div>
								   <div class="col-sm-8  border float-lg-right">Select all</div>
								</div>
                                   <?php  foreach ($results as $row) { ?>
                                   <div class="row">
								   <div class="col-sm-1"></div>
                                   <div class="col-sm-2 border float-left"><input type="checkbox" required name="branch_id[]" class="checkhour" value="<?php echo $row->branch_id; ?>" ></div>
                                   <div class="col-sm-8 border float-lg-right"><?php echo $row->branch_name; ?></div>
                                                                   
                                   </div>	 
                                <?php } } else { ?>
                                                <select name="branch_id[]" id="city" class="form-control input-lg" multiple="multiple" required>
                                                    <option value="">Select Branch</option>
                                                </select> 
                                                
                                                <?php } ?>
                                            </div> 
                                        </div>							
								
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Menu Items</label>
                                            <div class="col-sm-6">
                                            <input type="file" name="menu_image[]" class="form-control" multiple>
                                            </div>
                                        </div>
										
								<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Start Date</label>
                               <div class="col-sm-6">
                                <input type="date" class="form-control" name="start_date" />
                               </div>
                             </div> 
							 
							 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">End Date</label>
                               <div class="col-sm-6">
                                <input type="date" class="form-control" name="end_date" />
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
                                        <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('Products'); ?>">
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
    $(document).ready(function () {
        $('#state').change(function () {
            var company_id = $('#state').val();
            var action = 'get_city';
            if (company_id != '')
            {
                $.ajax({
                    url: "<?php echo base_url('/index.php/ProductController/action'); ?>",
                    method: "POST",
                    data: {company_id: company_id, action: action},
                    dataType: "JSON",
                    success: function (data)
                    {
                        var html = '<option> All </option>';

                        for (var count = 0; count < data.length; count++)
                        {
                            html += '<option value="' + data[count].branch_id + '">' + data[count].branch_name + ' / ' + data[count].arb_branch_name + '</option>';
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
    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
</script>

<script>
$('option').mousedown(function(e) {
    e.preventDefault();
    var originalScrollTop = $(this).parent().scrollTop();
    console.log(originalScrollTop);
    $(this).prop('selected', $(this).prop('selected') ? false : true);
    var self = this;
    $(this).parent().focus();
    setTimeout(function() {
        $(self).parent().scrollTop(originalScrollTop);
    }, 0);
    
    return false;
});
</script>

<script>
$(function() {
  var filter = $('#city');
  filter.on('change', function() {
    if (this.selectedIndex) return; //not `Select All`
    filter.find('option:gt(0)').prop('selected', true);
    filter.find('option').eq(0).prop('selected', false);
  });
});
</script>

<script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>