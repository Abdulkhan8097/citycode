<?php
namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\MallDetailsModel;
use App\Models\CodeModel;
use App\Models\CompanyDocFile;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\VipModel;
use App\Models\OrgModel;
use App\Models\OrgCompanyModel;
use App\Models\VipCustomerModel;
use App\Models\BranchModel;
use App\Models\HomeBusinessModel;
use App\Models\CategoryModel;
use App\Libraries\Paginationnew;
use App\Models\CustomerModel;
use App\Models\SitevariableModel;
use App\Libraries\SiteVariables;

class CompanyController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    function index() {
       // echo "string";exit;

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

        $search_priority = $this->request->getGet('search_priority');
        if($search_priority)
        {
            $search_priority = $search_priority;
            $data['search_priority'] = $search_priority;
        }else{
            $search_priority = '';
            $data['search_priority'] = '';
        }
        //echo $search_priority;exit;

        $data['action'] = "Company";
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $compModel->getDataAll($searchArray, '', '', '1','');
        //$totalRecord = 0;
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data['search_priority'] = $search_priority;

        $data["searchArray"] = $searchArray;
        $data['companylist'] = $compModel->getDataAll($searchArray, $startLimit, $Limit,'',$search_priority);

        //  $data["companylist"] = $compModel->getDataAll($searchArray,'', '', '');

        $data['priorities'] = [
            'Priority-1' =>'Priority-1',
            'Priority-2' =>'Priority-2',
            'Priority-3' =>'Priority-3',
            'Priority-4' =>'Priority-4',
            'all' =>'All',
        ];

        $customerModel = new CustomerModel();
        $searchvipArray = array("onlyvipcustomer"=>1);
        $data['lists'] = $customerModel->getData($searchvipArray);

       

        $this->template->render('admintemplate', 'contents', 'admin/company/companylist', $data);
    }
    
    function getVipCustomer()
    {
        $data = array();
         $companyid = $this->request->getGet('companyid');
        
       $data['companyid'] = $companyid;
       //print_r($data['companyid']);die;
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
        // print_r($companyVipCustomer);
        $data['companyVipCustomer'] = $companyVipCustomer;
        return view('admin/company/vip_customer_company',$data);
    }
	
	
	
	  function getVipcompany()
    {
        $data = array();
         $companyid = $this->request->getGet('companyid');
        
       $data['companyid'] = $companyid;        
        $companyVipCustomer = array();
        $comVipCustomer = new VipCustomerModel();
        $arrSearch = array('customer_id'=>$companyid);
        $data['VipCompany'] = $comVipCustomer->getData($arrSearch);
		
		//echo "<pre>"; print_r($VipCompany );die;
        /*foreach($comVipCustomer as $vipDetails)
        {
            $companyVipCustomer[] = $vipDetails->customer_id;
        }*/
        //print_r($companyVipCustomer);
        //$data['companyVipCustomer'] = $companyVipCustomer;
        return view('admin/company/vip_company',$data);
    }
  function getorgCustomer()
    {
        $data = array();
         $companyid = $this->request->getGet('companyid');
        
       $data['companyid'] = $companyid;

     
        $OrgModel = new OrgModel();
    
        // $searchvipArray = array("onlyvipcustomer"=>1);
        $data['listss'] = $OrgModel->getData2();
        // $data['lists'] = json_decode(json_encode($data), true);

         // echo"<pre>";
         // print_r($data['lists']);exit;
         $companyVipCustomer = array();
        $comVipCustomer = new OrgCompanyModel();

        $arrSearch = array('company_id'=>$companyid);
        $comVipCustomer = $comVipCustomer->getData($arrSearch);

        foreach($comVipCustomer as $vipDetails)
        {
            $companyVipCustomer[] = $vipDetails->org_id;
        }
        //print_r($companyVipCustomer);
        $data['companyVipCustomer'] = $companyVipCustomer;
           // echo"<pre>";
           // print_r($comVipCustomer);exit;

        return view('admin/company/org_customer_company',$data);
    }
    public function add_org() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
       



        $OrgCompanyModel = new OrgCompanyModel;
        $companyid = $this->request->getPost('companyid');
        
        $vipid = $this->request->getPost('org');
        $OrgCompanyModel->where('company_id',$companyid)->delete();
       
        if($companyid && $vipid)
        {
            foreach($vipid as $vipcustomerid){

                $searchVipArray = array("company_id"=>$companyid,"org_id"=>$vipcustomerid);
                $isexist = $OrgCompanyModel->getData($searchVipArray,'','',1);
                if(!$isexist)
                {
                    $data1 = [
                        'company_id' => $companyid,
                        'org_id' => $vipcustomerid,
                    ];

                    $cid = $OrgCompanyModel->save($data1);
                }
                // else{
                //     $data1 = [
                //         'company_id' => $companyid,
                //         'customer_id' => $vipcustomerid,
                //     ];

                //     $cid = $vipModel->set($data1)->where('customer_id',$vipcustomerid)->delete();
                // }
            }
            $this->session->setFlashdata('message', 'Organization Customer Added Successfully!');
        }
        else
        {
            $this->session->setFlashdata('message', 'Organization Customer Not added!');
        }
                
                return redirect()->to(site_url('Company'));
        
        
    }
    function add_new() {
        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
        $categoryModel = New CategoryModel();
        $data['categories'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();
        $this->template->render('admintemplate', 'contents', 'admin/company/company_form', $data);
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
            'whatsapp' => $this->request->getVar('whatsapp'),
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

        $mallModel = new MallDetailsModel();
        $data['mall_list'] = $mallModel->findAll();
        //echo "<pre>";print_r($data['mall_list']);exit;

        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->findAll();
        //echo"<pre>"; print_r($data['discount_items']);die;

	   $siteVariables = new SiteVariables();
        $data['priorities'] = $siteVariables->getVariable('priority');

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

        $businessModel = new HomeBusinessModel();
        $data['businessdata'] = $businessModel->getHomebusinessData($id);

        if (!$data['companydetails']) {
            $this->session->setFlashdata('errmessage', 'Company Id Does not exist!');
            return redirect()->to(site_url('Company'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/company/edit_company', $data);
    }

    public function editonlineshop()
    {
        $company_id = $this->request->getGet("company_id");
        
        $companyModel = new CompanyModel();
        $companydetails= $companyModel->getCompanyID($company_id);
        $data['details'] = $companydetails;
        //print_r($companydetails);die;
        $this->template->render('admintemplate', 'contents', 'admin/company/onlineshop', $data);
    }
    //////////////////////////  edit code company ////////////////

    public function edit_code() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");
        $offer_id = $this->request->getGet("company_id");

        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->findAll();
		
		$siteVariables = new SiteVariables();
        $data['priorities'] = $siteVariables->getVariable('priority');

        $codeModel = new CodeModel();
        $data['details'] = $codeModel->getCodeID($id);

        $mallModel = new MallDetailsModel();
        $data['mall_list'] = $mallModel->findAll();

        $branchModel = new BranchModel();
        $data['all_branch'] = $branchModel->getBranch($id, $offer_id);
        $this->template->render('admintemplate', 'contents', 'admin/company/city_code', $data);
    }

    public function update() {
        /*echo "<pre>";print_r($this->request->getFiles());
        echo "<pre>";print_r($this->request->getVar());exit;*/
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
        $whatsapp = $this->request->getPost('whatsapp');
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
                $picture = $file->getRandomName();

                if ($file->move($userFolderpath, $picture)) {
                    $picture = $file->getName();
                }
            }
        }

        if ($company_arb_name!='') {
            $company_arb_name1=$company_arb_name;
        }else{
            $company_arb_name1='';
        }
        if ($password!=='****' && $password!='') {
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
                'whatsapp' => $whatsapp,
                'status' => $status,
                'updated_date' => date('Y-m-d H:i:s'),
                'address' => $address,

                'company_arb_name' => $company_arb_name1,
                'arb_username' => $arb_username,
                'display_arb_name' => $display_arb_name,
                'arb_address' => $arb_address,
                'arb_location' => $arb_location,
            );
        }else{
            $arrSaveData = array(
                'category' => $category,
                'company_name' => $company_name,
                'cr_number' => $cr_number,
                'username' => $username,
                'auth_contact' => $auth_contact,
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
                'whatsapp' => $whatsapp,
                'status' => $status,
                'updated_date' => date('Y-m-d H:i:s'),
                'address' => $address,

                'company_arb_name' => $company_arb_name1,
                'arb_username' => $arb_username,
                'display_arb_name' => $display_arb_name,
                'arb_address' => $arb_address,
                'arb_location' => $arb_location,
            );

        }
        if($picture)
        {
            $arrSaveData['picture'] = $picture;
        }
//        echo "<pre>";print_r($arrSaveData);exit;
        $newuserdata = $arrSaveData; //(array_filter($arrSaveData));
        $newuserdata['status'] = $arrSaveData['status']; //if status 0 it removed so added here
      //  print_r($newuserdata);die;
        $Update = $companyModel->where('id', $new_id)->set($newuserdata)->update();

        //////////// update banner ////////////

        $data7 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            if (isset($files['banner'])) {
                foreach ($files['banner'] as $img) {
                   if ($img->isValid() && !$img->hasMoved()) {
                         $finalimg= $img->getRandomName();
                         //echo "<pre>";print_r($img);exit;
                        if ($img->move(FCPATH . 'company/', $finalimg)) {

                            $data7 = [
                                'company_id' => $new_id,
                                'banner' => $finalimg,
                                'type' => 'banner'
                            ];
                            $imagefile = new CompanyDocFile();

                         // echo "<pre>";print_r($data7);exit;
                            $save = $imagefile->insert($data7);
                        }
                   }
                }
            }
        }

////////////////////////// update document ////////////////////

        $data8 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            if (isset($files['doc'])) {
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
        }


        

//////////////////////// insert branch name ///////////////////////

        $branch_name = $this->request->getVar('branch_name');
        $branch_atho_no = $this->request->getVar('brach_atho_no');
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
                'branch_autho_no' => $branch_atho_no,
                'arb_branch_name' => $arb_branch_name,
                'arb_branch_location' => $arb_branch_location,               
            ];
            $branch_id = $branchModel->insert($branchdata);
        }




        //////////////////////// insert home business ///////////////////////

        
        $b_description = $this->request->getVar('b_description');
        $home_business = $this->request->getVar('home_business');
        $b_arb_description = $this->request->getVar('b_arb_description');
        $b_mobile_no = $this->request->getVar('b_mobile_no');
        $b_whatsapp_no = $this->request->getVar('b_whatsapp_no');
        $instagram = $this->request->getVar('instagram');
        $b_email = $this->request->getVar('b_email');
        $b_location = $this->request->getVar('b_location');

        $b_arb_location = $this->request->getVar('b_arb_location');
        $arb_branch_location = $this->request->getVar('arb_branch_location');

        $businessModel = new HomeBusinessModel();
        
        /*$userRecord = $branchModel->usernameExist($branch_username);*/
        /*if ($userRecord > 0) {
            $this->session->setFlashdata('errmessage', 'Username Already Exist');
            return redirect()->to(site_url('EditCompany?id=' . $new_id));
        }*/


        if ($home_business!='') {
            if ((!empty($b_email)) || (!empty($b_mobile_no)) || (!empty($b_description)) || (!empty($b_arb_description)) || (!empty($b_whatsapp_no))  || (!empty($instagram)) || (!empty($b_location)) || (!empty($b_arb_location)) || (!empty($picture)) ) {

                $businessdata = [
                    'company_id' => $new_id,
                    'description' => $b_description,
                    'arb_description' => $b_arb_description,
                    'h_mobile_no' => $b_mobile_no,
                    'h_whatsapp_no' => $b_whatsapp_no,
                    'h_instagram' => $instagram,
                    'h_location' => $b_location,
                    'h_arb_location' => $b_arb_location,               
                    'h_email' => $b_email,
                    'h_image' => $picture,
                    'coupon_type' => 'homebusiness',
                ];
                 $codeModel = new CodeModel();
                $code_id = $codeModel->insert($businessdata);
            }else{

                $this->session->setFlashdata('errmessage', 'please Enter  Data.');
                return redirect()->to(site_url('EditCompany?id=' . $new_id));
            }
        }

        $data9 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            //echo "in";exit;
            //echo "<pre>";print_r($files);
            if (isset($files['business'])) {
                foreach ($files['business'] as $img) {
                  //  echo 'in';exit;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $picture = $img->getClientName();
                        if ($img->move(FCPATH . 'company/')) {

                            $data9 = [
                                'company_id' => $new_id,
                                'doc' => $img->getClientName(),
                                'type' => 'business',
                                'business_id' => $code_id
                            ];
                            $imagefile = new CompanyDocFile();
                            $save = $imagefile->insert($data9);
                        }
                    }
                }
            }
        }


        ///////////////////////// update discount type  ///////////////////////		
        $c_branch = $this->request->getVar('c_branch');
        $mall = $this->request->getVar('mall');
        $mall_name = $this->request->getVar('mall_name');
        $mall_name_arabic = $this->request->getVar('mall_name_arabic');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $offer_name = $this->request->getVar('offer_name');
        $offer_name_arabic = $this->request->getVar('offer_name_arabic');
        $offer_p = $this->request->getVar('offer_p');
        $c_description = $this->request->getVar('c_description');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');
		$c_priority = $this->request->getVar('c_priority');
		$c_priority_start = $this->request->getVar('c_priority_start');
		$c_priority_end = $this->request->getVar('c_priority_end');

        $fam_branch = $this->request->getVar('fam_branch');
        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');
		$fam_priority = $this->request->getVar('fam_priority');
		$fam_priority_start = $this->request->getVar('fam_priority_start');
		$fam_priority_end = $this->request->getVar('fam_priority_end');

        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');
		$fri_priority = $this->request->getVar('fri_priority');
		$fri_priority_start = $this->request->getVar('fri_priority_start');
		$fri_priority_end = $this->request->getVar('fri_priority_end');

        $c_arb_description = $this->request->getVar('c_arb_description');
        $fam_arb_description = $this->request->getVar('fam_arb_description');
        $fri_arb_description = $this->request->getVar('fri_arb_description');


        if ($mall!='') {
           $fmall =$mall;
        }else{
           $fmall = "No";
        }

        if ($fri_priority!='') {
           $ffri_priority =$fri_priority;
        }else{
           $ffri_priority = "priority-99";
        }

        if ($c_priority!='') {
           $cc_priority =$c_priority;
        }else{
           $cc_priority = "priority-99";
        }

       


        if ($fam_priority!='') {
           $ffam_priority =$fam_priority;
        }else{
           $ffam_priority = "priority-99";
        }

        
        $site_id='';
        $siteval = array();
        if ($offer_p!='') {
           $siteval=[
            'st_name'=>$offer_name,
            'st_arb_name'=>$offer_name_arabic,
            'st_group'=>'discounttype',
           ];
           $sitemodel = new SitevariableModel();
           $sitemodel->insert($siteval);
           $site_id = $sitemodel->getInsertID();
        }else{
            $offer_p='';
        }


        if ($c_disc_detail!='' && $offer_p=='') {
           $c_disc_detail1 = $c_disc_detail;
        }else{
           $c_disc_detail1 = $site_id;
        }

        if ($fam_disc_detail!='' && $offer_p=='') {
           $fam_disc_detail1 = $fam_disc_detail;
        }else{
           $fam_disc_detail1 = $site_id;
        }

        if ($fri_disc_detail!='' && $offer_p=='') {
           $fri_disc_detail1 = $fri_disc_detail;
        }else{
           $fri_disc_detail1 = $site_id;
        }

       
       




        if (!empty($c_branch)) {

            $data = [
                'company_id' => $new_id,
                'branch_id' => $c_branch,
                'company_discount' => $company_discount,
                'comission' => $comission,
                'customer_discount' => $customer_discount,
                'discount_detail' => $c_disc_detail1,
                'description' => $c_description,
                'arb_description' => $c_arb_description,
                'start_date' => $c_start,
                'end_date' => $c_end,
                'coupon_type' => 'city',
				'priority' => $cc_priority,
				'priority_start' => $c_priority_start,
				'priority_end' => $c_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                //'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
            ];
            
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
                'discount_detail' => $fam_disc_detail1,
                'start_date' => $fam_start,
                'end_date' => $fam_end,
                'coupon_type' => 'vip',
				'priority' => $ffam_priority,
				'priority_start' => $fam_priority_start,
				'priority_end' => $fam_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                // 'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
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
                'discount_detail' => $fri_disc_detail1,
                'start_date' => $fri_start,
                'end_date' => $fri_end,
                'coupon_type' => 'friday',
				'priority' => $ffri_priority,
				'priority_start' => $fri_priority_start,
				'priority_end' => $fri_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                // 'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
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

        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();


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
        $this->template->render('admintemplate', 'contents', 'admin/company/companydetails', $data);
    }

    public function add_vip() {
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $vipModel = new VipCustomerModel;
        $companyid = $this->request->getPost('companyid');
        $vipid = $this->request->getPost('vip');
        $vipModel->where('company_id',$companyid)->delete();

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


    /////////////delete business images///////////////////////


    public function delete_business_image() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        if ($isAdminLoggedIn) {
            $docModel = new CompanyDocFile();
            $docModel->where('id', $id)->delete();
            $this->session->setFlashdata('message', ' Image Deleted Successfully.');
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
        $mall = $this->request->getVar('mall');
        $mall_name = $this->request->getVar('mall_name');
        $mall_name_arabic = $this->request->getVar('mall_name_arabic');
        $mall_name = $this->request->getVar('mall_name');
        $offer_name = $this->request->getVar('offer_name');
        $offer_name_arabic = $this->request->getVar('offer_name_arabic');
        $offer_p = $this->request->getVar('offer_p');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $c_description = $this->request->getVar('c_description');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');
		$c_priority = $this->request->getVar('c_priority');
		$c_priority_start = $this->request->getVar('c_priority_start');
		$c_priority_end = $this->request->getVar('c_priority_end');

        $fam_branch = $this->request->getVar('fam_branch');
        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');
		$fam_priority = $this->request->getVar('fam_priority');
		$fam_priority_start = $this->request->getVar('fam_priority_start');
		$fam_priority_end = $this->request->getVar('fam_priority_end');

        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');
		$fri_priority = $this->request->getVar('fri_priority');
		$fri_priority_start = $this->request->getVar('fri_priority_start');
		$fri_priority_end = $this->request->getVar('fri_priority_end');

        $c_arb_description = $this->request->getVar('c_arb_description');
        $fam_arb_description = $this->request->getVar('fam_arb_description');
        $fri_arb_description = $this->request->getVar('fri_arb_description');

        if ($mall!='') {
           $fmall =$mall;
        }else{
           $fmall = "No";
        }


        if ($c_priority!='') {
           $cc_priority =$c_priority;
        }else{
           $cc_priority = "priority-99";
        }

        if ($fri_priority!='') {
           $ffri_priority =$fri_priority;
        }else{
           $ffri_priority = "priority-99";
        }


        if ($fam_priority!='') {
           $ffam_priority =$fam_priority;
        }else{
           $ffam_priority = "priority-99";
        }


        $site_id='';
        $siteval = array();
        if ($offer_p!='') {
           $siteval=[
            'st_name'=>$offer_name,
            'st_arb_name'=>$offer_name_arabic,
            'st_group'=>'discounttype',
           ];
           $sitemodel = new SitevariableModel();
           $sitemodel->insert($siteval);
           $site_id = $sitemodel->getInsertID();
        }


        if ($c_disc_detail!='' && $offer_p=='') {
           $c_disc_detail1 = $c_disc_detail;
        }else{
           $c_disc_detail1 = $site_id;
        }

        if ($fam_disc_detail!='' && $offer_p=='') {
           $fam_disc_detail1 = $fam_disc_detail;
        }else{
           $fam_disc_detail1 = $site_id;
        }

        if ($fri_disc_detail!='' && $offer_p=='') {
           $fri_disc_detail1 = $fri_disc_detail;
        }else{
           $fri_disc_detail1 = $site_id;
        }

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
				'priority' => $cc_priority,
				'priority_start' => $c_priority_start,
				'priority_end' => $c_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                //'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
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
				'priority' => $ffam_priority,
				'priority_start' => $fam_priority_start,
				'priority_end' => $fam_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
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
				'priority' => $ffri_priority,
				'priority_start' => $fri_priority_start,
				'priority_end' => $fri_priority_end,
                'mall' => $fmall,
                'mall_name' => $mall_name,
                'mall_name_arabic' => $mall_name_arabic,
                'custmise' => $offer_p,
                'offer_name_cust'=>$offer_name,
                'offer_name_cust_arabic'=>$offer_name_arabic,
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
        //echo"<pre>"; print_r($data['branchdata']);die();

        $branchModel = new BranchModel();
        $cityModel = new CityModel();
        $data['city_cities'] = $branchModel->getBranchCity($cid);
        $data['branchdata'] = $branchModel->getBranchId($cid);
        $this->template->render('admintemplate', 'contents', 'admin/company/edit_branch', $data);
    }


    public function edit_business() {
       // echo "<pre>";print_r($this->request->getGet());
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $bid = $this->request->getGet("id");
        $businessModel = new HomeBusinessModel();
        $docModel = new CompanyDocFile();
        $data['h_images'] = $docModel->getImagesFile($bid);
        $codeModel = new CodeModel();
        $data['businessdata'] = $codeModel->getCodeID($bid);
        
       // echo"<pre>"; print_r($data['businessdata']);die();
        $this->template->render('admintemplate', 'contents', 'admin/company/edit_business', $data);
    }


    public function delete_business() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $businessModel = new HomeBusinessModel();

        if ($isAdminLoggedIn) {
            $businessModel->where('business_id', $id)->delete();

            $this->session->setFlashdata('message', 'Deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }





    ///////////////// update branch ///////////////////

    public function update_branch() {
        //echo '<pre>';print_r($this->request->getVar());exit;
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
        $yesno = $this->request->getPost('yesno');
        if ($yesno=='on') {
             $fast_delivery = (isset($_POST['fast_delivery']) && !empty($_POST['fast_delivery'])) ? $this->request->getPost('fast_delivery') : '';
              $special_delivery = (isset($_POST['special_delivery']) && !empty($_POST['special_delivery'])) ? $this->request->getPost('special_delivery') : '';
        }

        $branch_name = $this->request->getVar('branch_name');
        $brach_atho_no = $this->request->getVar('brach_atho_no');
        $branch_username = $this->request->getVar('branch_username');
        $branch_password = $this->request->getVar('branch_password');
        $state = $this->request->getVar('state');
        $city = $this->request->getVar('city');
        $location = $this->request->getVar('location');

         $arb_branch_name = $this->request->getVar('arb_branch_name');

        $latitude = $this->request->getVar('latt');
        $longitude = $this->request->getVar('lngg');

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
                'state' => $state,
                'city' => $city,
                'location' => $location,
                'branch_autho_no' => $brach_atho_no,

                'arb_branch_name' => $arb_branch_name,
                // 'arb_branch_location' => $arb_branch_location,
                'latitude' => $latitude,
                'longitude' => $longitude,
                 'fast_delivery_charges' => (isset($fast_delivery) && !empty($fast_delivery)) ? $fast_delivery : '',               
                'special_delivery_charges' => (isset($special_delivery) && !empty($special_delivery)) ? $special_delivery : '',
            ];    
            
            if($branch_password && $branch_password !=1111)
            {
                $updateCityCode['branch_password'] = password_hash($branch_password, 1);
            }
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


    //////////////////////// Update Home business model////////////////


    public function update_business() {

        //echo "<pre>";print_r($this->request->getPost());exit;

        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $business_id = $this->request->getPost('business_id');
        if (!$business_id) {
            $this->session->setFlashdata('errmessage', 'Branch Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $b_description = $this->request->getVar('b_description');
        $b_arb_description = $this->request->getVar('b_arb_description');
        $b_mobile_no = $this->request->getVar('b_mobile_no');
        $b_whatsapp_no = $this->request->getVar('b_whatsapp_no');
        $instagram = $this->request->getVar('instagram');
        $b_email = $this->request->getVar('b_email');
        $b_location = $this->request->getVar('b_location');
        $b_arb_location = $this->request->getVar('b_arb_location');
        $company_id = $this->request->getVar('company_id');

      

        if (($b_mobile_no != '') || ($b_email != '')  || $b_description!='' || $b_arb_description!='' || $b_whatsapp_no!=''  || $instagram!='' || $b_location!='' || $b_arb_location!='') {

            $data9 = [];
            if ($this->request->getFiles()) {
                $files = $this->request->getFiles();
                //echo "in";exit;
                //echo "<pre>";print_r($files);
                if (isset($files['business'])) {
                    foreach ($files['business'] as $img) {
                      //  echo 'in';exit;
                        if ($img->isValid() && !$img->hasMoved()) {
                            if ($img->move(FCPATH . 'company/')) {

                                $data9 = [
                                    'company_id' => $company_id,
                                    'doc' => $img->getClientName(),
                                    'type' => 'business',
                                    'business_id' => $business_id
                                ];
                                $imagefile = new CompanyDocFile();
                                $save = $imagefile->insert($data9);
                            }
                        }
                    }
                }
            }

            $updatebusiness = [
                'description' => $b_description,
                'arb_description' => $b_arb_description,
                'h_mobile_no' => $b_mobile_no,
                'h_whatsapp_no' => $b_whatsapp_no,
                'h_instagram' => $instagram,
                'h_email' => $b_email,
                'h_location' => $b_location,
                'h_arab_location' => $b_arb_location,
            ];            
           // $businessModel->where('business_id', $business_id)->set($updatebusiness)->update();
            $codeModel = new CodeModel();
            $codeModel->where('id', $business_id)->set($updatebusiness)->update();
        }else{
            $this->session->setFlashdata('errmessage', 'Please Enter Data.');
            return redirect()->to(site_url('EditBusiness?id=' . $business_id));
        }

        if ($business_id) {
            $this->session->setFlashdata('message', 'Updated successfully.');
            return redirect()->to(site_url('EditBusiness?id=' . $business_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditBusiness?id=' . $business_id));
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
		
        //if ((!empty($online_description)) && $online_description != '') {
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
        //}
		
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
public function addBranch(){
        //////////////////////// insert branch name ///////////////////////
         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $yesno = $this->request->getPost('yesno');
        if ($yesno=='on') {
             $fast_delivery = (isset($_POST['fast_delivery']) && !empty($_POST['fast_delivery'])) ? $this->request->getPost('fast_delivery') : '';
              $special_delivery = (isset($_POST['special_delivery']) && !empty($_POST['special_delivery'])) ? $this->request->getPost('special_delivery') : '';
        }
      
        $new_id = $this->request->getPost('new_id');
        $branch_name = $this->request->getVar('branch_name');
        $branch_atho_no = $this->request->getVar('brach_atho_no');
        $branch_username = $this->request->getVar('branch_username');
        $branch_password = $this->request->getVar('branch_password');
        $state = $this->request->getVar('state');
        $city = $this->request->getVar('city');
        $location = $this->request->getVar('location');

        $arb_branch_name = $this->request->getVar('arb_branch_name');
        $latitude = $this->request->getVar('latt');
        $longitude = $this->request->getVar('lngg');
        // $arb_branch_location = $this->request->getVar('arb_branch_location');

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
                'branch_autho_no' => $branch_atho_no,
                'arb_branch_name' => $arb_branch_name,
                // 'arb_branch_location' => $arb_branch_location,               
                'latitude' => $latitude,               
                'longitude' => $longitude,               
                'fast_delivery_charges' => (isset($fast_delivery) && !empty($fast_delivery)) ? $fast_delivery : '',               
                'special_delivery_charges' => (isset($special_delivery) && !empty($special_delivery)) ? $special_delivery : '',               
            ];
        
            $branch_id = $branchModel->insert($branchdata);
        $this->session->setFlashdata('message', 'New Branch Created successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
       return redirect()->to(site_url('EditCompany?id=' . $new_id));
    }
    public function addPublicoffer(){
        //////////////////////// insert branch name ///////////////////////
         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

       //////////// insert in company_code_details /////////    

        
        $new_id = $this->request->getPost('new_id');
        //echo "<pre>"; print_r($this->request->getVar()); die;
        $c_branch = $this->request->getVar('c_branch');
        $company_discount = $this->request->getVar('company_discount');
        $comission = $this->request->getVar('comission');
        $customer_discount = $this->request->getVar('customer_discount');
        $c_disc_detail = $this->request->getVar('c_disc_detail');
        $c_description = $this->request->getVar('c_description');
        $c_arb_description = $this->request->getVar('c_arb_description');
 $mall = $this->request->getVar('mall');
        $c_start = $this->request->getVar('c_start');
        $c_end = $this->request->getVar('c_end');

        $c_priority = $this->request->getVar('c_priority');
        $c_priority_start = $this->request->getVar('c_priority_start');
        $c_priority_end = $this->request->getVar('c_priority_end');
        $mall_name = $this->request->getVar('mall_name');
       
    


        if ((!empty($c_branch)) && ($c_branch != '')) {
            $data = [
                'company_id' => $new_id,
                'branch_id' => $c_branch,
'mall' => $mall,
                'company_discount' => $company_discount,
                'comission' => $comission,
                'customer_discount' => $customer_discount,
                'discount_detail' => $c_disc_detail,
                'description' => $c_description,
                'arb_description' => $c_arb_description,
                'start_date' => $c_start,
                'end_date' => $c_end,
                'priority' => $c_priority,
                'priority_start' => $c_priority_start,
                'priority_end' => $c_priority_end,
                'mall_name' => $mall_name,
                
                'coupon_type' => 'city',
            ];


            $codes = new CodeModel();
            $code_id = $codes->insert($data);

            $this->session->setFlashdata('message', 'New Public Offer Created successfully.');
            //print_r($code_id);die();
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
         return redirect()->to(site_url('EditCompany?id=' . $new_id));
     
    }
    public function addvip(){
    
         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

      

        
        $new_id = $this->request->getPost('new_id');
        //echo "<pre>"; print_r($this->request->getVar()); die;
       $fam_branch = $this->request->getVar('fam_branch');

        $fam_company_discount = $this->request->getVar('fam_company_discount');
        $fam_comission = $this->request->getVar('fam_comission');
        $fam_customer_discount = $this->request->getVar('fam_customer_discount');
        $fam_disc_detail = $this->request->getVar('fam_disc_detail');
        $fam_description = $this->request->getVar('fam_description');
        $fam_arb_description = $this->request->getVar('fam_arb_description');
        $fam_start = $this->request->getVar('fam_start');
        $fam_end = $this->request->getVar('fam_end');

        $fam_priority = $this->request->getVar('fam_priority');
        $fam_priority_start = $this->request->getVar('fam_priority_start');
        $fam_priority_end = $this->request->getVar('fam_priority_end');
        $mall = $this->request->getVar('mall');
        $mall_name = $this->request->getVar('mall_name');
    


        if ((!empty($fam_branch)) && ($fam_branch != '')) {
            $data = [
                'company_id' => $new_id,
                'branch_id' => $fam_branch,
                'company_discount' => $fam_company_discount,
                'comission' => $fam_comission,
                'customer_discount' => $fam_customer_discount,
                'discount_detail' => $fam_disc_detail,
                'description' => $fam_description,
                'arb_description' => $fam_arb_description,
                'start_date' => $fam_start,
                'end_date' => $fam_end,
                'priority' => $fam_priority,
                'priority_start' => $fam_priority_start,
                'priority_end' => $fam_priority_end,
                'mall_name' => $mall_name,
                'mall' => $mall,
                'coupon_type' => 'vip',
            ];


            $codes = new CodeModel();
            $code_id = $codes->insert($data);
            if ($code_id != '') {
            $updateData = array(
                'vip_link' => 'vip',
            );
             $companyModel = new CompanyModel();
            $Update = $companyModel->where('id', $new_id)->set($updateData)->update();
        }
            $this->session->setFlashdata('message', 'New V.I.P Offer Created successfully.');
            //print_r($code_id);die();
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
         return redirect()->to(site_url('EditCompany?id=' . $new_id));
     
    }
     public function addFridayCode(){

         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

  
        
        $new_id = $this->request->getPost('new_id');
        //echo "<pre>"; print_r($this->request->getVar()); die;
        $fri_branch = $this->request->getVar('fri_branch');
        $fri_company_discount = $this->request->getVar('fri_company_discount');
        $fri_comission = $this->request->getVar('fri_comission');
        $fri_customer_discount = $this->request->getVar('fri_customer_discount');
        $fri_disc_detail = $this->request->getVar('fri_disc_detail');
        $fri_description = $this->request->getVar('fri_description');
        $fri_arb_description = $this->request->getVar('fri_arb_description');
        $fri_start = $this->request->getVar('fri_start');
        $fri_end = $this->request->getVar('fri_end');
        $fri_priority = $this->request->getVar('fri_priority');
        $fri_priority_start = $this->request->getVar('fri_priority_start');
        $fri_priority_end = $this->request->getVar('fri_priority_end');
        $mall = $this->request->getVar('mall');
        $mall_name = $this->request->getVar('mall_name');
    


        if ((!empty($fri_branch)) && ($fri_branch != '')) {
            $data = [
                'company_id' => $new_id,
                'branch_id' => $fri_branch,
                'company_discount' => $fri_company_discount,
                'comission' => $fri_comission,
                'customer_discount' => $fri_customer_discount,
                'discount_detail' => $fri_disc_detail,
                'description' => $fri_description,
                'arb_description' => $fri_arb_description,
                'start_date' => $fri_start,
                'end_date' => $fri_end,
                'priority' => $fri_priority,
                'priority_start' => $fri_priority_start,
                'priority_end' => $fri_priority_end,
                'mall_name' => $mall_name,
                'mall' => $mall,
                'coupon_type' => 'friday',
            ];


            $codes = new CodeModel();
            $code_id = $codes->insert($data);
            $this->session->setFlashdata('message', 'New Friday Code Offer Created successfully.');
            //print_r($code_id);die();
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
         return redirect()->to(site_url('EditCompany?id=' . $new_id));
     
    }
    
     public function homeBusiness(){

         $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

  
        
        $new_id = $this->request->getPost('new_id');
        //echo "<pre>"; print_r($this->request->getVar()); die;
        $b_description = $this->request->getVar('b_description');
        $home_business = $this->request->getVar('home_business');
        $b_arb_description = $this->request->getVar('b_arb_description');
        $b_mobile_no = $this->request->getVar('b_mobile_no');
        $b_whatsapp_no = $this->request->getVar('b_whatsapp_no');
        $instagram = $this->request->getVar('instagram');
        $b_email = $this->request->getVar('b_email');
        $b_location = $this->request->getVar('b_location');

        $b_arb_location = $this->request->getVar('b_arb_location');
        $arb_branch_location = $this->request->getVar('arb_branch_location');
        $businessModel = new HomeBusinessModel();
    


        if ($home_business!='') {
            if ((!empty($b_email)) || (!empty($b_mobile_no)) || (!empty($b_description)) || (!empty($b_arb_description)) || (!empty($b_whatsapp_no))  || (!empty($instagram)) || (!empty($b_location)) || (!empty($b_arb_location))) {

                $businessdata = [
                    'company_id' => $new_id,
                    'description' => $b_description,
                    'arb_description' => $b_arb_description,
                    'h_mobile_no' => $b_mobile_no,
                    'h_whatsapp_no' => $b_whatsapp_no,
                    'h_instagram' => $instagram,
                    'h_location' => $b_location,
                    'h_arab_location' => $b_arb_location,               
                    'h_email' => $b_email,
                    // 'h_image' => $picture,
                    'coupon_type' => 'homebusiness',
                ];
                 $codeModel = new CodeModel();
                $code_id = $codeModel->insert($businessdata);
                $this->session->setFlashdata('message', 'New Home Business Created successfully.');
            }else{

                $this->session->setFlashdata('errmessage', 'please Enter  Data.');
                return redirect()->to(site_url('EditCompany?id=' . $new_id));
            }
        }

        $data9 = [];
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            //echo "in";exit;
            //echo "<pre>";print_r($files);
            if (isset($files['business'])) {
                foreach ($files['business'] as $img) {
                  //  echo 'in';exit;
                    if ($img->isValid() && !$img->hasMoved()) {
                        $picture = $img->getClientName();
                        if ($img->move(FCPATH . 'company/')) {

                            $data9 = [
                                'company_id' => $new_id,
                                'doc' => $img->getClientName(),
                                'type' => 'business',
                                'business_id' => $code_id
                            ];
                            $imagefile = new CompanyDocFile();
                            $save = $imagefile->insert($data9);
                        }
                    }
                }
            }
        }
         return redirect()->to(site_url('EditCompany?id=' . $new_id));
     
    }

}

?>
