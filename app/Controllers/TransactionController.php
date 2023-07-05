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
use App\Models\OnlineShoppingTransactionModel;
use App\Models\OnlineShoppingModel;
use App\Libraries\Paginationnew;

class TransactionController extends BaseController {

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
            $company_id = ($session->get('company_id'));
             if($company_id){ $searchArray['company_id'] =$company_id;  }
          
        if($start_date){
            $searchArray['start_date'] = $start_date ? $start_date : "";
          }
        if($end_date){
           $searchArray['end_date'] = $end_date;
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

          
            $totalRecord = $OnlineShoppingModel->getDataTransaction($searchArray);
       
            $data['txtsearch'] = $txtsearch;
            // $data['product_id'] = $product_id;
         
          
            $data["searchArray"] = $searchArray;
            $companyModel = new CompanyModel();
            $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
            $branchModel = new BranchModel();
            $data['branches']  = array();

           
        
           $data['list'] = $OnlineShoppingModel->getDataTransaction($searchArray, $startLimit, $Limit);
           // echo"<pre>";
           // print_r($data['list']);exit;
      
        $this->template->render('admintemplate', 'contents', 'admin/Transaction/txn_amount',$data);
    }


     public function balanceAmount() {

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
             $start_date = $this->request->getPost('order_start_date');

            $end_date = $this->request->getPost('order_end_date');
            $product_id = $this->request->getPost('product_id');
            $company_id = $this->request->getPost('company_id');
            $branch_id = $this->request->getPost('branch_id');
          
          
        if($start_date){
            $searchArray['start_date'] = $start_date ? $start_date : "";
          }
    
        if($end_date){
           $searchArray['end_date'] = $end_date;
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

         
            $totalRecord = $OnlineShoppingModel->getDataTransaction($searchArray);
           
          
           
            $data['txtsearch'] = $txtsearch;
            // $data['product_id'] = $product_id;
         
           
            $data['startLimit'] = $startLimit;
            $data['pagination'] = $pagination;
            $data["searchArray"] = $searchArray;
            $companyModel = new CompanyModel();
            $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
            $branchModel = new BranchModel();
           

            
           
        
           $data['list'] = $OnlineShoppingModel->getDataTransaction($searchArray);
           // echo"<pre>";
           // print_r($data['list']);exit;
      
        $this->template->render('admintemplate', 'contents', 'admin/Transaction/balance_amount',$data);
    }
    public function recorddetails(){
       $id= $this->request->getGet('id');
       $OnlineShoppingTransactionModel = new OnlineShoppingTransactionModel();
       if($id)
            {
                $searchArray['d'] = $id;
            }
         $data['list'] = $OnlineShoppingTransactionModel->getData($searchArray);
        // echo"<pre>";
        //   print_r($data['list']);exit;
      $this->template->render('admintemplate', 'contents', 'admin/Transaction/view',$data);


    }
      public function delete()
    {
        $data = array();     
       

         $id = $this->request->getGet('id');

            if($id)
            {
                $OnlineShoppingTransactionModel = new OnlineShoppingTransactionModel();

             
                    
                   $OnlineShoppingTransactionModel->where("id",$id)->delete();

                   
                   
                     $this->session->setFlashdata('message', 'Deleted  successfully.');
            }
            else
            {
                $this->session->setFlashdata('errmessage', 'Opps some error.');
            }
            
             return redirect()->to(site_url('viewrecord'));
           
    }
    public function getBranch()
    {
         $company_id = $this->request->getGet('company_id');
        $branchModel = new BranchModel();
        $branch = $branchModel->where('company_id', $company_id)->findAll();
         echo json_encode($branch);
    }

    public function save(){

        $amount=$this->request->getPost('amount');
        if ($amount) {
      
        $data= ['start_date'=>isset($_POST['order_start_date'])?$this->request->getPost('order_start_date'):'',
             'end_date'=>isset($_POST['order_end_date'])?$this->request->getPost('order_end_date'):'',
             'company_id'=>isset($_POST['company_id'])?$this->request->getPost('company_id'):'',
             'branch_id'=>isset($_POST['branch_id'])?$this->request->getPost('branch_id'):'',
             'total_amount_paid_by_customer'=>isset($_POST['total_amount_paid_by_customer'])?$this->request->getPost('total_amount_paid_by_customer'):'',
             'total_supplier_amount'=>isset($_POST['total_supplier_amount'])?$this->request->getPost('total_supplier_amount'):'',
             'total_citycode_charage'=>isset($_POST['total_citycode_charage'])?$this->request->getPost('total_citycode_charage'):'',
             'amount'=>$amount
           ];  
           $OnlineShoppingTransactionModel =new OnlineShoppingTransactionModel();
           $OnlineShoppingTransactionModel->insert($data);
           return redirect()->to(site_url('viewrecord'));
            }else{
                $this->session->setFlashdata('errmessage', 'Opps some error.');
                return redirect()->to(site_url('viewrecord'));
            }
        }

       function ViewRecord() {
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

         $OnlineShoppingTransactionModel =new OnlineShoppingTransactionModel();
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
            $totalRecord = $OnlineShoppingTransactionModel->getData($searchArray, '', '', '1');
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
           
        
           $data['list'] = $OnlineShoppingTransactionModel->getData($searchArray, $startLimit, $Limit);
           // echo"<pre>";
           // print_r($data['list']);exit;
      
        $this->template->render('admintemplate', 'contents', 'admin/Transaction/list',$data);
    }

    public function companySave()
    {
        $id=$this->request->getPost('id');
       if(intval($id)>0)
        {
            $OnlineShoppingTransactionModel =new OnlineShoppingTransactionModel();
        
         $data= ['cpaid_amount'=>isset($_POST['cpaid_amount'])?$this->request->getPost('cpaid_amount'):'',
             'payment_mode'=>isset($_POST['payment_mode'])?$this->request->getPost('payment_mode'):'',
             'txn_no'=>isset($_POST['txn_no'])?$this->request->getPost('txn_no'):'',
             'remark'=>isset($_POST['remark'])?$this->request->getPost('remark'):'',
             'supplier_payment_date'=>date("Y/m/d"),
             'payment_status'=>'1',
            
           ]; 

$OnlineShoppingTransactionModel->set($data)->where('id',$id)->update();
 $this->session->setFlashdata('message', 'successfully.');
          
return redirect()->to(site_url('viewrecord'));

    }else{
         $this->session->setFlashdata('errmessage', 'Opps some error.');
                return redirect()->to(site_url('viewrecord'));

    }
}

  

}

?>
