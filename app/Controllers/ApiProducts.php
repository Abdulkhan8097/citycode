<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class ApiProducts extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    //get all category
    public function index() {
        $searchArray = array();
        
        
        $company_id = $this->request->getGet('company_id');
        $show_inredeem = $this->request->getGet('show_inredeem');
        if($company_id)
        {
            $searchArray["company_id"] = $company_id;
        }
        if($show_inredeem || $show_inredeem ===0)
        {
            $searchArray["show_inredeem"] = $show_inredeem;
        }
        $searchArray["status"] =1;
      //  $searchArray = array("company_id"=>$company_id,"show_inredeem"=>$show_inredeem);
        $arrcompany =  $this->model->getAll($searchArray);
        
        
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Products listed successfully'
                    ],
                    'image_base_url' => base_url('product')."/",
                    'company_base_url' => base_url('company')."/",
                    'companylist' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No company available.');
            }
    }
    
    
   

    // create
    public function create() {

       
    }

    // single offer
    public function show($id = null) {

        $searchArray = array();
         $searchArray['id'] = $id;
         
         $data =  $this->model->getAll($searchArray);
//         
//
//         // company banner
//         $compayAddModel = new CompanyDocFile();
//         $addsearch = array('company_id'=>$id,'type'=>'banner');
//         $companyAddArr = $compayAddModel->getData($addsearch);
//         
         
//        print_r($companyAddArr);
        if ($data && $id) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('product')."/",
            ];
            
            $response['productdetail'] = $data;
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
	
//////////////////////////// redeem product ///////////////
	
	 public function redeem_product() {
        $searchArray = array();               
        $company_id = $this->request->getVar('company_id');

        //echo $company_id;exit;

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
                     'company_image_base_url' => base_url('company')."/",
                    'RedeemProduct' => $arrcompany,                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Product available.');
            }
    }
}
