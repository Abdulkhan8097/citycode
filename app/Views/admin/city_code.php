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
                            <a class="btn btn-secondary waves-effect waves-light" href="<?php echo site_url('EditCompany?id='.$details->company_id); ?>">
                                <i class="ion ion-md-arrow-back"></i> Back
                            </a>
                       </div>
                    </div>
                </div>
						
      
<form class="custom-validation" id="vendor-form"  method='post' action="CompanyController/update_offer" enctype='multipart/form-data'>
<input type="hidden" id="offer_id" name="offer_id" value="<?php echo $details->id; ?>">
<input type="hidden" id="company_id" name="company_id" value="<?php echo $details->company_id; ?>">
					<?php if($details->coupon_type == 'city') { ?>
					
                       <h2> Edit City code Offer </h2>   
                           <div id="city_field">                   
							   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                     <select name="c_branch"  class="form-control input-lg" >
                                      <option value="">- Please Select -</option>
                                      <?php  foreach ($all_branch as $row) { 
                                                   if($row->branch_id == $details->branch_id ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                        <?php if(($row->branch_name) && ($row->arb_branch_name)) { ?>
                                           <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name.' / '.$row->arb_branch_name;?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name;?></option>
                                        <?php } } ?>                                 
                                  </select>
                                  </div>
                                </div>            
								
				                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="company_discount" id="txt1"  onKeyUp="numericFilter(this, sum());" value="<?php echo $details->company_discount;?>"/>
                                  </div> <div class="col-sm-1">%</div>
                                </div>
								
				                        <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="comission" id="txt2"  onKeyUp="numericFilter(this, sum());" value="<?php echo $details->comission;?>"/>
                                  </div> <div class="col-sm-1">%</div>
                                </div>
								
								                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="customer_discount" id="txt3" readonly value="<?php echo $details->customer_discount;?>"/>
                                  </div> <div class="col-sm-1">%</div>
                                </div>
								
								
								 <div class="form-group row" id="discount_item_p">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="c_disc_detail" >
                                    <option value="">- Please Select -</option>
                                      <?php  foreach ($discount_items as $item) { 
                                                   if($item['st_id'] == $details->discount_detail){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $item['st_id'] ?>" <?php echo $selected ?>><?php echo $item['st_name'].' / '.$item['st_arb_name'] ?></option>
                                           <?php } ?> 
                                  </select>
                                  </div>
                                </div>

                                <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                        <?php if ($details->custmise=="Yes") {?>
                                            <input style="width: 20px;" class="form-control" type="checkbox" id="offer_p"  cols="6" rows="4" checked  name="offer_p" value="<?php echo $details->custmise;?>">
                                       <?php }else{?>
                                        <input style="width: 20px;" class="form-control" type="checkbox" id="offer_p"  cols="6" rows="4"   name="offer_p" value="Yes">
                                        <?php } ?>
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_p" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name" name="offer_name" cols="6" rows="4" value="<?php echo $details->offer_name_cust;?>" placeholder="Offer Name"/><br>
                                       <input type="text" class="form-control" id="offer_name_arabic" name="offer_name_arabic" cols="6" rows="4" placeholder="Arabic Offer Name " value="<?php echo $details->offer_name_cust_arabic;?>" />
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                   <textarea class="form-control" name="c_description" cols="6" rows="4" placeholder="Enter Description"><?php echo $details->description;?></textarea><br>
                                   <textarea class="form-control" name="c_arb_description" cols="6" rows="4" placeholder="Arebic Description"><?php echo $details->arb_description;?></textarea>

                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="c_start" 
										value="<?php if(!empty($details->start_date)) { echo date('Y-m-d', strtotime($details->start_date)); } ?>"/>
                                   </div>
                                 </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_end" 
									   value="<?php if(!empty($details->end_date)) { echo date('Y-m-d', strtotime($details->end_date)); } ?>"/>   
                                   </div> 
                                  </div> 
								  
								  <!------------------------------------- priority start here------------------------->
						
							<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">
						<select name="c_priority"  class="form-control input-lg">
                                                  <option value="">- Please Select -</option>
                                                    <?php
                                                    foreach ($priorities as $prio) {
                                                        if ($prio == $details->priority) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $prio; ?>" <?php echo $selected ?>><?php echo $prio; ?></option>
                                                 <?php } ?>
                                                </select>  													
                                        </div>
                                    </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_priority_start" 
									   value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->priority_start)); } ?>"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="c_priority_end" 
									   value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->priority_end)); } ?>"/>                                      
                                   </div>        
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                        <?php if ($details->mall =="Yes") {?>
                                           <input style="width: 20px;" class="form-control" type="checkbox" id="mall_p"  checked  cols="6" rows="4"  name="mall" value="Yes">
                                        <?php } else{ ?>
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_p"  cols="6" rows="4"  name="mall" value="Yes">
                                       <?php } ?> 
                                   </div>
                                </div>

                                

                                <div class="form-group row" id="mall_div1" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <?php if ($details->mall_name == $mall['id']) {?>
                                            <option value="<?php echo $mall['id']; ?>" selected > <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php  }else{?>
                                            <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?>  </option>
                                        <?php } } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div2" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic"  cols="6" rows="4"  name="mall_name_arabic" value="<?php  echo $details->mall_name_arabic ?>">
                                  </div>
                                </div> -->
								 
	                       <!------------------------------------- priority end here------------------------->
							  </div>                            
                             <?php }  ?>
							 
							 
						<?php if($details->coupon_type == 'vip') { ?>
						   <h2> Edit V.I.P code Offer </h2>
                 <div id="city_field"> 
                                 
							<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                    <select name="fam_branch"  class="form-control input-lg" >
                                      <option value="">- Please Select -</option>
                                      <?php  foreach ($all_branch as $row) { 
                                                   if($row->branch_id == $details->branch_id ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                        <?php if(($row->branch_name) && ($row->arb_branch_name)) { ?>
                                           <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name.' / '.$row->arb_branch_name;?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name;?></option>
                                        <?php } } ?>                                  
                                  </select>
                                  </div>
                                </div>
								
				                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="fam_company_discount" id="txt10" onKeyUp="numericFilter(this, famsum());" value="<?php echo $details->company_discount;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
							                	<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="fam_comission" id="txt20" onKeyUp="numericFilter(this, famsum());" value="<?php echo $details->comission;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="fam_customer_discount" id="txt30" readonly value="<?php echo $details->customer_discount;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
								    <div class="form-group row" id="discount_item_v">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fam_disc_detail" >
                                    <option value="">- Please Select -</option>
                                    <?php  foreach ($discount_items as $item) { 
                                                   if($item['st_id'] == $details->discount_detail){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $item['st_id'] ?>" <?php echo $selected ?>><?php echo $item['st_name'].' / '.$item['st_arb_name'] ?></option>
                                           <?php } ?> 	
                                  </select>
                                  </div>
                                </div>

                                 <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                      <?php if ($details->custmise=="Yes") {?>
                                            <input style="width: 20px;" class="form-control" type="checkbox" id="offer_v"  cols="6" rows="4" checked  name="offer_p" value="<?php echo $details->custmise;?>">
                                       <?php }else{?>
                                        <input style="width: 20px;" class="form-control" type="checkbox" id="offer_v"  cols="6" rows="4"   name="offer_p" value="Yes">
                                        <?php } ?>
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_v" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name1" name="offer_name" cols="6" rows="4" value="<?php echo $details->offer_name_cust;?>" placeholder="Offer Name"/><br>
                                       <input type="text" value="<?php echo $details->offer_name_cust_arabic;?>" class="form-control" id="offer_name_arabic1" name="offer_name_arabic" cols="6" rows="4" placeholder="Arabic Offer Name "/>
                                  </div>
                                </div>

                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-6">
                                  <textarea class="form-control" name="fam_description" cols="6" rows="4" placeholder="Enter Description"><?php echo $details->description;?></textarea>  <br>                          

                                  <textarea class="form-control" name="fam_arb_description" cols="6" rows="4" placeholder="Arebic Description"><?php echo $details->arb_description;?></textarea>                            
                                </div>
                            </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="fam_start" 
										value="<?php if(!empty($details->start_date)) { echo date('Y-m-d', strtotime($details->start_date)); } ?>"/>
                                   </div>
                                 </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_end" 
									   value="<?php if(!empty($details->end_date)) { echo date('Y-m-d', strtotime($details->end_date)); } ?>"/> 
                                   </div>
                                  </div>
								  
			 <!------------------------------------- priority start here------------------------->
						
			<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">
                                    <select name="fam_priority"  class="form-control input-lg">
                                                  <option value="">- Please Select -</option>
                                                    <?php
                                                    foreach ($priorities as $prio) {
                                                        if ($prio == $details->priority) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $prio; ?>" <?php echo $selected ?>><?php echo $prio; ?></option>
                                                 <?php } ?>
                                                </select> 
                                </div>
                              </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_priority_start" 
									   value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->priority_start)); } ?>"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fam_priority_end" 
									   value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->priority_end)); } ?>"/>                                      
                                   </div>        
                                 </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                        <?php if ($details->mall =="Yes") {?>
                                           <input style="width: 20px;" class="form-control" type="checkbox" id="mall_v"  checked  cols="6" rows="4"  name="mall" value="Yes">
                                        <?php } else{ ?>
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_v"  cols="6" rows="4"  name="mall" value="Yes">
                                       <?php } ?> 
                                   </div>
                                </div>

                                <!-- <div class="form-group row" id="mall_div3" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name1"  cols="6" rows="4"  name="mall_name" value="<?php echo $details->mall_name ?>">
                                  </div>
                                </div> -->

                                <div class="form-group row" id="mall_div3" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <?php if ($details->mall_name == $mall['id']) {?>
                                            <option value="<?php echo $mall['id']; ?>" selected > <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php  }else{?>
                                            <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?>  </option>
                                        <?php } } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div4" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic1"  cols="6" rows="4"  name="mall_name_arabic" value="<?php  echo $details->mall_name_arabic ?>">
                                  </div>
                                </div>
								  -->
	                       <!------------------------------------- priority end here------------------------->
								</div>                            
                           <?php } ?>
						   
						   
			<?php if($details->coupon_type == 'friday') { ?>
			  <h2> Edit Friday code Offer </h2>
                                 <div id="city_field"> 
	                             <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Branch <span class="mandatory">*</span></label>
                                    <div class="col-sm-6">
                                   <select name="fri_branch"  class="form-control input-lg" >
                                      <option value="">- Please Select -</option>
                                      <?php  foreach ($all_branch as $row) { 
                                                   if($row->branch_id == $details->branch_id ){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                        <?php if(($row->branch_name) && ($row->arb_branch_name)) { ?>
                                           <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name.' / '.$row->arb_branch_name;?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $row->branch_id ?>" <?php echo $selected ?>><?php echo $row->branch_name;?></option>
                                        <?php } } ?>                               
                                  </select>
                                  </div>
                                </div>
                                  
 											
				            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Company Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Company Discount" name="fri_company_discount" id="txt40"  onKeyUp="numericFilter(this, frisum());" value="<?php echo $details->company_discount;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
							<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">City Code Benefits </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter City Code Benefits" name="fri_comission" id="txt50"  onKeyUp="numericFilter(this, frisum());" value="<?php echo $details->comission;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
							<div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> Customer Discount </label>
                                    <div class="col-sm-6">
                                     <input type="text" class="form-control" placeholder="Enter Customer Discount" name="fri_customer_discount" id="txt60" readonly value="<?php echo $details->customer_discount;?>"/>
                                  </div><div class="col-sm-1">%</div>
                                </div>
								
			                <div class="form-group row" id="discount_item_c">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Discount Items </label>
                                    <div class="col-sm-6">
                                 <select class="form-control" name="fri_disc_detail" >
                                    <option value="">- Please Select -</option>
                                    <?php  foreach ($discount_items as $item) { 
                                                   if($item['st_id'] == $details->discount_detail){
                                                       $selected = 'selected="selected"';
                                                   } else {
                                                        $selected = '';
                                                   }
                                               ?>
                                           <option value="<?php echo $item['st_id'] ?>" <?php echo $selected ?>><?php echo $item['st_name'].' / '.$item['st_arb_name'] ?></option>
                                           <?php } ?>  
                                </select>
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Customize Offer</label>
                                    <div class="col-sm-6">
                                        <?php if ($details->custmise=="Yes") {?>
                                            <input style="width: 20px;" class="form-control" type="checkbox" id="offer_c"  cols="6" rows="4" checked  name="offer_p" value="<?php echo $details->custmise;?>">
                                       <?php }else{?>
                                        <input style="width: 20px;" class="form-control" type="checkbox" id="offer_c"  cols="6" rows="4"   name="offer_p" value="Yes">
                                        <?php } ?>
                                  </div>
                                </div> -->

                                <div class="form-group row" id="offer_ctsmise_c" style="display:none">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Offer Name</label>
                                    <div class="col-sm-6">
                                       <input type="text" class="form-control" id="offer_name2" name="offer_name" cols="6" rows="4" value="<?php echo $details->offer_name_cust;?>" placeholder="Offer Name"/><br>
                                       <input type="text" class="form-control" id="offer_name_arabic2" name="offer_name_arabic" value="<?php echo $details->offer_name_cust_arabic;?>" cols="6" rows="4" placeholder="Arabic Offer Name "/>
                                  </div>
                                </div>

                            <div class="form-group row">
                              <label for="inputPassword" class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-6">
                                         <textarea class="form-control" name="fri_description" cols="6" rows="4" placeholder="Enter Description"><?php echo $details->description;?></textarea>
                                         <textarea class="form-control" name="fri_arb_description" cols="6" rows="4" placeholder="Arebic Description"><?php echo $details->arb_description;?></textarea>
                                  </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Start Date / Time</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" name="fri_start" 
										value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->start_date)); } ?>"/>
                                   </div>
                                 </div>

                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">End Date / Time</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_end" 
									   value="<?php if(!empty($details->priority_start)) { echo date('Y-m-d', strtotime($details->end_date)); } ?>"/>
                                   </div>
                                  </div>
								  
								  <!------------------------------------- priority start here------------------------->
						
							<div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Priority Lavel</label>
                                  <div class="col-sm-6">
                                   <select name="fri_priority"  class="form-control input-lg">
                                                  <option value="">- Please Select -</option>
                                                    <?php
                                                    foreach ($priorities as $prio) {
                                                        if ($prio == $details->priority) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $prio; ?>" <?php echo $selected ?>><?php echo $prio; ?></option>
                                                 <?php } ?>
                                                </select> 
                                </div>
                              </div>
							  
								  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority Start Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_priority_start" value="<?php echo date('Y-m-d', strtotime($details->priority_start));?>"/>                                      
                                   </div>        
                                 </div>
								 
								   <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Priority End Date</label>
                                    <div class="col-sm-6">
                                       <input type="date" class="form-control" name="fri_priority_end" value="<?php echo date('Y-m-d', strtotime($details->priority_end));?>"/>                                      
                                   </div>        
                                 </div>

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall</label>
                                    <div class="col-sm-6">
                                        <?php if ($details->mall =="Yes") {?>
                                           <input style="width: 20px;" class="form-control" type="checkbox" id="mall_f"  checked  cols="6" rows="4"  name="mall" value="Yes">
                                        <?php } else{ ?>
                                       <input style="width: 20px;" class="form-control" type="checkbox" id="mall_f"  cols="6" rows="4"  name="mall" value="Yes">
                                       <?php } ?> 
                                   </div>
                                </div>

                                <!-- <div class="form-group row" id="mall_div5" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name2"  cols="6" rows="4"  name="mall_name" value="<?php echo $details->mall_name ?>">
                                  </div>
                                </div> -->

                                 <div class="form-group row" id="mall_div5" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Name</label>
                                    <select name="mall_name"  class="col-sm-6 form-control input-lg">
                                        <option value="">- Please Select -</option>
                                        <?php if($mall_list) { foreach ($mall_list as $mall) { ?>
                                        <?php if ($details->mall_name == $mall['id']) {?>
                                            <option value="<?php echo $mall['id']; ?>" selected > <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?> </option>
                                        <?php  }else{?>
                                            <option value="<?php echo $mall['id']; ?>"> <?php echo $mall['mall_name'].'/'.$mall['arabic_mall_name']; ?>  </option>
                                        <?php } } } ?>
                                  </select>
                                </div>

                                <!-- <div class="form-group row" id="mall_div6" style="display:none;">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mall Arabic</label>
                                    <div class="col-sm-6">
                                       <input  class="form-control" id="mall_name_arabic2"  cols="6" rows="4"  name="mall_name_arabic" value="<?php  echo $details->mall_name_arabic ?>">
                                  </div>
                                </div> -->
								 
	                       <!------------------------------------- priority end here------------------------->
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

<!--------------- famous code -------------------------->

<script>

$(document).ready(function(){
	
    $('#famstate').change(function(){

        var state_id = $('#famstate').val();

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
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
                    }

                    $('#famcity').html(html);
                }
            });
        }
        else
        {
            $('#famcity').val('');
        }

    });

});

</script>

<!------------- friday code ------------------------------->

<script>

$(document).ready(function(){
	
    $('#fristate').change(function(){

        var state_id = $('#fristate').val();

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
                        html += '<option value="'+data[count].city_id+'">'+data[count].city_name+'</option>';
                    }

                    $('#fricity').html(html);
                }
            });
        }
        else
        {
            $('#fricity').val('');
        }

    });


    $(document).on('click', '#mall_p', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div1").show();
            $("#mall_div2").show();
            $("#mall_name").attr("required", "required");
            $("#mall_name_arabic").attr("required", "required");
           
            
        }else{
            $("#mall_div1").hide();
            $("#mall_div2").hide();
            $('#mall_name').removeAttr("required","");
            $('#mall_name_arabic').removeAttr("required","");
        }
      });

      $(document).on('click', '#mall_v', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div3").show();
            $("#mall_div4").show();
            $("#mall_name1").attr("required", "required");
            $("#mall_name_arabic1").attr("required", "required");
           
            
        }else{
            $("#mall_div3").hide();
            $("#mall_div4").hide();
            $('#mall_name1').removeAttr("required","");
            $('#mall_name_arabic1').removeAttr("required","");
        }
      });

      $(document).on('click', '#mall_f', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#mall_div5").show();
            $("#mall_div6").show();
            $("#mall_name2").attr("required", "required");
            $("#mall_name_arabic2").attr("required", "required");
           
            
        }else{
            $("#mall_div5").hide();
            $("#mall_div6").hide();
            $('#mall_name2').removeAttr("required","");
            $('#mall_name_arabic2').removeAttr("required","");
        }
      });

      var checked_mall_p =$("#mall_p").is(":checked");
      if (checked_mall_p==true) {
            $("#mall_div1").show();
            $("#mall_div2").show();
            $("#mall_name").attr("required", "required");
            $("#mall_name_arabic").attr("required", "required");
      }
      var checked_mall_p =$("#mall_v").is(":checked");
      if (checked_mall_p==true) {
            $("#mall_div3").show();
            $("#mall_div4").show();
            $("#mall_name1").attr("required", "required");
            $("#mall_name_arabic1").attr("required", "required");
      }

      var checked_mall_p =$("#mall_f").is(":checked");
      if (checked_mall_p==true) {
           $("#mall_div5").show();
            $("#mall_div6").show();
            $("#mall_name2").attr("required", "required");
            $("#mall_name_arabic2").attr("required", "required");
      }


      $(document).on('click', '#offer_p', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_p").show();
            $("#discount_item_p").hide();
            $("#offer_name").attr("required", "required");
            $("#offer_name_arabic").attr("required", "required");
        }else{
            $("#offer_ctsmise_p").hide();
            $("#discount_item_p").show();
            $('#offer_name').removeAttr("required","");
            $('#offer_name_arabic').removeAttr("required","");
        }
      });
      $(document).on('click', '#offer_v', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_v").show();
            $("#discount_item_v").hide();
            $("#offer_name1").attr("required", "required");
            $("#offer_name_arabic1").attr("required", "required");
        }else{
            $("#offer_ctsmise_v").hide();
            $("#discount_item_v").show();
            $('#offer_name1').removeAttr("required","");
            $('#offer_name_arabic1').removeAttr("required","");
        }
      });
      $(document).on('click', '#offer_c', function(){  
        //var button_id = $(this).attr("id");   
        if ($(this).prop('checked')==true){ 
            $("#offer_ctsmise_c").show();
            $("#discount_item_c").hide();
            $("#offer_name2").attr("required", "required");
            $("#offer_name_arabic2").attr("required", "required");
        }else{
            $("#offer_ctsmise_c").hide();
            $("#discount_item_c").show();
            $('#offer_name2').removeAttr("required","");
            $('#offer_name_arabic2').removeAttr("required","");
        }
      });

      var checked_offer =$("#offer_p").is(":checked");
      if (checked_offer==true) {
            $("#offer_ctsmise_p").show();
            $("#discount_item_p").hide();
            $("#offer_name").attr("required", "required");
            $("#offer_name_arabic").attr("required", "required");
      }

      var checked_offer =$("#offer_v").is(":checked");
      if (checked_offer==true) {
            $("#offer_ctsmise_v").show();
            $("#discount_item_v").hide();
            $("#offer_name1").attr("required", "required");
            $("#offer_name_arabic1").attr("required", "required");
      }


      var checked_offer =$("#offer_c").is(":checked");
      
      if (checked_offer==true) {
             $("#offer_ctsmise_c").show();
            $("#discount_item_c").hide();
            $("#offer_name2").attr("required", "required");
            $("#offer_name_arabic2").attr("required", "required");
      }

});

</script>

<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}
</script>