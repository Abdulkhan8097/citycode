<?php

namespace App\Models;

use CodeIgniter\Model;

class OnlineShoppingTransactionModel extends Model {

    protected $table = 'transaction_record';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'start_date', 'end_date', 'company_id', 'branch_id', 'total_amount_paid_by_customer', 'total_supplier_amount', 'total_citycode_charage', 'created', 'amount', 'payment_status' ,'cpaid_amount', 'payment_mode', 'txn_no', 'remark', 'supplier_payment_date'];

   

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,CD.company_name,B.branch_name FROM $this->table AS ad ";
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
               if (isset($searchArray['payment_status'])) {
               $sql .= " AND (ad.payment_status LIKE '" . $searchArray['payment_status'] . "%')";
                
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
   


}

?>
