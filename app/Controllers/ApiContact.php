<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ContactUs;

class ApiContact extends ResourceController {

    use ResponseTrait;

    protected $model;

    public function __construct() {
        $this->model = new ContactUs();
    }

    //get all category
    public function index() {

        $contactdetail =  $this->model->getContactID();              
        if ($contactdetail) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'ContactUs' => $contactdetail,                    
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failNotFound('No Info available.');
            }
    }


}
