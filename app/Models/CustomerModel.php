<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model {

    protected $table = 'customer';
    protected $tableorder = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'password', 'city_code', 'vip_code', 'vip_plus', 'gender', 'date_of_birth', 'nationality', 'stateid', 'cityid', 'language', 'email', 'mobile', 'status', 'profile', 'created_date', 'updated_date', 'start_date', 'end_date', 'category', 'commission','totalsaveamount','totalpoint', 'customer_type','interest','arb_name','android_token','delete_status','device','operating_system','phone_model','latitude','longitude','location','new_mob_no','onetime_point','current_version','app_status'];

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        
        // for user orders count
        $salespurchase = "";
   //     if (isset($searchArray['order_count']) && $searchArray['order_count']) {
            $salespurchase ="( SELECT COUNT(OD.od_userid) FROM ".$this->tableorder." AS OD WHERE OD.od_userid=ad.id  ";
            
            
            //if date selected then count will be
            if ((isset($searchArray['order_start_date'])) && (isset($searchArray['order_end_date'])) && $salespurchase && !$coutOnly) {
            $salespurchase .= " AND ( DATE_FORMAT(OD.created_date, '%Y-%m-%d') >= '".$searchArray['order_start_date']."' ";
             $salespurchase .= " AND DATE_FORMAT(OD.created_date, '%Y-%m-%d') <= '".$searchArray['order_end_date']."' ) "; 
             
           }
           $salespurchase .=" ) AS order_count ";
    //    }
        
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*, ST.state_name,ST.arb_state_name,if(CT.city_name!='',city_name,'') as city_name,if(CT.city_arb_name!='',city_arb_name,'') as city_arb_name,if(CN.country_enNationality!='',country_enNationality,'') as country_enNationality ,if(CN.country_arNationality!='',country_arNationality,'') As country_arNationality  ";
            
                //if user order count then 
                if($salespurchase)
                {
                 $sql .= ",".$salespurchase;
                }
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN states as ST ON (ad.stateid = ST.state_id) ";
        $sql .= " LEFT JOIN cities as CT ON (ad.cityid = CT.city_id) ";
        $sql .= " LEFT JOIN countries as CN ON (ad.nationality = CN.country_id) ";

        $sql .= ' WHERE 1 ';
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND ( ad.email LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.vip_code LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.city_code LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.name LIKE '" . $searchArray['txtsearch'] . "%' ";

            $sql .= " OR ad.start_date LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.end_date LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.gender LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.stateid LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.cityid LIKE '" . $searchArray['txtsearch'] . "%' ";

            $sql .= " OR ad.mobile LIKE '" . $searchArray['txtsearch'] . "%' ) ";

        }

        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

            if (isset($searchArray['current_version']) && $searchArray['current_version']) {
            $sql .= " AND ad.current_version = '" . $searchArray['current_version'] . "' ";
        }

         if (isset($searchArray['app_status']) && $searchArray['app_status']) {
            $sql .= " AND ad.app_status = '" . $searchArray['app_status'] . "' ";
        }

          

        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }
        if (isset($searchArray['customer_type'])) {
            $sql .= " AND ad.customer_type = '" . $searchArray['customer_type'] . "' ";
        }
       
        if (isset($searchArray['mobile'])) {
            $sql .= " AND ad.mobile = '" . $searchArray['mobile'] . "' ";
        }
        if (isset($searchArray['gender'])) {
            $sql .= " AND ad.gender = '" . $searchArray['gender'] . "' ";
        }
        if (isset($searchArray['city_code'])) {
            $sql .= " AND ad.city_code = '" . $searchArray['city_code'] . "' ";
        }
        if (isset($searchArray['vip_code'])) {
            $sql .= " AND ad.vip_code = '" . $searchArray['vip_code'] . "' ";
        }
        if (isset($searchArray['stateid'])) {
            $sql .= " AND ad.stateid = '" . $searchArray['stateid'] . "' ";
        }
        if (isset($searchArray['cityid'])) {
            $sql .= " AND ad.cityid = '" . $searchArray['cityid'] . "' ";
        }
        
        if (isset($searchArray['status']) && $searchArray['status']) {
            $sql .= " AND ad.status='".$searchArray['status']."' ";
        }
                                
        if (isset($searchArray['onlyvipcustomer']) && $searchArray['onlyvipcustomer']) {
            $sql .= " AND ad.vip_code <>'' ";
        }
        
        // check for order count of users
        if ((isset($searchArray['order_start_date'])) && (isset($searchArray['order_end_date']))) {
             $salespurchase ="( SELECT OD.od_userid FROM ".$this->tableorder." AS OD WHERE OD.od_userid=ad.id  ";
             $salespurchase .= " AND ( DATE_FORMAT(OD.created_date, '%Y-%m-%d') >= '".$searchArray['order_start_date']."' ";
             $salespurchase .= " AND DATE_FORMAT(OD.created_date, '%Y-%m-%d') <= '".$searchArray['order_end_date']."' ) "; 
             
             $salespurchase .=" ) ";
             
              $sql .= " AND ad.id IN ".$salespurchase;
           }
 // if order count then sort according to it
         if (isset($searchArray['orderby']) && $searchArray['orderby']) {

            $sql .= " ORDER BY  ".$searchArray['orderby']." DESC ";

        }
           
        // if order count then sort according to it
       else if (isset($searchArray['order_count']) && $searchArray['order_count']=='less' && $salespurchase!="" && $coutOnly=="") {
            $sql .= ' ORDER BY order_count ASC';
        }
        else if ( $salespurchase!="" & $coutOnly=='') {
            $sql .= ' ORDER BY order_count DESC';
        }
        else {
            $sql .= ' ORDER BY id DESC';
        }

  

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        if($showQuery)
        { 
            echo $sql;
        }
        //echo $sql;die;
        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }
    
    

    function checkUserLoginApi($mobile, $password) {

        $userdetails = array();
        $userid = null;
        $objResult = $this->asObject()
                ->where(['mobile' => $mobile])
                ->first();

        if ($objResult) {

            $dbPassword = $objResult->password;

            if (password_verify($password, $dbPassword)) {
                $userdetails = array(
                    'id' => $objResult->id,
                    'email' => $objResult->email,
                    'name' => $objResult->name,
                    'city_code' => $objResult->city_code,
                    'interest' => $objResult->interest,
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
    function checkUserLoginApiNew($mobile, $password,$user_id) {

        $userdetails = array();
        $userid = null;
        $objResult = $this->asObject()
                ->where(['id' => $user_id])
                ->first();

        if ($objResult) {


            $dbPassword = $objResult->password;

            if (password_verify($password, $dbPassword)) {

                 $query = $this->db->query("UPDATE customer  SET `mobile` ='".$mobile."', `new_mob_no` ='' WHERE `id` ='".$user_id."'");
                
                if ($query) {
                    $userdetails = array(
                        'id' => $objResult->id,
                        'email' => $objResult->email,
                        'name' => $objResult->name,
                        'city_code' => $objResult->city_code,
                        'interest' => $objResult->interest,
                        'isUserLoggedIn' => TRUE
                    );
                }
                $session = session();
                $session->set($userdetails);
                $txtreturn = true;
                $userid = $objResult->id;
            }
        }

        return $userdetails;
    }

    public function checkEmailExist($mobile) {
        $arrResult = $this->asArray()
                ->where(['mobile' => $mobile])
                ->countAllResults();
        return $arrResult;
    }

    public function checkCityCodeExist($city_code, $id) {
        $arrResult = $this->asArray()
                ->where('city_code', $city_code)
                ->where('id !=', $id)
                ->countAllResults();
        return $arrResult;
    }

    public function checkCityCode($city_code) {
        $arrResult = $this->asArray()
                ->where(['city_code' => $city_code])
                ->countAllResults();
        return $arrResult;
    }

    public function getCustomerID($id) {
        $sql = "SELECT customer.*, categories.* FROM customer";
        $sql .= " LEFT JOIN categories ON (customer.interest = categories.cat_id) ";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getVipCode($vip_code) {
        $sql = "SELECT name, profile FROM $this->table";
        $sql .= " WHERE vip_code ='" . $vip_code . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    /////////////////////////// customer list /////////////////////////////////

    public function getProfile($user_id) {
        $sql = "SELECT * FROM $this->table";
        $sql .= " WHERE id ='" . $user_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    //////////////////////// customer entire information //////////////////////

    public function customerInfo($user_id) {
        $sql = "SELECT customer.* FROM $this->table";
        $sql .= " WHERE id ='" . $user_id . "' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function checkMobileExist($mobile) {
        $arrResult = $this->asArray()
                ->where(['mobile' => $mobile])
                ->countAllResults();
        return $arrResult;
    }

    public function EditMobileExist($mobile, $id) {
        $arrResult = $this->asArray()
                ->where('mobile', $mobile)
                ->where('id !=', $id)
                ->countAllResults();

        //echo $this->getLastQuery(); die;

        return $arrResult;
    }

    public function getVipCustomer() {
        $sql = "SELECT customer.id,customer.name, customer.vip_code FROM $this->table";
        $sql .= " JOIN vip  ON (vip.vip_code = customer.vip_code) ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function generatecode($customername = '') {
        helper('text');
        $citycode = '';
        $codetrue = false;
        do {
            //if user anme then take his first letter of name
            if ($customername) {
                $firstLetter = substr($customername, 0, 1);
            } else {
                $firstLetter = random_string('alpha', 1);
            }

            $citycode = $firstLetter . random_string('nozero', 4);
            $citycode = strtoupper($citycode);

            $sql = "SELECT city_code   FROM $this->table  ";
            $sql .= " WHERE (city_code LIKE '" . $citycode . "' OR vip_code LIKE '" . $citycode . "')";
            $query = $this->db->query($sql);
            $result = $query->getResult();
            if ($result) {
                $codetrue = true;
            }
        } while ($codetrue);

        return $citycode;
    }
	

	 public function city_code($coupon_type) {
        $sql = "SELECT city_code,id,vip_code, totalpoint FROM $this->table";
        $sql .= " WHERE city_code ='" . $coupon_type . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
        return $result;
    }
	
	public function vip_code($coupon_type) {
        $sql = "SELECT vip_code,id, totalpoint FROM $this->table";
        $sql .= " WHERE vip_code ='" . $coupon_type . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }
  public function org_code($coupon_type) {
        $sql = "SELECT vip.vip_code,vip.org_status,org_details.vip as id,org_details.org_name as name, org_details.org_id ";
         $sql .=" FROM vip ";
        $sql.= "LEFT JOIN org_details ON (org_details.vip = vip.id) ";
          $sql .= " WHERE vip_code ='" . $coupon_type . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }
	
     /**
     *  Function for user add points
     * @param type $userid
     * @param type $point
     * @param type $type
     * @param type $orderid
     * @param type $redeemid
     */
    public function setCustomerpoint($userid,$point,$type="CR",$orderid=0,$redeemid=0,$comments="")
    {
        $point = $point ? $point :0;
        $arrCusDetail =  $this->asArray()
                    ->where(['id' => $userid])
                    ->first();
       
        if($arrCusDetail)
        {
            $currentPoint = $arrCusDetail['totalpoint'];
            
            if(strtoupper($type)=="CR")
            {
                $currentPoint = $currentPoint +$point;
            }
            else if(strtoupper($type)=="DR")
            {
                $currentPoint = $currentPoint - $point;
            }
            
            $customerDetail = array("totalpoint"=>$currentPoint);
            $this->set($customerDetail)->where(['id' => $userid])->update();
            $transactionData = array(
                                "customer_id"=>$userid,
                                "order_id"=>$orderid,
                                "redeem_id"=>$redeemid,
                                "points"=>$point,
                                "tr_totalpoint"=>$currentPoint,
                                "tr_type"=>$type,
                                "tr_comments"=>$comments,
                              );
                    
            //print_r($transactionData);die;
            $objTransaction = new \App\Models\TransactionModel();
            $objTransaction->save($transactionData);
        }
        
    }

    public function user($userid){
         $sql = "SELECT * from $this->table WHERE id='".$userid."' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        //echo "<pre>";print_r($result);exit;
        return $result;
    }

     public function do_upload($image,$userid){
        $sql = "update $this->table set profile='".$image."' WHERE id=".$userid;
        $query = $this->db->query($sql);
        //$result = $query->getRow();
        //echo "<pre>";print_r($result);exit;
        return $query;
    }

    //---------------Get Active Customer Count
    public function countActiveCustomer(){
        $sql = "SELECT count(id) as 'ActiveCustomer' from $this->table WHERE status=1";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        //$result = $query->getResult();

        //echo "<pre>";print_r($result);exit;
        return $result;
    }
    //----------------------------
 public function change($test, $red){
       
        return $this->db
                        ->table('company_details')
                        ->where(["id" => $test])
                        ->set($red)
                   ->update();
 
    }
 public function changepoints(){


        $sql = "UPDATE customer set  onetime_point= 0 where onetime_point = 1";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        //$result = $query->getResult();

        //echo "<pre>";print_r($result);exit;
        return $result;
    }

}

?>