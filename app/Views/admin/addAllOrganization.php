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
}
</style> 

   <script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                               <h4 class="card-title">Assigned Organization Code</h4>
                            <!--    <form class="custom-validation"  method='post' action="VipController/saveAssignedUser" enctype='multipart/form-data'> -->
                                 <form class="custom-validation"  method='post' action="VipController/sample" enctype='multipart/form-data'>
                                 <?php echo view('admin/_topmessage'); ?>

                          <div class="for-mobile-laptop">                               
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-2 col-form-label">Organization Code(<?php echo $org['vip_code'];?>)</label>
                                    <div class="col-sm-2">

                                     <input type="text"  class="test-input text-center" name="org_code" maxlength="5" value="<?php echo $org['vip_code'];?>" readonly />

<!--<input type="text"  onkeyup="this.value = this.value.toUpperCase();" />-->

                                         <!-- <input class="test-input" type="text" max="5" />-->
                                  </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <input type="hidden" value="<?php echo (isset($org) && !empty($org)) ? $org['id'] : ''; ?>" name="id">
                                 <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            This Code All User Assigned
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

