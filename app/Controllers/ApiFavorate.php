<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\FavouriteModel;
use App\Models\CodeModel;
use App\Models\CouponModel;

class ApiFavorate extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new FavouriteModel();
    }

    //get all category
    public function index() {
        
        $searchArray = array();
        
        $customer_id = $this->request->getGet('customer_id');

        //echo $customer_id;exit;
        
        $searchArray['customer_id'] = $customer_id;
        
        $arrcompany =  $this->model->getData($searchArray);
           // $arrOf=['isfavorate'=>'1'];
           //     foreach($arrcompany as $arr) {
                               
           //             $arrcompany[]=  array_merge((array) $arr, (array) $arrOf);
                    
           //          }
                    // print_r($arrcompany);exit;
        $CouponModel = new CouponModel();
        if($customer_id)
         {
             $searchArray['fav_customerid'] = $customer_id;
         }
         $searchArray['coupon'] = '1';
        $coupolist =  $CouponModel->favouritedata($searchArray);
        
          if ($coupolist) {
       




          $arrOffers1= (object) [
                               
                                'coupon_type'=>'',
                                'company_discount'=>'',
                                'comission'=>'',
                                'customer_discount'=>'',
                                'discount_detail'=>'',
                                'description'=>'',
                                'arb_description'=>'',
                                'timing'=>'',
                                'online_link'=>'',
                                'playstore_link'=>'',
                                'ios_link'=>'',
                                'huawai_link'=>'',
                                'priority'=>'',
                                'priority_start'=>'',
                                'priority_end'=>'',
                                'h_mobile_no'=>'',
                                'h_whatsapp_no'=>'',
                                'h_instagram'=>'',
                                'h_email'=>'',
                                'h_location'=>'',
                                'h_arab_location'=>'',
                                'h_image'=>'',
                                'mall'=>'',
                                'mall_name'=>'',
                                'mall_name_arabic'=>'',
                                'custmise'=>'',
                                'offer_name_cust'=>'',
                                'offer_name_cust_arabic'=>'',
                                'discountdisplay'=>'',
                                'company_name'=>'',
                                'display_arb_name'=>'',
                                'category'=>'',
                                'discount_en_detail'=>'',
                                'discount_arb_detail'=>'',
                                'remainingday'=>'',
                                'add_date'=>'',
                                'discountdisplay'=>'Coupons',
                                'customer_discount'=>'',
                                'discount_detail'=>'',
                                'discount_en_detail'=>'',
                                'remaininghours'=>'',
                                'remainingminutes'=>'',
                                'user_fav'=>'',
                                'customer_id'=>$customer_id
                            ];
                             foreach($coupolist as $arr) {
                                // if ($arr->isfavorate=='1'  ) {
                                    // code...
                                
                       $coupolistdata[]= (object) array_merge((array) $arr, (array) $arrOffers1);
                       // }
                    }

        $arrcompany = array_merge($arrcompany, $coupolistdata);
    }
        
        if ($arrcompany || $customer_id) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Favourate listed successfully'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'favouratelist' => $arrcompany,
                     // 'favouratecouponlist' => $coupolistdata,
                    
                ];
                return $this->respondCreated($response);
            } else {
                
                 $response = [
                    'status' => 404,
                    'error' => null,
                    'messages' => [
                        'success' => 'No data available.'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'favouratelist' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            }
    }

   

    // create
    public function create() {
       // echo "string";exit;
        $userdata = array();
  
        $userdata['customer_id'] = $this->request->getPost('customer_id');
        $userdata['company_id'] = $this->request->getPost('company_id');
        $offer_id = $this->request->getPost('offer_id');
        if ($offer_id!='') {
            $userdata['offer_id']= $offer_id;
        }else{
            $userdata['offer_id']=0;
        }


        $newuserdata = (array_filter($userdata));
        if (count($newuserdata)==3 || count($newuserdata)==2) {
            
            $isuserexist = $this->model
                     ->where(['customer_id' => $userdata['customer_id']])
                     ->where(['company_id' => $userdata['company_id']])
                     ->where(['offer_id' => $userdata['offer_id']])
                     ->first();
            //echo $this->model->getLastQuery();exit;

            if (empty($isuserexist)) {
                $query = $this->model->save($userdata);

                if ($query) {
                    $userid = $this->model->getInsertID();
                    $userdata['id'] = $userid;
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Added successfully'
                        ],
                        'details' => $userdata,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Opps! some error occurs.');
                }
            } else {
                return $this->failNotFound(' alreay exist.');
            }
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }
    
    
     public function removefavourate() {

        $userdata = array();
  
        $userdata['customer_id'] = $this->request->getPost('customer_id');
        $userdata['company_id'] = $this->request->getPost('company_id');
        $offer_id = $this->request->getPost('offer_id');
        if ($offer_id!='') {
            $userdata['offer_id']= $offer_id;
        }else{
            $userdata['offer_id']=0;
        }
        $newuserdata = (array_filter($userdata));
        if (count($newuserdata)==3) {
            if ($userdata['offer_id']!=0) {
                 $isuserexist = $this->model
                     ->where(['customer_id' => $userdata['customer_id']])
                     ->where(['company_id' => $userdata['company_id']])
                     ->where(['offer_id' => $userdata['offer_id']])
                     ->first();
                if (!empty($isuserexist)) {
                    $query = $this->model
                             ->where(['customer_id' => $userdata['customer_id']])
                             ->where(['company_id' => $userdata['company_id']])
                             ->where(['offer_id' => $userdata['offer_id']])
                             ->delete();
                       //echo "<pre>";print_r($query);exit;
                    if ($query) {
                        $response = [
                            'status' => 201,
                            'error' => null,
                            'messages' => [
                                'success' => 'Removed successfully'
                            ],
                            'details' => $userdata,
                        ];
                        return $this->respondCreated($response);
                    } else {
                        return $this->failNotFound('Opps! some error occurs.');
                    }
                }else{

                    return $this->failNotFound('Allready Removed!');
                }
            }else{
               return $this->failNotFound('Please provide all data');
            }
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }
    

    // single user
    public function show($id = null) {

        $data = $this->model->where('id', $id)->first();
        if ($data) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => ' detail'
                ]
            ];
            $response['favouratedetail'] = $data;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }

}
