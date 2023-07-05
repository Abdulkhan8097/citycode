<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\FavouriteModel;

class ApiFavorate extends ResourceController {

    use ResponseTrait;
    protected $model;

    public function __construct() {
        $this->model = new FavouriteModel();
    }

    //get all category
    public function index() {
        $array = array();

        return $this->failNotFound('Invalid access found');
    }

   

    // create
    public function create() {

        $userdata = array();
  
        $userdata['customer_id'] = $this->request->getPost('customer_id');
        $userdata['company_id'] = $this->request->getPost('company_id');
        $newuserdata = (array_filter($userdata));
        if (count($newuserdata)==2) {
            
            $isuserexist = $this->model
                     ->where(['customer_id' => $userdata['customer_id']])
                     ->where(['company_id' => $userdata['company_id']])
                     ->first();

            if (empty($isuserexist)) {
                $query = $this->model->save($userdata);

                if ($query) {
                    $userid = $this->model->getInsertID();
                    $userdata['id'] = $userid;
                    $response = [
                        'status' => 201,
                        'error' => null,
                        'messages' => [
                            'success' => 'Added successfully'
                        ],
                        'details' => $userdata,
                    ];
                    return $this->respondCreated($response);
                } else {
                    return $this->failNotFound('Opps! some error occurs.');
                }
            } else {
                return $this->failNotFound(' alreay exist.');
            }
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }

    // single user
    public function show($id = null) {

        $data = $this->model->where('id', $id)->first();
        if ($data) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'User detail'
                ]
            ];
            $response['userdetail'] = $data;

            return $this->respond($response);
        } else {
            return $this->failNotFound('No Data found');
        }
    }

}
