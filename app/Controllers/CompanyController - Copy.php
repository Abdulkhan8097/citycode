<?php
namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\CompanyDocFile;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\VipModel;
use App\Models\VipCustomerModel;
use App\Models\BranchModel;
use App\Models\CategoryModel;
use App\Libraries\Paginationnew;
use App\Models\CustomerModel;
use App\Models\SitevariableModel;

class CompanyController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    function index() {

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $data = array();
        $compModel = new CompanyModel();
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $data['action'] = "Company";
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $compModel->getDataAll($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['companylist'] = $compModel->getDataAll($searchArray, $startLimit, $Limit);

        //  $data["companylist"] = $compModel->getDataAll($searchArray,'', '', '');

        $customerModel = new CustomerModel();
        $searchvipArray = array("onlyvipcustomer"=>1);
        $data['lists'] = $customerModel->getData($searchvipArray);

       

        $this->template->render('admintemplate', 'contents', 'admin/companylist', $data);
    }
    
    function getVipCustomer()
    {
        $data = array();
         $companyid = $this->request->getGet('companyid');
        
       $data['companyid'] = $companyid;
       
        $customerModel = new CustomerModel();
        $searchvipArray = array("onlyvipcustomer"=>1);
        $data['lists'] = $customerModel->getData($searchvipArray);
        
        $companyVipCustomer = array();
        $comVipCustomer = new VipCustomerModel();
        $arrSearch = array('company_id'=>$companyid);
        $comVipCustomer = $comVipCustomer->getData($arrSearch);
        foreach($comVipCustomer as $vipDetails)
        {
            $companyVipCustomer[] = $vipDetails->customer_id;
        }
        //print_r($companyVipCustomer);
        $data['companyVipCustomer'] = $companyVipCustomer;
        return view('admin/vip_customer_company',$data);
    }

    function add_new() {
        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
        $categoryModel = New CategoryModel();
        $data['categories'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
        $this->template->render('admintemplate', 'contents', 'admin/company_form', $data);
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

    public function add_company() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $email = $this->request->getVar('email');
        $details = new CompanyModel;
        $emailRecord = $details->checkEmailExist($email);
        if ($emailRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Email Id Already Exist');
            return redirect()->to(site_url('AddCompany'));
        }
       
        $data = array();
        $picture = "";
        $file = $this->request->getFile("picture");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            $userFolderpath = FCPATH . 'company/';

            if (in_array($file_type, $valid_file_types)) {
                $picture = $file->getName();

                if ($file->move($userFolderpath, $picture)) {
                    $picture = $file->getName();
                }
            }
        }
        $data = [
            'category' => $this->request->getVar('category'),
            'company_name' => $this->request->getVar('company_name'),
            'cr_number' => $this->request->getVar('cr_number'),
            'username' => $this->request->getVar('username'),
            'auth_contact' => $this->request->getVar('auth_contact'),
            'password' => password_hash($this->request->getVar('password'), 1),
            'mobile' => $this->request->getVar('mobile'),
            'email' => $this->request->getVar('email'),
            'display_name' => $this->request->getVar('display_name'),
            'c_location' => $this->request->getVar('c_location'),
            'views' => $this->request->getVar('views'),
            'website' => $this->request->getVar('website'),
            'instagram' => $this->request->getVar('instagram'),
            'twitter' => $this->request->getVar('twitter'),
            'facebook' => $this->request->getVar('facebook'),
            'snapchat' => $this->request->getVar('snapchat'),
            'address' => $this->request->getVar('address'),
            'status' => $this->request->getVar('status'),
            'picture' => $picture,
            'created_date' => date('Y-m-d H:i:s'),

            'company_arb_name' => $this->request->getVar('company_arb_name'),
            'arb_username' => $this->request->getVar('arb_username'),
            'display_arb_name' => $this->request->getVar('display_arb_name'),
            'arb_address' => $this->request->getVar('arb_address'),
            'arb_location' => $this->request->getVar('arb_location'),
        ];
        // echo"<pre>"; print_r($data);die;

        $newuserdata = (array_filter($data));
        $id = $details->insert($newuserdata);

//////////// insert in company_doc_file /////////

        $data11 = [];
        if ($this->request->getMethod() == 'post') {
            $files = $this->request->getFiles();

            foreach ($files['doc'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'company/')) {

                        $data11 = [
                            'company_id' => $id,
                            'doc' => $img->getClientName(),
                            'type' => 'doc',
                        ];
                        $imagefile = new CompanyDocFile();
                        $save = $imagefile->insert($data11);
                    }
                }
            }
        }

///////////////// company banner ///////////////////////

        $data12 = [];
        if ($this->request->getMethod() == 'post') {
            $files = $this->request->getFiles();

            foreach ($files['banner'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'company/')) {

                        $data12 = [
                            'company_id' => $id,
                            'banner' => $img->getClientName(),
                            'type' => 'banner',
                        ];
                        $imagefile = new CompanyDocFile();
                        $save = $imagefile->insert($data12);
                    }
                }
            }
        }

//////////// insert in company_code_details /////////	

        $company_id = $id;
        //echo "<pre>"; print_r($this->request->getVar()); die;
        $c_branch = $this->request->getVar('c_branch');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $c_description = $this->request->getVar('c_description');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');

        $fam_branch = $this->request->getVar('fam_branch');
        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');

        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');

        if ((!empty($c_branch)) && ($c_branch != '')) {
            $data = [
                'company_id' => $id,
                'branch_id' => $c_branch,
                'company_discount' => $company_discount,
                'comission' => $comission,
                'customer_discount' => $customer_discount,
                'discount_detail' => $c_disc_detail,
                'description' => $c_description,
                'start_date' => $c_start,
                'end_date' => $c_end,
                'coupon_type' => 'city',
            ];
            $codes = new CodeModel();
            $code_id = $codes->insert($data);
            //print_r($code_id);die();
        }
/////////////////////// for v.i.p /////////////////////////

        if (!empty($fam_branch)) {
            $data2 = [
                'company_id' => $id,
                'branch_id' => $fam_branch,
                'company_discount' => $fam_company_discount,
                'comission' => $fam_comission,
                'customer_discount' => $fam_customer_discount,
                'description' => $fam_description,
                'discount_detail' => $fam_disc_detail,
                'start_date' => $fam_start,
                'end_date' => $fam_end,
                'coupon_type' => 'vip',
            ];
            $codes = new CodeModel();
            $vip_id = $codes->insert($data2);
        }

/////////////////////// for friday /////////////////////////
        $friday_id = '';
        if (!empty($fri_branch)) {

            $data3 = [
                'company_id' => $id,
                'branch_id' => $fri_branch,
                'company_discount' => $fri_company_discount,
                'comission' => $fri_comission,
                'customer_discount' => $fri_customer_discount,
                'description' => $fri_description,
                'discount_detail' => $fri_disc_detail,
                'start_date' => $fri_start,
                'end_date' => $fri_end,
                'coupon_type' => 'friday',
            ];
            $codes = new CodeModel();
            $friday_id = $codes->insert($data3);
        }

////////////// for only vip link ///////////////
//print_r($friday_id);die;
        if ($friday_id) {
            $updateData = array(
                'vip_link' => 'friday',
            );
            $Update = $details->where('id', $id)->set($updateData)->update();
        }
        if ($details->errors) {
            return $this->fail($details->errors());
        } else {
            $this->session->setFlashdata('message', 'Company Details Added Successfully!');
            return redirect()->to(site_url('Company'));
        }
    }

    //////////////////////////  edit company ////////////////

    public function edit_company() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");
        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();
        $data['all_cities'] = $cityModel->findAll();

        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();
        //echo"<pre>"; print_r($data['discount_items']);die;

        $categoryModel = New CategoryModel();
        $data['categories'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companydetails'] = $companyModel->getCompanyID($id);

        $codeModel = new CodeModel();
        $data['results'] = $codeModel->getall($id);

        $docModel = new CompanyDocFile();
        $data['banners'] = $docModel->getBanner($id);
        $data['docss'] = $docModel->getDocFile($id);

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->getBranchData($id);

        if (!$data['companydetails']) {
            $this->session->setFlashdata('errmessage', 'Company Id Does not exist!');
            return redirect()->to(site_url('Company'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/edit_company', $data);
    }

    public function editonlineshop()
    {
        $company_id = $this->request->getGet("company_id");
        
        $companyModel = new CompanyModel();
        $companydetails= $companyModel->getCompanyID($company_id);
        $data['details'] = $companydetails;
        //print_r($companydetails);die;
        $this->template->render('admintemplate', 'contents', 'admin/onlineshop', $data);
    }
    //////////////////////////  edit code company ////////////////

    public function edit_code() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");
        $offer_id = $this->request->getGet("company_id");

        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();

        $codeModel = new CodeModel();
        $data['details'] = $codeModel->getCodeID($id);

        $branchModel = new BranchModel();
        $data['all_branch'] = $branchModel->getBranch($id, $offer_id);
        $this->template->render('admintemplate', 'contents', 'admin/city_code', $data);
    }

    public function update() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $new_id = $this->request->getPost('new_id');
        if (!$new_id) {
            $this->session->setFlashdata('errmessage', 'Company Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $category = $this->request->getPost('category');
        $company_name = $this->request->getPost('company_name');
        $cr_number = $this->request->getPost('cr_number');
        $username = $this->request->getPost('username');
        $auth_contact = $this->request->getPost('auth_contact');
        $password = $this->request->getPost('password');
        $mobile = $this->request->getPost('mobile');
        $email = $this->request->getPost('email');
        $display_name = $this->request->getPost('display_name');
        $c_location = $this->request->getPost('c_location');
        $views = $this->request->getPost('views');
        $website = $this->request->getPost('website');
        $instagram = $this->request->getPost('instagram');
        $twitter = $this->request->getPost('twitter');
        $facebook = $this->request->getPost('facebook');
        $snapchat = $this->request->getPost('snapchat');
        $status = $this->request->getPost('status');
        $picture = $this->request->getPost('picture');
        $updated_date = $this->request->getPost('updated_date');
        $address = $this->request->getVar('address');

        $company_arb_name = $this->request->getVar('company_arb_name');
        $arb_username = $this->request->getVar('arb_username');
        $display_arb_name = $this->request->getVar('display_arb_name');
        $arb_address = $this->request->getVar('arb_address');
        $arb_location = $this->request->getVar('arb_location');

        $companyModel = new CompanyModel();
        $emailRecord = $companyModel->EditEmailExist($email, $new_id);
        if ($emailRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Email Id Already Exist');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        }  

        $data = array();
        $picture = "";
        $file = $this->request->getFile("picture");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            $userFolderpath = FCPATH . 'company/';

            if (in_array($file_type, $valid_file_types)) {
                $picture = $file->getName();

                if ($file->move($userFolderpath, $picture)) {
                    $picture = $file->getName();
                }
            }
        }
        $arrSaveData = array(
            'category' => $category,
            'company_name' => $company_name,
            'cr_number' => $cr_number,
            'username' => $username,
            'auth_contact' => $auth_contact,
            'password' => password_hash($password, 1),
            'mobile' => $mobile,
            'email' => $email,
            'display_name' => $display_name,
            'c_location' => $c_location,
            'views' => $views,
            'website' => $website,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'facebook' => $facebook,
            'snapchat' => $snapchat,
            'status' => $status,
            'picture' => $picture,
            'updated_date' => date('Y-m-d H:i:s'),
            'address' => $address,

            'company_arb_name' => $company_arb_name,
            'arb_username' => $arb_username,
            'display_arb_name' => $display_arb_name,
            'arb_address' => $arb_address,
            'arb_location' => $arb_location,
        );

        $newuserdata = (array_filter($arrSaveData));
        $Update = $companyModel->where('id', $new_id)->set($newuserdata)->update();

        //////////// update banner ////////////

        $data7 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            foreach ($files['banner'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'company/')) {

                        $data7 = [
                            'company_id' => $new_id,
                            'banner' => $img->getClientName(),
                            'type' => 'banner'
                        ];
                        $imagefile = new CompanyDocFile();
                        $save = $imagefile->insert($data7);
                    }
                }
            }
        }

////////////////////////// update document ////////////////////

        $data8 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            foreach ($files['doc'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'company/')) {

                        $data8 = [
                            'company_id' => $new_id,
                            'doc' => $img->getClientName(),
                            'type' => 'doc'
                        ];
                        $imagefile = new CompanyDocFile();
                        $save = $imagefile->insert($data8);
                    }
                }
            }
        }

//////////////////////// insert branch name ///////////////////////

        $branch_name = $this->request->getVar('branch_name');
        $branch_username = $this->request->getVar('branch_username');
        $branch_password = $this->request->getVar('branch_password');
        $state = $this->request->getVar('state');
        $city = $this->request->getVar('city');
        $location = $this->request->getVar('location');

        $arb_branch_name = $this->request->getVar('arb_branch_name');
        $arb_branch_location = $this->request->getVar('arb_branch_location');

        $branchModel = new BranchModel();
        $userRecord = $branchModel->usernameExist($branch_username);
        if ($userRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Username Already Exist');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        }

        if ((!empty($branch_name)) || (!empty($arb_branch_name))) {
            $branchdata = [
                'company_id' => $new_id,
                'branch_name' => $branch_name,
                'branch_username' => $branch_username,
                'branch_password' => password_hash($branch_password, 1),
                'state' => $state,
                'city' => $city,
                'location' => $location,
                'arb_branch_name' => $arb_branch_name,
                'arb_branch_location' => $arb_branch_location,               
            ];
            $branch_id = $branchModel->insert($branchdata);
        }

///////////////////////// update discount type  ///////////////////////		
        $c_branch = $this->request->getVar('c_branch');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $c_description = $this->request->getVar('c_description');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');

        $fam_branch = $this->request->getVar('fam_branch');
        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');

        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');

        $c_arb_description = $this->request->getVar('c_arb_description');
        $fam_arb_description = $this->request->getVar('fam_arb_description');
        $fri_arb_description = $this->request->getVar('fri_arb_description');

        if (!empty($c_branch)) {
            $data = [
                'company_id' => $new_id,
                'branch_id' => $c_branch,
                'company_discount' => $company_discount,
                'comission' => $comission,
                'customer_discount' => $customer_discount,
                'discount_detail' => $c_disc_detail,
                'description' => $c_description,
                'arb_description' => $c_arb_description,
                'start_date' => $c_start,
                'end_date' => $c_end,
                'coupon_type' => 'city',
            ];
            //print_r($data);
            $codeModel = new CodeModel();
            $code_id = $codeModel->insert($data);
        }
//////////////////////// for vip update //////////////////

        $vip_id = '';
        if (!empty($fam_branch)) {

            $data2 = [
                'company_id' => $new_id,
                'branch_id' => $fam_branch,
                'company_discount' => $fam_company_discount,
                'comission' => $fam_comission,
                'customer_discount' => $fam_customer_discount,
                'description' => $fam_description,
                'arb_description' => $fam_arb_description,
                'discount_detail' => $fam_disc_detail,
                'start_date' => $fam_start,
                'end_date' => $fam_end,
                'coupon_type' => 'vip',
            ];
            $codeModel = new CodeModel();
            $vip_id = $codeModel->insert($data2);
        }

/////////////////// for only vip link /////////////
//print_r($vip_id);die;

        if ($vip_id != '') {
            $updateData = array(
                'vip_link' => 'vip',
            );
            $Update = $companyModel->where('id', $new_id)->set($updateData)->update();
        }

///////////////////////// for friday code update ////////
        
        if (!empty($fri_branch)) {
            $data3 = [
                'company_id' => $new_id,
                'branch_id' => $fri_branch,
                'company_discount' => $fri_company_discount,
                'comission' => $fri_comission,
                'customer_discount' => $fri_customer_discount,
                'description' => $fri_description,
                'arb_description' => $fri_arb_description,
                'discount_detail' => $fri_disc_detail,
                'start_date' => $fri_start,
                'end_date' => $fri_end,
                'coupon_type' => 'friday',
            ];
            $codeModel = new CodeModel();
            $friday_id = $codeModel->insert($data3);
        }

        if(!empty($branch_id)){
            $this->session->setFlashdata('message', 'New Branch Added Successfully.');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        }
        else if ((!empty($code_id)) || (!empty($vip_id)) || (!empty($friday_id))) {
            $this->session->setFlashdata('message', 'New Offer Added Successfully.');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        } else if ($new_id) {
            $this->session->setFlashdata('message', 'Company updated successfully.');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        }
    }

//////////// delete product /////////////

    public function delete_company() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        $companyModel = new CompanyModel();
        $codeModel = new CodeModel();

        if ($isAdminLoggedIn) {
            $companyModel->where('id', $id)->delete();
            $codeModel->where('company_id', $id)->delete();
            $this->session->setFlashdata('message', 'Company deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Company'));
    }

////////////////////////// company detail //////////////////////

    public function companydetails() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
        $companyModel = new CompanyModel();
        $data['companydetails'] = $companyModel->getCompanyID($id);
        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
        $cityModel = new CityModel();
        $data['all_cities'] = $cityModel->findAll();
        $codeModel = new CodeModel();
        $data['offer_details'] = $codeModel->getCodeIDs($id);

        $branchModel = new BranchModel();
        $data['branch_details'] = $branchModel->getBranchData($id);
        //echo"<pre>";print_r($data['offer_details']);die();
        $docModel = new CompanyDocFile();
        $data['banners'] = $docModel->getBanner($id);
        $data['docss'] = $docModel->getDocFile($id);

        if (!$data['companydetails']) {
            $this->session->setFlashdata('errmessage', 'Company Id Does not exist!');
            return redirect()->to(site_url('Company'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/companydetails', $data);
    }

    public function add_vip() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $vipModel = new VipCustomerModel;
        $companyid = $this->request->getPost('companyid');
        $vipid = $this->request->getPost('vip');

        if($companyid && $vipid)
        {
            foreach($vipid as $vipcustomerid){

                $searchVipArray = array("company_id"=>$companyid,"customer_id"=>$vipcustomerid);
                $isexist = $vipModel->getData($searchVipArray,'','',1);
                if(!$isexist)
                {
                    $data1 = [
                        'company_id' => $companyid,
                        'customer_id' => $vipcustomerid,
                    ];

                    $cid = $vipModel->save($data1);
                }
            }
            $this->session->setFlashdata('message', 'V.I.P Customer Added Successfully!');
        }
        else
        {
            $this->session->setFlashdata('message', 'V.I.P Customer Not added!');
        }
                
                return redirect()->to(site_url('Company'));
        
        
    }

//////////////////////////// delete company banner ///////////////////////

    public function delete_comapny_banner() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        if ($isAdminLoggedIn) {
            $docModel = new CompanyDocFile();
            $docModel->where('id', $id)->delete();
            $this->session->setFlashdata('message', 'Company Banner Deleted Successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        //return redirect()->to(site_url($_SERVER["HTTP_REFERER"]));
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

//////////////////////////// delete company document ///////////////////////

    public function delete_comapny_document() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        if ($isAdminLoggedIn) {
            $docModel = new CompanyDocFile();
            $docModel->where('id', $id)->delete();
            $this->session->setFlashdata('message', 'Company Document Deleted Successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        //return redirect()->to(site_url($_SERVER["HTTP_REFERER"]));
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

    ////////////////////////////////////////// pagalpan ///////////////////////////////////

    public function update_offer() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $company_id = $this->request->getPost('company_id');
        $offer_id = $this->request->getPost('offer_id');
        //print_r($offer_id);die();
        if (!$offer_id) {
            $this->session->setFlashdata('errmessage', 'Offer Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
        $c_branch = $this->request->getVar('c_branch');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $c_description = $this->request->getVar('c_description');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');

        $fam_branch = $this->request->getVar('fam_branch');
        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');

        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');

        $c_arb_description = $this->request->getVar('c_arb_description');
        $fam_arb_description = $this->request->getVar('fam_arb_description');
        $fri_arb_description = $this->request->getVar('fri_arb_description');


        if ((!empty($c_branch)) && $c_branch != '') {

            $updateCityCode = [
                'branch_id' => $c_branch,
                'company_discount' => $company_discount,
                'comission' => $comission,
                'customer_discount' => $customer_discount,
                'discount_detail' => $c_disc_detail,
                'description' => $c_description,
                'arb_description' => $c_arb_description,
                'start_date' => $c_start,
                'end_date' => $c_end,
            ];

            //print_r($updateCityCode);die();
            $codeModel = new CodeModel();
            $codeModel->where('id', $offer_id, 'company_id', $company_id)->set($updateCityCode)->update();
            //$codeModel->where('id',$offer_id , 'c_branch',$c_branch)->set($updateCityCode)->update();
        }

        if ((!empty($fam_branch)) && $fam_branch != '') {

            $updateVipCode = [
                'branch_id' => $fam_branch,
                'company_discount' => $fam_company_discount,
                'comission' => $fam_comission,
                'customer_discount' => $fam_customer_discount,
                'description' => $fam_description,
                'arb_description' => $fam_arb_description,
                'discount_detail' => $fam_disc_detail,
                'start_date' => $fam_start,
                'end_date' => $fam_end,
            ];
            $codeModel = new CodeModel();
            $codeModel->where('id', $offer_id, 'fam_branch', $fam_branch)->set($updateVipCode)->update();
        }

        if ((!empty($fri_branch)) && $fri_branch != '') {

            $updateFridayCode = [
                'branch_id' => $fri_branch,
                'company_discount' => $fri_company_discount,
                'comission' => $fri_comission,
                'customer_discount' => $fri_customer_discount,
                'description' => $fri_description,
                'arb_description' => $fri_arb_description,
                'discount_detail' => $fri_disc_detail,
                'start_date' => $fri_start,
                'end_date' => $fri_end,
            ];
            //print_r($data);
            $codeModel = new CodeModel();
            $codeModel->where('id', $offer_id, 'fri_branch', $fri_branch)->set($updateFridayCode)->update();
        }

        if ($offer_id) {
            $this->session->setFlashdata('message', 'Company Offer updated successfully.');
            return redirect()->to(site_url('EditOffer?id=' . $offer_id . '&&' . 'company_id=' . $company_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditOffer?id=' . $offer_id));
        }
    }

///////////////// delete offer ////////////////

    public function delete_offer() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");

        $codeModel = new CodeModel();
        $branchModel = new BranchModel();

        if ($isAdminLoggedIn) {
            $codeModel->where('id', $id)->delete();

            $this->session->setFlashdata('message', 'Company Offer deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        //  return redirect()->to(site_url('Company'));
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

    public function edit_branch() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $cid = $this->request->getGet("id");

        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $branchModel = new BranchModel();
        $cityModel = new CityModel();
        $data['city_cities'] = $branchModel->getBranchCity($cid);
        $data['branchdata'] = $branchModel->getBranchId($cid);
        //print_r($data['branchdata']);die();
        $this->template->render('admintemplate', 'contents', 'admin/edit_branch', $data);
    }

    ///////////////// update branch ///////////////////

    public function update_branch() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $branch_id = $this->request->getPost('branch_id');
        if (!$branch_id) {
            $this->session->setFlashdata('errmessage', 'Branch Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $branch_name = $this->request->getVar('branch_name');
        $branch_username = $this->request->getVar('branch_username');
        $branch_password = $this->request->getVar('branch_password');
        $state = $this->request->getVar('state');
        $city = $this->request->getVar('city');
        $location = $this->request->getVar('location');

        $arb_branch_name = $this->request->getVar('arb_branch_name');
        $arb_branch_location = $this->request->getVar('arb_branch_location');

        $branchModel = new BranchModel();
        $userRecord = $branchModel->EdituserExist($branch_username, $branch_id);
        if ($userRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Username Already Exist');
            return redirect()->to(site_url('EditBranch?id=' . $branch_id));
        }

        if (($branch_name != '') || ($arb_branch_name != '')) {
            $updateCityCode = [
                'branch_name' => $branch_name,
                'branch_username' => $branch_username,
                'branch_password' => password_hash($branch_password, 1),
                'state' => $state,
                'city' => $city,
                'location' => $location,

                'arb_branch_name' => $arb_branch_name,
                'arb_branch_location' => $arb_branch_location,
            ];            
            $branchModel->where('branch_id', $branch_id)->set($updateCityCode)->update();
        }

        if ($branch_id) {
            $this->session->setFlashdata('message', 'Branch updated successfully.');
            return redirect()->to(site_url('EditBranch?id=' . $branch_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditBranch?id=' . $branch_id));
        }
    }

    //////////// delete branch /////////////////

    public function delete_branch() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $branchModel = new BranchModel();

        if ($isAdminLoggedIn) {
            $branchModel->where('branch_id', $id)->delete();

            $this->session->setFlashdata('message', 'Branch deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

    /////////////// edit online offer ////////////////

    public function update_onlineShop() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $company_id = $this->request->getPost('company_id');		
        if (!$company_id) {
            $this->session->setFlashdata('errmessage', 'Company Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
        $online_description = $this->request->getVar('online_description');
        $online_startdate = $this->request->getVar('online_startdate');
        $online_enddate = $this->request->getVar('online_enddate');     
        $online_link = $this->request->getVar('online_link');
        $online_playstore_link= $this->request->getVar('online_playstore_link');
        $online_ios_link = $this->request->getVar('online_ios_link');
        $online_huawei_link = $this->request->getVar('online_huawei_link');
        $online_arb_description = $this->request->getVar('online_arb_description');
		
        if ((!empty($online_description)) && $online_description != '') {
            $shopdata = [
                'online_description' => $online_description,
                'online_startdate' => $online_startdate,
                'online_enddate' => $online_enddate,
                'online_link' => $online_link,
                'online_playstore_link' => $online_playstore_link,
                'online_ios_link' => $online_ios_link,
                'online_huawei_link' => $online_huawei_link,
                'online_shop' => '1',
                'online_arb_description' => $online_arb_description,
            ];
            $companyModel = new CompanyModel();
            $companyModel->where('id', $company_id)->set($shopdata)->update();
        }
		
        if ($company_id) {
            $this->session->setFlashdata('message', 'Online Shop updated successfully.');
            return redirect()->to(site_url('editonlineshop?company_id=' . $company_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('editonlineshop?company_id=' . $company_id));
        }
    }

    ///////// delete online offer ///////////////

    public function delete_onlineshop() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $company_id = $this->request->getGet("company_id");
        if (!$company_id) {
            $this->session->setFlashdata('errmessage', 'Company Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
            $delete_Shopdata = [
                'online_description' => '',
                'online_startdate' => '',
                'online_enddate' => '',
                'online_link' => '',
                'online_playstore_link' => '',
                'online_ios_link' => '',
                'online_huawei_link' => '',
                'online_shop' => '0',
                'online_arb_description' => '',
            ];
            $companyModel = new CompanyModel();
            $delete_id =  $companyModel->where('id', $company_id)->set($delete_Shopdata)->update();
      		
        if ($delete_id) {
            $this->session->setFlashdata('message', 'Online Shop Deleted Successfully.');
            return redirect()->to(site_url('EditCompany?id='. $company_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditCompany?id='. $company_id));
        }
    }

}

?>
