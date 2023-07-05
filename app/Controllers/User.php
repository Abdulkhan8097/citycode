<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\UserModel;
use CodeIgniter\Session\Session;

class User extends BaseController {

    protected $session;
    protected  $isUserLoggedIn;
    
    public function __construct()
	{
		$this->session = session();
		// echo "<pre>"; print_r($session);die;
		$this->isUserLoggedIn = $this->session->get('isUserLoggedIn');
	}
        
	public function index()
	{
        $session = session();
          
        $isUserLoggedIn = $session->get('isUserLoggedIn'); 
     
        if($isUserLoggedIn)
        { 
               return redirect()->to(site_url('userdashboard'));
        }

    	$errorMsg = "";	
        $method = $this->request->getMethod();
        
        $userModel = new UserModel();
        
		if($method=='post'){										
			$username 	= $this->request->getPost("username");				
			$password 	= $this->request->getPost("password");
					
			if($username != '' && $password != ''){
				$return = $userModel->checkUserLogin($username,$password);
				if($return){
				return redirect()->to(site_url('userdashboard'));
				} else {
                    $session->setFlashdata('errmessage','Invalid Email / Password');	
				}						
			}else{																
				$session->setFlashdata('errmessage','Invalid Email / Password');
			}
		}

        $this->template->render('usertemplate', 'contents' , 'user/login',array("errorMsg"=>$errorMsg));
	}
        
        public function dashboard()
        {
            if(!$this->isUserLoggedIn)
            {  
                   return redirect()->to(site_url('user'));
            }
            
            $this->template->render('usertemplate', 'contents' , 'user/dashboard',array("errorMsg"=>''));            
        }

	public function logout()
	{	
		$session = session();
             
		$session->destroy();
		return redirect()->to(site_url('user'));
	}	
	
}
