<?php

namespace App\Controllers;
use App\Models\MenuModel;
use App\Models\MenuImagesModel;
use App\Models\BranchModel;
use App\Models\CompanyModel;
use App\Libraries\Paginationnew;

class MenuController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
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

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
        $data['branchdata'] = $branchModel->getBranchData($session->get('company_id'));

        $menuModel = new MenuModel();

            $paginationnew = new Paginationnew();
            $searchArray = array();
            $txtsearch = $this->request->getGet('txtsearch');
			
            $company_id = ($session->get('company_id'));
             if($company_id){ $searchArray['company_id'] =$company_id;  }

            $page = $this->request->getGet('page');
            $page = $page ? $page : 1;
            $Limit = PER_PAGE_RECORD;
            $totalRecord = $menuModel->getAll($searchArray, '', '', '1');
            $startLimit = ($page - 1) * $Limit;
			$data['reverse'] = $totalRecord-($page -1) * $Limit;
            $data['startLimit'] = $startLimit;
            $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
            $data['txtsearch'] = $txtsearch;
            $data['startLimit'] = $startLimit;
            $data['pagination'] = $pagination;
            $data["searchArray"] = $searchArray;
            if($company_id){

            $data['allmenus'] = $menuModel->getAll($searchArray, $startLimit, $Limit);
//print_r($data['allmenus']);die;
       } 
       else {
           $data['allmenus'] = $menuModel->getAll($searchArray, $startLimit, $Limit);
        }
        $this->template->render('admintemplate', 'contents', 'admin/menulist', $data);
    }

    function add_new() {
        $session = session();
        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
            $menuModel = new MenuModel();
            $data['results'] =  $menuModel->getCompanyBranch($isAdminLoggedIn);
        }
       //echo"<pre>"; print_r($data['results']); die;

        $this->template->render('admintemplate', 'contents', 'admin/menu_list_form', $data);
    }

    function action() {
        if ($this->request->getVar('action')) {
            $action = $this->request->getVar('action');
            if ($action == 'get_city') {
                $branchModel = new BranchModel();
                $branchdata = $branchModel->where('company_id', $this->request->getVar('company_id'))->findAll();
                echo json_encode($branchdata);
            }
        }
    }

///////////////////////////// add new menu /////////////////////

    public function add_new_menu() {
        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
            $company_id = $this->request->getVar('company_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
            $company_id =  $isAdminLoggedIn;
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $data = array();
		$branch_id = $this->request->getVar('branch_id');
        if ($branch_id) {
            $branch_id = implode(',', $this->request->getVar('branch_id'));
        }
		
        $data = [
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'start_date' => $this->request->getVar('start_date'),
			'end_date' => $this->request->getVar('end_date'),
            'status' => $this->request->getVar('status')
        ];
        $menu = new MenuModel();
        $id = $menu->insert($data);
	 
	  $data2 = [];
        if ($this->request->getMethod() == 'post') {
            $files = $this->request->getFiles();

            foreach ($files['menu_image'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'menulist/')) {

                        $data2 = [
		                    'menu_id' => $id,
                            'menu_image' =>  $img->getClientName()
                         ];
                       $imageModel = new MenuImagesModel();	
                        $save = $imageModel->insert($data2);
                    }
                }
            }
        }


        if ($menu->errors) {
            return $this->fail($menu->errors());
        } else {
            $this->session->setFlashdata('message', 'New Menu Added Successfully!');
            return redirect()->to(site_url('MenuList'));
        }
    }

    ///////////////////////////// edit menu /////////////////////

    public function edit_menu() {
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

        $menuModel = new MenuModel();
        $data['menurow'] = $menuModel->getMenuID($id);       

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();

        $data['results'] =  $menuModel->getBranchName($id);

        $imageModel = new MenuImagesModel();
	    $data['images'] = $imageModel->getImageById($id);
       // echo"<pre>"; print_r($id);die;

        //$data['alls'] = $branchModel->findAll();

        if (!$data['menurow']) {
            $this->session->setFlashdata('errmessage', 'Menu Id Does not exist!');
            return redirect()->to(site_url('MenuList'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/edit_menu_form', $data);
    }
	

    public function update() {
        $session = session();

        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
            $company_id = $this->request->getPost('company_id');
        } else if ($session->get('company_id')) {
            $company_id = ($session->get('company_id'));
            $isAdminLoggedIn = $session->get('company_id');
        }   
     //   $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $menu_id = $this->request->getPost('menu_id');
        if (!$menu_id) {
            $this->session->setFlashdata('errmessage', 'Menu does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
        
		$branch_id = $this->request->getVar('branch_id');
        if ($branch_id) {
            $branch_id = implode(',', $this->request->getVar('branch_id'));
        }		
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $status = $this->request->getPost('status');
	    
		$menuModel = new MenuModel();
        $data = array();
        $arrSaveData = array(
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status
        );
    $newuserdata = (array_filter($arrSaveData));

    $Update = $menuModel->where('id', $menu_id)->set($newuserdata)->update();
				
	$imageModel = new MenuImagesModel();
    $updateImage =[];

	if($this->request->getFiles()){
	$files = $this->request->getFiles();
	 foreach($files['menu_image'] as $img) {
	   if($img->isValid() && !$img->hasMoved()){
	     if($img->move(FCPATH . 'menulist/')) {
	 
	      $updateImage = [
		        'menu_id' => $menu_id,
                'menu_image' =>  $img->getClientName()
              ];			  
	      $save = $imageModel->insert($updateImage);
	    }
	   }
	  }
	 }

        if ($menu_id) {
            $this->session->setFlashdata('message', 'Menu updated successfully.');
            return redirect()->to(site_url('EditMenu?id=' . $menu_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditMenu?id=' . $menu_id));
        }
    }

//////////// delete menu /////////////


    public function delete_menu() {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }

        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $menuModel = new MenuModel();
        $imagefile = new MenuImagesModel();

        if ($id) {
           $menuModel->where('id', $id)->delete();
           $imagefile->where('menu_id', $id)->delete();
            $this->session->setFlashdata('message', 'Menu deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('MenuList'));
    }

///////// menu detail //////////////////////

    public function menudetails() {
        $session = session();
		$isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
		$id = $this->request->getGet("id");

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }
        $isIn1 ='';
        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }

        $imageModel = new MenuImagesModel();
	    $data['images'] = $imageModel->getImageById($id);
       // print_r($data['images']);die;
	   
        $menuModel = new MenuModel();
        $data['menurow'] = $menuModel->getMenuID($id);

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();

        if (!$data['menurow']) {
            $this->session->setFlashdata('errmessage', 'Menu Id Does not exist!');
            return redirect()->to(site_url('MenuList'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/menudetails', $data);
    }


    //////////////// delete images from edit section ////////////////////

 public function delete_menu_image()
 {
     $session = session();

     $isAdminLoggedIn = $session->get('isAdminLoggedIn');
     $id =  $this->request->getGet("id");
     if($id)
     {
        $profileModel = new MenuImagesModel();
        $profileModel->where('id',$id)->delete();         
        $this->session->setFlashdata('message', 'Menu Image Deleted Successfully.');
     } else {
         $this->session->setFlashdata('errmessage', 'Invalid access.');
       }
         return redirect()->to($_SERVER["HTTP_REFERER"]);
     }


}

?>
