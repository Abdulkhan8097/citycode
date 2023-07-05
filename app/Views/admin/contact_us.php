
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
        color: #6c757d !important;
    }
h4 {
        color: #000 !important;
    }

input {
    width: 100%
}


   
</style> 

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                    <?php echo view('admin/_topmessage'); ?>
                                 <h4 class="card-title">Contact Us</h4>
					

                        <form class="custom-validation"  method='post' action="Contact/update" enctype='multipart/form-data'>
                            <div class="for-mobile-laptop">

                           
                                           <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Phone No.</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="phone" value="<?php echo $row->phone; ?>"/>
                                            </div> 
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Whatsapp</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="whatsapp" value="<?php echo $row->whatsapp; ?>"/>
                                            </div> 
                                        </div>
								
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Instagram</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="instagram" value="<?php echo $row->instagram; ?>"/>
                                            </div> 
                                        </div>
								
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Mail</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="mail" value="<?php echo $row->mail; ?>"/>
                                            </div> 
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Location</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="location" value="<?php echo $row->location; ?>"/>
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
                       </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->    
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



