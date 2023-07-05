<?php namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ProfileModel;

class Profile extends BaseController {
    
    protected $session;
    protected  $isAdminLoggedIn;
    public $profile;
    
	function __construct()
	{
		
             $this->profile = new ProfileModel();
          
            $this->session = session();
        
            $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn'); 
     
            
            
	}
	
	public function index()
	{
            
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
                $data =array();
                $userid = $this->session->get('user_id');
		set_title('Profile | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
                
                $data['profile_data'] = $this->profile->getUserDetails($userid);
               // echo "<pre>";print_r($data);die;
		 $this->template->render('admintemplate', 'contents' , 'admin/profile/admin_profile', $data);
		
	}

	
	public function UpdateProfile(){
		
            
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }

            $userid = $this->session->get('user_id');
            
            $first_name =$this->request->getPost('first_name'); 
            
            $arrSaveData = array(
                'name'=>$first_name
                );
            $this->profile->where('id',$userid)->set($arrSaveData)->update();
            
            $this->session->setFlashdata('message', 'Profle updated succesfully.');
            return redirect()->to(site_url('profile'));

	}
	
	
	function changepwd(){		
		
		$data = array();
             $this->template->render('admintemplate', 'contents' , 'admin/profile/change_password', $data);
           
	}
        
        public function UpdatePassword(){
		
            
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }

            $userid = $this->session->get('user_id');
            
            $old_password =$this->request->getPost('old_password'); 
            $new_password =$this->request->getPost('new_password'); 
            $cnf_new_password =$this->request->getPost('cnf_new_password'); 
            
            if($new_password != $cnf_new_password)
            {
                $this->session->setFlashdata('errmessage', 'New Password and Confirm password not match.');
                 return redirect()->to(site_url('changepassword'));
            }
            $arrSaveData = array(
                'password'=>password_hash($new_password, 1)
                );
           
            $this->profile->where('id',$userid)->set($arrSaveData)->update();
           
            $this->session->setFlashdata('message', 'Profle updated succesfully.');
            return redirect()->to(site_url('changepassword'));

	}
	
	
}