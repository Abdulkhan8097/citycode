<style>
label.error{
   color:red;
}
</style>
<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Update Profile</div>
                    </div>

                    <div class="card-body col-lg-10">
                        <?php echo view('admin/_topmessage'); ?>
                            <form class="card" id='add_member_form' method='post' action="<?php echo site_url('updatepassword'); ?>" enctype='multipart/form-data'>
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-sm-6 col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">Old Password</label>
                                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="cnf_new_password" placeholder="Confirm Password" class="form-control" required>
                                            </div>
                                        </div>

                                  </div>
                               </div>
                               <div class="card-footer text-right">
                                 
                                  <button type="submit" class="btn btn-success pull-left">Submit</button>
                                  <a href="<?php echo site_url('dashboard'); ?>"> <button type="button" class="btn btn-danger pull-left" style="margin-left: 5px;">Cancel</button></a>
                               </div>
                            </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
