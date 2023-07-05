<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\VipCustomerModel;
use App\Models\OrdersModel;
use App\Libraries\EmailSms;

class ApiUsers extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new CustomerModel();
    }

    //get all category
    public function index() {
        $array = array();

        return $this->failNotFound('Invalid access found');
    }

    public function Login() {
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');

        if ($mobile && $password) {
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

        //return $this->failNotFound('Opps! some error occurs.' . print_r($this->request->getPost(), 1));
        
        $newuserdata = (array_filter($userdata));

        $profileImage = "";


        if ($userdata['mobile'] && $userdata['name']) {
            $isuserexist = $this->model->where('mobile', $newuserdata['mobile'])->first();

            if (empty($isuserexist)) {
                $citycode = $this->model->generatecode();

                $userdata['city_code'] = $citycode;
                $userdata['profile'] = $profileImage;
                $userdata['customer_type'] = "customer";

                $query = $this->model->save($userdata);

                if ($query) {
                    $userid = $this->model->getInsertID();
                    $userdata['id'] = $userid;
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Account created successfully'
                        ],
                        'userdetail' => $userdata,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Opps! some error occurs.' . print_r($data, 1));
                }
            } else {
                return $this->failNotFound('Mobile number alreay exist.');
            }
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }

    // single user
    public function show($id = null) {

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
            $response['userdetail'] = $data;
            $response['userInterest'] = $userInterest;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
    
     // single user
    public function showvip() {

        $vip_code = $this->request->getGet('vip_code');
        
        $data = array();
        $vipOffers = array();

        if ($vip_code) {
            
            $searchArray = array('vip_code'=>$vip_code);
            $data = $this->model->getData($searchArray);
            //get all offers of cutomers
            if($data)
            {
                $arrVipSearch = array('customer_id'=>$data[0]->id,"coupon_type"=>"vip");
               $vipCustomerModel = new VipCustomerModel();
               $vipOffers = $vipCustomerModel->getVipOffers($arrVipSearch);
            }
          //  print_r($vipOffers);die;
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

        
        $profileImage = "";

         if (!empty($_FILES['profileimage']['name'])) {

                $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
               $file_type  = $_FILES['profileimage']['type'];
              $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['profileimage']['name'];
                $profile = $userFolderpath.$newfilename;
                 
                if (move_uploaded_file($_FILES['profileimage']['tmp_name'], $profile)) {
                    $profileImage = $newfilename;
                }
            }
        }


        if ($userid && $profileImage) {
            
                $userdata['profile'] = $profileImage;

                $Update = $this->model->where('id', $userid)->set($userdata)->update();

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
            
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }

    
    public function getotp() {
        $mobileno = $this->request->getGet('mobileno');
        $language = $this->request->getGet('language');

        if ($mobileno) {
            $data = $this->model->where('mobile', $mobileno)->first();

            if ($data) {
                helper('text');
                $otpno =  random_string('nozero', 4);

                $userid = $data['id'];
                $userdata = array("password" => password_hash($otpno,1));
                
                $usermodel = new CustomerModel();
                $Update = $usermodel->where('id', $userid)->set($userdata)->update();

                if ($Update) {
                    
                    $mobileno = "968".$mobileno;
                    $smsemail = new EmailSms();
                    $smsemail->send_sms($mobileno,"Your OTP for Citycode: ".$otpno,$language);
       
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
    
    
    public function getCitycode() {

        $city_code = $this->request->getGet('city_code');
        
        $data = array();
        
        if ($city_code) {
            
            $searchArray = array('city_code'=>$city_code);
            $data = $this->model->getData($searchArray);
            
          //  print_r($vipOffers);die;
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('users')."/",
            ];
            } else {
            
            $response = [
                'status' => 404,
                'error' => null,
                'messages' => [
                    'success' => 'Please provide valid city Code'
                ],
                'image_base_url' => base_url('users')."/",
                'company_base_url' => base_url('company')."/",
            ];
            
           
        }
            
            $response['userdetail'] = $data;
           

            return $this->respond($response);
        
    }
    
    public function addpoints() {

        $userid         = $this->request->getPost('userid');
        $companyid      = $this->request->getPost('companyid');
        $branchid       = $this->request->getPost('branchid');
        $ordernumber    = $this->request->getPost('ordernumber');
        $totalamount    = $this->request->getPost('totalamount');
        $paidamount     = $this->request->getPost('paidamount');
        $discount       = $this->request->getPost('discount');
        
        $data = array();
        
        if ($userid && $companyid && $paidamount && $discount) {
            
            $points = $paidamount * PER_OMR_POINT;
            $arrOrder = [
                "od_userid"=>$userid,
                "od_companyid"=>$companyid,
                "od_branchid"=>$branchid,
                "od_number"=>$ordernumber,
                "od_totalamount"=>$totalamount,
                "od_saveamount"=>$companyid,
                "od_paidamount"=>$paidamount,
                "od_point"=>$points,
            ];
            
            $objOrder = new OrdersModel();
            $objOrder->save($arrOrder);
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
    
    public function test()
    {
       $smsemail = new EmailSms();
       $response = $smsemail->send_sms('96893292282',"Your code is 234");
       
       print_r($response);
    }

}
