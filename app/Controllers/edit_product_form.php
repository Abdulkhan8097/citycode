<?php $session = session(); ?>
<style>
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
}.fa {
color:red !important;
}
</style> 

<style>
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

                    <?php echo view('admin/_topmessage'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Edit Product</h4>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="card-title">Arebic</h4>
                            </div>
                        </div><br>

                        <form class="custom-validation"  method='post' action="ProductController/update" enctype='multipart/form-data'>
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="for-mobile-laptop">
                                
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Company Name <span class="mandatory">*</span></label>
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
                                                    <option value="">Please Select</option>                                        
                                                    <?php
                                                    foreach ($companies as $row) {
                                                        if ($row['id'] == $product['company_id']) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                    <?php if (($row["company_name"]) && ($row["company_arb_name"])){ ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'].' / '.$row['company_arb_name'];?></option>
                                                    <?php } else if ($row["company_arb_name"]) { ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_arb_name'];?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['company_name'];?></option>                                                    
                                                        <?php } } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">   
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>                                  
                                            <div class="col-sm-6">
 <?php if ($session->get('company_id')){ ?>
											
						<div class="row">
						   <div class="col-sm-1"> </div>		
						      <?php $gidz = explode(',', $product['branch_id']); ?>
						       <div class="col-sm-2 border float-left"><input type="checkbox" name="checkall" id="checkall"
							 <?php if(count($results) == count($gidz)) { echo "checked" ; } ?> > </div>
						     <div class="col-sm-8 border float-lg-right">Select All</div>
						  </div>
                                        <?php
                                            $gidz = explode(',', $product['branch_id']);
                                            foreach ($results as $row) {
                                        ?>
                                 <div class="row">
				   <div class="col-sm-1"></div>
                                     <div class="col-sm-2 border float-left">
					<input type="checkbox" class="checkhour" required name="branch_id[]" value="<?php echo $row->branch_id; ?>" 
					<?php if (in_array($row->branch_id, $gidz)) { echo "checked"; } ?>></div>
                                                    
                                        <div class="col-sm-8 border float-lg-right"><?php echo $row->branch_name; ?></div>
                                        </div>	 
                                      <?php } } else { ?>
                                                <select name="branch_id[]" id="city" class="form-control input-lg" multiple="multiple" required>
                                                    <option value="">Select Branch</option>
                                                   
                                                    <?php
							$gidz = explode(',', $product['branch_id']);
							foreach ($results as $row) { 
							if(in_array($row->branch_id, $gidz)){
							$selected = 'selected="selected"';
                                                        } else {
                                                        $selected = '';
                                                        }                                                    
                                                    ?>
                                           <option value="<?php echo $row->branch_id?>" <?php echo $selected ?>><?php echo $row->branch_name; ?></option>
                                           <?php } ?>
                                               </select>  <?php } ?>   
                                            </div> 
                                        </div>
                                    </div>
                                </div>
								
				<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Name <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" required  name="product_name" value="<?php echo $product['product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="arb_product_name" value="<?php echo $product['arb_product_name']; ?>"/>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Product Description <span class="mandatory"></span></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description" cols="6" rows="4" ><?php echo $product['description']; ?></textarea>
                                                
                                            </div></div> </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="arb_description" cols="6" rows="4" ><?php echo $product['arb_description']; ?></textarea>
                                                
                                            </div></div> </div> 
                                </div>
                             
                        <div class="row">
                           <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Picture <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                        <?php if (!empty($product['picture'])) { ?>
					                        <img src="<?php echo base_url('product/'.$product['picture']);?>" height=190 width=190 class="img-fluid"> 
                                         <?php } else { ?> <?php } ?> <br> <br>
                                            <input type="file" name="picture" /> 
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Original Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="org_price" class="form-control" placeholder="Original Price" name="original_price" onKeyUp="numericFilter(this);" value="<?php echo $product['original_price']?>"; required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Discount<span class="mandatory"></span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="discount_per" placeholder="Discount percentage" name="discount_per"  value="<?php echo $product['discount_per'];?>" onKeyUp="numericFilter(this, sum());" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Price <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Price" name="price" id="price" onKeyUp="numericFilter(this);" required readonly value="<?php echo $product['price'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
						     <div class="row">
                                <div class="col-md-6">
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Menu List</label>
									
                     <div class="col-sm-6">
                                     <?php if($images) { foreach ($images as $img) { ?>
					  <div class="col-sm-2 mandatory">
					     <img src="<?php echo base_url('product/'.$img->image_name); ?>" height=60 width=60 class="img-fluid" style="margin-top:10px;"> 
						<a href="<?php echo site_url('DeleteProductImage?id='.$img->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
					  </div>
					<?php } } else { ?> <?php } ?>
                                        <input type="file" name="image_name[]" class="form-control" multiple>
                                    </div>
                                </div>
							</div>
						</div>
								

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" required name="status"/>
<?php if ($product['status'] == 1) { ?>
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
                            </div>

                            <div class="form-group row mb-0">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Update
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
                        var html = '<option value="">All</option>';

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
<script type="text/javascript">
    function sum() {
       // alert('in');
        var final_org_amount = 0;
        var txtFirstNumberValue = document.getElementById('org_price').value||0;
        var txtSecondNumberValue = document.getElementById('discount_per').value||0;
        var result = parseInt(txtFirstNumberValue)*parseInt(txtSecondNumberValue)/100;
        final_org_amount =parseInt(txtFirstNumberValue)-parseInt(result);
        //alert(final_org_amount);
        if (!isNaN(final_org_amount)) {
            document.getElementById('price').value = final_org_amount;
        }
    }
</script>
<script>
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>