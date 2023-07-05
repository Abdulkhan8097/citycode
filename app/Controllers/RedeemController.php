<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImagesModel;
use App\Models\CompanyModel;
use App\Libraries\Paginationnew;
use App\Models\CustomerModel;

class RedeemController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    function index() {
        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $productModel = new ProductModel();
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if ($txtsearch) {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $searchArray['show_inredeem'] = '1';
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $productModel->getAll($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
        $data['reverse'] = $totalRecord - ($page - 1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data ['lists'] = $productModel->getAll($searchArray, $startLimit, $Limit);
        $this->template->render('admintemplate', 'contents', 'admin/redeemlist', $data);
    }

    function add_new() {
        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
        $this->template->render('admintemplate', 'contents', 'admin/redeem_form', $data);
    }

/////// add new product /////////

    public function add_new_product() {
        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

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

$company_id=$this->request->getVar('company_id');

        $data = [
            'company_id' => $company_id,
            'product_name' => $this->request->getVar('product_name'),
            'pr_redeempoint' => $this->request->getVar('pr_redeempoint'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
            'status' => $this->request->getVar('status'),
            'created_date' => date('Y-m-d H:i:s'),
            'show_inredeem' => '1',
            'picture' => $picture,
            'arb_product_name' => $this->request->getVar('arb_product_name'),
            'arb_description' => $this->request->getVar('arb_description'),
        ];

        $productModel = new ProductModel();
        $id = $productModel->insert($data);
	$red=['redeem' => '1'];
	$productModel->rechange($company_id,$red);

        if ($productModel->errors) {
            return $this->fail($productModel->errors());
        } else {
            $this->session->setFlashdata('message', 'Redeem Product Added Successfully!');
            return redirect()->to(site_url('Redeem_Products'));
        }
    }

/////////// edit redeem products ///////////////


    public function edit_redeem_product() {

        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $productModel = new ProductModel();
        $data['result'] = $productModel->getRedeemID($id);
          $company_id=$data['result']['company_id'];
        $imageModel = new ProductImagesModel();
        $data['images'] = $imageModel->getImageById($id);

        $companyModel = new CompanyModel();
     
         $data['redeemc'] = $companyModel->where('id',$company_id)->find();


        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        if (!$data['result']) {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('Redeem_Products'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/edit_redeem_form', $data);
    }

//////////////////////////// update ////////////////////////

    public function update() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }


        $new_id = $this->request->getPost('new_id');
	$p_company_id = $this->request->getPost('p_company_id');

        if (!$new_id) {
            $this->session->setFlashdata('errmessage', 'This Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }

        $company_id = $this->request->getVar('company_id');
        $product_name = $this->request->getVar('product_name');
        $pr_redeempoint = $this->request->getVar('pr_redeempoint');
        $description = $this->request->getVar('description');
        $price = $this->request->getVar('price');
        $status = $this->request->getVar('status');
        $arb_product_name = $this->request->getPost('arb_product_name');
        $arb_description = $this->request->getPost('arb_description');
        $picture = $this->request->getPost('picture');
        $redeem = $this->request->getPost('redeem');
          if($company_id != $p_company_id){

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
        $arrSaveData = array(
            'company_id' => $company_id,
            'product_name' => $product_name,
            'pr_redeempoint' => $pr_redeempoint,
            'description' => $description,
            'price' => $price,
            'status' => $status,
            'arb_product_name' => $arb_product_name,
            'arb_description' => $arb_description
        );
        if ($picture) {
            $arrSaveData['picture'] = $picture;
        }
        $newuserdata =$arrSaveData;
        // $newuserdata = (array_filter($arrSaveData));
        $Update = $productModel->where('id', $new_id)->set($newuserdata)->update();

            $Data =
       ['redeem' => $redeem];


           $companyModel = new CompanyModel();
           $Update = $companyModel->where('id', $company_id)->set($Data)->update();
            $Data0 =
       ['redeem' => 0];
         $companyModel->where('id', $p_company_id)->set($Data0)->update();


}else{
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
        $arrSaveData = array(
            'company_id' => $company_id,
            'product_name' => $product_name,
            'pr_redeempoint' => $pr_redeempoint,
            'description' => $description,
            'price' => $price,
            'status' => $status,
            'arb_product_name' => $arb_product_name,
            'arb_description' => $arb_description
        );
        if ($picture) {
            $arrSaveData['picture'] = $picture;
        }
        $newuserdata =$arrSaveData;
        // $newuserdata = (array_filter($arrSaveData));
        $Update = $productModel->where('id', $new_id)->set($newuserdata)->update();

            $Data =
       ['redeem' => $redeem];


           $companyModel = new CompanyModel();
           $Update = $companyModel->where('id', $company_id)->set($Data)->update();
     }
     

        if ($new_id) {
            $this->session->setFlashdata('message', 'Redeem Product updated successfully.');
            return redirect()->to(site_url('EditRedeem_Products?id=' . $new_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditRedeem_Products?id=' . $new_id));
        }
    }

//////////// delete Redeem Product /////////////


    public function delete_redeem_Product() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");


        $productModel = new ProductModel();
   $CustomerModel = new CustomerModel();
        $profileModel = new ProductImagesModel();
        if ($isAdminLoggedIn) {
 $data = $productModel->getRedeemID($id);
$test=$data['company_id'];


         

            $productModel->where('id', $id)->delete();
           $red=['redeem' => '0'];
            $CustomerModel->change($test,$red);

            //$profileModel->where('product_id',$id)->delete();               
            $this->session->setFlashdata('message', 'Reddem Product deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Redeem_Products'));
    }

//////////////// delete images from edit section ////////////////////

    public function delete_images() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        $id = $this->request->getGet("id");
        if ($id) {
            $profileModel = new ProductImagesModel();
            $profileModel->where('id', $id)->delete();

            $this->session->setFlashdata('message', 'Product Image Deleted Successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to($_SERVER["HTTP_REFERER"]);
    }

    ///////// product detail //////////////////////

    public function productdetails() {
        $session = session();

        if ($session->get('user_id')) {
            $isIn = $session->get('user_id');
        }
        $isIn1 = '';
        if ($session->get('company_id')) {
            $isIn1 = $session->get('company_id');
        }

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $productModel = new ProductModel();
        $data['product'] = $productModel->getProductID($id);
        $redeemProfile = new ProductImagesModel();
        $data['images'] = $redeemProfile->getImageById($id);

        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        if (($isIn1 == $data['product']['created_by']) || $isIn) {
            
        } else {
            die('permission denied!');
        }

        if (!$data['product']) {
            $this->session->setFlashdata('errmessage', 'Product Id Does not exist!');
            return redirect()->to(site_url('Products'));
        }

        $this->template->render('admintemplate', 'contents', 'admin/redeem_productdetails', $data);
    }

    public function import() {
        $productModel = new ProductModel();
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if ($txtsearch) {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $searchArray['show_inredeem'] = '1';
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
        $data ['lists'] = $productModel->getAll($searchArray, $startLimit, $Limit);

        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,4098]|ext_in[file,csv]'
        ]);

        if (!$input) {
            $data['validation'] = $this->validator;
            return view('admin/redeemlist', $data);
        } else {

            if ($file = $this->request->getFile('file')) {

                if ($file->isValid() && !$file->hasMoved()) {
                    $randomName = $file->getRandomName();

                    $file->move('../public/csv/', $randomName);
                    $file = fopen("../public/csv/" . $randomName, "r");
                    $i = 0;

                    $company_id = $this->request->getVar('company_id');

                    $fieldsNum = 4;
                    $collection = array();

                    while (($filedata = fgetcsv($file, 1500, ",")) !== FALSE) {
                        $num = count($filedata);
                        if ($i > 0 && $num == $fieldsNum) {
                            $collection[$i]['product_name'] = $filedata[0];
                            $collection[$i]['description'] = $filedata[1];
                            $collection[$i]['price'] = $filedata[2];
                            $collection[$i]['pr_redeempoint'] = $filedata[3];

                            $collection[$i]['company_id'] = $company_id;

                            $collection[$i]['show_inredeem'] = '1';
                            $collection[$i]['created_by'] = 1;
                        }
                        $i++;
                    }

                    // /print_r($collection);die;
                    fclose($file);

                    $count = 0;
                    foreach ($collection as $prodData) {
                        $product = new ProductModel();
                        if ($product->insert($prodData)) {
                            $count++;
                        }
                    }
                    session()->setFlashdata('message', $count . ' Item added to db.');
                    session()->setFlashdata('alert-class', 'alert-info');
                } else {
                    session()->setFlashdata('message', 'Error occured while importing CSV.');
                    session()->setFlashdata('alert-class', 'alert-warning');
                }
            } else {
                session()->setFlashdata('message', 'Error occured while importing CSV.');
                session()->setFlashdata('alert-class', 'alert-warning');
            }
            return redirect()->to($_SERVER["HTTP_REFERER"]);
        }
    }


  
}



?>
