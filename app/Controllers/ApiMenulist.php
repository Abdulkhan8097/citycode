<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;
use App\Models\MenuImagesModel;

class ApiMenulist extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new MenuModel();
        $this->imagemodel = new MenuImagesModel();

    }

    //get all category
    public function index() {
        $searchArray = array();
        
        
        $company_id = $this->request->getGet('company_id');
        $branch_id = $this->request->getGet('branch_id');
  
        $searchArray = array("company_id"=>$company_id,"branch_id"=>$branch_id);
        $arrcompany =  $this->model->getAll($searchArray);
        
     // print_r($arrcompany );die;       
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Menu items listed successfully'
                    ],
                    'image_base_url' => base_url('menulist')."/",
                    'company_base_url' => base_url('company')."/",
                    'menulist' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No menus available.');
            }
    }
    
//////////////////////////// redeem product ///////////////
	
	 public function redeem_product() {
        $searchArray = array();               
        $company_id = $this->request->getPost('company_id');

        $searchArray = array("company_id"=>$company_id,"show_inredeem"=>'1');
        $arrcompany =  $this->model->getAll($searchArray);              
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Redeem Products listed successfully'
                    ],
                    'image_base_url' => base_url('product')."/",
                    'RedeemProduct' => $arrcompany,                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Product available.');
            }
    }
}
