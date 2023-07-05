<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <?php echo view('admin/_topmessage'); ?>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Update Profile</div>
                    </div>

                    <div class="card-body col-lg-10">
                        <!-- <div class="col-lg-8"> -->
                            <form class="card" id='add_member_form' method='post' action="<?php echo site_url('updateprofile'); ?>" enctype='multipart/form-data'>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"> Name</label>
                                                <input type="text" class="form-control" name="first_name" value="<?php echo $profile_data['name']; ?>" placeholder=" Name"  required="">
                                            </div>
                                        </div>
                                        
                                        </div>

                                  </div>
                               </div>
                               <div class="card-footer text-right">                                 
                                  <button type="submit" class="btn btn-success pull-left">Submit</button>
                                  <button type="button" class="btn btn-danger pull-left" style="margin-left: 5px;">Cancel</button>
                               </div>
                            </form>
                         <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
