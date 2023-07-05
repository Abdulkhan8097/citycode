<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CodeModel;
use App\Models\CompanyModel;
use App\Models\CouponModel;
use App\Models\HomeBusinessModel;
use App\Models\DashboardAdvertisementModel;

class ApiOffers extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new CodeModel();
        $this->businessModel = new HomeBusinessModel();
        
    }

    //get all category
    public function index() {
        $searchArray = array();
        
         $coupon_type = $this->request->getGet('coupon_type');
         $homebusiness_type = $this->request->getGet('homebusiness_type');
         $userid = $this->request->getGet('userid');
         $category = $this->request->getGet('category');
         $stateid = $this->request->getGet('stateid');
         $cityid = $this->request->getGet('cityid');
         $discounttype = $this->request->getGet('discounttype');
         $sortby = $this->request->getGet('sortby');
         $mallby = $this->request->getGet('mallby');
        // $fav_customerid = $this->request->getGet('fav_customerid');
          $page = $this->request->getGet('page');


          if($coupon_type=='coupon')
         {
             $searchArray['coupon'] = '1';
          
         }

         else
         {
             $searchArray['coupon_type'] = $coupon_type;
         }

         if($homebusiness_type)
         {
            $searchArray['homebusiness_type'] = $homebusiness_type;
         }

         if($category)
         {
             $arrCategory = explode("A", $category);
            
             $searchArray['category'] = $arrCategory;
         }
         if($stateid)
         {
             $searchArray['stateid'] = $stateid;
         }
         if($cityid)
         {
             $searchArray['cityid'] = $cityid;
         }
         if($discounttype)
         {
             $searchArray['discounttype'] = $discounttype;
         }
         if($sortby)
         {
             $searchArray['sortby'] = $sortby;
         }

         if($mallby)
         {
             $searchArray['mallby'] = $mallby;
         }

        if($userid)
         {
             $searchArray['fav_customerid'] = $userid;
         }
         
         $searchArray['company_status']  =1;
         $searchArray['expiredoffer']  =1;

        $totalRecord = 0;
        //echo date('Y-m-d g:i:s');die;
        if ($searchArray['coupon_type'] == 'Friday') {
            if ($searchArray['coupon_type'] == date('l') || date('l') =='Thursday') {
                
                $arrOffers =  $this->model->getData($searchArray);

                //echo "<pre>";print_r($arrOffers);exit;
               $totalRecord = $count =count($arrOffers);
                for($i=0; $i <$count ; $i++) { 
                    $arrOffers[$i]['user_fav'] = '';
                    $arrOffers[$i]['customer_id'] = '';
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
                                unset($arrOffers[$j]);
                                $arrOffers = array_values($arrOffers);
                                $count =count($arrOffers);
                           }
                        }
                    }
                 } 
                
                for($i=0; $i <$count ; $i++) { 
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
                                unset($arrOffers[$j]);
                                $arrOffers = array_values($arrOffers);
                                $count =count($arrOffers);
                           }
                        }
                    }
                } 

                if ($arrOffers) {
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Offer listed successfully'
                        ],
                        'image_base_url' => base_url('company')."/",
                        'offers' => $arrOffers,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('No offers available.');
                }
            } else {
                 return $this->failNotFound('No offers available.');
            }
        } else{
            if (!empty($searchArray)) {
                $arrOffers =  $this->model->getData($searchArray);
                  $CouponModel = new CouponModel();
                    // ('coupon_status','1')


                $coupolist =  $CouponModel->getDatalist($searchArray);
                // print_r($coupolist);exit;

                $coupon_status=$coupolist[0]->coupon_status;


                
//               $arrOffers = $this->unique_key($arrOffers,'customer_discount');

               
               $totalRecord = $count =count($arrOffers);
                for($i=0; $i <$count ; $i++) { 
                    
                     $arrOffers[$i]['user_fav'] = '';
                    $arrOffers[$i]['customer_id'] = '';
                    
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
                                unset($arrOffers[$j]);
                                $arrOffers = array_values($arrOffers);
                                $count =count($arrOffers);
                           }
                        }
                    }
                 } 

                 for($i=0; $i <$count ; $i++) { 
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
                                unset($arrOffers[$j]);
                                $arrOffers = array_values($arrOffers);
                                $count =count($arrOffers);
                           }
                        }
                    }
                } 
                //this for duplicae discount of same company
                for($i=0; $i <$count ; $i++) { 
                    for($j=$i+1; $j <$count ; $j++) { 
                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
                                unset($arrOffers[$j]);
                                $arrOffers = array_values($arrOffers);
                                $count =count($arrOffers);
                           }
                        }
                    }
                } 

                if ($arrOffers) {
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Offer listed successfully...'
                        ],
                        'image_base_url' => base_url('company')."/",
                        'offers' => $arrOffers,
                        'totalRecord' => $totalRecord,
                    ];
                    return $this->respondCreated($response);
                }elseif($coupon_status=='1') {

                    
                        $Record = $count =count($coupolist);
                          if ($coupon_status) {
                        $arrOffers1= (object) [
                                // 'id'=>'',
                                // 'company_id'=>'',
                                // 'branch_id'=>'',
                                'coupon_type'=>'',
                                'company_discount'=>'',
                                'comission'=>'',
                                'customer_discount'=>'',
                                'discount_detail'=>'',
                                'description'=>'',
                                'arb_description'=>'',
                                'start_date'=>'',
                                'end_date'=>'',
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
                                'company_arb_name'=>'',
                                // 'display_name'=>'',
                                'display_arb_name'=>'',
                                // 'companylogo'=>'',
                                // 'coupon_status'=>$coupon_status,
                                // 'view_count'=>'',
                                'category'=>'',
                                'discount_en_detail'=>'',
                                'discount_arb_detail'=>'',
                                // 'isfavorate'=>'',
                                'remainingday'=>'',
                                'remaininghours'=>'',
                                'remainingminutes'=>'',
                                'user_fav'=>'',
                                'customer_id'=>''
                            ];

                            // print_r($arrOffers);exit;
                             foreach($coupolist as $arr) {
                       $arrOffers[]= (object) array_merge((array) $arr, (array) $arrOffers1);
                    }
                            // $arrOffers[] = (object) array_merge(
                            // (array) $arrOffers1, (array) $coupolist);


                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Offer listed successfully'
                        ],
                        'image_base_url' => base_url('company')."/",
                        'add_image_base_url' => base_url('advertisement')."/",
                        'offers' => $arrOffers,
                        'totalRecord' => $Record,
                       
                    ];
                    return $this->respondCreated($response);
                } 
                    // return $this->failNotFound('No offers available.');
                }
                else {


                     return $this->failNotFound('No offers available.');
                }
            }
        }
             
          
       /*elseif (isset($searchArray['coupon_type']) && $searchArray['coupon_type']=='homebusiness_type') {
            $arrOffers =  $this->businessModel->getData($searchArray);
            if ($arrOffers) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'listed successfully'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'offers' => $arrOffers,
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No offers available.');
            }
            //echo "<pre>";print_r($arrOffers);exit;
        }*//*elseif ($homebusiness_type!='') {
            $arrOffers =  $this->businessModel->getData($searchArray);
            if ($arrOffers) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'listed successfully'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'offers' => $arrOffers,
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No offers available.');
            }
        }*/
    }
    

    
     public function getOffers() {
        $searchArray = array();
        
         $coupon_type = $this->request->getGet('coupon_type');
         $userid = $this->request->getGet('userid');
         $homebusiness_type = $this->request->getGet('homebusiness_type');
         $category = $this->request->getGet('category');
         $stateid = $this->request->getGet('stateid');
         $cityid = $this->request->getGet('cityid');
         $discounttype = $this->request->getGet('discounttype');
         $sortby = $this->request->getGet('sortby');
         $mallby = $this->request->getGet('mallby');
        
         $page = $this->request->getGet('page');
         $totalRecord = 0;

           if($coupon_type=='coupon')
         {
             $searchArray['coupon'] = '1';
          
         }

         else
         {
             $searchArray['coupon_type'] = $coupon_type;
         }
         // if($coupon_type)
         // {
         //     $searchArray['coupon_type'] = strtolower($coupon_type);
         // }

         if($homebusiness_type)
         {
            $searchArray['homebusiness_type'] = $homebusiness_type;
         }

         if($category)
         {
             $arrCategory = explode("A", $category);
            
             $searchArray['category'] = $arrCategory;
         }
         if($stateid)
         {
             $searchArray['stateid'] = $stateid;
         }
         if($cityid)
         {
             $searchArray['cityid'] = $cityid;
         }
         if($discounttype)
         {
             $searchArray['discounttype'] = $discounttype;
         }
         if($sortby)
         {
             $searchArray['sortby'] = $sortby;
         }

         if($mallby)
         {
             $searchArray['mallby'] = $mallby;
         }

         if($userid)
         {
             $searchArray['fav_customerid'] = $userid;
         }
         
         $searchArray['company_status']  =1;
         $searchArray['expiredoffer']  =1;
         $searchArray['groupby']  =1;
         
         //get advertise detail
            $objDashAdvertise = new DashboardAdvertisementModel();
            $adpage = $page ? $page : 1;
            $adLimit = 1;
            $adtotalRecord = $objDashAdvertise->getDataAll('', '', '', '1');
            
            if($adpage > $adtotalRecord)
            { $adtotalRecord = $adtotalRecord ? $adtotalRecord : 1;
                $adpage = $adpage  % $adtotalRecord;
                $adpage = $adpage ? $adpage +1 :1;
            }
            $adstartLimit = ($adpage - 1) * $adLimit;	
         $dashAdvertise = $objDashAdvertise->getDataAll('',$adstartLimit,$adLimit);
        $dashAdvertise = $dashAdvertise ? $dashAdvertise[0] : array();
        //echo date('Y-m-d g:i:s');die;
//        if ($coupon_type == 'Friday') {
//            echo date('l');
//            if ($searchArray['coupon_type'] == date('l') || date('l') =='Thursday') {
//                
//                $page = $page ? $page : 1;
//                $Limit = 18;
//                $totalRecord = $this->model->getData($searchArray, '', '', '1');
//                $startLimit = ($page - 1) * $Limit;	
//                
//                $arrOffers =  $this->model->getData($searchArray,$startLimit,$Limit);
//                //echo "<pre>";print_r($arrOffers);exit;
//                $count =count($arrOffers);
//                for($i=0; $i <$count ; $i++) { 
//                    
//                    for($j=$i+1; $j <$count ; $j++) { 
//                     //   $arrOffers[$i]['isfavorate'] =0;
//                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
//                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
//                                unset($arrOffers[$j]);
//                                $arrOffers = array_values($arrOffers);
//                                $count =count($arrOffers);
//                           }
//                        }
//                    }
//                 } 
//                
//                for($i=0; $i <$count ; $i++) { 
//                    for($j=$i+1; $j <$count ; $j++) { 
//                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
//                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
//                                unset($arrOffers[$j]);
//                                $arrOffers = array_values($arrOffers);
//                                $count =count($arrOffers);
//                           }
//                        }
//                    }
//                } 
//
//                if ($arrOffers) {
//                    $response = [
//                        'status' => 201,
//                        'error' => null,
//                        'messages' => [
//                            'success' => 'Offer listed successfully'
//                        ],
//                        'image_base_url' => base_url('company')."/",
//                        'add_image_base_url' => base_url('company')."/",
//                        'offers' => $arrOffers,
//                        'totalRecord' => $totalRecord,
//                        'perpageRecord' => $Limit,
//                        'dashAdvertise' => $dashAdvertise,
//                    ];
//                    return $this->respondCreated($response);
//                } else {
//                    return $this->failNotFound('No offers available.');
//                }
//            } else {
//                 return $this->failNotFound('No offers available.');
//            }
//        } else{
           $coupon_type = strtolower($coupon_type);
            if (!empty($searchArray)) {
                
                if ($coupon_type == 'friday')
                {
                    // $check=date('l');


                    if (date('l') !='Friday') {
                        $searchArray['coupon_type'] = "NONE";
                        EXIT;

                   }
                } 
                $page = $page ? $page : 1;
                $Limit = 18;
                $allRecord = $this->model->getData($searchArray);
                $totalRecord = (string )count($allRecord) ; //$this->model->getData($searchArray, '', '', '1');
                $startLimit = ($page - 1) * $Limit;
                
                $arrOffers =  $this->model->getData($searchArray,$startLimit,$Limit,'');
              
                    $CouponModel = new CouponModel();
                    // ('coupon_status','1')


                $coupolist =  $CouponModel->getDatalist($searchArray);

                $coupon_status=$coupolist[0]->coupon_status;
               

                // $CompanyModel = new CompanyModel();
                // $coupolist =  $CompanyModel->where('coupon_status','1')->first();
                // $coupon_status=$coupolist['coupon_status'];
                 // print_r($coupolist);exit;
             //   print_r($arrOffers);
//               $arrOffers = $this->unique_key($arrOffers,'customer_discount');
               
//                $count =count($arrOffers);
//                for($i=0; $i <$count ; $i++) { 
//                   //  $arrOffers[$i]['isfavorate'] =0;
//                    for($j=$i+1; $j <$count ; $j++) { 
//                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
//                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
//                                unset($arrOffers[$j]);
//                                $arrOffers = array_values($arrOffers);
//                                $count =count($arrOffers);
//                           }
//                        }
//                    }
//                 } 
//
//                 for($i=0; $i <$count ; $i++) { 
//                    for($j=$i+1; $j <$count ; $j++) { 
//                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
//                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
//                                unset($arrOffers[$j]);
//                                $arrOffers = array_values($arrOffers);
//                                $count =count($arrOffers);
//                           }
//                        }
//                    }
//                } 
//                //this for duplicae discount of same company
//                for($i=0; $i <$count ; $i++) { 
//                    for($j=$i+1; $j <$count ; $j++) { 
//                        if($arrOffers[$i]['company_id']==$arrOffers[$j]['company_id']) {
//                           if($arrOffers[$i]['customer_discount']==$arrOffers[$j]['customer_discount']) {
//                                unset($arrOffers[$j]);
//                                $arrOffers = array_values($arrOffers);
//                                $count =count($arrOffers);
//                           }
//                        }
//                    }
//                } 

                
                if ($arrOffers) {


                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Offer listed successfully'
                        ],
                        'image_base_url' => base_url('company')."/",
                        'add_image_base_url' => base_url('advertisement')."/",
                        'offers' => $arrOffers,
                        'totalRecord' => $totalRecord,
                        'perpageRecord' => $Limit,
                        'dashAdvertise' => $dashAdvertise,
                    ];
                    return $this->respondCreated($response);
                } elseif($coupon_status=='1') {

                    $Record = $count =count($coupolist);

                          if ($coupon_status) {
                        $arrOffers1= (object) [
                                // 'id'=>'',
                                // 'company_id'=>'',
                                // 'branch_id'=>'',
                                'coupon_type'=>'',
                                'company_discount'=>'',
                                'comission'=>'',
                                'customer_discount'=>'',
                                'discount_detail'=>'',
                                'description'=>'',
                                'arb_description'=>'',
                                // 'start_date'=>'',
                                // 'end_date'=>'',
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
                                // 'company_arb_name'=>'',
                                // 'display_name'=>'',
                                'display_arb_name'=>'',
                                // 'companylogo'=>'',
                                // 'coupon_status'=>$coupon_status,
                                // 'view_count'=>'',
                                'category'=>'',
                                'discount_en_detail'=>'',
                                'discount_arb_detail'=>'',
                                 // 'isfavorate'=>'',
                                'remainingday'=>'',
                                'remaininghours'=>'',
                                'remainingminutes'=>'',
                                'user_fav'=>'',
                                'customer_id'=>''
                            ];

                            // print_r($arrOffers);exit;
                             foreach($coupolist as $arr) {
                       $arrOffers[]= (object) array_merge((array) $arr, (array) $arrOffers1);
                    }
                            // $arrOffers[] = (object) array_merge(
                            // (array) $arrOffers1, (array) $coupolist);
                    // echo "<pre>";
                    // print_r($arrOffers);exit;

                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Offer listed successfully'
                        ],
                        'image_base_url' => base_url('company')."/",
                        'add_image_base_url' => base_url('advertisement')."/",
                        'offers' => $arrOffers,
                        'totalRecord' => "$Record",
                        'perpageRecord' => $Limit,
                        'dashAdvertise' => $dashAdvertise,
                    ];
                    return $this->respondCreated($response);
                } 
                    // return $this->failNotFound('No offers available.');
                }
                else {


                     return $this->failNotFound('No offers available.');
                }
            }
//        }
             
          
      
    }
    // single offer
    public function show($id = null) {

        $searchArray = array();
        $searchArray['id'] = $id;
         
        $data =  $this->model->getData($searchArray);
         
        
        if ($data && $id) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('company'),
            ];
            
            $response['offerdetail'] = $data;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
    
    
    //function for remove duplicate value 
        public function unique_key($array,$keyname){
           
            $new_array = array();
            foreach($array as $key=>$value){

              if(!isset($new_array[$value[$keyname]])){
                $new_array[$value[$keyname]] = $value;
              }

            }
            $new_array = array_values($new_array);
            return $new_array;
        }
}
