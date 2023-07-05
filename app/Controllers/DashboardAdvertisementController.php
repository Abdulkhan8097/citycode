<?php

namespace App\Controllers;

use App\Models\DashboardAdvertisementModel;
use App\Models\CompanyModel;
use App\Models\StateModel;
use App\Models\AdBannerModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class DashboardAdvertisementController extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }

    function index() {

        $session = session();

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $data = array();
        $addModel = new DashboardAdvertisementModel();
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if ($txtsearch) {
            $searchArray['txtsearch'] = $txtsearch;
        }
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $addModel->getDataAll($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
        $data['reverse'] = $totalRecord - ($page - 1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
        $data["lists"] = $addModel->getDataAll($searchArray, $startLimit, $Limit);

        $this->template->render('admintemplate', 'contents', 'admin/dashboardadd/advertiselist', $data);
    }

    function advertisementNew() {
        $data = array();
        $this->template->render('admintemplate', 'contents', 'admin/dashboardadd/advertise_form', $data);
    }

    public function advertisementAddCreate() {

        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $fileObject = $file = $this->request->getFile("banner");
         $fileObject->move("advertisement/");
        $filename = $fileObject->getName();
        
        if($filename)
        {
            $details = new DashboardAdvertisementModel;
            $data = [
                'add_name' => $this->request->getVar('add_name'),
                'url' => $this->request->getVar('url'),
                'add_image' => $filename,
                'status' => $this->request->getVar('status')
            ];

            $id = $details->insert($data);
        }
        else
        {
             return $this->fail("Banner Not addes");
        }
        if ($details->errors) {
            return $this->fail($details->errors());
        } else {
            $this->session->setFlashdata('message', 'Advertisement Added Successfully!');
            return redirect()->to(site_url('dashboardadd'));
        }
    }

    /////////// edit advertisement ///////////////


    public function editAdvertisement() {

       if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        
        $id = $this->request->getGet("id");

        $advertiseModel = new DashboardAdvertisementModel();
        $data['bannerdetails'] = $advertiseModel->getBannersId($id);
        
        if (!$data['bannerdetails']) {
            $this->session->setFlashdata('errmessage', 'Banner Id Does not exist!');
            return redirect()->to(site_url('dashboardadd'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/dashboardadd/edit_advertise', $data);
    }

    public function updateAdvertisement() {
        
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        
        $add_id = $this->request->getPost('add_id');
        $add_name = $this->request->getVar('add_name');
        $url = $this->request->getVar('url');
        $status = $this->request->getVar('status');
        
        $fileObject = $file = $this->request->getFile("banner");
        $filename ="";
       
        if($fileObject->getName())
        {
            $fileObject->move("advertisement/");
            $filename = $fileObject->getName();
        }

        $advertiseModel = new DashboardAdvertisementModel();

        $arrSaveData = array(
            'add_name' => $add_name,
            'url' => $url,
            'status' => $status,
        );
        
        if($filename)
        {
            $arrSaveData['add_image'] =$filename;
        }
        $Update = $advertiseModel->where('add_id', $add_id)->set($arrSaveData)->update();

        if ($Update) {

            $this->session->setFlashdata('message', 'Banner updated successfully.');
            return redirect()->to(site_url('editadd?id=' . $add_id));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('editadd?id=' . $add_id));
        }
    }

    public function deleteAdvertise() {
       
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        
         $baseUrl = FCPATH; 
         
        $add_id = $this->request->getGet("id");
        $advertiseModel = new DashboardAdvertisementModel();
       $addDetails = $advertiseModel->getBannersId($add_id);
       
         $isdelete = $advertiseModel->where('add_id', $add_id)->delete();
         
        if ($isdelete) {
            
            // delete file also
            
            if($addDetails)
            {
                $baseUrl = FCPATH; 
                $filename= $addDetails['add_image'];
                if($filename)
                {
                     $filePath = $baseUrl.'advertisement/'.$filename;
                     unlink($filePath);
                }
            }
            
            $this->session->setFlashdata('message', 'Advertisement deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('dashboardadd'));
    }
    
    
    public function delAddImage() {
        
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
         
       
        $add_id = $this->request->getGet('add_id');
       
        $advertiseModel = new DashboardAdvertisementModel();
        $addDetails = $advertiseModel->getBannersId($add_id);
        
        $arrSaveData = array(
            'add_image' => ""
        );
       
        $Update = $advertiseModel->where('add_id', $add_id)->set($arrSaveData)->update();

        if ($Update) {
            //delete file
            if($addDetails)
            { 
                $baseUrl = FCPATH; 
                $filename= $addDetails['add_image'];
                if($filename)
                {
                     $filePath = $baseUrl.'advertisement/'.$filename;
                     unlink($filePath);
                }
            }


            $this->session->setFlashdata('message', 'Image deleted successfully.');
            return redirect()->to(site_url('editadd?id=' . $add_id));
        } else {

            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('editadd?id=' . $add_id));
        }
    }

}

?>
