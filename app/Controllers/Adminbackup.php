<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
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

use CodeIgniter\Session\Session;

class Admin extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
	{
       
            $this->session = session();
          // echo "<pre>"; print_r($session);die;
            $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn'); 
     
		
	}
        
	public function index()
	{

        $session = session();
          
        $isAdminLoggedIn = $session->get('isAdminLoggedIn'); 
     
        if($isAdminLoggedIn)
        { 
               return redirect()->to(site_url('dashboard'));
        }

    	$errorMsg = "";	
       $method = $this->request->getMethod(); 
        
        $adminModel = new AdminModel();       
		if($method=='post'){										
			$username 	= $this->request->getPost("username");				
			$password 	= $this->request->getPost("password");


					
			if($username != '' && $password != ''){		
				$return = $adminModel->checkAdminLogin($username,$password);

				if($return){
				return redirect()->to(site_url('dashboard'));
				} else {
                    $session->setFlashdata('errmessage','Invalid Email / Password');	
				}						
			}else{																
				$session->setFlashdata('errmessage','Invalid Email / Password');
			}
		}
				
		$companyModel = new CompanyModel();
		if($method=='post'){														
			$username 	= $this->request->getPost("username");				
			$password 	= $this->request->getPost("password");
					
			if($username != '' && $password != ''){		
				$return = $companyModel->checkCompanyLogin($username,$password);
				//echo "<pre>";print_r($return);exit;
				if($return){
				/*helper('text');
		              $otpno =  random_string('nozero', 4);

		              $userid = $data['id'];
		              $userdata = array("password" => password_hash($otpno,1));*/



				return redirect()->to(site_url('dashboard'));
				} else {
                    		$session->setFlashdata('errmessage','Invalid Email / Password');	
				}						
			}else{																
				$session->setFlashdata('errmessage','Invalid Email / Password');
			}
		}
		
		//////////////////////////// employee login ////////////////////////
		
		$employeeModel = new EmployeeModel();
		if($method=='post'){														
			$username 	= $this->request->getPost("username");				
			$password 	= $this->request->getPost("password");
					
			if($username != '' && $password != ''){		
				$return = $employeeModel->checkEmployeeLogin($username,$password);
				if($return){
				return redirect()->to(site_url('dashboard'));
				} else {
                    $session->setFlashdata('errmessage','Invalid Email / Password');	
				}						
			}else{																
				$session->setFlashdata('errmessage','Invalid Email / Password');
			}
		}
                
        $this->template->render('admintemplate', 'contents' , 'admin/loginTpl',array("errorMsg"=>$errorMsg));
	}

        
     public function dashboard()
    {
	
	$session = session();
	if($session->get('user_id')){         
            $isAdminLoggedIn = $session->get('user_id'); 		
	}

	 else if ($session->get('company_id')){
	      $isAdminLoggedIn = $session->get('company_id'); 		
	 }
	
         else if ($session->get('employee_id')){
	      $isAdminLoggedIn = $session->get('employee_id'); 		
	}
		
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $data = array();
		
		$adminModel = new AdminModel();
		$data['login'] = $adminModel->LoginID();

        $compModel = new CompanyModel();
        $searchArray = '';
        $data["companycount"] = $compModel->getDataAll($searchArray,'','',1);

        $vipModel = new VipModel();
        $searchArray = '';
        $data ['vipcount'] = $vipModel->getData($searchArray,'','',1);

        $contactus = new ContactUsModel();
        $searchArray = '';
        $data['contactcount'] = $contactus->getDataAll($searchArray,'','',1);

        $userModel = new CustomerModel();
        $searchArray = '';
        $data ['customer_count'] = $userModel->getData($searchArray,'','',1);

        $productModel = new ProductModel();
        $searchArray = array();
        $searchArray['show_inredeem'] = '0';
        $data ['productCount'] = $productModel->getAll($searchArray,'','',1); 
		
		$searchArray['company_id'] = $session->get('company_id');
        $data ['CountProduct'] = $productModel->getAll($searchArray,'','',1);  
        
        $searchArray['show_inredeem'] = '1';
        $data ['redeemCount'] = $productModel->getAll($searchArray,'','',1);  
    
        $addModel = new AdvertisementModel();
        $searchArray = '';
	    $data["bannerCount11"] = $addModel->getDataAll($searchArray,'','',1);

        $enqModel = new CompanyEnquiryModel();
        $searchArray = '';
	    $data["enquiryCount"] = $enqModel->getData($searchArray,'','',1);
		
		$docModel = new CompanyDocFile();
        $searchArray = array();
        $searchArray['company_id'] = $session->get('company_id');;
        $data ['bannerCount'] = $docModel->getData($searchArray,'','',1);
		
		$enquiryModel = new CompanyEnquiryModel();
        $searchArray = array();
        $searchArray['ce_companyid'] = $session->get('company_id');;
        $data ['CompEnqCount'] = $enquiryModel->getData($searchArray,'','',1);
		
		$notifyModel = new NotificationModel();
        $searchArray = '';
	    $data["notifyCount"] = $notifyModel->getData($searchArray,'','',1);

		$empModel = new EmployeeModel();
        $searchArray = '';
	    $data["employeeCount"] = $empModel->getData($searchArray,'','',1);

	    $mallModel = new MallDetailsModel();
        $searchArray = '';
	    $data["mallcount"] = $mallModel->getData($searchArray,'','',1);

           $menuModel = new MenuModel();
           $searchArray = '';
	   $data["menuCount"] = $menuModel->getAll($searchArray,'','',1);


       
        $this->template->render('admintemplate', 'contents' , 'admin/dashboard', $data);
    }
	
/////////////////////////  company dashboard ///////////////////////////////
	
	public function dashboard1()
    {
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $data = array();

        $medModel = new MedicineModel();
        $searchArray = '';
        $data['totalmedicinecount'] = $medModel->getData($searchArray,'','',1);

        $delboyModel = new DelBoyModel();
        $searchArray = '';
        $data['totaldeliveryboyscount'] = $delboyModel->getData($searchArray,'','',1);

        $ordersModel = new OrdersModel();
        $searchArray = '';
        $data['totalorderscount'] = $ordersModel->getData($searchArray,'','',1);

        $userModel = new UserModel();
        $searchArray = '';
        $data['totalcustomerscount'] = $userModel->getData($searchArray,'','',1);
        
        $this->template->render('admintemplate', 'contents' , 'admin/dashboard1', $data);
    }

	
	

	public function logout()
	{
		$session = session();

		$session->destroy();
		return redirect()->to(site_url('admin'));
	}	
	
}
