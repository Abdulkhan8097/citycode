<!-- ========== Left Sidebar Start ========== -->
<?php $session = session(); ?>
<style>
    .menu-title{
        font-size:14px;
    }

    
</style>
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->                      

                     
            <?php if ($session->get('user_id')) { ?>

            <ul class="metismenu list-unstyled " id="side-menu">
                           
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('Dashboard'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('home_dashboard.jpg'); ?>" height="30px">
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('VipCode'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('vip.jpg'); ?>" height="30px">
                                    <span class="menu-title">Generate V.I.P Code</span>
                                </a>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('customer.jpg'); ?>" height="30px">
                                    <span class="menu-title">Customers</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('Customers'); ?>">View Customers</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('AddCustomer'); ?>" >Add Customer</a></li>
                                </ul>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('company.jpg'); ?>" height="30px">
                                    <span class="menu-title">Company Details </span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('Company'); ?>">View Company</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('AddCompany'); ?>" >Add Company</a></li>
                                </ul>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('product.jpg'); ?>" height="30px">
                                    <span class="menu-title">Product Details </span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('Products'); ?>">View Products</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('AddProduct'); ?>" >Add Product</a></li>
                                </ul>
                            </li>
                            
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('MenuList'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('menulist.jpg'); ?>" height="30px">
                                    <span class="menu-title">Menu List</span>
                                </a>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('report.jpg'); ?>" height="30px">
                                    <span class="menu-title">City Code Banners</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('Advertisement'); ?>">View Banners</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('add_new'); ?>" >Add Banners</a></li>
                                </ul>
                            </li>

 <!-- <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php //echo site_url('openingpoint'); ?>" class="waves-effect ">
                                    <img src="<?php //echo base_url('redeem.jpg'); ?>" height="30px">
                                    <span class="menu-title">Set Point</span>
                                </a>
                            </li> -->
 

                            <li  style="border-bottom: 1px solid #5f6369">
                            <a href="Banners" class="waves-effect ">
                            
                            <img src="<?php echo base_url('banner.jpg'); ?>" height="30px">
                            <span class="menu-title">Company Banners</span>
                             </a>                        
                             </li>


                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('redeem.jpg'); ?>" height="30px">
                                    <span class="menu-title">Redeem Products</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('Redeem_Products'); ?>">View Products</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('AddRedeem_Products'); ?>" >Add Products</a></li>
                                </ul>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('report.jpg'); ?>" height="30px">
                                    <span class="menu-title">Reports</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                    <li style="border-bottom: 1px solid #5f6369"><a href="<?php echo site_url('reports'); ?>">View Report</a> </li>
                                     
                                    <li style="border-bottom: 1px solid #5f6369;"><a href="<?php echo site_url('toppurchasecutomers'); ?>" >Top Sale / Purchase </a></li>
                                    <li style="border-bottom: 1px solid #5f6369;"><a href="<?php echo site_url('appviewcutomer'); ?>" >App Views </a></li>
                                    <li style="border-bottom: 1px solid #5f6369;"><a href="<?php echo site_url('chatreport'); ?>" >Chat Report </a></li>
                                    <li style="border-bottom: 1px solid #5f6369;"><a href="<?php echo site_url('getorderss'); ?>" >Online Shopping</a></li>
                                    <li style="border-bottom: 1px solid #5f6369;"><a href="<?php echo site_url('viewnotification'); ?>" >Notification view</a></li>
                                </ul>
                            </li>
                             <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('transaction icon.png'); ?>" height="30px">
                                    <span class="menu-title">Transaction</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('addtransaction'); ?>">Add Transaction</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('viewrecord'); ?>">View Transaction</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('report.jpg'); ?>" height="30px">
                                    <span class="menu-title">Advertisement</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('dashboardadd'); ?>">View Add</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('dashboardaddnew'); ?>" >Add New</a></li>
                                </ul>
                            </li>
                            
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('customer_feedback.jpg'); ?>" height="30px">
                                    <span class="menu-title">Feedback</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('CustomerFeedback'); ?>">Customer Feedback</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('CompanyEnquiry'); ?>" >Company Feedback </a></li>
                                </ul>
                            </li>
                            
                         
                            
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('ContactUs'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('contact_us.jpg'); ?>" height="30px">
                                    <span class="menu-title">Contact Us</span>
                                </a>
                            </li>
                            
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('openingpoint'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('redeem.jpg'); ?>" height="30px">
                                    <span class="menu-title">Set Point</span>
                                </a>
                            </li>
                             <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('buypoints'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('redeem.jpg'); ?>" height="30px">
                                    <span class="menu-title">Buy Points</span>
                                </a>
                            </li>
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('Notifications'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('notification.jpg'); ?>" height="30px">
                                    <span class="menu-title">Notifications</span>
                                </a>
                            </li>
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('Employees'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('employee.jpg'); ?>" height="30px">
                                    <span class="menu-title">Employees</span>
                                </a>
                            </li>
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('MallDetails'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('mall.jpg'); ?>" height="30px">
                                    <span class="menu-title">Mall Details</span>
                                </a>
                            </li>
                            <li  style="border-bottom: 1px solid #5f6369">
                                <a href="<?php echo site_url('CustomOfferDetails'); ?>" class="waves-effect ">
                                    <img src="<?php echo base_url('mall.jpg'); ?>" height="30px">
                                    <span class="menu-title">Custom Offer Details</span>
                                </a>
                            </li>
                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('coupon.png'); ?>" height="30px">
                                    <span class="menu-title">Coupon Management</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                     <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('addcouponamt'); ?>">Assign Coupon Amount</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('viewcouponamt'); ?>" >View Assign Coupon List</a></li>

                                <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('addcoupon'); ?>">Add Coupon Type</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('viewcoupon'); ?>" >View Coupon Type List</a></li>
                                    <li style="border-bottom: 1px solid #5f6369"><a href="<?php echo site_url('couponreports'); ?>">Coupon Report</a> </li>
                                   
                                </ul>
                            </li>


                            <li class="" style="border-bottom: 1px solid #5f6369">
                                <a href="javascript: void(0);" class="has-arrow waves-effect " aria-expanded="false">
                                <img src="<?php echo base_url('version_control.jpg'); ?>" height="30px">
                                    <span class="menu-title">Version Control</span>
                                </a>
                                <ul class="sub-menu mm-collapse " aria-expanded="false" style="">
                                     <li style="border-bottom: 1px solid #5f6369">
                                    <a href="<?php echo site_url('addversion'); ?>">Add Version Control</a>
                                    </li>
                                    <li style="border-bottom: 1px solid #5f6369;">
                                    <a href="<?php echo site_url('listversion'); ?>" >View Version Control</a></li>

                             
                                   
                                </ul>
                            </li>

                           
            </ul> 
   
            <?php } ?>
            <?php if ($session->get('company_id')) { ?>


                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Dashboard"> <li class="menu-title" style="color:#000 !important;">  
                            <img src="<?php echo base_url('home_dashboard.jpg'); ?>"> Dashboard</li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="About_Company"> <li class="menu-title" style="color:#000 !important;">  
                            <img src="<?php echo base_url('company.jpg'); ?>"> About Company</li>   </a>                        
                </ul>


                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Products"> <li class="menu-title" style="color:#000 !important;">
                            <img src="<?php echo base_url('product.jpg'); ?>"> Product Details </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Banners"> <li class="menu-title" style="color:#000 !important;">  
                            <img src="<?php echo base_url('banner.jpg'); ?>"> Banners </li>   </a>                        
                </ul>


              <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="<?php echo site_url('companyreport'); ?>"> <li class="menu-title" style="color:#000 !important;">  
                            <img src="<?php echo base_url('report.jpg'); ?>">Reports </li>   </a>                        
                </ul> 
                 <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="<?php echo site_url('couponreports'); ?>"> <li class="menu-title" style="color:#000 !important;">  
                            <img src="<?php echo base_url('report.jpg'); ?>">Coupon Report </li>   </a>                        
                </ul> 




                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="CompanyEnquiry"> <li class="menu-title" style="color:#000 !important;">
                            <img src="<?php echo base_url('customer_feedback.jpg'); ?>"> Company Feedback </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Notifications"> <li class="menu-title" style="color:#000 !important;">
                            <img src="<?php echo base_url('notification.jpg'); ?>"> Notification </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="MenuList"> <li class="menu-title" style="color:#000 !important;">
                            <img src="<?php echo base_url('menulist.jpg'); ?>"> Menu List </li>   </a>                        
                </ul>


                  <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="<?php echo site_url('viewrecord'); ?>"> <li class="menu-title" style="color:#000 !important;">
                            <img src="<?php echo base_url('transaction icon.png'); ?>"> Transaction </li>   </a>                        
                </ul>


         


            <?php } ?>

            <!--------------------------- employee section ------------------------------>

            <?php if ($session->get('employee_id')) { ?>	


                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Dashboard"> <img src="<?php echo base_url('home_dashboard.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;">Dashboard</li>   </a>                        
                </ul>    

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Customers"> <img src="<?php echo base_url('customer.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;">Customer Details </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Company"> <img src="<?php echo base_url('company.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;"> Company Details </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Products"> <img src="<?php echo base_url('product.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;"> Product Details </li>   </a>                        
                </ul>

                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="Redeem_Products"> <img src="<?php echo base_url('redeem.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;"> Redeem Products </li>   </a>                        
                </ul>


                <ul class="metismenu list-unstyled" id="side-menu">
                    <a href="<?php echo site_url('companyreport'); ?>"> <img src="<?php echo base_url('report.jpg'); ?>">
                        <li class="menu-title" style="color:#000 !important;"> Reports </li>   </a>                        
                </ul>
            <?php } ?>


        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->