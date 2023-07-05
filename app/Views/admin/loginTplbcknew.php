 <style>

.btn-primary:hover { 
    background-color: #F6D000 !important;
    border-color: #F6D000 ;
}
</style>

   <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="font-size-20" style="color:black !important;">Welcome Back !</h5>
                                <p class="50" style="color:black;" >Sign in to continue to City Code</p>
                            </div>
                        </div>

                        <div class="card-body p-4">

                               <center> <a href="<?php echo site_url("admin");?>" >
                                    <img src="<?php echo base_url('admin/images/city-logo.jpg'); ?>" height="50" alt="logo">
                                </a> </center>

                            <div class="p-3">


                                <form class="form-horizontal mt-4" method="post" role="form" name="loginForm" id="loginForm" action="<?php echo site_url("admin/index");?>" >

                                	<?php echo \Config\Services::validation()->listErrors(); ?>
                                    <?php echo csrf_field() ?>
                                    <?php echo view('admin/_topmessage'); ?>

                                    <div class="form-group">
                                        <label for="username">Email Id</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Email Id" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required="">
                                    </div>
                                    <?php if (!isset($_COOKIE['otpno'])) {?>
                                        <div class="form-group">
                                                <label for="password">OTP</label>
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-9 row">
                                                <input type="password"  class="form-control" id="otp" name="otp" placeholder="Enter OTP" required="">
                                            </div>
                                            <div class="col-sm-1">
                                            </div>
                                            <div class="col-sm-2 row">
                                                <a onclick="generateotp();" class="btn btn-primary form-control w-md waves-effect waves-light" style="color:black;">Generate</a>
                                            </div>
                                        </div>
                                    </div>
                                   <?php }else{?>
                                    <input type="hidden"  class="form-control" id="otp" name="otp" placeholder="Enter OTP" value="<?php echo $_COOKIE['otpno'] ?>">
                                   <?php } ?>

                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-checkbox" style="color:black;">
                                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit" style="color:black;">Log In</button>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group mt-2 mb-0 row">
                                        <div class="col-12 mt-4">
                                            <a href="pages-recoverpw.html"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                        </div>
                                    </div> -->

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <!-- <p>Don't have an account ? <a href="pages-register.html" class="font-weight-medium text-primary"> Signup now </a> </p> -->
                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> City Code. All rights reserve.</p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            
        function generateotp() {

           var email = $('#username').val();
           var pass = $('#password').val();
          // var values = formserielize();
           //alert(pass);
           if (email!='' || pass!='') {
            $.ajax({
                url:'<?php echo site_url('admin');?>',
                dataType:'json',
                method:'Post',
                data:$('#loginForm').serialize(),
                success:function(json){
                   if (json==1) {
                    alert("Otp Sent successfully!");
                   }else{
                    alert("Otp Not Sent!");
                   }
                }
            });

           }else{
            alert('Please Enter Data');
            return false;
           }
           
        }

        </script>
    </div>
