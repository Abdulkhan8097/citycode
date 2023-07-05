<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\CategoryModel;
use App\Models\CountryModel;
use App\Libraries\SiteVariables;
use App\Models\SitevariableModel;

class ApiFilters extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
     
    }

    //get all category
    public function index() {
        
        $language = $this->request->getGet('language');
        
        //get category list
        $searchArray = array();
        $objCategory = new CategoryModel();
        $arrCategory =  $objCategory->getData($searchArray);
        
        //get state list
        $searchArray = array('sort_by'=>$language);
        $objState = new StateModel();
        $arrState =  $objState->getData($searchArray);
//        print_r($arrState);die;
        //get state list
        $searchArray = array('state_id'=>0,'sort_by'=>$language);
        $objCity = new CityModel();
        $arrCity =  $objCity->getData($searchArray);
        
        //get state list
        $searchArray = array('sort_by'=>$language);
        $objCountry = new CountryModel();
        $arrCountry =  $objCountry->getData($searchArray);
        
        // get discount type
        $siteVariablesModel = new SitevariableModel();
        $arrSearch = array('st_group'=>'discounttype');
        $discountType = $siteVariablesModel->getData();
        
        // gender
        $siteVariables = new SiteVariables();
        $genderarr = $siteVariables->getVariable('gender');
        $languagearr = $siteVariables->getVariable('language');
        $sortby = $siteVariables->getVariable('sortby');
       
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Filters listed successfully'
                    ],
                    'category_base_url' => base_url('category')."/",
                    'category_list' => $arrCategory,
                    'state_list' => $arrState,
                    'city_list' => $arrCity,
                    'discounttype_list' => $discountType,
                    'gender_list' => $genderarr,
                    'language_list' => $languagearr,
                    'sortby_list' => $sortby,
                    'country_list' => $arrCountry,
                    
                ];
                return $this->respondCreated($response);
           
    }

   
    
    public function getcities() {
        $state_id = $this->request->getGet('state_id');
        $language = $this->request->getGet('language');

        //get state list
        $searchArray = array('state_id'=>$state_id,'sort_by'=>$language);
        $objCity = new CityModel();
        $arrCity =  $objCity->getData($searchArray);
        
        if ($arrCity && $state_id) {
            
           
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'City list successfully'
                    ],
                    'city_list' => $arrCity
                ];
                return $this->respondCreated($response);
            
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }

    // create
    public function create() {

       
    }

    // single offer
    public function show($id = null) {

       
    }
    
    
    
}
