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
use App\Models\SitevariableModel;

use App\Models\CustomerModel;

class AboutCompany extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


  function index() {

	$session = session();
	//$isAdminLoggedIn = $session->get();
	 $isAdminLoggedIn = $session->get('isAdminLoggedIn');

	 $companyModel = new CompanyModel();
	 $data['companydetails'] = $companyModel->getCompanyID($session->get('company_id'));

$siteModel = new SitevariableModel();
        $data['discount_items'] = $siteModel->getAll();


     $stateModel = new StateModel();
     $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();
	 $cityModel = new CityModel();
     $data['cities'] = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();
     $data['all_cities'] = $cityModel->findAll();
	 $codeModel = new CodeModel();
	 $data['offer_details'] = $codeModel->getCodeIDs($session->get('company_id'));


	 $branchModel = new BranchModel();
        $data['branch_details'] = $branchModel->getBranchData($session->get('company_id'));
	  
	  $docModel = new CompanyDocFile();
	  $data['banners'] = $docModel->getBanner($session->get('company_id'));
	  $data['docss'] = $docModel->getDocFile($session->get('company_id'));

	 if(!$data['companydetails'])    
	 {
		 $this->session->setFlashdata('errmessage', 'Banner Id Does not exist!');
		 return redirect()->to(site_url('Banners'));
	 }
	 $this->template->render('admintemplate', 'contents' , 'admin/companydetails', $data);
 }

////////////////////////// add banner_form/////////////////

 function add_banner()
	{

		$this->template->render('admintemplate', 'contents' , 'admin/banner_form');
	}

/////////////////////// add banner image //////////////////

public function add()
    {
 	$session = session();
	 
	 if ($session->get('company_id')){
	    $isAdminLoggedIn = $session->get('company_id'); 		
	}
		
	$data =[];
	if($this->request->getFiles()){	
	 $files = $this->request->getFiles(); 	 
	 foreach($files['banner'] as $img) {
	 if($img->isValid() && !$img->hasMoved()){
	 if($img->move(FCPATH . 'company/')) {
	 
	      $data = [    
                'banner' =>  $img->getClientName(),
				'company_id' => $session->get('company_id'),
				'type' => 'banner'
              ];
			  $bannerfile = new CompanyDocFile();
			  $save = $bannerfile->insert($data);
	       }
	    }
	  }
    }  
    if ($bannerfile->errors) {
        return $this->fail($bannerfile->errors());
     }
     else{
        $this->session->setFlashdata('message', 'Banner Added Successfully!');
        return redirect()->to(site_url('Banners'));
    }
 }

 /////////////////////// banner list ///////////////////////

 function banner_list()
	{
		$session = session();
		$isAdminLoggedIn = $session->get('isAdminLoggedIn');
		$docModel = new CompanyDocFile();
		 $data = array();
      
        $data['action'] = "Banners";
       
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }

        $company_id = ($session->get('company_id'));
        if($company_id){ $searchArray['company_id'] =$company_id;  }

       
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $docModel->getDatalist($searchArray,'','','1');
        // print_r($totalRecord);exit;

        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
         // print_r($data['pagination']);exit;
        $data["searchArray"] = $searchArray;
   
       if($company_id){
          $data['banners'] = $docModel->getBanner($session->get('company_id'));
       } 
       else {
          $data['list'] = $docModel->getDatalist($searchArray, $startLimit, $Limit);
          // print_r($data['list']);exit;
        } 
		// $data['banners'] = $docModel->getBanner($session->get('company_id'));
		// $data['list'] = $docModel->getBanneradmin();
		// echo "<pre>";print_r($data['list']);exit;
       // $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		// $data['pagination'] = 1;



		$this->template->render('admintemplate', 'contents' , 'admin/bannerlist', $data);
	}

////////////////////////// edit banner /////////////////////

public function edit_banner()
    {
    $session = session();
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");

	if($session->get('user_id')){         
          $isIn = $session->get('user_id'); 		
       }
	if ($session->get('company_id')){
	    $isIn1 = $session->get('company_id'); 		
        }
        $docModel = new CompanyDocFile();
        $data['bannerdetails'] = $docModel->getBannerId($id);
		
        if(!$data['bannerdetails']) 
        {
            $this->session->setFlashdata('errmessage', 'Banner Id Does not exist!');
            return redirect()->to(site_url('Banners'));
        }
        $this->template->render('admintemplate', 'contents' , 'admin/edit_banner', $data);
    }

	/////////////// update ////////////////////////

public function update()
{
	$session = session();
	$isAdminLoggedIn = $session->get('isAdminLoggedIn');

	if(!$isAdminLoggedIn)
	{  
		return redirect()->to(site_url('admin'));
	}		
	$banner_id = $this->request->getPost('banner_id');
	if(!$banner_id)
	{
		$this->session->setFlashdata('errmessage', 'Banner does not exist!');
		return redirect()->to(site_url('adminlist'));
	}

	$bannerfile = new CompanyDocFile();
	$data = array();  
    $banner = "";
    $file = $this->request->getFile("banner");
    if($file)
    {
	   $file_type = $file->getClientMimeType();
	   $valid_file_types = array("image/png", "image/jpeg", "image/jpg");  
	   $userFolderpath = FCPATH.'company/';  
	   if (in_array($file_type, $valid_file_types)) {
		   $banner = $file->getName();
   
		   if ($file->move($userFolderpath, $banner)) {
			   $banner = $file->getName();
		   }
	   }
   }
		  $arrSaveData = array(
			   'banner' => $banner,			   
			 );	 
   $Update = $bannerfile->where('id',$banner_id)->set($arrSaveData)->update(); 	
	if($banner_id) {		
		$this->session->setFlashdata('message', 'Banner Updated Successfully.');           
		return redirect()->to(site_url('EditBanner?id='.$banner_id));
	}
else {		
		$this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');            
		return redirect()->to(site_url('EditBanner?id='.$banner_id));
	}
}

//////////// delete banner /////////////

public function delete()
{
  $session = session();

if($session->get('user_id')){         
	  $isIn = $session->get('user_id'); 		
   }

if ($session->get('company_id')){
	$isIn1 = $session->get('company_id'); 		
	}

	$isAdminLoggedIn = $session->get('isAdminLoggedIn');

	$id =  $this->request->getGet("id");

	$bannerfile = new CompanyDocFile();
	$bannerfile ->where('id',$id)->delete();
	if($bannerfile) {		
		$this->session->setFlashdata('message', 'Banner Deleted Successfully.');
	}
	else {
		$this->session->setFlashdata('errmessage', 'Invalid access.');
	}
	return redirect()->to(site_url('Banners'));
}

  public function status() {


        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getPost('id');
     
        if (!$id) {
            $this->session->setFlashdata('errmessage', 'Banner does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $status = $this->request->getPost('status');
       // echo $status ;exit;

       $docModel = new CompanyDocFile();

        $arrSaveData = array(
            'b_status' => $status,
        );

        $Update = $docModel->where('id', $id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'status updated successfully.');
            return redirect()->to(site_url('Banners'));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('Banners'));
        }
    }
 
	
	



}

?>
