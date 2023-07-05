<?php
namespace App\Controllers;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\VipModel;
use App\Models\CategoryModel;
use App\Models\VersionControlModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class CustomerController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $siteVariables = new SiteVariables();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    public function Allcustomerlist() {
        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
	$hightshow = $this->request->getGet('points');  
		
		$stateModel = new StateModel();
        $data['states'] = $stateModel->findAll();
		      
        $customerModel = new CustomerModel();
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $siteVariables = new SiteVariables();
        $data['customertype'] = $siteVariables->getVariable('customertype');
         $customer_type = $this->request->getGet('customer_type');
         $current_version = $this->request->getGet('current_version');
         $app_status = $this->request->getGet('app_status');
        if($customer_type){ $searchArray['customer_type'] =$customer_type;  }
        if($current_version){ $searchArray['current_version'] =$current_version;  }
        if($app_status){ $searchArray['app_status'] =$app_status;  }

        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $customerModel->getData($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;		
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
       if($hightshow){
                $searchArray['points'] = 1;
               }
           $data["searchArray"] = $searchArray;
        
        
         if($hightshow){
                $searchArray['orderby'] = 'totalpoint';
               }
//print_r($data["searchArray"]);die('667');

if($customer_type != 'customer' && ($customer_type != 'vip')){
$data['title'] = 'All Customer List';
} 
else if($customer_type = 'vip' && ($customer_type != 'customer')){
$data['title'] = 'V.I.P Customer List';
}
else if($customer_type = 'customer' && ($customer_type != 'vip')){
$data['title'] = 'Customer List';
}else {
$data['title'] = '';
}
        $data['customers'] = $customerModel->getData($searchArray, $startLimit, $Limit);
        $VersionControlModel =new VersionControlModel();
        $data['version']=$VersionControlModel->select('id,version_no')->find();

        $this->template->render('admintemplate', 'contents', 'admin/customer/customerlist', $data);
    }

    function index() {
        $stateModel = new StateModel();
        $data['states'] = $stateModel->findAll();
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->findAll();
        $vipModel = New VipModel();
        $data['values'] = $vipModel->where('status',1)->orderBy('id', 'DESC')->findAll();
        $categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
        $siteVariables = new SiteVariables();
        $data['genderarr'] = $siteVariables->getVariable('gender');
        //echo"<pre>"; print_r($data['genderarr']);die;
        $this->template->render('admintemplate', 'contents', 'admin/customer/customer_form', $data);
    }

    function action() {
        if ($this->request->getVar('action')) {
            $action = $this->request->getVar('action');

            if ($action == 'get_city') {
                $cityModel = new CityModel();
                $citydata = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();

                echo json_encode($citydata);
            }
        }
    }

/////// add new customer start here /////////

    public function create_newcustomer() {

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $mobile = $this->request->getVar('mobile');
        $city_code = $this->request->getVar('city_code');

        $customer = new CustomerModel();
        $moblRecord = $customer->checkMobileExist($mobile);
        if ($moblRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Mobile No Already Exist');
            return redirect()->to(site_url('AddCustomer'));
        }

        $codeRecord = $customer->checkCityCode($city_code);
        if ($codeRecord > 0) {
            $this->session->setFlashdata('errmessage', 'This City Code Already Exist');
            return redirect()->to(site_url('AddCustomer'));
        }

        $customer = new CustomerModel;
        $data = array();
        $profile = "";
        $file = $this->request->getFile("profile");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            if (in_array($file_type, $valid_file_types)) {
                $profile = $file->getName();

                if ($file->move("users", $profile)) {
                    $profile = $file->getName();
                }
            }
        }

        $interest = $this->request->getVar('interest');
        if ($interest) {
            $interest = implode(',', $this->request->getVar('interest'));
        }
        $customer_name = $this->request->getVar('name');
        $vip_code = $this->request->getVar('vip_code');
	$vip_plus = "";
        if($vip_code){
            $customer_type = 'vip';
            $vip_plus = 'false';
        } else {
            $customer_type = 'customer'; 
        }        
        $data = [
            'name' => $customer_name,
            'mobile' => $this->request->getVar('mobile'),
            'email' => $this->request->getVar('email'),
            'city_code' => $customer->generatecode(),
            'gender' => $this->request->getVar('gender'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'nationality' => $this->request->getVar('nationality'),
            'stateid' => $this->request->getVar('stateid'),
            'cityid' => $this->request->getVar('cityid'),
            'language' => $this->request->getVar('language'),
            'profile' => $profile,
            'created_date' => date('Y-m-d H:i:s'),
            'customer_type' => $customer_type,
            'interest' => $interest,
            'vip_code' => $this->request->getVar('vip_code'),
            'start_date' => $this->request->getVar('start_date'),
            'end_date' => $this->request->getVar('end_date'),
            'commission' => $this->request->getVar('commission'),
            'arb_name' => $this->request->getVar('arb_name'),
            'vip_plus' => $vip_plus,
        ];

        $newuserdata = (array_filter($data));
        $id = $customer->insert($newuserdata);

        $vip_code = $this->request->getPost('vip_code');
        $arrSaveData = array(
            'status' => 0,
        );
        $vipModel = new VipModel();
        $Update = $vipModel->where('vip_code', $vip_code)->set($arrSaveData)->update();

        if ($customer->errors) {
            return $this->fail($customer->errors());
        } 
        else {
            $this->session->setFlashdata('message', 'Your data saved successully and your city code is ' . $data['city_code']);
            return redirect()->to(site_url('Customers'));
        }
        /*else if($customer_type == 'vip') {
            $this->session->setFlashdata('message', 'Your data saved successully and your city code is ' . $data['city_code']);
            return redirect()->to(site_url('VipCustomers'));
        }
        */
    }

    public function edit_customer() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
        $customerModel = new CustomerModel();
        $data['customers'] = $customerModel->getCustomerID($id);
        //echo"<pre>";print_r($data['customers']);die('AA');
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->findAll();
        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->findAll();
        $cityModel = new CityModel();
        $data['cities'] = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();
        $data['all_cities'] = $cityModel->findAll();
        $vipModel = New VipModel();
        // $data['values'] = $vipModel->orderBy('id', 'DESC')->findAll();
        $data['values'] = $vipModel->where('status',1)->orderBy('id', 'DESC')->findAll();
        $categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();

        $siteVariables = new SiteVariables();
        $data['genderarr'] = $siteVariables->getVariable('gender');
        //echo"<pre>"; print_r($data['genderarr']);die;

        if (!$data['customers']) {
            $this->session->setFlashdata('errmessage', 'Customer Boy Id Does not exist!');
            return redirect()->to(site_url('Customers'));
        }

        $this->template->render('admintemplate', 'contents', 'admin/customer/edit_customer_form', $data);
    }

    public function update() {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $customer_id = $this->request->getPost('customer_id');

        if (!$customer_id) {
            $this->session->setFlashdata('errmessage', 'Customer does not exist!');

            return redirect()->to(site_url('adminlist'));
        }

        $interest = implode(',', $this->request->getVar('interest'));
        $name = $this->request->getPost('name');
        $city_code = $this->request->getPost('city_code');
        $gender = $this->request->getPost('gender');
        $date_of_birth = $this->request->getPost('date_of_birth');
        $nationality = $this->request->getPost('nationality');
        $stateid = $this->request->getPost('stateid');
        $cityid = $this->request->getPost('cityid');
        $language = $this->request->getPost('language');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');
        $status = $this->request->getPost('status');
        $profile = $this->request->getPost('profile');
        $updated_date = $this->request->getPost('updated_date');
        $vip_code = $this->request->getPost('vip_code');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $commission = $this->request->getPost('commission');
        $vip_code = $this->request->getPost('vip_code');
		$arb_name = $this->request->getPost('arb_name');
        $totalpoint = $this->request->getPost('totalpoint');

        $customerModel = new CustomerModel();
        $codeRecord = $customerModel->checkCityCodeExist($city_code, $customer_id);
        if ($codeRecord > 0) {
            $this->session->setFlashdata('errmessage', 'This City Code Already Exist');
            return redirect()->to(site_url('EditCustomer?id=' . $customer_id));
        }

        $moblRecord = $customerModel->EditMobileExist($mobile, $customer_id);
        if ($moblRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Mobile No Already Exist');
            return redirect()->to(site_url('EditCustomer?id=' . $customer_id));
        }

        $vipModel = new VipModel();
        $vipRecord = $vipModel->checkVipCodeExist($city_code);
        if ($vipRecord > 0) {
            $this->session->setFlashdata('errmessage', 'This City Code Already Exist');
            return redirect()->to(site_url('EditCustomer?id=' . $customer_id));
        }	
        	
        $data['customers'] = $customerModel->getCustomerID($customer_id);
        if($vip_code){
            $customer_type = 'vip';
            $vip_code = $vip_code;  
        }
       else if($data['customers']->vip_code){
            $customer_type = 'vip';
            $vip_code = $data['customers']->vip_code;
        }
        else { 
            $customer_type = 'customer'; 
        }  
       
        $data = array();
        $profile = "";
        $file = $this->request->getFile("profile");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            $userFolderpath = FCPATH . 'users/';

            if (in_array($file_type, $valid_file_types)) {
                $profile = $file->getName();

                if ($file->move($userFolderpath, $profile)) {
                    $profile = $file->getName();
                }
            }
        }
       $arrSaveData = array(
                    'name' => $name,
                    'city_code' => $city_code,
                    'vip_code' => $vip_code,
                    'gender' => $gender,
                    'date_of_birth' => $date_of_birth,
                    'nationality' => $nationality,
                    'stateid' => $stateid,
                    'cityid' => $cityid,
                    'language' => $language,
                    'mobile' => $mobile,
                    'email' => $email,
                    'status' => $status,
                    'profile' => $profile,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'interest' => $interest,
                    'commission' => $commission,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'arb_name' => $arb_name,
                    'customer_type' => $customer_type,
					'totalpoint' => $totalpoint        
                  );     
        $newuserdata = (array_filter($arrSaveData));  
        $Update = $customerModel->where('id', $customer_id)->set($newuserdata)->update();
        $arrSaveData = array(
            'status' => 0,
        );
        $vipModel = new VipModel();
        $vipModel->where('vip_code', $vip_code)->set($arrSaveData)->update();

        if ($Update) {
            $this->session->setFlashdata('message', 'Customer updated successfully.');
            return redirect()->to(site_url('EditCustomer?id=' . $customer_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditCustomer?id=' . $customer_id));
        }
    }

//////////// delete customer /////////////


    public function delete_customer() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $customerModel = new CustomerModel();

        if ($isAdminLoggedIn) {
            $type = 'customer';
            $customerModel->where('id', $id)->delete();

            $this->session->setFlashdata('message', 'Customer deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
      //  return redirect()->to(site_url('Customers'));
          return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

//////////// delete vip customer /////////////

    public function delete_vipcustomer() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $customerModel = new CustomerModel();

        if ($isAdminLoggedIn) {
            $type = 'vip';
            $customerModel->where('id', $id)->delete();

            $this->session->setFlashdata('message', 'V.I.P Customer deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('VipCustomers'));
    }

///////// customer detail //////////////////////

    public function customerdetails() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
        $categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();

        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $customerModel = new CustomerModel();
        $data['customer'] = $customerModel->getCustomerID($id); // return count value

        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->orderBy('country_enName', 'ASC')->findAll();

        if (!$data['customer']) {
            $this->session->setFlashdata('errmessage', 'Customer Id Does not exist!');
            return redirect()->to(site_url('Customers'));
        }

        $this->template->render('admintemplate', 'contents', 'admin/customer/customerdetails', $data);
    }


////////////////////////////////// vip plus //////////////////////////////

 public function vip_plus() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            $this->session->setFlashdata('errmessage', 'Vip Customer does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $vip_plus = $this->request->getPost('vip_plus');

        $customertModel = new customerModel();

        $arrSaveData = array(
            'vip_plus' => $vip_plus,
        );

        $Update = $customertModel->where('id', $id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'vip plus updated successfully.');
            return redirect()->to($_SERVER["HTTP_REFERER"]);
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to($_SERVER["HTTP_REFERER"]);
        }
    }

    public function Deletevipcode(){
         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
       $id=$this->request->getGet('id'); 

        $customerModel = new CustomerModel();

       if ($id) {

        $data['vip_code']='';
             $customerModel->set($data)->where('id', $id)->update();

            $this->session->setFlashdata('message', 'V.I.P Customer deleted successfully.');
            return redirect()->to($_SERVER["HTTP_REFERER"]);
       }
           

    }


}

?>

