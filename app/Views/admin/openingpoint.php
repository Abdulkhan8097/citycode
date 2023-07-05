<style type="text/css">
    .set{padding: calc(0px) calc(0px / 6) 59px calc(251px / 1);
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                    <?php echo view('admin/_topmessage'); ?>
                                 <h4 class="card-title">Set Opening Point ( New Registration )</h4>
					

                                 <form class="custom-validation"  method='post' action="<?php echo site_url("updateopeningpoint"); ?>" enctype='multipart/form-data'>
                            <div class="for-mobile-laptop">

                           
                                           <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Start Date</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" name="startdate" value="<?php echo $data->start_date; ?>"/>
                                            </div> 
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">End Date</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" name="enddate" value="<?php echo $data->end_date; ?>"/>
                                            </div> 
                                        </div>
								
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Opening Point</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="initialpoint" value="<?php echo $data->initial_point; ?>"/>
                                            </div> 
                                        </div>
								
                                        
                                        </div>

                            <div class="form-group row mb-0">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Submit
                                    </button> 
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
<div class="set">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                  
                                 <h4 class="card-title">Set Point ( One Time )</h4>
                    

                                 <form class="custom-validation"  method='post' action="<?php echo site_url("OpeningPoint/updatepoinr"); ?>" enctype='multipart/form-data'>
                            <div class="for-mobile-laptop">

                           
                                             <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Start Date</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" name="startdate1" value="<?php echo $data1->start_date1; ?>"/>
                                            </div> 
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">End Date</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" name="enddate1" value="<?php echo $data1->end_date1; ?>"/>
                                            </div> 
                                        </div>
                                
                                        <div class="form-group row">
                                            <label  class="col-sm-2 col-form-label">Opening Point</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="initialpoint1" value="<?php echo $data1->initial_point1; ?>"/>
                                            </div> 
                                        </div>
                                
                                        
                                        </div>

                            <div class="form-group row mb-0">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Submit
                                    </button> 
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



