<?php

namespace App\Controllers;

use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\CustomerImpressionModel;
use App\Models\CategoryModel;
use App\Models\BranchModel;
use App\Models\OrdersModel;
use App\Models\CompanyDocFile;
use App\Models\ChatModel;
use App\Models\couponPurchaseModel;
use App\Models\CouponModel;
use App\Models\assignCouponAmount;
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

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
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
        $branch_id = $this->request->getGet('branch_id');
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
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
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

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
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
        $branch_id = $this->request->getGet('branch_id');
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
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $searchArray['id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
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

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
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
        $branch_id = $this->request->getGet('branch_id');
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
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
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

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
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
        $branch_id = $this->request->getGet('branch_id');
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
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
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
        $data['totalcommision'] = $orderModel->getData($searchArray);
        
        unset($searchArray['sumcommision']);
        $searchArray['sumpaidamount'] = 1;
       
        $data['totalpaidamount'] = $orderModel->getData($searchArray);
         unset($searchArray['sumpaidamount']);
        if( $company_id =='city_code') {
            $searchArray['company_id'] = "city_code";
        }
       
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['transactionsList'] = $transactionsList;
        // echo"<pre>";
        // print_r($data['transactionsList']);exit;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/transactionsList',$data);
    }
    
    function delTransaction() {
        $responseData = array("sucess"=>false,"data"=>"");
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
         $od_id = $this->request->getGet('od_id');
         
         if($od_id)
         {
              $orderModel = new OrdersModel();
              $orderModel->where('od_id', $od_id)->delete();
             
              $responseData['sucess'] = true;
               
         }
         echo json_encode($responseData);die;
    }
    
    
    
    function adminOtherReport() {
        
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "atransactionreports";
    	
        $mostpopulardetail = array("city_code"=>0,'name'=>'','gender'=>'');
        $orderModel = new OrdersModel();
        $customerModel = new CustomerModel();
        
        $mostpopularuser = $orderModel->getMostPopularcode(0,1);
        if($mostpopularuser)
        {
            $customerdetail = $customerModel->getProfile($mostpopularuser[0]->od_userid);
            
            if($customerdetail)
            {
                $mostpopulardetail['city_code'] =$customerdetail[0]->city_code;
                $mostpopulardetail['name'] =$customerdetail[0]->name;
                $mostpopulardetail['gender'] =$customerdetail[0]->gender;
            }
        }
        
        $data['mostpopularuser'] = $mostpopulardetail;
        
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/otherreport',$data);
    }

    function topPurchaseCustomer() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "toppurchasecutomers";
    	
        
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches']  = array();
        $customerModel = new CustomerModel();
       
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('order_start_date');
        $end_date = $this->request->getGet('order_end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $branch_id = $this->request->getGet('branch_id');
        $coupon_type = $this->request->getGet('coupon_type');
        $sales_purchase = $this->request->getGet('sales_purchase');
        

        if($start_date) {
            $searchArray['order_start_date'] = $start_date ? $start_date : "";
          
        }
        if($end_date) {
           $searchArray['order_end_date'] = $end_date;
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
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }
        if($sales_purchase){
            $searchArray['sales_purchase'] = $sales_purchase;
            $searchArray['order_count'] = $sales_purchase;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type || $sales_purchase){
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
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/toppurchagecustomerlist',$data);
    }
    
    
    function topSalesCompany() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "topsalecompany";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
        $compModel = new CompanyModel();
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('order_start_date');
        $end_date = $this->request->getGet('order_end_date');
        $mobile = $this->request->getGet('mobile');
        $gender = $this->request->getGet('gender');
        $city_code = $this->request->getGet('city_code');
    	$vip_code = $this->request->getGet('vip_code');  
        $stateid = $this->request->getGet('stateid');
        $cityid = $this->request->getGet('cityid');
        $company_id = $this->request->getGet('company_id');
        $branch_id = $this->request->getGet('branch_id');
        $coupon_type = $this->request->getGet('coupon_type');
        $sales_purchase = $this->request->getGet('sales_purchase');

        if($start_date) {
            $searchArray['order_start_date'] = $start_date ;
        }
        if($end_date) {
           $searchArray['order_end_date'] = $end_date;
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
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $searchArray['id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        
        
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }
        // for count order of company
        if($sales_purchase) {
           $searchArray['sales_purchase'] = $sales_purchase;
            $searchArray['order_count'] = $sales_purchase;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$companylist = array();
        
        if($start_date || $end_date || $mobile || $gender || $city_code || $stateid ||$cityid || $company_id || $coupon_type || $sales_purchase){
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
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/topsalecompanylist',$data);
    }
    
    
    function appViewCustomer() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "appviewcutomer";
    	$stateModel = new StateModel();
    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

//        $companyModel = new CompanyModel();
//        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

//        $branchModel = new BranchModel();
//        $data['branches']  = array();
        
        $customerImpressionModel = new CustomerImpressionModel();
       
        
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
        $branch_id = $this->request->getGet('branch_id');
        $coupon_type = $this->request->getGet('coupon_type');
        $sales_purchase = $this->request->getGet('sales_purchase');
        

        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
          
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
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }
        if($sales_purchase){
            $searchArray['sales_purchase'] = $sales_purchase;
            $searchArray['order_count'] = $sales_purchase;
        }

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        
        $totalRecord = $customerImpressionModel->getData($searchArray, '', '', '1');
        $customers = $customerImpressionModel->getData($searchArray, $startLimit, $Limit);
        
        
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
         
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['customers'] = $customers;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/appviewcustomerlist',$data);
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
    
    
    function chatReport() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "chatreport";
        
//    	$stateModel = new StateModel();
//    	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
//
//        $cityModel = new CityModel();
//    	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
        $customerModel = new ChatModel();
       
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $company_id = $this->request->getGet('company_id');
        $branch_id = $this->request->getGet('branch_id');

        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
            //$searchArray['company_name'] = '';
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
       
        if($branch_id) {
            $searchArray['branch_id'] = $branch_id;
        }
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
             $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        //         echo"<pre>";
        // print_r($data['branches']);exit;
        }
       

        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        if($start_date || $end_date || $company_id || $branch_id){
        $totalRecord = $customerModel->getChatData($searchArray, '', '', '1');
        $customers = $customerModel->getChatData($searchArray, $startLimit, $Limit,'');
        // echo"<pre>";
        // print_r($customers);exit;

        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
         
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['customers'] = $customers;
        // echo"<pre>";
        // print_r($data['customers']);exit;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/chatlist',$data);
    }
    
    
    
    function chatDetail() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	
        $data['pageurl'] = "chatdetail";
        
        
        $chatModel = new ChatModel();
        $paginationnew = new Paginationnew();
        
        $senderid = $this->request->getGet('sender_id');
        $receiverid = $this->request->getGet('receiver_id');
        if($senderid) {
            $searchArray['sender_id'] = $senderid;
        }
        if($receiverid) {
           $searchArray['receiver_id'] = $receiverid;
        }
       
        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = 50;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        if($senderid || $receiverid){
        $totalRecord = $chatModel->getBothChatData($searchArray, '', '', '1');
        $chatlist = $chatModel->getBothChatData($searchArray, $startLimit, $Limit,'');
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
         
        $data['chatlist'] = $chatlist;
        $data['startLimit'] = $startLimit;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        
        $this->template->render('admintemplate', 'contents' , 'admin/report/chatdetail',$data);
    }
    
    
    function getmorechatDetail() {
       
        $data['pageurl'] = "chatdetail";
        
        
        $chatModel = new ChatModel();
        $paginationnew = new Paginationnew();
        
        $senderid = $this->request->getGet('sender_id');
        $receiverid = $this->request->getGet('receiver_id');
        if($senderid) {
            $searchArray['sender_id'] = $senderid;
        }
        if($receiverid) {
           $searchArray['receiver_id'] = $receiverid;
        }
       
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = 50;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
    	$customers = array();
        
        if($senderid || $receiverid){
            
         $totalRecord = $chatModel->getBothChatData($searchArray, '', '', '1');
        $chatlist = $chatModel->getBothChatData($searchArray, $startLimit, $Limit,'');
        }
      
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['chatlist'] = $chatlist;
        $data["searchArray"] = $searchArray;
         $data['pagination'] = $pagination;
        
        echo view('admin/report/morechatdetail',$data);
    }
    
    public function getBranch()
    {
         $company_id = $this->request->getGet('company_id');
        $branchModel = new BranchModel();
        $branch = $branchModel->where('company_id', $company_id)->findAll();
         echo json_encode($branch);
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
function EditTransaction() {
        
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
         $od_id = $this->request->getGet('id');
     
         
         if($od_id)
         {
              $orderModel = new OrdersModel();
              $data['edit']=$orderModel->geteditS($od_id);
           
          $this->template->render('admintemplate', 'contents' , 'admin/report/edit_transaction',$data);
               
         }
         
    }
     function updatetransaction() {

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
         $od_id = $this->request->getPost('od_id');
         $data=[
'od_paidamount' => $this->request->getPost('od_paidamount'),
'od_saveamount' => $this->request->getPost('od_saveamount'),
'citycode_commission' => $this->request->getPost('citycode_commission'),
'od_totalamount' => $this->request->getPost('od_totalamount')
         ];

      
       
         if(intval($od_id)>0)
         {
              $orderModel = new OrdersModel();
            $orderModel->set($data)->where("od_id",$od_id)->update();

              $this->session->setFlashdata('message', 'Updated  successfully.');
            

           
       
         return redirect()->to(site_url('atransactionreportsedit?id='.$od_id));
               
         }
         
    }




    //coupon list
      function clist() {
        $session = session();
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        } 
         $coupon_purchase = new couponPurchaseModel();
           
  
        $data['pageurl'] = "couponreports";
        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] =$coupon_purchase->comp();
      // print_r($data['companies']);exit;

        // $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
              
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $company_id = $this->request->getGet('company_id');
        $coupon_name = $this->request->getGet('coupon_name');
        $coupon_amount = $this->request->getGet('coupon_amount');
       
        

        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
            //$searchArray['company_name'] = '';
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
    $session_company_id = ($session->get('company_id'));
     if($session_company_id) {
            $searchArray['session_company_id'] = $session_company_id;
         
        }

        if($company_id) {
            $searchArray['company_id'] = $company_id;
         
        }
        if($coupon_name) {
           $searchArray['coupon_name'] = $coupon_name;
        }

         if($coupon_amount) {
           $searchArray['coupon_amount'] = $coupon_amount;
        }
        $branch_id = $this->request->getGet('branch_id');
         if($branch_id) {
           $searchArray['branch_id'] = $branch_id;
        }
       
        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
        $customers = array();

        
        if($start_date || $end_date || $company_id || $coupon_name || $coupon_price ){
        $totalRecord = $coupon_purchase->getDataReport($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReport($searchArray, $startLimit, $Limit);
         $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        elseif($session_company_id){
             $totalRecord = $coupon_purchase->getDataReport($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReport($searchArray, $startLimit, $Limit);
        }

         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        
     
      
        
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['coupon_purchase'] = $coupon_purchase;
       
      


        
        $this->template->render('admintemplate', 'contents' , 'admin/report/couponlist',$data);
    }

     function couponreportsredeem() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        } 
        $session = session();  
        $data['pageurl'] = "couponreports";
        $stateModel = new StateModel();
        $coupon_purchase = new couponPurchaseModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] =$coupon_purchase->comp();


        $branchModel = new BranchModel();
        $data['branches']  = array();
        
        
       
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $company_id = $this->request->getGet('company_id');
        $coupon_name = $this->request->getGet('coupon_name');
        $coupon_amount = $this->request->getGet('coupon_amount');
        
 $session_company_id = ($session->get('company_id'));
     if($session_company_id) {
            $searchArray['session_company_id'] = $session_company_id;
         
        }
        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
            //$searchArray['company_name'] = '';
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
   
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
           
        }
         if($coupon_name) {
           $searchArray['coupon_name'] = $coupon_name;
        }
         if($coupon_amount) {
           $searchArray['coupon_amount'] = $coupon_amount;
        }
        $branch_id = $this->request->getGet('branch_id');
         if($branch_id) {
           $searchArray['branch_id'] = $branch_id;
        }
       
        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
        $customers = array();
        
        if($start_date || $end_date || $company_id || $coupon_name || $coupon_price ){
        $totalRecord = $coupon_purchase->getDataReportredeem($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReportredeem($searchArray, $startLimit, $Limit);
         $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
         elseif($session_company_id){
             $totalRecord = $coupon_purchase->getDataReportredeem($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReportredeem($searchArray, $startLimit, $Limit);
        
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
      
        
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['coupon_purchase'] = $coupon_purchase;
        // echo"<pre>";
        // print_r($data['coupon_purchase']);exit;


        
        $this->template->render('admintemplate', 'contents' , 'admin/report/couponlist',$data);
    }

    function couponreportexpire() {
       $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }  
        $coupon_purchase = new couponPurchaseModel(); 
        $data['pageurl'] = "couponreportexpire";
        $stateModel = new StateModel();
        $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
       $data['companies'] =$coupon_purchase->comp();

        $branchModel = new BranchModel();
        $data['branches']  = array();
        
        
       
        
        $paginationnew = new Paginationnew();
        $txtsearch = $this->request->getGet('txtsearch');
        $searchArray = array();
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $company_id = $this->request->getGet('company_id');
        $coupon_name = $this->request->getGet('coupon_name');
        $coupon_amount = $this->request->getGet('coupon_amount');
         $session_company_id = ($session->get('company_id'));
     if($session_company_id) {
            $searchArray['session_company_id'] = $session_company_id;
         
        }

        if($start_date) {
            $searchArray['start_date'] = $start_date ? $start_date : "";
            //$searchArray['company_name'] = '';
        }
        if($end_date) {
           $searchArray['end_date'] = $end_date;
        }
   
        if($company_id && $company_id !=='city_code') {
            $searchArray['company_id'] = $company_id;
           
        }
         if($coupon_name) {
           $searchArray['coupon_name'] = $coupon_name;
        }
         if($coupon_amount) {
           $searchArray['coupon_amount'] = $coupon_amount;
        }
          $branch_id = $this->request->getGet('branch_id');
         if($branch_id) {
           $searchArray['branch_id'] = $branch_id;
        }
       
        //////////// pagination ////////////
            
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;  
        $startLimit = ($page - 1) * $Limit;
        $totalRecord =0;
        $pagination =array();
        $customers = array();
        
        if($start_date || $end_date || $company_id || $coupon_name || $coupon_price ){
        $totalRecord = $coupon_purchase->getDataReportexpire($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReportexpire($searchArray, $startLimit, $Limit);
         $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
        elseif($session_company_id){
             $totalRecord = $coupon_purchase->getDataReportexpire($searchArray, '', '', '1');
        $coupon_purchase = $coupon_purchase->getDataReportexpire($searchArray, $startLimit, $Limit);
        }
         $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
      
      
        
        $data['startLimit'] = $startLimit;
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['coupon_purchase'] = $coupon_purchase;
        // echo"<pre>";
        // print_r($data['coupon_purchase']);exit;


        
        $this->template->render('admintemplate', 'contents' , 'admin/report/couponlist',$data);
    }

    function couponpreviewpurchase() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }  
        
        $coupon_purchase = new couponPurchaseModel();
        $searchArray = array();
        $id = $this->request->getGet('id');
        $purchase_status = $this->request->getGet('purchase_status');
      
         if($id) {
           $searchArray['id'] = $id;
        }
        if($purchase_status) {
           $searchArray['purchase_status'] = $purchase_status;
        }
        $preview = $coupon_purchase->getDatapreview($searchArray);
        $data['preview'] = $preview[0];
  


        
        $this->template->render('admintemplate', 'contents' , 'admin/report/purchasecouponpreview',$data);
    }

//      function checkout() {
//         $data=array();
       
//    $data['client_reference_id']=rand(1111,9999);

//    $data['mode']='payment';
//    $data['products']=['name'=> "product 1",'quantity'=> '1','unit_amount'=> '100'];

// $data['success_url']='https://company.com/success';
//    $data['cancel_url']='https://company.com/cancel';
//    // $data['customer_id']='26';
//    $data['metadata']=['Customer name'=> "Abdul",'order id'=> str::upper(str::random(8))];



// $curl = curl_init();

// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://uatcheckout.thawani.om/api/v1/checkout/session",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => json_encode($data),
//   CURLOPT_HTTPHEADER => [
//     "Content-Type:application/json ",
//     "thawani-api-key:rRQ26GcsZzoEhbrP2HZvLYDbn9C9et "
//   ],
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }
        

        
      
//     }



}

?>
