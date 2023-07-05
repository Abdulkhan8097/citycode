<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ContactUsModel;

class ApiContactus extends ResourceController {

    use ResponseTrait;

    protected $model;

    public function __construct() {
        $this->model = new ContactUsModel();
    }

    //get all category
    public function index() {
        $searchArray = array();

        return $this->failNotFound('No company available.');
    }

    // create
    public function create() {

        $userdata = array();

        $userdata['user_id'] = $this->request->getPost('userid');
        $userdata['email'] = $this->request->getPost('email');
        $userdata['mobile'] = $this->request->getPost('mobile');
        $userdata['enquiry'] = $this->request->getPost('details');

        $newuserdata = (array_filter($userdata));

        if (count($newuserdata) > 3) {
            $query = $this->model->save($userdata);

            if ($query) {
                $userid = $this->model->getInsertID();
                $userdata['id'] = $userid;
                $response = [
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Enquiry sent successfully'
                    ],
                    'enquirydetail' => $userdata,
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('Opps! some error occurs.' . print_r($data, 1));
            }
        } else {
            return $this->failNotFound('Please provide all data');
        }
    }

    // single offer
    public function show($id = null) {
        
    }

}
