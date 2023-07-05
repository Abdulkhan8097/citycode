<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CustomerModel;
use App\Models\CategoryModel;
use App\Models\VipCustomerModel;
use App\Models\OrdersModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\ChatModel;
use App\Models\BranchModel;
use App\Models\SitevariableModel;
use App\Models\NotificationModel;
use App\Libraries\EmailSms;
use App\Libraries\Pushnotification;


class ApiTest extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
   
    }

    //get all category
    public function index() {
         $push = new Pushnotification();
      
        $arrMessage =  ["title"=>" City Code Confirmation","body"=>"City Code Confirmation, Please accept or decline",
                      "details"=>["companyid"=>"1","companyname"=>"abc","branchid"=>'1',"branchname"=>"pqr","discpount"=>"20","totalamount"=>"200","paidamount"=>"180"]];
        $push->sendAndroidNotification("fe402JDNQ7Sdaey1yAXMW0:APA91bFSdEeiRLUZ80t-lcUspTJVLCY58HyRpz8rM0MtoNP8P3LQ4IngWPgR8iWFqrfGdq0tTIBHJN79K7AE5Z1w9wey7KMJzU6GsQd97d5PdmjZVeOBHRY1zceix1B_Tr6s8bNoN8SF",$arrMessage);
        echo "message sent";
    }

    
    
     public function iostest()
    {
        $push = new Pushnotification();
      
        $arrMessage =  ["title"=>" City Code Confirmation","body"=>"City Code Confirmation, Please accept or decline",
                      "details"=>["companyid"=>"1","companyname"=>"abc","branchid"=>'1',"branchname"=>"pqr","discpount"=>"20","totalamount"=>"200","paidamount"=>"180"]];
        $token = array("cBs1r8y2TDK8DvW5UW7nyt:APA91bF5W5xAGWA4o8GTIIlvA0du6khzEMBevhqtV-FQPdq3pWiJ7LLKLAnXS8Vok03nzHCtg6MpwZUC4p7XchQROtrnS5-PofilOcd8Gk2qk-dSfK7c1FjVk1ILJzK2lWis5kvJcJwZ","eERKCcerX07WkX1c71FQE8:APA91bHTw92fiQmPK5wvM83OP8elOxUOIsR9-Q-FIKvsjhabEJsnQ9hyACZDooVnWWngrgUvsNGxgCtKM157mcmpgyZsi8c_SVl4SseG0u_ayxhTg_0P1M6K9s5p8skJhjWL6oB9qnHA");
        foreach($token as $tto)
        {
            $push->sendNotificationtest($tto,$arrMessage);
        }
        echo "message sent";
    }
    
    
	



}

