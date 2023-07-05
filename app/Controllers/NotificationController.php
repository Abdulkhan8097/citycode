<?php
namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\CompanyModel;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\OrdersModel;
use App\Libraries\Paginationnew;
use App\Models\SitevariableModel;
use App\Models\CompanyDocFile;
use App\Libraries\Pushnotification;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\NotificationViewModel;

class NotificationController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
		$this->model = new CustomerModel();
      }


  function index() { 
        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $data = array();
        $stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
        
        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();
        
        
	
	$categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
		
        $notifyModel = new NotificationModel();
        $data['action'] = "Notifications";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }

        $company_id = ($session->get('company_id'));
        if($company_id){ $searchArray['company_id'] =$company_id;  }

        $searchArray['notification_type'] ='city';
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $notifyModel->getData($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
         $companyModel = new CompanyModel();
          $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
   
       if($company_id){
          $data['results'] = $notifyModel->getData($searchArray, $startLimit, $Limit);
       } 
       else {
          $data['results'] = $notifyModel->getData($searchArray, $startLimit, $Limit);
        }           
         $this->template->render('admintemplate', 'contents', 'admin/notification', $data);    	
     }
 
   function add_notification_form() { 
		$categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();		
        $this->template->render('admintemplate', 'contents', 'admin/notification_form', $data);    	
 }
 
  function add_notification() {

        // echo "<pre>";print_r($this->request->getFiles());
        // echo "<pre>";print_r($this->request->getVar());exit;

        $session = session();
        $company_id = '';
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        if ($session->get('company_id')) {
            $isCompany = $session->get('company_id');
            $company_id =  $isCompany;
            $notification_type= 'company';
        } else {
            $notification_type= 'city';
            $company_id = isset($_POST['company_id'])?$this->request->getPost('company_id'):'';
        }
      
        $description = $this->request->getVar('description');
        $noti_image = $this->request->getFiles();
        $checkimg1='';
        foreach ($noti_image['notifyimage'] as $nimg) {
            $checkimg1=$nimg->getClientName();
            break;
        }
        if ($checkimg1!='') {
            $checkimg =$checkimg1;
        }
        else{
            $checkimg ='';
        }
       // echo "<pre>"; print_r($checkimg);exit;
        if ($description!='' OR $checkimg!='') {

            $data = array();	
            $interestval = '';
            if (!$session->get('company_id')) {
                $strinterest = implode(',', $this->request->getVar('interest'));
                $interestval = ",".$strinterest.",";
            }

            $dataimg = [];
            $image ='';

            if ($this->request->getMethod() == 'post') {
                $files = $this->request->getFiles();

                foreach ($files['notifyimage'] as $img) {
                //cho "in";exit;
                    if ($img->isValid() && !$img->hasMoved()) {
                        if ($img->move(FCPATH . 'company/')) {
                            $image = $img->getClientName();
                            $dataimg = [
                                'company_id' => $company_id,
                                'doc' => $img->getClientName(),
                                'type' => 'notification',
                            ];
                            $imagefile = new CompanyDocFile();
                            $save = $imagefile->insert($dataimg);
                        }
                    }
                }
            }
            
            $description = $this->request->getVar('description');
            $description = preg_replace ('/<[^>]*>/', '', $description);
	    $description = str_replace('&nbsp;',' ',$description);
            
            $language = $this->request->getVar('language');
            
            $data = [
                'interest' => $interestval,
                'description' => $description,
                'notification_type' => $notification_type,
                'company_id' => $company_id,
                'image' => $image,
                'title' => $this->request->getVar('title'),
                'image_url' => $this->request->getVar('imageurl'),
                'gender' => $this->request->getVar('gender'),
                'governet' => $this->request->getVar('stateid'),
                'state' => $this->request->getVar('cityid'),
                'language' => $language,
               
            ];

            $notificationModel = new NotificationModel();
            $id = $notificationModel->insert($data);				
            if (!empty($id)) {
    	     $this->session->setFlashdata('message', 'Notification Sent Successfully!');
                  return redirect()->to(site_url('Notifications'));          
            }else{			
    	        $this->session->setFlashdata('errmessage', 'Notification Not Sent!');
                return redirect()->to(site_url('Notifications'));
            }
        }else {         
            $this->session->setFlashdata('errmessage', 'Please Insert Data In Image Or Description!');
            return redirect()->to(site_url('Notifications'));
        }
    }
	
	///////////////////////////// notification details //////////////////////
	
    public function notification_details(){
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
		
		$categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
		
        $notifyModel = new notificationModel();
        $data['row'] = $notifyModel->getNotificationID($id); 
        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('Notifications'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/notification_detail', $data);
    }

    //////////////////////////// notification delete //////////////////////

    public function delete_notification() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

       $notifyModel = new notificationModel();
       $deleteNotification = $notifyModel->where('id', $id)->delete();

       if($deleteNotification){
            $this->session->setFlashdata('message', 'Notification deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Notifications'));
    }

    public function send_Notification(){
        $data = array();
        $sendModel = New NotificationModel();
        $userModel = New UserModel();
        $ordersModel = New OrdersModel();
    $interests_data = $sendModel->where('send_status' , '0')->where('notification_type <>', 'purchase')->orderBy('id','DESC')->limit(1)->find();
        // echo "<pre>";print_r($interests_data);exit;
        $user_data =array();
        $session = session();
         
        if ($session->get('company_id')) {
         $company_id = $session->get('company_id'); 
        }else{
         $company_id = ''; 
        }
        foreach ($interests_data as $key => $value) {
            if (!$company_id) {
                if ($value['notification_type'] == 'city') {
                   $interstl = ltrim($value['interest'],",");
                   $interst = rtrim($interstl,",");
                   $intersts = explode(",",$interst);

                    $strInterest = '';
                    $count=1;
                    foreach($intersts as $intrestval){
                        $strInterest .= "interest  LIKE '%".$intrestval."%' ";

                        ($count > 0 && count($intersts) > $count) ? $strInterest .= " OR " : " ";
                        $count++;
                    }
                   $CustomerModel=new CustomerModel();
                   
                    $objCusDetail = $CustomerModel->where("(".$strInterest.")");

                    
                   
                    if(in_array($value['gender'],array('Male','Female'))) {
                        $objCusDetail->where("LOWER(gender)",strtolower($value['gender']));
                    }
                    
                    if($value['governet']) {
                        $objCusDetail->where("stateid",$value['governet']);
                    }
                    if($value['state']) {
                        $objCusDetail->where("cityid",$value['state']);
                    }
                    if($value['language']) {
                        $objCusDetail->where("LOWER(language)",strtolower($value['language']));
                    }
                    
                     $arrCusDetail = $objCusDetail->find();
                    // echo $objCusDetail->getLastQuery();die;
                    //    echo"<pre>";
                    // print_r($arrCusDetail);exit;
                   
                    $i= 1;
                    foreach($arrCusDetail as $info){    
                        // print_r($info);die;
                        $details=array();
                        if ($value['notification_type'] == 'company') {
                           $notification = "companies";
                        }else{
                            $notification = $value['notification_type'];
                        }
                        $details=[
                            'notification_id' => $i++,
                            'notificationtype' => $notification,
                            "companyname"=>'',
                            "arb_companyname"=>'',
                            "branchname"=>'',
                            "arb_branchname"=>'',
                            "totalamount"=>'',
                            "discount"=>'',
                            "order_id"=>'',
                            "branchid"=>'',
                            "userid"=>'',
                            "user_code"=>'',
                            "image"=>'',
                            'image_base_url' => base_url('company')."/",
                            "notifyimage"=>$value['image'],
                            "image_url"=>$value['image_url'],
                        ];              
                   
                        $arrMessage = [ 
                            "title"=>$value['title'], 
                            "body"=>$value['description'],
                            "details"=>$details,
                        ];
                        //for testing developer token
                       // $android_token = 'fhTPNGEqRout1ysNtrBfer:APA91bHkFKVYmPYVym5b2DsttK_8yUwUeTxiLwO0XVObFHG8lsvV1UkDcDtOUARynmp9fS-RAhaESyUpPQbjIyjjqafdC25zyRBAL2cSGiR5tQAhZRGK89a-o0vlbfT_7H0lmvaoF08r';
                        // $android_token = 'fEyYBwyuR562elHGvqokY3:APA91bGZhmVPvLBEjLZwdYuZUDepi3B7a5vZM8RvSAfhfRtVlxWmsPx6iCYQdLrH4-5AP5z4DXa97jpogNqnHgvbk2oscOK2xBSVsUiry3rryc6jiuMjDrI_nsBJkgVGjXNfB7nTl1JU';
                         $android_token = $info['android_token'];
                        
                        $push = new Pushnotification();                  
                        $push->sendAndroidNotification($android_token,$arrMessage,"City Code Confirmation"); 
                    }
                    $user_data = [
                        'send_status'=>'1',
                    ];
                    $sendModel->where('id', $value['id'])->set($user_data)->update();
                    if ($sendModel->errors) {
                        return $this->fail($sendModel->errors());
                    }
                }elseif ($value['notification_type'] == 'company') {
                    $userDetail = $ordersModel->where('od_companyid' , $value['company_id'])->groupBy ('od_userid')->orderBy('od_id','DESC')->find();
                    if (!empty($userDetail)) {
                        $j=1;
                        foreach ($userDetail as $key => $uvalue) {
                            $usertocan = $this->model->where('id',$uvalue['od_userid'])->find();
                            if (isset($usertocan[0])) {
                                //echo "<pre>";print_r($usertocan[0]['android_token']);
                                $details=array();
                                if ($value['notification_type'] == 'company') {
                                   $notification = "companies";
                                }else{
                                    $notification = $value['notification_type'];
                                }
                                $details=[
                                    'notification_id' => $j++,
                                    'notificationtype' => $notification,
                                    "companyname"=>'',
                                    "arb_companyname"=>'',
                                    "branchname"=>'',
                                    "arb_branchname"=>'',
                                    "totalamount"=>'',
                                    "discount"=>'',
                                    "order_id"=>'',
                                    "branchid"=>'',
                                    "userid"=>'',
                                    "user_code"=>'',
                                    "image"=>'',
                                    'image_base_url' => base_url('company')."/",
                                    "notifyimage"=>$value['image'],
                                ];              
                           
                                $arrMessage = [ 
                                    "title"=>$value['title'], 
                                    "body"=>$value['description'],
                                    "details"=>$details
                                ];
                                //for testing developer token
                               // $android_token = 'ev0-p3tQTtmWQtk3S5GclH:APA91bFCFWbgYCn4Z86UldvxW-vVcUj-O_A17-6ak7dZzkRclmj1Bf4KhUI7zpLTI9pGe9rXmvY6ApyQ2H5zFUyNPQnijXrnku0VeCyGfD_JZTwlXCg2P3HDyLw6OxuYNwOfdjKvhGAY';
                              
                                $android_token = $usertocan[0]['android_token'];
                                
                                $push = new Pushnotification();                  
                                $push->sendAndroidNotification($android_token,$arrMessage,"City Code Confirmation");
                            }
                        }
                        $user_data = [
                         'send_status'=>'1',
                        ];
                        $sendModel->where('id', $value['id'])->set($user_data)->update();
                        if ($sendModel->errors) {
                            return $this->fail($sendModel->errors());
                        }
                    }
                }
            }else{
                if ($company_id) {
                    $userDetail = $ordersModel->where('od_companyid' , $company_id)->groupBy ('od_userid')->orderBy('od_id','DESC')->find();
                   // echo $ordersModel->getLastQuery();die();
                    //echo "<pre>";print_r($userDetail);exit;
                    if (!empty($userDetail)) {
                        $j=1;
                        foreach ($userDetail as $key => $uvalue) {
                            $usertocan = $this->model->where('id',$uvalue['od_userid'])->find();
                            if (isset($usertocan[0])) {
                                $details=array();
                                if ($value['notification_type'] == 'company') {
                                   $notification = "companies";
                                }else{
                                    $notification = $value['notification_type'];
                                }
                                $details=[
                                    'notification_id' => $j++,
                                    'notificationtype' => $notification,
                                    "companyname"=>'',
                                    "arb_companyname"=>'',
                                    "branchname"=>'',
                                    "arb_branchname"=>'',
                                    "totalamount"=>'',
                                    "discount"=>'',
                                    "order_id"=>'',
                                    "branchid"=>'',
                                    "userid"=>'',
                                    "user_code"=>'',
                                    "image"=>'',
                                    'image_base_url' => base_url('company')."/",
                                    "notifyimage"=>'',
                                ];              
                           
                                $arrMessage = [ 
                                    "title"=>$value['title'], 
                                    "body"=>$value['description'],
                                    "details"=>$details
                                ];
                                
                                //for testing developer token
                               // $android_token = 'ev0-p3tQTtmWQtk3S5GclH:APA91bFCFWbgYCn4Z86UldvxW-vVcUj-O_A17-6ak7dZzkRclmj1Bf4KhUI7zpLTI9pGe9rXmvY6ApyQ2H5zFUyNPQnijXrnku0VeCyGfD_JZTwlXCg2P3HDyLw6OxuYNwOfdjKvhGAY';
                              
                                $android_token = $usertocan[0]['android_token'];
                                
                                $push = new Pushnotification();                  
                                $push->sendAndroidNotification($android_token,$arrMessage,"City Code Confirmation");
                            }
                        }
                        $user_data = [
                            'send_status'=>'1',
                        ];
                        $sendModel->where('id', $value['id'])->set($user_data)->update();
                        if ($sendModel->errors) {
                            return $this->fail($sendModel->errors());
                        } 
                    }
                }
            }
        }  
        die('done');
    }

    public function status() {
        //echo "string";exit;
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            $this->session->setFlashdata('errmessage', 'Notification  does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $status = $this->request->getPost('status');

        //$productModel = new ();

        $arrSaveData = array(
            'aprove_status' => $status,
        );
        $notificationModel = new NotificationModel();

        $Update = $notificationModel->where('id', $id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'status updated successfully.');
            return redirect()->to(site_url('Notifications'));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('Notifications'));
        }
    }

    function viewnotification() { 
        $session = session();
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        
        $NotificationViewModel = new NotificationViewModel();
        $data['action'] = "viewnotification";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }

     

       
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $NotificationViewModel->getData($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
        $data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        
        $data['results'] = $NotificationViewModel->getData($searchArray, $startLimit, $Limit);
        // echo"<pre>";
        // print_r($data['results']);exit;
    
                
         $this->template->render('admintemplate', 'contents', 'admin/readnotification', $data);     
     }

      public function viewnoticationdelete() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

       $NotificationViewModel = new NotificationViewModel();
       $deleteNotification = $NotificationViewModel->where('id', $id)->delete();

       if($deleteNotification){
            $this->session->setFlashdata('message', 'View Notification deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('viewnotification'));
    }
 

}

?>



