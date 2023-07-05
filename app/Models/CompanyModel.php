<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model {

    protected $table = 'company_details';
     protected $tableorder = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_name', 'auth_contact', 'password', 'display_name', 'mobile', 'email', 'picture', 'views', 'website', 'instagram', 'twitter', 'timing',
        'facebook', 'snapchat', 'status', 'created_date', 'updated_date', 'category', 'cr_number', 'address', 'username', 'c_location', 'view_count', 'vip_link','online_description',
         'online_startdate', 'online_enddate', 'online_link', 'online_playstore_link', 'online_ios_link', 'online_huawei_link', 'online_shop', 'company_arb_name', 'arb_username', 'display_arb_name', 'arb_address', 'arb_location', 'online_arb_description', 'whatsapp','mobile_otp','cookiesotp','redeem','company_chat_status','coupon_status'];


    /*public function getCompanyID($id) {
        $arrResult = $this->asArray()
                ->where(['id' => $id])
                ->first();
        return $arrResult;
    }*/

public function getCompanyDetail($id) {
        $arrResult = $this->asArray()
                ->where(['id' => $id])
                ->first();
        return $arrResult;
    }




    //DATE_FORMAT(online_startdate,'%d-%m-%Y')

    public function getCompanyID($id) {
        $sql = "SELECT company_details.*, DATE_FORMAT(company_details.online_startdate,'%d-%m-%Y'), DATE_FORMAT(company_details.online_enddate,'%d-%m-%Y'), categories.* FROM company_details";
        $sql .= " LEFT JOIN categories ON (categories.cat_id = company_details.category) ";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getDataAll($searchArray = array(), $offset = '', $limit = '', $coutOnly = '', $serach_priority = '',$showQuery='') {
       
        // for user orders count
        $salespurchase = "";
   //     if (isset($searchArray['order_count']) && $searchArray['order_count']) {
            $salespurchase ="( SELECT COUNT(OD.od_companyid) FROM ".$this->tableorder." AS OD WHERE OD.od_companyid=ad.id  ";
            
            
            //if date selected then count will be
            if ((isset($searchArray['order_start_date'])) && (isset($searchArray['order_end_date'])) && $salespurchase && !$coutOnly) {
            $salespurchase .= " AND ( DATE_FORMAT(OD.created_date, '%Y-%m-%d') >= '".$searchArray['order_start_date']."' ";
             $salespurchase .= " AND DATE_FORMAT(OD.created_date, '%Y-%m-%d') <= '".$searchArray['order_end_date']."' ) "; 
             
           }
           $salespurchase .=" ) AS order_count ";
    //    }
           
           
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        }
         else {
                $sql = "SELECT ad.*, DATE_FORMAT(ad.online_startdate,'%d-%m-%Y') as online_startdate,DATE_FORMAT(ad.online_enddate,'%d-%m-%Y') as online_enddate  ";
                
                //if user order count then 
                if($salespurchase)
                {
                 $sql .= ",".$salespurchase;
                }
                $sql .= " FROM $this->table AS ad ";
               if($serach_priority!='' && $serach_priority!='all'){
                    $sql .= " LEFT JOIN company_code_details as city ON (ad.id = city.company_id) ";
                   
                }
            }
        $sql .= " ";
        $sql .= " WHERE 1 ";

        if($serach_priority!='' && $serach_priority!='all'){
            $sql .= " AND (city.priority LIKE '" . $serach_priority . "%' )";
        }

        if (isset($searchArray['id']) && $searchArray['id']) {
            
            if(is_array($searchArray['id']))
            {
                $in_array = implode("','",$searchArray['id']);

                 $sql .= " AND ad.id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
            }

        }

        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.mobile LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.email LIKE '" . $searchArray['txtsearch'] . "%' )";                       
        }

        if (isset($searchArray['company_name'])) {
            $sql .= " AND ad.company_name = '" . $searchArray['company_name'] . "' ";
        }
        
        
        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }
        
        if (isset($searchArray['status'])) {
            $sql .= " AND ad.status = '" . $searchArray['status'] . "' ";
        }

        if (isset($searchArray['online_shop'])) {
            $sql .= " AND ad.online_shop = '" . $searchArray['online_shop'] . "' ";
        }
        
        // check for order count of users
        if ((isset($searchArray['order_start_date'])) && (isset($searchArray['order_end_date']))) {
             $salespurchase ="( SELECT OD.od_companyid FROM ".$this->tableorder." AS OD WHERE OD.od_companyid=ad.id  ";
             $salespurchase .= " AND ( DATE_FORMAT(OD.created_date, '%Y-%m-%d') >= '".$searchArray['order_start_date']."' ";
             $salespurchase .= " AND DATE_FORMAT(OD.created_date, '%Y-%m-%d') <= '".$searchArray['order_end_date']."' ) "; 
             
             $salespurchase .=" ) ";
             
              $sql .= " AND ad.id IN ".$salespurchase;
           }
           
        // if order count then sort according to it
        if (isset($searchArray['order_count']) && $searchArray['order_count']=='less' && $salespurchase!="" && $coutOnly=="") {
            $sql .= ' ORDER BY order_count ASC';
        }
        else if ( $salespurchase!="" & $coutOnly=='') {
            $sql .= ' ORDER BY order_count DESC';
        }
        else {
           $sql .= "  ORDER BY ad.id DESC";
        }

        

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
        
        if($showQuery)
        { 
            echo $sql;
        }
        //echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];

        }
        //echo "<pre>"; print_r($result);exit; 


        return $result;
    }
    
    
    public function getonlineShop($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
           $sql = "SELECT ad.*,DATE_FORMAT(ad.online_startdate,'%d-%m-%Y') as online_startdate,DATE_FORMAT(ad.online_enddate,'%d-%m-%Y') as online_enddate, ";
            
            $sql .= " FLOOR(HOUR(TIMEDIFF(ad.online_enddate, '".date('Y-m-d g:i:s')."')) / 24) AS remainingday, ";
            $sql .= " MOD(HOUR(TIMEDIFF(CONCAT(ad.online_enddate,' 24:00:00'), '".date('Y-m-d g:i:s')."')), 24) AS remaininghours, ";
             $sql .= " MINUTE(TIMEDIFF(ad.online_enddate, '".date('Y-m-d g:i:s')."')) AS remainingminutes ";
             $sql .= " FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";

        if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }

        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.email LIKE '" . $searchArray['txtsearch'] . "%' )";
        }
        
        if (isset($searchArray['online_shop'])) {
            $sql .= " AND ad.online_shop = '" . $searchArray['online_shop'] . "' ";
            
        }
        
         //category
        if (isset($searchArray['category']) && $searchArray['category']) {
            
            if(is_array($searchArray['category']))
            {
                $in_array = implode("','",$searchArray['category']);
                
                 $sql .= " AND ad.category IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.category = '" . $searchArray['category'] . "' ";
            }
           
        }
        
        if (!isset($searchArray['expiredoffer'])) {
         $sql .= " AND ( DATE_FORMAT(ad.online_startdate, '%Y-%m-%d') <= '".date('Y-m-d')."' ";
         $sql .= " AND DATE_FORMAT(ad.online_enddate, '%Y-%m-%d') >= '".date('Y-m-d')."' ) ";
        }
        
        $sql .= " ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
      //  echo $sql;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }

        return $result;
    }

///////////////////////////////////// Login with company_details //////////////////

    function checkCompanyLogin($username, $password) {
        //echo "in database";exit;
        $txtreturn = false;

        $objResult = $this->asObject()
                ->where(['email' => $username])
                ->first();

        if ($objResult) {

            $dbPassword = $objResult->password;
            if(password_verify($password,$dbPassword)) {
                $adminSession = array(
                    'company_id' => $objResult->id,
                    'email' => $objResult->email,
                    'company_name' => $objResult->company_name,
                    'isAdminLoggedIn' => TRUE,
                    'LoggedIn' => TRUE,
                );

                $session = session();
                $session->set($adminSession);
                $txtreturn = true;
                return $objResult;
            }
        }
        return '';

    }

/////////////////// search company information with city code ///////////////////

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.*, city.id,city.company_id,city.c_location, city.company_discount, city.comission, city.c_disc_detail, city.c_start, city.c_end FROM $this->table AS OT ";
            $sql .= " LEFT JOIN company_code_details as city ON (OT.id = city.company_id) ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND city.c_location LIKE '" . $searchArray['txtsearch'] . "%' ";
            //$sql .= " AND city.company_discount LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.comission LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_disc_detail LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_start LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_end LIKE '".$searchArray['txtsearch']."%' ";
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }

/////////////////// search company information with city code with state ///////////////////

    public function getDataWithState($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.*, states.*, city.id,city.c_state,city.company_id,city.c_location, city.company_discount, city.comission, city.c_disc_detail, city.c_start, city.c_end FROM $this->table AS OT ";
            $sql .= " LEFT JOIN company_code_details as city ON (OT.id = city.company_id) ";

            $sql .= " LEFT JOIN states ON (city.c_state = states.state_id) ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND states.state_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            //$sql .= " AND city.company_discount LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.comission LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_disc_detail LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_start LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_end LIKE '".$searchArray['txtsearch']."%' ";
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }

////////////////////////////ASHISH - search company information with discount low to high /////////////////////
    public function getDataWithLowDiscount($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.*, states.*, city.id,city.c_state,city.company_id,city.c_location, city.company_discount, city.comission, city.c_disc_detail, city.c_start, city.c_end FROM $this->table AS OT ";
            $sql .= " LEFT JOIN company_code_details as city ON (OT.id = city.company_id) ";

            $sql .= " LEFT JOIN states ON (city.c_state = states.state_id) ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND states.state_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            //$sql .= " AND city.company_discount LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.comission LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_disc_detail LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_start LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_end LIKE '".$searchArray['txtsearch']."%' ";
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.company_discount ASC";
        // $sql .= " ORDER BY OT.company_discount DESC";


        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }

////////////////////////////ASHISH - search company information with discount high to low /////////////////////
    public function getDataWithHighDiscount($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT($this->primaryKey) as total_count FROM $this->table AS OT ";
        } else {
            $sql = "SELECT OT.*, states.*, city.id,city.c_state,city.company_id,city.c_location, city.company_discount, city.comission, city.c_disc_detail, city.c_start, city.c_end FROM $this->table AS OT ";
            $sql .= " LEFT JOIN company_code_details as city ON (OT.id = city.company_id) ";

            $sql .= " LEFT JOIN states ON (city.c_state = states.state_id) ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND states.state_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            //$sql .= " AND city.company_discount LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.comission LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_disc_detail LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_start LIKE '".$searchArray['txtsearch']."%' ";
            //$sql .= " AND city.c_end LIKE '".$searchArray['txtsearch']."%' ";
        }

        //  echo   $sql .= " ORDER BY ".$this->primaryKey." DESC"; die();

        $sql .= " ORDER BY OT.company_discount DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }

//////////////////////////// company information with city code only with state name/////////////////////

    public function getCompanyInfoBystate($state_name) {

        $sql = "SELECT company_details.*, states.*, code.id,code.c_state,code.company_id,code.c_location, code.company_discount, code.comission, code.c_disc_detail, code.c_start, code.c_end FROM $this->table";

        $sql .= " LEFT JOIN company_code_details as code ON (company_details.id = code.company_id) ";
        $sql .= " LEFT JOIN states ON (code.c_state = states.state_id) ";
        $sql .= " WHERE state_name ='" . $state_name . "' ";
        $sql .= " ORDER BY company_details.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

////////////////// company information with city code with favourite //////////////////////////


    public function customerFavorite($user_id) {
        $sql = "SELECT company_details.*, favourite.*, code.id,code.c_state,code.company_id,code.c_location, code.company_discount, code.comission, code.c_disc_detail, code.c_start, code.c_end FROM $this->table";
        $sql .= " LEFT JOIN company_code_details as code ON (company_details.id = code.company_id) ";
        $sql .= " LEFT JOIN favourite ON (company_details.id = favourite.company_id) ";
        $sql .= " WHERE favourite.customer_id ='" . $user_id . "' ";
        $sql .= " ORDER BY favourite.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

//////////////////// home api //////////////////

    public function HomeApi() {

        $sql = "SELECT company.*, code.* FROM company_details as company";
        $sql .= " LEFT JOIN company_code_details AS code ON (company.id = code.company_id) ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

////////////// city code ////////////////////////


    public function CityCodeApi() {

        $sql = "SELECT company.*, code.company_id, code.c_location, code.company_discount, code.comission, code.customer_discount, code.c_disc_detail, code.c_start, code.c_end, code.c_state, code.c_village, code.id AS id FROM company_details as company";
        $sql .= " LEFT JOIN company_code_details AS code ON (company.id = code.company_id) ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

//////////////////// famous code api /////////////////////////

    public function FamousCodeApi() {

        $sql = "SELECT company.*, code.company_id, code.fam_location, code.fam_company_discount, code.fam_comission, code.fam_customer_discount, code.fam_disc_detail, code.fam_start, code.fam_end, code.fam_state, code.fam_village, code.id AS id FROM company_details as company";
        $sql .= " LEFT JOIN company_code_details AS code ON (company.id = code.company_id) ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();

        return $result;
    }

/////////////////////// friday code api /////////////////////////////

    public function FridayCodeApi() {

        $sql = "SELECT company.*, code.company_id, code.fam_location, code.fam_company_discount, code.fam_comission, code.fam_customer_discount, code.fam_disc_detail, code.fam_start, code.fam_end, code.fam_state, code.fam_village, code.id AS id FROM company_details as company ";
        $sql .= " LEFT JOIN company_code_details AS code ON (company.id = code.company_id) ";
        //  $sql .= " WHERE company_name ='".$company_name."' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();

        return $result;
    }

////////////////// interest category ///////////////////////////////

    public function interestApi($category) {
        $sql = "SELECT company_details.* FROM $this->table";
        $sql .= " WHERE category ='" . $category . "' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function public_citycodeapi_1() {
        $sql = "SELECT company.* FROM $this->table AS company ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function public_citycodeapi_2($company_id) {
        $coupon_type = 'city';
        $sql = "SELECT code.*, branch.branch_name FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " LEFT JOIN branch  ON (branch.branch_id = code.branch_id) ";
        $sql .= " WHERE code.company_id ='" . $company_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function public_vipcodeapi_2($company_id) {
        $coupon_type = 'vip';
        $sql = "SELECT code.*, branch.branch_name FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " LEFT JOIN branch  ON (branch.branch_id = code.branch_id) ";
        $sql .= " WHERE code.company_id ='" . $company_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function public_fridaycodeapi_2($company_id) {
        $coupon_type = 'friday';
        $sql = "SELECT code.*, branch.branch_name FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " LEFT JOIN branch  ON (branch.branch_id = code.branch_id) ";
        $sql .= " WHERE code.company_id ='" . $company_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    /* public function OnlineShopApi($id) {   
      $sql = "SELECT company.shop_branch, company.shop_state, company.shop_start, company.shop_end, company.shop_username, company.shop_password, company.shop_company_discount, company.shop_company_details, company.shop_disc_detail, company.shop_description, company.online_link,company.playstore_link, company.ios_link, company.huawai_link FROM company_details as company";
      $sql .= " WHERE id ='".$id."' ";
      $sql .= " AND shop_description !='' ";
      $query = $this->db->query($sql);
      $result = $query->getResult();
      return $result;
      } */

    public function OnlineShopApi($company_id) {
        $coupon_type = 'online';
        $sql = "SELECT code.start_date, code.end_date, code.description, code.online_link, code.playstore_link, code.ios_link, code.huawai_link FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function public_banner($company_id) {
        $type = "banner";
        $sql = "SELECT company_doc_banner.* FROM company_doc_banner ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = company_doc_banner.company_id) ";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " AND type ='" . $type . "' ";
        $query = $this->db->query($sql);
        $result['dd'] = $query->getResult();
        return $result;
    }

///////////////////////////////////////////// new query /////////////////////////////

    public function VipCustomer() {

        $sql = "SELECT company.*, code.company_id, code.fri_branch FROM company_code_details as code ";
        $sql .= " LEFT JOIN company_details AS company ON (company.id = code.company_id) ";
        $sql .= " WHERE fri_branch !='' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

////////////////// wishlist ///////////////

    public function company_wishlist($customer_id, $coupon_type) {
        $sql = "SELECT company.* , favourite.customer_id FROM $this->table AS company ";
        $sql .= " LEFT JOIN company_code_details ON (company_code_details.company_id = company.id) ";
        $sql .= " LEFT JOIN favourite ON (favourite.company_id = company.id) ";
        $sql .= " WHERE customer_id ='" . $customer_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function city_code_wishlist($customer_id) {
        $coupon_type = 'city';
        $sql = "SELECT code.c_branch, code.c_username, code.company_discount, code.comission, code.customer_discount, code.c_disc_detail, code.c_description, code.c_start, code.c_end, code.c_state, code.c_village FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " LEFT JOIN favourite ON (favourite.company_id = code.company_id) ";
        $sql .= " WHERE customer_id ='" . $customer_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function vip_code_wishlist($customer_id) {
        $coupon_type = 'vip';
        $sql = "SELECT code.fam_branch, code.fam_username, code.fam_password, code.fam_location, code.fam_company_discount, code.fam_comission, code.fam_customer_discount, code.fam_disc_detail, code.fam_description, code.fam_start, code.fam_end, code.fam_state, code.fam_village FROM company_code_details as code ";
        $sql .= " LEFT JOIN $this->table AS company ON (company.id = code.company_id) ";
        $sql .= " LEFT JOIN favourite ON (favourite.company_id = code.company_id) ";
        $sql .= " WHERE customer_id ='" . $customer_id . "' ";
        $sql .= " AND coupon_type ='" . $coupon_type . "' ";
        $sql .= " ORDER BY company.id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


    public function checkEmailExist($email) {
        $arrResult = $this->asArray()
                ->where(['email' => $email])
                ->countAllResults();
        return $arrResult;
    }

    public function EditEmailExist($email, $id) {
        $arrResult = $this->asArray()
                ->where('email', $email)
                ->where('id !=', $id)
                ->countAllResults();
        return $arrResult;
    }

    public function getComanyName($id) {
        $sql = "SELECT * FROM $this->table WHERE id='".$id."' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
       // echo "<pre>";print_r($result);exit;
        return $result;
    }



///////////////////////////// for offer report company list //////////////

    public function getCompanyOffer($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(DISTINCT ad.id) as total_count FROM $this->table AS ad ";
        } else {
           // $sql = "SELECT ad.*, DATE_FORMAT(ad.online_startdate,'%d-%m-%Y') as online_startdate,DATE_FORMAT(ad.online_enddate,'%d-%m-%Y') as online_enddate FROM $this->table AS ad ";
            $sql = "SELECT DISTINCT ad.*, DATE_FORMAT(ad.online_startdate,'%d-%m-%Y') as online_startdate,DATE_FORMAT(ad.online_enddate,'%d-%m-%Y') as online_enddate FROM $this->table AS ad ";
        }
       $sql .= " LEFT JOIN company_code_details as code ON (code.company_id = ad.id) "; 
        $sql .= " LEFT JOIN branch ON (branch.branch_id = code.branch_id) ";
        
        $sql .= " WHERE 1 ";

        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (code.id LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR code.start_date LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR code.end_date LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR code.coupon_type LIKE '" . $searchArray['txtsearch'] . "%' )";                       
        }  
        
        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(code.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
            $sql .= " AND DATE_FORMAT(code.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
        }

        if (isset($searchArray['company_name'])) {
            $sql .= " AND ad.company_name = '" . $searchArray['company_name'] . "' ";
        }

        if (isset($searchArray['coupon_type'])) {
            $sql .= " AND code.coupon_type = '" . $searchArray['coupon_type'] . "' ";
        }

        $sql .= " ORDER BY ad.id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }

        return $result;
    }



    function checkUserLoginApi($mobile, $password) {

        $userdetails = array();
        $userid = null;
        $objResult = $this->asObject()
                ->where(['auth_contact' => $mobile])
                ->first();

        if ($objResult) {

            $dbPassword = $objResult->mobile_otp;
            if (password_verify($password, $dbPassword)) {
                $userdetails = array(
                    'id' => $objResult->id,
                    'email' => $objResult->email,
                    'name' => $objResult->company_name,
                    'city_code' =>'',
                    'interest' => '',
                    'isUserLoggedIn' => TRUE
                );

                $session = session();
                $session->set($userdetails);

                $txtreturn = true;

                $userid = $objResult->id;
            }
        }

        return $userdetails;
    }   



    //---------------Get Active Customer Count
    public function countActiveCompany(){
        $sql = "SELECT count(id) as 'ActiveCompany' from $this->table WHERE status=1";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        //$result = $query->getResult();

        //echo "<pre>";print_r($result);exit;
        return $result;
    }
    //----------------------------
 public function update1($company_id, $data) {
        return $this->db
                        ->table('company_details')
                        ->where(["id" => $company_id])
                        ->set($data)
                        ->update();
    }

}

?>
