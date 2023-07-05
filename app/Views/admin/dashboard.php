<?php $session = session(); ?>

<style>
.col-sm{
background:#F6D000; 
margin-right:34px;
}


.col-sm-4{
background:#F6D000; 
margin-right:30px;
}


.pull-right{
padding: 10px 0 ;
}

.tile-heading{
font-size:20px;
font-weight:500;
margin-bottom:14px;
}
.tile-footer {
    padding: 5px 8px;
    background-color:rgba(0,0,0,0.1)!important;
}

.tile-footer a{
     color: #000 !important;
}

.tile-heading a{
     color: #000 !important;
}

.fa-arrow-right{
float:right !important;
margin:0;
}

</style>

<style>


.datetime{

  color: #000;
  background: #fff;
  font-family: "Segoe UI", sans-serif;
  width: 400px;
  padding: 15px 10px;
  /*border: 1px solid #F6D000;*/
  border-radius: 5px;
 /* -webkit-box-reflect: below 1px linear-gradient(transparent, rgba(255, 255, 255, 0.1));*/
  transition: 0.5s;
  transition-property: background, box-shadow;



margin-top: -74px;
    margin-bottom: 20px;
margin-left:20px;
}

.datetime:hover{
  background: #fff;
  box-shadow: 0 0 30px #fff;
}

.date{
  font-size: 20px;
  font-weight: 600;
  text-align: center;
  letter-spacing: 3px;
}

.time{
  font-size: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.time span:not(:last-child){
  position: relative;
  margin: 0 6px;
  font-weight: 500;
  text-align: center;

}

.time span:last-child{
  background: #fff;
  font-size: 30px;
  font-weight: 600;
  text-transform: uppercase;
  margin-top: 10px;
  padding: 0 5px;
  border-radius: 3px;
}
.right-sidebar{

  color: #000;
  background: #fff;
  font-family: "Segoe UI", sans-serif;
  width: 500px;
  
  padding: 15px 10px;
  /*border: 1px solid #F6D000;*/
  border-radius: 5px;
  -webkit-box-reflect: below 1px linear-gradient(transparent, rgba(255, 255, 255, 0.1));
  transition: 0.5s;
  transition-property: background, box-shadow;

margin-top: -74px;
margin-bottom: 20px;
margin-right:10px !important;
}

.col-sm-2{
  display: inline;

}

.list_all li {
 display: inline;
margin:0 3em 0 4em;
}

.pull-right img{
float:right !important; 
border-radius: 50%;
height:56x; 
width:56px;
}

.pull-right{
color: #000;
}

</style>

<div class="page-content">
    <div class="container-fluid">

    	<!-- start page title -->
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <!--<ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" style="color:#000;">Welcome to City Code Dashboard</li>
                    </ol>-->
                </div>
            </div>
        </div>       
    </div> 
</div>


    <!--digital clock start-->
 <body onLoad="initClock()">
<div class="container">
  <div class="row">
     <div class="col-sm-6" >

    <div class="datetime">
      <div class="date">
        <span id="dayname">Day</span>,
        <span id="month">Month</span>
        <span id="daynum">00</span>,
        <span id="year">Year</span>
      </div>
      <div class="time">
        <span id="hour">00</span>:
        <span id="minutes">00</span>:
        <span id="seconds">00</span>
        <span id="period">AM</span>
      </div>
    </div>
</div>


<div class="col-sm-6" >
</div>


<div>
</div>
    <!--digital clock end-->

<?php if($session->get('user_id')){  ?>

<div class="container">
  <div class="row" style="margin:0 20px;">

    <div class="col-sm" >
        <h2 class="pull-right"> <?php echo $vipcount;?><img src="<?php echo base_url('vip.jpg'); ?>"></h2>
         <div class="tile-heading" style="padding:14px 0;"><a href="VipCode">V.I.P Code</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 



    <div class="col-sm" >
        <h2 class="pull-right"><?php echo $customer_count; ?> <img src="<?php echo base_url('customer.jpg'); ?>"></h2>
        <span class="text-dark font-weight-bold">Active: <?php echo $active_customer_count; ?></span>
         <div class="tile-heading" style="padding:14px 0;"><a href="Customers">Customers</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 

   <div class="col-sm" >
      <h2 class="pull-right"><?php echo $companycount; ?> <img src="<?php echo base_url('company.jpg'); ?>"></h2>
      <span class="text-dark font-weight-bold">Active: <?php echo $active_companycount; ?></span>
      <div class="tile-heading" style="padding:14px 0;"><a href="Company"> Company </div>
       <div class="tile-footer"> More info
      <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i>  </a>
     </div>
  </div>
  
      <div class="col-sm" >
       <h2 class="pull-right"><?php echo $productCount;?> <img src="<?php echo base_url('product.jpg'); ?>"></h2>
       <div class="tile-heading" style="padding:14px 0;"><a href="Products">Products </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>
   
  </div>
</div> 


<div class="container">
  <div class="row" style="margin:30px 20px;">

  <div class="col-sm" >
       <h2 class="pull-right"><?php echo $menuCount; ?> <img src="<?php echo base_url('menulist.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="MenuList"> Menu List <div> &nbsp;</div></div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>


    <div class="col-sm" >
       <h2 class="pull-right"><?php echo $bannerCount11; ?> <img src="<?php echo base_url('banner.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Advertisement">City Code Banners </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>

    <div class="col-sm" >
       <h2 class="pull-right"><?php echo $redeemCount;?> <img src="<?php echo base_url('redeem.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Redeem_Products">Redeem Products </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>
	
	  <div class="col-sm" >
       <h2 class="pull-right"> <img src="<?php echo base_url('report.jpg'); ?>"></h2>
       <div class="tile-heading" style="padding-top:32px;"><a href="<?php echo site_url('reports'); ?>">Reports  <div> &nbsp;</div></div> 
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>

 

</div>
</div>



<div class="container">
  <div class="row" style="margin:0 20px 60px;">
 

   <div class="col-sm" >
        <h2 class="pull-right"><?php echo $contactcount; ?> <img src="<?php echo base_url('customer_feedback.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="CustomerFeedback">Customer Feedback</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 
<div class="col-sm" >
        <h2 class="pull-right"><?php echo $enquiryCount; ?> <img src="<?php echo base_url('customer_feedback.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="CompanyEnquiry">Company Feedback</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 
	
	<div class="col-sm" >
        <h2 class="pull-right">1<img src="<?php echo base_url('contact_us.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="ContactUs">Contact Us <div> &nbsp;</div></div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 
	
	<div class="col-sm" >
        <h2 class="pull-right"><?php echo $notifyCount; ?> <img src="<?php echo base_url('notification.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="Notifications">Notification<div> &nbsp;</div></div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 
	

</div>
</div>


<div class="container">
  <div class="row" style="margin:0 20px 60px;">
	
	<div class="col-sm" >
        <h2 class="pull-right"><?php echo $employeeCount; ?> <img src="<?php echo base_url('employee.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="Employees">Employees<div> &nbsp;</div></div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div>

    <div class="col-sm" >
        <h2 class="pull-right"><?php echo $mallcount; ?> <img src="<?php echo base_url('mall.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="MallDetails">Malls<div> &nbsp;</div></div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div>

<div class="col-lg-3"></div>
<div class="col-lg-3"></div>
<div class="col-lg-3"></div>

</div>
</div>




<?php } ?>
<?php if ($session->get('company_id')){	?>

<div class="container">
  <div class="row" style="margin:30px 20px;">

    <div class="col-sm" >
       <h2 class="pull-right"><?php echo $CountProduct;?> <img src="<?php echo base_url('product.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Products">Products </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>

    <div class="col-sm" >
       <h2 class="pull-right"><?php echo $companymenuCount;?> <img src="<?php echo base_url('menulist.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="MenuList">Menu List </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>



    <div class="col-sm" >
       <h2 class="pull-right"><?php echo $bannerCount;?> <img src="<?php echo base_url('banner.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Advertisement">Banners </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>


</div>
</div>

<div class="container">
 <div class="row" style="margin:30px 20px 90px;">


    <div class="col-sm" >
       <h2 class="pull-right"> <img src="<?php echo base_url('report.jpg'); ?>"></h2>
       <div class="tile-heading" style="padding-top:32px;"><a href="companyreport">Reports </div>

       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>


<div class="col-sm">
        <h2 class="pull-right"><?php echo $CompEnqCount; ?> <img src="<?php echo base_url('customer_feedback.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="CompanyEnquiry">Company Feedback</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div>

	<div class="col-sm" >
        <h2 class="pull-right"><?php echo $notifyCount; ?> <img src="<?php echo base_url('notification.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="Notifications">Notification</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 

    
    </div>
</div>
<?php } ?>

<!--------------------------------- employee section ------------------------------------>

<?php if ($session->get('employee_id')){	?>

<div class="container">
  <div class="row" style="margin:0 20px;">

    <div class="col-sm" >
        <h2 class="pull-right"><?php echo $customer_count; ?> <img src="<?php echo base_url('customer.jpg'); ?>"></h2>
         <div class="tile-heading"><a href="Customers">Customers</div>
         <div class="tile-footer"> More info 
        <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i> </a>
       </div>
    </div> 

   <div class="col-sm" >
      <h2 class="pull-right"><?php echo $companycount; ?> <img src="<?php echo base_url('company.jpg'); ?>"></h2>
      <div class="tile-heading"><a href="Company"> Company </div>
       <div class="tile-footer"> More info
      <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i>  </a>
     </div>
  </div>
  
      <div class="col-sm" >
       <h2 class="pull-right"><?php echo $productCount;?> <img src="<?php echo base_url('product.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Products">Products </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>


   
  </div>
</div> 





<div class="container">
  <div class="row" style="margin:30px 20px 90px;">

 <div class="col-sm" >
       <h2 class="pull-right"><?php echo $redeemCount;?> <img src="<?php echo base_url('redeem.jpg'); ?>"></h2>
       <div class="tile-heading"><a href="Redeem_Products">Redeem Products </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>


   <div class="col-sm" >
       <h2 class="pull-right"> <img src="<?php echo base_url('report.jpg'); ?>"></h2>
       <div class="tile-heading" style="padding-top:32px;"><a href="Reports">Reports </div>
       <div class="tile-footer"> More info
       <i class="fa fa-arrow-right" aria-hidden="true pull-right"></i></a>
      </div>
    </div>
	
	<div class="col-lg-4" >      
        </div> 


</div>
</div>

<?php } ?>




    <script type="text/javascript">
    function updateClock(){
      var now = new Date();
      var dname = now.getDay(),
          mo = now.getMonth(),
          dnum = now.getDate(),
          yr = now.getFullYear(),
          hou = now.getHours(),
          min = now.getMinutes(),
          sec = now.getSeconds(),
          pe = "AM";

          if(hou >= 12){
            pe = "PM";
          }
          if(hou == 0){
            hou = 12;
          }
          if(hou > 12){
            hou = hou - 12;
          }

          Number.prototype.pad = function(digits){
            for(var n = this.toString(); n.length < digits; n = 0 + n);
            return n;
          }

          var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"];
          var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
          var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
          for(var i = 0; i < ids.length; i++)
          document.getElementById(ids[i]).firstChild.nodeValue = values[i];
    }

    function initClock(){
      updateClock();
      window.setInterval("updateClock()", 1);
    }
    </script>





