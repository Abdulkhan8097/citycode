<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\CustomerModel;
use CodeIgniter\Session\Session;

class CustControllerApi extends BaseController {

	
    protected $session;    
    
    public function __construct()
    {

	}

    public function registerapi()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $custModel = new CustomerModel();
        
        if ($this->request->getPost()) 
        {
            // $data['inputdata'] = $this->request->getPost();
            $cus_forename = $this->request->getPost('cus_forename');
            $cus_familyname = $this->request->getPost('cus_familyname');
            $cus_sex = $this->request->getPost('cus_sex');
            $cus_dob = $this->request->getPost('cus_dob');
            $cus_nationality = $this->request->getPost('cus_nationality');
            $cus_governorate = $this->request->getPost('cus_governorate');
            $cus_state = $this->request->getPost('cus_state');
            $cus_phone = $this->request->getPost('cus_phone');
            $cus_email = $this->request->getPost('cus_email');
            $cus_village = $this->request->getPost('cus_village');

            if($cus_forename!= "" && $cus_familyname!= "" && $cus_phone!= "" && $cus_email!= "")
            {
                $totalRecord = $custModel->checkCustExist($cus_email, $cus_phone);
                if($totalRecord > 0){
                    $data['status'] = 3;
                    $data['message'] = 'Customer Already Exists';
                } else {                    
                    $arrSaveData = array(
                        'cus_forename'=>$cus_forename,
                        'cus_familyname'=>$cus_familyname,
                        'cus_sex'=>$cus_sex,
                        'cus_dob'=>$cus_dob,
                        'cus_nationality'=>$cus_nationality,
                        'cus_governorate'=>$cus_governorate,
                        'cus_state'=>$cus_state,
                        'cus_phone'=>$cus_phone,
                        'cus_email'=>$cus_email,
                        'cus_village'=>$cus_village,
                    );
                    // echo "<pre>";print_r($arrSaveData); die();
                    $custModel->save($arrSaveData);
                    $cus_id = $custModel->getInsertID();

                    if($cus_id) {
                        $data['status'] = 1;
                        $data['message'] = 'Customer Created Successfully';
                        $data['cus_id'] = $cus_id;
                        $data['cust_details'] = $arrSaveData;
                    } else {
                        $data['status'] = 2;
                        $data['message'] = 'Customer not Created';
                    }
                }
            } else {
                $data['status'] = 4;
                $data['message'] = 'Please Enter All values';
            }
        } else {
            $data['status'] = 5;
            $data['message'] = 'Invalid Access';
        }

        echo json_encode($data);        
    }

    public function generateotp()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $custModel = new CustomerModel();
        
        if ($this->request->getPost()) 
        {
            // $data['inputdata'] = $this->request->getPost();
            $cus_phone = $this->request->getPost('cus_phone');

            if($cus_phone!= "")
            {
                $custdetail = $custModel->getCustomerdetails('','', $cus_phone);
                if($custdetail){
                    $otp = rand(1000,9999);

                    $arrSaveData = array(
                        'otp'=>$otp,
                    );
                    // echo "<pre>";print_r($arrSaveData); die();
                    $Update = $custModel->where('cus_phone',$cus_phone)->set($arrSaveData)->update();

                    if($Update) {
                        $data['status'] = 1;
                        $data['message'] = 'OTP generated Successfully';
                        $data['otp_number'] = $otp;
                    } else {
                        $data['status'] = 2;
                        $data['message'] = 'OTP not generated';
                    }

                } else {
                    $data['status'] = 3;
                    $data['message'] = 'Customer Not Found';
                }
            } else {
                $data['status'] = 4;
                $data['message'] = 'Phone Number Empty';
            }
        } else {
            $data['status'] = 5;
            $data['message'] = 'Invalid Access';
        }

        echo json_encode($data);        
    }

    public function validateotp()
    {
        $data = array('status' => '0', 'message' => 'Failure');

        $custModel = new CustomerModel();
        
        if ($this->request->getPost()) 
        {
            // $data['inputdata'] = $this->request->getPost();
            $cus_phone = $this->request->getPost('cus_phone');
            $otp_number = $this->request->getPost('OTP_number');

            if($cus_phone!= "")
            {
                if($otp_number!= "")
                {
                    $custdetail = $custModel->getCustomerdetails('','', $cus_phone);
                    if($custdetail['otp'] == $otp_number)
                    {
                        $initial = substr($custdetail['cus_forename'],0,1); // get initial letter of forename

                        $latestcode = $custModel->getmaxUsermembercode(); // get latest code 

                        $code = sprintf('%04d',substr($latestcode[0]->membership_code,1) + 1);

                        $membershipcode = $initial.sprintf('%04d', $code);  // Generate Membership Code

                        $arrSaveData = array(
                            'membership_code'=>$membershipcode,
                            'cus_status'=>1,
                        );
                        // echo "<pre>";print_r($arrSaveData); die();
                        $Update = $custModel->where('cus_phone',$cus_phone)->set($arrSaveData)->update();
                        $custdetail = $custModel->getCustomerdetails('','', $cus_phone);

                        if($Update) {
                            $data['status'] = 1;
                            $data['message'] = 'Membership Code Generated';
                            $data['membershipcode'] = $membershipcode;
                            $data['cust_details'] = $custdetail;
                        } else {
                            $data['status'] = 2;
                            $data['message'] = 'Membership Code not Generated';
                        }

                    } else {
                        $data['status'] = 3;
                        $data['message'] = 'Incorrect OTP';
                    }
                } else {
                    $data['status'] = 4;
                    $data['message'] = 'OTP Number Empty';
                }
            } else {
                $data['status'] = 5;
                $data['message'] = 'Phone Number Empty';
            }
        } else {
            $data['status'] = 6;
            $data['message'] = 'Invalid Access';
        }

        echo json_encode($data);        
    }
  

}
