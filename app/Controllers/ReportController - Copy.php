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
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


  function index() {
        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }	

	$stateModel = new StateModel();
	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

    $cityModel = new CityModel();
	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

    $companyModel = new CompanyModel();
    $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

    $customerModel = new CustomerModel();
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
    $company_name = $this->request->getGet('company_name');
    $coupon_type = $this->request->getGet('coupon_type');

        if($start_date) {
            $searchArray['start_date'] = $start_date;
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
        if($company_name) {
            $searchArray['company_name'] = $company_name;
        }
        if($coupon_type){
            $searchArray['coupon_type'] = $coupon_type;
        }

        if($cityid || $stateid || $vip_code || $city_code || $gender || $mobile) {            
            $searchArray['company_name'] = '';
            $searchArray['coupon_type'] = '';
        }       
        if($coupon_type || $company_name){
            $searchArray['city_code'] = '';
            $searchArray['vip_code'] = '';
            $searchArray['gender'] = '';
            $searchArray['mobile'] = '';
            $searchArray['cityid'] = '';
            $searchArray['stateid'] = '';            
        }

    //////////// pagination ////////////
        
    $page = $this->request->getGet('page');
    $page = $page ? $page : 1;
    $Limit = PER_PAGE_RECORD;  
    $startLimit = ($page - 1) * $Limit;
	//$data['reverse'] = $totalRecord-($page -1) * $Limit;
    $data['startLimit'] = $startLimit;
    $totalRecord = $customerModel->getData($searchArray, '', '', '1');
    $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
  
    $data['txtsearch'] = $txtsearch;
    $data['startLimit'] = $startLimit;
    $data['pagination'] = $pagination;
    $data["searchArray"] = $searchArray;
    $data['customers'] = $customerModel->getData($searchArray, $startLimit, $Limit);

    if((!empty($searchArray['coupon_type'])) || (!empty($searchArray['start_date'])) || (!empty($searchArray['end_date']))){

        $totalRecord2 = $compModel->getCompanyOffer($searchArray, '', '', '1');
        $pagination2 = $paginationnew->getPaginate($totalRecord2, $page, $Limit);
        $data['startLimit'] = $startLimit;
        $data['pagination2'] = $pagination2;        
        $data['companylist'] = $compModel->getCompanyOffer($searchArray, $startLimit, $Limit);
    } else {

        $totalRecord2 = $compModel->getDataAll($searchArray, '', '', '1');
        $pagination2 = $paginationnew->getPaginate($totalRecord2, $page, $Limit);
        $data['startLimit'] = $startLimit;
        $data['pagination2'] = $pagination2;
        $data['companylist'] = $compModel->getDataAll($searchArray, $startLimit, $Limit);
    }

    $codeModel = new CodeModel();
    $totalRecord3 = $codeModel->getDataAll($searchArray, '', '', '1');
    $pagination3 = $paginationnew->getPaginate($totalRecord3, $page, $Limit);
    $data['startLimit'] = $startLimit;
    $data['pagination3'] = $pagination3;
	
	$company_id = ($session->get('company_id'));
    if($company_id){ $searchArray['company_id'] =$company_id;  }
			 
	if($company_id){
	$data['offers'] = $codeModel->getDataAll($searchArray, $startLimit, $Limit);	
	}
	else{
    $data['offers'] = $codeModel->getDataAll($searchArray, $startLimit, $Limit);
	//echo"<pre>"; print_r($data['offers']);die;
	}
	
	//////////////////////////////////// Transaction ///////////////////////////////
	
	$orderModel = new OrdersModel();
    $totalRecord4 = $orderModel->getData($searchArray, '', '', '1');
    $pagination4 = $paginationnew->getPaginate($totalRecord4, $page, $Limit);
    $data['startLimit'] = $startLimit;
    $data['pagination4'] = $pagination4;
	
	if($session->get('company_id')){
	$data['transactions'] = $orderModel->getData($searchArray, $startLimit, $Limit);
	//echo"<pre>"; print_r($data['transactions']);die;	
	}
	else{
    $data['transactions'] = $orderModel->getData($searchArray, $startLimit, $Limit);
	
	}
    
        $this->template->render('admintemplate', 'contents' , 'admin/reportlist',$data);
     }

	function action()
	{
		if($this->request->getVar('action'))
		{
			$action = $this->request->getVar('action');

			if($action == 'get_city')
			{
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
	
	$siteModel = new SitevariableModel();
     $data['discount_items'] = $siteModel->getAll();
		
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
	
	$orderModel = new OrdersModel();
    $data['order'] = $orderModel->reportdetail($id); // return count value

    ////////////////// for company ////////////

    $companyModel = new CompanyModel();
    $data['companydetails'] = $companyModel->getCompanyID($id);
    $codeModel = new CodeModel();
    $data['details'] = $codeModel->getCodeID($id);
    $data['offer_details'] = $codeModel->getCodeIDs($id);
    $branchModel = new BranchModel();
    $data['branch_details'] = $branchModel->getBranchData($id);
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
