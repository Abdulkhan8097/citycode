<?php namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model{
    
     protected $table = 'coupon';
     protected $primaryKey = 'id';
     protected $allowedFields = ['id', 'start_date', 'end_date', 'created', 'coupon_name', 'coupon_amount', 'coupon_price', 'company_id', 'branch_id', 'status', 'coupon_details', 'coupon_quantity', 'arb_coupon_name', 'arb_coupon_details', 'autounique'];

	
   public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name,CD.picture,CD.coupon_status,B.branch_name FROM $this->table AS ad ";
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

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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
              if (isset($searchArray['coupon_id']) && $searchArray['coupon_id']) {
            $sql .= " AND ad.id = '" . $searchArray['coupon_id'] . "' ";
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
            $sql = "SELECT ad.*,CD.company_name,CD.picture,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        $sql.= "AND coupon_quantity>0";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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



    public function getDatalist($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.company_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT DISTINCT ad.*,CD.company_name as display_name,CD.company_arb_name,CD.picture as companylogo,CD.coupon_status,CD.view_count,B.branch_name,CD.status as company_status ,";

               //favorate if user id
            $fav_customerid =  isset($searchArray['fav_customerid']) ? $searchArray['fav_customerid'] : 0;

            $sql .= " IF((SELECT if((customer_id='".$fav_customerid."' AND company_id=ad.company_id),1,0) FROM `favourite` where customer_id='".$fav_customerid."' AND company_id=ad.company_id ),1,0 ) AS isfavorate ";

            $sql .= " FROM $this->table AS ad ";
     

        }
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        // $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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


        $sql .= " AND CD.status='1'";
         $sql .= " GROUP  BY ad.company_id";
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
    public function favouritedata($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.company_id) as total_count FROM $this->table AS ad ";
        } else {
              $fav_customerid =  isset($searchArray['fav_customerid']) ? $searchArray['fav_customerid'] : 0;

            $sql = "SELECT DISTINCT ad.*,(SELECT count('customer_id,company_id') from favourite as C  WHERE C.customer_id='".$fav_customerid."' AND C.company_id=ad.company_id)as isfavorate,CD.company_name as display_name,CD.company_arb_name,CD.picture as companylogo,CD.coupon_status,CD.view_count,B.branch_name,CD.status as company_status ";

               //favorate if user id
          


            // $sql .= " IF((SELECT if((customer_id='".$fav_customerid."' AND company_id=ad.company_id),1,0) FROM `favourite` where customer_id='".$fav_customerid."' AND company_id=ad.company_id ),1,0 ) AS isfavorate ";

            $sql .= " FROM $this->table AS ad ";
     

        }
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";
           

        // $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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
              $sql .= " AND (SELECT count('customer_id,company_id') from favourite as C  WHERE C.customer_id='".$fav_customerid."' AND C.company_id=ad.company_id)='1'";

        $sql .= " AND CD.status='1'";
         $sql .= " GROUP  BY ad.company_id";
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

        public function getBranchName($id) {
        $sql = "SELECT coupon.company_id, branch.branch_id, branch.branch_name, branch.arb_branch_name FROM coupon";
        $sql .= " LEFT JOIN branch ON (branch.company_id = coupon.company_id) ";
        $sql .= " WHERE id ='" . $id . "' "; 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }


    //  public function edit($id) {
    //     $sql = "SELECT coupon.company_id, branch.branch_id, branch.branch_name, branch.arb_branch_name FROM coupon";
    //     $sql .= " LEFT JOIN branch ON (branch.company_id = coupon.company_id) ";
    //     $sql .= " WHERE id ='" . $id . "' "; 
    //     $query = $this->db->query($sql);
    //     $result = $query->getResult();
    //     return $result;
    // }


     public function getDataApilistcoupon($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT  ad.*,CD.company_name,CD.picture,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";

        $sql.= "AND coupon_quantity>0";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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


        // $sql .= " ORDER BY id DESC";
        $sql .= " GROUP BY ad.autounique";
       

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
   //echo $this->db->getLastQuery();exit;
        return $result;
    }


      public function getDataApilistcouponcompany($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT  ad.*,(SELECT count(id) from coupon as C  WHERE C.autounique = ad.autounique AND C.coupon_quantity>0)as coupon_quantity,CD.company_name,CD.picture,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";

        $sql.= "AND ad.coupon_quantity>0";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
           
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


        
        $sql .= " GROUP BY ad.autounique";
         // $sql .= " ORDER BY ad.id DESC";
       

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
   // echo $this->db->getLastQuery();exit;
        return $result;
    }



}

?>
