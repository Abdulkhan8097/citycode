<?php namespace App\Models;

use CodeIgniter\Model;

class couponPurchaseModel extends Model{
    
     protected $table = 'coupon_purchase';
     protected $primaryKey = 'id';
     protected $allowedFields = ['id', 'user_id', 'coupon_id', 'created', 'purchase_status', 'company_id', 'branch_id', 'checkautounique'];

	
   public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name,CD.picture,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

        
              if (isset($searchArray['company_id'])) {
               $sql .= " AND (ad.company_id LIKE '" . $searchArray['company_id'] . "%')";
                
              }
              if (isset($searchArray['branch_id'])) {
               $sql .= " AND (ad.branch_id LIKE '" . $searchArray['branch_id'] . "%')";
                
              }
               if (isset($searchArray['status'])) {
               $sql .= " AND (ad.status LIKE '" . $searchArray['status'] . "%')";
            
                
              }
              if (isset($searchArray['id'])) {
               $sql .= " AND (ad.id LIKE '" . $searchArray['id'] . "%')";
                
              }


        $sql .= " ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        // if($showQuery)
        // { 
        //     echo $sql;
        //     die();
        // }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
//print_r($coutOnly); die('aa');
            return $result[0]->total_count;
        }
  // echo $this->db->getLastQuery();
        return $result;
    }
     public function getDataApi($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.id as coupon_purchase_id,ad.coupon_id,ad.purchase_status,co.*,CD.company_name,CD.picture,B.branch_name FROM $this->table AS ad ";
             $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
             $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
            $sql .= " LEFT JOIN coupon AS co ON (ad.coupon_id = co.id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

        
              if (isset($searchArray['user_id'])) {
               $sql .= " AND ad.user_id ='" . $searchArray['user_id'] . "'";
             
                
              }
            


        $sql .= " ORDER BY ad.id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        // if($showQuery)
        // { 
        //     echo $sql;
        //     die();
        // }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
//print_r($coutOnly); die('aa');
            return $result[0]->total_count;
        }
   //echo $this->db->getLastQuery();
        return $result;
    }



    public function getDataReport($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,co.coupon_name,co.coupon_amount,co.coupon_price,c.name,com.company_name,c.city_code,B.branch_name";
            
                //if user order count then 
               
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN coupon as co ON (ad.coupon_id = co.id) ";
        $sql .= " LEFT JOIN customer as c ON (ad.user_id = c.id) ";
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
        $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
       

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
            $sql .= " AND ( DATE_FORMAT(ad.created, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

          

       
         if (isset($searchArray['session_company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['session_company_id'] . "' ";
        }
       
        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
        }
        if (isset($searchArray['branch_id'])) {
            $sql .= " AND ad.branch_id = '" . $searchArray['branch_id'] . "' ";
        }
        if (isset($searchArray['coupon_name'])) {
            $sql .= " AND co.coupon_name LIKE '" . $searchArray['coupon_name'] . "%' ";
        }
         if (isset($searchArray['coupon_amount'])) {
            $sql .= " AND co.coupon_amount = '" . $searchArray['coupon_amount'] . "' ";
        }
         if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }
      
        // $sql.="AND ad.purchase_status='Active'";
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

     public function getDataReportexpire($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,co.coupon_name,co.coupon_amount,co.coupon_price,c.name,com.company_name,c.city_code,B.branch_name";
            
                //if user order count then 
               
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN coupon as co ON (ad.coupon_id = co.id) ";
        $sql .= " LEFT JOIN customer as c ON (ad.user_id = c.id) ";
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
        $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
       

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
            $sql .= " AND ( DATE_FORMAT(ad.created, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

          

       
          if (isset($searchArray['session_company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['session_company_id'] . "' ";
        }

       
        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
        }
        if (isset($searchArray['coupon_name'])) {
            $sql .= " AND co.coupon_name LIKE '" . $searchArray['coupon_name'] . "%' ";

        }
         if (isset($searchArray['coupon_amount'])) {
            $sql .= " AND co.coupon_amount = '" . $searchArray['coupon_amount'] . "' ";
        }
         if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }
      
        $sql.="AND ad.purchase_status='Expire'";
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


    public function getDataReportredeem($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,co.coupon_name,co.coupon_amount,co.coupon_amount,co.coupon_price,c.name,com.company_name,orders.od_totalamount,orders.od_saveamount,orders.od_paidamount,orders.od_discount,B.branch_name";
            
                //if user order count then 
               
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN coupon as co ON (ad.coupon_id = co.id) ";
        $sql .= " LEFT JOIN customer as c ON (ad.user_id = c.id) ";
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
        $sql .= " LEFT JOIN orders as orders ON (ad.id = orders.coupon_purchase_id) ";
        $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
       

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
            $sql .= " AND ( DATE_FORMAT(ad.created, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }
            if (isset($searchArray['session_company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['session_company_id'] . "' ";
        }

          

       
        
       
        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
        }
        if (isset($searchArray['coupon_name'])) {
            $sql .= " AND co.coupon_name LIKE '" . $searchArray['coupon_name'] . "%' ";
        }
         if (isset($searchArray['coupon_amount'])) {
            $sql .= " AND co.coupon_amount = '" . $searchArray['coupon_amount'] . "' ";
        }
        $sql.="AND ad.purchase_status='Used'";
      

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
        // echo $this->db->getLastQuery();

         return $result;
    }


      public function usergetDataReport($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,co.coupon_name,co.coupon_amount,co.coupon_price,co.start_date,co.end_date,co.arb_coupon_name,co.coupon_details,co.arb_coupon_details,c.name,com.company_name,c.city_code,OID.od_paidamount";
            
                //if user order count then 
               
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN coupon as co ON (ad.coupon_id = co.id) ";
        $sql .= " LEFT JOIN customer as c ON (ad.user_id = c.id) ";
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
        $sql .= " LEFT JOIN orders as OID ON (ad.id = OID.coupon_purchase_id) ";

       

        $sql .= ' WHERE 1 ';
   


       
        
       
     
         if (isset($searchArray['userid'])) {
            $sql .= " AND ad.user_id = '" . $searchArray['userid'] . "' ";
        }
         if (isset($searchArray['companyid'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['companyid'] . "' ";
         
        }
        $sql .= 'ORDER BY ad.id DESC';
      
        // $sql.="AND ad.purchase_status='Active'";
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


      public function getDatapreview($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
           $sql = "SELECT ad.*,co.coupon_name,co.coupon_amount,co.coupon_price,co.start_date,co.end_date,co.arb_coupon_name,co.coupon_details,co.arb_coupon_details,c.name,com.company_name,c.city_code,orders.od_totalamount,orders.od_saveamount,orders.od_paidamount,orders.od_discount,B.branch_name";
            
                //if user order count then 
               
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN coupon as co ON (ad.coupon_id = co.id) ";
        $sql .= " LEFT JOIN customer as c ON (ad.user_id = c.id) ";
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
        $sql .= " LEFT JOIN orders as orders ON (ad.id = orders.coupon_purchase_id) ";
        $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
       

        $sql .= ' WHERE 1 ';
     

        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

          
       
        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
        }
        if (isset($searchArray['coupon_name'])) {
            $sql .= " AND ad.coupon_name = '" . $searchArray['coupon_name'] . "' ";
        }
         if (isset($searchArray['coupon_price'])) {
            $sql .= " AND ad.coupon_price = '" . $searchArray['coupon_price'] . "' ";
        }
         if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }

         if (isset($searchArray['purchase_status'])) {
            $sql .= " AND ad.purchase_status = '" . $searchArray['purchase_status'] . "' ";
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

    public function comp($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        

        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM 'assignCouponAmount' AS ad ";
        } else {
           $sql = "SELECT ad.company_id as id,com.company_name,com.company_arb_name";
            
                //if user order count then 
               
            $sql .= " FROM assignCouponAmount AS ad ";
        }

      
        $sql .= " LEFT JOIN company_details as com ON (ad.company_id = com.id) ";
       

        $sql .= ' WHERE 1 ';
     

     $sql.="GROUP BY ad.company_id";
    
      
    
        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        if($showQuery)
        { 
            echo $sql;
        }
        //echo $sql;die;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }




    
}

?>
