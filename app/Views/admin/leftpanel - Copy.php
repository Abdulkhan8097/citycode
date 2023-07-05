<!-- ========== Left Sidebar Start ========== -->
<?php $session = session(); ?>
<style>
.menu-title{
font-size:14px;
}

#side-menu img{
float:right !important; 
border-radius: 50%;
height:30x; 
width:30px;
margin-top:-5px;
margin-right:5px;
float:left !important;
}
</style>
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->



                        <ul class="metismenu list-unstyled" id="side-menu">   
                          <a href="Dashboard"> <li class="menu-title" style="color:#000 !important; margin-left:35px;">Dashboard</li> </a>
                        </ul>

  <?php if($session->get('user_id')){  ?>

		  <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="VipCode">
						    <li class="menu-title" style="color:#000 !important;">  
                               <img src="<?php echo base_url('vip.jpg'); ?>">Generate V.I.P Code </li>   </a>                        
                     </ul>

  
                    <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Customers"> 
						   <li class="menu-title" style="color:#000 !important;">
                              <img src="<?php echo base_url('customer.jpg'); ?>">Customer Details </li>   </a>                        
                     </ul>

                    <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Company"> <li class="menu-title" style="color:#000 !important;"> 
                               <img src="<?php echo base_url('company.jpg'); ?>">Company Details </li>   </a>                        
                     </ul>

                    <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Products"> <li class="menu-title" style="color:#000 !important;">  
                             <img src="<?php echo base_url('product.jpg'); ?>"> Product Details </li>   </a>                        
                     </ul>
					 

		  <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Advertisement"> <li class="menu-title" style="color:#000 !important;">  
                               <img src="<?php echo base_url('report.jpg'); ?>">City Code Banners </li>   </a>                        
                     </ul>

		  <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Redeem_Products"> <li class="menu-title" style="color:#000 !important;">  
                                <img src="<?php echo base_url('redeem.jpg'); ?>">Redeem Products </li>   </a>                        
                     </ul>


		  <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="Reports"> <li class="menu-title" style="color:#000 !important;">  
                              <img src="<?php echo base_url('report.jpg'); ?>"> Reports </li>   </a>                        
                     </ul>

                    <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="CustomerFeedback"> <li class="menu-title" style="color:#000 !important;">
                             <img src="<?php echo base_url('customer_feedback.jpg'); ?>"> Customer Feedback </li>   </a>                        
                     </ul>

                     <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="CompanyEnquiry"> <li class="menu-title" style="color:#000 !important;">
                             <img src="<?php echo base_url('customer_feedback.jpg'); ?>"> Company Feedback </li>   </a>                        
                     </ul>




		<?php } ?>
		<?php if ($session->get('company_id')){	?>

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
                           <a href="Reports"> <li class="menu-title" style="color:#000 !important;">  
						   <img src="<?php echo base_url('report.jpg'); ?>">Reports </li>   </a>                        
                     </ul>

                     <ul class="metismenu list-unstyled" id="side-menu">
                           <a href="CompanyEnquiry"> <li class="menu-title" style="color:#000 !important;">
                             <img src="<?php echo base_url('customer_feedback.jpg'); ?>"> Company Feedback </li>   </a>                        
                     </ul>

	       <?php } ?>


                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->