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
                        <div class="card-title">Update Exchange Credential</div>
                    </div>

                    <div class="card-body col-lg-10">
                        <?php $this->load->view('admin/_topmessage'); ?>
                            <form class="card" id='add_member_form' method='post' action="<?php echo site_url('adminprofile/update_credential'); ?>" enctype='multipart/form-data'>
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange User Id</label>
                                                <input type="text" name="ex_user_id" id="ex_user_id" value="<?php echo $profile_data['ex_user_id']; ?>" class="form-control" placeholder="Exchange user id" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange API Key</label>
                                                <input type="text" name="ex_api_key" id="ex_api_key" value="<?php echo $profile_data['ex_api_key']; ?>" class="form-control" placeholder="Exchange API Key" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange Secrete Key</label>
                                                <input type="text" name="ex_api_secrete_key" id="ex_api_secrete_key" value="<?php echo $profile_data['ex_api_secrete_key']; ?>" placeholder="Exchange secrete key" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange User Name</label>
                                                <input type="text" class="form-control" placeholder="Exchange user name"  name="ex_user_name" value="<?php echo $profile_data['ex_user_name']; ?>"  readonly >
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange Email</label>
                                                <input type="text" class="form-control" placeholder="Exchange Email"  name="ex_user_email" value="<?php echo $profile_data['ex_user_email']; ?>"  readonly>
                                            </div>
                                        </div>

                                  </div>
                               </div>
                                <p><small> If you are first time adding details after submit your validity button will active. You have to validate by click validity button it will fetch all other data.</small></p>
                                <p><small> Once your validation will successfully other details populate automatically.</small></p>
                                <?php if($profile_data['ex_api_secrete_key']){ ?>
                                <p> <div class="col-sm-6 col-md-6"> <a href="<?php echo site_url('adminprofile/exvalidate');?>" class="btn btn-pill btn-info">Verify your details.</a></div></p>
                                
                                <?php } ?>
                                
                               <div class="card-footer text-right">                                 
                                  <button type="submit" class="btn btn-success pull-left">Submit</button>
                                  <a href="<?php echo site_url('adminDashboard'); ?>"> <button type="button" class="btn btn-danger pull-left" style="margin-left: 5px;">Cancel</button></a>
                               </div>
                            </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
