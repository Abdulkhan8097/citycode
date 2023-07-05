<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\NearNotification;
use App\Models\VipCustomerModel;
use App\Models\BuyPoints;
use App\Models\OrdersModel;
use App\Models\CartListModel;
use App\Models\CompanyModel;
use App\Models\userAddressModel;
use App\Models\CodeModel;
use App\Models\ChatModel;
use App\Models\OrgModel;
use App\Models\OrgCompanyModel;
use App\Models\ApiOrgModel;
use App\Models\OnlineShoppingModel;
use App\Models\CouponModel;
use App\Models\ChatStatusModel;
use App\Models\BranchModel;
use App\Models\SitevariableModel;
use App\Models\NotificationModel;
use App\Models\CustomerImpressionModel;
use App\Models\OpeningPointModel;
use App\Models\DashboardAdvertisementModel;
use App\Models\ProductModel;
use App\Models\couponPurchaseModel;
use App\Models\VersionControlModel;
use App\Models\NotificationViewModel;


use App\Libraries\EmailSms;
use App\Libraries\Pushnotification;


class ApiUsers extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
    $this->model = new CustomerModel();
	$this->company = new CompanyModel();
    $this->companycode = new CodeModel();
	$this->branch = new BranchModel();
        $this->order = new OrdersModel();
    }

    //get all category
    public function index() {
        $array = array();

        return $this->failNotFound('Invalid access found');
    }

    public function Login() {
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');
        $customer = $this->request->getPost('customer');
        //$company = $this->request->getPost('company');
     


        if ($mobile && $password && $customer=='customer') {
            $return = $this->model->checkUserLoginApi($mobile, $password);

            if ($return) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Login successfully'
                    ],
                    'user_detail' => $return
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Invalid mobile number or OTP.');
            }
        }elseif ($mobile && $password && $customer=='company') {
           
           $return = $this->branch->checkUserLoginApi($mobile, $password);
           // echo "<pre>";print_r($return);exit;
            if ($return) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Login successfully'
                    ],
                    'user_detail' => $return
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Invalid mobile number or OTP.');
            }
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }

    // create
    public function create() {

        $userdata = array();
  
        $userdata['email'] = $this->request->getPost('email');
        $userdata['mobile'] = $this->request->getPost('mobile');

        $userdata['name'] = $this->request->getPost('name');
        $userdata['family_name'] = $this->request->getPost('familyname');
        $userdata['gender'] = $this->request->getPost('gender');
        $userdata['date_of_birth'] = $this->request->getPost('date_of_birth');
        $userdata['nationality'] = $this->request->getPost('nationality');
        $userdata['stateid'] = $this->request->getPost('governorate');
        $userdata['cityid'] = $this->request->getPost('cityid');
        $userdata['language'] = $this->request->getPost('language');

        $userdata['device'] = $this->request->getPost('device');
        $userdata['operating_system'] = $this->request->getPost('operating_system');
        $userdata['phone_model'] = $this->request->getPost('phone_model');
        $userdata['latitude'] = $this->request->getPost('latitude');
        $userdata['longitude'] = $this->request->getPost('longitude');
        $userdata['location'] = $this->request->getPost('location');

        //return $this->failNotFound('Opps! some error occurs.' . print_r($this->request->getPost(), 1));
        
        $newuserdata = (array_filter($userdata));

         $profile = "";
         if (!empty($_FILES['profile']['name'])) {
              $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
              $file_type  = $_FILES['profile']['type'];
              $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['profile']['name'];
                $profileImage = $userFolderpath.$newfilename;
                 
                if (move_uploaded_file($_FILES['profile']['tmp_name'], $profileImage)) {
                    $profile = $newfilename;
                }
            }
        }

        if ($userdata['mobile'] && $userdata['name']) {
            $isuserexist = $this->model->where('mobile', $newuserdata['mobile'])->first();

            //echo "<pre>";print_r($isuserexist);exit;

            if (empty($isuserexist)) {
                $citycode = $this->model->generatecode();

                $userdata['city_code'] = $citycode;
                $userdata['profile'] = $profile;
                $userdata['customer_type'] = "customer";

                $query = $this->model->save($userdata);

                if ($query) {
                    $userid = $this->model->getInsertID();
                    $userdata['id'] = $userid;
                    
                     //give initial point to customer
                    $openingPointModel = new OpeningPointModel();
                    $arrSearch = array("date"=>date('Y-m-d'));
                    $data1 = $openingPointModel->getData($arrSearch); 
                    $data1 = count($data1) ? $data1[0] : array();
                    if($data1) {
                        $points = $data1->initial_point;
                        if($points)
                        {
                            $objCustomer = new CustomerModel();
                            $objCustomer->setCustomerpoint($userid,$points,'CR',0,0,'Registration Bonus');
                        }
                    }
                    
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Account created successfully'
                        ],
                        'userdetail' => $userdata,
                        'image_base_url' => base_url('users')."/",
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Opps! some error occurs.' . print_r($data, 1));
                }
            } else {
                $delete_status = 0;
                $userid = 0;
                $delete_status = $isuserexist['delete_status'];
                $userid =  $isuserexist['id'];
                if ($delete_status == 1) {
                   $deleteuserdata=[
                        'delete_status' => '0',
                    ];
                    $Update = $this->model->where('id', $userid)->set($deleteuserdata)->update();
                    $userdata = $this->model->where('mobile', $newuserdata['mobile'])->first();
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Account created successfully'
                        ],
                        'userdetail' => $userdata,
                        'image_base_url' => base_url('users')."/",
                    ];
                    return $this->respondCreated($response);
                }else{
                    return $this->failNotFound('Mobile number alreay exist.');
                }
            }
        } else {
            
            return $this->failNotFound('Please provide all data');
        }
    }

    // single user
    public function show($id = null) {
       // echo$id;exit;

        $searchArray = ['id'=>$id];
        $data = $this->model->getData($searchArray);
        
        $userInterest = array();
        
        //user interest
        $categoryModel = new CategoryModel();
        if($data[0]->interest)
        {
            $cat_array  = explode(",", $data[0]->interest);
            
            $arrSearchCat = array('cat_id'=>$cat_array);
            $userInterest = $categoryModel->getData($arrSearchCat);
        }
        
        if ($data) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ]
            ];
            $response['interest_base_url'] = base_url('category')."/";
            $response['userurl'] = base_url('users')."/";
            $response['userdetail'] = $data;
            $response['userInterest'] = $userInterest;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
    
     // single user
    public function showvip() {
    //echo "string";exit;
        $vip_code = $this->request->getGet('vip_code');
       
        $data = array();
        $vipOffers = array();

        if ($vip_code) {
            
            $searchArray = array('vip_code'=>$vip_code);
            $searchArray['company_status']  =1;
            $data = $this->model->getData($searchArray);

            //get all offers of cutomers
            if($data)
            {
                $arrVipSearch = array('customer_id'=>$data[0]->id,"coupon_type"=>"vip",'company_status' =>1);
               $vipCustomerModel = new VipCustomerModel();
               $vipOffers = $vipCustomerModel->getVipOffers($arrVipSearch);
            }else{

               // $searchArray = array('vip_code'=>$vip_code);
            //$data = $this->model->getData($searchArray);
               $OrgModel = new ApiOrgModel();
                  $data = $OrgModel->getData2($searchArray);
            //            echo"<pre>";
            
            // print_r($data);die;

                  $objectB= (object) array("city_code"=>"",
                    "vip_plus"=>"",
                    "customer_type"=>"",
                    "arb_name"=>"",
                    "username"=>"",
                    "family_name"=>"",
                    "mobile"=>"",
                  );
               
                
              
                    foreach($data as $arr) {
                       $data[0] = (object) array_merge((array) $arr, (array) $objectB);
                    }
                 
                    // echo"<pre>";
            // print_r($vipOffers);
            // print_r($data);die;

                  if($data)
                      {
                               // $arrVipSearch = array('org_id'=>$data[0]->id,"coupon_type"=>"vip");
                                $arrVipSearch = array("status"=>"1","coupon_type"=>"vip","org_id"=>$data[0]->id);
                             
                               $OrgCompanyModel = new OrgCompanyModel();
                               $vipOffers = $OrgCompanyModel->getVipOffers($arrVipSearch);
            //                     print_r($vipOffers);die;
            // echo"<pre>";
            // print_r($vipOffers);exit;
                      }
                 }

          //  echo "<pre>";print_r($vipOffers);exit;
            //-------------------------------------------------------------------
            if (!empty($vipOffers)) {
                 $count =count($vipOffers);
                for($i=0; $i <$count ; $i++) { 
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($vipOffers[$i]->company_id == $vipOffers[$j]->company_id) {
                           if($vipOffers[$i]->discountdisplay==$vipOffers[$j]->discountdisplay) {
                                unset($vipOffers[$j]);
                                $vipOffers = array_values($vipOffers);
                                $count =count($vipOffers);
                           }
                        }
                    }
                 } 
                for($i=0; $i <$count ; $i++) { 
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($vipOffers[$i]->company_id==$vipOffers[$j]->company_id) {
                           if($vipOffers[$i]->discountdisplay==$vipOffers[$j]->discountdisplay) {
                                unset($vipOffers[$j]);
                                $vipOffers = array_values($vipOffers);
                                $count =count($vipOffers);
                           }
                        }
                    }
                }
            }
            //-------------------------------------------------------------------
           // print_r($vipOffers);die;
            // echo"<pre>";
            // print_r($vipOffers);
            // print_r($data);die;
                if (!$vipOffers) {
                    return $this->failNotFound('No Data found');
                }


            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Vip detail'
                ],
                'image_base_url' => base_url('users')."/",
                'company_base_url' => base_url('company')."/",
            ];
            $response['userdetail'] = $data;
            $response['vipOffers'] = $vipOffers;
            return $this->respond($response);
        } else {
            
            $response = [
                'status' => 404,
                'error' => null,
                'messages' => [
                    'success' => 'Please provide valid VIP Code'
                ],
                'image_base_url' => base_url('users')."/",
                'company_base_url' => base_url('company')."/",
            ];
            
            $response['userdetail'] = $data;
            $response['vipOffers'] = $vipOffers;

            return $this->respond($response);
            
            //return $this->failNotFound('No Data found');
        }
    }

    // update
    public function profileUpdate() {

        $userdata = array();

        $userid = $this->request->getPost('userid');

        $userdata['email'] = $this->request->getPost('email');
      //  $userdata['mobile'] = $this->request->getPost('mobile');

        $userdata['name'] = $this->request->getPost('name');
        $userdata['family_name'] = $this->request->getPost('familyname');
        $userdata['gender'] = $this->request->getPost('gender');
        $date_of_birth = $this->request->getPost('date_of_birth');
        $userdata['nationality'] = $this->request->getPost('nationality');
        $userdata['stateid'] = $this->request->getPost('governorate');
        $userdata['cityid'] = $this->request->getPost('state');
        $userdata['language'] = $this->request->getPost('language');

        if($date_of_birth)
        {
            $userdata['date_of_birth'] = date("Y-m-d", strtotime($date_of_birth));
        }
        $newuserdata = (array_filter($userdata));

        $profileImage = "";

        // upload profile image
        $file = $this->request->getFile("profileimage");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $profile = $file->getName();

                if ($file->move($userFolderpath, $profile)) {
                    $profileImage = $file->getName();
                }
            }
        }


        if ($userid) {
            if (count($newuserdata) > 0) {

                if ($profileImage) {
                    $userdata['profile'] = $profileImage;
                }
                
              //  $isuserexist = $this->model->where('mobile', $newuserdata['mobile'])->where('id',$userid)->first();
                $isuserexist = $this->model->where('id',$userid)->first();

                if($isuserexist)
                {
                    $Update = $this->model->where('id', $userid)->set($newuserdata)->update();

                    if ($Update) {
                        $userdata['id'] = $userid;
                        $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Profile updated successfully'
                            ],
                            'userdetail' => $userdata
                        ];
                        return $this->respondCreated($response);
                    } else {
                        return $this->failNotFound('Profile not updated.');
                    }
                }
                else {
                        return $this->failNotFound('User not exist.');
                    }
            } else {
                return $this->failNotFound('Please provide all data.');
            }
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }

    
     public function UpdateProfileimage() {

        $userdata = array();
        $userid = $this->request->getPost('userid');
       // echo "<pre>";print_r($this->request->getPost());
        //echo "<pre>";print_r($_FILES);exit;


        
        $profileImage = "";

         if (!empty($_FILES['profileimage']['name'])) {
           // echo "in";exit;
              $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
              $file_type  = $_FILES['profileimage']['type'];
              $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['profileimage']['name'];
                $profile = $userFolderpath.$newfilename;

                //echo "in";exit;
                 
                if (move_uploaded_file($_FILES['profileimage']['tmp_name'], $profile)) {
                    $profileImage = $newfilename;
                }
            }
            //echo $profileImage; exit;
        }

        //echo $profileImage;
       // exit;


        if ($userid && $profileImage) {
            
                $userdata['profile'] = $profileImage;

                //$Update = $this->model->where('id', $userid)->set('profile',$userdata['profile'])->update();

                $Update = $this->model->do_upload($profileImage,$userid);
                $abc=$this->model->getLastQuery();
                //echo $Update;exit;

                if ($Update) {
                    $userdata['id'] = $userid;
                    $response = [
                        'status' => 201,
                        //'abc' => $Update,
                        'error' => null,
                        'messages' => [
                            'success' => 'Profile updated successfully'
                        ],
                        'userdetail' => $userdata
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Profile not updated.');
                }
            
        } else {
            return $this->failNotFound('Please provide all data.'.print_r($_FILES));
        }
    }

    
    public function getotp() {

        $mobileno = $this->request->getGet('mobileno');
        $customer = $this->request->getGet('customer');
        $language = $this->request->getGet('language');



        if ($mobileno && $customer=='customer') {
            $data = $this->model->where('mobile', $mobileno)->where('delete_status', '0')->first();

            //echo "<pre>";print_r($data);exit;

            if ($data) {

                if ($mobileno=='66666666') {
                  $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => '6666',
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                    exit;
                }
                helper('text');
                $otpno =  random_string('nozero', 4);

                $userid = $data['id'];
                $userdata = array("password" => password_hash($otpno,1));
               
                $usermodel = new CustomerModel();
                $Update = $usermodel->where('id', $userid)->set($userdata)->update();

                if ($Update) {
                  
                    $mobileno = "968".$mobileno;  
                    $smsemail = new EmailSms();  
                    $smsemail->send_sms($mobileno,"Your verification code is: ".$otpno."  Message id : lMn7ahqOEjz ",$language);
       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => $otpno,
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Otp not generated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        }elseif($customer=="company" && $mobileno){

            $data = $this->branch->where('branch_autho_no', $mobileno)->first();


            if ($data) {
                helper('text');
                $otpno =  random_string('nozero', 4);

                $userid = $data['branch_id'];
                $userdata = array("mobile_otp" => password_hash($otpno,1));
               
                
                $Update = $this->branch->where('branch_id', $userid)->set($userdata)->update();

                if ($Update) {
                  
                    $mobileno = "968".$mobileno;  
                    $smsemail = new EmailSms();  
                    $smsemail->send_sms($mobileno,"Your verification code is: ".$otpno."  Message id : lMn7ahqOEjz ",$language);
       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => $otpno,
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Otp not generated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        } else {
            return $this->failNotFound('Please enter mobile no.');
        }
    }  

    public function getmobdata() {

        $mobileno = $this->request->getPost('mobileno');
        $customer = $this->request->getPost('customer');
        // print_r($mobileno);exit;

        if ($mobileno && $customer=='customer') {
            //echo "string";exit;

            $data = $this->model->where('mobile', $mobileno)->where('delete_status', '0')->first();
            if ($data) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data Find successfully'
                    ],
                    'user_data' => $data,
                ];
                return $this->respondCreated($response);
            }else{
                 return $this->failNotFound('Data not Found.');
            }
        }elseif($customer=="company" && $mobileno){
            $data = $this->branch->where('branch_autho_no', $mobileno)->first();
            if ($data) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data Find successfully'
                    ],
                   
                    'user_data' => $data,
                ];
                return $this->respondCreated($response);
            }else{
                 return $this->failNotFound('Data not Found.');
            }
        }

    }  

    
     public function getCitycode() {


        $data = array();

        $user_code = $this->request->getPost('user_code');
         $companyid=(isset($_POST['companyid']) && !empty($_POST['companyid'])) ? $this->request->getPost('companyid') : '';
        


             $city_code = $this->model->city_code($user_code);       
		if($city_code){	
	        $searchArray = array('city_code'=>$user_code);
            $codevalue = 'City Code';	
		}
		$org_code = $this->model->org_code($user_code);
        $org_id=$org_code->org_id;
        $OrgCompanyModel = new OrgCompanyModel();
        $checkcompany=$OrgCompanyModel->where('org_id',$org_id)->where('company_id',$companyid)->first();
        // print_r($org_code);exit;
		$vip_code = $this->model->vip_code($user_code);
		 if($vip_code){	
		  $searchArray = array('vip_code'=>$user_code);
                  $codevalue = 'V.I.P Code';
		
}elseif($checkcompany){
  	  $obj = (object) array(
    'customer_type'=>'vip',
    'status'=> '1',
     'city_code'=> '',
    'arb_name'=> '',
    'username'=> '',
    'family_name'=> '',
    'mobile'=> '',
    'password'=> '',
    'email'=> '',
    'language'=> '',
    'interest'=> '',
    'gender'=> '',
    'profile'=> '',
    'date_of_birth'=> '',
    'governorate'=> '',
    'nationality'=> '',
    'state'=> '',
    'stateid'=> '',
    'cityid'=> '',
    'commission'=> '',
    'totalpoint'=> '',
    'totalsaveamount'=> '',
    'start_date'=> '',
    'end_date'=> '',
    'android_token'=> '',
    'created_date'=> '',
    'updated_date'=> '',
    'device'=> '',
    'delete_status'=> '',
    'state_name'=> '',
    'arb_state_name'=> '',
    'city_name'=> '',
    'city_arb_name'=> ''
  
);
         
           $obj_merged[] = (object) array_merge((array) $org_code, (array) $obj);
               
            $codevalue = 'V.I.P Code';
            if($user_code = $org_code){
                 $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('users')."/",
                'code' => $codevalue,
                //'userdetail' => $obj_merged,
            ];
		$response['userdetail'] = $obj_merged;
            return $this->respond($response);

            }     
        }


       
                
           if (($user_code = $city_code) || ($user_code = $vip_code)) {            
            $data = $this->model->getData($searchArray);
     





               

            
           //print_r($data);die;
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('users')."/",
                'company_base_url' => base_url('company')."/",
                'code' => $codevalue,
                'userdetail' => $data,
            ];
            return $this->respond($response);

            } else {
                return $this->failNotFound('Please Provide Valid Code.');
          }                                                
    } 


public function updatetoken() {

       $mobileno = $this->request->getPost('mobileno');
	   $android_token = $this->request->getPost('android_token');
       
        if ($mobileno) {
            $data = $this->model->where('mobile', $mobileno)->first();

            if ($data) {
                $userid = $data['id']; 
                $userdata = array("android_token" => $android_token); 
             
                $usermodel = new CustomerModel();
                $Update = $usermodel->where('id', $userid)->set($userdata)->update();

                if ($Update) {       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'android_token updated successfully'
                        ],
                        'android_token' => $android_token,
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('android_token not updated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        } else {
            return $this->failNotFound('Please enter mobile no and android_token.');
        }
    }
    
    public function addpoints() {       
        $userid         = $this->request->getPost('userid');
        $companyid      = $this->request->getPost('companyid');
        $branchid       = $this->request->getPost('branchid');
        $ordernumber    = $this->request->getPost('ordernumber');
        $totalamount    = $this->request->getPost('totalamount');
        $paidamount     = $this->request->getPost('paidamount');
        $discount       = $this->request->getPost('discount');
        $desc       = $this->request->getPost('description');
                
        $data = array();		
	    $image = "";

         if (!empty($_FILES['image']['name'])) {
              $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
              $file_type  = $_FILES['image']['type'];
              $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['image']['name'];
                $profile = $userFolderpath.$newfilename;
                 
                if (move_uploaded_file($_FILES['image']['tmp_name'], $profile)) {
                    $image = $newfilename;
                }
            }
        }
        
        if ($userid && $companyid && $branchid && $totalamount && $paidamount && $discount) {
            
            $points = $paidamount * PER_OMR_POINT;            
            $arrOrder = [
                "od_userid"=>$userid,
                "od_companyid"=>$companyid,
                "od_branchid"=>$branchid,
                "od_number"=>$ordernumber,
                "od_totalamount"=>$totalamount,
                "od_saveamount"=>$discount,
                "od_paidamount"=>$paidamount,
                "od_point"=>$points,
                "od_description"=>$desc,
		        "image" =>$image,
            ];
            
            $objOrder = new OrdersModel();
            $orderid = $objOrder->insert($arrOrder);
             
            $objCustomer = new CustomerModel();
            $objCustomer->setCustomerpoint($userid,$points,'CR',$orderid);

            $saveamount = $totalamount-$paidamount;
            $data =  $arrCusDetail = $this->model->where('id', $userid)->first();
           // echo $this->model->getLastQuery();die;
           // print_r($arrCusDetail);die;
            if($arrCusDetail) {
                  $currentPoint = $arrCusDetail['totalsaveamount'];            
                  $currentPoint1 = $currentPoint + $saveamount;                        
                  $customerDetail = array("totalsaveamount"=>$currentPoint1);
                  $Update = $this->model->where('id', $userid)->set($customerDetail)->update();
               }    
                       
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Point aaded succesfully'
                ],               
              ];
            } else {
            return $this->failNotFound('Please provide all data.');
        }            
            $response['userdetail'] = $data;
            return $this->respond($response);        
    }

////////////////////////////////////// transfer point api //////////////////////
	
	
	 public function transferPoint() {
           $sender_user_id = $this->request->getPost('sender_user_id');
	   $point = $this->request->getPost('point');
	   $rcvr_code = $this->request->getPost('rcvr_code');
	   	   
	   $customerModel = new CustomerModel();

           $city_code = $customerModel->city_code($rcvr_code);
           if($city_code){			
              $rcvr_id = $city_code->id;
	      $rcvr_point =	$city_code->totalpoint;
            }
		
	  $vip_code = $customerModel->vip_code($rcvr_code);
	  if($vip_code){	
	         $rcvr_id = $vip_code->id;	
		 $rcvr_point =	$vip_code->totalpoint;
	}
				       
        if ($sender_user_id && $rcvr_code) {
            $data = $this->model->where('id', $sender_user_id)->first();

            if ($data && $rcvr_id) {
                $userid = $data['id']; 
                $userdata = array("totalpoint" => $data['totalpoint'] - $point); 
             
                $usermodel = new CustomerModel();
                $Update = $usermodel->where('id', $sender_user_id)->set($userdata)->update();
				
		$rid = $rcvr_id; 
                $userdata1 = array("totalpoint" => $rcvr_point + $point);              
                $Update1 = $usermodel->where('id', $rid)->set($userdata1)->update();

                if ($Update && $Update1) {       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                         'success' => 'points updated successfully'
                        ],
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('not updated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        } else {
            return $this->failNotFound('Please enter all fields.');
        }
    }

/////////////////////////////////////////portfolio api////////////////////////////////////
	
	 public function portfolioApi() {
		          		 
                $user_id = $this->request->getGet('user_id');		
		        $orderModel = new OrdersModel();		
                $orderlist = $orderModel->getOrdersApi($user_id);	

                $i = 0;
                foreach($orderlist as $info){   
                    $savng_amount =  $info->od_totalamount - $info->od_paidamount;
                    $savng_amount = number_format($savng_amount,3);
                    $array11[$i] = array( 
                           'image_base_url' => base_url('company')."/",
            			   'id' => $info->od_id,	                      
                                    'company_name' => $info->company_name,
            			   'branch_name' => $info->branch_name,
            			   'company_image' => $info->picture,
            			   'purchase_amount'=> $info->od_paidamount,
            			   'points' => $info->od_point,
            			   'reddem_point' => $info->reddem_point,
            			   'saving_amount' => $savng_amount,
                           'purchase_date' => $info->created_date,				 			
                           'coupon_type' => $info->coupon_purchase_id,                          
                           'coupon_amount' => isset($info->coupon_amount)?$info->coupon_amount:'',                          
                           'coupon_price' => isset($info->coupon_price)?$info->coupon_price:'',                          
                          );
                          $i++;
                       }

            if($user_id){
              if ($orderlist) {                               
                 $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Purchased item listed successfully'
                    ],
                    'Purchased item list' =>$array11,                   
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Purchased item available.');
            }
         }
           else {
                return $this->failNotFound('User not Exist.');
            }
          } 
		
	
    
   
	
	
//////////////////////// send notification ///////////////

 public function Notification() {
        //echo "<per>";print_r($this->request->getPost());exit;

        $userid         = $this->request->getPost('userid');
        $companyid      = $this->request->getPost('companyid');
        $branchid       = $this->request->getPost('branchid');
        //$ordernumber    = $this->request->getPost('ordernumber');
        $totalamount    = $this->request->getPost('totalamount');
        $paidamount     = $this->request->getPost('paidamount');
        $redeempoint     = $this->request->getPost('redeempoint');
        $coupon_purchase_id = (isset($_POST['coupon_purchase_id']) && !empty($_POST['coupon_purchase_id'])) ?  $this->request->getPost('coupon_purchase_id') : '';
         $coupon_id = (isset($_POST['coupon_id']) && !empty($_POST['coupon_id'])) ?  $this->request->getPost('coupon_id') : '';

      
       
        
        
        $discount       = $this->request->getPost('discount');
        //$desc           = $this->request->getPost('description');
        $notificationtype = $this->request->getPost('notificationtype');
        $product_id = $this->request->getPost('product_id');
        
        $product_id = $product_id ? $product_id :0;
        $usertransactioncode = $this->order->generateusercode();


        if ($redeempoint!='') {
            $redeempoint = $this->request->getPost('redeempoint');
        }else{
            $redeempoint ='0';
        }

        if (isset($_POST['offer_id'])) {
           $offer_id = $this->request->getPost('offer_id');
        }else{
            $offer_id ='';
        }

        //echo $redeempoint;exit;

        $data = array();
        $image = "";
         if (!empty($_FILES['image']['name'])) {
              $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
              $file_type  = $_FILES['image']['type'];
              $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['image']['name'];
                $profile = $userFolderpath.$newfilename;
                 
                if (move_uploaded_file($_FILES['image']['tmp_name'], $profile)) {
                    $image = $newfilename;
                }
            }
        }
       
        if ($userid!='' && $companyid!='' && $branchid!='' && $totalamount!='' && $paidamount!='' && $discount!='' &&  $notificationtype!='') {

            //echo "in";exit;

        	$data =  $arrCusDetail = $this->model->where('id', $userid)->first();
                $interest = explode(',', $arrCusDetail['interest']);
        	$strinterest =  implode(',', $interest);
                $interestss = ",".$strinterest.",";
		
            $Compnay_details = $this->companycode->where('id', $offer_id)->first();
            $commission1 = $Compnay_details['comission'];
            // echo "<pre>";print_r($commission1);exit;
            $discount1 = $Compnay_details['discount_detail'];

            if ($commission1 > 0) {
                $points = $paidamount * PER_OMR_POINT;
                $city_commission = $paidamount * $commission1/100;
            }else{
                //$points =$discount + $paidamount;
                $points = $paidamount * PER_OMR_POINT;
                
                 $city_commission = 0;
            }
              


          
            $saveamount = $totalamount - $paidamount;           
            $arrOrder = [
                "od_userid"=>$userid,
                "od_companyid"=>$companyid,
                "od_branchid"=>$branchid,
                //"od_number"=>$ordernumber,
                "od_totalamount"=>$totalamount,
                "od_saveamount"=> $saveamount,
                "od_paidamount"=>$paidamount,
                "od_point"=>$points,
                //"od_description"=>$desc,
                "reddem_point"=>$redeempoint,
                "product_id"=>$product_id,
                "od_discount"=>$discount,
                "image" => $image, 
                "citycode_commission" => $city_commission, 
                "notification_id" => 1, 
                "usertransactioncode" => $usertransactioncode,
                "usertransactionstatus" => 'true',             
                "coupon_purchase_id" => $coupon_purchase_id,             
                "coupon_id" => $coupon_id,             
            ];


            $objOrder = new OrdersModel();
            $orderid = $objOrder->insert($arrOrder);

           

            $notificationOrder=array();

            $notificationOrder = [
                "company_id"=>$companyid,
                "notification_type"=>"purchase",
                //"description"=>$desc,
                "reddem_point"=>$redeempoint,
                "interest"=> $interestss,             
                "order_id"=> $orderid,             
                "user_id"=> $userid,
                      
            ];
  if ($coupon_purchase_id) {
           $notificationOrder['coupon_type']='coupon';
        }

          

       
            $notifyModel = new NotificationModel();
            $notify_id = $notifyModel->insert($notificationOrder); 
            //getlastid();
             if($points)
             {
                $objCustomer = new CustomerModel();
                $objCustomer->setCustomerpoint($userid,$points,'CR',$orderid);
             }

            $saveamount = $totalamount-$paidamount;
            // $data =  $arrCusDetail = $this->model->where('id', $userid)->first();
        
            if($arrCusDetail) {
                $currentPoint = $arrCusDetail['totalsaveamount'];            
                $currentPoint1 = $currentPoint + $saveamount;                        
                $customerDetail = array("totalsaveamount"=>$currentPoint1);
                $Update = $this->model->where('id', $userid)->set($customerDetail)->update();

                $countorder = count($this->order->where('notification_id', '1')->findAll());                 
                $arrCompnay = $this->company->where('id', $companyid)->first();
        		$company_name = $arrCompnay['display_name'] ? $arrCompnay['display_name'] : $arrCompnay['company_name'];
                        $arb_company = $arrCompnay['display_arb_name'] ? $arrCompnay['display_arb_name'] : $arrCompnay['company_arb_name'];
        		$arrBranch = $this->branch->where('branch_id', $branchid)->first();
        		$branch_name = $arrBranch['branch_name'];
        		$arb_branch = $arrBranch['arb_branch_name'];
			
    		    if ($arrCusDetail['city_code']) {
    	            $user_code = $arrCusDetail['city_code'];
    		    }
    			if ($arrCusDetail['vip_code']) {
    			    $user_code = $arrCusDetail['vip_code'];
    			}
			
    			$arrMessage =  array( "title"=>" City Code Confirmation", "body"=>"City Code Confirmation, Please Accept or Cancel",
                            "details"=>array("notification_id" => $countorder,"order_id" => "$orderid", "userid"=>$userid, "user_code" => $user_code, "companyid"=>$companyid, "companyname"=>$company_name, "arb_companyname"=>$arb_company, "branchid"=>$branchid, "branchname"=>$branch_name, "arb_branchname"=>$arb_branch, "saveamount"=>$saveamount,
                                       "totalamount"=>$totalamount, "paidamount"=>$paidamount, "discount"=>$discount, "image" =>base_url('company')."/".$arrCompnay['picture'], "notificationtype"=>$notificationtype,"redeempoint"=>$redeempoint));
      
                $push = new Pushnotification();                  
                $push->sendAndroidNotification($arrCusDetail['android_token'],$arrMessage,"City Code Confirmation");                  
            }    
                       
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Notification send succesfully'
                ],  
               
               "fcm_token"=>$arrCusDetail['android_token'],
                "data"=>$arrMessage
            ];
        } else {
            return $this->failNotFound('Please provide all data.');
        }
            
        $response['userdetail'] = $data;
        return $this->respond($response);        
    }

///////////////////// accept api /////////////////////////

public function Acceptapi() {
       $od_id = $this->request->getPost('od_id');
       $status = $this->request->getPost('status');
       
        if ($od_id && $status) {
            $data = $this->order->where('od_id', $od_id)->first();
            //echo $data['reddem_point'];exit;

            if ($data['usertransactionstatus'] == 'true') {
                $order_id = $data['od_id']; 
                $od_userid = $data['od_userid']; 
                $reddem_point = $data['reddem_point']; 

                $userdata = array("usertransactionstatus" => 'false',"usertransactionstatus" => 'false'); 
                $Update = $this->order->where('od_id', $order_id)->set($userdata)->update();
               
                //update user points and insert into history
                $objCustomer = new CustomerModel();
                $objCustomer->setCustomerpoint($od_userid,$reddem_point,'DR',$order_id);
                
                
//                $custdata = $this->model->where('id', $od_userid)->first();
//
//                $custpoint = $custdata['totalpoint'];
//                $newcustpoint = $custpoint-$reddem_point;
//                $custpointdata = array("totalpoint" => $newcustpoint); 
//                $Updatecust = $this->model->where('id', $od_userid)->set($custpointdata)->update();
//                //echo "<pre>";print_r($Updatecust);exit;


                $notidata = array("accept_status" => '1'); 

                $notify = new NotificationModel;

                $Update = $notify->where('order_id', $order_id)->set($notidata)->update();
				
			$companyid = $data['od_companyid'];
			$branchid = $data['od_branchid'];
			$discount = $data['od_discount'];
			$totalamount = $data['od_totalamount'];
			$paidamount =  $data['od_paidamount'];
			$userid =  $data['od_userid'];
                        $saveamount = ($data['od_totalamount']) - ($data['od_paidamount']);
	
			$arrUser = $this->model->where('id', $userid)->first();
                        if ($arrUser['city_code']) {
			$user_code = $arrUser['city_code'];
			}			
			if ($arrUser['vip_code']) {
			$user_code = $arrUser['vip_code'];
			}	                
			$arrCompnay = $this->company->where('id', $companyid)->first();
			$company_name = $arrCompnay['company_name'];
                        $arb_company = $arrCompnay['company_arb_name'];
		        $arrBranch = $this->branch->where('branch_id', $branchid)->first();
			$branch_name = 	$arrBranch['branch_name'];
			$arb_branch = 	$arrBranch['arb_branch_name'];
			$android_token = $arrBranch['android_token'];
                        //$countstatus = count($this->order->where('status', '1')->findAll());			
			
			$arrMessage =  [ "title"=>" City Code Confirmation", "body"=>"City Code Confirmation, Please Accept or Cancel",
                       "details"=>["order_id"=>$order_id, "userid"=>$userid, "user_code" => $user_code, "companyid"=>$companyid, "companyname"=>$company_name, "arb_companyname"=>$arb_company, "branchid"=>$branchid, "branchname"=>$branch_name, "arb_branchname"=>$arb_branch, "discount"=>$discount, "totalamount"=>$totalamount, "paidamount"=>$paidamount, "saveamount"=>$saveamount,"image" =>base_url('company')."/".$arrCompnay['picture'], "notificationtype"=>"company","reddem_point"=>$reddem_point],];             

                if ($Update) { 

                  $push = new Pushnotification();                  
                  $push->sendAndroidNotification($android_token,$arrMessage,"City Code Confirmation"); 
      
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'status updated successfully'
                        ],
                        
                        "fcm_token"=>$android_token,
                        "data"=>$arrMessage
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('status not updated.');
                }
            } else {
                return $this->failNotFound('status already updataed.');
            }
        } else {
            return $this->failNotFound('Please enter all fields.');
        }
    }	
	
	////////////////////////// update company token ////////////////////////
	
	public function update_company_token() {

       $branch_id = $this->request->getPost('branch_id');
       $android_token = $this->request->getPost('android_token');
       
        if ($branch_id && $android_token) {
            $data = $this->branch->where('branch_id', $branch_id)->first();

            if ($data) {
                $bid = $data['branch_id']; 
                $userdata = array("android_token" => $android_token);             
                $Update = $this->branch->where('branch_id', $bid)->set($userdata)->update();

                if ($Update) {       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'android_token updated successfully'
                        ],
                        'android_token' => $android_token,
                        'branch_id' => $bid,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('android_token not updated.');
                }
            } else {
                return $this->failNotFound('Branch Id not exist.');
            }
        } else {
            return $this->failNotFound('Please enter branch_id and android_token.');
        }
    }


////////////////////////////////////////////// User Transaction Code //////////////////////////////////

public function TransactionCode() {
        $userid = $this->request->getGet('userid');  
        $data = array ();  
        if ($userid) {             
            $data = $this->order->getlast($userid);
          //  echo "<pre>";print_r($data);exit;
      
            
                    $orderid = $data->od_id;
                    $usertransactioncode = $data->usertransactioncode;
                    $companyid = $data->od_companyid;
                    $branchid = $data->od_branchid;
                    $company_name = $data->company_name;
                    $arb_company = $data->company_arb_name;	
                    $branch_name = $data->branch_name;
                    $arb_branch = $data->arb_branch_name;
                    $discount = $data->od_saveamount;
                    $totalamount = $data->od_totalamount;
                    $paidamount =  $data->od_paidamount;
                    $redeempoint =  $data->reddem_point;
                    $status = $data->usertransactionstatus;	
					
	            $arrMessage = ["order_id" => "$orderid", "userid"=>$userid, "usertransactioncode" => $usertransactioncode, "companyid"=>$companyid, "companyname"=>$company_name, "arb_companyname"=>$arb_company, "branchid"=>$branchid, "branchname"=>$branch_name, "arb_branchname"=>$arb_branch, "discount"=>$discount,"totalamount"=>$totalamount, "paidamount"=>$paidamount, "usertransactionstatus"=>$status,"redeempoint"=>$redeempoint];				                  
            //print_r($arrMessage);die;                          
            $response = [
                'status' => 201,
                'error' => null,                   
		"data"=>$arrMessage                                               
            ];

           return $this->respondCreated($response);
 
            } 
	  else {
            return $this->failNotFound('Please enter userid.');
        } 
                  
    }
    

/////////////////////////////////////////////// Check Transaction Code ///////////////////////////

public function CheckTransactionCode() {

        $companyid = $this->request->getPost('companyid');
	   $userid = $this->request->getPost('userid');
	   $usertransactioncode = $this->request->getPost('usertransactioncode');
	   $usertransactionstatus = $this->request->getPost('usertransactionstatus');
	          
        if ($usertransactioncode && $companyid && $userid) {
            $data = $this->order->where('usertransactioncode', $usertransactioncode)->first();						
    	    $user_id = $data['od_userid'];
            $order_id = $data['od_id'];
    	    $usercode = $data['usertransactioncode'];
    	    $company_id = $data['od_companyid'];
            $status = $data['usertransactionstatus'];
            //$od_userid = $data['od_userid']; 
            $reddem_point = $data['reddem_point']; 

            if ($user_id && $usercode && $company_id && $status == 'true') {
                $userdata = array("usertransactionstatus" => 'false');             
                $Update = $this->order->where('usertransactioncode', $usercode)->set($userdata)->update();
                $notify = new NotificationModel;
                $notidata = array("accept_status" => '1');             
                $Update = $notify->where('order_id', $order_id)->set($notidata)->update();
               // $Update = $this->order->where('usertransactioncode', $usercode)->set($userdata)->update();
                $custdata = $this->model->where('id', $user_id)->first();

                $custpoint = $custdata['totalpoint'];
                $newcustpoint = $custpoint-$reddem_point;
                $custpointdata = array("totalpoint" => $newcustpoint); 
                $Updatecust = $this->model->where('id', $user_id)->set($custpointdata)->update();

                if ($Update) {       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => 'success' 
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Invalid Code.');
                }
            }else {
                return $this->failNotFound('Invalid Code.');
            }
        }else {
            return $this->failNotFound('Please provide all data.');
        }
    }
	
	
	//////////////////////////////// notification list ////////////////////////

		  
    public function NotificationList() {

        $userid = $this->request->getGet('userid');  
        $data = array ();  
        $userNotification = array();
        if ($userid) {             
            $data = $this->model->where('id', $userid)->first(); 
            $user_id = $data['id'];					
            $createddate = $data['created_date'];  // for notification will come after this date
            $createddate = explode(" ",$createddate);
            $createddate=$createddate[0];					
	    $interest = explode(',', $data['interest']);
            $strInterest ="";
            $count=1;
            foreach($interest as $userinterest){
                $strInterest .= "interest  LIKE '%,".$userinterest.",%' ";
                ($count > 0 && count($interest) > $count) ? $strInterest .= " OR " : " ";
                $count++;
            }
            $notify = new notificationModel();
            $arrSearch = array();
            $arrSearch['gender'] = (isset($data['gender']) && $data['gender']) ? $data['gender'] : "";
            $arrSearch['governet'] = (isset($data['stateid']) && $data['stateid']) ? $data['stateid'] : "";
            $arrSearch['state'] = (isset($data['cityid']) && $data['cityid']) ? $data['cityid'] : "";
            $arrSearch['language'] = (isset($data['language']) && $data['language']) ? $data['language'] : "";
             
            $notelist = $notify->getDetailsCompany($strInterest,$createddate,$arrSearch);
              // echo "<pre>";print_r($notelist);exit;
            $i = 0;
            foreach($notelist as $info){   
                $instrest_users_data = rtrim($info->user_id,",");
                $instrest_users = explode(",", $instrest_users_data);
                foreach ($instrest_users as $key => $intsvalue) {
                    //echo $userid."==".$intsvalue;
                    if (($userid == $intsvalue) && ($info->notification_type != 'purchase')) {
                        $status = 1;
                        break;
                    }else{
                        $status = 0;
                    }
                }
                
                //if purchase type notification then only so the purchase user
                if($info->notification_type == 'purchase')
                {
                    if($info->od_userid != $userid)
                    {
                        $status = 1;
                    }
                }
              //  echo $status;die;
               // echo  $info->accept_status; exit;
                if ($status == 0) {
                    $notation_id='';
                    $picture='';
                    $company_name='';
                    $company_arb_name='';
                    $notification_type='';
                    $title='';
                    $description='';
                    $interest='';
                    $od_id='';
                    $branch_name='';
                    $arb_branch_name='';
                    $od_discount="0";
                    $od_paidamount= "0";
                    $od_totalamount= "0";
                    $reddem_point= "0";
                    $created_date='';
                    $coupon_type='';
                    if ($info->notation_id!='') {
                        $notation_id=$info->notation_id;
                    }
                    if ($info->coupon_type!='') {
                        $coupon_type=$info->coupon_type;
                    }
                    if ($info->picture!='') {
                        $picture=$info->picture;
                    }
                    if ($info->company_name!='') {
                        $company_name=$info->company_name;
                    }
                    if ($info->company_arb_name!='') {
                        $company_arb_name=$info->company_arb_name;
                    }
                    if ($info->notification_type!='') {
                        $notification_type=$info->notification_type;
                    }
                    if ($info->title!='') {
                        $title=$info->title;
                    }
                    if ($info->description!='') {
                        $description=$info->description;
                    }
                    if ($info->interest!='') {
                        $interest=$info->interest;
                    } 
                    if ($info->od_id!='') {
                        $od_id=$info->od_id;
                    } 
                    if ($info->branch_name!='') {
                        $branch_name=$info->branch_name;
                    } 
                    if ($info->arb_branch_name!='') {
                        $arb_branch_name=$info->arb_branch_name;
                    } 
                    if ($info->od_discount!='') {
                        $od_discount=$info->od_discount;
                    }
                    if ($info->od_paidamount!='') {
                        $od_paidamount=$info->od_paidamount;
                    }
                    if ($info->created_date!='') {
                        $created_date=$info->created_date;
                    }
                    if ($info->reddem_point!='') {
                        $reddem_point=$info->reddem_point;
                    }

                    if ($info->od_totalamount!='') {
                        $od_totalamount=$info->od_totalamount;
                    }

                    $userNotification[$i] = array(  
                      'coupon_type' => $coupon_type,                                     
    		       'notification_id' => $notation_id,	                      
                       'company_id' => $info->company_id,                       
    		        'company_logo' => $picture,
                       'company_name' => $company_name,
                       'company_arb_name' => $company_arb_name,
                       'type' => $notification_type,
                       'title'=>$title,           
    		        'text'=> $description,
    		        'interest'=> $interest,
                       'notifyimage'=> $info->notifyimage,
                       'image_url'=> $info->image_url,
                       'order_id'=> $od_id,
                       'branch_name'=> $branch_name,
                       'branch_arb_name'=> $arb_branch_name,
                       'discount'=> $od_discount,
                       'discount_amout'=> $od_paidamount,
                       'amount'=> $od_totalamount,
                       'accept_status'=> $info->accept_status,
    		       'time' => $created_date ,                      				 			
                       'reddem_point' => $reddem_point,                                                  
                       'language' => $info->language,                                              
                                                                  
                    );
                    $i++;
                }
            }

            if ($notelist) {                               
                $response = [
                    'status' => 201,
                    'error' => null,
		     'image_base_url' => base_url('company')."/",					
                    'Notification list' =>$userNotification,                   
                ];
               // echo "<pre>";print_r($response);exit;
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Notification list available.');
            }
        }
        else{
            return $this->failNotFound('User not Exist.');
        }                  
    }


    public function NotificationDeleteApi() {
        $userid         = $this->request->getPost('userid');
        $companyid      = $this->request->getPost('companyid');
        $notificationid      = $this->request->getPost('notificationid');
        if ($userid!='' && $notificationid!='') {
            $notifiModel = new NotificationModel();  
            $preusers = $notifiModel->where('id', $notificationid)->find();
            $preuser = $preusers[0]['user_id'];
            if ($preuser!='') {
                $finaluser =$preuser.$userid.','; 
            }else{
                $finaluser = $userid.',';
            }
            $user_data =[
                'user_id'=>$finaluser,
            ];
            // echo "<pre>";print_r($finaluser);exit;
            $Update =$notifiModel->where('id', $notificationid)->set($user_data)->update();
            //echo $notifiModel->getLastQuery();die();
            if ($Update) {                               
                 $response = [
                    'status' => 201,
                    'error' => null,
                    'msg' =>'Deleted Successfully!',                   
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 404,
                    'error' => null,
                    'msg' =>'',                   
                ];
                return $this->respondCreated($response);
            }
        }
    }

    public function DeleteUserApi() {
        $userid = $this->request->getPost('user_id'); 
        //$data = $this->model->where('id', $userid)->first(); 
        if ($userid!='') {
            $deleteuserdata=[
                'delete_status' => '1',
            ];
            $Update = $this->model->where('id', $userid)->set($deleteuserdata)->update();
            if ($Update) {                               
                 $response = [
                    'status' => 201,
                    'error' => null,
                    'msg' =>'Deleted Successfully!',                   
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 404,
                    'error' => null,
                    'msg' =>'',                   
                ];
                return $this->respondCreated($response);
            }
        }
    }

    public function GetMallList() {

        $malldata = $this->companycode->getmalllist();
        //echo $this->companycode->getLastQuery();exit;
        if ($malldata) {   
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Mall listed successfully',
                ],
               'mall_data' => $malldata,                 
            ];
        //echo "<pre>";print_r($response);exit;
            return $this->respondCreated($response);
        }else{
            return $this->failNotFound('No Mall available.');
        }

    }

    public function GetOfferList() {

        $siteModel = new SitevariableModel();

        $offerdata = $siteModel->getofferdata();
        if ($offerdata) {   
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Offer listed successfully',
                ],
               'offerdata_data' => $offerdata,                 
            ];
        //echo "<pre>";print_r($response);exit;
            return $this->respondCreated($response);
        }else{
            return $this->failNotFound('No Offer available.');
        }

    }

    public function chat() {

        $arrResponse = array('response' => 'failure', 'message' => 'Invalid access.',);
        $reponsestatus = true;

        if ($this->request->getPost()) {
            //$userdata = $this->input->post();
            $userdata = $this->request->getPost();
            
            if (count($userdata)) {
                $sender_id = $userdata['sender_id'];
                $receiver_id = $userdata['receiver_id'];
                $image = isset($userdata['image']) ? $userdata['image'] : "";
                $msg = $userdata['msg'];
                $send_by = $userdata['send_by'];
                // {
                if ($sender_id != "" && $receiver_id != "" && $msg != "") {
                    $data = array(
                        'sender_id' => $sender_id,
                        'receiver_id' => $receiver_id,
                        'msg' => $msg,
                        'image' => $image,
                        'send_by' => $send_by,
                        'created_date' => date('Y-m-d H:i:s'),
                    );
                    
                    $chatmodel = new ChatModel();
                    $res = $chatmodel->insert($data);
                    
                    if ($res) {
                        $d = array(
                            'lastmsg' => $msg,
                            'message_date' => date('Y-m-d H:i:s'),
                        );
                        
                        //check user is on the chat window then not send notification
                        $objChatstatus = new ChatStatusModel();
                        //check my status with new chat users
                        $objChatstatus->inserChatstatus($sender_id,$receiver_id);
            
                        $windowstatus = $objChatstatus->checkChatstatus($receiver_id,$sender_id);
                        if(!$windowstatus)
                        {
                            //send notification to reciever
                            $Pushnotification = new Pushnotification();
                            $arrMessage =  array("title"=>"","body"=>"","details"=>array());
                            $details = array("sender_id"=>$sender_id,"receiver_id"=>$receiver_id,"notificationtype"=>'chat',"company_logo"=>"","company_id"=>"","company_name"=>"","customer_image"=>"","customer_name"=>"");
                            if($send_by == 'company')
                            {
                               //branch details
                                $compayId =  $sender_id;
                                $compayModel = new  BranchModel();
                                $searchArr = array("id"=>$compayId);
                                $arrBranchdetail = $compayModel->getData($searchArr);
                                $arrBranchdetail = isset($arrBranchdetail[0]) ? $arrBranchdetail[0] : array();
                                $arrMessage['title'] = isset($arrBranchdetail['company_name']) ? $arrBranchdetail['company_name'] : "";
                                $arrMessage['body'] = $msg;
                                $details['company_id'] =isset($arrBranchdetail['id']) ? $arrBranchdetail['id'] : "";
                                $details['company_name'] =isset($arrBranchdetail['company_name']) ? $arrBranchdetail['company_name'] : "";
                                $details['company_logo'] =isset($arrBranchdetail['picture']) ? $arrBranchdetail['picture'] : "";
                                $details['company_image_base_url'] = base_url('company')."/";
                                //send notification to customers
                                $userId =  $receiver_id;
                                $customerModel = new CustomerModel();
                                $customerInfo = $customerModel->customerInfo($userId);
                                $userToken = isset($customerInfo[0]) ? $customerInfo[0]->android_token : "";
                                $details['customer_name'] = isset($customerInfo[0]) ? $customerInfo[0]->name : "";
                                $details['customer_image'] = isset($customerInfo[0]) ? $customerInfo[0]->profile : "";
                                $details['customer_image_base_url'] = base_url('users')."/";
                                $arrMessage['details'] =$details;
    //                            print_r($arrMessage);
                               if($userToken)
                               {
                                   $Pushnotification->sendAndroidNotification($userToken,$arrMessage);
                               }
                            }
                            else if($send_by == 'customer')
                            {
                                $userId =  $sender_id;
                                $customerModel = new CustomerModel();
                                $customerInfo = $customerModel->customerInfo($userId);


                                $arrMessage['title'] = isset($customerInfo[0]) ? $customerInfo[0]->name : "";
                                $details['customer_name'] = isset($customerInfo[0]) ? $customerInfo[0]->name : "";
                                $details['customer_image'] = isset($customerInfo[0]) ? $customerInfo[0]->profile : "";
                                $details['customer_image_base_url'] = base_url('users')."/";
                                $arrMessage['body'] = $msg;

                                //send to company
                                $compayId =  $receiver_id;
                                $compayModel = new  BranchModel();
                                $searchArr = array("id"=>$compayId);
                                $arrBranchdetail = $compayModel->getData($searchArr);

                                $arrBranchdetail = isset($arrBranchdetail[0]) ? $arrBranchdetail[0] : array();
                                $branchToken = isset($arrBranchdetail['android_token']) ? $arrBranchdetail['android_token'] : "";
                                $details['company_id'] =isset($arrBranchdetail['id']) ? $arrBranchdetail['id'] : "";
                                $details['company_name'] =isset($arrBranchdetail['company_name']) ? $arrBranchdetail['company_name'] : "";
                                $details['company_logo'] =isset($arrBranchdetail['picture']) ? $arrBranchdetail['picture'] : "";
                                $details['company_image_base_url'] = base_url('company')."/";
                                $arrMessage['details'] =$details;
                              //  print_r($arrMessage);die;
                                if($branchToken)
                                 {
                                     $Pushnotification->sendAndroidNotification($branchToken,$arrMessage);
                                 }

                            }
                        }
                            


                        $arrResponse['response'] = 'success';
                        $arrResponse['message'] = 'Send Successfully';
                                
                    } else {
                        $arrResponse['response'] = 'failure';
                        $arrResponse['message'] = 'Send Unsuccessfully"';
                    }
                }
                // }
            }
        }
        return $this->respondCreated($arrResponse);
    }

    public function chatdetalis() {
        //echo "string";exit;
        $arrResponse = array('response' => 'failure', 'message' => 'Invalid access.',);
        $reponsestatus = true;

        if ($this->request->getPost()) {
            $userdata = $this->request->getPost();
            if (count($userdata)) {
                $sender_id = $userdata['sender_id'];
                $receiver_id = $userdata['receiver_id'];

                // if($retailer_id!='')
                // {
                // echo "ok";die;
                if ($sender_id == "") {
                    $arrResponse['response'] = 'failure';
                    $arrResponse['message'] = 'Please enter sender id.';
                } else if ($receiver_id == "") {
                    $arrResponse['response'] = 'failure';
                    $arrResponse['message'] = 'Please enter receiver id.';
                } else {

                    //echo "in";exit;
                    $chatmodel = new ChatModel();
                    $where = "receiver_id is  NOT NULL";

                    //$customers = $chatmodel->select('*')->from('chat')->where("sender_id", $sender_id)->where("receiver_id", $receiver_id)->order_by('id', 'DESC')->get()->result();
                    $customers = $chatmodel->where('sender_id', $sender_id)->where("receiver_id", $receiver_id)->orderby('id', 'ASC')->find();
                    $customers1 = $chatmodel->where('sender_id', $receiver_id)->where("receiver_id", $sender_id)->orderby('id', 'ASC')->find();


                    $finalarray = array_merge($customers,$customers1);
                    $finalarray1=array();
                    if ($finalarray) {
                        foreach ($finalarray as $key => $row) {
                            $finalarray1[$key] = $row['id'];
                        }
                    }

                    array_multisort($finalarray1, SORT_ASC, $finalarray);
                    //$finalarray1 = 
                    //array_multisort($finalarray, SORT_DESC, $finalarray);
                    //echo "<pre>";print_r($finalarray);exit;


                    $count = count($finalarray);
                    if ($count > 0) {
                        // print_r($customers);die;
                        $arrResponse['response'] = 'success';
                        $arrResponse['message'] = 'Data found';
                        $arrResponse['count'] = $count;
                        $arrResponse['users'] = $finalarray;
                    } else {
                        $arrResponse['response'] = 'failure';
                        $arrResponse['message'] = 'No data found';
                    }
                }
            } else {
                $arrResponse['response'] = 'failure';
                $arrResponse['message'] = 'Please enter login details';
            }
            // }
            // else 
            // {
            //     $arrResponse['response'] = 'failure';
            //     $arrResponse['message'] = 'Please enter login details';
            // }
        }
       return $this->respondCreated($arrResponse);
    }


     public function newgetotp() {

        $mobileno = $this->request->getPost('mobileno');
        $user_id = $this->request->getPost('user_id');
        $customer = $this->request->getPost('customer');
        $language = $this->request->getPost('language');
        if ($mobileno && $customer=='customer') {
        //echo "in";exit;
            $data = $this->model->where('id', $user_id)->where('delete_status', '0')->first();

            //echo "<pre>";print_r($data);exit;

            if ($data) {

                if ($mobileno=='66666666') {
                  $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => '6666',
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                    exit;
                }
                helper('text');
                $otpno =  random_string('nozero', 4);

                $userid = $data['id'];
                $userdata = array(
                    "password" => password_hash($otpno,1),
                    "new_mob_no" => $mobileno
                );
               
                $usermodel = new CustomerModel();
               // echo "<pre>";print_r($userid);exit;
                $Update = $usermodel->where('id', $userid)->set($userdata)->update();

                if ($Update) {
                  
                    $mobileno = "968".$mobileno;  
                    $smsemail = new EmailSms();  
                    $smsemail->send_sms($mobileno,"Your verification code is: ".$otpno."  Message id : lMn7ahqOEjz ",$language);
       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => $otpno,
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Otp not generated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        }/*elseif($customer=="company" && $mobileno){

            $data = $this->branch->where('branch_autho_no', $mobileno)->first();


            if ($data) {
                helper('text');
                $otpno =  random_string('nozero', 4);

                $userid = $data['branch_id'];
                $userdata = array("mobile_otp" => password_hash($otpno,1));
               
                
                $Update = $this->branch->where('branch_id', $userid)->set($userdata)->update();

                if ($Update) {
                  
                    $mobileno = "968".$mobileno;  
                    $smsemail = new EmailSms();  
                    $smsemail->send_sms($mobileno,"Your verification code is: ".$otpno."  Message id : lMn7ahqOEjz ",$language);
       
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Otp generated successfully'
                        ],
                        'optno' => $otpno,
                        'mobile' => $mobileno,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Otp not generated.');
                }
            } else {
                return $this->failNotFound('User not exist.');
            }
        }*/ else {
            return $this->failNotFound('Please enter mobile no.');
        }
    } 

    public function newgetotpverify() {

        $mobileno = $this->request->getPost('mobileno');
        $user_id = $this->request->getPost('user_id');
        $customer = $this->request->getPost('customer');
        $password = $this->request->getPost('password');
        $language = $this->request->getPost('language');

        if ($mobileno && $password && $user_id && $customer=='customer') {
            $return = $this->model->checkUserLoginApiNew($mobileno, $password,$user_id);

            if ($return) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Updated successfully'
                    ],
                    'user_detail' => $return
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Invalid mobile number or OTP.');
            }
        }
    }


    public function AddUserIntrest() {
       $userid = $this->request->getPost('userid');
       $interest = $this->request->getPost('interest');
       if ($userid!='' && $interest!='') {
            //$custdata = $this->model->where('id', $userid)->first();
            $custintrestdata = array("interest" => $interest); 
            $Updatecust = $this->model->where('id', $userid)->set($custintrestdata)->update();
            if ($Updatecust) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Updated successfully'
                    ],
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Updated Unsuccessfully!');
            }
       }else{
        return $this->failNotFound('Please Provide All Data!');
       }
    }
    public function ApiAcceptStatus() {
       $order_id = $this->request->getPost('order_id');
       if ($order_id!='') {
            $orderModel = new OrdersModel();
            $Updatecust = $orderModel->where('od_id', $order_id)->where('usertransactionstatus', 'false')->find();
            if ($Updatecust) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Unsuccessfully!');
            }
       }else{
        return $this->failNotFound('Please Provide All Data!');
       }
       
    }
    
     public function ApiUserimpression() {
         
          $today = date('Y-m-d');
       $user_id = $this->request->getGet('userid');
       if ($user_id) {
            $userimpressionModel = new CustomerImpressionModel();
            $userImpress = $userimpressionModel->getTodayimpression($user_id);
            if ($userImpress) {
                $countImp = $userImpress[0]->cm_count;
                $updateData = array('cm_count'=>++$countImp);
                $userimpressionModel->where('cm_userid', $user_id)->where("DATE_FORMAT(cm_created, '%Y-%m-%d')",$today)->set($updateData)->update();
                // $userimpressionModel->getLastQuery();
            } 
            else {
                $updateData = array("cm_userid"=>$user_id,'cm_count'=>1);
                $userimpressionModel->insert($updateData);
            }
            
             if($user_id)
                {
                 $points =1;
                    $objCustomer = new CustomerModel();
                    $objCustomer->setCustomerpoint($user_id,$points,'CR',0,0,'Application open Bonus');
                }
            
            $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                ];
                return $this->respondCreated($response);
       }else{
        return $this->failNotFound('Please Provide All Data!');
       }
       
    }
    
    public function ApiMessageStatus() {
         
       
       $chatid = $this->request->getGet('chatid');
       $seenstatus = $this->request->getGet('seenstatus');
       $seenstatus = $seenstatus ? $seenstatus :"seen";
       $arrChatid = explode(",", $chatid);
       if ($arrChatid) {
           foreach($arrChatid as $chatid)
           {
            $chatModel = new ChatModel();
            //$updateData = array("seen_status"=>$seenstatus);
$updateData = array("seen_status"=>$seenstatus,"user_chat_status"=>'0');
             $chatModel->where('id', $chatid)->set($updateData)->update();
           }
            $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Seen successfully'
                    ],
                ];
                return $this->respondCreated($response);
       }else{
        return $this->failNotFound('Please Provide chat id!');
       }
       
    }
    
    public function ApiMessageCount() {
         
       
       $userid = $this->request->getGet('userid');
       $seenstatus = $this->request->getGet('seenstatus');
       $send_by = $this->request->getGet('send_by');
       $seenstatus = $seenstatus ? $seenstatus :"unseen";
       
       if ($userid) {
            $chatModel = new ChatModel();
            $messagecount = $chatModel->getmessagecount($userid,$send_by,$seenstatus);
            
            $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Seen successfully'
                    ],
                ];
                $response['messagecount'] = $messagecount;
                return $this->respondCreated($response);
       }else{
        return $this->failNotFound('Please Provide chat id!');
       }
       
    }
    
    public function ApiAddChatStatus() {
         
       
       $senderid = $this->request->getGet('senderid');
       $receiverid = $this->request->getGet('receiverid');
       
       if ($senderid &&$receiverid ) {
            $ChatStatusModel = new ChatStatusModel();
            
            $chatObj = $ChatStatusModel->where("senderid",$senderid)->where("receiverid",$receiverid)->find();
            if(!$chatObj)
            {
                $insertData = array("senderid"=>$senderid,"receiverid"=>$receiverid);
                $ChatStatusModel->insert($insertData);
            }
            
            $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                ];
               
                return $this->respondCreated($response);
       }else{
        return $this->failNotFound('Please Provide chat id!');
       }
       
    }
    
    public function ApiremoveChatStatus() {
         
       
       $senderid = $this->request->getGet('senderid');
       $receiverid = $this->request->getGet('receiverid');
       
       if ($senderid &&$receiverid ) {
            $ChatStatusModel = new ChatStatusModel();
            
            $chatObj = $ChatStatusModel->where("senderid",$senderid)->where("receiverid",$receiverid)->delete();
            
            
            $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                ];
               
                return $this->respondCreated($response);
       }else{
        return $this->failNotFound('Please Provide chat id!');
       }
       
    }
    
    public function iosskip()
        {
            $response = [
                        'status' => 201,
                        'data' => 7,
                        'error' => null,
                        'messages' => [
                            'success' => 'Skip successfully'
                        ],
                    ];
                    return $this->respondCreated($response);
        }
          public function showBuyPoints()
        {
            $BuyPoints= new BuyPoints();

            $points=$BuyPoints->limit(6, 0)->find();
            $response = [
                        'status' => 201,
                        
                        'error' => null,
                        'messages' => [
                            'success' => 'list successfully'
                        ],

                    ];
                    $response['buypointslist'] = $points;
                    return $this->respondCreated($response);
        }

           public function countviewbanner() {
            $id= $this->request->getGet('add_id');
            $DashboardAdvertisementModel = new DashboardAdvertisementModel();
            $iddata=$DashboardAdvertisementModel->where('add_id',$id)->find();
            if($iddata){
              
        $DashboardAdvertisementModel = new DashboardAdvertisementModel();
         
         $data =  $DashboardAdvertisementModel->find();
         // print_r($data);exit;
       
        if ($data) {
            
            $currentcount = $data[0]['countview1'] + 1;
            $updateCount = array('countview1'=>$currentcount);
           

           $DashboardAdvertisementModel->where("add_id",$id)->set($updateCount)->update();

          
                       $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'View updated successfully'
                ],
               
                
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
        } else {
            return $this->failNotFound('Banner Id Not Found');
        }
    }
    public function userAddress(){
 $formArr = array();
        //$userid = $this->request->getGet('userid');
        $formArr['user_id']=$userid = $this->request->getPost('userid');

      
       
        $formArr['name'] = $name = (isset($_POST['name']) && !empty($_POST['name'])) ? $this->request->getPost('name') : '';
        $formArr['governate'] = $governate = (isset($_POST['governate']) && !empty($_POST['governate'])) ? $this->request->getPost('governate') : '';
        $formArr['state'] = $state = (isset($_POST['state']) && !empty($_POST['state'])) ? $this->request->getPost('state') : '';
        $formArr['house_no'] = $house_no = (isset($_POST['house_no']) && !empty($_POST['house_no'])) ? $this->request->getPost('house_no') : '';
        $formArr['phone'] = $phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $this->request->getPost('phone') : '';
     
        if(intval($userid) > 0){
       
        $userAddressModel = new userAddressModel();
         $userAddressModel->save($formArr);
        
        $data['id'] = $userAddressModel->getInsertID();
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Save successfully'
                ],
                'userdetail' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
          }
    }
    public function getAddress()
    {
        //$userid = $this->request->getGet('userid');
       $userid = $this->request->getGet('userid');
   
        
         // get user information for check user exist or not
         
         if ($userid) {
             
             //user information
             $userAddressModel = new userAddressModel();
            $Data = $userAddressModel->where('user_id',$userid)->find();

            
            if($Data)
            {
                 
               $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'info list successfully'
                            ],
                           
                        ];
               
               $response['list_address'] = $Data;
                        return $this->respondCreated($response);
                
            }
            else {
            return $this->failNotFound('User Address Not Exist');
            }
         
         }else {
            return $this->failNotFound('User not exist');
        }
   
    }

     public function deleteAddress()
    {
        //$userid = $this->request->getGet('userid');
       $userid = $this->request->getPost('userid');
       $id = $this->request->getPost('add_id');
   
        
         // get user information for check user exist or not
         
         if ($userid AND $id) {
             
             //user information
             $userAddressModel = new userAddressModel();
            $Data = $userAddressModel->where('user_id',$userid)->where('id',$id)->delete();

            
            if($Data)
            {
                 
               $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Address Remove successfully'
                            ],
                           
                        ];
               
             
                        return $this->respondCreated($response);
                
            }
            else {
            return $this->failNotFound('User Address Not Exist');
            }
         
         }else {
            return $this->failNotFound('User not exist');
        }
   
    }


     public function updateaddress()
    {
        //$userid = $this->request->getGet('userid');
       $userid = $this->request->getPost('userid');
       $id = $this->request->getPost('add_id');
       $formArr=array();
       $formArr['name'] = $name = (isset($_POST['name']) && !empty($_POST['name'])) ? $this->request->getPost('name') : '';
        $formArr['governate'] = $governate = (isset($_POST['governate']) && !empty($_POST['governate'])) ? $this->request->getPost('governate') : '';
        $formArr['state'] = $state = (isset($_POST['state']) && !empty($_POST['state'])) ? $this->request->getPost('state') : '';
        $formArr['house_no'] = $house_no = (isset($_POST['house_no']) && !empty($_POST['house_no'])) ? $this->request->getPost('house_no') : '';
        $formArr['phone'] = $phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $this->request->getPost('phone') : '';
   
        
         // get user information for check user exist or not
         
         if ($userid AND $id) {
             
             //user information
             $userAddressModel = new userAddressModel();
            $Data = $userAddressModel->where('user_id',$userid)->where('id',$id)->find();

            
            if($Data)
            {

                $Data = $userAddressModel->set($formArr)->where('user_id',$userid)->where('id',$id)->update();
     
                 
               $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Address Update successfully'
                            ],
                           
                        ];
               
             
                        return $this->respondCreated($response);
                
            }
            else {
            return $this->failNotFound('User Address Not Exist');
            }
         
         }else {
            return $this->failNotFound('User not exist');
        }
   
    }

     public function productPrice()
    {
        //$userid = $this->request->getGet('userid');
       $userid = $this->request->getPost('userid');
       $product_id = $this->request->getPost('product_id');
       $branch_id = $this->request->getPost('branch_id');
       $qty = $this->request->getPost('qty');
       $delivery_charge =(isset($_POST['delivery_charge']) && !empty($_POST['delivery_charge'])) ? $this->request->getPost('delivery_charge') : '0';
       if($userid && $product_id){
       $ProductModel= new ProductModel();
       $CustomerModel= new CustomerModel();
       $CodeModel= new CodeModel();
      $CodeModelData= $CodeModel->where('branch_id',$branch_id)->find();
      $productDate= $ProductModel->where('id',$product_id)->find();
      $Customerdata= $CustomerModel->where('id',$userid)->find();
     $discount=$CodeModelData[0]['customer_discount'];


      $price=$productDate[0]['original_price'];
      $total1=$price*$qty;
      $data=$total1*$productDate[0]['discount_offer'];
      $mobile=$data/100;
      $total2=$total1*$discount/100;
      $total=$total1-$total2;
      $vat=$total*5/100;
      $totalFinal=$vat+$total;
      $totalFinal=$productDate[0]['service_charge']+$totalFinal;
      $totalFinal=$productDate[0]['citycode_vat']+$totalFinal;
      $totalFinal=$delivery_charge+$totalFinal;
      // $totalFinal=$productDate[0]['delivery_charge']+$totalFinal;old code

      $discountOffercitycode=$discount*$qty;


$data=$productDate[0]['original_price']*$qty;

      $product_cost_mobile=$data+$productDate[0]['service_charge']+$productDate[0]['citycode_vat']+$vat;
$dis=$qty*$discount;
      $mobiledeescount1=$product_cost_mobile*$dis/100;
      $mobiledeescount=$product_cost_mobile-$mobile;
      $total_cost_mobile=$mobiledeescount+$delivery_charge;
      // $total_cost_mobile=$mobiledeescount+$productDate[0]['delivery_charge'];old code
      $customer=$total_cost_mobile*10;

  $afdiscount=$total+$delivery_charge;
  // $afdiscount=$total+$productDate[0]['delivery_charge'];oldc ode
  $afvat=$afdiscount*5/100;
       // print_r($productDate[0]['product_discount_mobile']);exit;

  $totalFinal=$afdiscount+$afvat;
     
      $userdata=array(
        'actual_price'=>number_format($total1, 3, '.', ''),

        'quantity'=>$qty,

        'product_id'=>$productDate[0]['id'],

        'company_id'=>$productDate[0]['company_id'],

        'branch_id'=>$branch_id,

        'discount'=>number_format($discount, 3, '.', ''),

        'discount_offer_citycode'=>number_format($discountOffercitycode, 3, '.', ''),

        'after_discount'=>number_format($total, 3, '.', ''),

        'supliervat_charges'=>number_format($vat, 3, '.', ''),

        'appService_charge'=>number_format($productDate[0]['service_charge'], 3, '.', ''),

        'cityCodeVat_Charge'=>number_format($productDate[0]['citycode_vat'], 3, '.', ''),

        'delivery_charge'=>number_format($delivery_charge, 3, '.', ''),

        'Total'=>number_format($totalFinal, 3, '.', ''),
        // 'Total'=>number_format($totalFinal, 3, '.', ''), old code

        'product_cost_mobile'=>number_format($product_cost_mobile, 3, '.', ''),

        'product_discount_mobile'=>number_format($mobiledeescount, 3, '.', ''),

        'total_cost_mobile'=>number_format($total_cost_mobile, 3, '.', ''),

        'total_cost_mobile_without_deilvery_charges'=>number_format($mobiledeescount, 3, '.', ''),

        'afterdiscount_plus_delivery_charge'=>number_format($afdiscount, 3, '.', ''),

        'afterdiscount_plus_delivery_charge_vat'=>number_format($afvat, 3, '.', ''),

        'total_point'=>$Customerdata[0]['totalpoint'],

        'point'=>number_format($customer, 1, '.', ''),

    );
    
      $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'list successfully'
                            ],
                           
                        ];
               
               $response['list_data'] = $userdata;
                        return $this->respondCreated($response);



       }else {
            return $this->failNotFound('User not exist');
        }

    }

    public function orderSave(){
        $formArr = array();
        //$userid = $this->request->getGet('userid');
        $formArr['user_id']=$userid = $this->request->getPost('userid');

         $formArr['company_id'] = $company_id = (isset($_POST['company_id']) && !empty($_POST['company_id'])) ? $this->request->getPost('company_id') : '';
         $formArr['branch_id'] = $branch_id = (isset($_POST['branch_id']) && !empty($_POST['branch_id'])) ? $this->request->getPost('branch_id') : '';

         $formArr['product_id'] = $product_id = (isset($_POST['product_id']) && !empty($_POST['product_id'])) ? $this->request->getPost('product_id') : '';

         $formArr['qty'] = $qty = (isset($_POST['qty']) && !empty($_POST['qty'])) ? $this->request->getPost('qty') : '';

        $formArr['actual_price'] = $actual_price = (isset($_POST['actual_price']) && !empty($_POST['actual_price'])) ? $this->request->getPost('actual_price') : '';
        
        
        $formArr['afterdiscount_price'] = $after_discount = (isset($_POST['after_discount']) && !empty($_POST['after_discount'])) ? $this->request->getPost('after_discount') : '';

        $formArr['discount_percent'] = $discount = (isset($_POST['discount']) && !empty($_POST['discount'])) ? $this->request->getPost('discount') : '';

          $formArr['total_amount'] = $total_amount = (isset($_POST['total_amount']) && !empty($_POST['total_amount'])) ? $this->request->getPost('total_amount') : '';

          $formArr['suppliervat_charges'] = $suppliervat_charges = (isset($_POST['suppliervat_charges']) && !empty($_POST['suppliervat_charges'])) ? $this->request->getPost('suppliervat_charges') : '';
          

           $formArr['appService_charge'] = $appService_charge = (isset($_POST['appService_charge']) && !empty($_POST['appService_charge'])) ? $this->request->getPost('appService_charge') : '';

           $formArr['cityCodeVat_Charge'] = $cityCodeVat_Charge = (isset($_POST['cityCodeVat_Charge']) && !empty($_POST['cityCodeVat_Charge'])) ? $this->request->getPost('cityCodeVat_Charge') : '';

            $formArr['delivery_charge'] = $delivery_charge = (isset($_POST['delivery_charge']) && !empty($_POST['delivery_charge'])) ? $this->request->getPost('delivery_charge') : '';

           $formArr['product_cost_mobile'] = $product_cost_mobile = (isset($_POST['product_cost_mobile']) && !empty($_POST['product_cost_mobile'])) ? $this->request->getPost('product_cost_mobile') : '';
           $formArr['product_discount_mobile'] = $product_discount_mobile = (isset($_POST['product_discount_mobile']) && !empty($_POST['product_discount_mobile'])) ? $this->request->getPost('product_discount_mobile') : '';

             $formArr['total_cost_mobile'] = $total_cost_mobile = (isset($_POST['total_cost_mobile']) && !empty($_POST['total_cost_mobile'])) ? $this->request->getPost('total_cost_mobile') : '';

             $formArr['total_cost_mobile_without_deilvery_charges'] = $total_cost_mobile_without_deilvery_charges = (isset($_POST['total_cost_mobile_without_deilvery_charges']) && !empty($_POST['total_cost_mobile_without_deilvery_charges'])) ? $this->request->getPost('total_cost_mobile_without_deilvery_charges') : '';

             $formArr['point'] = $point = (isset($_POST['point']) && !empty($_POST['point'])) ? $this->request->getPost('point') : '';
              $formArr['discount_offer_citycode'] = $discount_offer_citycode = (isset($_POST['discount_offer_citycode']) && !empty($_POST['discount_offer_citycode'])) ? $this->request->getPost('discount_offer_citycode') : '';

           $formArr['payment_status'] = $status = (isset($_POST['status']) && !empty($_POST['status'])) ? $this->request->getPost('status') : '';
           $formArr['transaction_id'] = $transaction_id = (isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])) ? $this->request->getPost('transaction_id') : '';
   
        if(intval($userid) > 0){
       
        $OnlineShoppingModel = new OnlineShoppingModel();
         $OnlineShoppingModel->save($formArr);
        
        $data['order_id'] = $OnlineShoppingModel->getInsertID();
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Order Save successfully'
                ],
                'userdetail' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }
    public function cartSave(){
        $formArr = array();
        //$userid = $this->request->getGet('userid');
        $formArr['user_id']=$userid = $this->request->getPost('userid');
        $formArr['company_id'] = $companyid = (isset($_POST['companyid']) && !empty($_POST['companyid'])) ? $this->request->getPost('companyid') : '';
        $formArr['branch_id'] = $branch_id = (isset($_POST['branchid']) && !empty($_POST['branchid'])) ? $this->request->getPost('branchid') : '';
        $formArr['product_id'] = $product_id = (isset($_POST['productid']) && !empty($_POST['productid'])) ? $this->request->getPost('productid') : '';
        $formArr['qty'] = $quantity = (isset($_POST['quantity']) && !empty($_POST['quantity'])) ? $this->request->getPost('quantity') : '';

     $ProductModel= new ProductModel();
       $CustomerModel= new CustomerModel();
       $CodeModel= new CodeModel();
      $CodeModelData= $CodeModel->where('branch_id',$branch_id)->find();
      $productDate= $ProductModel->where('id',$product_id)->find();
      $Customerdata= $CustomerModel->where('id',$userid)->find();
     $discount=$CodeModelData[0]['customer_discount'];


      $price=$productDate[0]['original_price'];
      $total1=$price*$quantity;

      $data=$total1*$productDate[0]['discount_offer'];

      $mobile=$data/100;
      $total2=$total1*$discount/100;
      $total=$total1-$total2;
      $vat=$total*5/100;
      $totalFinal=$vat+$total;
      $totalFinal=$productDate[0]['service_charge']+$totalFinal;
      $totalFinal=$productDate[0]['citycode_vat']+$totalFinal;
      $totalFinal=$productDate[0]['delivery_charge']+$totalFinal;
      $data=$productDate[0]['original_price']*$quantity;
      $product_cost_mobile=$data+$productDate[0]['service_charge']+$productDate[0]['citycode_vat']+$vat;
    $dis=$qty*$discount;
      $mobiledeescount1=$product_cost_mobile*$dis/100;
      $mobiledeescount=$product_cost_mobile-$mobile;
      $total_cost_mobile=$mobiledeescount+$productDate[0]['delivery_charge'];
      $customer=$total_cost_mobile*10;
$formArr['product_cost_mobile']=$product_cost_mobile;
$formArr['product_discount_mobile']=$mobiledeescount;
$formArr['delivery_charge']=$productDate[0]['delivery_charge'];
     
      
   
        if(intval($userid) > 0){

       
        $CartListModel = new CartListModel();
         $CartListModel->save($formArr);
        
        // $data['order_id'] = $OnlineShoppingModel->getInsertID();
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                // 'userdetail' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }
    public function cartList(){

       $userid = $this->request->getGet('userid');
       $company_id = $this->request->getGet('companyid');
        if(intval($userid) > 0){

      if ($userid) {
            $searchArray['user_id'] = $userid;

        }
        if ($company_id) {
            $searchArray['company_id'] = $company_id;

        }
        $CartListModel = new CartListModel();
         $data=$CartListModel->getDataApi($searchArray);
         // print_r($data);exit;
        
        // $data['order_id'] = $OnlineShoppingModel->getInsertID();
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                'image_base_url' => base_url('product')."/",
                'company_image_base_url' => base_url('company')."/",
                 'cart_list' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }

    public function companyCartList(){

       $userid = $this->request->getGet('userid');

       
        if(intval($userid) > 0){

      if ($userid) {
            $searchArray['txtsearch'] = $userid;

        }
       
        $CartListModel = new CartListModel();
         $data=$CartListModel->getDataApiCompany($searchArray);
         // print_r($data);exit;
        
        // $data['order_id'] = $OnlineShoppingModel->getInsertID();
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
               
                'company_image_base_url' => base_url('company')."/",
                 'company_cart_list' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }
    public function cartRemove(){

          $userid = $this->request->getPost('userid');
           $cart_id = $this->request->getPost('cart_id');
        if($userid && $cart_id){


        $CartListModel = new CartListModel();
         $data=$CartListModel->where('user_id',$userid)->where('cart_id',$cart_id)->find();
         if($data){


         $CartListModel->where('user_id',$userid)->where('cart_id',$cart_id)->delete();

       
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Remove successfully'
                ], 
            ];
            return $this->respondCreated($response);
              }else{
            return $this->failNotFound('This User Id Product Not Exist.');
            }

            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }
    public function getListSummary(){

         
       $userid = $this->request->getGet('userid');
       $company_id = $this->request->getGet('companyid');
        if(intval($userid) > 0){

      
        $CartListModel = new CartListModel();
         $data=$CartListModel->where('user_id',$userid)->Where('company_id',$company_id)->find();
         $qty=0;
         $product_cost_mobile=0;
         $product_discount_mobile=0;
         $delivery_charge=0;
         foreach($data as $value){
                 $qty+=$value['qty'];
                 $product_cost_mobile+=$value['product_cost_mobile'];
                 $product_discount_mobile+=$value['product_discount_mobile'];
                 $delivery_charge+=$value['delivery_charge'];
         }
        
         $totalPrice=$delivery_charge+$product_discount_mobile;
       $point=$totalPrice*10;
         $data=array('qty'=>"$qty",
         'product_cost_mobile'=>number_format($product_cost_mobile, 3, '.', ''),
        'product_discount_mobile'=>number_format($product_discount_mobile, 3, '.', ''),
        'delivery_charge'=>number_format($delivery_charge, 3, '.', ''),
        'totalPrice'=>number_format($totalPrice, 3, '.', ''),
        'point'=>number_format($point, 1, '.', ''),
    );



          
        
        // $data['order_id'] = $OnlineShoppingModel->getInsertID();
        $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
             
                 'cart_summary' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
            }
    }

    // public function orderGet(){
    //     $formArr = array();
    //     //$userid = $this->request->getGet('userid');
    //     $formArr['user_id']=$userid = $this->request->getPost('userid');
    //     $formArr['actual_price'] = $actual_price = (isset($_POST['actual_price']) && !empty($_POST['actual_price'])) ? $this->request->getPost('actual_price') : '';
    //     $formArr['product_id'] = $product_id = (isset($_POST['product_id']) && !empty($_POST['product_id'])) ? $this->request->getPost('product_id') : '';
    //     $formArr['qty'] = $qty = (isset($_POST['qty']) && !empty($_POST['qty'])) ? $this->request->getPost('qty') : '';
    //     $formArr['afterdiscount_price'] = $afterdiscount_price = (isset($_POST['afterdiscount_price']) && !empty($_POST['afterdiscount_price'])) ? $this->request->getPost('afterdiscount_price') : '';
    //     $formArr['discount_percent'] = $discount = (isset($_POST['discount']) && !empty($_POST['discount'])) ? $this->request->getPost('discount') : '';
    //       $formArr['total_amount'] = $total_amount = (isset($_POST['total_amount']) && !empty($_POST['total_amount'])) ? $this->request->getPost('total_amount') : '';
   
    //     if(intval($userid) > 0){
       
    //     $OnlineShoppingModel = new OnlineShoppingModel();
    //      $OnlineShoppingModel->save($formArr);
        
    //     $data['order_id'] = $OnlineShoppingModel->getInsertID();
    //     $response = [
    //             'status' => 201,
    //             'error' => null,
    //             'messages' => [
    //                 'success' => 'Order Save successfully'
    //             ],
    //             'userdetail' => $data,
    //         ];
    //         return $this->respondCreated($response);
    //         }else{
    //         return $this->failNotFound('User Id Not Found.');
    //         }
    // }
      public function EditQuantity(){
        $formArr = array();
        //$userid = $this->request->getGet('userid');
        $cart_id = $this->request->getPost('cartid');
        $qty = $this->request->getPost('Quantity');

        if ($cart_id) {
            $CartListModel = new CartListModel();
         $listData=$CartListModel->where('cart_id',$cart_id)->first();
         $company_id=$listData['company_id'];
         $branch_id=$listData['branch_id'];
         $product_id=$listData['product_id'];
         $userid=$listData['user_id'];
      

     $ProductModel= new ProductModel();
       $CustomerModel= new CustomerModel();
       $CodeModel= new CodeModel();
      $CodeModelData= $CodeModel->where('branch_id',$branch_id)->find();
      $productDate= $ProductModel->where('id',$product_id)->find();

      $Customerdata= $CustomerModel->where('id',$userid)->find();
     $discount=$CodeModelData[0]['customer_discount'];


      $price=$productDate[0]['original_price'];

      $total1=$price*$qty;
      $data=$total1*$productDate[0]['discount_offer'];
      $mobile=$data/100;
      $total2=$total1*$discount/100;
      $total=$total1-$total2;
      $vat=$total*5/100;
      $totalFinal=$vat+$total;
      $totalFinal=$productDate[0]['service_charge']+$totalFinal;
      $totalFinal=$productDate[0]['citycode_vat']+$totalFinal;
      $totalFinal=$productDate[0]['delivery_charge']+$totalFinal;

      $discountOffercitycode=$discount*$qty;


$data=$productDate[0]['original_price']*$qty;

      $product_cost_mobile=$data+$productDate[0]['service_charge']+$productDate[0]['citycode_vat']+$vat;
$dis=$qty*$discount;
      $mobiledeescount1=$product_cost_mobile*$dis/100;
      $mobiledeescount=$product_cost_mobile-$mobile;
      $total_cost_mobile=$mobiledeescount+$productDate[0]['delivery_charge'];
      $customer=$total_cost_mobile*10;


       // print_r($productDate[0]['product_discount_mobile']);exit;

      $userdata=array(
       
        'product_cost_mobile'=>number_format($product_cost_mobile, 3, '.', ''),
        'product_discount_mobile'=>number_format($mobiledeescount, 3, '.', ''),
        'qty'=>$qty,
        

    );
       

     $listData=$CartListModel->set($userdata)->where('cart_id',$cart_id)->update();
      
    $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'list successfully'
                            ],
                           
                        ];
               
               $response['qty_data'] = $userdata;
                        return $this->respondCreated($response);
  

       }else {
            return $this->failNotFound('Cart id not exist');
        }

    }

     public function couponList(){
   
       
    $company_id = (isset($_POST['companyid']) && !empty($_POST['companyid'])) ? $this->request->getPost('companyid') : '';
    $coupon_id = (isset($_POST['coupon_id']) && !empty($_POST['coupon_id'])) ? $this->request->getPost('coupon_id') : '';
   
     
        if($company_id){
            if($company_id){
                $searchArray['company_id']=$company_id;
            }
          
          
       
        $CouponModel = new CouponModel();
        
         $data=$CouponModel->getDataApilistcoupon($searchArray);
         // $qty=$data[0]->coupon_quantity;
         // echo"<pre>";
         //   print_r($data);exit;
        if (empty($data)) {
             return $this->failNotFound('company coupon qty not available.');
        }
        
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'list successfully'
                ],
                'company_image_base_url' => base_url('company')."/",
                'coupon_list' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('company Id Not Found.');
          }
    }

     public function couponListbycouponID(){
   
       
  
    $coupon_id = (isset($_POST['coupon_id']) && !empty($_POST['coupon_id'])) ? $this->request->getPost('coupon_id') : '';
   
     
        if($coupon_id){
            if($coupon_id){
                $searchArray['coupon_id']=$coupon_id;
            }
          
          
       
        $CouponModel = new CouponModel();
        
         $data=$CouponModel->getData($searchArray);
         // $qty=$data[0]->coupon_quantity;
         // echo"<pre>";
         //   print_r($data);exit;
        if (empty($data)) {
             return $this->failNotFound('company coupon qty not available.');
        }
        
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'list successfully'
                ],
                'company_image_base_url' => base_url('company')."/",
                'company_coupon_list' => $data,
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('coupon id Id Not Found.');
          }
    }
       public function couponPurchase(){
        
   $data=array();
   $couponPurchaseModel = new couponPurchaseModel();
    $CouponModel = new CouponModel();
       
    $data['coupon_id'] = $couponid=(isset($_POST['couponid']) && !empty($_POST['couponid'])) ? $this->request->getPost('couponid') : '';
    $data['user_id'] = $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
   
     
        if($couponid And $userid ){
            $previecoupon=$CouponModel->where('id',$couponid)->first();
            $co=$previecoupon['company_id'];
            $bra=$previecoupon['branch_id'];
            $autounique=$previecoupon['autounique'];

            



          $checklist=$couponPurchaseModel->where('user_id',$userid)->where('company_id',$co)->where('branch_id',$bra)->where('purchase_status','Active')->where('checkautounique',$autounique)->first();
        
         if($checklist){

 return $this->failNotFound('You have already Coupon.');

         }

      $CouponModel = new CouponModel();
        $data1=$CouponModel->where('id',$couponid)->first();
       $data['company_id']= $company_id=$data1['company_id'];
        $data['branch_id']=$branch_id=$data1['branch_id'];
        $data['checkautounique']=$branch_id=$data1['autounique'];

            $cheqty=$CouponModel->where('id',$couponid)->where('coupon_quantity','1')->first();
            if ($cheqty) {
              $check= $couponPurchaseModel->insert($data);
            }else{
              return $this->failNotFound('Coupon Not available.');  
            }

        
       // $check= $couponPurchaseModel->insert($data);
       if($check){
        $CouponModel = new CouponModel();

        $data1=$CouponModel->where('id',$couponid)->first();
        $qty=$data1['coupon_quantity'];
        if (intval($qty)>0) {
            $qty=$qty-1;
            $data['coupon_quantity']=$qty;
            $CouponModel->set($data)->where('id',$couponid)->update();
        }
       }
        
         // $qty=$data[0]->coupon_quantity;
         // print_r($qty);exit;
        
        
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                
              
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('coupon Id Not Found.');
          }
    }

     public function userCouponList(){
   
        
   $data=array();
   $couponPurchaseModel = new couponPurchaseModel();
       
    
    $data['user_id'] = $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
   
     
        if($userid ){

             $searchArray['user_id']=$userid;
          $checklist=$couponPurchaseModel->getDataApi($searchArray);
          $end_date=$checklist[0]->end_date;
          $coupon_id=$checklist[0]->id;

          $current_date=date('Y-m-d');
         if($current_date>$end_date){
         
             $couponPurchaseModel = new couponPurchaseModel();
            $data1['purchase_status']='Expire';
            $couponPurchaseModel->set($data1)->where('coupon_id',$coupon_id)->update();
         }
        

        
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                 'company_image_base_url' => base_url('company')."/",
                'userCouponList' => $checklist,
                 
                
              
            ];
            return $this->respondCreated($response);
            }else{
            return $this->failNotFound('User Id Not Found.');
          }
    }
        public function redeemcoupon(){
   
        
   $data=array();
   $couponPurchaseModel = new couponPurchaseModel();
       
    
    $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
     $couponid=(isset($_POST['couponid']) && !empty($_POST['couponid'])) ? $this->request->getPost('couponid') : '';
   
     
        if($userid AND $couponid){

          
           $data1=$couponPurchaseModel->where('coupon_id',$couponid)->where('user_id',$userid)->where('purchase_status','Active')->first();
           if($data1){

            // $couponPurchaseModel->set($arr)->where('coupon_id',$couponid)->update();


        $arr['purchase_status']='Used';
       
        $couponPurchaseModel->set($arr)->where('coupon_id',$couponid)->update();
           
        
          $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                
            
                 
                
              
            ];
            return $this->respondCreated($response);
             }else{
                $arr['purchase_status']='Used';

            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'successfully'
                ],
                
                'coupon_status' => $arr['purchase_status'],
            ];
              return $this->respondCreated($response);
          }
            }else{
            return $this->failNotFound('User Id Not Found.');
          }
    }

       function checkout() {
        // $data=array();
   $data=['Customer name'=> "Abdul",'Contact Number'=> "8976900627",'Email'=> "abdulkhan@gmail.com",'Address'=> "space 912 mira road"];


     $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                    
                    'metadata' => $data,
                    
                ];
                return $this->respondCreated($response);
            }

              function userCoupon() {
        
   $userid=(isset($_GET['userid']) && !empty($_GET['userid'])) ? $this->request->getGet('userid') : '';
   $companyid=(isset($_GET['companyid']) && !empty($_GET['companyid'])) ? $this->request->getGet('companyid') : '';

   if ($userid || $companyid) {
    $couponPurchaseModel = new couponPurchaseModel();

    if ($companyid) {
        $checkcopmpany=$couponPurchaseModel->where('company_id',$companyid)->find();

       
    }else{

      $checkuser=$couponPurchaseModel->where('user_id',$userid)->find();
    }
      if ($checkcopmpany || $checkuser) {

        if ($checkcopmpany) {
              $searchArray['companyid']=$companyid;
        }
          if ($checkuser) {
              $searchArray['userid']=$userid;       
               }
          
        
      
         
        $userreport=$couponPurchaseModel->usergetDataReport($searchArray);

      $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'successfully'
                    ],
                    
                    'userCouponReport' => $userreport,
                    
                ];
                return $this->respondCreated($response);


        
      }else{
            return $this->failNotFound('Not Found.');
          }
      
   }else{
            return $this->failNotFound('Not Found.');
          }



            }


    public function gettransactioncompany()
    {

       $company_id=(isset($_POST['companyid']) && !empty($_POST['companyid'])) ? $this->request->getPost('companyid') : '';
        $branch_id=(isset($_POST['branchid']) && !empty($_POST['branchid'])) ? $this->request->getPost('branchid') : ''; 

       if ($company_id && $branch_id) {
        
            $searchArray['company_id'] = $company_id;
            $searchArray['branch_id'] = $branch_id;

            $data=$this->order->getData($searchArray);
            if ($data) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'list successfully'
                    ],
                    'company_transaction' => $data
                ];
                return $this->respondCreated($response);
            }
       
        }else{
            return $this->failNotFound('Please provide companyid and branchid..');
          }
    }


    public function latlong()
    {

        $CustomerModel = new CustomerModel();
        $BranchModel = new  BranchModel();
        $NearNotification= new NearNotification();
         $user_id= $this->request->getPost('userid');
         $centerLat= $this->request->getPost('lat1');
         $centerLng=$this->request->getPost('lon1');


       

$companyCoords=$BranchModel->select('latitude,longitude,branch_name')->where("latitude!=''")->where("longitude!=''")->sendmessage();


        foreach ($companyCoords as $coord) 
        {
          $distance = $this->haversineDistance($centerLat, $centerLng, $coord['latitude'], $coord['longitude']);
          // print_r($distance);exit;


                  if ($distance <= 0.3) {
                     $objCusDetail = $CustomerModel->where('id',$user_id)->find();

                    // echo   $coord['branch_name'] ." is within 1 km <br>";

                     $i= 1;
                    foreach($objCusDetail as $info){    
                        // print_r($info);die;
                      
                                  
                   
                        $arrMessage = [ 
                            "title"=>" " . $coord['company_name'] . "(" . $coord['branch_name'] . ") is Near by You", 
                            // "body"=>"Branch name is '" . $coord['branch_name'] . "'",
                           
                        ];

                         $arr=array();
                            $arr['branch_id']=$coord['branch_id'];
                            $arr['company_id']=$coord['company_id'];
                            $arr['user_id']=$user_id;
                            $arr['notify_status']='1';

                        $cheknoti=$NearNotification->where('user_id',$user_id)->where('company_id',$arr['company_id'])->where('branch_id',$arr['branch_id'])->where('notify_status','1')->find();
                        if (!$cheknoti) {
                            // code...
                       
                         $android_token = $info['android_token'];
                        
                        $push = new Pushnotification();                  
                        $push->sendAndroidNotification($android_token,$arrMessage); 
                           

                        


                        $NearNotification->save($arr);
                         $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Notification send succesfully'
                            ],  
                           
                           "fcm_token"=>$android_token,
                            "data"=>$arrMessage,
                            "company_id"=>$coord['company_id'],
                            "branch_id"=>$coord['branch_id'],
                        ];
                         return $this->respond($response);  

                    }
                }




                  } else {

                 
                  }
        }
    }
    function haversineDistance($lat1, $lng1, $lat2, $lng2) 
       {

          $earthRadius = 6371; // in km

          $dLat = deg2rad($lat2 - $lat1);
          $dLng = deg2rad($lng2 - $lng1);


          $a = sin($dLat / 2) * sin($dLat / 2) +
               cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
               sin($dLng / 2) * sin($dLng / 2);
          $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
          $distance = $earthRadius * $c;


          return $distance;
        }


        public function versionControl(){
            
            
            $VersionControlModel= new VersionControlModel();
           

            $data=$VersionControlModel->orderBy('id','desc')->first();
           
                 $response = [
                            'status' => 200,
                            'error' => null,
                            'messages' => [
                                'success' => 'latest Version'
                            ],  
                           
                           "latest_version"=>$data['version_no'],
                           
                        ];
                         return $this->respond($response); 


           
        }

        public function myOrders(){
            $user_id=$this->request->getGet('userid');
         
             $OnlineShoppingModel = new OnlineShoppingModel();

               if($user_id)
            {
                $searchArray['user_id'] = $user_id;
                 $data = $OnlineShoppingModel->myOrder($searchArray);
                 if ($data) {
                    
                
                 $response = [
                            'status' => 200,
                            'error' => null,
                            'messages' => [
                                'success' => 'My Order list successfully..'
                            ], 
                            'product_image_base_url' => base_url('product')."/",
                            'company_image_base_url' => base_url('company')."/",
                           'myOrder'=>$data,
                           
                        ];
                         return $this->respond($response); 
                     }else{
                        return $this->failNotFound('User Not Found..');
                     }
            }
            else{
                return $this->failNotFound('User Not Found..');

            }
        }
        public function appversion(){
            $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
        $version_no=(isset($_POST['version_no']) && !empty($_POST['version_no'])) ? $this->request->getPost('version_no') : ''; 
               $CustomerModel = new CustomerModel();
               if ($userid AND $version_no) {
                  $arr=['current_version'=>$version_no];
                  $check=$CustomerModel->set($arr)->where('id',$userid)->update();
                  if ($check) {
                         $response = [
                            'status' => 200,
                            'error' => null,
                            'messages' => [
                                'success' => 'Version Update successfully..'
                            ], 
                           
                           
                        ];
                         return $this->respond($response); 
                  }
              }else{
                        return $this->failNotFound('User Not Found..');
                     }

        }

        // public function appstatus(){
        //     $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
        //     $CustomerModel = new CustomerModel();
        //        if ($userid) {
        //           $arr=['current_version'=>$version_no];
        //           $check=$CustomerModel->set($arr)->where('id',$userid)->update();
        //           if ($check) {
        //                  $response = [
        //                     'status' => 200,
        //                     'error' => null,
        //                     'messages' => [
        //                         'success' => 'Version Update successfully..'
        //                     ], 
                           
                           
        //                 ];
        //                  return $this->respond($response); 
        //           }
        //       }else{
        //                 return $this->failNotFound('User Not Found..');
        //              }
        // }




          public function usernotificationread(){
            $userid=(isset($_POST['userid']) && !empty($_POST['userid'])) ? $this->request->getPost('userid') : '';
        $notification_id=(isset($_POST['notification_id']) && !empty($_POST['notification_id'])) ? $this->request->getPost('notification_id') : ''; 
               
               $NotificationViewModel = new NotificationViewModel();
               $NotificationModel = new NotificationModel();
               $CustomerModel = new CustomerModel();
               $findnotification=$NotificationModel->where('id',$notification_id)->find();
               $userfindnotification=$CustomerModel->where('id',$userid)->find();
               if (!$findnotification) {
                 return $this->failNotFound('Notification Not Found..');
               }
                if (!$userfindnotification) {
                 return $this->failNotFound('Customer Not Found..');
               }
               if ($userid AND $notification_id) {
                $checkuser=$NotificationViewModel->where('user_id',$userid)->where('notification_id',$notification_id)->find();
                if ($checkuser) {
                      $response = [
                             'status' => 200,
                             'error' => null,
                             'messages' => [
                                 'success' => 'User already Read this Notification..'
                             ], 
                           
                           
                         ];
                          return $this->respond($response); 
                   
                }else{
                    $data=['user_id'=>$userid,'notification_id'=>$notification_id];
                    $check=$NotificationViewModel->save($data);
                      if ($check) {
                         $response = [
                            'status' => 200,
                            'error' => null,
                            'messages' => [
                                'success' => 'Notification Read successfully..'
                            ], 
                           
                           
                        ];
                         return $this->respond($response); 
                  }



                }

                
                



              }else{
                        return $this->failNotFound('User Not Found..');
                     }

        }



}

