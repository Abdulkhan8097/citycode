<?php
namespace App\Controllers;
use App\Models\CompanyEnquiryModel;
use App\Libraries\Paginationnew;

class CompanyEnquiryController extends BaseController {
	
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
				
        $data = array();
        $companyEnquiry = new CompanyEnquiryModel();
        $data['action'] = "CompanyEnquiry";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }

        $ce_companyid = ($session->get('company_id'));
        if($ce_companyid){ $searchArray['ce_companyid'] =$ce_companyid;  }

        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $companyEnquiry->getData($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
       
        if($ce_companyid){
            $data['results'] = $companyEnquiry->getData($searchArray, $startLimit, $Limit);
       } 
       else {
        $data['results'] = $companyEnquiry->getData($searchArray, $startLimit, $Limit);
        }
//echo"<pre>";print_r($data['results']);die;
        $this->template->render('admintemplate', 'contents' , 'admin/company_enquiry_list', $data);
     }


///////////////////// details /////////////////////

   public function enquiry_details()
    {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }
       
        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
        $companyenquiry = new CompanyEnquiryModel();
        $data['row'] = $companyenquiry->getEnquiryID($id); 
        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('CompanyEnquiry'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/company_enquiry_detail', $data);
    }

////////////////// delete customer feedback ////////////////////

    public function delete_company_enquiry() {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }

        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $enquiryModel = new CompanyEnquiryModel();
        $deleteEnquiry = $enquiryModel->where('ce_id', $id)->delete();

       if($deleteEnquiry){
            $this->session->setFlashdata('message', 'Company Enquiry deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('CompanyEnquiry'));
    }


}

?>
