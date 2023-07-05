<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdminModel;
use App\Models\MedicineModel;
use App\Models\DelBoyModel;
use App\Models\OrdersModel;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\MallDetailsModel;
use App\Models\VipModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\AdvertisementModel;
use App\Models\ContactUsModel;
use App\Models\CompanyEnquiryModel;
use App\Models\CompanyDocFile;
use App\Models\NotificationModel;
use App\Models\EmployeeModel;
use App\Models\MenuModel;
use App\Libraries\EmailSms;
use CodeIgniter\Session\Session;

class Admin extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {

        $this->session = session();
        //echo "<pre>"; print_r($session);die;
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    public function index() {
        
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if ($isAdminLoggedIn) {
            //echo "<pre>"; print_r($session->get('isAdminLoggedIn'));die;
            return redirect()->to(site_url('dashboard'));
        }

        $errorMsg = "";
        $method = $this->request->getMethod();

        $adminModel = new AdminModel();
        if ($method == 'post') {
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            if ($username != '' && $password != '') {
                $return = $adminModel->checkAdminLogin($username, $password);
                if ($return) {
                    return redirect()->to(site_url('dashboard'));
                } else {
                    $session->setFlashdata('errmessage', 'Invalid Email / Password');
                }
            } else {
                $session->setFlashdata('errmessage', 'Invalid Email / Password');
            }
        }

        $companyModel = new CompanyModel();
        if ($method == 'post') {
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            $otp = $this->request->getPost("otp");
            $language = '';
            if ($username != '' && $password != '') {
                $return = $companyModel->checkCompanyLogin($username, $password);
                if ($return != '') {
                    $oldptp = $return->cookiesotp;
                    if (password_verify($otp, $oldptp)) {
                        $cookie_name = "otpno";
                        setcookie($cookie_name, $otp, time() + (86400 * 30 * 12), "/");
                        return redirect()->to(site_url('dashboard'));
                    } else {
                        if (isset($_COOKIE['otpno'])) {
                            unset($_COOKIE['otpno']);
                            setcookie('otpno', null, -1, '/');
                        }
                        $session = session();
                        $session->destroy();
                        $session->setFlashdata('errmessage', 'Please Enter valid Otp');
                        return redirect()->to(site_url('admin'));
                    }
                } else {
                    $session->setFlashdata('errmessage', 'Invalid Email / Password');
                    return redirect()->to(site_url('admin'));
                }
            } else {
                $session->setFlashdata('errmessage', 'Invalid Email / Password');
                return redirect()->to(site_url('admin'));
            }
        }

        //////////////////////////// employee login ////////////////////////

        $employeeModel = new EmployeeModel();
        if ($method == 'post') {
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            if ($username != '' && $password != '') {
                $return = $employeeModel->checkEmployeeLogin($username, $password);
                if ($return) {
                    return redirect()->to(site_url('dashboard'));
                } else {
                    $session->setFlashdata('errmessage', 'Invalid Email / Password');
                }
            } else {
                $session->setFlashdata('errmessage', 'Invalid Email / Password');
            }
        }

        $this->template->render('admintemplate', 'contents', 'admin/loginTpl', array("errorMsg" => $errorMsg));
    }

    public function generateotp() {
        //echo "in";die;
        $session = session();
        $method = $this->request->getMethod();
        $companyModel = new CompanyModel();
        if ($method == 'post') {
            //echo "in";exit;
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            //$otp 	= $this->request->getPost("otp");
            $language = '';
            if ($username != '' && $password != '') {
                $return = $companyModel->checkCompanyLogin($username, $password);

                if ($return != '') {
                    $oldptp = $return->cookiesotp;
                    helper('text');
                    $otpno = random_string('nozero', 4);
                    $userid = $return->id;
                    $mobileno = $return->mobile;
                    $userdata = array("cookiesotp" => password_hash($otpno, 1));
                    $Update = $companyModel->where('id', $userid)->set($userdata)->update();

                    $myTextFile = FCPATH . "codelog.txt";
                    file_put_contents($myTextFile, "\n" . date('Y-d-m h:i:s A') . " code  " . print_r($username . " - " . $otpno, true) . " ", FILE_APPEND);

                    // echo $otpno;die;
                    $status = 0;
                    $response = array();
                    if ($Update) {
                        $status = 1;
                        $mobileno = "968" . $mobileno;
                        $smsemail = new EmailSms();
                        $smsemail->send_sms($mobileno, "Your verification code is: " . $otpno . "  Message id : lMn7ahqOEjz ", $language);
                        $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Otp generated successfully'
                            ],
                            'optno' => $otpno,
                            'mobile' => $mobileno,
                        ];
                        // echo $otpno;exit;
                        $json = $status;

                        $session->destroy();
                        return $this->response->setJSON($json);
                        return redirect()->to(site_url('admin'));
                        //echo " index";exit;
                        //echo json_encode($json);
                    } else {
                        $session = session();
                        $session->destroy();
                        return $this->response->setJSON($json);
                        //return $this->response->setJSON($response);
                    }
                    //echo "out";exit;
                    $session->setFlashdata('errmessage', 'Invalid Email / Password');
                } else {
                    $session->setFlashdata('errmessage', 'Invalid Email / Password');
                }
            }
        }
    }

    public function dashboard() {

        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
        } else if ($session->get('employee_id')) {
            $isAdminLoggedIn = $session->get('employee_id');
        }

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
      //  return redirect()->to(site_url('logout'));
        $data = array();

        $adminModel = new AdminModel();
        $data['login'] = $adminModel->LoginID();

        $compModel = new CompanyModel();
        $searchArray = '';
        $data["companycount"] = $compModel->getDataAll($searchArray, '', '', 1);
        $searchArray = array('status'=>1);
        $data["active_companycount"] = $compModel->getDataAll($searchArray, '', '', 1);

        $vipModel = new VipModel();
        $searchArray = '';
        $data ['vipcount'] = $vipModel->getData($searchArray, '', '', 1);

        $contactus = new ContactUsModel();
        $searchArray = '';
        $data['contactcount'] = $contactus->getDataAll($searchArray, '', '', 1);

        $userModel = new CustomerModel();
        $searchArray = '';
        $data ['customer_count'] = $userModel->getData($searchArray, '', '', 1);
        $searchArray = array('status'=>1);
        $data ['active_customer_count'] = $userModel->getData($searchArray, '', '', 1);

        $productModel = new ProductModel();
        $searchArray = array();
        $searchArray['show_inredeem'] = '0';
        $data ['productCount'] = $productModel->getAll($searchArray, '', '', 1);

        $searchArray['company_id'] = $session->get('company_id');
        $data ['CountProduct'] = $productModel->getAll($searchArray, '', '', 1);

        $searchArray['show_inredeem'] = '1';
        $data ['redeemCount'] = $productModel->getAll($searchArray, '', '', 1);

        $addModel = new AdvertisementModel();
        $searchArray = '';
        $data["bannerCount11"] = $addModel->getDataAll($searchArray, '', '', 1);

        $enqModel = new CompanyEnquiryModel();
        $searchArray = '';
        $data["enquiryCount"] = $enqModel->getData($searchArray, '', '', 1);

        $docModel = new CompanyDocFile();
        $searchArray = array();
        $searchArray['company_id'] = $session->get('company_id');
        ;
        $data ['bannerCount'] = $docModel->getData($searchArray, '', '', 1);

        $enquiryModel = new CompanyEnquiryModel();
        $searchArray = array();
        $searchArray['ce_companyid'] = $session->get('company_id');
        ;
        $data ['CompEnqCount'] = $enquiryModel->getData($searchArray, '', '', 1);

        $notifyModel = new NotificationModel();
        $searchArray = array("notification_type" => 'city');
        $data["notifyCount"] = $notifyModel->getData($searchArray, '', '', 1);

        $empModel = new EmployeeModel();
        $searchArray = '';
        $data["employeeCount"] = $empModel->getData($searchArray, '', '', 1);

        $mallModel = new MallDetailsModel();
        $searchArray = '';
        $data["mallcount"] = $mallModel->getData($searchArray, '', '', 1);

        $menuModel = new MenuModel();
         $searchArray = '';
       
        $data["menuCount"] = $menuModel->getAll($searchArray, '', '',1);
        $company_id = $session->get('company_id');
        if($company_id){

            $data["companymenuCount"] = $menuModel->select('company_id')->where('company_id',$company_id)->countAllResults();
            // print_r($data["companymenuCount"]);
        }
        

        $this->template->render('admintemplate', 'contents', 'admin/dashboard', $data);
    }

/////////////////////////  company dashboard ///////////////////////////////

    public function dashboard1() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $data = array();

        $medModel = new MedicineModel();
        $searchArray = '';
        $data['totalmedicinecount'] = $medModel->getData($searchArray, '', '', 1);

        $delboyModel = new DelBoyModel();
        $searchArray = '';
        $data['totaldeliveryboyscount'] = $delboyModel->getData($searchArray, '', '', 1);

        $ordersModel = new OrdersModel();
        $searchArray = '';
        $data['totalorderscount'] = $ordersModel->getData($searchArray, '', '', 1);

        $userModel = new UserModel();
        $searchArray = '';
        $data['totalcustomerscount'] = $userModel->getData($searchArray, '', '', 1);

        $this->template->render('admintemplate', 'contents', 'admin/dashboard1', $data);
    }


    public function edit_password()
    {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/change_password');

    }


    public function update_password()
    {
        $adminModel = new AdminModel();

        $session = session();

        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        }

       $userid = $this->session->get('user_id');
       

       $new_password = $this->request->getPost('password');

  
       $arrSaveData = array(
                    'password' => password_hash($new_password, 1),
                    
                  );
          
        $Update = $adminModel->where('id',$userid)->set($arrSaveData)->update();
        
        if ($Update) 
        {
            $this->session->setFlashdata('message', 'Admin Password updated successfully.');
             
            $this->template->render('admintemplate', 'contents' , 'admin/change_password');
            
        }
       
    }

    public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('admin'));
    }

}
