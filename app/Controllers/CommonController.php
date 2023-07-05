<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\BrandModel;
use CodeIgniter\Session\Session;

class CommonController extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
	{
		$this->session = session();
		// echo "<pre>"; print_r($session);die;
		$this->LoggedIn = $this->session->get('LoggedIn');
		$this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
		$this->isUserLoggedIn = $this->session->get('isUserLoggedIn');
	}

	public function addbrand()
    {
        if(!$this->LoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }

        $brandModel = new BrandModel();
            
        // echo "<pre>";print_r($this->request->getPost()); die();
        
        $brandname =$this->request->getPost('brandname'); 
       
        $searchArray = array('txtsearch'=>$brandname);

        // echo "<pre>";print_r($searchArray); die();
        
        $totalRecord = $brandModel->getData($searchArray,'','',1); // return count value
        
        if($totalRecord > 0){
            echo 'Brand Already Exists';
        } else {
            $arrSaveData = array(
            'br_name'=>$brandname,
            );
            // echo "<pre>";print_r($arrSaveData); die();

            $query = $brandModel->save($arrSaveData);
            
            if($query){
            	$this->session->setFlashdata('message', 'Brand Added succesfully.');
                if($this->isAdminLoggedIn)
			    {  
			    	return redirect()->to(site_url('BrandsList'));
			    }
			    if($this->isUserLoggedIn)
			    {  
			    	return redirect()->to(site_url('userBrandsList'));
			    }
            } else {
            	$this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
	}

	public function updatebrand()
    {
        if(!$this->LoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
        
        $id =$this->request->getPost('brandID');    
        $brandname =$this->request->getPost('brandname');

        if(!$brandId)
        {
            $this->session->setFlashdata('errmessage', 'Brand Id does not exist!');

            // return redirect()->to(site_url('adminlist'));
            echo "<script>window.history.back();</script>";
        }
            
        //   echo "<pre>";print_r($this->request->getPost());die();
        
        $brandModel = new BrandModel();

        $arrResult = $brandModel->where('br_id!=',$id)
                                ->where(['br_name' => $brandname])
                                ->countAllResults();

        if($arrResult){

            $this->session->setFlashdata('errmessage', 'Brand Name Already Exists! Please Try a different Brand Email.');
                
            // return redirect()->to(site_url('editsubadmin?id='.$id));
            echo "<script>window.history.back();</script>";

        } else {

            $arrSaveData = array(
                'br_name'=> $brandname,
            );
                
            // print_r($arrSaveData);die;            

            $Update = $brandModel->where('br_id',$id)->set($arrSaveData)->update();

           if($Update){
            	$this->session->setFlashdata('message', 'Brand Updated succesfully.');
                if($this->isAdminLoggedIn)
			    {  
			    	return redirect()->to(site_url('BrandsList'));
			    }
			    if($this->isUserLoggedIn)
			    {  
			    	return redirect()->to(site_url('userBrandsList'));
			    }
            } else {
            	$this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }
        
	
	
}
