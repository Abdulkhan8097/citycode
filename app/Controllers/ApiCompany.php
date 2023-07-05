<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CompanyModel;
use App\Models\CompanyDocFile;
use App\Models\BranchModel;
use App\Models\ProductModel;
use App\Models\ChatModel;
use App\Models\CodeModel;
use App\Models\VipModel;
use App\Models\VipCustomerModel;
use App\Models\OrgCompanyModel;
use App\Models\ProductImagesModel;
use App\Models\OrdersModel;
use App\Models\CustomerModel;
use App\Models\CouponModel;
use App\Libraries\EmailSms;
use App\Libraries\Pushnotification;
use App\Models\DashboardAdvertisementModel;

class ApiCompany extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new CompanyModel();
       
    }

    //get all category
    public function index() {
        $searchArray = array();
        
        
        $arrcompany =  $this->model->getDataAll($searchArray);
        
        
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Offer listed successfully'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'companylist' => $arrcompany,
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No company available.');
            }
    }
    
    
    public function onlineshop() {
        
        $page = $this->request->getGet('page');
        
        $searchArray = array('online_shop'=>'1');
        
        
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
        
        
        $page = $page ? $page : 1;
        $Limit = 18;
        $totalRecord = $this->model->getonlineShop($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
        
        $arrcompany =  $this->model->getonlineShop($searchArray,$startLimit,$Limit);
        
        
        if ($arrcompany) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Offer listed successfully'
                    ],
                    'image_base_url' => base_url('company')."/",
                    'companylist' => $arrcompany,
                    'totalRecord' => $totalRecord,
                    'perpageRecord' => $Limit,
                    'add_image_base_url' => base_url('advertisement')."/",
                    'dashAdvertise' => $dashAdvertise,
                    
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
         
         $data =  $this->model->getDataAll($searchArray);
         
         // company branch
         $branchsearch = array('company_id'=>$id);
         $branchModel = new BranchModel();
         $branchArr = $branchModel->getData($branchsearch);
         $allBranchs = array();
//         echo "<pre>"; //print_r($branchArr);die;
         // all offers of branch
         foreach($branchArr as $branchdetail)
         {
             $codeModel = new CodeModel();
             $arrOfersdata = array();
             $branchOffersearch = array('branch_id'=>$branchdetail['branch_id'],'alloffer'=>1); //alloffer return all branch offer
             $arrOfersdata = $codeModel->getData($branchOffersearch);
             $branchdetail["branch_offers"] = $arrOfersdata;  // assign offers
             $allBranchs[]  = $branchdetail;
            //print_r($arrOfersdata);
         }
         

         // company banner
         $compayAddModel = new CompanyDocFile();
         $addsearch = array('company_id'=>$id,'type'=>'banner');
         $companyAddArr = $compayAddModel->getData($addsearch);
         
         
//        print_r($companyAddArr);
        if ($data && $id) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ],
                'image_base_url' => base_url('company')."/",
            ];
            
            $response['companydetails'] = $data;
            $response['company_branch'] = $allBranchs;
            $response['company_banner'] = $companyAddArr;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
    
    
     public function viewcount() {

         $company_id = $this->request->getGet('company_id');
         
        $searchArray = array();
         $searchArray['id'] = $company_id;
         
         $data =  $this->model->getDataAll($searchArray);
//        print_r($data);die;
        if ($data && $company_id) {
            
            $currentcount = $data[0]['view_count'] + 1;
            $updateCount = array('view_count'=>$currentcount);
            $this->model->where("id",$company_id)->set($updateCount)->update();
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'View updated successfully'
                ],
                
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }
    
     public function companyproduct1() {
         
         $searchimgArray = array();
         $company_id = $this->request->getGet('company_id');
         $show_inredeem = $this->request->getGet('show_inredeem');
         $branch_id = $this->request->getGet('branch_id');
         $discount_offer = $this->request->getGet('discount_offer');
         
         $productModel = new ProductModel();
         
        $searchimgArray = array("company_id"=>$company_id);
       
       
        if($show_inredeem || $show_inredeem==0)
        {
         $searchArray['show_inredeem'] = $show_inredeem;
        }
        $productlist = $productModel->getAll1($searchimgArray);
        
        if ($productlist) {
            //get product image list
            
            
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Product listed successfully'
                    ],
                    'product_image_base_url' => base_url('product')."/",
                    'company_image_base_url' => base_url('company')."/",
                    'productlist' => $productlist,
                    
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No product available.');
            }
    }
    ///----edited
     public function companyproduct() {
         
         $searchimgArray = array();
         $company_id = $this->request->getGet('company_id');
         $show_inredeem = $this->request->getGet('show_inredeem');
         $branch_id = $this->request->getGet('branch_id');
         $discount_offer = $this->request->getGet('discount_offer');
         
         $productModel = new ProductModel();
         
        $searchimgArray = array("company_id"=>$company_id,"branch_id"=>$branch_id,"discount_offer"=>$discount_offer);
       

       
        if($show_inredeem || $show_inredeem==0)
        {
         $searchArray['show_inredeem'] = $show_inredeem;
        }
        $productlist = $productModel->getAll($searchimgArray);
      
        
        if ($productlist) {
            //get product image list
            
            
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Product listed successfully'
                    ],
                    'product_image_base_url' => base_url('product')."/",
                    'company_image_base_url' => base_url('company')."/",
                    'productlist' => $productlist,
                    
                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No product available.');
            }
    }
    
    public function branchLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if ($username && $password) { 
            $branchModel = new BranchModel();
            $return = $branchModel->checkBranchLogin($username, $password);

            if ($return) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Login successfully'
                    ],
                    'user_detail' => $return
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Invalid User Name or Password.');
            }
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }


    public function uploadReceipt(){
        //echo "string";exit;
        $userdata = array();
        $order_id = $this->request->getPost('order_id');
       // echo $order_id;exit;
        $receipt_no = $this->request->getPost('receipt_no');
      /* echo "<pre>";print_r($this->request->getPost());
        echo "<pre>";print_r($_FILES);exit;*/


        
        $receiptImg = "";
         if (!empty($_FILES['receiptImage']['name'])) {
           // echo "in";exit;
              $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
              $file_type  = $_FILES['receiptImage']['type'];
              $userFolderpath = FCPATH . 'company/';

            if (in_array($file_type, $valid_file_types)) {
                $newfilename = rand().'_'.$_FILES['receiptImage']['name'];
                $receipt = $userFolderpath.$newfilename;

                //echo "in";exit;
                 
                if (move_uploaded_file($_FILES['receiptImage']['tmp_name'], $receipt)) {
                   // echo "string";exit;
                    $receiptImg = $newfilename;
                   // echo $receiptImg;exit;
                }
            }
        }

        //echo $order_id;exit;
        //echo $receiptImg;exit;
        if ($order_id && $receiptImg) {
             $orederModel = new OrdersModel();
                $Update = $orederModel->do_upload($receiptImg,$order_id,$receipt_no);
                if ($Update) {
                    $response = [
                        'status' => 201,
                        //'abc' => $Update,
                        'error' => null,
                        'messages' => [
                            'success' => 'Receipt Uploaded successfully'
                        ],
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Receipt Not Uploaded.');
                }
            
        } else {
            return $this->failNotFound('Please provide all data.');
        }
    }
    
    
///------------------edited
 public function companyoffer() {
         $searchidArray = array();       
         $company_id = $this->request->getPost('company_id');
         $branch_id = $this->request->getPost('branch_id');
         $user_code = $this->request->getPost('user_code');

         $companycoupon=isset($_POST['type'])?$this->request->getPost('type'):'';
         if ($companycoupon=='coupon') {
                $customerModel = new CustomerModel();
        $validCityCode= $customerModel->where('city_code',$user_code)->find(); 

        if(!$validCityCode){

             $response = [
                    'status' => 202,
                    'error' => null,
                    'messages' => [
                        'success' => 'Please Enter Valid City Code.'
                    ],
                                       
                ];
           return $this->respondCreated($response);
        }

            $CouponModel= new CouponModel();
            $couponcfind=$CouponModel->where('company_id',$company_id)->where('branch_id',$branch_id)->find();
           if($couponcfind){


            $datacheck=$CouponModel->select('id,company_id,branch_id,start_date,end_date,coupon_amount as company_discount,coupon_amount as customer_discount,arb_coupon_details as arb_description,coupon_details as discount_detail,coupon_details asdescription')->where('company_id',$company_id)->where('branch_id',$branch_id)->find();

             // $arr1=['coupon_type'=>'coupon','comission'=>'0','code'=>'coupon'];
             //  foreach($datacheck as $arr) {
             //           $datacheck[]=  array_merge( $arr,  $arr1);
             //       }
 // print_r($datacheck);exit;

           if ($datacheck) {




                    
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Offer listed successfully'
                    ],
                    'offerlist' =>$datacheck,                   
                ];
                return $this->respondCreated($response);
           }
       }else{
         return $this->failNotFound('data Not fond.');
       }


           
         }
        


       
         $code=isset($_POST['vip_org_code'])?$this->request->getPost('vip_org_code'):'';
     if($code){

        $VipModel = new VipModel();
         $customerModel = new CustomerModel();
        $validCityCode= $customerModel->where('city_code',$user_code)->find(); 

        if(!$validCityCode){

             $response = [
                    'status' => 202,
                    'error' => null,
                    'messages' => [
                        'success' => 'Please Enter Valid City Code.'
                    ],
                                       
                ];
           return $this->respondCreated($response);
        }



        $VipCustomerModel = new VipCustomerModel();
        $OrgCompanyModel = new OrgCompanyModel();

        $checkCompany=$VipCustomerModel->where('company_id',$company_id)->find();

        $checkorg=$OrgCompanyModel->where('company_id',$company_id)->find();



        if($checkCompany){


             $VipModel = new VipModel();
        $validcode= $VipModel->where('vip_code',$code)->find(); 
     
       if(!$validcode){

         $response = [
                    'status' => 202,
                    'error' => null,
                    'messages' => [
                        'success' => 'Please Enter Valid  Code..'
                    ],
                               
                ];
           return $this->respondCreated($response);

           
       }

        // if(!$validCityCode){
        //     return $this->failNotFound('Please Enter Valid City Code.');
        // }

      
        $org_code = $VipModel->org_code($code); 
        $vipCustomer= $customerModel->where('city_code',$user_code)->where('vip_code',$code)->find(); 
           

                 if($org_code){ 
                  $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';



                }elseif($vipCustomer){

           if($vipCustomer){ 
                  $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';
                      }
                      

                }else{

                     $response = [
                    'status' => 202,
                    'error' => null,
                    'messages' => [
                        'success' => 'Invalid Code.'
                    ],
                                 
                ];
           return $this->respondCreated($response);
                  

             // $customerModel = new CustomerModel();
             //   $vip_code = $customerModel->vip_code($user_code);
             //    $city_code = $customerModel->city_code($user_code);       
             //    if($city_code){ 
             //          $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'city');
             //              $codevalue = 'City Code'; 
             //    }
              
             //    elseif($vip_code){ 
             //      $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
             //              $codevalue = 'V.I.P Code';
             //    }
            }


        }elseif($checkorg){

             $VipModel = new VipModel();
        $org_code = $VipModel->org_code($code); 
       

                 if($org_code){ 
                  $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';

                }else{


             $customerModel = new CustomerModel();
               $vip_code = $customerModel->vip_code($user_code);
                $city_code = $customerModel->city_code($user_code);       
                if($city_code){ 
                      $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'city');
                          $codevalue = 'City Code'; 
                }
              
                elseif($vip_code){ 
                  $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';
                }
            }

        }else{

              $response = [
                    'status' => 202,
                    'error' => null,
                    'messages' => [
                        'success' => 'Company Not Link With V.I.P/Organization Code.'
                    ],
                                     
                ];
           return $this->respondCreated($response);
           
        }

     


        
            
        //--------get Friday Offer    
}
if ($user_code AND $code=='' ) {
    // code...


         $currentday=date('D');

         // if($currentday=='Fri')
         // {

         //    //echo 'Today is friday';
         //    $coupon_type=array('friday','vip');
         //    //$friday_code = 
         //     if($coupon_type){ 
         //        $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>$coupon_type);
         //        $codevalue = 'V.I.P Code';

         //        $customerModel = new CustomerModel();
         //        $city_code = $customerModel->city_code($user_code); 

         //        if($city_code){ 
         //            $coupon_type=array('friday','city');
         //              $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>$coupon_type);
         //                  $codevalue = 'City Code'; 
         //        }
         //        $vip_code = $customerModel->vip_code($user_code);
         //         if($vip_code){ 
         //            $coupon_type=array('friday','vip');
         //          $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>$coupon_type);
         //                  $codevalue = 'V.I.P Code';
         //        }
         //    }
         // }
         // else
         // {
            $customerModel = new CustomerModel();
                $city_code = $customerModel->city_code($user_code);
                $vip_code = $customerModel->vip_code($user_code);
                $vcheckvip_code=$city_code['vip_code'];

              if ($vcheckvip_code) {
                   $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';
              }


                elseif($city_code){ 
                      $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'city');
                          $codevalue = 'City Code'; 
                }
                

                 elseif($vip_code){ 
                  $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'vip');
                          $codevalue = 'V.I.P Code';
                }
         // }
     }

         

        
        
        //print_r($searchidArray);exit;
         //----------------

        
         // print_r($searchidArray); exit;
        
// print_r($productlist);exit;
        $codeModel = new CodeModel();       
                $productlist = $codeModel->getDataAll($searchidArray);     
                   

           $i = 0;
                foreach($productlist as $info){                   
                    $array11[$i] = array( 
                         'id' => $info['id'],   
                        'company_id' => $info['company_id'],
                         'branch_id' => $info['branch_id'],
                         'coupon_type' => $info['coupon_type'],
                         'company_discount' => $info['company_discount'],
                         'comission' => $info['comission'],
                         'customer_discount' => $info['customer_discount'],                          
                         'discount_detail' => $info['st_name'].'/'.$info['st_arb_name'],
                         'description' => $info['description'],
                         'arb_description' => $info['arb_description'],
                         'start_date' => $info['start_date'],   
                         'end_date' => $info['end_date'],
                        'code' => $codevalue       
                    );
                $i++;
                }
      if($user_code && $company_id && $branch_id){
        // if (($productlist && $user_code = $city_code) || ($productlist && $user_code = $vip_code)) {
            //get product image list
                    
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Offer listed successfully'
                    ],
                    'offerlist' =>$array11,                   
                ];
                return $this->respondCreated($response);
            // } else {
            //     return $this->failNotFound('No Offer available.');
            // }
         }
           else {
                return $this->failNotFound('No Offer available.');
            }
    } 

//////////////////// city offer //////////////////////////

 public function cityoffer() {
                  
         $searchidArray = array();       
         $company_id = $this->request->getPost('company_id');
         $branch_id = $this->request->getPost('branch_id');
         $coupon_type = $this->request->getPost('coupon_type');
         //echo $company_id.", ".$branch_id.", ".$coupon_type; exit;
         $currentday=date('D');
         if($currentday=='Fri')
         {
            $coupon_type= array('friday','city');
         }
         else
         {
            $coupon_type=$coupon_type;
         }
        $ChatModel = new ChatModel();
      
       $chatdata=$ChatModel->select('id,user_chat_status')->where('receiver_id',$branch_id)->orderBy('id','desc')->find();
        $chatStatus=$chatdata[0]['user_chat_status'];
        if($chatStatus==1){
          $data=array('company_chat_status' => $chatStatus);
          $result = $this->model->update1($company_id, $data);
        }
	 if($chatStatus==0){
            $data=array('company_chat_status' => $chatStatus);
          $result = $this->model->update1($company_id, $data);
        }
         
         $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>$coupon_type);

         if ($coupon_type) {
            $searchidArray['coupon_type']=$coupon_type;

         }

        
        $codeModel = new CodeModel();       
        $productlist = $codeModel->getDataAll($searchidArray);
        if (!$productlist) {
            $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'city');
            $productlist = $codeModel->getDataAll($searchidArray);
        }

	$status[]['company_chat_status']= $productlist[0]['company_chat_status'];      
        //print_r($productlist);exit;
            $i = 0;
                foreach($productlist as $info){
                    $array11[$i] = array( 
                           'id' => $info['id'],                       
                            'company_id' => $info['company_id'],
                         'branch_id' => $info['branch_id'],
                         'coupon_type' => $info['coupon_type'],
                         'company_discount' => $info['company_discount'],
                         'comission' => $info['comission'],
                         'customer_discount' => $info['customer_discount'],                          
                         'discount_detail' => $info['st_name'].'/'.$info['st_arb_name'],
                         'description' => $info['description'],
                         'arb_description' => $info['arb_description'],
                         'start_date' => $info['start_date'],   
                         'end_date' => $info['end_date']            
                    );
                $i++;
            }

$searchArray = array("branch_id"=>$branch_id, "company_id"=>$company_id);
        
              $CouponModel = new CouponModel();
        $productlist1 = $CouponModel->getDataApilistcouponcompany($searchArray);
        
        // print_r($productlist1);exit;

     
            // $i = 0;
            //     foreach($productlist1 as $info){
            //         $arraycoupon[$i] = array( 
            //                'id' => $info['id'],                       
            //                 'company_id' => $info['company_id'],
            //              'branch_id' => $info['branch_id'],
            //              'coupon_type' => $info['coupon_type'],
            //              'company_discount' => $info['company_discount'],
            //              'comission' => $info['comission'],
            //              'customer_discount' => $info['customer_discount'],                          
            //              'discount_detail' => $info['st_name'].'/'.$info['st_arb_name'],
            //              'description' => $info['description'],
            //              'arb_description' => $info['arb_description'],
            //              'start_date' => $info['start_date'],   
            //              'end_date' => $info['end_date']            
            //         );
            //     $i++;
            // }


      if($company_id && $branch_id){
        if ($productlist || $productlist1) {
            //get product image list
                    
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'offer listed successfully'
                    ],
                    'offerlist' =>$array11,
			        'company_status' =>$status,
                    'coupon_data' =>$productlist1,
		                  
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Offer available.');
            }
         }
           else {
                return $this->failNotFound('No Offer available.');
            }
    }  

    public function cityoffer_og() {
                  
         $searchidArray = array();       
         $company_id = $this->request->getPost('company_id');
         $branch_id = $this->request->getPost('branch_id');
         $searchidArray = array("branch_id"=>$branch_id, "company_id"=>$company_id, 'coupon_type'=>'city');
        
        $codeModel = new CodeModel();       
        $productlist = $codeModel->getDataAll($searchidArray);      
        
            $i = 0;
                foreach($productlist as $info){
                    $array11[$i] = array( 
                           'id' => $info['id'],                       
                            'company_id' => $info['company_id'],
                         'branch_id' => $info['branch_id'],
                         'coupon_type' => $info['coupon_type'],
                         'company_discount' => $info['company_discount'],
                         'comission' => $info['comission'],
                         'customer_discount' => $info['customer_discount'],                          
                         'discount_detail' => $info['st_name'].'/'.$info['st_arb_name'],
                         'description' => $info['description'],
                         'arb_description' => $info['arb_description'],
                         'start_date' => $info['start_date'],   
                         'end_date' => $info['end_date']            
                    );
                $i++;
            }
      if($company_id && $branch_id){
        if ($productlist) {
            //get product image list
                    
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'offer listed successfully'
                    ],
                    'offerlist' =>$array11,                   
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Offer available.');
            }
         }
           else {
                return $this->failNotFound('No Offer available.');
            }
    }  


    public function chat_user_list() {
        //echo "string";exit;
        $branch_id = $this->request->getPost('branch_id');
        $chatModel = new ChatModel();
        $custModel = new CustomerModel();
//$data=$chatModel->where('receiver_id ',$branch_id)->orderBY('id  DESC')->find();
        //$listStatus[]=$data[0]['user_chat_status'];
  $unseen=$chatModel->select('seen_status')->where('seen_status','unseen')->where('receiver_id',$branch_id)->find();
                $unseen_data=0;
         foreach ($unseen as $key => $value) {
              
              $unseen_data++;
                 }
                
        //$unseen_status=$unseen[0]['seen_status'];
         // print_r($unseen_data);exit;
         $data=(object) array('unreed_status'=>$unseen_data);
        
        if ($branch_id) {
             $Userlist = $chatModel->getUserChat($branch_id);
             $ListChat=array();
            if ($Userlist) {
                $user_id = '';
                $User='';
                $User_data=array();
                foreach ($Userlist as $key => $value) {
                    $user_id = $value->sender_id;
                    $User = $custModel->user($user_id);
                   $obj=(object)array_merge((array)$data,(array)$User);

                    // print_r($obj);exit;
                  
                   if($User)
                   {
                    $User_data=[
                        'id'=>$obj->id,
                        'city_code'=>$obj->city_code,
                        'username'=>$obj->username,
                        'name'=>$obj->name,
                        'arb_name'=>$obj->arb_name,
                        'profile'=>$obj->profile,
                        'mobile'=>$obj->mobile,
                        'unread_status'=>$obj->unreed_status,
                    ];
                   array_push($ListChat,$User_data);
                   }
                }
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'User listed successfully'
                    ],
                    
                    'image_url' => base_url('users')."/",
                    'Userlist' => $ListChat,

                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No User available.');
            }
        }                
    }

    //-------------Return Company chat list
    public function chat_user_company_list() {
       //echo "string";exit;
       $company_id = $this->request->getPost('company_id');
        $userid = $this->request->getPost('userid');
        //echo $userid; exit;
        $chatModel = new ChatModel();
        $custModel = new CustomerModel();
        $branchModel = new BranchModel();
        $companyModel = new CompanyModel();
        
        if ($userid) {
             $companyList = $chatModel->getUserCompanyChat($userid);

             $ListChat=array();
             //print_r($companyList);exit;
            if ($companyList) {
                $user_id = '';
                $User='';
                $User_data=array();
                foreach ($companyList as $key => $value) {
                    $branch_id = $value->receiver_id;
                    //echo $key ."->".$branch_id.", ";
                    if($branch_id){
                        //echo $key ."->".$branch_id.", ";
                        $company =  $branchModel->getComanyChat($branch_id);
                
                        $companydetails =  $companyModel->getComanyName($company->company_id);
                        //echo "<pre>".print_r($companydetails->id);exit;
                        $User_data=[
                            'id'=>$companydetails->id,
                            'company_name'=>$companydetails->company_name,
                            'company_arb_name'=>$companydetails->company_arb_name,
                            'picture'=>$companydetails->picture,
                            'branch_id'=>$company->branch_id,
                            'branch_name'=>$company->branch_name,
                            'arb_branch_name'=>$company->arb_branch_name,
                            'lastupdatetime'=>$value->created_date,
                        ];

                       array_push($ListChat,$User_data);
                    }
                   ///print_r($ListChat);print_r($User_data);exit;
                }
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'User listed successfully'
                    ],
                    
                    'image_url' =>base_url('company')."/",
                    'Userlist' => $ListChat,
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No User available.');
            }
        }
            
                
    }
    
    
    
    
}
