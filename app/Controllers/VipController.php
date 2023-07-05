<?php
namespace App\Controllers;

use App\Models\VipModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\OrgModel;
use CodeIgniter\Session\Session;
use App\Libraries\Paginationnew;

class VipController extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    
function VipCode() {

        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $vipModel = new VipModel();	
        $data['action'] = "VipCode";
        $txtsearch = $this->request->getGet('txtsearch');
     
        $paginationnew = new Paginationnew();                 
        $searchArray = array();
	    if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }			
		$page = $this->request->getGet('page');
		$page = $page ? $page : 1;
		$Limit = 100;
		$totalRecord = $vipModel->getData($searchArray,'','','1'); 
		$startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
		$data['startLimit'] = $startLimit;
		$pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		$data['txtsearch'] = $txtsearch;
		$data['startLimit'] = $startLimit;
		$data['pagination'] = $pagination;
		$data['lists'] = $vipModel->getData($searchArray, $startLimit, $Limit);
		$data["searchArray"] = $searchArray;		
                $this->template->render('admintemplate', 'contents' , 'admin/vipList',$data);
             }

function index()
	{
		$this->template->render('admintemplate', 'contents' , 'admin/vip_form');
	}

///////////////// generate vip code /////////

    public function add_new()
    {

        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }
       
     $vip = new VipModel();
     $customerModel = new CustomerModel();
                $vip_code = $this->request->getPost('vip_code');
                $totalRecord = $vip->checkVipExist($vip_code);
                $cityRecord = $customerModel->checkCityCode($vip_code);

                if($totalRecord > 0 || $cityRecord  > 0){
                    $this->session->setFlashdata('message', 'This V.I.P Code Already Exist');
                  return redirect()->to(site_url('AddVipCode'));
                } else {
               $data = [
                    'vip_code' => $this->request->getVar('vip_code'),
                    'status' => 1,
                    'created_date' => date('Y-m-d H:i:s'),            
                   ];
     $id = $vip->insert($data);

     if ($vip->errors){
        return $this->fail($vip->errors());
     }
      else{
        $this->session->setFlashdata('message', 'V.I.P Code generated Successfully!');
        return redirect()->to(site_url('VipCode'));
     }
   }
 }

//////////////////// Edit Vip Code /////////////////////////////

public function edit_vip()
    {
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $vipModel = new VipModel();

        $data['values'] = $vipModel->getVipID($id); 

        if(!$data['values'])
        {
            $this->session->setFlashdata('errmessage', 'Vip code Does not exist!');
            return redirect()->to(site_url('VipCode'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/edit_vip_form', $data);
    }
public function addOrganization(){
    if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }
                 $vip = new VipModel();
            $data['vip']=$vip->select('id,vip_code')->where('status','1')->find();
            // echo"<pre>";
            // print_r($data['vip']);exit;
        $this->template->render('admintemplate', 'contents' , 'admin/addOrganization',$data);
}
public function sample(){
     $this->template->render('admintemplate', 'contents' , 'admin/sample');
}

public function addAllOrganization(){
    $id = $this->request->getGet('id');
    $VipModel = new VipModel();
    $data['org']=$VipModel->getbyid($id);
    $this->template->render('admintemplate', 'contents' , 'admin/addAllOrganization',$data);
}
public function saveORG()
    {

        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }
       $id=$this->request->getPost('vip');
       $orgModel = new OrgModel();
        $data=[
        'org_name' => $this->request->getPost('org_name'),
        'vip' => $id,
        'org_email' => $this->request->getPost('org_email'),
        'org_phone' => $this->request->getPost('org_phone'),
	'arb_name' => $this->request->getPost('arb_name')
           ];
           $orgModel->insert($data);
    
            $status = [
                   'status' => '0',
                    'org_status' => '1'      
                   ];
    
      $vip = new VipModel();
      $vip->set($status)->where('id',$id)->update();
      return redirect()->to(site_url('VipCode'));
   
 }
 public function add_org()
    {

         if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

       
               $vip = new VipModel();
               $customerModel = new CustomerModel();
                $vip_code = $this->request->getPost('organization_code');
               

                $totalRecord = $vip->checkVipExist($vip_code);
                $cityRecord = $customerModel->checkCityCode($vip_code);

                if($totalRecord > 0 || $cityRecord  > 0){
                    $this->session->setFlashdata('message', 'This V.I.P Code Already Exist');
                  return redirect()->to(site_url('AddVipCode'));
                } else {
               $data = [
                    'vip_code' => $this->request->getVar('organization_code'),
                    'type' => $this->request->getVar('org'),
                    'status' => 1,
                    'created_date' => date('Y-m-d H:i:s'),            
                   ];
     $id = $vip->insert($data);

     if ($vip->errors){
        return $this->fail($vip->errors());
     }
      else{
        $this->session->setFlashdata('message', 'Organization Code generated Successfully!');
        return redirect()->to(site_url('VipCode'));
     }
   }
 }


public function update()
    {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
            
        $vip_id = $this->request->getPost('vip_id');

        if(!$vip_id)
        {
            $this->session->setFlashdata('errmessage', 'V.I.P Code does not exist!');

            return redirect()->to(site_url('adminlist'));
        }
                      
        $vip_code =$this->request->getPost('vip_code');
        $updated_date = $this->request->getPost('updated_date');
       
        $vipModel = new VipModel();

                $totalRecord = $vipModel->checkVipExist($vip_code);

                if($totalRecord > 0){
                    $this->session->setFlashdata('message', 'This V.I.P Code Already Exist');
                  return redirect()->to(site_url('EditVipCode?id='.$vip_id));

                } else {


        $arrSaveData = array(

            'vip_code'=>$vip_code,
            'updated_date' => date('Y-m-d H:i:s'),
          );

        $Update = $vipModel->where('id',$vip_id)->set($arrSaveData)->update();  

        if($Update) {
            
            $this->session->setFlashdata('message', 'V.I.P Code updated successfully.');
            
            return redirect()->to(site_url('EditVipCode?id='.$vip_id));
        } 
else {
             $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            
            return redirect()->to(site_url('EditVipCode?id='.$vip_id));
        }
      }
    }


//////////// delete v.i.p code /////////////


    public function delete_VipCode()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id =  $this->request->getGet("id");

        $vipModel = new VipModel();
	$orgModel = new orgModel();
	$CustomerModel = new CustomerModel();

        if($isAdminLoggedIn)
        {
		 $data=$vipModel->where('id',$id)->find();
            $vip_code=$data[0]['vip_code'];
        

           $data1=$CustomerModel->where('vip_code',$vip_code)->find();
            if($data1){
            $cusid=$data1[0]['id'];
            $changevip=['vip_code'=> ''];
            $CustomerModel->set($changevip)->where('id',$cusid)->update();
          }

            $vipModel->where('id',$id)->delete();
		$available=$orgModel->where('vip',$id)->find();
		if($available){
               $orgModel->where('vip',$id)->delete();  
              }
                
            $this->session->setFlashdata('message', 'V.I.P Code deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('VipCode'));
    }
  

///////// vip and customer detail //////////////////////

    public function VipCodeDetails()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

	$stateModel = new StateModel();
	$data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $cityModel = new CityModel();
	$data['cities'] = $cityModel->orderBy('city_name', 'ASC')->findAll();

	$countryModel = new CountryModel();
	$data['countries'] = $countryModel->orderBy('country_enName', 'ASC')->findAll();

        $vipModel = new VipModel();
        $data['vipdetails'] = $vipModel->getDetails($id);

//echo"<pre>"; print_r($data['vipdetails']);die('11');
			
        if(!$data['vipdetails'])      
        {
            $this->session->setFlashdata('errmessage', 'This V.I.P Code Does not exist!');
            return redirect()->to(site_url('VipCode'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/vipdetails', $data);
    }



}

?>
