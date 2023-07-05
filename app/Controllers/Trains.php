<?php namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\TrainModel;


class Trains extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
    public $trainmodel;
    

   public function __construct()
	{
       
            $this->trainmodel = new TrainModel();
          
            $this->session = session();
          // echo "<pre>"; print_r($session);die;
            $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn'); 
     
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            
		
	}

	public function index()
	{
     
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
		set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
                $userid = $this->session->get('user_id');
                
                $paginationnew = new \App\Libraries\Paginationnew();
              
                 $searchArray = array('user_id'=>$userid);
                 
                 $searchArray['txtsearch'] = $this->request->getGet('txtsearch');
                    $page = $this->request->getGet('page');
                    $page = $page ? $page : 1;
                    $Limit = PER_PAGE_RECORD;
                    $totalRecord = $this->trainmodel->getData($searchArray,'','',1); // return count value

                    $startLimit = ($page - 1) * $Limit;
                    $data['startLimit'] = $startLimit;

                    $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
                    $data['pagination'] = $pagination;
                    $data["ordersData"] = $this->trainmodel->getData($searchArray, $startLimit, $Limit);
                    $data["searchArray"] = $searchArray;
                   
                    
                 
                    $this->template->render('admintemplate', 'contents' , 'admin/trains/train_list', $data);
				
		
	}

        public function newtrain()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            
            $data['arrStation'] = $this->trainmodel->getStationArr();
            
            $this->template->render('admintemplate', 'contents' , 'admin/trains/newtrain', $data);

        }
        
        public function edittrain()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            $trainid =  $this->request->getGet("id");
            
            if(!$trainid)
            {
                $this->session->setFlashdata('errmessage', 'Train number doesnot exist! Please try again.');

                return redirect()->to(site_url('trains'));
            }
            set_title('Welcome | ' . SITE_NAME);
                $metatag = array("content" => "", "keywords" => "", "description" => "");
                set_metas($metatag);
            
            $data = array();
            $orderId ='';
            $data['traindetails']  = $this->trainmodel->getTraindetail($trainid);
           
            if(!$data['traindetails'])
            {
                $this->session->setFlashdata('errmessage', 'Train doesnot exist! Please try again.');

                return redirect()->to(site_url('trains'));
            }
            $data['arrStation'] = $this->trainmodel->getStationArr();
           
          
           // echo "<pre>";print_r($data);
            $this->template->render('admintemplate', 'contents' , 'admin/trains/edit_train', $data);

        }
        
        
        public function addtrain()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
           // echo "<pre>";print_r($this->request->getPost());
            
            $trainno =$this->request->getPost('trainno'); 
            $trainname =$this->request->getPost('trainname'); 
            $fromstation =$this->request->getPost('fromstation'); 
            $tostation =$this->request->getPost('tostation'); 
           
            $arrSaveData = array(
                
                'trainno'=>$trainno,
                'name'=> $trainname,
                'fromstation'=>$fromstation,
                'tostation'=> $tostation,
            );
            
            $this->trainmodel->save($arrSaveData);
            
            $this->session->setFlashdata('message', 'Train Added Successfully.');
            return redirect()->to(site_url('trains'));
         

        }
        
         public function updatetrain()
        {
            if(!$this->isAdminLoggedIn)
            {  
                   return redirect()->to(site_url('admin'));
            }
            
            $userid = $this->session->get('user_id');
            
            $trainid = $this->request->getPost('trainid')  ;
            
            if(!$trainid)
            {
                $this->session->setFlashdata('errmessage', 'Train number doesnot exist! Please try again.');

                return redirect()->to(site_url('neworder'));
            }
            
         //   echo "<pre>";print_r($this->request->getPost());die;
            
            $trainid = $this->request->getPost('trainid'); 
            $trainno = $this->request->getPost('trainno'); 
            $trainname = $this->request->getPost('trainname'); 
            $fromstation =$this->request->getPost('fromstation'); 
            $tostation =$this->request->getPost('tostation'); 
            
           
           
            $arrSaveData = array(
                
                'trainno'=>$trainno,
                'name'=> $trainname,
                'fromstation'=>$fromstation,
                'tostation'=>$tostation
            );
            
               $this->orders->where('id',$trainid)->set($arrSaveData)->update();
                
            
             $this->session->setFlashdata('message', 'Train updated succesfully.');
            return redirect()->to(site_url('edittrain?id='.$trainid));
        }

        
         public function deltrain()
        {
            $session = session();
            
            $id =  $this->request->getGet("id");
           if($id)
           {
                $this->trainmodel->where('id',$id)->delete();
                $this->session->setFlashdata('message', 'Train deleted succesfully.');
           }
            else {
                $this->session->setFlashdata('errmessage', 'Invalid access.');
            }
            return redirect()->to(site_url('trains'));
        }
        
        
        
        
    
    
        
      
	
}