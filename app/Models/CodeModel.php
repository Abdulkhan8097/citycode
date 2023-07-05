<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model {

    protected $table = 'company_code_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'branch_id', 'coupon_type', 'branch', 'company_discount', 'comission', 'customer_discount', 'discount_detail', 'description', 'arb_description', 'start_date', 'end_date', 'timing', 'online_link', 'playstore_link', 'ios_link', 'huawai_link', 'priority', 'priority_start', 'priority_end','h_whatsapp_no','h_mobile_no','h_instagram','h_location','h_arab_location','h_email','h_image','mall','mall_name','mall_name_arabic','custmise','offer_name_cust','offer_name_cust_arabic'];

     public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
       // echo "<pre>";print_r($searchArray);exit;
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT  ad.*,CONCAT(ad.customer_discount,'%') AS discountdisplay,C.company_name,C.company_arb_name,C.display_name,C.display_arb_name,C.picture as companylogo,C.coupon_status,C.view_count,C.category, DATE_FORMAT(ad.start_date,'%d-%m-%Y') as start_date,DATE_FORMAT(ad.end_date,'%d-%m-%Y') as end_date,if(SV.st_name!='',SV.st_name,'') as discount_en_detail,if(SV.st_arb_name!='',st_arb_name,'') as discount_arb_detail, ";
            
            //favorate if user id
            $fav_customerid =  isset($searchArray['fav_customerid']) ? $searchArray['fav_customerid'] : 0;
            $sql .= " IF((SELECT if((customer_id='".$fav_customerid."' AND company_id=ad.company_id),1,0) FROM `favourite` where customer_id='".$fav_customerid."' AND company_id=ad.company_id ),1,0 ) AS isfavorate, ";
            
            //$sql .= " FLOOR(HOUR(TIMEDIFF(ad.end_date, '".date('Y-m-d g:i:s')."')) / 24) AS remainingday, ";
            $sql .= " IF (DATEDIFF(ad.end_date, '".date('Y-m-d g:i:s')."'),DATEDIFF(ad.end_date, '".date('Y-m-d g:i:s')."'),0) AS remainingday, ";
            $sql .= " MOD(HOUR(TIMEDIFF(CONCAT(ad.end_date,' 24:00:00'), '".date('Y-m-d g:i:s')."')), 24) AS remaininghours, ";
             $sql .= " MINUTE(TIMEDIFF(ad.end_date, '".date('Y-m-d g:i:s')."')) AS remainingminutes ";
             $sql .= " FROM $this->table AS ad ";
        }
        
          $sql .= " LEFT JOIN company_details AS C ON (ad.company_id = C.id) ";
          $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id) ";
          $sql .= " LEFT JOIN sitevariable AS SV ON (ad.discount_detail = SV.st_id) ";
        //  $sql .= " LEFT JOIN favourite AS F ON (ad.id = F.offer_id) ";
          
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
           
        }
        
        //for favorite company of users
          
//        if (isset($searchArray['fav_customerid']) && $searchArray['fav_customerid']) {
//            $sql .= " OR F.customer_id = '" . $searchArray['fav_customerid'] . "' ";
//        }
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND ad.id LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }
        
        if (isset($searchArray['company_status'])) {
            $sql .= " AND C.status = '" . $searchArray['company_status'] . "' ";
           
        }

         if (isset($searchArray['coupon'])) {
            $sql .= " AND (C.coupon_status = '" . $searchArray['coupon'] . "' ";
             $sql .= " AND ad.coupon_type = '')";
           
        }
        
        //category
        if (isset($searchArray['category']) && $searchArray['category']) {
            
            if(is_array($searchArray['category']))
            {
                $in_array = implode("','",$searchArray['category']);
                
                 $sql .= " AND C.category IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND C.category = '" . $searchArray['category'] . "' ";
            }
           
        }
        
        //coupon type
        if (isset($searchArray['coupon_type']) && $searchArray['coupon_type']) {
            
            if(is_array($searchArray['coupon_type']))
            {
                $in_array = implode("','",$searchArray['coupon_type']);
                
                 $sql .= " AND ad.coupon_type IN ('" . $in_array . "') ";

            }elseif ($searchArray['coupon_type'] == 'new') {
                $sql .= " AND ad.coupon_type = 'city' ";
            }
            else
            {
             $sql .= " AND ad.coupon_type = '" . $searchArray['coupon_type'] . "' ";
             $sql .= " AND C.coupon_status = '0' ";
         
             
             

            }
           
        }
        
        //stateid type
        if (isset($searchArray['stateid']) && $searchArray['stateid']) {
            
            if(is_array($searchArray['stateid']))
            {
                $in_array = implode("','",$searchArray['stateid']);
                
                 $sql .= " AND B.state IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND B.state = '" . $searchArray['stateid'] . "' ";
            }
           
        }
        
        //city type
        if (isset($searchArray['cityid']) && $searchArray['cityid']) {
            
            if(is_array($searchArray['cityid']))
            {
                $in_array = implode("','",$searchArray['cityid']);
                
                 $sql .= " AND B.city IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND B.city = '" . $searchArray['cityid'] . "' ";
            }
           
        }
        
        //city type
        if (isset($searchArray['discounttype']) && $searchArray['discounttype']) {
            
            if(is_array($searchArray['discounttype']))
            {
                $in_array = implode("','",$searchArray['discounttype']);
                
                 $sql .= " AND ad.discount_detail IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.discount_detail IN ('" . $searchArray['discounttype'] . "') ";
            }
           
        }
        
        //get according to branch
        
        //city type
        if (isset($searchArray['branch_id']) && $searchArray['branch_id']) {

            
            if(is_array($searchArray['branch_id']))
            {
                $in_array = implode("','",$searchArray['branch_id']);
                
                 $sql .= " AND ad.branch_id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.branch_id = '" . $searchArray['branch_id'] . "' ";
            }
           
        }
        
        // if all  expire also the pass all as 1
        if (isset($searchArray['coupon_type']) &&  $searchArray['coupon_type']!= 'homebusiness') {
            if (!isset($searchArray['expiredoffer']) || (isset($searchArray['coupon_type']) && $searchArray['coupon_type']!= 'new')) {
               
//             $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') <= '".date('Y-m-d')."' ";
//             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') >= '".date('Y-m-d')."' ) ";
            }
       
          
            if (isset($searchArray['coupon_type']) &&  $searchArray['coupon_type']== 'new') {

                $date = date_create(date('Y-m-d'));
                date_sub($date,date_interval_create_from_date_string('7 days'));
                $newdate =  date_format($date,'Y-m-d');

             $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') > '".$newdate."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') >= '".date('Y-m-d')."' ) ";
            }
            
            /*if (!isset($searchArray['alloffer']) && (isset($searchArray['coupon_type']) && $searchArray['coupon_type']!='new' && $searchArray['coupon_type']!='city' )){
             $sql .= " GROUP BY ad.company_id ";
            }*/
        }
        
        //check coupon start date if search by date range
        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.start_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

        if (isset($searchArray['mallby']) && $searchArray['mallby']) {
            
            $sql .= "AND (mall_name LIKE '%".$searchArray['mallby']."%' OR mall_name_arabic LIKE '%".$searchArray['mallby']."%') ";
            
        }
        
        if (isset($searchArray['groupby']) && $searchArray['groupby']) {
             $sql .= " GROUP BY ad.customer_discount,ad.company_id  ";
        }
        
         
         if (isset($searchArray['sortby']) && $searchArray['sortby']) {
             
             if($searchArray['sortby'] ==1)
             {
                 $sql .= " ORDER BY id DESC";
             }
             else if($searchArray['sortby'] ==2)
             {
                 $sql .= " ORDER BY customer_discount DESC";
             }
             else if($searchArray['sortby'] ==3)
             {
                 $sql .= " ORDER BY customer_discount ASC";
             }
         }


         else
         {
             // $sql .= " GROUP BY id";
              $sql .= " ORDER BY priority ASC";
         }

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            
            return $result[0]['total_count'];
        }
        
        if($showQuery)
        {
            echo $sql;
        }
        

        return $result;
    }
   

    public function getCodeIDs($id) {

        $sql = "SELECT company_code_details.*, branch.branch_name, branch.arb_branch_name FROM company_code_details";
        $sql .= " LEFT JOIN branch ON (branch.branch_id = company_code_details.branch_id) ";
        $sql .= " WHERE  company_code_details.company_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getCodeID($id) {

        $sql = "SELECT company_code_details.* , branch.branch_name, branch.arb_branch_name, company_details.company_name, company_details.company_arb_name FROM company_code_details";
		$sql .= " LEFT JOIN company_details ON (company_details.id = company_code_details.company_id) ";
		$sql .= " LEFT JOIN branch ON (branch.branch_id = company_code_details.branch_id) ";
        $sql .= " WHERE company_code_details.id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getall($company_id) {

        $sql = "SELECT company_code_details.* FROM company_code_details";
        $sql .= " WHERE company_id ='" . $company_id . "' ";
        $sql .= " ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


////////////////////////////////// state city ////////////////////////////////

    public function getCityState($id) {
        $sql = "SELECT cities.*, company_code_details.id, company_code_details.village FROM company_code_details";
        $sql .= " LEFT JOIN cities ON (cities.city_id = company_code_details.village) ";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    /////////////////// for report //////////////////

    public function getDataAll($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(code.id) as total_count FROM $this->table AS code ";
        } else {
            $sql = "SELECT code.*, cd.company_name,cd.company_chat_status, cd.email, cd.mobile, branch.branch_name, SV.st_name, SV.st_arb_name FROM $this->table AS code ";
        }

        $sql .= " LEFT JOIN company_details as cd ON (cd.id = code.company_id) ";
        $sql .= " LEFT JOIN branch ON (branch.branch_id = code.branch_id) ";
		 $sql .= " LEFT JOIN sitevariable AS SV ON (code.discount_detail = SV.st_id) ";
        
        $sql .= " WHERE 1 ";

        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (code.id LIKE '" . $searchArray['txtsearch'] . "%' ";
            //$sql .= " OR code.coupon_type LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR code.start_date LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR code.end_date LIKE '" . $searchArray['txtsearch'] . "%' ";
			$sql .= " OR code.company_id LIKE '" . $searchArray['txtsearch'] . "%' ";
			$sql .= " OR code.branch_id LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR cd.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR branch.branch_name LIKE '" . $searchArray['txtsearch'] . "%' )";                       
        }  

        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(code.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
            $sql .= " AND DATE_FORMAT(code.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
        }
          
        if (isset($searchArray['company_name'])) {
            $sql .= " AND cd.company_name = '" . $searchArray['company_name'] . "' ";
        }

        if (isset($searchArray['branch_name'])) {
            $sql .= " AND branch.branch_name = '" . $searchArray['branch_name'] . "' ";
        }
		
		if (isset($searchArray['company_id'])) {
            $sql .= " AND code.company_id = '" . $searchArray['company_id'] . "' ";
        }
		
	if (isset($searchArray['branch_id'])) {
            $sql .= " AND code.branch_id = '" . $searchArray['branch_id'] . "' ";
        }
	
         if (isset($searchArray['coupon_type']) && $searchArray['coupon_type']) {
             // print_r($searchArray['coupon_type']);exit;
            if(is_array($searchArray['coupon_type']))
            {
                $in_array = implode("','",$searchArray['coupon_type']);
                
                 $sql .= " AND code.coupon_type IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND code.coupon_type = '" . $searchArray['coupon_type'] . "' ";
            }
           
        }
        if (isset($searchidArray['coupon_type']) && $searchidArray['coupon_type']) {
            $sql .= " AND code.coupon_type = '" . $searchidArray['coupon_type'] . "' ";
        }

        $sql .= " ORDER BY code.id DESC"; 

    
        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
        // echo $sql;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]['total_count'];
        }
        return $result;
    }

    public function getmalldata(){
        
        $sql = "SELECT DISTINCT * FROM $this->table WHERE mall='Yes' GROUP By mall_name ORDER BY mall_name ASC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        $result1=array();
        if ($result) {
            foreach ($result as $key => $value) {
                if($value['mall_name']!=''){
                    $sql1 = "SELECT * FROM mall_details WHERE id= '".$value['mall_name']."' ORDER BY id ASC";
                    $query = $this->db->query($sql1);
                    $resultmall = $query->getRow();
                    if(!empty($resultmall)){
                        $result1[]=array(
                            'id' => $resultmall->id,
                            'mall_name' => $resultmall->mall_name,
                            'mall_name_arabic' =>$resultmall->arabic_mall_name
                        );
                    }
                }
            }// exit;
        }
        return $result1;
    }
    
    public function getmalllist(){
        
        $sql = "SELECT * FROM mall_details ORDER BY mall_name ASC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
       
        return $result;
    }

     public function getCustomerDiscount($id,$coupon_type) {

        $sql = "SELECT DISTINCT(customer_discount),comission FROM company_code_details where company_id='".$id."' and coupon_type='".$coupon_type."'";
        
        //$sql1="SELECT customer_discount FROM company_code_details WHERE company_id=122 and coupon_type='city';

        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        //$result=$sql;
        return $result;
    }
}

?>
