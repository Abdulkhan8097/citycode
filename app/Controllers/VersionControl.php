<?php
namespace App\Controllers;
use App\Models\VersionControlModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class VersionControl extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
		$siteVariables = new SiteVariables();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


 
    function index() {

    $session = session();
        
    if($session->get('user_id')){         
           $isAdminLoggedIn = $session->get('user_id');         
    }
             if(!$this->isAdminLoggedIn)
        {  
          return redirect()->to(site_url('admin'));
        }
        $data = array();
       $data['pagetitle']='List Version Control';
        $paginationnew = new Paginationnew(); 
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        

        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
   
        
         $VersionControlModel = new VersionControlModel();
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $VersionControlModel->getData($searchArray,'','','1'); 
      

        $startLimit = ($page - 1) * $Limit;
        $data['reverse'] = $totalRecord-($page -1) * $Limit;
     
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;

      
        $data['list'] = $VersionControlModel->getData($searchArray, $startLimit, $Limit);
        
         // print_r($data['list']);exit;

        $this->template->render('admintemplate', 'contents' , 'admin/version/list', $data);
     }

     function add()
    {
      
   
        set_title('Add | ' . SITE_NAME);
        $data['pagetitle'] = "Add Version Control";
        $VersionControlModel = new VersionControlModel();
       $this->template->render('admintemplate', 'contents' , 'admin/version/add',$data);
        
     }

     function save()
    {  
        $menudata = array();  
        $VersionControlModel = new VersionControlModel();
        $postdata = $this->request->getPost();
                $menudata = array("version_no"=>$postdata['version_no']);

                $VersionControlModel->save($menudata);

                $this->session->setFlashdata('message', 'Version added  successfully.');
                return redirect()->to(site_url('listversion'));  
     }

     function delete()
    {  
        $menudata = array();  
        $VersionControlModel = new VersionControlModel();
        $id = $this->request->getGet('id');
        if ($id) {
          $VersionControlModel->where('id',$id)->delete();
          $this->session->setFlashdata('message', 'Version delete  successfully.');
        }
               
      
        return redirect()->to(site_url('listversion'));  
     }


   


       

 


}

?>
