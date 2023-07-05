<?php
namespace App\Controllers;
use App\Models\ContactUsModel;
use App\Libraries\Paginationnew;

class ContactUsController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
     {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


 function index() {

        if(!$this->isAdminLoggedIn)
        {  
          return redirect()->to(site_url('admin'));
        }
				
        $data = array();
        $contactus = new ContactUsModel();
        $data['action'] = "CustomerFeedback";

        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $contactus->getDataAll($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data['results'] = $contactus->getDataAll($searchArray, $startLimit, $Limit);
       // $data['results'] = $contactus->getDataAll($searchArray,'', '', '');

        $this->template->render('admintemplate', 'contents' , 'admin/feedbacklist', $data);
     }


///////////////////// details /////////////////////

   public function feedback_details()
    {
        $session = session();

	if($session->get('user_id')){         
          $isIn = $session->get('user_id'); 		
       }

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $contactus = new ContactUsModel();
        $data['row'] = $contactus->getFeedbackID($id); 

        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('CustomerFeedback'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/feedback_details', $data);
    }

////////////////// delete customer feedback ////////////////////

    public function delete_customerFeedback() {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }

        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $contactModel = new ContactUsModel();
        $deleteCustomer = $contactModel->where('con_id', $id)->delete();

       if($deleteCustomer){
            $this->session->setFlashdata('message', 'Customer Enquiry deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('CustomerFeedback'));
    }


}

?>
