<?php
namespace App\Controllers;
use App\Models\OpeningPointModel;
use App\Models\OnetimePointModel;
use App\Models\CustomerModel;
use App\Models\BuyPoints;
use App\Libraries\Paginationnew;

class OpeningPoint extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
     {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
      }


   public function index()
    {
        $session = session();
	    if($session->get('id')){         
          $isIn = $session->get('id'); 		
       }
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
		
        $openingPointModel = new OpeningPointModel();
        $data = $openingPointModel->getData(); 
        $data['data'] = count($data) ? $data[0]:array(); 
       // print_r($data);die;
	$OnetimePointModel = new OnetimePointModel();
        $data1 = $OnetimePointModel->getData(); 
        $data['data1'] = count($data1) ? $data1[0]:array();

        $this->template->render('admintemplate', 'contents' , 'admin/openingpoint', $data);
    }
	
	
	
    public function update() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $startdate = $this->request->getPost('startdate');
        $enddate = $this->request->getPost('enddate');
        $initialpoint = $this->request->getPost('initialpoint');
       
        $startdate = date("Y-m-d", strtotime($startdate));
        $enddate = date("Y-m-d", strtotime($enddate));
        
        $openingModel = new OpeningPointModel();
        
        $arrSaveData = array(
            'start_date' => $startdate,
            'end_date' => $enddate,
            'initial_point' => $initialpoint,
        );
        
        $Update = $openingModel->where('id', '1')->set($arrSaveData)->update();

        if ($Update) {
            $this->session->setFlashdata('message', 'Updated successfully.');
            return redirect()->to(site_url('openingpoint'));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('openingpoint'));
        }
    }
	public function updatepoinr() {

        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $startdate = $this->request->getPost('startdate1');
        $enddate = $this->request->getPost('enddate1');
        $initialpoint = $this->request->getPost('initialpoint1');

       
        $startdate = date("Y-m-d", strtotime($startdate));

        $enddate = date("Y-m-d", strtotime($enddate));
        
        $OnetimePointModel = new OnetimePointModel();
        
        $arrSaveData = array(
            'start_date1' => $startdate,
            'end_date1' => $enddate,
            'initial_point1' => $initialpoint,
        );
        
        $Update = $OnetimePointModel->where('point_id', '1')->set($arrSaveData)->update();
 if($Update>0){
           
            $CustomerModel=new CustomerModel();
            $CustomerModel->changepoints();
            //$sql= "Update customer set  onetime_point= 0 where onetime_point = 1";

        }

        if ($Update) {
            $this->session->setFlashdata('message', 'Updated successfully.');
            return redirect()->to(site_url('openingpoint'));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('openingpoint'));
        }
    }
        public function buyPointIndex(){
            $session = session();
           if (!$this->isAdminLoggedIn) {
               return redirect()->to(site_url('admin'));
           }  
            $id =$this->request->getGet('id');
            if($id>0){
           $BuyPoints = new BuyPoints();
           $data['edit'] = $BuyPoints->find($id);
           // echo"<pre>";
           // print_r($data);exit;
            }
            
           $paginationnew = new Paginationnew();
           $txtsearch = $this->request->getGet('txtsearch');
           $searchArray = array();
           if($txtsearch)
           {
               $searchArray['txtsearch'] = $txtsearch;
           }
           $page = $this->request->getGet('page');
           $page = $page ? $page : 1;
           $Limit = 6;
            // $Limit =6;
           $BuyPoints = new BuyPoints();
           // $totalRecord = $BuyPoints->getData($searchArray, '', '', '1');
           $totalRecord = 6;

           // $startLimit = ($page - 1) * $Limit; 
           $startLimit = 0;

           $data['reverse'] = $Limit;
            // print_r($data['reverse']);exit; 

           $data['startLimit'] = $startLimit;
        
           $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
           $data['txtsearch'] = $txtsearch;
           $data['startLimit'] = $startLimit;
           $data['pagination'] = $pagination;
             // print_r($data['pagination']);exit; 
           $data['customers'] = $BuyPoints->getData($searchArray, $startLimit, $Limit);
           
           $this->template->render('admintemplate', 'contents', 'admin/buypoints',$data);
        
    }
     public function buyPointSave(){

        
         $id =$this->request->getpost('id');
         $BuyPoints = new BuyPoints();
         
        $data=['amount'=>$this->request->getPost('amt'),
             'points'=>$this->request->getPost('points')
           ];
               if(intval($id)>0)
                {
                    // print_r($_POST);
                    // exit;
                  $BuyPoints->set($data)->where("id",$id)->update();

              $this->session->setFlashdata('message', 'Updated  successfully.');
                       
                }else{
            $BuyPoints->limit(6, 0)->insert($data);

            $this->session->setFlashdata('message', 'data added  successfully.');
                }
           
           return redirect()->to(site_url('buypoints'));
    }
       public function delete()
    {
       $id = $this->request->getGet('id');
       $BuyPoints = new BuyPoints();
       
       if(intval($id)>0)
       { 
        $BuyPoints = new BuyPoints();
       $BuyPoints->where("id",$id)->delete();
       
        $this->session->setFlashdata('message', 'Deleted  successfully.');
         
      }
      return redirect()->to(site_url('buypoints'));
  }



}

?>
