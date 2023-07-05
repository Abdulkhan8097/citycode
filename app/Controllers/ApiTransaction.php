<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TransactionModel;


class ApiTransaction extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new TransactionModel();
    }

    // create
    public function index() {

        $userdata = array();
  
        $userdata['company_id'] = $this->request->getPost('company_id');
        $userdata['branch_id'] = $this->request->getPost('branch_id');
		        
        $newuserdata = (array_filter($userdata));
		
        if ($userdata['company_id'] && $userdata['branch_id']) {
           
                $query = $this->model->save($userdata);

                if ($query) {
                    $userid = $this->model->getInsertID();
                    $userdata['id'] = $userid;
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Account created successfully'
                        ],
                        'userdetail' => $userdata,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Opps! some error occurs.' . print_r($data, 1));
                }
            
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }

    

}
