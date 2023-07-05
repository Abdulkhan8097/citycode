    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <?php echo view('admin/_topmessage'); ?>
                            <h4 class="card-title">Add Delivery Boy</h4>
                               <form class="custom-validation"  method='post' action="" enctype='multipart/form-data'>

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" required placeholder="Type something" name="firstname"/>
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" required placeholder="Type something" name="lastname"/>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div>
                                        <input type="password" id="pass2" class="form-control" required
                                                placeholder="Password" name="password"/>
                                    </div>
                                    <div class="mt-2">
                                        <input type="password" class="form-control" required
                                                data-parsley-equalto="#pass2"
                                                placeholder="Re-Type Password" name="rep_password"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>E-Mail</label>
                                    <div>
                                        <input type="email" class="form-control" required
                                                parsley-type="email" placeholder="Enter a valid e-mail" name="email" id="useremail"/>
                                    </div>

                                    <div class="text-danger" id="email-exist-error-msg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <div>
                                        <input data-parsley-type="digits" type="text"
                                                class="form-control" required
                                                placeholder="Enter only digits" name="mobilenumber"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <div>
                                        <input type="text" class="form-control" required placeholder="Enter Address" name="address"/>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                                            <i class="ion ion ion-md-arrow-back"></i> Back
                                        </a>
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
