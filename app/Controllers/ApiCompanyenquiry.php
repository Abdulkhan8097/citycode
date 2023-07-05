<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CompanyEnquiryModel;

class ApiCompanyenquiry extends ResourceController {

    use ResponseTrait;

    protected $model;

    public function __construct() {
        $this->model = new CompanyEnquiryModel();
    }

    //get all category
    public function index() {
        $searchArray = array();

        return $this->failNotFound('No company available.');
    }

    // create
    public function create() {

        $userdata = array();

        $userdata['ce_userid'] = $this->request->getPost('userid');
        $userdata['ce_companyid'] = $this->request->getPost('companyid');
        $userdata['ce_details'] = $this->request->getPost('details');

        $newuserdata = (array_filter($userdata));

        if (count($newuserdata) > 2) {
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
