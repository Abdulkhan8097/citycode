<?php

namespace App\Controllers;

use App\Models\CountryModel;

use App\Models\StateModel;

use App\Models\CityModel;

use App\Models\CustomerModel;

class EditCustomer extends BaseController {

	
    protected $session;
    protected  $isAdminLoggedIn;
    
    
    public function __construct()
    {
        $this->session = session();

        $this->isAdminLoggedIn = $this->session->get('isAdminLoggedIn');

	}




 

}
?>
