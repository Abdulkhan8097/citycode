<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\AdminModel;
use App\Models\MedicineModel;
use App\Models\MedicineImagesModel;
use App\Models\OrdersModel;
use App\Models\DelBoyModel;
use App\Models\UserModel;
use CodeIgniter\Session\Session;

class AdminController extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
    {
        
        $this->session = session();
      // echo "<pre>"; print_r($session);die;
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');

	}

    public function medicineslist()
    {
     
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $medModel = new MedicineModel();
                            
        $paginationnew = new \App\Libraries\Paginationnew();
                 
        $searchArray = '';
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $medModel->getData($searchArray,'','',1); // return count value

        $startLimit = ($page - 1) * $Limit;
        $data['startLimit'] = $startLimit;

        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['pagination'] = $pagination;
        $data["ordersData"] = $medModel->getData($searchArray, $startLimit, $Limit);
        $data["searchArray"] = $searchArray;          
         
        $this->template->render('admintemplate', 'contents' , 'admin/medicines/medicineslist', $data);
                
    }

    public function newmedicineform()
    {
     
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }         
        $this->template->render('admintemplate', 'contents' , 'admin/medicines/newmedicineform');                
    }

    public function addmedicine()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $medModel = new MedicineModel();
        $medimgModel = new MedicineImagesModel();
            
        // echo "<pre>";print_r($this->request->getPost()); die();
        
        $medname =$this->request->getPost('med_name');
        $itemprice =$this->request->getPost('item_price'); 
        $med_description =$this->request->getPost('medicine_description');

        $searchArray = array('txtsearch'=>$medname);

        $totalRecord = $medModel->getData($searchArray,'','',1); // return count value

        if($totalRecord > 0){
            $this->session->setFlashdata('errmessage', 'Medicine Already Exist.');

            return redirect()->to(site_url('AddMedicine'));
        } else {

            if($file = $this->request->getFile('medicine_icon')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                   // Get file name and extension
                   $name = $file->getName();
                   $ext = $file->getClientExtension();

                   // Get random file name
                   $newName = $file->getRandomName(); 

                   // Store file in public/uploads/ folder
                   $file->move('../public/medicineimages', $newName);

                   $medicine_icon = $newName;

                   $arrSaveData = array(
                    'medicine_name'=>$medname,
                    'item_price'=>$itemprice,
                    'medicine_desc'=>$med_description,
                    'medicine_icon'=>$medicine_icon,
                    // 'medicine_images'=>$medicineimages,
                    );
                    // echo "<pre>";print_r($arrSaveData); die();

                    $medModel->save($arrSaveData);
                    $medId = $medModel->getInsertID();

                   $name_array = array();
                    if($imagefile = $this->request->getFiles())
                    {
                       foreach($imagefile['medicine_images'] as $img)
                       {
                          if ($img->isValid() && ! $img->hasMoved())
                          {
                               $newName = $img->getRandomName();
                               $img->move('../public/medicineimages', $newName);

                               // $name_array[] = $newName;

                               $arrSaveData = array(
                                'image_name'=>$newName,
                                'medicine_id'=>$medId,
                                );

                               $query = $medimgModel->save($arrSaveData);
                          }
                       }
                    }

                    // $medicineimages= implode(',', $name_array);

               } else {
                    $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');

                    return redirect()->to(site_url('AddMedicine'));
               }
           } else {
                $this->session->setFlashdata('errmessage', 'Medicine Icon Not Uploaded! Try Again.');

                return redirect()->to(site_url('AddMedicine'));
           }

            //echo $names; die();            
                        
           if($query) {
                
                $this->session->setFlashdata('message', 'Medicine Added succesfully.');
                
                return redirect()->to(site_url('Medicines'));

            } else {
                
                $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }

        // echo "<pre>";print_r($newName); die();      
    }

    public function medicinedetail()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
        $id =  $this->request->getGet("id");
            
        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'Medicine ID is not proper');

            return redirect()->to(site_url('Medicines'));
        }

        $medModel = new MedicineModel();
        $medimgModel = new MedicineImagesModel();

        $data = array();

        $searchArray = array('txtsearch'=>$id);

        $data['medicinedetails'] = $medModel->getMedicinedetail($id);
        $data["medicineimages"] = $medimgModel->getData($searchArray,'', '', '');
           
        if(!$data['medicinedetails'])
        {
            $this->session->setFlashdata('errmessage', 'Medicine Does not exist!');
            return redirect()->to(site_url('Medicines'));
        }
        // echo "<pre>";print_r($data); die();
        $this->template->render('admintemplate', 'contents' , 'admin/medicinedetails', $data);
    }

    public function editmedicinepage()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
        $id =  $this->request->getGet("id");

        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'Medicine ID is not proper');

            return redirect()->to(site_url('Medicines'));
        }

        $medModel = new MedicineModel();
        $medimgModel = new MedicineImagesModel();

        $data = array();

        $searchArray = array('txtsearch'=>$id);

        $data['medicinedetails'] = $medModel->getMedicinedetail($id);
        $data["medicineimages"] = $medimgModel->getData($searchArray,'', '', '');

        if(!$data['medicinedetails'])
        {
            $this->session->setFlashdata('errmessage', 'Medicine Does not exist!');
            return redirect()->to(site_url('Medicines'));
        }
        // echo "<pre>";print_r($data); die();
        $this->template->render('admintemplate', 'contents' , 'admin/medicines/editmedicinepage', $data);
    }

    public function deliveryboylist()
    {
     
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $data= array();

        $delboyModel = new DelBoyModel();

        $searchArray = '';
        $data["deliveryboylist"] = $delboyModel->getData($searchArray,'', '', '');

        $this->template->render('admintemplate', 'contents' , 'admin/user/deliveryboylist', $data);
    }

    public function deliveryboydetail()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $delboyModel = new DelBoyModel();

        $data['deliveryboydetails'] = $delboyModel->getdeliveryboybyID($id); // return count value

        // print_r($data['deliveryboydetails']);die();

        if(!$data['deliveryboydetails'])
        {
            $this->session->setFlashdata('errmessage', 'Delivery Boy Id Does not exist!');
            return redirect()->to(site_url('DeliveryBoy'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/user/deliveryboydetails', $data);
    }

    public function newdeliveryboyform()
    {
     
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }         
        $this->template->render('admintemplate', 'contents' , 'admin/newdeliveryform');                
    }

    public function editdeliveryboypage()
    {
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");

        $delboyModel = new DelBoyModel();

        $data['deliveryboydetails'] = $delboyModel->getdeliveryboybyID($id); // return count value

        // print_r($data['deliveryboydetails']);die();

        if(!$data['deliveryboydetails'])
        {
            $this->session->setFlashdata('errmessage', 'Delivery Boy Id Does not exist!');
            return redirect()->to(site_url('DeliveryBoy'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/user/editdeliveryform', $data);
    }

    public function deliveryitemlist()
    { 
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $orderModel = new OrdersModel();

        $searchArray = '';
        $data ['allorders'] = $orderModel->getData($searchArray,'','',''); // return count value
        
        $this->template->render('admintemplate', 'contents' , 'admin/orders/deliveryitemlist',$data);
    }

    public function deliveryitemdetails()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

        $orderid =  $this->request->getGet("orderid");
        
        $orderModel = new OrdersModel();
        
        $data['orderdetails'] = $orderModel->getOrderDetailsbyid($orderid); 

        $this->template->render('admintemplate', 'contents' , 'admin/orders/deliverydetailspage',$data);
    }

    public function remove_medicine_icon()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if($isAdminLoggedIn)
        {
            $id =  $this->request->getPost("med_id");
            $medicon =  $this->request->getPost("med_icon");
            // echo $id; die();
            $medModel = new MedicineModel();

            $path_to_file = '../public/medicineimages/'.$medicon;
            // echo $path_to_file;
            if(unlink($path_to_file)) {
                $arrSaveData = array(
                    'medicine_icon'=> '',
                );

                $Update = $medModel->where('id',$id)->set($arrSaveData)->update();

                if($Update){
                    $this->session->setFlashdata('message', 'Icon Successfully Deleted.');
                } else {
                    $this->session->setFlashdata('errmessage', 'Icon Not Deleted From Database');
                }
            } else {
                $this->session->setFlashdata('errmessage', 'Icon Not Deleted From Server');
            }            
        } else {
            return redirect()->to(site_url('admin'));
        }
    }

    public function delete_medicine_image()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if($isAdminLoggedIn)
        {
            $id =  $this->request->getPost("med_id");
            $img_id =  $this->request->getPost("image_id");
            $img_name =  $this->request->getPost("image_name");

            // echo $id; die();
            $medimgModel = new MedicineImagesModel();

            $path_to_file = '../public/medicineimages/'.$img_name;
            // echo $path_to_file;
            if(unlink($path_to_file)) {
                $Update = $medimgModel->where('id',$img_id)->delete();

                if($Update){
                    $this->session->setFlashdata('message', 'Image Successfully Deleted.');
                } else {
                    $this->session->setFlashdata('errmessage', 'Image Not Deleted From Database');
                }
            } else {
                $this->session->setFlashdata('errmessage', 'Image Not Deleted From Server');
            }
        } else {
            return 'Invalid Access';
        }
    }

    public function deletemedicine()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if($isAdminLoggedIn)
        {
            $id =  $this->request->getGet("id");

            $medModel = new MedicineModel();
            $medimgModel = new MedicineImagesModel();

            $data = array();

            $searchArray = array('txtsearch'=>$id);

            $medicinedetails = $medModel->getMedicinedetail($id);
            $medicon =  $medicinedetails["medicine_icon"];
         
            $path_to_file = '../public/medicineimages/'.$medicon;
            // echo $path_to_file;
            if(unlink($path_to_file)) {
                
                $medModel->where('id',$id)->delete();

                $medicineimages = $medimgModel->getData($searchArray,'', '', '');

                foreach($medicineimages as $img){
                    $path_to_file = '../public/medicineimages/'.$img->image_name;
                    unlink($path_to_file);
                }

                $medimgModel->where('medicine_id',$id)->delete();

                $this->session->setFlashdata('message', 'Medicine Successfully Deleted.');

            } else {
                $this->session->setFlashdata('errmessage', 'Image Deleting Error.');
            }
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Medicines'));
    }

    public function updatemedicine()
    {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
            
        $med_id = $this->request->getPost('med_id');

        if(!$med_id)
        {
            $this->session->setFlashdata('errmessage', 'Medicine does not exist!');

            return redirect()->to(site_url('adminlist'));
        }
            
        //   echo "<pre>";print_r($this->request->getPost());die();
            
        $medname =$this->request->getPost('med_name');
        $itemprice =$this->request->getPost('item_price'); 
        $med_description =$this->request->getPost('medicine_description');
        $status =$this->request->getPost('status');
        $med_icon = $this->request->getFile('medicine_icon');
        
        $medModel = new MedicineModel();
        $medimgModel = new MedicineImagesModel();

        if($file = $this->request->getFile('medicine_icon')) {
            if ($file->isValid() && ! $file->hasMoved()) {
               // Get file name and extension
               $name = $file->getName();
               $ext = $file->getClientExtension();

               // Get random file name
               $newName = $file->getRandomName(); 

               // Store file in public/uploads/ folder
               $file->move('../public/medicineimages', $newName);

               $medicine_icon = $newName;
            }
        }

        $arrSaveData = array(
            'medicine_name'=>$medname,
            'item_price'=>$itemprice,
            'medicine_desc'=>$med_description,
            'status'=>$status,
            );

        if($med_icon != ''){
            $arrSaveData['medicine_icon'] = $medicine_icon;
        }

        $Update = $medModel->where('id',$med_id)->set($arrSaveData)->update();

        $name_array = array();
        if($imagefile = $this->request->getFiles())
        {
           foreach($imagefile['medicine_images'] as $img)
           {
              if ($img->isValid() && ! $img->hasMoved())
              {
                   $newName = $img->getRandomName();
                   $img->move('../public/medicineimages', $newName);

                   // $name_array[] = $newName;

                   $arrSaveData = array(
                    'image_name'=>$newName,
                    'medicine_id'=>$med_id,
                    );

                   $query = $medimgModel->save($arrSaveData);
              }
           }
        }
        
         

        if($Update) {
            
            $this->session->setFlashdata('message', 'Medicine updated succesfully.');
            
            return redirect()->to(site_url('EditMedicine?id='.$med_id));

        } else {
            
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            
            return redirect()->to($_SERVER['HTTP_REFERER']);

        }
    }


    public function updatedeliveryboy()
    {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
            
        $delboy_id = $this->request->getPost('delboy_id');

        if(!$delboy_id)
        {
            $this->session->setFlashdata('errmessage', 'Delivery Boy Id does not exist!');

            return redirect()->to(site_url('adminlist'));
        }
            
        //   echo "<pre>";print_r($this->request->getPost());die();
            
        $fname =$this->request->getPost('firstname');
        $lname =$this->request->getPost('lastname'); 
        $password =$this->request->getPost('password');
        $email =$this->request->getPost('email');
        $mobile = $this->request->getPost('mobilenumber');
        $status = $this->request->getPost('status');

        $delboyModel = new DelBoyModel();

        $arrSaveData = array(
            'fname'=>$fname,
            'lname'=>$lname,
            'email'=>$email,
            'phone'=>$mobile,
            'user_status'=>$status,
            );

        if($password != ''){
            $arrSaveData['password'] = $password;
        }

        $Update = $delboyModel->where('id',$delboy_id)->set($arrSaveData)->update();         

        if($Update) {
            
            $this->session->setFlashdata('message', 'Delivery Boy updated succesfully.');
            
            return redirect()->to(site_url('editDeliveryBoy?id='.$delboy_id));

        } else {
            
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            
            return redirect()->to(site_url('editDeliveryBoy?id='.$delboy_id));

        }
    }

    public function customerlist()
    { 
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $userModel = new UserModel();

        $searchArray = '';
        $data ['allcustomer'] = $userModel->getData($searchArray,'','',''); // return count value
        
        $this->template->render('admintemplate', 'contents' , 'admin/user/customerlist',$data);
    }

    public function customerdetails()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }

        $custid =  $this->request->getGet("id");
        
        $userModel = new UserModel();
        
        $data['custdetails'] = $userModel->getUserdetail($custid); 

        $this->template->render('admintemplate', 'contents' , 'admin/user/customerdetailspage',$data);
    }








	public function subadminlist()
	{
     
	    if(!$this->isAdminLoggedIn)
	    {  
	           return redirect()->to(site_url('admin'));
	    }

	    $adminModel = new AdminModel();
            
		set_title('Welcome | ' . SITE_NAME);
        
        $userid = $this->session->get('user_id');
                
        $paginationnew = new \App\Libraries\Paginationnew();
                 
		$searchArray = '';
		$page = $this->request->getGet('page');
		$page = $page ? $page : 1;
		$Limit = PER_PAGE_RECORD;
		$totalRecord = $adminModel->getData($searchArray,'','',1); // return count value

		$startLimit = ($page - 1) * $Limit;
		$data['startLimit'] = $startLimit;

		$pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		$data['pagination'] = $pagination;
		$data["ordersData"] = $adminModel->getData($searchArray, $startLimit, $Limit);
		$data["searchArray"] = $searchArray;          
         
        $this->template->render('admintemplate', 'contents' , 'admin/subadminlist', $data);
				
	}

	public function userslist()
	{
     
	    if(!$this->isAdminLoggedIn)
	    {  
	           return redirect()->to(site_url('admin'));
	    }

	    $usermodel = new UserModel();
            
		set_title('Welcome | ' . SITE_NAME);
        
        $paginationnew = new \App\Libraries\Paginationnew();
                 
		$searchArray = '';
		$page = $this->request->getGet('page');
		$page = $page ? $page : 1;
		$Limit = PER_PAGE_RECORD;
		$totalRecord = $usermodel->getData($searchArray,'','',1); // return count value

		$startLimit = ($page - 1) * $Limit;
		$data['startLimit'] = $startLimit;

		$pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
		$data['pagination'] = $pagination;
		$data["ordersData"] = $usermodel->getData($searchArray, $startLimit, $Limit);
		$data["searchArray"] = $searchArray;          
         
        $this->template->render('admintemplate', 'contents' , 'admin/userslist', $data);
				
	}

	public function newadmin()
	{
     
	    if(!$this->isAdminLoggedIn)
	    {  
	           return redirect()->to(site_url('admin'));
	    }         
        $this->template->render('admintemplate', 'contents' , 'admin/addadmin');				
	}

	public function addadmin()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $adminModel = new AdminModel();
            
        // echo "<pre>";print_r($this->request->getPost()); die();
        
        $fname =$this->request->getPost('firstname'); 
        $lname =$this->request->getPost('lastname'); 
        $password =$this->request->getPost('password'); 
        $rep_password =$this->request->getPost('rep_password'); 
        $email =$this->request->getPost('email'); 
        $mobile =$this->request->getPost('mobilenumber');

        $searchArray = array('txtsearch'=>$email);

        // echo "<pre>";print_r($searchArray); die();
        
        $totalRecord = $adminModel->getData($searchArray,'','',1); // return count value
        
        if($totalRecord > 0){
            echo 'Sub Admin Already Exists';
        } else {
            $arrSaveData = array(
            'fname'=>$fname,
            'lname'=>$lname,
            'password'=>password_hash($password, 1),
            'email'=>$email,
            'phone'=>$mobile,
            'admin_type'=>'subadmin',
            );
            // echo "<pre>";print_r($arrSaveData); die();

            $adminModel->save($arrSaveData);
            $adminId = $adminModel->getInsertID();
            
            if($adminId){
                echo 'Sub Admin Created ID '.$adminId.' '.$arrSaveData['admin_type'];
            } else {
                echo 'Something Went Wrong';
            }
        }
	}

	public function newowner()
	{
     
	    if(!$this->isAdminLoggedIn)
	    {  
	           return redirect()->to(site_url('admin'));
	    }

        $adminModel = new AdminModel();

        $admintype = 'subadmin';
        $searchArray = array('txtsearch'=>$admintype);
        
        $data['subadminlist'] = $adminModel->getData($searchArray,'','','');
        // echo "<pre>";print_r($data['subadminlist']); die();

        $this->template->render('admintemplate', 'contents' , 'admin/addowner', $data);				
	}

	public function newstaff()
	{
     
	    if(!$this->isAdminLoggedIn)
	    {  
	           return redirect()->to(site_url('admin'));
	    }

        $adminModel = new AdminModel();

        $admintype = 'subadmin';
        $searchArray = array('txtsearch'=>$admintype);
        
        $data['subadminlist'] = $adminModel->getData($searchArray,'','','');
       // echo "<pre>";print_r($data['ownerslist']); die();

        $this->template->render('admintemplate', 'contents' , 'admin/addstaff', $data);				
	}

	public function addowner()
    {
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $userModel = new UserModel();
            
        // echo "<pre>";print_r($this->request->getPost()); die();
        
        $fname =$this->request->getPost('firstname'); 
        $lname =$this->request->getPost('lastname'); 
        $password =$this->request->getPost('password'); 
        $rep_password =$this->request->getPost('rep_password'); 
        $email =$this->request->getPost('email'); 
        $mobile =$this->request->getPost('mobilenumber');
        $subadmin =$this->request->getPost('sub_admin');
    
        $searchArray = array('txtsearch'=>$email);

        // echo "<pre>";print_r($searchArray); die();

        $totalRecord = $userModel->getData($searchArray,'','',1); // return count value

        // echo "<pre>";print_r($totalRecord); die();
        
        if($totalRecord > 0){
            $this->session->setFlashdata('errmessage', 'User Name Already Exist');
                
            echo '<script>window.history.back();</script>';
        } else {
            $arrSaveData = array(
            'fname'=>$fname,
            'lname'=>$lname,
            'password'=>password_hash($password, 1),
            'email'=>$email,
            'phone'=>$mobile,
            'sub_admin'=>$subadmin,
            'user_type'=>'owner',
            );
            // echo "<pre>";print_r($arrSaveData); die();
            $userModel->save($arrSaveData);
            $ownerId = $userModel->getInsertID();
            
            if($ownerId) {
                
                $this->session->setFlashdata('message', 'Owner Added succesfully.');
                
                return redirect()->to(site_url('newowner'));

            } else {
                
                $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }
        
	}

	public function addstaff()
    {
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $userModel = new UserModel();
            
        // echo "<pre>";print_r($this->request->getPost()); die();
        
        $fname =$this->request->getPost('firstname'); 
        $lname =$this->request->getPost('lastname'); 
        $password =$this->request->getPost('password'); 
        $rep_password =$this->request->getPost('rep_password'); 
        $email =$this->request->getPost('email'); 
        $mobile =$this->request->getPost('mobilenumber'); 
        $subadmin =$this->request->getPost('sub_admin'); 
        $owner =$this->request->getPost('owner'); 
    
        $arrSaveData = array(
            'fname'=>$fname,
            'lname'=>$lname,
            'password'=>password_hash($password, 1),
            'email'=>$email,
            'phone'=>$mobile,
            'sub_admin'=>$subadmin,
            'owner'=>$owner,
            'user_type'=>'staff',
        );
        // echo "<pre>";print_r($arrSaveData); die();

        $searchArray = array('txtsearch'=>$email);

        // echo "<pre>";print_r($searchArray); die();

        $totalRecord = $userModel->getData($searchArray,'','',1); // return count value

        // echo "<pre>";print_r($totalRecord); die();
        
        if($totalRecord > 0){
            $this->session->setFlashdata('errmessage', 'Email Already Exist');
                
            echo '<script>window.history.back();</script>';
        } else {

        $userModel->save($arrSaveData);
        $userId = $userModel->getInsertID();
        
        if($userId) {
                
                $this->session->setFlashdata('message', 'Staff Added succesfully.');
                
                return redirect()->to(site_url('newstaff'));

            } else {
                
                $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }
	}

    public function delsubadmin()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id =  $this->request->getGet("id");

        $adminModel = new AdminModel();

        if($isAdminLoggedIn)
        {
            $adminModel->where('id',$id)->delete();
                
            $this->session->setFlashdata('message', 'Subadmin deleted succesfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('adminlist'));
    }

    public function editsubadmin()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
        $id =  $this->request->getGet("id");
            
        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'SubAdmin ID number doesnot exist! Please try again.');

            return redirect()->to(site_url('adminlist'));
        }

        $adminModel = new AdminModel();

        $data = array();

        $data['subadmindetails'] = $adminModel->getSubAdmindetail($id);
           
        if(!$data['subadmindetails'])
        {
            $this->session->setFlashdata('errmessage', 'SubAdmin does not exist!');
            return redirect()->to(site_url('adminlist'));
        } 
        // echo "<pre>";print_r($data);
        $this->template->render('admintemplate', 'contents' , 'admin/edit_subadmin', $data);
    }

    public function UpdateSubAdmin()
    {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
            
        $id = $this->request->getPost('subadminID');

        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'Sub Admin does not exist!');

            return redirect()->to(site_url('adminlist'));
        }
            
        //   echo "<pre>";print_r($this->request->getPost());die();
            
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $oldpassword = $this->request->getPost('oldpassword');
        $newpassword =$this->request->getPost('new_password');
        $email =$this->request->getPost('email');
        $mobile =$this->request->getPost('mobilenumber');
        
        $adminModel = new AdminModel();

        $arrResult = $adminModel->where('id!=',$id)
                                ->where(['email' => $email])
                                ->countAllResults();

        if($arrResult){

            $this->session->setFlashdata('errmessage', 'Email ID Already Exists! Please Try a different Email ID.');
                
            return redirect()->to(site_url('editsubadmin?id='.$id));

        } else {

            $arrSaveData = array(
                'fname'=> $firstname,
                'lname'=>$lastname,            
                'email'=>$email,
                'phone'=>$mobile,
            );

            if($newpassword){
                $arrSaveData['password'] = password_hash($newpassword, 1);
            }
                
            // print_r($arrSaveData);die;            

            $Update = $adminModel->where('id',$id)->set($arrSaveData)->update();

            if($Update) {
                
                $this->session->setFlashdata('message', 'Sub-Admin updated succesfully.');
                
                return redirect()->to(site_url('editsubadmin?id='.$id));

            } else {
                
                $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }
    }

    public function Checkuseremailexist()
    {
        $userModel = new UserModel();

        $email = $_POST['email'];
        // echo "<pre>";print_r($email); die();
        
        $searchArray = array('txtsearch'=>$email);

        // echo "<pre>";print_r($searchArray); die();

        $totalRecord = $userModel->getData($searchArray,'','',1); // return count value

        // echo "<pre>";print_r($totalRecord); die();
    
        echo json_encode($totalRecord);
                
    }

    public function Checkowneraccordingtosubadmin()
    {
        $userModel = new UserModel();

        $subadmin = $_POST['subadmin'];
        // echo "<pre>";print_r($subadmin); die();
        
        $searchArray = array('txtsearch'=>$subadmin);

        // echo "<pre>";print_r($searchArray); die();

        $data = $userModel->getData($searchArray,'','',''); // return count value

        //echo "<pre>";print_r($array); die();
    
        echo json_encode($data);
                
    }

    public function edituser()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
           return redirect()->to(site_url('admin'));
        }
        $id = $this->request->getGet("id");

        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'User ID number doesnot exist! Please try again.');

            return redirect()->to(site_url('userlist'));
        }

        $userModel = new UserModel();

        $data['userdetails'] = $userModel->getUserdetail($id); // return count value

        //echo "<pre>";print_r($array); die();

        if(!$data)
        {
            $this->session->setFlashdata('errmessage', 'User does not exist!');
            return redirect()->to(site_url('userlist'));
        }
        // echo "<pre>";print_r($array[0]); die();
        $this->template->render('admintemplate', 'contents' , 'admin/edituser', $data);
    }

    public function updateuser()
    {

        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        if(!$isAdminLoggedIn)
        {  
            return redirect()->to(site_url('admin'));
        }
            
        $id = $this->request->getPost('userID');

        if(!$id)
        {
            $this->session->setFlashdata('errmessage', 'User does not exist!');

            return redirect()->to(site_url('userlist'));
        }
            
        //   echo "<pre>";print_r($this->request->getPost());die();
            
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $oldpassword = $this->request->getPost('oldpassword');
        $newpassword =$this->request->getPost('new_password');
        $email =$this->request->getPost('email');
        $mobile =$this->request->getPost('mobilenumber');
        
        $userModel = new UserModel();

        $arrResult = $userModel->where('id!=',$id)
                                ->where(['email' => $email])
                                ->countAllResults();

        if($arrResult){

            $this->session->setFlashdata('errmessage', 'Email ID Already Exists! Please Try a different Email ID.');
                
            return redirect()->to(site_url('edituser?id='.$id));

        } else {

            $arrSaveData = array(
                'fname'=> $firstname,
                'lname'=>$lastname,            
                'email'=>$email,
                'phone'=>$mobile,
            );

            if($newpassword){
                $arrSaveData['password'] = password_hash($newpassword, 1);
            }
                
            // print_r($arrSaveData);die;            

            $Update = $userModel->where('id',$id)->set($arrSaveData)->update();

            if($Update) {
                
                $this->session->setFlashdata('message', 'User updated succesfully.');
                
                return redirect()->to(site_url('edituser?id='.$id));

            } else {
                
                $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
                
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }
    }

    public function deluser()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id =  $this->request->getGet("id");

        $userModel = new UserModel();

        if($isAdminLoggedIn)
        {
            $userModel->where('id',$id)->delete();
                
            $this->session->setFlashdata('message', 'Subadmin deleted succesfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('userlist'));
    }

    public function brandlist()
    {     
        if(!$this->isAdminLoggedIn)
        {  
               return redirect()->to(site_url('admin'));
        }

        $brandModel = new BrandModel();
        
        $userid = $this->session->get('user_id');
                
        $paginationnew = new \App\Libraries\Paginationnew();
                 
        $searchArray = '';
        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $brandModel->getData($searchArray,'','',1); // return count value

        $startLimit = ($page - 1) * $Limit;
        $data['startLimit'] = $startLimit;

        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['pagination'] = $pagination;
        $data["brandsData"] = $brandModel->getData($searchArray, $startLimit, $Limit);
        $data["searchArray"] = $searchArray;          
         
        $this->template->render('admintemplate', 'contents' , 'admin/brandslist', $data);
    }

    public function deletebrand()
    {
        $session = session();

        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id =  $this->request->getGet("id");

        $brandModel = new BrandModel();

        if($isAdminLoggedIn)
        {
            $brandModel->where('br_id',$id)->delete();
                
            $this->session->setFlashdata('message', 'Brand deleted succesfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('BrandsList'));
    }



}
