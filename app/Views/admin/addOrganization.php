<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Assign Organization</h4>
                               <form class="custom-validation"  method='post' action="VipController/saveORG" enctype='multipart/form-data'>
                                 <?php echo view('admin/_topmessage'); ?>

                          <div class="for-mobile-laptop">                               
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">V.I.P Code<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">

                               <select name="vip" class="form-control" required>
                                 <option selected disabled>--Select vip code--</option>
                                 <?php if(isset($vip) && !empty($vip)){
                                    foreach ($vip as $key => $value) {
                                        ?>
                                 <option value="<?php echo $value['id']; ?>" <?php echo (isset($edit_product) && !empty($edit_product) && $edit_product['id']==$value['id']) ? 'selected' : ''; ?>>
                                    <?php echo $value['vip_code']; ?>
                                 </option>
                                 <?php }
                                    } ?>          
                              </select>
                                  </div>
                                </div>
                                  <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">Organization Name(English)<span class="mandatory">*</span></label>
                                    <div class="col-sm-6">

                               <input name="org_name" type="text" class="form-control"  placeholder="Name of Organization" required>
                                  </div>
                                </div>
                                 <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">Organization Name(Arabic)</label>
                                    <div class="col-sm-6">

                               <input name="arb_name" type="text" class="form-control"  placeholder="Name of Organization" >
                                  </div>
                                </div>
                                 <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">

                               <input name="org_email" type="email" class="form-control"  placeholder="email" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">Mobile NO.</label>
                                    <div class="col-sm-6">

                               <input name="org_phone" type="number" class="form-control"  placeholder="phone" >
                                  </div>
                                </div>

                                 


                                <div class="form-group row mb-0">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                      
                                        
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
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