<style>
.mandatory {
     display:inline;
     color:red;
 }
  
.col-sm-4 { 
   color: #000;
}
.col-sm-8{ 
   color: #000;
}
.font-size-20{
color: #000;
}
label{
color: #000 !important;
}
 .btn-primary{
color: #000 !important;
}
.table td {
padding: .30rem;
}
</style>

		
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">                  
                        <div class="card-body"> 
			             <?php echo view('admin/_topmessage'); ?>
						 <div class="row">
                            <div class="col-lg-3"> 
                               <h4 class="card-title">Edit Employee</h4>     
                          </div>                        
                    </div>
                  <hr>
                         <form class="custom-validation"  method='post' action="EmployeeController/update" enctype='multipart/form-data'>	
			 <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $row->id; ?>">			 				
                            <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Name<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                 <input type="text" class="form-control" placeholder="Enter Name" name="name" value="<?php echo $row->name; ?>"/>
                                </div>
                              </div> 
					
					
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Mobile No<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                 <input type="text" class="form-control" placeholder="Enter Mobile No" name="mobileno" value="<?php echo $row->mobileno; ?>"/>
                                </div>
                              </div>

                               <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Email Id<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                 <input type="text" class="form-control" placeholder="Enter Email Id" name="email" value="<?php echo $row->email; ?>"/>
                                </div>
                              </div> 

                                 <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-6">
					<input type="password" id="pass2" class="form-control" placeholder="Password" name="password"/>
                                  </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Re-Type Password</label>
                                    <div class="col-sm-6">
                                      <input type="password" class="form-control" data-parsley-equalto="#pass2" placeholder="Re-Type Password" name="rep_password"/>
                                  </div>
                                </div>	



                                    
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" required name="status"/>
                                           <?php if ($row->status == 1) { ?>
                                                    <option selected value="1">Active</option>
                                                    <option value ="0">Inactive</option>
                                           <?php } else { ?>
                                                    <option value="1">Active</option>
                                                    <option selected value ="0">Inactive</option>
                                            <?php } ?>
                                                </select>
 
                                            </div>
                                        </div>
                                  
                               
								
							  
			 <div class="form-group row mb-0">
                              <label for="inputPassword" class="col-sm-2 col-form-label"></label>
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
$("#checkall").change(function () {
    $('.checkhour').prop('checked', $(this).prop("checked"));
});
</script>

