<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Site Setting</div>
                    </div>

                    <div class="card-body">
                        <?php $this->load->view('admin/_topmessage'); ?>
                            <form action="<?php echo site_url('adminSetting/Uploadsettingview');?>" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8">
                                            <div class="form-group">                                                
                                                <label class="form-label">Site Name</label>
                                                <input type="text" class="form-control" size="25" value="<?php echo $viewData['SITE_NAME']; ?>" name="SITE_NAME" >
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Site Logo</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="SITE_LOGO" name="SITE_LOGO" >
                                                    <label class="custom-file-label">Upload Logo</label>
                                                </div>
                                                
                                                <div id="divUploadedImages" style="float:left; padding-left: 4px;">
                                                <?php
                                                        if($viewData['SITE_LOGO'] != ""){
                                                            $htmlpath = base_url("/assets/images/".$viewData['SITE_LOGO']);
                                                            ?>
                                                                <div>
                                                                    <img src='<?php echo $htmlpath; ?>' height='70' width='70'/><br/>

                                                                </div>
                                                      <?php  } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Admin Side Logo</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="ADMIN_SITE_LOGO" name="ADMIN_SITE_LOGO" >
                                                    <label class="custom-file-label">Upload Admin Logo</label>
                                                </div>
                                            <div id="divUploadedImages" style="float:left; padding-left: 4px;">
                                            <?php
                                                    if($viewData['ADMIN_SITE_LOGO'] != ""){
                                                        $htmlpath = base_url('assets/images/'.$viewData['ADMIN_SITE_LOGO']);
                                                        ?>
                                                            <div>
                                                                <img src='<?php echo $htmlpath; ?>' height='70' width='70'/><br/>

                                                            </div>
                                                  <?php  } ?>
                                            </div>
                                            </div>
                                        </div>                                        

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Contact Number</label>
                                                <input type="number" class="form-control"  value="<?php echo $viewData['CONTACT_PHONE'] != ''? $viewData['CONTACT_PHONE'] : '' ?>"  name="CONTACT_PHONE">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Contact Email</label>
                                                <input type="text" class="form-control"  value="<?php echo $viewData['CONTACT_EMAIL'] != '' ? $viewData['CONTACT_EMAIL'] : '' ?>" name="CONTACT_EMAIL">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="heading-success col-md-12 ">
                                            <h3 class="card-title">SMTP Email Setting:</h3>
                                         </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">SMTP Email Host:</label>
                                                <input type="text" class="form-control"  value="<?php echo $viewData['SMTP_EMAIL_HOST'] != '' ? $viewData['SMTP_EMAIL_HOST'] : '' ?>" name="SMTP_EMAIL_HOST">
                                            </div>
                                        </div>

                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">SMTP PORT:</label>
                                                <input type="text" class="form-control"  value="<?php echo $viewData['SMTP_EMAIL_PORT'] != '' ? $viewData['SMTP_EMAIL_PORT'] : '' ?>" name="SMTP_EMAIL_PORT">
                                            </div>
                                        </div>
                                            
                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">SMTP Email:</label>
                                                <input type="text" class="form-control" size="80" value="<?php echo $viewData['SMTP_EMAIL'] != '' ? $viewData['SMTP_EMAIL'] : '' ?>" name="SMTP_EMAIL">
                                            </div>
                                        </div>
                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">SMTP Email Password:</label>
                                                <input type="text" class="form-control" size="80" value="<?php echo $viewData['SMTP_EMAIL_PASSWORD'] != '' ? $viewData['SMTP_EMAIL_PASSWORD'] : '' ?>" name="SMTP_EMAIL_PASSWORD">
                                            </div>
                                        </div>
                                        </div>

                                        <div class="heading-info col-md-12 ">
                                            <h3 class="card-title">Exchange Setting:</h3>
                                         </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchanges:</label>
                                                <input type="text" class="form-control"  value="<?php echo $viewData['EX_EXCHANGE'] != '' ? $viewData['EX_EXCHANGE'] : '' ?>" name="EX_EXCHANGE">
                                                <span><small>Add Comma separated multiple exchange name.</small></span>
                                            </div>
                                        </div>

                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange Product Type:</label>
                                                <input type="text" class="form-control"  value="<?php echo $viewData['EX_PRODUCT'] != '' ? $viewData['EX_PRODUCT'] : '' ?>" name="EX_PRODUCT">
                                                <span><small>Add Comma separated multiple exchange product.</small></span>
                                            </div>
                                        </div>

                                            <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Exchange Order Type:</label>
                                                <input type="text" class="form-control" size="80" value="<?php echo $viewData['EX_ORDER_TYPE'] != '' ? $viewData['EX_ORDER_TYPE'] : '' ?>" name="EX_ORDER_TYPE">
                                                <span><small>Add Comma separated multiple order type.</small></span>
                                            </div>
                                        </div>
                                            
                                        </div>
                                  
                               </div>                               

                               <div class="card-footer text-right">                                 
                                  <button type="submit" class="btn btn-success pull-left">Submit</button>
                                 <a href="<?php echo site_url('adminMenuList/settings');?>"><button type="button" class="btn btn-danger pull-left" style="margin-left: 5px;">Cancel</button></a>
                               </div>
                            </form>
                         <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/footer'); ?>
</div>