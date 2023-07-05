<?php
namespace App\Controllers;
use App\Models\CouponModel;
use App\Models\BranchModel;
use App\Models\AssignCouponAmountModel;
use App\Models\couponPurchaseModel;
use App\Models\CompanyModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class Coupon extends BaseController {
	
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
        $CouponModel = new CouponModel();
        $paginationnew = new Paginationnew(); 
        $branchModel = new BranchModel();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
         $start_date = $this->request->getGet('start_date');

            $end_date = $this->request->getGet('end_date');
            $company_id = $this->request->getGet('company_id');
            $branch_id = $this->request->getGet('branch_id');
            $status = $this->request->getGet('status');

        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
      if($start_date){
            $searchArray['start_date'] = $start_date ? $start_date : "";
          }
        if($end_date){
           $searchArray['end_date'] = $end_date ? $end_date : "";
        }
       
         if($company_id){
           $searchArray['company_id'] = $company_id;
            $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
         if($branch_id){
           $searchArray['branch_id'] = $branch_id;
        }
         if($status){
           $searchArray['status'] = $status;
        }
         $companyModel = new CompanyModel();
     
        // $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
         $coupon_purchase = new couponPurchaseModel();
 $data['companies'] =$coupon_purchase->comp();
        
        // $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
		$page = $this->request->getGet('page');
		$page = $page ? $page : 1;
		$Limit = PER_PAGE_RECORD;
		$totalRecord = $CouponModel->getData($searchArray,'','','1'); 
		$startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
		$data['startLimit'] = $startLimit;
		$pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		$data['txtsearch'] = $txtsearch;
		$data['startLimit'] = $startLimit;
		$data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;

      
        $data['list'] = $CouponModel->getData($searchArray, $startLimit, $Limit);
        //  $coupon_id=$data['list'][0]->id;
     
        // $coupon_purchase = new couponPurchaseModel();
        // $checkcoupondata=$coupon_purchase->where('coupon_id',$coupon_id)->find();
        // if ($checkcoupondata) {
        //    $data['cdeletehide']=$checkcoupondata;

        // }
       
        
        

        $this->template->render('admintemplate', 'contents' , 'admin/Coupon/list', $data);
     }


function addCoupon()
	{
         $id = $this->request->getGet('id');
         if ($id) {
             set_title('Update | ' . SITE_NAME);
        $data['pagetitle'] = "Update Coupon Type";
        
             $companyModel = new CompanyModel();
             $CouponModel = new CouponModel();
             $AssignCouponAmountModel = new AssignCouponAmountModel();
             $data['edit']= $edit= $CouponModel->find($id);
            $company_id = $edit['company_id'];
            $ass_data=$AssignCouponAmountModel->where('company_id',$company_id)->find();
            // print_r($ass_data);exit;

            //   print_r($company_id);exit;
        $coupon_purchase = new couponPurchaseModel();
 $data['companies'] =$coupon_purchase->comp();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->find();
         $data['results'] =  $CouponModel->getBranchName($id);
       $this->template->render('admintemplate', 'contents' , 'admin/Coupon/add',$data);
            
         }else{
             set_title('Add | ' . SITE_NAME);
        $data['pagetitle'] = "Add Coupon Type";
        $companyModel = new CompanyModel();
        // $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
    $coupon_purchase = new couponPurchaseModel();
 $data['companies'] =$coupon_purchase->comp();
 // print_r($data['companies']);exit;
        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
	$this->template->render('admintemplate', 'contents' , 'admin/Coupon/add',$data);
}
     }



   
function save()
    {
      // print_r($_POST);exit;    
$data = array();  
$CouponModel = new CouponModel();
$AssignCouponAmountModel = new AssignCouponAmountModel();
        $postdata = $this->request->getPost();
         $id=$postdata['id'];
         $company_id=$postdata['company_id'];
         $bal_amount=$postdata['bal_amount'];
         $coupon_amount=$postdata['coupon_amount'];
         $coupon_quantity=$postdata['coupon_quantity'];
          $coupon_amount = str_replace(".000", "", $coupon_amount);
         $addamtqty=$coupon_amount*$coupon_quantity;

         if($bal_amount){

      $bal_amount = str_replace(".000", "", $bal_amount);
       $bal_amount = (int) $bal_amount;
       $data=$bal_amount >= $addamtqty;
       if($data==false){
        $this->session->setFlashdata('errmessage', 'Invalid Amount.');
            return redirect()->to(site_url('addcoupon'));
       }
      }


       $branch_id = $postdata['branch_id'];

          if ($branch_id) {
            $branch_id = implode(',', $this->request->getVar('branch_id'));
        }
          if($bal_amount){
$cupdate=$bal_amount-$addamtqty;
$AssignCouponAmountModel = new AssignCouponAmountModel();
$data1=['bal_amount'=>$cupdate];
$check=$AssignCouponAmountModel->where('bal_amount',$bal_amount)->where('company_id',$company_id)->first();
$dataid=$check['id'];

$AssignCouponAmountModel->set($data1)->where('id',$dataid)->update();
 }
        $randomnumber =  rand(1000,9999);
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $res = "coupon-";

      for ($i = 0; $i < 10; $i++) {
          $res .= $chars[mt_rand(0, strlen($chars)-1)];     
      }

        $menudata = array(
                 "start_date"=>$postdata['start_date'],
                 "end_date"=>$postdata['end_date'],
                 "company_id"=>$postdata['company_id'],
                 "branch_id"=>$branch_id,
                 "coupon_name"=>$postdata['coupon_name'],
                 "coupon_amount"=>$postdata['coupon_amount'],
                 "coupon_price"=>$postdata['coupon_price'],
                 "coupon_quantity"=>'1',
                 "autounique"=>$res,
                 // "coupon_quantity"=>$postdata['coupon_quantity'],
                 "coupon_details"=>$postdata['coupon_details'],
                 "status"=>$postdata['status'],
                 "arb_coupon_name"=>isset($postdata['arb_coupon_name'])?$postdata['arb_coupon_name']:'',
                 "arb_coupon_details"=>isset($postdata['arb_coupon_details'])?$postdata['arb_coupon_details']:'',
              
             );
           
              for ($x = 1; $x <= $coupon_quantity; $x++) {
                 $checkstatus=$CouponModel->save($menudata);

                     if($checkstatus){
                       
                        $CompanyModel= new CompanyModel();
                        $company_id=$postdata['company_id'];
                        $couponStatus=['coupon_status'=>'1'];
                        $data=$CompanyModel->set($couponStatus)->where('id',$company_id)->update();
                        
                      

                     }
              }
                            
                     
                     
                      $this->session->setFlashdata('message', 'added  successfully.');
               
                    
          
              return redirect()->to(site_url('viewcoupon'));  
     }






    public function delete()
    {
      $session = session();

        $id =  $this->request->getGet("id");
        $couponPurchaseModel =new couponPurchaseModel();
        $checkcouponused=$couponPurchaseModel->where('coupon_id',$id)->first();
      
   
        if ($checkcouponused) {
            $this->session->setFlashdata("errmessage", "sorry, this coupon is used we can't delete");
           return redirect()->to($_SERVER["HTTP_REFERER"]);
        }
       


       $CouponModel = new CouponModel();
       $AssignCouponAmountModel = new AssignCouponAmountModel();
       $data=$CouponModel->select('*')->where('id',$id)->first();
       $coupon_amount=$data['coupon_amount'];
       $coupon_quantity=$data['coupon_quantity'];
       $total=$coupon_amount*$coupon_quantity;
      $company_id=$data['company_id'];

     

       if($id) {

        $chedata=$AssignCouponAmountModel->where('company_id',$company_id)->first();

        if($chedata){
             $data=array();
            $aid=$chedata['id'];
            $bal_amount=$chedata['bal_amount'];
            $totalAmount=$total+$bal_amount;
           
            $data['bal_amount']=$totalAmount;
            $AssignCouponAmountModel->set($data)->where('id',$aid)->update();
        }

            $CouponModel->where('id',$id)->delete();
            $check=$CouponModel->select('company_id')->where('company_id',$company_id)->first();
            if(!$check){
                 $CompanyModel= new CompanyModel();
                        
                        $couponStatus=['coupon_status'=>'0'];
                        $data=$CompanyModel->set($couponStatus)->where('id',$company_id)->update();
            }
          
               
            $this->session->setFlashdata('message', 'Coupon deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('viewcoupon'));
    }

public function getBranch()
    {
         $company_id = $this->request->getGet('company_id');
        $branchModel = new BranchModel();
        $branch = $branchModel->where('company_id', $company_id)->findAll();
         echo json_encode($branch);
    }
    public function getBranchasscoupon()
    {
         $company_id = $this->request->getGet('company_id');
        $AssignCouponAmountModel = new AssignCouponAmountModel();
        $branch = $AssignCouponAmountModel->groupBy('branch_id')->select('branch_id')->where('company_id', $company_id)->findAll();

        foreach ($branch as $key => $value) {
            // code...
        
         $branchModel = new BranchModel();
        $branch = $branchModel->groupBy('branch_id')->where('company_id', $company_id)->findAll();
        

       }
       // echo"<pre>";
       // print_r($branch);exit;
        echo json_encode($branch);
       
    }

       public function detailsCoupon(){
       $id= $this->request->getGet('id');
       $CouponModel = new CouponModel();
       if($id)
            {
                $searchArray['id'] = $id;
            }
         $data['list'] = $CouponModel->getData($searchArray);
        // echo"<pre>";
        //   print_r($data['list']);exit;
      $this->template->render('admintemplate', 'contents', 'admin/Coupon/view',$data);


    }

    ///coupon set amount
    function list() {

    $session = session();
        
    if($session->get('user_id')){         
           $isAdminLoggedIn = $session->get('user_id');         
    }
             if(!$this->isAdminLoggedIn)
        {  
          return redirect()->to(site_url('admin'));
        }
        $data = array();
        $AssignCouponAmountModel = new AssignCouponAmountModel();
              $branchModel = new BranchModel();
        $paginationnew = new Paginationnew(); 
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
         $start_date = $this->request->getGet('start_date');

            $end_date = $this->request->getGet('end_date');
            $company_id = $this->request->getGet('company_id');
            $branch_id = $this->request->getGet('branch_id');
            $status = $this->request->getGet('status');

        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }
      if($start_date){
            $searchArray['start_date'] = $start_date ? $start_date : "";
          }
        if($end_date){
           $searchArray['end_date'] = $end_date ? $end_date : "";
        }
       
         if($company_id){
           $searchArray['company_id'] = $company_id;
           $data['branches']  = $branchModel->where('company_id', $company_id)->findAll();
        }
         if($branch_id){
           $searchArray['branch_id'] = $branch_id;
        }
         if($status){
           $searchArray['status'] = $status;
        }
         $companyModel = new CompanyModel();
     
        // $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
         $coupon_purchase = new couponPurchaseModel();
      $data['companies'] =$coupon_purchase->comp();
  
        // $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $AssignCouponAmountModel->getData($searchArray,'','','1'); 
      

        $startLimit = ($page - 1) * $Limit;
        $data['reverse'] = $totalRecord-($page -1) * $Limit;
     
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;

      
        $data['list'] = $AssignCouponAmountModel->getData($searchArray, $startLimit, $Limit);
        
         // print_r($data['list']);exit;

        $this->template->render('admintemplate', 'contents' , 'admin/AssignCouponAmount/list', $data);
     }

     function addCouponAmount()
    {
         $id = $this->request->getGet('id');
         if ($id) {
             set_title('Update | ' . SITE_NAME);
        $data['pagetitle'] = "Update Coupon";
        
             $companyModel = new CompanyModel();
             $CouponModel = new CouponModel();
             $data['edit'] = $CouponModel->find($id);
             // print_r($data['edit']);exit;
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->find();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->find();
       $this->template->render('admintemplate', 'contents' , 'admin/AssignCouponAmount/add',$data);
            
         }else{
             set_title('Add | ' . SITE_NAME);
        $data['pagetitle'] = "Set Company Coupon Amount";
        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
    $this->template->render('admintemplate', 'contents' , 'admin/AssignCouponAmount/add',$data);
         }
     }

     function saveAssignAmount()
    {
        // print_r($_POST);exit;    
        $data = array();  
        $AssignCouponAmountModel = new AssignCouponAmountModel();
        $postdata = $this->request->getPost();
        $id=$postdata['id'];
        $branch_id = $postdata['branch_id'];

        $company_id = $postdata['company_id'];
        $plusamount=$postdata['add_amount'];
   
         $bal_amount = $postdata['bal_amount'];


        if ($branch_id) {
            $balamount=0;
            foreach($branch_id as $value){

$balamount= $AssignCouponAmountModel->select('bal_amount')->where('branch_id', $value)->where('company_id', $company_id)->findAll();

 foreach($balamount as $balamountp){
// print_r($balamountp['bal_amount']);exit;
    $bal_amount=$balamountp['bal_amount']+$plusamount;
    

   



                  $menudata = array(
                 
                 "company_id"=>$postdata['company_id'],
                 "branch_id"=>$value,
                 "bal_amount"=>$bal_amount,
                 "assign_amount"=>$postdata['add_amount']
                
              
             );

                  $data=$AssignCouponAmountModel->save($menudata);
                   }
                   if (!$balamount) {
                       // code...
                
                    $menudata = array(
                 
                 "company_id"=>$postdata['company_id'],
                 "branch_id"=>$value,
                 "bal_amount"=>$plusamount,
                 "assign_amount"=>$postdata['add_amount']
                
              
             );

                  $data=$AssignCouponAmountModel->save($menudata);
                   }
              }

            // $branch_id = implode(',', $this->request->getVar('branch_id'));
            //  print_r($branch_id);exit;
        }
   
        

      
         
              
                            
                     
                 
                     
                      $this->session->setFlashdata('message', 'added  successfully.');
               
                    
          
              return redirect()->to(site_url('viewcouponamt'));  
     }


     public function getBalance()
    {
         $AssignCouponAmountModel = new AssignCouponAmountModel();
       
        $branch_id = $this->request->getGet('branch_id');
        $company_id = $this->request->getGet('company_id');
       
   if ($branch_id=='Select All') {
       $branchModel = new BranchModel();
        $branch = $branchModel->select('branch_id')->where('company_id', $company_id)->findAll();
        $balamt=0;
       foreach($branch as $branch_id){
 $data = $AssignCouponAmountModel->select('')->where('company_id', $company_id)->where('branch_id', $branch_id)->orderBy('id','desc')->first();
 $sum+=$data['bal_amount'];


       }

      echo number_format($sum, 3, '.', '');
   }else{
        $AssignCouponAmountModel = new AssignCouponAmountModel();
        $data = $AssignCouponAmountModel->where('company_id', $company_id)->where('branch_id', $branch_id)->orderBy('id','desc')->first();
           $sum=$data['bal_amount'];
        // $sum =0;
        // foreach($data as $value){
        //     $sum +=$value['assign_amount'];
        // }
        echo number_format($sum, 3, '.', '');
    }
        
        
         // echo json_encode($i);
    }

     public function AssigndetailsCoupon(){
       $id= $this->request->getGet('id');
       $AssignCouponAmountModel = new AssignCouponAmountModel();
       if($id)
            {
                $searchArray['id'] = $id;
            }
         $data['list'] = $AssignCouponAmountModel->getData($searchArray);
        // echo"<pre>";
        //   print_r($data['list']);exit;
      $this->template->render('admintemplate', 'contents', 'admin/AssignCouponAmount/view',$data);


    }
     public function deletecoupon()
    {
      $session = session();

        $id =  $this->request->getGet("id");

       $AssignCouponAmountModel = new AssignCouponAmountModel();
       $CouponModel = new CouponModel();

       $checkid=$AssignCouponAmountModel->where('id',$id)->first();
       $company_id=$checkid['company_id'];
      
       $coupon_purchase = new couponPurchaseModel();
       $checkused=$coupon_purchase->where('company_id',$company_id)->first();


       if($id) {

        if ($checkused) {
            $this->session->setFlashdata("errmessage", "sorry, this coupon is used we can't delete");
           return redirect()->to($_SERVER["HTTP_REFERER"]);
        }

       

            $changestatus=$AssignCouponAmountModel->where('id',$id)->delete();
            $comcheck=$coupon_purchase->where('company_id',$company_id)->find();
            $comcheckCoupon=$CouponModel->where('company_id',$company_id)->find();
          if($comcheckCoupon){
            $CouponModel->where('company_id',$company_id)->delete();
            }
       
            if($comcheck){
           $coupon_purchase->where('company_id',$company_id)->delete();
            }
            if($changestatus){
                 $CompanyModel= new CompanyModel();
                        
                        $couponStatus=['coupon_status'=>'0'];
                        $data=$CompanyModel->set($couponStatus)->where('id',$company_id)->update();
            }
          
               
            $this->session->setFlashdata('message', 'Coupon deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('viewcouponamt'));
    }

       

 


}

?>
