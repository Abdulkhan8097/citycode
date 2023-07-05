<?php
namespace App\Controllers;
use App\Models\AdvertisementModel;
use App\Models\CompanyModel;
use App\Models\StateModel;
use App\Models\AdBannerModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class AdvertisementController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
		$siteVariables = new SiteVariables();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


  function index() {

    $session = session();
		
	if($session->get('user_id')){         
           $isAdminLoggedIn = $session->get('user_id'); 		
	}
	  else if ($session->get('company_id')){
	  $isAdminLoggedIn = $session->get('company_id'); 		
	}
        if(!$this->isAdminLoggedIn)
        {  
          return redirect()->to(site_url('admin'));
        }
        $data = array();
        $addModel = new AdvertisementModel();
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
		$totalRecord = $addModel->getDataAll($searchArray,'','','1'); 
		$startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
		$data['startLimit'] = $startLimit;
		$pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		$data['txtsearch'] = $txtsearch;
		$data['startLimit'] = $startLimit;
		$data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;

    if($session->get('user_id')){
	   $data["lists"] = $addModel->getDataAll($searchArray, $startLimit, $Limit);
     
        }

        $this->template->render('admintemplate', 'contents' , 'admin/advertiselist', $data);
     }


function add_new()
	{
          $stateModel = new StateModel();
	  $data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

	  $companyModel = new CompanyModel();
          $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

         $siteVariables = new SiteVariables();
         $data['genderarr'] = $siteVariables->getVariable('gender');

	$this->template->render('admintemplate', 'contents' , 'admin/advertise_form', $data);
     }



   public function add()
    {
 	$session = session();

	if($session->get('user_id')){         
           $isAdminLoggedIn = $session->get('user_id'); 		
	 }
	else if ($session->get('company_id')){
	    $isAdminLoggedIn = $session->get('company_id'); 		
	}

        if(!$this->isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

	$details = new AdvertisementModel;
	
	   $governorate = $this->request->getVar('governorate');
	   $gender = $this->request->getVar('gender');
        if ($governorate) {
            $governorate = implode(',', $this->request->getVar('governorate'));
        }
		if ($gender) {
            $gender = implode(',', $this->request->getVar('gender'));
        }
           $data = [
                    'company_name' => $this->request->getVar('company_name'),
                    'governorate' => $governorate,
                    'location' => $this->request->getVar('location'),
                    'gender' => $gender,
                    'start_date' => $this->request->getVar('start_date'),
                    'end_date' => $this->request->getVar('end_date'),
                    'url' => $this->request->getVar('url'),
                    'status' => $this->request->getVar('status'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' =>  $isAdminLoggedIn,
                    'banner_type' => $this->request->getVar('banner_type'),
                    'in_app' =>  $this->request->getVar('in_app'),
                    'company_id' =>  $this->request->getVar('company_id')              
                  ];
				  
		   $newuserdata = (array_filter($data));		
                   $id = $details->insert($newuserdata);

            $bannermodel = new AdBannerModel;
		   
	   if ($this->request->getFileMultiple('banner')) {
             foreach($this->request->getFileMultiple('banner') as $banner)
              { 			  
              $banner->move("advertisement/");

              $data2 = [
		        'banner_id' => $id,
                        'banner' =>  $banner->getClientName(),
                        'created_by' =>  $isAdminLoggedIn
                      ];
 
              $save = $bannermodel->insert($data2);
            }
	} 
     if ($details->errors) {
        return $this->fail($details->errors());
     }
     else{
        $this->session->setFlashdata('message', 'Banner Added Successfully!');
        return redirect()->to(site_url('Advertisement'));
     }
 }
 
    
 
 
 /////////// edit advertisement ///////////////


public function edit_advertisement()
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

        $advertiseModel = new AdvertisementModel();
        $data['bannerdetails'] = $advertiseModel->getBannersID($id);

		if($isIn1 = $data['bannerdetails']['created_by']) {
		 } else {
		die('permission denied!');
		}

        $bannerModel = new AdBannerModel();
	$data['banners'] = $bannerModel->getBannerById($id);

	$companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

	$stateModel = new StateModel();
	$data['states'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $siteVariables = new SiteVariables();
        $data['genderarr'] = $siteVariables->getVariable('gender');
		
        if(!$data['bannerdetails']) 
        {
            $this->session->setFlashdata('errmessage', 'Banner Id Does not exist!');
            return redirect()->to(site_url('Advertisement'));
        }
        $this->template->render('admintemplate', 'contents' , 'admin/edit_advertise', $data);
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
            
        $new_id = $this->request->getPost('new_id');
        if(!$new_id)
        {
            $this->session->setFlashdata('errmessage', 'Banner does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

                    $governorate = $this->request->getVar('governorate');
		    $company_name = $this->request->getVar('company_name');
		    $count = $this->request->getVar('count');
                    $location = $this->request->getVar('location');
                    $gender = $this->request->getVar('gender');
                    $start_date = $this->request->getVar('start_date');
                    $end_date = $this->request->getVar('end_date');
                    $url = $this->request->getVar('url');
                    $status = $this->request->getVar('status');
                    $banner_type = $this->request->getVar('banner_type');
                    $in_app = $this->request->getVar('in_app');
                    $company_id = $this->request->getVar('company_id');
					
		     if ($governorate) {
                        $governorate = implode(',', $this->request->getVar('governorate'));
                     }
		     if ($gender) {
                        $gender = implode(',', $this->request->getVar('gender'));
                     }

            $advertiseModel = new AdvertisementModel();

                $arrSaveData = array(
                     'company_name' => $company_name,
                     'governorate' => $governorate,
                     'location' => $location,
                     'gender' => $gender,
                     'start_date'=> $start_date,
                     'end_date' => $end_date,
                     'url' => $url,
                     'status'=>$status,
                     'banner_type' => $banner_type,
                     'in_app' => $in_app,
                     'company_id' => $company_id,
		     'count' => $count,	
                   );
//echo"<pre>"; print_r($arrSaveData);die;
         $Update = $advertiseModel->where('id', $new_id)->set($arrSaveData)->update();


         $imagefile = new AdBannerModel;
         $data11 =[];

	if($this->request->getFiles()){
	//$imagefile->where('banner_id',$new_id)->delete();
	$files = $this->request->getFiles();
	 foreach($files['banner'] as $img) {
	 if($img->isValid() && !$img->hasMoved()){
	 if($img->move(FCPATH . 'advertisement/')) {
	 
	      $data11 = [
		'banner_id' => $new_id,
                'banner' =>  $img->getClientName(),
                'created_by' =>  $isAdminLoggedIn
              ];
			  
	  $save = $imagefile->insert($data11);
	    }
	   }
	  }
	 }
	    
        if($new_id) {
            
            $this->session->setFlashdata('message', 'Banner updated successfully.');           
            return redirect()->to(site_url('EditAdvertisement?id='.$new_id));
        }
 else {
            
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');            
            return redirect()->to(site_url('EditAdvertisement?id='.$new_id));
        }
    }
//////////// delete banner /////////////


    public function delete_banner()
    {
      $session = session();

	if($session->get('user_id')){         
          $isIn = $session->get('user_id'); 		
       }

	if ($session->get('company_id')){
	    $isIn = $session->get('company_id'); 		
        }

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id =  $this->request->getGet("id");
       $advertiseModel = new AdvertisementModel();
       $adbannerModel = new AdBannerModel();

       if($isIn) {

            $advertiseModel->where('id',$id)->delete();
            $adbannerModel->where('banner_id',$id)->delete();
               
            $this->session->setFlashdata('message', 'Banner deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Advertisement'));
    }

///////////////////// delete //////////////////

 public function delete_city_banner() {
        $session = session();

	if($session->get('user_id')){         
          $isIn = $session->get('user_id'); 		
       }
	if ($session->get('company_id')){
	    $isIn1 = $session->get('company_id'); 		
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id =  $this->request->getGet("id");

       $adbannerModel = new AdBannerModel();

       $deleteBanner = $adbannerModel->where('id',$id)->delete();
        if($deleteBanner){       
            $this->session->setFlashdata('message', 'Banner deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to($_SERVER["HTTP_REFERER"]);
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
        //echo $id ;exit;

        $adbannerModel = new AdvertisementModel();

        $arrSaveData = array(
            'status' => $status,
        );

        $Update = $adbannerModel->where('id', $id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'status updated successfully.');
            return redirect()->to(site_url('Advertisement'));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('Advertisement'));
        }
    }


}

?>
