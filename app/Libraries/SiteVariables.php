<?php

namespace App\Libraries;

/* * ***************************************************************************\
  +-----------------------------------------------------------------------------+
  | Project        : fluid9                                           		  |
  | FileName       : sitevariables.php                                           |
  | Version        : 1.0                                                      |
  | Developer      : subedar Yadav                                            |
  | Created On     : 15-03-2021                                               |
  | Modified On    :                                                          |
  | Modified   By  :                                                          |
  | Authorised By  :  subedar Yadav                                           |
  | Comments       :  This class used for site message		  		          |
  | Email          : subedar2507@gmail.com                                    |
  +-----------------------------------------------------------------------------+
  \**************************************************************************** */

class SiteVariables {

    private $arrMessage = array();

    public function getVariable($key) {


        //message for registration 
        $this->arrMessage['gender'] = array('male' => 'Male', 'female' => 'Female', 'Others' => 'Others');
        $this->arrMessage['genderarb'] = array('male' => 'Male', 'female' => 'Female');
        $this->arrMessage['discounttype'] = array('1' => 'Buy 1 Get 1', '2' => 'All Items', '3' => 'Selected Items');
        $this->arrMessage['discounttypearb'] = array('1' => 'Buy 1 Get 1', '2' => 'All Items', '3' => 'Selected Items');
        $this->arrMessage['sortby'] = array('1' => 'Recent Arrived', '2' => 'Discount (Top to bottom)', '3' => 'Discount (from bottom to top)');
        $this->arrMessage['language'] = array('english' => 'English', 'arebic' => 'Arebic');

        $this->arrMessage['customertype'] = array('customer' => 'Customer List', 'vip' => 'Vip Customer List');
		
		$this->arrMessage['priority'] = array('Priority-1' => 'Priority-1', 'Priority-2' => 'Priority-2', 'Priority-3' => 'Priority-3', 'Priority-4' => 'Priority-4');

        if (array_key_exists($key, $this->arrMessage)) {
            return $this->arrMessage[$key];
        }
    }

}

?>