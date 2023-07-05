<?php
namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\MallDetailsModel;
use App\Models\CompanyModel;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\OrdersModel;
use App\Libraries\Paginationnew;
use App\Models\SitevariableModel;
use App\Models\CompanyDocFile;
use App\Libraries\Pushnotification;

class MallDetailsController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
		$this->model = new CustomerModel();
      }


  function index() { 
   //echo "string";exit;
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
	   $categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
		$mallModel = new MallDetailsModel();
        $notifyModel = new NotificationModel();
        $data['action'] = "MallDetails";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }


        $company_id = ($session->get('company_id'));
        if($company_id){
         $searchArray['company_id'] =$company_id; 
        }

        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $mallModel->getData($searchArray, '', '', '1');
        //echo  $totalRecord;exit;
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
   
       if($company_id){
          $data['results'] = $mallModel->getData($searchArray, $startLimit, $Limit);
       } 
       else {
          $data['results'] = $mallModel->getData($searchArray, $startLimit, $Limit);
        }           
         $this->template->render('admintemplate', 'contents', 'admin/malldetails', $data);   
     }
 
   function add_notification_form() { 
		$categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();		
        $this->template->render('admintemplate', 'contents', 'admin/notification_form', $data);    	
 }
 
  function add_mall() {

    //echo "string";exit;

        
      //  echo "<pre>";print_r($this->request->getVar());exit;

        $session = session();
        $company_id = '';
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $mall_name = $this->request->getVar('mall_name');
        $arabic_mall_name = $this->request->getVar('arabic_mall_name');
       // echo "<pre>"; print_r($checkimg);exit;
        if ($mall_name!='' && $arabic_mall_name!='') {
            $data = array();	

            $data = [
                'mall_name' => $mall_name,
                'arabic_mall_name' => $arabic_mall_name,
            ];
            $mallModel = new MallDetailsModel();
            $id = $mallModel->insert($data);				
            if (!empty($id)) {
    	     $this->session->setFlashdata('message', 'Mall Inserted Successfully!');
                  return redirect()->to(site_url('MallDetails'));          
            }else{			
    	        $this->session->setFlashdata('errmessage', 'Notification Not Sent!');
                return redirect()->to(site_url('MallDetails'));
            }
        }else {         
            $this->session->setFlashdata('errmessage', 'Please Insert Data In Image Or Description!');
            return redirect()->to(site_url('MallDetails'));
        }
    }
	
	///////////////////////////// notification details //////////////////////
	
    public function Mall_Details(){
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
		
		
		
        $mallModel = new MallDetailsModel();
        $data['row'] = $mallModel->getMallID($id); 
        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('MallDetails'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/mall_details', $data);
    }

    //////////////////////////// notification delete //////////////////////

    public function delete_mall() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

       $mallModel = new MallDetailsModel();
       $deleteMall = $mallModel->where('id', $id)->delete();

       if($deleteMall){
            $this->session->setFlashdata('message', 'Mall deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('MallDetails'));
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
            if ($company_id=='') {
                if ($value['notification_type'] == 'city') {
                   $interstl = ltrim($value['interest'],",");
                   $interst = rtrim($interstl,",");
                   $intersts = explode(",",$interst);
                    $strInterest = '';
                    $count=1;
                    foreach($intersts as $intrestval){
                        $strInterest .= "interest  LIKE '%,".$intrestval.",%' ";
                        ($count > 0 && count($intersts) > $count) ? $strInterest .= " OR " : " ";
                        $count++;
                    }
                    $arrCusDetail = $this->model->where($strInterest)->findAll();

                    $i= 1;
                    foreach($arrCusDetail as $info){                   
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
                        ];              
                   
                        $arrMessage = [ 
                            "title"=>$value['title'], 
                            "body"=>$value['description'],
                            "details"=>$details,
                        ];
                        $push = new Pushnotification();                  
                        $push->sendAndroidNotification('cJJrXS8JRuSQAUueBupyVR:APA91bGuNoaJGsiZP3IVMnXPWOpDPkajOjzTY9j78KxMV_ICR0r7DimGUcRAzDaOUrN0J7u6y7EGKoDoJRVGEZ7sSXV4FoczJfBHXWfZEla_IQecEd9L00h1qArGFEaxD2pTFcl3dqki',$arrMessage,"City Code Confirmation"); 
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
                                $push = new Pushnotification();                  
                                $push->sendAndroidNotification('cJJrXS8JRuSQAUueBupyVR:APA91bGuNoaJGsiZP3IVMnXPWOpDPkajOjzTY9j78KxMV_ICR0r7DimGUcRAzDaOUrN0J7u6y7EGKoDoJRVGEZ7sSXV4FoczJfBHXWfZEla_IQecEd9L00h1qArGFEaxD2pTFcl3dqki',$arrMessage,"City Code Confirmation");
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
                if ($company_id!='') {
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
                                $push = new Pushnotification();                  
                                $push->sendAndroidNotification('cJJrXS8JRuSQAUueBupyVR:APA91bGuNoaJGsiZP3IVMnXPWOpDPkajOjzTY9j78KxMV_ICR0r7DimGUcRAzDaOUrN0J7u6y7EGKoDoJRVGEZ7sSXV4FoczJfBHXWfZEla_IQecEd9L00h1qArGFEaxD2pTFcl3dqki',$arrMessage,"City Code Confirmation");
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
}

?>



