<?php

namespace App\Models;

use CodeIgniter\Model;

class OnlineShoppingModel extends Model {

    protected $table = 'onlineShoppingOrders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = ['order_id', 'user_id', 'transaction_id', 'product_id', 'qty', 'actual_price', 'afterdiscount_price', 'discount_percent', 'created_date', 'total_amount', 'company_id', 'product_cost_mobile', 'product_discount_mobile', 'payment_status', 'suppliervat_charges', 'appService_charge', 'cityCodeVat_Charge', 'delivery_charge', 'total_cost_mobile', 'total_cost_mobile_without_deilvery_charges', 'point', 'branch_id', 'discount_offer_citycode'];

   

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.order_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name,C.name,C.vip_code,C.city_code ,C.mobile,P.discount_offer,P.product_name,P.picture,P.service_charge,P.citycode_vat,P.supplierVat_charges,P.original_price,P.cityCode_benefits,P.price,P.delivery_charge,P.delivery_km,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN customer AS C ON (ad.user_id = C.id ) ";
            $sql .= " LEFT JOIN products AS P ON (ad.product_id = P.id ) ";
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

            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
            if (isset($searchArray['product_id'])) {
               $sql .= " AND (ad.product_id LIKE '" . $searchArray['product_id'] . "%')";
                
              }
              if (isset($searchArray['company_id'])) {
               $sql .= " AND (ad.company_id LIKE '" . $searchArray['company_id'] . "%')";
                
              }
              if (isset($searchArray['branch_id'])) {
               $sql .= " AND (ad.branch_id LIKE '" . $searchArray['branch_id'] . "%')";
                
              }
               if (isset($searchArray['payment_status'])) {
               $sql .= " AND (ad.payment_status LIKE '" . $searchArray['payment_status'] . "%')";
                
              }
              if (isset($searchArray['order_id'])) {
               $sql .= " AND (ad.order_id LIKE '" . $searchArray['order_id'] . "%')";
                
              }


        $sql .= " ORDER BY order_id DESC";

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
     public function getDataTransaction($searchArray = array()) {
     
            $sql = "SELECT ad.*,CD.company_name,C.name,C.vip_code,C.city_code ,C.mobile,P.product_name,P.picture,P.cityCode_benefits,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN customer AS C ON (ad.user_id = C.id ) ";
            $sql .= " LEFT JOIN products AS P ON (ad.product_id = P.id ) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

    
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

         if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {

            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           
           }
            if (isset($searchArray['product_id'])) {
               $sql .= " AND (ad.product_id LIKE '" . $searchArray['product_id'] . "%')";
                
              }
              if (isset($searchArray['company_id'])) {
               $sql .= " AND (ad.company_id LIKE '" . $searchArray['company_id'] . "%')";
                
              }
              if (isset($searchArray['branch_id'])) {
               $sql .= " AND (ad.branch_id LIKE '" . $searchArray['branch_id'] . "%')";
                
              }
               if (isset($searchArray['payment_status'])) {
               $sql .= " AND (ad.payment_status LIKE '" . $searchArray['payment_status'] . "%')";
                
              }
              if (isset($searchArray['order_id'])) {
               $sql .= " AND (ad.order_id LIKE '" . $searchArray['order_id'] . "%')";
                
              }

        $sql .= "AND ad.payment_status='1'";
        $sql .= " ORDER BY order_id DESC";

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

      
  // echo $this->db->getLastQuery();
        return $result;
    }

     public function myOrder($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.order_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name,CD.company_arb_name,CD.picture as companyImage,C.name,C.vip_code,C.city_code ,C.mobile,P.discount_offer,P.product_name,P.picture,P.service_charge,P.citycode_vat,P.supplierVat_charges,P.original_price,P.cityCode_benefits,P.price,P.delivery_charge,P.delivery_km,P.arb_product_name,B.branch_name FROM $this->table AS ad ";
            $sql .= " LEFT JOIN company_details AS CD ON (ad.company_id = CD.id) ";
            $sql .= " LEFT JOIN customer AS C ON (ad.user_id = C.id ) ";
            $sql .= " LEFT JOIN products AS P ON (ad.product_id = P.id ) ";
            $sql .= " LEFT JOIN branch AS B ON (ad.branch_id = B.branch_id ) ";

        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        
        // if (isset($searchArray['txtsearch'])) {
        //     $sql .= " AND (P.product_name LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
        //     $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        // }

       
              if (isset($searchArray['user_id'])) {
               $sql .= " AND (ad.user_id = '" . $searchArray['user_id'] . "')";
                
              }


        $sql .= " ORDER BY order_id DESC";

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


}

?>
