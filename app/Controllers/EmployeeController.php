<?php
namespace App\Controllers;
use App\Models\EmployeeModel;
use App\Libraries\Paginationnew;
use App\Models\SitevariableModel;


class EmployeeController extends BaseController {
	
    protected $session;
    protected  $isAdminLoggedIn;
        
    public function __construct()
    {
        $this->session = session();
        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');
	$this->model = new EmployeeModel();
      }


  function index() { 
        $session = session();
	$data = array();
		
        $data['action'] = "Employee";
        $paginationnew = new Paginationnew();
        $searchArray = array();
        $txtsearch = $this->request->getGet('txtsearch');
        if($txtsearch)
        {
            $searchArray['txtsearch'] = $txtsearch;
        }

        $page = $this->request->getGet('page');
        $page = $page ? $page : 1;
        $Limit = PER_PAGE_RECORD;
        $totalRecord = $this->model->getData($searchArray, '', '', '1');
        $startLimit = ($page - 1) * $Limit;
		$data['reverse'] = $totalRecord-($page -1) * $Limit;
        $data['startLimit'] = $startLimit;
        $pagination = $paginationnew->getPaginate($totalRecord, $page, $Limit);
        $data['txtsearch'] = $txtsearch;
        $data['startLimit'] = $startLimit;
        $data['pagination'] = $pagination;
        $data["searchArray"] = $searchArray;
       
        $data['results'] = $this->model->getData($searchArray, $startLimit, $Limit);
        $this->template->render('admintemplate', 'contents', 'admin/employeelist', $data);    	
 }
 
   function add_new_form() { 		
        $this->template->render('admintemplate', 'contents', 'admin/employee_form');    	
 }
 
  function add_employee() {
      
        $data = array();
		        
        $data = [
            'name' => $this->request->getVar('name'),
            'mobileno' => $this->request->getVar('mobileno'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), 1),
            'status' => $this->request->getVar('status'),
        ];
			  		  
        $id = $this->model->insert($data);				
							
        if ($this->model->errors) {
            return $this->fail($this->model->errors());
        } else {
            $this->session->setFlashdata('message', 'New Employee Added Successfully!');
            return redirect()->to(site_url('Employees'));
        }    }
	
	///////////////////////////// notification details //////////////////////
	
public function employee_details(){
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');
        if (!$isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");
		
        $data['row'] = $this->model->getEmployeeId($id); 
        if(!$data['row'])
        {
            $this->session->setFlashdata('errmessage', 'This Id Does not exist!');
            return redirect()->to(site_url('Employees'));
        }

        $this->template->render('admintemplate', 'contents' , 'admin/employee_detail', $data);
    }

    //////////////////////////// notification delete //////////////////////

    public function delete_employee() {
        $session = session();
        $isAdminLoggedIn = $session->get('isAdminLoggedIn');

        $id = $this->request->getGet("id");

       $deleteEmployee = $this->model->where('id', $id)->delete();

       if($deleteEmployee){
            $this->session->setFlashdata('message', 'Employee deleted successfully.');
        } else {
            $this->session->setFlashdata('errmessage', 'Invalid access.');
        }
        return redirect()->to(site_url('Employees'));
    }
	

///////////////////////////// edit employee /////////////////////

    public function edit_employee() {
        $session = session();
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }

        $id = $this->request->getGet("id");		
        $data['row'] = $this->model->getEmployeeId($id);
        if (!$data['row']) {
            $this->session->setFlashdata('errmessage', 'Employee Id Does not exist!');
            return redirect()->to(site_url('Employees'));
        }
        $this->template->render('admintemplate', 'contents', 'admin/edit_employee', $data);
    }

    public function update() {
        $session = session();
		
        if (!$this->isAdminLoggedIn) {
            return redirect()->to(site_url('admin'));
        }
		
	$employee_id = $this->request->getPost('employee_id');
        if (!$employee_id) {
            $this->session->setFlashdata('errmessage', 'Employee Id does not exist!');
            return redirect()->to(site_url('adminlist'));
        }
       
        $name = $this->request->getPost('name');
        $mobileno = $this->request->getPost('mobileno');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $status = $this->request->getPost('status');
		$updated_date = $this->request->getPost('updated_date');

        $arrSaveData = array(
            'name' => $name,
            'mobileno' => $mobileno,
            'email' => $email,
            'password' => password_hash($password, 1),
            'status' => $status,
            'updated_date' => date('Y-m-d H:i:s'),
        );
        $newuserdata = (array_filter($arrSaveData));
        $Update = $this->model->where('id', $employee_id)->set($newuserdata)->update();

        if ($employee_id) {
            $this->session->setFlashdata('message', 'Employee updated successfully.');
            return redirect()->to(site_url('EditEmployee?id=' . $employee_id));
        } else {
            $this->session->setFlashdata('errmessage', 'Something Went Wrong! Try Again.');
            return redirect()->to(site_url('EditEmployee?id=' . $emplyee_id));
        }
    }



}

?>

