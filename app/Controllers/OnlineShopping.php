<?php

namespace App\Controllers;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\ProductModel;
use App\Models\ProductImagesModel;
use App\Models\AdminModel;
use App\Models\BranchModel;
use App\Models\CompanyModel;
use App\Models\CodeModel;
use App\Models\OnlineShoppingModel;
use App\Libraries\Paginationnew;

class OnlineShopping extends BaseController {

    protected $session;
    protected $isAdminLoggedIn;

    public function __construct() {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
    }
    

    function index() {
        $session = session();
        if ($session->get('user_id')) {
            $isAdminLoggedIn = $session->get('user_id');
        } else if ($session->get('company_id')) {
            $isAdminLoggedIn = $session->get('company_id');
        }
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
        $adminModel = new AdminModel();
        $data['login'] = $adminModel->LoginID();

        $stateModel = new StateModel();
        $data['statedata'] = $stateModel->orderBy('state_name', 'ASC')->findAll();

        $companyModel = new CompanyModel();
        $ProductModel = new ProductModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
        $data['product'] = $ProductModel->orderBy('product_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
        $data['branchdata'] = $branchModel->getBranchData($session->get('company_id'));

        $OnlineShoppingModel = new OnlineShoppingModel();
       // if ($session->get('user_id')) {
            $paginationnew = new Paginationnew();
            $searchArray = array();
             $start_date = $this->request->getGet('order_start_date');
            $end_date = $this->request->getGet('order_end_date');
            $product_id = $this->request->getGet('product_id');
            $company_id = $this->request->getGet('company_id');
            $branch_id = $this->request->getGet('branch_id');
            $payment_status = $this->request->getGet('payment_status');
          
        if($start_date){
            $searchArray['start_date'] = $start_date ? $start_date : "";
          }
        if($end_date){
           $searchArray['end_date'] = $end_date;
        }
        if($product_id){
           $searchArray['product_id'] = $product_id;
        }
         if($company_id){
           $searchArray['company_id'] = $company_id;
        }
         if($branch_id){
           $searchArray['branch_id'] = $branch_id;
        }
         if($payment_status){
           $searchArray['payment_status'] = $payment_status;
        }
            $txtsearch = $this->request->getGet('txtsearch');
            if($txtsearch)
            {
                $searchArray['txtsearch'] = $txtsearch;
            }
            $searchArray['show_inredeem'] = '0';

            $company_id = ($session->get('company_id'));
             if($company_id){ $searchArray['company_id'] =$company_id;  }

            $page = $this->request->getGet('page');
            $page = $page ? $page : 1;
            $Limit = PER_PAGE_RECORD;
            $totalRecord = $OnlineShoppingModel->getData($searchArray, '', '', '1');
            $startLimit = ($page - 1) * $Limit;
			$data['reverse'] = $totalRecord-($page -1) * $Limit;
            $data['startLimit'] = $startLimit;
            $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
            $data['txtsearch'] = $txtsearch;
            // $data['product_id'] = $product_id;
         
           
            $data['startLimit'] = $startLimit;
            $data['pagination'] = $pagination;
            $data["searchArray"] = $searchArray;
            $companyModel = new CompanyModel();
            $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
            $branchModel = new BranchModel();
            $data['branches']  = array();
           
        
           $data['list'] = $OnlineShoppingModel->getData($searchArray, $startLimit, $Limit);
           // echo"<pre>";
           // print_r($data['list']);exit;
      
        $this->template->render('admintemplate', 'contents', 'admin/OnlineShopping/orderlist',$data);
    }
    public function customerdetailsonline(){
       $id= $this->request->getGet('id');
       $OnlineShoppingModel = new OnlineShoppingModel();
       if($id)
            {
                $searchArray['order_id'] = $id;
            }
         $data['list'] = $OnlineShoppingModel->getData($searchArray);
        // echo"<pre>";
        //   print_r($data['list']);exit;
      $this->template->render('admintemplate', 'contents', 'admin/OnlineShopping/view',$data);


    }
      public function delete()
    {
        $data = array();     
       

         $id = $this->request->getGet('id');

            if($id)
            {
                $OnlineShoppingModel = new OnlineShoppingModel();

             
                    
                   $OnlineShoppingModel->where("order_id",$id)->delete();

                   
                   
                     $this->session->setFlashdata('message', 'Deleted  successfully.');
            }
            else
            {
                $this->session->setFlashdata('errmessage', 'Opps some error.');
            }
            
             return redirect()->to(site_url('getorderss'));
           
    }
    public function getBranch()
    {
         $company_id = $this->request->getGet('company_id');
        $branchModel = new BranchModel();
        $branch = $branchModel->where('company_id', $company_id)->findAll();
         echo json_encode($branch);
    }

  

}

?>
