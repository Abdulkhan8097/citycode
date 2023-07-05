<?php
namespace App\Controllers;
use App\Models\CouponModel;
use App\Models\CompanyModel;
use App\Models\BranchModel;
use App\Libraries\Paginationnew;
use App\Libraries\SiteVariables;

class AssignCouponAmount extends BaseController {
	
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
        }
         if($branch_id){
           $searchArray['branch_id'] = $branch_id;
        }
         if($status){
           $searchArray['status'] = $status;
        }
         $companyModel = new CompanyModel();
     
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();
        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
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
        
        

        $this->template->render('admintemplate', 'contents' , 'admin/AssignCouponAmount/list', $data);
     }


function addCoupon()
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
        $data['pagetitle'] = "Add Coupon";
        $companyModel = new CompanyModel();
        $data['companies'] = $companyModel->orderBy('company_name', 'DESC')->findAll();

        $branchModel = new BranchModel();
        $data['branches'] = $branchModel->orderBy('branch_name', 'DESC')->findAll();
	$this->template->render('admintemplate', 'contents' , 'admin/AssignCouponAmount/add',$data);
}
     }



   
function save()
    {
     // print_r($_POST);exit;    
$data = array();  
$CouponModel = new CouponModel();
        $postdata = $this->request->getPost();
         $id=$postdata['id'];

        $menudata = array(
                 "start_date"=>$postdata['start_date'],
                 "end_date"=>$postdata['end_date'],
                 "company_id"=>$postdata['company_id'],
                 "branch_id"=>$postdata['branch_id'],
                 "coupon_name"=>$postdata['coupon_name'],
                 "coupon_amount"=>$postdata['coupon_amount'],
                 "coupon_price"=>$postdata['coupon_price'],
                 "coupon_quantity"=>$postdata['coupon_quantity'],
                 "coupon_details"=>$postdata['coupon_details'],
                 "status"=>$postdata['status'],
              
             );
           if(intval($id)>0)
                {

                      $CouponModel->set($menudata)->where('id',$id)->update();

                
                        
                        $this->session->setFlashdata('message', 'Updated  successfully..');
     
                }
              else
                {
                            
                     $CouponModel->save($menudata);
                     
                      $this->session->setFlashdata('message', 'added  successfully.');
                }
                    
          
              return redirect()->to(site_url('viewcoupon'));  
     }






    public function delete()
    {
      $session = session();

        $id =  $this->request->getGet("id");
       $CouponModel = new CouponModel();
     

       if($id) {

            $CouponModel->where('id',$id)->delete();
          
               
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

       public function detailsCoupon(){
       $id= $this->request->getGet('id');
       $CouponModel = new CouponModel();
       if($id)
            {
                $searchArray['d'] = $id;
            }
         $data['list'] = $CouponModel->getData($searchArray);
        // echo"<pre>";
        //   print_r($data['list']);exit;
      $this->template->render('admintemplate', 'contents', 'admin/Coupon/view',$data);


    }

 


}

?>
