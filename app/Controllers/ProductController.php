<?php

namespace App\Controllers;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\ProductModel;
use App\Models\ProductImagesModel;
use App\Models\AdminModel;
use App\Models\BranchModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\ProductMultipleImage;
use App\Libraries\Paginationnew;

class ProductController extends BaseController {

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
        $adminModel = new AdminModel();
        $data['login'] = $adminModel->LoginID();

        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
        $data['branchdata'] = $branchModel->getBranchData($session->get('company_id'));

        $productModel = new ProductModel();
       // if ($session->get('user_id')) {
            $paginationnew = new Paginationnew();
            $searchArray = array();
            $txtsearch = $this->request->getGet('txtsearch');
            $companytxtsearch = $this->request->getGet('companytxtsearch');
            $company_id = $this->request->getGet('company_id');

            if($txtsearch)
            {
                $searchArray['txtsearch'] = $txtsearch;
            }
            if($company_id)
            { 
                $searchArray['company_id'] =$company_id;
               
            }
            $searchArray['show_inredeem'] = '0';

            $company_id = ($session->get('company_id'));
               // print_r($company_id);exit;
             if($company_id)
            { 
                $searchArray['company_id'] =$company_id;
            }
             if($companytxtsearch)
            {
                $searchArray['companytxtsearch'] = $companytxtsearch;
                $searchArray['companyidsearch'] = $company_id;
            }

            $page = $this->request->getGet('page');
            $page = $page ? $page : 1;
            $Limit = PER_PAGE_RECORD;
            $totalRecord = $productModel->getAll($searchArray, '', '', '1');
            $startLimit = ($page - 1) * $Limit;
			$data['reverse'] = $totalRecord-($page -1) * $Limit;
            $data['startLimit'] = $startLimit;
            $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
            $data['txtsearch'] = $txtsearch;
            $data['startLimit'] = $startLimit;
            $data['pagination'] = $pagination;
            $data["searchArray"] = $searchArray;
            if($company_id){
            $data['allproduct'] = $productModel->getAll($searchArray, $startLimit, $Limit);
       } 
       else {
           $data['allproduct'] = $productModel->getAll($searchArray, $startLimit, $Limit);

        }
        // echo"<pre>";
        // print_r($data['allproduct']);exit;
        $this->template->render('admintemplate', 'contents', 'admin/products/productlist', $data);
    }

    function add_new() {
        $session = session();
        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
            $productModel = new ProductModel();
            $data['results'] =  $productModel->getCompanyBranch($isAdminLoggedIn);
        }
       //echo"<pre>"; print_r($data['results']); die;

        $this->template->render('admintemplate', 'contents', 'admin/products/product_form', $data);
    }

    function action() {
        //---for testing on company change selection of branch
        if ($this->request->getVar('action_old')) {
            $action = $this->request->getVar('action');
            if ($action == 'get_city') {
                $branchModel = new BranchModel();
                $branchdata = $branchModel->where('company_id', $this->request->getVar('company_id'))->findAll();
                echo json_encode($branchdata);
            }
        }

        //----for seelct branch after discount offer and discount selection.
       //  if ($this->request->getVar('action')) {
       //      $action = $this->request->getVar('action');
       //      if ($action == 'get_city') {
       //          $branchModel = new BranchModel();
       //          $branchdata = $branchModel->where('company_id', $this->request->getVar('company_id'))->findAll();
       //          echo json_encode($branchdata);
       //      }
       // }
       if ($this->request->getVar('action')) {
            $action = $this->request->getVar('action');
            if ($action == 'get_city') {
                $branchModel = new BranchModel();
                $CodeModel = new CodeModel();
             
                   $branchdata = $CodeModel->where('company_id', $this->request->getVar('company_id'))->where('coupon_type', $this->request->getVar('offer_Type'))->findAll();
                   $branchdata = $branchModel->where('company_id', $this->request->getVar('company_id'))->findAll();
                echo json_encode($branchdata);
            }
        }
        /*if ($this->request->getVar('action')) {
            $action = $this->request->getVar('action');
            if ($action == 'get_city') {
                $branchModel = new BranchModel();
                $branchdata = $branchModel->where('company_id', $this->request->getVar('company_id'))->findAll();
                echo json_encode($branchdata);
            }
        }*/
    }

    function getDiscount() {
        $action = $_POST['action'];
        $coupon_type=$_POST['offer_Type'];
        $company_id=$_POST['company_id'];
       
        //$codeModel = $action ." ".$coupon_type;
        if ($action == 'get_Offer') {
            $codeModel = new CodeModel();
            $codeModel = $codeModel->getCustomerDiscount($company_id,$coupon_type);             
            echo json_encode($codeModel);
        }
    }


///////////////////////////// add new product /////////////////////

    public function add_new_product() {
        //echo "<pre>";print_r($this->request->getPost());exit;
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
        // $picture = "";
        // $file = $this->request->getFile("picture");
        // if ($file) {
        //     $file_type = $file->getClientMimeType();
        //     $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

        //     $userFolderpath = FCPATH . 'product/';

        //     if (in_array($file_type, $valid_file_types)) {
        //         $picture = $file->getName();

        //         if ($file->move($userFolderpath, $picture)) {
        //             $picture = $file->getName();
        //         }
        //     }
        // }

        // $picture_2 = "";
        // $file = $this->request->getFile("picture_2");
        // if ($file) {
        //     $file_type = $file->getClientMimeType();
        //     $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

        //     $userFolderpath = FCPATH . 'product/';

        //     if (in_array($file_type, $valid_file_types)) {
        //         $picture = $file->getName();

        //         if ($file->move($userFolderpath, $picture)) {
        //             $picture_2 = $file->getName();
        //         }
        //     }
        // }
        //  $picture_3 = "";
        // $file = $this->request->getFile("picture_3");
        // if ($file) {
        //     $file_type = $file->getClientMimeType();
        //     $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

        //     $userFolderpath = FCPATH . 'product/';

        //     if (in_array($file_type, $valid_file_types)) {
        //         $picture = $file->getName();

        //         if ($file->move($userFolderpath, $picture)) {
        //             $picture_3 = $file->getName();
        //         }
        //     }
        // }
        //    $picture_4 = "";
        // $file = $this->request->getFile("picture_4");
        // if ($file) {
        //     $file_type = $file->getClientMimeType();
        //     $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

        //     $userFolderpath = FCPATH . 'product/';

        //     if (in_array($file_type, $valid_file_types)) {
        //         $picture = $file->getName();

        //         if ($file->move($userFolderpath, $picture)) {
        //             $picture_4 = $file->getName();
        //         }
        //     }
        // }
         if(isset($_FILES["picture"]["name"]) && !empty($_FILES["picture"]["name"]))
              {
                $picture = (isset($_FILES['picture']) && !empty($_FILES['picture']))? $this->request->getFile('picture') : '';
                $picture ->move(FCPATH . 'product/');
                // $picture ->move(PUBLIC_FOLDER . 'uploads/');
                
                $picture = $picture->getName();
                             


              }
              if(isset($_FILES["picture_2"]["name"]) && !empty($_FILES["picture_2"]["name"]))
              {
                $picture_2 = (isset($_FILES['picture_2']) && !empty($_FILES['picture_2'])) ? $this->request->getFile('picture_2') : '';
                $picture_2 ->move(FCPATH . 'product/');
                $picture_2 = $picture_2->getName();
              }
              if(isset($_FILES["picture_3"]["name"]) && !empty($_FILES["picture_3"]["name"]))
              {
                $picture_3 = (isset($_FILES['picture_3']) && !empty($_FILES['picture_3'])) ? $this->request->getFile('picture_3') : '';
                 $picture_3 ->move(FCPATH . 'product/');
                $picture_3 = $picture_3->getName();
              }
               if(isset($_FILES["picture_4"]["name"]) && !empty($_FILES["picture_4"]["name"]))
              {
                $picture_4 = (isset($_FILES['picture_4']) && !empty($_FILES['picture_4'])) ? $this->request->getFile('picture_4') : '';
                $picture_4 ->move(FCPATH . 'product/');
                $picture_4 = $picture_4->getName();
              }
             $picture = (isset($picture) && !empty($picture))? $picture : '';
             
             $picture_2=(isset($picture_2) && !empty($picture_2))? $picture_2 : '';
             $picture_3=(isset($picture_3) && !empty($picture_3))? $picture_3 : '';
             $picture_4=(isset($picture_4) && !empty($picture_4))? $picture_4 : '';


		$branch_id = $this->request->getVar('branch_id');
        if ($branch_id) {
            $branch_id = implode(',', $this->request->getVar('branch_id'));
        }
$org_price=$this->request->getVar('original_price');
$citycodebenifit=$citycodebenifit=isset($_POST['cityCode_benefits'])?$this->request->getPost('cityCode_benefits'):'0';
$service_charge=$service_charge=isset($_POST['service_charge'])?$this->request->getPost('service_charge'):'0';
$cityb=$cityb=isset($_POST['cityb'])?$this->request->getPost('cityb'):'0';
$supplierVat_charges=$supplierVat_charges=isset($_POST['Supplier'])?$this->request->getPost('Supplier'):'0';
 $discount_offer=$discount_offer=isset($_POST['discount_offer'])?$this->request->getPost('discount_offer'):'0';

// 
// $org_price = substr($org_price, 0, strpos($org_price, "."));
// $citycodebenifit = substr($citycodebenifit, 0, strpos($citycodebenifit, "."));
// $service_charge = substr($service_charge, 0, strpos($service_charge, "."));
// $cityb = substr($cityb, 0, strpos($cityb, "."));
// $supplierVat_charges = substr($supplierVat_charges, 0, strpos($supplierVat_charges, "."));
// $discount_offer = substr($discount_offer, 0, strpos($discount_offer, "."));
$product_cost_mobile=$org_price+$service_charge+$cityb+$citycodebenifit+$supplierVat_charges;
// var_dump($product_cost_mobile);exit;
// $product_cost_mobile=$org_price+=$citycodebenifit+=$service_charge+=$cityb+=$supplierVat_charges;


$mobilediscount=$org_price*$discount_offer;
$mobilediscount=$mobilediscount/100;
$product_discount_mobile=$product_cost_mobile-$mobilediscount;

		
        $data = [
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'coupon_type' => $this->request->getVar('offer_Type'),
            'discount_offer' => $this->request->getVar('discount_offer'),
            'product_name' => $this->request->getVar('product_name'),
            'description' => $this->request->getVar('description'),
            'price' => isset($_POST['price'])?$this->request->getPost('price'):'',
            'picture' => $picture,
            'picture_2' => $picture_2,
            'picture_3' => $picture_3,
            'picture_4' => $picture_4,
            'status' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $isAdminLoggedIn,
            'arb_product_name' => $this->request->getVar('arb_product_name'),
            'arb_description' => $this->request->getVar('arb_description'),
            'original_price' => $this->request->getVar('original_price'),
         //   'discount_per' => $this->request->getVar('discount_per'),
            'after_discount' => isset($_POST['after_discount'])?$this->request->getPost('after_discount'):'',
            'supplierVat_charges' => isset($_POST['Supplier'])?$this->request->getPost('Supplier'):'',
            'delivery_charge' => isset($_POST['d_charges'])?$this->request->getPost('d_charges'):'',
            'service_charge' => isset($_POST['service_charge'])?$this->request->getPost('service_charge'):'',
            'citycode_vat' => isset($_POST['cityb'])?$this->request->getPost('cityb'):'',
            'delivery_km' => isset($_POST['d_km'])?$this->request->getPost('d_km'):'',
            'cityCode_benefits' => isset($_POST['cityCode_benefits'])?$this->request->getPost('cityCode_benefits'):'',
            'product_cost_mobile' =>isset($product_cost_mobile)?$product_cost_mobile:'',
            'product_discount_mobile' =>isset($product_discount_mobile)?$product_discount_mobile:'',
        ];
        // echo"<pre>";
        // print_r($data);
        // exit;

        //echo print_r($data); exit;
        $product = new ProductModel;
        $id = $product->insert($data);

        $ProductMultipleImage = new ProductMultipleImage;
         $data11 = [];
        if ($this->request->getMethod() == 'post') {
            $files = $this->request->getFiles();

            foreach ($files['picture'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    if ($img->move(FCPATH . 'product/')) {

                        $data11 = [
                            'product_id' => $id,
                            'product_image_name' => $img->getClientName(),
                            
                        ];
                      
                        $save = $ProductMultipleImage->insert($data11);
                    }
                }
            }
        }



	 
	  // $data2 = [];
   //      if ($this->request->getMethod() == 'post') {
   //          $files = $this->request->getFiles();

   //          foreach ($files['image_name'] as $img) {
   //              if ($img->isValid() && !$img->hasMoved()) {
   //                  if ($img->move(FCPATH . 'product/')) {

   //                      $data2 = [
		 //                    'product_id' => $id,
   //                           'image_name' =>  $img->getClientName()
   //                       ];
   //                     $imageModel = new ProductImagesModel();	
   //                      $save = $imageModel->insert($data2);
   //                  }
   //              }
   //          }
   //      }


        if ($product->errors) {
            return $this->fail($product->errors());
        } else {
            $this->session->setFlashdata('message', 'New Product Added Successfully!');
            return redirect()->to(site_url('Products'));
        }
    }

    ///////////////////////////// edit product /////////////////////

    public function edit_product() {
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

        $productModel = new ProductModel();
        $data['product'] = $productModel->getProductID($id); 
        $data['discount_offer'] = $productModel->getDiscountOffer($id);

        /*if ($isIn1 = $data['product']['created_by']) {           
        } else {
            die('permission denied!');
        }*/

        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();

        $data['results'] =  $productModel->getBranchName($id);

        $imageModel = new ProductImagesModel();
        $ProductMultipleImage = new ProductMultipleImage();
	    $data['images'] = $imageModel->getImageById($id);
       // echo"<pre>"; print_r($id);die;

        $data['product_img'] = $ProductMultipleImage->getProductId($id);


        //$data['alls'] = $branchModel->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();

        if (!$data['product']) {
            $this->session->setFlashdata('errmessage', 'Product Id Does not exist!');
            return redirect()->to(site_url('products'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/products/edit_product_form', $data);
    }

    public function update() {
        $session = session();

        //echo "<pre>";print_r($this->request->getPost());exit;

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
        $product_id = $this->request->getPost('product_id');
        if (!$product_id) {
            $this->session->setFlashdata('errmessage', 'Product does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
        
		$branch_id = $this->request->getVar('branch_id');
        if ($branch_id) {
            $branch_id = implode(',', $this->request->getVar('branch_id'));
        }
        $product_name = $this->request->getPost('product_name');
        $description = $this->request->getPost('description');

        $coupon_type = $this->request->getPost('offer_Type');
        $discount_offer = $this->request->getPost('discount_offer');

        $price = $this->request->getPost('price');
        $status = $this->request->getPost('status');
        $picture = $this->request->getPost('picture');
        $updated_date = $this->request->getPost('updated_date');
        $arb_product_name = $this->request->getPost('arb_product_name');
        $arb_description = $this->request->getPost('arb_description');
        $original_price = $this->request->getPost('original_price');
        $discount_per = $this->request->getPost('discount_per');
        $productModel = new ProductModel();

        $data = array();
        $picture = "";
        $file = $this->request->getFile("picture");
        if ($file) {
            $file_type = $file->getClientMimeType();
            $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

            $userFolderpath = FCPATH . 'product/';

            if (in_array($file_type, $valid_file_types)) {
                $picture = $file->getName();

                if ($file->move($userFolderpath, $picture)) {
                    $picture = $file->getName();
                }
            }
        }

       // echo $discount_per;exit;
        if ($picture) {
            $arrSaveData = array(
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'product_name' => $product_name,
                'coupon_type' => $coupon_type,
                'discount_offer' => $discount_offer,
                'description' => $description,
                'price' => $price,
              //  'status' => $status,
                'updated_date' => date('Y-m-d H:i:s'),
                'arb_product_name' => $arb_product_name,
                'arb_description' => $arb_description,
                'picture' => $picture,
                'original_price' => $original_price,
                'discount_per' => $discount_per,
            );
        }else{
            $arrSaveData = array(
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'product_name' => $product_name,
                'coupon_type' => $coupon_type,
                'discount_offer' => $discount_offer,
                'description' => $description,
                'price' => $price,
//                'status' => $status,
                'updated_date' => date('Y-m-d H:i:s'),
                'arb_product_name' => $arb_product_name,
                'arb_description' => $arb_description,
                'original_price' => $original_price,
                'discount_per' => $discount_per,
            );
        }

   // $newuserdata = (array_filter($arrSaveData));
    //echo "<pre>";print_r($arrSaveData);exit;
    $Update = $productModel->where('id', $product_id)->set($arrSaveData)->update();
				
	$imageModel = new ProductImagesModel();
    $updateImage =[];

	if($this->request->getFiles()){
	$files = $this->request->getFiles();
	 foreach($files['image_name'] as $img) {
	   if($img->isValid() && !$img->hasMoved()){
	     if($img->move(FCPATH . 'product/')) {
	 
	      $updateImage = [
		        'product_id' => $product_id,
                'image_name' =>  $img->getClientName()
              ];			  
	      $save = $imageModel->insert($updateImage);
	    }
	   }
	  }
	 }

        if ($product_id) {
            $this->session->setFlashdata('message', 'Product updated successfully.');
            return redirect()->to(site_url('EditProduct?id=' . $product_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditProduct?id=' . $product_id));
        }
    }

//////////// delete product /////////////


    public function delete_product() {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }

        if ($session->get('company_id')) {
            $isIn = $session->get('company_id');
        }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

        $productModel = new ProductModel();
        $imagefile = new ProductImagesModel;
        //echo $isIn1;
       // echo $isIn;exit;

       // if (($isIn1 = $data['product']['created_by']) || $isIn) {
        if ($isIn!='') {

            $productModel->where('id', $id)->delete();
          // $imagefile->where('product_id', $id)->delete();
            $this->session->setFlashdata('message', 'Product deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Products'));
    }

///////// product detail //////////////////////

    public function productdetails() {
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

        $imageModel = new ProductImagesModel();
	    $data['images'] = $imageModel->getImageById($id);
       // print_r($data['images']);die;

        $productModel = new ProductModel();
        $data['product'] = $productModel->getProductID($id);

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();

        /*if (($isIn1 == $data['product']['created_by'])) {
            
        } else {
            die('permission denied!');
        }*/
				 
        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
        $data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

        if (!$data['product']) {
            $this->session->setFlashdata('errmessage', 'Product Id Does not exist!');
            return redirect()->to(site_url('Products'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/products/productdetails', $data);
    }

////////////////// change status ////////////////////

    public function status() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            $this->session->setFlashdata('errmessage', 'Product does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $status = $this->request->getPost('status');

        $productModel = new ProductModel();

        $arrSaveData = array(
            'status' => $status,
        );

        $Update = $productModel->where('id', $id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'status updated successfully.');
            return redirect()->to(site_url('Products'));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('Products'));
        }
    }

    //////////////// delete images from edit section ////////////////////

 public function delete_product_image()
 {
     $session = session();

     $isAdminLoggedIn = $session->get('isAdminLoggedIn');
     $id =  $this->request->getGet("id");
     if($id)
     {
        $profileModel = new ProductImagesModel();
        $profileModel->where('id',$id)->delete();         
        $this->session->setFlashdata('message', 'Product Image Deleted Successfully.');
     } else {
         $this->session->setFlashdata('errmessage', 'Invalid access.');
       }
         return redirect()->to($_SERVER["HTTP_REFERER"]);
     }





     /////////////////// import ///////////

     public function import()
    {	
	    $session = session();
		
		$company_id =$this->request->getVar('company_id');
        $branch_id =$this->request->getVar('branch_id');
				
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');	
			$company_id = $isAdminLoggedIn;					
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
		
        $productModel = new ProductModel();
             $paginationnew = new Paginationnew();
             $searchArray = array();
             $txtsearch = $this->request->getGet('txtsearch');
             if($txtsearch)
             {
                 $searchArray['txtsearch'] = $txtsearch;
             }
             $searchArray['show_inredeem'] = '0';
 
             $page = $this->request->getGet('page');
             $page = $page ? $page : 1;
             $Limit = PER_PAGE_RECORD;
             $totalRecord = $productModel->getAll($searchArray, '', '', '1');
             $startLimit = ($page - 1) * $Limit;
             $data['startLimit'] = $startLimit;
             $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
             $data['txtsearch'] = $txtsearch;
             $data['startLimit'] = $startLimit;
             $data['pagination'] = $pagination;
             $data["searchArray"] = $searchArray;            
             $data['allproduct'] = $productModel->getAll($searchArray, $startLimit, $Limit);
        
        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,4098]|ext_in[file,csv]'
        ]);
 
        if (!$input) {
            $data['validation'] = $this->validator;
            return view('admin/products/productlist', $data); 
        }else{

            if($file = $this->request->getFile('file')) {

            if ($file->isValid() && ! $file->hasMoved()) {
                $randomName = $file->getRandomName();

                $file->move('../public/csv/', $randomName);
                $file = fopen("../public/csv/".$randomName, "r");
                $i = 0;
				
                $fieldsNum = 3;
                $collection = array();
                
                while (($filedata = fgetcsv($file, 1500, ",")) !== FALSE) {
                    $num = count($filedata);
                    if($i > 0 && $num == $fieldsNum){ 
                        $collection[$i]['product_name'] = $filedata[0];
                        $collection[$i]['description'] = $filedata[1];
                        $collection[$i]['price'] = $filedata[2];
                        $collection[$i]['company_id'] = $company_id;
                        $collection[$i]['branch_id'] = $branch_id;
                        $collection[$i]['created_by'] = $isAdminLoggedIn;
                    }
                    $i++;
                }
                fclose($file);

                $count = 0;
                foreach($collection as $prodData){
                    $product = new ProductModel();
//print_r($prodData);die;
                  //  $getResults = $product->where('product_name', $prodData['product_name'])->countAllResults();

                    //if($getResults == 0){
                        if($product->insert($prodData)){
                            $count++;
                        }
                   // }
                }
                session()->setFlashdata('message', $count.' Item added to db.');
                session()->setFlashdata('alert-class', 'alert-info');
            } else{
                session()->setFlashdata('message', 'Error occured while importing CSV.');
                session()->setFlashdata('alert-class', 'alert-warning');
            }
            } else{
                session()->setFlashdata('message', 'Error occured while importing CSV.');
                session()->setFlashdata('alert-class', 'alert-warning');
            }
            return redirect()->to($_SERVER["HTTP_REFERER"]);
        }
    }

    public function delete_product_banner() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        if ($isAdminLoggedIn) {
            $ProductMultipleImage = new ProductMultipleImage();
            $ProductMultipleImage->where('img_id', $id)->delete();
            $this->session->setFlashdata('message', 'Product Banner Deleted Successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        //return redirect()->to(site_url($_SERVER["HTTP_REFERER"]));
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

}

?>
