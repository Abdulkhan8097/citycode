<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;

use App\Models\FavouriteModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\TransactionModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\ContactUsModel;
use App\Models\AdBannerModel;
use CodeIgniter\Session\Session;

class ApiController extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
    {
        $this->session = session();
      
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
	}


////////////////// login api ///////////////////////////

    public function userlogin()
    {
        $session = session();

        $data = array('status' => '0', 'message' => 'Failure');

        $customerModel = new CustomerModel();

        if ($this->request->getPost()) 
        {
           
            $mobile = $this->request->getPost('mobile');
	    $password = $this->request->getPost('password');

            if($mobile != '' && $password != ''){     
                $return = $customerModel->checkUserLoginApi($mobile, $password);
                if($return){
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['user_detail'] = $return;
                } else {
                    $data['message'] = 'Please Enter Correct Mobile and Password';
                }                       
            } else {
                $data['message'] = 'Please Enter Mobile and Password';
            }
        } else {
            $data['message'] = 'Invalid Access';
        }

        echo json_encode($data);
    }
	
/////////////////// register api //////////////////////////	
    
 public function userregisterapi()
    {
        $data = array('status' => '0', 'message' => 'Failure');
        $customerModel = new CustomerModel();

        if ($this->request->getPost()) 
        {		
            $name = $this->request->getPost('name');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('mobile');

            $password = $this->request->getPost('password');
	    $gender = $this->request->getPost('gender');
            $language = $this->request->getPost('language');
            $date_of_birth = $this->request->getPost('date_of_birth');          		
            $nationality = $this->request->getPost('nationality');						
            $governorate = $this->request->getPost('governorate');
            $state = $this->request->getPost('state');
            $village = $this->request->getPost('village');
            $created_date = $this->request->getPost('created_date');	

 $file = $this->request->getFile("profile");
 $file_type = $file->getClientMimeType();
 $valid_file_types = array("image/png", "image/jpeg", "image/jpg");

 if (in_array($file_type, $valid_file_types)) {
 $profile = $file->getName();

if ($file->move("images", $profile)) {             				
                $totalRecord = $customerModel->checkEmailExist($mobile);

                $codeRecord = $customerModel->checkCityCodeExist($city_code);

                if($totalRecord > 0){
                    $data['message'] = 'Mobile Number Already Exist';
                    $data['city_code'] = '';
                }else if($codeRecord > 0){
                    $data['message'] = 'City Code Already Exist';
                    $data['city_code'] = '';
                }  else {

                    $arrSaveData = array(
                    'name'=>$name,
                    'username'=>$username,
                    'email'=>$email,
                    'mobile'=>$mobile,	
                    'password'=>password_hash($password, 1),									
		    'gender'=>$gender,
                    'language'=>$language,   
                    'date_of_birth'=>$date_of_birth,					
		    'nationality'=>$nationality,
                    'governorate'=>$governorate,
                    'state'=>$state,					
		    'village'=>$village,
		    'profile'=>$profile,
                    'created_date' => date('Y-m-d H:i:s'),
                    'city_code' => ucfirst(substr($name, 0, 1)).mt_rand(1000, 9999),
                    );

                    $customerModel->save($arrSaveData);
                    $UserId = $customerModel->getInsertID();

                    if($UserId) {    
                        $data['status'] = '1';
                        $data['message'] = 'Account Created Successfully';
                        $data['city_code'] = $arrSaveData['city_code'];
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Account not Created';
                        $data['city_code'] = '';

                    }
                }                   
            
}}

else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
                $data['city_code'] = '';
            }
        } 
        echo json_encode($data);        
    }	

////////////// company information with city code api ///////////////////////
	
public function PublicOffer()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companies = new CompanyModel();
        $allorders = $companies->CityCodeApi(); // Get Order List
						
             $i = 0;
            foreach($allorders as $order){

                    $array[$i] = array(
                         'company_name' => $order->company_name,
			 'username' => $order->username,
                         'auth_contact' => $order->auth_contact,
			 'display_name' =>$order->display_name,
			 'mobile' =>$order->mobile,
			 'email' =>$order->email,
			 'location' =>$order->location,
			 'picture' => base_url()."/images/".$order->picture,
			 'views' =>$order->views,
			 'website' =>$order->website,
			 'instagram' =>$order->instagram,
			 'twitter' =>$order->twitter,
                        'facebook' =>$order->facebook,
			'snapchat' =>$order->snapchat,
			'category' =>$order->category,
			'cr_number' =>$order->cr_number,
			'address' =>$order->address,
			'status' =>$order->status,
                        'company_id' => $order->company_id,					
                        'c_location' => $order->c_location,
			'company_discount' => $order->company_discount,
                        'comission' => $order->comission,
                        'customer_discount' => $order->customer_discount,
                        'c_disc_detail' => $order->c_disc_detail,
                        'c_start' => $order->c_start,
			'c_end' =>$order->c_end,
			'c_state' =>$order->c_state,
			'c_village' =>$order->c_village,
                        'created_date' => $order->created_date,  
                    );
                    $i++;
            }

            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['City Code'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

	
/////////////////////// company information with famous code api ///////////////////////
	
	public function FamousCodeApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companies = new CompanyModel();
        $allorders = $companies->FamousCodeApi(); // Get Order List
						
             $i = 0;
            foreach($allorders as $order){

                    $array[$i] = array(
                         'company_name' => $order->company_name,
			 'username' => $order->username,
                         'auth_contact' => $order->auth_contact,
			 'display_name' =>$order->display_name,
			 'mobile' =>$order->mobile,
			 'email' =>$order->email,
			 'location' =>$order->location,
			 'picture' => base_url()."/images/".$order->picture,
			 'views' =>$order->views,
			 'website' =>$order->website,
			 'instagram' =>$order->instagram,
			 'twitter' =>$order->twitter,
                        'facebook' =>$order->facebook,
			'snapchat' =>$order->snapchat,
			'category' =>$order->category,
			'cr_number' =>$order->cr_number,
			'address' =>$order->address,
			'status' =>$order->status,
                        'company_id' => $order->company_id,
	
                        'fam_location' => $order->fam_location,
                        'fam_company_discount' => $order->fam_company_discount,
	                'fam_comission' => $order->fam_comission,
                        'fam_customer_discount' => $order->fam_customer_discount,
                        'fam_disc_detail' => $order->fam_disc_detail,
                        'fam_start' => $order->fam_start,
                        'fam_end' => $order->fam_end,
                        'fam_state' => $order->fam_state,
                        'fam_village' => $order->fam_village,
                        'created_date' => $order->created_date,    
                    );
                    $i++;
            }

            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['V.I.P code'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }
		
	
////////////////////// company information with friday code api ///////////////////////
	
	public function FridayCodeApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companies = new CompanyModel();
        $allorders = $companies->FridayCodeApi(); // Get Order List
						
             $i = 0;
            foreach($allorders as $order){

                    $array[$i] = array(
                         'company_name' => $order->company_name,
			 'username' => $order->username,
                         'auth_contact' => $order->auth_contact,
			 'display_name' =>$order->display_name,
			 'mobile' =>$order->mobile,
			 'email' =>$order->email,
			 'location' =>$order->location,
			 'picture' => base_url()."/images/".$order->picture,
			 'views' =>$order->views,
			 'website' =>$order->website,
			 'instagram' =>$order->instagram,
			 'twitter' =>$order->twitter,
                        'facebook' =>$order->facebook,
			'snapchat' =>$order->snapchat,
			'category' =>$order->category,
			'cr_number' =>$order->cr_number,
			'address' =>$order->address,
			'status' =>$order->status,
                        'company_id' => $order->company_id,
	
                        'fri_location' => $order->fri_location,
                        'fri_company_discount' => $order->fri_company_discount,
	                'fri_comission' => $order->fri_comission,
                        'fri_customer_discount' => $order->fri_customer_discount,
                        'fri_disc_detail' => $order->fri_disc_detail,
                        'fri_start' => $order->fri_start,
                        'fri_end' => $order->fri_end,
                        'fri_state' => $order->fri_state,
                        'fri_village' => $order->fri_village,
                        'created_date' => $order->created_date,     
                    );
                    $i++;
            }

            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['Friday Code'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

////////////////////// company information with online shop ///////////////////////
	
	public function OnlineShop()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companies = new CompanyModel();
        $allorders = $companies->onlineShopApi(); // Get Order List						
             $i = 0;
            foreach($allorders as $order){

                                $array[$i] = array(
                                                 'company_name' => $order->company_name,
                                                 'username' => $order->username,
                                                 'auth_contact' => $order->auth_contact,
						 'display_name' =>$order->display_name,
						 'mobile' =>$order->mobile,
						 'email' =>$order->email,
						 'location' =>$order->location,
						 'picture' => base_url()."/images/".$order->picture,
						 'views' =>$order->views,
						 'website' =>$order->website,
						 'instagram' =>$order->instagram,
						 'twitter' =>$order->twitter,
                                                 'facebook' =>$order->facebook,
						 'snapchat' =>$order->snapchat,
						 'category' =>$order->category,
						 'cr_number' =>$order->cr_number,
						 'address' =>$order->address,

						 'shop_state' =>$order->shop_state,
						 'shop_village' =>$order->shop_village,
						 'shop_location' =>$order->shop_location,
						 'shop_company_discount' =>$order->shop_company_discount,
                                                 'shop_disc_detail' =>$order->shop_disc_detail,
	                                         'online_link' =>$order->online_link,
	                                         'playstore_link' =>$order->playstore_link,
	                                         'ios_link' =>$order->ios_link,
	                                         'huawai_link' =>$order->huawai_link,
						 'status' =>$order->status,					
                                                 'created_date' => $order->created_date, 
						 'updated_date' => $order->updated_date,    
                                               );
                                         $i++;
                                       }
            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['Online Shop'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

	
	

//////// product detail by company name /////////////////


public function ProductDetailsByCompany()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $company_name =  $this->request->getPost("company_name");
        if($company_name){

                $productModel = new ProductModel();

                $allorders = $productModel->getProductByCompany($company_name); // return count value
                   
                 $i = 0;
                foreach($allorders as $order){
                   
                    $array[$i] = array(
                        
                        'id' => $order->id,
                        'company_name' => $order->company_name,
                        'governorate' => $order->governorate,
                        'state' => $order->state,
                        'village' => $order->village,
                        'product_name' => $order->product_name,
                        'description' => $order->description,
                        'picture' => base_url()."/images/".$order->picture,
                        'quantity' => $order->quantity,
                        'price' => $order->price,
                        'discount_price' => $order->discount_price, 
						'status' => $order->status,
                        'created_date' => $order->created_date,
                    );
                    $i++;
                }
    
                if($allorders)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['allorders'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'No Company Found';
                }

 
        } else {
            $data['message'] = "Please Enter Company";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }
	
	
	
//////////////////// company detail by state /////////////////

public function CompanyDetailsByState()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $state_name =  $this->request->getPost("state_name");
        if($state_name){

                $companyModel = new CompanyModel();

                $alldetails = $companyModel->getCompanyInfoBystate($state_name); // return count value
                   
                 $i = 0;
                foreach($alldetails as $detail){
                   
                    $array[$i] = array(
                        
                        'company_name' => $detail->company_name,
                        'username' => $detail->username,
                        'auth_contact' => $detail->auth_contact,
			'display_name' =>$detail->display_name,
			'mobile' =>$detail->mobile,
			'email' =>$detail->email,
			'location' =>$detail->location,
			'picture' => base_url()."/images/".$order->picture,
			'views' =>$detail->views,
			'website' =>$detail->website,
			'instagram' =>$detail->instagram,
			'twitter' =>$detail->twitter,
                        'facebook' =>$detail->facebook,
			'snapchat' =>$detail->snapchat,
			'category' =>$detail->category,
			'cr_number' =>$detail->cr_number,
			'address' =>$detail->address,
			'status' =>$detail->status,					
                        'c_location' => $detail->c_location,
                        'company_discount' => $detail->company_discount,
                        'comission' => $detail->comission,
                        'customer_discount' => $detail->customer_discount,
                        'c_disc_detail' =>$detail->c_disc_detail,
                        'c_start' => $detail->c_start,
                        'c_end' => $detail->c_end,
			'c_state' => $detail->c_state,
			'c_village' => $detail->c_village,
                        'created_date' => $detail->created_date, 
                        'updated_date' => $detail->updated_date,
                    );
                    $i++;
                }
    
                if($alldetails)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['Company_details'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'No State Found';
                }

 
        } else {
            $data['message'] = "Please Enter State";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }
	
	
	////////////////// search Company information with city code only ///////
	
	public function SearchCompanyInfo()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $text =  $this->request->getGet("search");
        if($text){

            $companyModel = new CompanyModel();

            $searchArray = array('txtsearch'=>$text);
             //echo json_encode($searchArray); die();
            $all_info = array();
            $mediciene = $companyModel->getData($searchArray,'','',''); // return count value
            //print_r($mediciene); die();
            $i = 0;
            foreach($mediciene as $meddet){

                /*$medimgModel = new MedicineImagesModel();
                $med_img = array();
                $med_img = $medimgModel->getMedicineImagesbyMedId($meddet->id);
                $med_img = array_column($med_img, 'image_name');

                $array = $med_img;
                $med_img=explode(",", (base_url()."/medicineimages/".implode(",".base_url()."/medicineimages/", $array)));*/

                $all_info[$i]['id'] = $meddet->id;
                $all_info[$i]['company_name'] = $meddet->company_name;
                $all_info[$i]['auth_contact'] = $meddet->auth_contact;
                $all_info[$i]['display_name'] = $meddet->display_name;
				$all_info[$i]['mobile'] = $meddet->mobile;
                $all_info[$i]['email'] = $meddet->email;
                $all_info[$i]['picture'] = base_url()."/images/".$meddet->picture;	
		$all_info[$i]['views'] = $meddet->views;
                $all_info[$i]['website'] = $meddet->website;
                $all_info[$i]['instagram'] = $meddet->instagram;
			    $all_info[$i]['twitter'] = $meddet->twitter;
                $all_info[$i]['facebook'] = $meddet->facebook;
                $all_info[$i]['snapchat'] = $meddet->snapchat;
				$all_info[$i]['category'] = $meddet->category;
                $all_info[$i]['cr_number'] = $meddet->cr_number;
                $all_info[$i]['address'] = $meddet->address;
				$all_info[$i]['shop_disc'] = $meddet->shop_disc;
                $all_info[$i]['shop_comission'] = $meddet->shop_comission;
                $all_info[$i]['shop_cstmr_disc'] = $meddet->shop_cstmr_disc;
				$all_info[$i]['shop_link'] = $meddet->shop_link;
                $all_info[$i]['created_date'] = $meddet->created_date;
            
                $i++;
            }


            if(!$all_info)
            {
                $data['status'] = '0';
                $data['message'] = 'Failure';
            } else {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['company_info'] = $all_info;
            }
        } else {
            $data['response'] = 'Failure';
            $data['message'] = 'Please enter city location';
        }
        // echo json_encode($data);
        
        echo json_encode($data,JSON_PRETTY_PRINT);
        
    }
	

	////////////////// search Company information with city code onlywith state name ///////
	
	public function SearchWithState()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $text =  $this->request->getGet("search");
        if($text){

            $companyModel = new CompanyModel();

            $searchArray = array('txtsearch'=>$text);
             //echo json_encode($searchArray); die();
            $all_info = array();
            $mediciene = $companyModel->getDataWithState($searchArray,'','',''); // return count value
            //print_r($mediciene); die();
            $i = 0;
            foreach($mediciene as $meddet){

                /*$medimgModel = new MedicineImagesModel();
                $med_img = array();
                $med_img = $medimgModel->getMedicineImagesbyMedId($meddet->id);
                $med_img = array_column($med_img, 'image_name');

                $array = $med_img;
                $med_img=explode(",", (base_url()."/medicineimages/".implode(",".base_url()."/medicineimages/", $array)));*/

                $all_info[$i]['id'] = $meddet->id;
                $all_info[$i]['company_name'] = $meddet->company_name;
                $all_info[$i]['auth_contact'] = $meddet->auth_contact;
                $all_info[$i]['display_name'] = $meddet->display_name;
				$all_info[$i]['mobile'] = $meddet->mobile;
                $all_info[$i]['email'] = $meddet->email;
                $all_info[$i]['picture'] = base_url()."/images/".$meddet->picture;	
		$all_info[$i]['views'] = $meddet->views;
                $all_info[$i]['website'] = $meddet->website;
                $all_info[$i]['instagram'] = $meddet->instagram;
			    $all_info[$i]['twitter'] = $meddet->twitter;
                $all_info[$i]['facebook'] = $meddet->facebook;
                $all_info[$i]['snapchat'] = $meddet->snapchat;
				$all_info[$i]['category'] = $meddet->category;
                $all_info[$i]['cr_number'] = $meddet->cr_number;
                $all_info[$i]['address'] = $meddet->address;
				$all_info[$i]['shop_disc'] = $meddet->shop_disc;
                $all_info[$i]['shop_comission'] = $meddet->shop_comission;
                $all_info[$i]['shop_cstmr_disc'] = $meddet->shop_cstmr_disc;
				$all_info[$i]['shop_link'] = $meddet->shop_link;
                $all_info[$i]['created_date'] = $meddet->created_date;
            
                $i++;
            }

            if(!$all_info)
            {
                $data['status'] = '0';
                $data['message'] = 'Failure';
            } else {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['company_search'] = $all_info;
            }
        } else {
            $data['response'] = 'Failure';
            $data['message'] = 'Please enter city location';
        }
        // echo json_encode($data);
        
        echo json_encode($data,JSON_PRETTY_PRINT);
        
    }

/////////////////////// ASHISH - search Company information with low to high discount  /////////////////////////////////////			
    public function SearchWithLowDiscount()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $text =  $this->request->getGet("search");
        if($text){

            $companyModel = new CompanyModel();

            $searchArray = array('txtsearch'=>$text);
             //echo json_encode($searchArray); die();
            $all_info = array();
            $mediciene = $companyModel->getDataWithLowDiscount($searchArray,'','',''); // return count value
            //print_r($mediciene); die();
            $i = 0;
            foreach($mediciene as $meddet){

                /*$medimgModel = new MedicineImagesModel();
                $med_img = array();
                $med_img = $medimgModel->getMedicineImagesbyMedId($meddet->id);
                $med_img = array_column($med_img, 'image_name');

                $array = $med_img;
                $med_img=explode(",", (base_url()."/medicineimages/".implode(",".base_url()."/medicineimages/", $array)));*/

                $all_info[$i]['id'] = $meddet->id;
                $all_info[$i]['company_name'] = $meddet->company_name;
                $all_info[$i]['auth_contact'] = $meddet->auth_contact;
                $all_info[$i]['display_name'] = $meddet->display_name;
				$all_info[$i]['mobile'] = $meddet->mobile;
                $all_info[$i]['email'] = $meddet->email;
                $all_info[$i]['picture'] = base_url()."/images/".$meddet->picture;	
		$all_info[$i]['views'] = $meddet->views;
                $all_info[$i]['website'] = $meddet->website;
                $all_info[$i]['instagram'] = $meddet->instagram;
			    $all_info[$i]['twitter'] = $meddet->twitter;
                $all_info[$i]['facebook'] = $meddet->facebook;
                $all_info[$i]['snapchat'] = $meddet->snapchat;
				$all_info[$i]['category'] = $meddet->category;
                $all_info[$i]['cr_number'] = $meddet->cr_number;
                $all_info[$i]['address'] = $meddet->address;
				$all_info[$i]['shop_disc'] = $meddet->shop_disc;
                $all_info[$i]['shop_comission'] = $meddet->shop_comission;
                $all_info[$i]['shop_cstmr_disc'] = $meddet->shop_cstmr_disc;
				$all_info[$i]['shop_link'] = $meddet->shop_link;
                $all_info[$i]['created_date'] = $meddet->created_date;
            
                $i++;
            }

            if(!$all_info)
            {
                $data['status'] = '0';
                $data['message'] = 'Failure';
            } else {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['company_search'] = $all_info;
            }
        } else {
            $data['response'] = 'Failure';
            $data['message'] = 'Please enter city location';
        }
        // echo json_encode($data);
        
        echo json_encode($data,JSON_PRETTY_PRINT);
        
    }

    /////////////////////// ASHISH - search Company information with high to low discount  /////////////////////////////////////			
    public function SearchWithHighDiscount()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $text =  $this->request->getGet("search");
        if($text){
            $companyModel = new CompanyModel();
            $searchArray = array('txtsearch'=>$text);
             //echo json_encode($searchArray); die();
            $all_info = array();
            $mediciene = $companyModel->getDataWithHighDiscount($searchArray,'','',''); // return count value
            //print_r($mediciene); die();
            $i = 0;
            foreach($mediciene as $meddet){

                /*$medimgModel = new MedicineImagesModel();
                $med_img = array();
                $med_img = $medimgModel->getMedicineImagesbyMedId($meddet->id);
                $med_img = array_column($med_img, 'image_name');

                $array = $med_img;
                $med_img=explode(",", (base_url()."/medicineimages/".implode(",".base_url()."/medicineimages/", $array)));*/

                $all_info[$i]['id'] = $meddet->id;
                $all_info[$i]['company_name'] = $meddet->company_name;
                $all_info[$i]['auth_contact'] = $meddet->auth_contact;
                $all_info[$i]['display_name'] = $meddet->display_name;
				$all_info[$i]['mobile'] = $meddet->mobile;
                $all_info[$i]['email'] = $meddet->email;
                $all_info[$i]['picture'] = base_url()."/images/".$meddet->picture;	
		$all_info[$i]['views'] = $meddet->views;
                $all_info[$i]['website'] = $meddet->website;
                $all_info[$i]['instagram'] = $meddet->instagram;
			    $all_info[$i]['twitter'] = $meddet->twitter;
                $all_info[$i]['facebook'] = $meddet->facebook;
                $all_info[$i]['snapchat'] = $meddet->snapchat;
				$all_info[$i]['category'] = $meddet->category;
                $all_info[$i]['cr_number'] = $meddet->cr_number;
                $all_info[$i]['address'] = $meddet->address;
				$all_info[$i]['shop_disc'] = $meddet->shop_disc;
                $all_info[$i]['shop_comission'] = $meddet->shop_comission;
                $all_info[$i]['shop_cstmr_disc'] = $meddet->shop_cstmr_disc;
				$all_info[$i]['shop_link'] = $meddet->shop_link;
                $all_info[$i]['created_date'] = $meddet->created_date;
            
                $i++;
            }

            if(!$all_info)
            {
                $data['status'] = '0';
                $data['message'] = 'Failure';
            } else {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['company_search'] = $all_info;
            }
        } else {
            $data['response'] = 'Failure';
            $data['message'] = 'Please enter city location';
        }
        // echo json_encode($data);
        
        echo json_encode($data,JSON_PRETTY_PRINT);
        
    }
	

			
///////////////////////  26 June /////////////////////////////////////			
/////////////////////// Customer Entire Information //////////////////

public function CustomerInfo()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $user_id =  $this->request->getPost("user_id");
        if($user_id){

                $customerModel = new CustomerModel();

                $inforamations = $customerModel->customerInfo($user_id); // return count value
                   
                 $i = 0;
                foreach($inforamations as $info){
                   
                    $array[$i] = array(
                        

                        'name' => $info->name,
						'family_name' => $info->family_name,						
                        'mobile' => $info->mobile,
						'email' => $info->email,
                        'city_code' => $info->city_code,
						'famous_code' => $info->famous_code,
						'sex' => $info->sex,
						'date_of_birth' => $info->date_of_birth,
						'nationality' => $info->nationality,
                        'governorate' => $info->nationality,
                        'state' => $info->state,
                        'village' => $info->village,
						'language' => $info->language,
                        'profile' => $info->profile,
						'status' => $info->status,
                        'created_date' => $info->created_date,
						'updated_date' => $info->updated_date,
                    );
                    $i++;
                }
    
                if($inforamations)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['inforamations'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'Not Found';
                }
 
        } else {
            $data['message'] = "Please Enter Customer Id";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }
	
/////////////////////// Customer Favorite //////////////////

public function CustomerFavorite()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $user_id =  $this->request->getPost("user_id");
        if($user_id){

                $companyModel = new CompanyModel();

                $favorites = $companyModel->customerFavorite($user_id); // return count value
                   
                 $i = 0;
                foreach($favorites as $detail){
                   
                    $array[$i] = array(
                        
                         'company_name' => $detail->company_name,
                         'auth_contact' => $detail->auth_contact,
						 'display_name' =>$detail->display_name,
						 'mobile' =>$detail->mobile,
						 'email' =>$detail->email,
						 'views' =>$detail->views,
						 'website' =>$detail->website,
						 'instagram' =>$detail->instagram,
						 'twitter' =>$detail->twitter,
                         'facebook' =>$detail->facebook,
						 'snapchat' =>$detail->snapchat,
						 'status' =>$detail->status,					
                         'c_location' => $detail->c_location,
						 'c_discount' => $detail->c_discount,
                         'company_id' => $detail->company_id,
                         'c_disc_detail' =>$detail->c_disc_detail,
                         'c_start' => $detail->c_start,
                         'c_end' => $detail->c_end,
						'c_state' => $detail->c_state,
						'c_village' => $detail->c_village,

                    );
                    $i++;
                }
    
                if($favorites)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['favorites'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'Not Found';
                }

        } else {
            $data['message'] = "Please Enter Customer Id";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }
	
	
/////////////////////////////////// update mobile no ///////////////////////////////////////////////

public function updateMobileNo()
    {	
	
	$data = array('status' => '1', 'message' => 'Failure');
	    $customerModel = new CustomerModel();
		
		if ($this->request->getPost()) 
        {            
        $user_id = $this->request->getPost('user_id');            
        $mobile =$this->request->getPost('mobile');
		
		if($user_id!= "" && $mobile!= "")
        {     
        $totalRecord = $customerModel->checkMobileExist($mobile);
        if($totalRecord > 0){
        $data['message'] = 'Mobile Number Already Exist';
        }
		
		if($customerModel->getCustomerID($user_id)){
		
        $arrSaveData = array(
            'mobile'=>$mobile,
          );

        $Update = $customerModel->where('id',$user_id)->set($arrSaveData)->update();  
            if($Update) {    
                        $data['status'] = '0';
                        $data['message'] = 'Udated Successfully';
                        $data['user_id'] = $user_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Not Updated';
                    }					
			    } 
				else {
                   $data['status'] = '0';
                   $data['message'] = 'This customer not exists in database.';
               }
			   
		    } else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
                }   
			} 
				else {
                   $data['status'] = '4';
                   $data['message'] = 'Invalid Access';
               }
                 echo json_encode($data);
            }
			
			
////////////////////////////// update Location ///////////////////////////


 public function updateLocation()
   {		
	$data = array('status' => '1', 'message' => 'Failure');
	    $customerModel = new CustomerModel();
		
		if ($this->request->getPost()) 
        {            
        $user_id = $this->request->getPost('user_id');            
        $state =$this->request->getPost('state');
		$village =$this->request->getPost('village');		    
		
		if($customerModel->getCustomerID($user_id)){
		
        $arrSaveData = array(
            'state'=>$state,
	    'village'=>$village
          );

        $Update = $customerModel->where('id',$user_id)->set($arrSaveData)->update();  
            if($Update) {    
                        $data['status'] = '0';
                        $data['message'] = 'Udated Successfully';
                        $data['user_id'] = $user_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Not Updated';
                    }					
			    } 
		      
			} 
				else {
                   $data['status'] = '4';
                   $data['message'] = 'Invalid Access';
               }
                 echo json_encode($data);
            }
			
			
////////////////////////////// update Category ///////////////////////////


 public function updateCategory()
   {		
	$data = array('status' => '1', 'message' => 'Failure');
	    $customerModel = new CustomerModel();
		
		if ($this->request->getPost()) 
        {            
        $user_id = $this->request->getPost('user_id');            
        $category =$this->request->getPost('category');	
		
		if($user_id!= "" && $category!= "")
              {	    
		
		if($customerModel->getCustomerID($user_id)){
		
        $arrSaveData = array(
            'category'=>$category,
          );

        $Update = $customerModel->where('id',$user_id)->set($arrSaveData)->update(); 
		
            if($Update) {    
                        $data['status'] = '0';
                        $data['message'] = 'Category Udated Successfully';
                        $data['user_id'] = $user_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Category Not Updated';
                    }					
		 }
	      }				 
		else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
                }
	     } 
		  else {
                   $data['status'] = '4';
                   $data['message'] = 'Invalid Access';
                }
                 echo json_encode($data);
            }
			
			
	////////////////////////////// update Status ///////////////////////////


public function updateStatus()
   {		
	$data = array('status' => '1', 'message' => 'Failure');
	    $customerModel = new CustomerModel();
		
		if ($this->request->getPost()) 
        {            
        $user_id = $this->request->getPost('user_id');            
        $status = $this->request->getPost('status');	
		
		if($user_id!= "" && $status!= "")
        {	    
		
		if($customerModel->getCustomerID($user_id)){
		
        $arrSaveData = array(
            'status' => $status,
          );

        $Update = $customerModel->where('id',$user_id)->set($arrSaveData)->update(); 
		
            if($Update) {    
                        $data['status'] = '0';
                        $data['message'] = 'Status Udated Successfully';
                        $data['user_id'] = $user_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Status Not Updated';
                    }					
			    }
		    }				 
			  else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
                }
		    } 
			    else {
                   $data['status'] = '4';
                   $data['message'] = 'Invalid Access';
                }
                 echo json_encode($data);
            }

//////////////////// customer he purchased /////////////////

public function CustomerTransactionInfo()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $user_id =  $this->request->getPost("user_id");
        if($user_id){

                $transactionModel = new TransactionModel();
                $inforamations = $transactionModel->customerPurchase($user_id); // return count value
                   
                 $i = 0;
                foreach($inforamations as $order){
                   
                    $array[$i] = array(
					
			'product_name' => $order->product_name,
                        'company_name' => $order->company_name,						
			'c_location' =>$order->c_location,
			'company_discount' =>$order->company_discount,
			'comission' =>$order->comission,
			'customer_discount' =>$order->customer_discount,
			'c_discount' =>$order->c_discount,
			'c_disc_detail' =>$order->c_disc_detail,
			'c_start' =>$order->c_start,
                        'c_end' =>$order->c_end,
			'c_state' =>$order->c_state,
			'c_village' =>$order->c_village,

			'fam_location' =>$order->fam_location,
			'fam_company_discount' =>$order->fam_company_discount,
			'fam_comission' =>$order->fam_comission,
			'fam_customer_discount' =>$order->fam_customer_discount,
			'fam_discount' =>$order->fam_discount,
			'fam_disc_detail' =>$order->fam_disc_detail,
			'fam_start' =>$order->fam_start,
                        'fam_end' =>$order->fam_end,
			'fam_state' =>$order->fam_state,
			'fam_village' =>$order->fam_village,	

			'fri_location' =>$order->fri_location,
			'fri_company_discount' =>$order->fri_company_discount,
			'fri_comission' =>$order->fri_comission,
			'fri_customer_discount' =>$order->fri_customer_discount,
			'fri_discount' =>$order->fri_discount,
			'fri_disc_detail' =>$order->fri_disc_detail,
			'fri_start' =>$order->fri_start,
                        'fri_end' =>$order->fri_end,
			'fri_state' =>$order->fri_state,
			'fri_village' =>$order->fri_village,

			'shop_state' =>$order->shop_state,
			'shop_village' =>$order->shop_village,
			'shop_location' =>$order->shop_location,
			'shop_company_disc' =>$order->shop_company_disc,
			'shop_discount_details' =>$order->shop_discount_details,
			'online_link' =>$order->online_link,
			'playstore_link' =>$order->playstore_link,
                        'ios_link' =>$order->ios_link,
			'huawai_link' =>$order->huawai_link,
                        'points' => $order->points,
                        'created_date' => $order->created_date 						
                    );
                    $i++;
                }    
                if($inforamations)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['inforamations'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'Not Found';
                }
 
        } else {
            $data['message'] = "Please Enter Customer Id";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }	


//////////////////// customer he purchased points /////////////////

public function CustomerTransactionPoints()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $user_id =  $this->request->getPost("user_id");
        $points =  $this->request->getPost("points");
        if($user_id && $points){

                $transactionModel = new TransactionModel();
                $inforamations = $transactionModel->customerPurchasePoints($user_id, $points); // return count value
                   
                 $i = 0;
                foreach($inforamations as $order){
                   
                    $array[$i] = array(
					
			'product_name' => $order->product_name,
                        'company_name' => $order->company_name,						
			'c_location' =>$order->c_location,
			'company_discount' =>$order->company_discount,
			'comission' =>$order->comission,
			'customer_discount' =>$order->customer_discount,
			'c_discount' =>$order->c_discount,
			'c_disc_detail' =>$order->c_disc_detail,
			'c_start' =>$order->c_start,
                        'c_end' =>$order->c_end,
			'c_state' =>$order->c_state,
			'c_village' =>$order->c_village,

			'fam_location' =>$order->fam_location,
			'fam_company_discount' =>$order->fam_company_discount,
			'fam_comission' =>$order->fam_comission,
			'fam_customer_discount' =>$order->fam_customer_discount,
			'fam_discount' =>$order->fam_discount,
			'fam_disc_detail' =>$order->fam_disc_detail,
			'fam_start' =>$order->fam_start,
                        'fam_end' =>$order->fam_end,
			'fam_state' =>$order->fam_state,
			'fam_village' =>$order->fam_village,	

			'fri_location' =>$order->fri_location,
			'fri_company_discount' =>$order->fri_company_discount,
			'fri_comission' =>$order->fri_comission,
			'fri_customer_discount' =>$order->fri_customer_discount,
			'fri_discount' =>$order->fri_discount,
			'fri_disc_detail' =>$order->fri_disc_detail,
			'fri_start' =>$order->fri_start,
                        'fri_end' =>$order->fri_end,
			'fri_state' =>$order->fri_state,
			'fri_village' =>$order->fri_village,

			'shop_state' =>$order->shop_state,
			'shop_village' =>$order->shop_village,
			'shop_location' =>$order->shop_location,
			'shop_company_disc' =>$order->shop_company_disc,
			'shop_discount_details' =>$order->shop_discount_details,
			'online_link' =>$order->online_link,
			'playstore_link' =>$order->playstore_link,
                        'ios_link' =>$order->ios_link,
			'huawai_link' =>$order->huawai_link,
                        'points' => $order->points,
                        'created_date' => $order->created_date 						
                    );
                    $i++;
                }    
                if($inforamations)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['inforamations'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'Not Found';
                }
 
        } else {
            $data['message'] = "Please Enter Customer Id and Points";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }

////////////////////////////// Favourite Api //////////////////////////////////

public function createFavouriteApi()
    {
        $data = array('status' => '1', 'message' => 'Failure');
        $favouriteModel = new FavouriteModel();
        
        if ($this->request->getPost()) 
        {		
            $customer_id = $this->request->getPost('customer_id');
            $company_id = $this->request->getPost('company_id');
	
            if($customer_id!= "" && $company_id!= "" )
            { 
               $totalRecord = $favouriteModel->FavouriteExist($customer_id, $company_id);
                if($totalRecord > 0){
                    $data['message'] = 'Already Exist';
                } else {
     
                    $arrSaveData = array(
                    'customer_id'=>$customer_id,
                    'company_id'=>$company_id
                    );
                   
                    $favouriteModel->save($arrSaveData);
                    $favourite_id = $favouriteModel->getInsertID();

                    if($favourite_id) {    
                        $data['status'] = '0';
                        $data['message'] = 'Successfully added in Favourite.';
                        $data['favourite_id'] = $favourite_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'not Created';
                    }
                } }
            else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
            }
        } else {
            $data['status'] = '4';
            $data['message'] = 'Invalid Access';
        }

        echo json_encode($data);        
    }


/////////////////////////////// remove from favourite //////////////////////////////

public function deleteApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $favouriteModel = new FavouriteModel();
        
        if ($this->request->getPost()) 
        {
             $favourite_id = $this->request->getPost('favourite_id');

            if($favourite_id!= "")
            {

                if($favouriteModel->getCustomerID($favourite_id)){
				
                $Update = $favouriteModel->where('id',$favourite_id)->delete();

                if($Update) {
                    $data['status'] = '1';
                    $data['message'] = 'Successfully removed from favourite.';
                } else {
                    $data['message'] = 'Not Updated';
                }                             
               }
			}
			else {
                $data['message'] = 'Please Enter All values';
            }
        } else {
            $data['message'] = 'Invalid Access';
        }
        echo json_encode($data);
    }
				
////////////////////////// get village api ///////////////////////

public function getVillage()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $state_id =  $this->request->getPost("state_id");
        if($state_id){

                $stateModel = new StateModel();
                $cityModel = new CityModel();

                $values = $stateModel->get_village($state_id); // return count value
                   
                 $i = 0;
                foreach($values as $value){
                   
                    $array[$i] = array(                       
                        'city_id' => $value->city_id,
                        'city_name' => $value->city_name,
                        'state_id' => $value->state_id,
                    );
                    $i++;
                }
    
                if($values)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['village'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'Data Not Found';
                }

 
        } else {
            $data['message'] = "Please Enter state Id";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }


//////////////////////// count views ////////////////////////

public function viewsCount()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companyModel = new CompanyModel();
        
        if ($this->request->getPost()) 
        {
             $company_id = $this->request->getPost('company_id');

            if($company_id!= "")
            {
        $companies = $companyModel->getCompanyID($company_id);
        if($company_id){
				
        $arrSaveData = array(
            'count'=>  $companies['count'] + 1,
          );

        $Update = $companyModel->where('id',$company_id)->set($arrSaveData)->update();  

                if($Update) {
                    $data['status'] = '1';
                    $data['message'] = 'view count added successfully.';
                } else {
                    $data['message'] = 'Not Updated';
                }                             
               }
	     }
		else {
                $data['message'] = 'Please Enter Company Id';
            }
        } else {
            $data['message'] = 'Invalid Access';
        }
        echo json_encode($data);
    }

////////////// company information with home api ///////////////////////
	
public function Home()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $companies = new CompanyModel();
        $allorders = $companies->HomeApi(); // Get Order List
						
             $i = 0;
            foreach($allorders as $order){

$date1 = $order->c_end; 
$date2 = $order->c_start; 
$diff = abs(strtotime($date2) - strtotime($date1)); 
$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 


$fam_date1 = $order->fam_end; 
$fam_date2 = $order->fam_start; 
$diff1 = abs(strtotime($fam_date2) - strtotime($fam_date1)); 
$years1   = floor($diff1 / (365*60*60*24)); 
$months1  = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24)); 
$days1    = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));
$hours1   = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24)/ (60*60)); 
$minuts1  = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24 - $hours1*60*60)/ 60); 
$seconds1 = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24 - $days1*60*60*24 - $hours1*60*60 - $minuts1*60)); 


$fri_date1 = $order->fri_end; 
$fri_date2 = $order->fri_start; 
$diff2 = abs(strtotime($fri_date2) - strtotime($fri_date1)); 
$years2   = floor($diff2 / (365*60*60*24)); 
$months2  = floor(($diff2 - $years2 * 365*60*60*24) / (30*60*60*24)); 
$days2    = floor(($diff2 - $years2 * 365*60*60*24 - $months2*30*60*60*24)/ (60*60*24));
$hours2   = floor(($diff2 - $years2 * 365*60*60*24 - $months2*30*60*60*24 - $days2*60*60*24)/ (60*60)); 
$minuts2  = floor(($diff2 - $years2 * 365*60*60*24 - $months2*30*60*60*24 - $days2*60*60*24 - $hours2*60*60)/ 60); 
$seconds2 = floor(($diff2 - $years2 * 365*60*60*24 - $months2*30*60*60*24 - $days2*60*60*24 - $hours2*60*60 - $minuts2*60)); 


                    $array[$i] = array(
                        'company_name' => $order->company_name,
			'username' => $order->username,
                        'auth_contact' => $order->auth_contact,
			'display_name' =>$order->display_name,
			'mobile' =>$order->mobile,
			'email' =>$order->email,
			'location' =>$order->location,
			'picture' => base_url()."/images/".$order->picture,
			'views' =>$order->views,
			'website' =>$order->website,
			'instagram' =>$order->instagram,
			'twitter' =>$order->twitter,
                        'facebook' =>$order->facebook,
			'snapchat' =>$order->snapchat,
			'category' =>$order->category,
			'cr_number' =>$order->cr_number,
			'address' =>$order->address,
			'status' =>$order->status,
                        'company_id' => $order->company_id,					
                        'c_location' => $order->c_location,
			'company_discount' => $order->company_discount,
                        'comission' => $order->comission,
                        'customer_discount' => $order->customer_discount,
                        'c_disc_detail' => $order->c_disc_detail,
                        'c_start' => $order->c_start,
			'c_end' => $order->c_end,
			'c_state' => $order->c_state,
			'c_village' => $order->c_village,
                        'c_timing' => ($days . ' Days ' .',' .$hours .':' .$minuts.':' .$seconds),                        

                        'fam_location' => $order->fam_location,
                        'fam_company_discount' => $order->fam_company_discount,
	                'fam_comission' => $order->fam_comission,
                        'fam_customer_discount' => $order->fam_customer_discount,
                        'fam_disc_detail' => $order->fam_disc_detail,
                        'fam_start' => $order->fam_start,
                        'fam_end' => $order->fam_end,
                        'fam_state' => $order->fam_state,
                        'fam_village' => $order->fam_village,
                        'fam_timing' => ($days1 . ' Days ' .',' .$hours1 .':' .$minuts1.':' .$seconds1),

                        'fri_location' => $order->fri_location,
                        'fri_company_discount' => $order->fri_company_discount,
	                'fri_comission' => $order->fri_comission,
                        'fri_customer_discount' => $order->fri_customer_discount,
                        'fri_disc_detail' => $order->fri_disc_detail,
                        'fri_start' => $order->fri_start,
                        'fri_end' => $order->fri_end,
                        'fri_state' => $order->fri_state,
                        'fri_village' => $order->fri_village,
                        'fri_timing' => ($days2 . ' Days ' .',' .$hours2 .':' .$minuts2.':' .$seconds2),

                        'created_date' => $order->created_date,
                        'count' => $order->count,  
                    );
                    $i++;
            }

            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['City Code'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

/////////////// interest category api ///////////////////////////////////////

public function interestCategoryApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $allorders = array("Restaurants", "Perfumes", "Health & Beauty", "Hotels", "Furniture & House Holds", "Cars", "Clothes & Shops", "Travel & tourism"); 
						
            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['interest_category'] = $allorders;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

////////////////////////// interest api ////////////////////


public function interestApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $category = $this->request->getPost('category');

        $companies = new CompanyModel();
        $allorders = $companies->interestApi($category);
						
             $i = 0;
            foreach($allorders as $order){

            $array[$i] = array(
             'company_name' => $order->company_name,
	     'picture' => base_url()."/images/".$order->picture,	   
            );
         $i++;
       }

            if($allorders)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['interest_api'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Orders Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }
//////////////////////////// contact us ////////////////////////////

public function ContactUs()
    {
        $data = array('status' => '0', 'message' => 'Failure');
        $contactus = new ContactUsModel();
        
        if ($this->request->getPost()) 
        {		
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('mobile');
            $enquiry = $this->request->getPost('enquiry');
	                    
                    $arrSaveData = array(
                    'email'=>$email,
                    'mobile'=>$mobile,										
		    'enquiry'=>$enquiry,
                    );

                    $contactus->save($arrSaveData);
                    $UserId = $contactus->getInsertID();

                    if($UserId) {    
                        $data['status'] = '1';
                        $data['message'] = 'Account Created Successfully';
                        $data['user_id'] = $UserId;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Account not Created';
                        $data['user_id'] = '';
                    }                                 
                  } else {
                      $data['status'] = '4';
                      $data['message'] = 'Invalid Access';
                      $data['user_id'] = '';
                   }
                 echo json_encode($data);        
              }


///////////////////// PublicApi//////////////////////////////

public function PublicApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');
            $companies = new CompanyModel(); 
            $percent = '%';       
            $allorders_1 = $companies->public_citycodeapi_1();
						                    
            $i = 0;
            foreach($allorders_1 as $order){   
			
		$shops = $companies->OnlineShopApi($order->id);
	    $banners = $companies->public_banner($order->id); 
            
        $allorders_2 = $companies->public_citycodeapi_2($order->id);

        $vips = $companies->public_vipcodeapi_2($order->id); 

        $fridays = $companies->public_fridaycodeapi_2($order->id);  

		$g = 0; 
                if($banners){    
                foreach($banners as $item){
                    $array5[$g] = array(
			'banner_image' => base_url()."/company/".$item->banner,
                    );
                    $g++; 
                    $data5 = $array5;                                    
                } 
              } else {
	            $array5 = array();                     
                    $data5 = $array5;				
		}
 				
		$j = 0;    
                if($allorders_2){ foreach($allorders_2 as $item){
                    $array1[$j] = array(
			             'c_branch' => $item->branch_name,
                         'c_location' => $item->location,
			             'c_company_discount' => $item->company_discount.$percent,
                         'c_codeapp_comission' => $item->comission.$percent,
                         'c_customer_discount' => $item->customer_discount.$percent,
                         'c_discount_detail' => $item->discount_detail,
                         'c_description' => $item->description,
			              'c_state' =>$item->state,
			              'c_village' =>$item->village,
                        'c_start' => date('Y-m-d', strtotime($item->start_date)),
                        'c_end' => date('Y-m-d', strtotime($item->end_date)),
                    );
                    $j++; 
                    $data111 = $array1;                                    
                }
              } else {
	            $array1 = array();                     
                    $data111 = $array1;				
		}
  
				
				
		$k = 0;    
                   if($vips) { foreach($vips as $item){
                    $array2[$k] = array(
			            'vip_branch' => $item->branch_name,
                        'vip_location' => $item->location,
			            'vip_company_discount' => $item->company_discount.$percent,
                        'vip_codeapp_comission' => $item->comission.$percent,
                        'vip_customer_discount' => $item->customer_discount.$percent,
                        'vip_discount_detail' => $item->discount_detail,
                        'vip_description' => $item->description,
			             'vip_state' =>$item->state,
			            'vip_village' =>$item->village,
                        'vip_start' => date('Y-m-d', strtotime($item->start_date)),
                        'vip_end' => date('Y-m-d', strtotime($item->end_date)),

                    );
                    $k++; 
                    $data222 = $array2;                                    
                } 
              } else {
	            $array2 = array();                     
                    $data222 = $array2;				
		}

								
		$t = 0;    
                 if($fridays) { foreach($fridays as $item){
                    $array3[$t] = array(
			           'fri_branch' => $item->branch_name,
                        'fri_location' => $item->location,
			            'fri_company_discount' => $item->company_discount,
                        'fri_codeapp_comission' => $item->comission.$percent,
                        'fri_customer_discount' => $item->customer_discount.$percent,
                        'fri_discount_detail' => $item->discount_detail.$percent,
                        'fri_description' => $item->description,
			            'fri_state' =>$item->state,
			            'fri_village' =>$item->village,
                        'fri_start' => date('Y-m-d', strtotime($item->start_date)),
                        'fri_end' => date('Y-m-d', strtotime($item->end_date)),

                    );
                    $t++; 
                    $data333 = $array3;                                    
                }
              } else {
	            $array3 = array();                     
                    $data333 = $array3;				
		}


	   $f = 0;    
                if($shops) { foreach($shops as $shop){			                  
                    $array4[$f] = array(
                        'shop_description' => $shop->description,
                        'online_link' => $shop->online_link,
                        'playstore_link' => $shop->playstore_link,
                        'ios_link' => $shop->ios_link,
                        'huawai_link' => $shop->huawai_link,
                    );
                   $f++;
                    $data4 = $array4;                                    
              }
              } else {
	            $array4 = array();                     
                    $data4 = $array4;				
		}

 												            
                 $array[$i] = array(
                        'company_id' => $order->id,
                        'company_name' => $order->company_name,
			'username' => $order->username,
                        'auth_contact' => $order->auth_contact,
			'display_name' =>$order->display_name,
			'mobile' =>$order->mobile,
			'email' =>$order->email,
			'location' =>$order->location,
			'picture' => base_url()."/company/".$order->picture,
			'views' =>$order->views,
			'website' =>$order->website,
			'instagram' =>$order->instagram,
			'twitter' =>$order->twitter,
                        'facebook' =>$order->facebook,
			'snapchat' =>$order->snapchat,
			'category' =>$order->category,
			'cr_number' =>$order->cr_number,
			'address' =>$order->address,
			'status' =>$order->status,
		
		        'banner' => $data5,
                        'city_code' => $data111,
			'vip_code' => $data222, 
			'friday_code' => $data333,

			'online_shop' => $data4,

                );
		$i++; 
             //   $data = $array;
                unset($array1, $array2, $array3, $array4, $array5);				                 
            }
                              
          if($allorders_1)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['alldetails'] = $array;
                // $data['citycode'] = $array1;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Records Found';
            } 
        
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }


////////////////////////// product detail mew /////////////////////////

public function NewApi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

	$company_name =  $this->request->getPost("company_name");
        if($company_name){

            $productModel = new ProductModel();			
            $products = $productModel->CompanyName($company_name);
						                    
            $i = 0;
            foreach($products as $order){   		
               $results = $productModel->getProductByCompany($order->company_name); 				
				
		$k = 0;    
                   if($results) { foreach($results as $row){
                    $array2[$k] = array(
			'branch' => $row->branch,
			'product_name' => $row->product_name,
			'description' => $row->description,
			'picture' => base_url()."/images/".$row->picture,
			'quantity' => $row->quantity,

			'price' => $row->price,				
                    );
                    $k++; 
                    $data222 = $array2;                                    
                 } 
              } else {
	            $array2 = array();                     
                    $data222 = $array2;				
		}
																		            
                 $array[$i] = array(
                        'company_name' => $order->company_name,	
			'product_detail' => $data222, 

                );
		$i++; 
                unset($array2);				                 
            }
                              
          if($products)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['alldetails'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Records Found';
            }

        } else {
            $data['message'] = "Please Enter Company";
        }
        
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }

////////////////////////////// city code bannerr //////////////////////


public function CityCodeBanner()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $bannerModel = new AdBannerModel();
        $results = $bannerModel->getBanner(); 						
             $i = 0;
            foreach($results as $row){

                    $array[$i] = array(

                         'city_code_banner' => base_url()."/advertisement/".$row->banner,

                    );
                    $i++;
            }

            if($results)
            {
                $data['status'] = '1';
                $data['message'] = 'Success';
                $data['City Code Banner'] = $array;
            } else {
                $data['status'] = '0';
                $data['message'] = 'No Banner Found';
            } 
      
        echo json_encode($data, JSON_PRETTY_PRINT); 
    }


///////////////////////////////// profile view ///////////////////////////

public function Profile()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $customer_id =  $this->request->getPost("customer_id");
        if($customer_id){

                $customerModel = new CustomerModel();
                $results = $customerModel->getProfile($customer_id); // return count value
                   
                 $i = 0;
                foreach($results as $ress){
                   
                    $array[$i] = array(
                        
                        'id' => $ress->id,
                        'name' => $ress->company_name,
                        'interest' => $ress->interest,
                        'family_name' => $ress->family_name,
                        'city_code' => $ress->city_code,
                        'vip_code' => $ress->vip_code,
                        'gender' => $ress->gender,
                        'date_of_birth' => $ress->date_of_birth,
                        'mobile' => $ress->mobile,
                        'email' => $ress->email,
                        'profile' => base_url()."/images/".$ress->profile,
                        'nationality' => $ress->nationality,
                        'governcorate' =>  $ress->governorate,
                        'state' =>  $ress->state,
                        'language' => $ress->language,
                        'commission' => $ress->commission,
                        'start_date' => $ress->start_date,
                        'end_date' => $ress->end_date,
						'status' =>  $ress->status,
                    );
                    $i++;
                }
    
                if($results)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['profile'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'No Customer Found';
                }

 
        } else {
            $data['message'] = "Please Enter Customer Id";
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }
	
	
	/////////////////////////// update profile ////////////////////////////
								
public function UpdateProfile()
   {		
	$data = array('status' => '0', 'message' => 'Failure');
	    $customerModel = new CustomerModel();
		
		if ($this->request->getPost()) 
        {  
		$user_id = $this->request->getPost('user_id');           
        $name = $this->request->getPost('name');            
        $interest =$this->request->getPost('interest');	
		$family_name = $this->request->getPost('family_name');
		$gender = $this->request->getPost('gender');
		$date_of_birth = $this->request->getPost('date_of_birth');
		$mobile = $this->request->getPost('mobile');
        $email = $this->request->getPost('email');
        $profile = $this->request->getPost('profile');
        $nationality = $this->request->getPost('nationality');
        $governorate = $this->request->getPost('governorate');
        $state = $this->request->getPost('state');
        $language = $this->request->getPost('language');
        $commission = $this->request->getPost('commission');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
		
if($user_id!= "" )
        {
		if($customerModel->getCustomerID($user_id)){
		
        $arrSaveData = array(
                        'name' => $name,
                        'interest' => $interest,
                        'family_name' => $family_name,
                        'gender' => $gender,
                        'date_of_birth' => $date_of_birth,
                        'mobile' => $mobile,
                        'email' => $email,
                        'profile' => $profile,
                        'nationality' => $nationality,
                        'governorate' =>  $governorate,
                        'state' =>  $state,
                        'language' => $language,
                        'commission' => $commission,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
          );

        $Update = $customerModel->where('id',$user_id)->set($arrSaveData)->update(); 
		
            if($Update) {    
                        $data['status'] = '1';
                        $data['message'] = 'Profile Updated Successfully';
                        $data['user_id'] = $user_id;
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Profile Not Updated';
                    }					
		        }
		     }				 
			  else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter user_id';
                }
		    }
	      
		  else {
                   $data['status'] = '4';
                   $data['message'] = 'Invalid Access';
                }
                 echo json_encode($data);
            }

	///////////////////////// v.i.p code /////////////////////////////
	
	public function VipCode()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $vip_code =  $this->request->getPost("vip_code");
        if($vip_code){

                $customerModel = new CustomerModel();
                $results = $customerModel->getVipCode($vip_code); // return count value
                   
                 $i = 0;
                foreach($results as $row){
                   
                    $array[$i] = array(                        
                        'name' => $row->company_name,
                        'profile' => base_url()."/images/".$row->profile,
                    );
                    $i++;
                }    
                if($results)
                {
                    $data['status'] = '1';
                    $data['message'] = 'Success';
                    $data['V.I.P Customer'] = $array;
                } else {
                    $data['status'] = '0';
                    $data['message'] = 'V.I.P Code Not Found';
                } 
               } else {
                    $data['message'] = "Please Enter V.I.P Code";
                 }       
        echo json_encode($data,JSON_PRETTY_PRINT); 
    }	
	
	
	//////////////////////////// add profile //////////////////////////	
	
	public function add_profile()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $customerModel = new CustomerModel();
        
        if ($this->request->getPost()) 
        {		
            $name = $this->request->getPost('name');
            $interest = $this->request->getPost('interest');
			$family_name = $this->request->getPost('family_name');            
			$gender = $this->request->getPost('gender');
			$date_of_birth = $this->request->getPost('date_of_birth');
			$mobile = $this->request->getPost('mobile');
			$email = $this->request->getPost('email');
            $nationality = $this->request->getPost('nationality');						
            $governorate = $this->request->getPost('governorate');
            $state = $this->request->getPost('state');
            $language = $this->request->getPost('language');
            $created_date = $this->request->getPost('created_date');	

 $file = $this->request->getFile("profile");
 $file_type = $file->getClientMimeType();
 $valid_file_types = array("image/png", "image/jpeg", "image/jpg");
 if (in_array($file_type, $valid_file_types)) {
 $profile = $file->getName();
if ($file->move("images", $profile)) {
              				                   
                    $arrSaveData = array(
                    'name'=>$name,
                    'interest'=>$interest,
					'family_name'=>$family_name,
					'gender'=>$gender,
					'date_of_birth'=>$date_of_birth,
                    'mobile'=>$mobile,	
					'email'=>$email,
                    'nationality'=>$nationality,
                    'governorate'=>$governorate,
                    'state'=>$state,										    
                    'language'=>$language,   
                    'profile'=>$profile,
                    'created_date' => date('Y-m-d H:i:s'),
                    'city_code' => ucfirst(substr($name, 0, 1)).mt_rand(1000, 9999),
                    );
                    $customerModel->save($arrSaveData);
                    $UserId = $customerModel->getInsertID();

                    if($UserId) {    
                        $data['status'] = '1';
                        $data['message'] = 'Account Created Successfully';
                        $data['city_code'] = $arrSaveData['city_code'];
                    } else {
                        $data['status'] = '2';
                        $data['message'] = 'Account not Created';
                        $data['city_code'] = '';
                    }                          
                  }
				}

else {
                $data['status'] = '3';
                $data['message'] = 'Please Enter All values';
                $data['city_code'] = '';
            }
        } 
        echo json_encode($data);        
    }	


    public function update_script()
    {
        //echo "string";exit;
        //$data = array('status' => '0', 'message' => 'Failure');
        $productModel = new ProductModel();

        $update_data = $productModel->getupdatedata();
        if($update_data){
            foreach ($update_data as $key => $value) {
                $price = $value->price;
                $id = $value->id;
                $fupdate= $productModel->getupdate($price,$id);

            }
            echo "done";
            exit;

        }
                
    }   

}