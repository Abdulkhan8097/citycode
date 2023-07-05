<?php namespace App\Libraries;

/* * ***************************************************************************\
  +-----------------------------------------------------------------------------+
  | Project        : citycode                                           		  |
  | FileName       : EmailSms.php                                           |
  | Version        : 1.0                                                      |
  | Developer      : subedar Yadav                                            |
  | Created On     : 15-08-2021                                               |
  | Modified On    :                                                          |
  | Modified   By  :                                                          |
  | Authorised By  :  subedar Yadav                                           |
  | Comments       :  This class used for site message		  		          |
  | Email          : subedar2507@gmail.com                                    |
  +-----------------------------------------------------------------------------+
  \**************************************************************************** */

class EmailSms {

    protected $SMS_BASE_URL;
     protected $SMS_SENDERID='citycodews4860';
    protected $SMS_API_KEY='Citycodews4860@123';
    
	private $arrMessage = array();
	
        public function __construct() {
            
            $this->SMS_BASE_URL = "https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=".$this->SMS_SENDERID."&Password=".$this->SMS_API_KEY;
            
        }
    public function getMessage($key){


		//message for registration
		$this->arrMessage['register'] = " Dear ##USER_NAME## 
													 Thank you for registering with us.
												";


		//message for gorgot password
		$this->arrMessage['forgotpassword'] = " Dear ##USER_NAME## <br>
													 Your Password generation link ##PASSWPRD_LINK## . <br> Please click above link and reset your password.
                        ";
                        
    //message for gorgot password
		$this->arrMessage['renewpassword'] = " Dear ##USER_NAME## <br>
    Your Password updated successfully.";

    //message for gorgot password
		$this->arrMessage['fillingcomplain'] = " Hello, <br>
    Please find below complain details <br> <br> 
   <table width='50%'>
   <tr><td><b> Name: </b></td><td> ##C_NAME##</td><tr>
   <tr><td><b>Address: </b></td><td> ##C_ADDRESS## </td><tr>
   <tr><td><b>Phone (day):</b></td><td> ##C_PHONE## </td><tr>
   <tr><td><b> Phone (cell): </b></td><td> ##C_MOBILE## </td><tr>
   <tr><td><b> E-mail Address: </b></td><td> ##C_EMAIL## </td><tr>
   <tr><td><b> Kola Account Number: </b></td><td> ##C_KOLA_ACCOUNT## </td><tr>
   <tr><td><b>Complain Detail: </b></td><td>  ##C_DETAILS## </td><tr>
   <tr><td> <b>Signing Name: </b></td><td> ##C_SIGNING_NAME## </td><tr>
   <tr><td><b> Time: </b></td><td> ##C_SIGNING_TIME## </td><tr>
    ";
		
		if(array_key_exists($key,$this->arrMessage))
		{
			return $this->arrMessage[$key];
		}
  }
  
  

  public function getEmailFooter()
  {
     return "Thanks & Regards <br> ".SITE_NAME." Team";
  }

  //function for send email

  public function sendEmail($toEmail,$subject='',$mailbody='',$attachment='')
  {
       $email = \Config\Services::email();

        $config['protocol'] = 'SMTP';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordWrap'] = true;

        $email->initialize($config);

        $email->setFrom('service@kolafinancial.com', SITE_NAME);
        $email->setTo($toEmail);
        $email->setSubject($subject);
        $email->setMessage($mailbody);
        if($attachment)
        {
          $email->attach($attachment);
        }
       

        $email->send();
         $data = $email->printDebugger(['headers']);
         print_r($data); 
  }


  public function  send_sms($mobileno,$message,$language='')
    {
      $smsbaseurl = $this->SMS_BASE_URL;

      $languageNumber = ($language=='arb') ? 64 :0;
        $url = $smsbaseurl."&MobileNo=".$mobileno."&Message=".urlencode($message)."&Lang=".$languageNumber."&FLashSMS=N&Header=".urlencode("City Code");
        
                $client = \Config\Services::curlrequest();

                    $response = $client->request('GET',$url);
                    $body = $response->getBody();
                    $startus = $response->getStatusCode();
                    
                    return array('startus'=>$startus,"body"=>$body);
                    
       // print_r($body);
        
       // echo $response->getStatusCode();
       // echo "<br><br><br>".$url;
       //echo $text = file_get_contents($url);
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        $result = curl_exec($ch);
//        curl_close($ch);   
//        print_r($result); 
    }
	

}

?>