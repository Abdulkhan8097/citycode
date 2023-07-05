<?php

namespace App\Models;

use CodeIgniter\Model;

class company_payment_record extends Model {

    protected $table = 'company_payment_record';
    protected $primaryKey = 'com_id';
    protected $allowedFields = ['com_id', 'cpaid_amount', 'payment_mode', 'txn_no', 'remark', 'balance', 'supplier_payment_date', 'record_id'];

   

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.com_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
           

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
               if (isset($searchArray['payment_status'])) {
               $sql .= " AND (ad.payment_status LIKE '" . $searchArray['payment_status'] . "%')";
                
              }
              if (isset($searchArray['id'])) {
               $sql .= " AND (ad.id LIKE '" . $searchArray['id'] . "%')";
                
              }


        $sql .= " ORDER BY com_id DESC";

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
