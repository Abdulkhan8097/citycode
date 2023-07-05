<?php
namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\MallDetailsModel;
use App\Models\CompanyModel;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\OrdersModel;
use App\Libraries\Paginationnew;
use App\Models\SitevariableModel;
use App\Models\CompanyDocFile;
use App\Libraries\Pushnotification;

class CustomOfferController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
		$this->model = new CustomerModel();
      }


  function index() { 
   //echo "string";exit;
        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }


	$data = array();
		$siteModel = new SitevariableModel();
        $data['action'] = "CustomOfferDetails";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }


        $company_id = ($session->get('company_id'));
        if($company_id){
         $searchArray['company_id'] =$company_id; 
        }

        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $siteModel->getData($searchArray, '', '', '1');
        //echo  $totalRecord;exit;
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
   
       if($company_id){
          $data['results'] = $siteModel->getData($searchArray, $startLimit, $Limit);
       } 
       else {
          $data['results'] = $siteModel->getData($searchArray, $startLimit, $Limit);
        }           
         $this->template->render('admintemplate', 'contents', 'admin/CustomOfferDetails', $data);   
     }
 
 
  function AddCustomOffer() {
        //echo "string";exit;
        //echo "<pre>";print_r($this->request->getPost());exit;

        $session = session();
        $company_id = '';
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $st_name = $this->request->getPost('st_name');
        $st_arb_name = $this->request->getPost('st_arb_name');
       // echo "<pre>"; print_r($checkimg);exit;
        if ($st_name!='' && $st_arb_name!='') {
            $data = array();	

            $data = [
                'st_name' => $st_name,
                'st_arb_name' => $st_arb_name,
                'st_group' => 'discounttype',
            ];
            $siteModel = new SitevariableModel();
            $id = $siteModel->insert($data);				
            if (!empty($id)) {
    	     $this->session->setFlashdata('message', 'Offers Inserted Successfully!');
                  return redirect()->to(site_url('CustomOfferDetails'));          
            }else{			
    	        $this->session->setFlashdata('errmessage', 'Offers Not Inserted!');
                return redirect()->to(site_url('CustomOfferDetails'));
            }
        }else {         
            $this->session->setFlashdata('errmessage', 'Please Insert Data!');
            return redirect()->to(site_url('CustomOfferDetails'));
        }
    }


    public function edit_Offer_details() {
        //echo "string";exit;
        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }

        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }

        $siteModel = new SitevariableModel();
        $data['customOffers'] = $siteModel->getOfferID($id);       
        //echo "<pre>";print_r($data['customOffers']);exit;
        

        if (!$data['customOffers']) {
           // echo "in";exit;
            $this->session->setFlashdata('errmessage', 'Offer Id Does not exist!');
            return redirect()->to(site_url('CustomOfferDetails'));
        }
         //echo "<pre>";print_r($data);exit;
        $this->template->render('admintemplate', 'contents', 'admin/testing', $data);
    }


    function EditCustomOffer() {
        //echo "string";exit;
        //echo "<pre>";print_r($this->request->getPost());exit;

        $session = session();
        $company_id = '';
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $st_name = $this->request->getPost('st_name');
        $st_arb_name = $this->request->getPost('st_arb_name');
        $offer_id = $this->request->getPost('offer_id');
        //echo "<pre>"; print_r($offer_id);exit;
        if ($st_name!='' && $st_arb_name!='') {
            $data = array();    

            $data = [
                'st_name' => $st_name,
                'st_arb_name' => $st_arb_name,
                'st_group' => 'discounttype',
            ];
            $siteModel = new SitevariableModel();
            $id =$siteModel->where('st_id', $offer_id)->set($data)->update();
            //echo "<pre>"; print_r($offer_id);exit;

            if (!empty($id)) {
             $this->session->setFlashdata('message', 'Offer Updated Successfully!');
            return redirect()->to(site_url('EditCustomOffer?id=' . $offer_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditCustomOffer?id=' . $offer_id));
        }
    }
}








	
	///////////////////////////// notification details //////////////////////
	
    public function CustomOffer_Details(){
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
		
		
        $siteModel = new SitevariableModel();
        $data['row'] = $siteModel->getOfferID($id); 
       // echo "<pre>";print_r($data['row']);exit;
        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('CustomOfferDetails'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/customOffers_Datails', $data);
    }

    //////////////////////////// notification delete //////////////////////

    public function delete_customOffer() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

       $siteModel = new SitevariableModel();
       $deleteOfferMall = $siteModel->where('st_id', $id)->delete();

       if($deleteOfferMall){
            $this->session->setFlashdata('message', 'Offer deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('CustomOfferDetails'));
    }

    
}

?>



