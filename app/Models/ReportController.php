<?php

namespace App\Controllers;

use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\CategoryModel;
use App\Models\BranchModel;
use App\Models\OrdersModel;
use App\Models\CompanyDocFile;
use App\Libraries\Paginationnew;
use App\Models\SitevariableModel;

class ReportController extends BaseController {

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
        $data['pageurl'] = "reports";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $customerModel = new CustomerModel();
       
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $coupon_type = $this->request->getGet('coupon_type');

        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
            //$searchArray['company_name'] = '';
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
        if($mobile){
            $searchArray['mobile'] = $mobile;
        }
        if($gender){
            $searchArray['gender'] = $gender;
        }        
        if($city_code) {
            $searchArray['city_code'] = $city_code;
        }		
	if($vip_code){
            $searchArray['vip_code'] = $vip_code;
        }
        if($stateid) {
            $searchArray['stateid'] = $stateid;
        }        
        if($cityid) {
            $searchArray['cityid'] = $cityid;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type){
        $totalRecord = $customerModel->getData($searchArray, '', '', '1');
        $customers = $customerModel->getData($searchArray, $startLimit, $Limit);
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
         
        if($company_id =='city_code') {
            $searchArray['company_id'] = 'city_code';
        }
        
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['customers'] = $customers;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/customerlist',$data);
    }
    
    function adminCompanyReport() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "acomapnyreports";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        
        $compModel = new CompanyModel();
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $coupon_type = $this->request->getGet('coupon_type');

        if($start_date) {
            $searchArray['start_date'] = $start_date ;
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
        if($mobile){
            $searchArray['mobile'] = $mobile;
        }
        if($gender){
            $searchArray['gender'] = $gender;
        }        
        if($city_code) {
            $searchArray['city_code'] = $city_code;
        }		
	if($vip_code){
            $searchArray['vip_code'] = $vip_code;
        }
        if($stateid) {
            $searchArray['stateid'] = $stateid;
        }        
        if($cityid) {
            $searchArray['cityid'] = $cityid;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $searchArray['id'] = $company_id;
        }
        
        
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$companylist = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type){
        $totalRecord = $compModel->getDataAll($searchArray, '', '', '1');
        $companylist = $compModel->getDataAll($searchArray, $startLimit, $Limit);
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      if($company_id =='city_code') {
            $searchArray['company_id'] = 'city_code';
        }
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['companylist'] = $companylist;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/companylist',$data);
    }
    
    function adminOfferReport() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "aofferreports";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        
        $codeModel = new CodeModel();
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $coupon_type = $this->request->getGet('coupon_type');

        if($start_date) {
            $searchArray['start_date'] = $start_date ;
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
        if($mobile){
            $searchArray['mobile'] = $mobile;
        }
        if($gender){
            $searchArray['gender'] = $gender;
        }        
        if($city_code) {
            $searchArray['city_code'] = $city_code;
        }		
	if($vip_code){
            $searchArray['vip_code'] = $vip_code;
        }
        if($stateid) {
            $searchArray['stateid'] = $stateid;
        }        
        if($cityid) {
            $searchArray['cityid'] = $cityid;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$offerslist = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type){
        $totalRecord = $codeModel->getDataAll($searchArray, '', '', '1');
        $offerslist = $codeModel->getDataAll($searchArray, $startLimit, $Limit);
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
         if($company_id =='city_code') {
            $searchArray['company_id'] = "city_code";
        }
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['offerslist'] = $offerslist;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/offerslist',$data);
    }
    
    function adminTransactionReport() {
        
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "atransactionreports";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        
        $orderModel = new OrdersModel();
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $coupon_type = $this->request->getGet('coupon_type');

        if($start_date) {
            $searchArray['start_date'] = $start_date ;
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
        if($mobile){
            $searchArray['mobile'] = $mobile;
        }
        if($gender){
            $searchArray['gender'] = $gender;
        }        
        if($city_code) {
            $searchArray['city_code'] = $city_code;
        }		
	if($vip_code){
            $searchArray['vip_code'] = $vip_code;
        }
        if($stateid) {
            $searchArray['stateid'] = $stateid;
        }        
        if($cityid) {
            $searchArray['cityid'] = $cityid;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$transactionsList = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type){
        $totalRecord = $orderModel->getData($searchArray, '', '', 1);
        $transactionsList = $orderModel->getData($searchArray, $startLimit, $Limit,'');
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
         
        $searchArray['sumcommision'] = 1;
        $data['totalcommision'] = $orderModel->getData($searchArray,'','');
      
        if( $company_id =='city_code') {
            $searchArray['company_id'] = "city_code";
        }
       
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['transactionsList'] = $transactionsList;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/transactionsList',$data);
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

/////////////////// view detail ///////////////

    public function report_details() {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");
        //echo "<pre>";print_r($this->request->getGet());exit;


        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();

        $categoryModel = New CategoryModel();
        $data['interests'] = $categoryModel->orderBy('cat_id', 'ASC')->findAll();

        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();
        // echo "<pre>";print_r($data['cities']);exit;

        $od_id = $this->request->getGet("od_id");
        $orderModel = new OrdersModel();
        $data['order'] = $orderModel->reportdetail($od_id); // return count value
        // echo "<pre>";print_r($data['order']->od_userid);exit;

        $customerModel = new CustomerModel();
        $data['customer'] = $customerModel->getCustomerID($data['order']->od_userid); // return count value

        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->orderBy('country_enName', 'ASC')->findAll();

        ////////////////// for company ////////////
        $company_id = $this->request->getGet("company_id");
        $companyModel = new CompanyModel();
        $data['companydetails'] = $companyModel->getCompanyID($company_id);

        $offer_id = $this->request->getGet("offer_id");
        $codeModel = new CodeModel();
        $data['code_details'] = $codeModel->getCodeID($offer_id);
        $data['offer_details'] = $codeModel->getCodeIDs($company_id);

        $branchModel = new BranchModel();
        $data['branch_details'] = $branchModel->getBranchData($company_id);
        $data['all_branch'] = $branchModel->orderBy('branch_id', 'ASC')->findAll();

        $docModel = new CompanyDocFile();
        $data['banners'] = $docModel->getBanner($id);
        $data['docss'] = $docModel->getDocFile($id);
        $siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();

        $this->template->render('admintemplate', 'contents', 'admin/reportdetail', $data);
    }

}

?>
