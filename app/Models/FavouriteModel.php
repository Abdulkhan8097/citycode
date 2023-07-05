<?php

namespace App\Models;

use CodeIgniter\Model;

class FavouriteModel extends Model {

    protected $table = 'favourite';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'customer_id', 'company_id', 'add_date','offer_id'];

    
    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*, ";
            
            $sql .= " C.company_name,C.company_arb_name, C.display_name,C.display_arb_name,C.picture as companylogo,C.view_count,CONCAT(CC.customer_discount,'%') AS discountdisplay,CC.customer_discount,CC.discount_detail,CC.description, if(SV.st_name!='',SV.st_name,'') as discount_en_detail,if(SV.st_arb_name!='',st_arb_name,'') as discount_arb_detail, ";

            //if(SV.st_name!='',SV.st_name,'') as discount_en_detail,if(SV.st_arb_name!='',st_arb_name,'') as discount_arb_detail, ";
            
            $sql .= " FLOOR(HOUR(TIMEDIFF(CC.end_date, '".date('Y-m-d g:i:s')."')) / 24) AS remainingday, ";
            $sql .= " MOD(HOUR(TIMEDIFF(CONCAT(CC.end_date,' 24:00:00'), '".date('Y-m-d g:i:s')."')), 24) AS remaininghours, ";
             $sql .= " MINUTE(TIMEDIFF(CC.end_date, '".date('Y-m-d g:i:s')."')) AS remainingminutes ";
//             
            $sql .= " FROM $this->table AS ad ";
        }
        
          $sql .= " LEFT JOIN company_details as C ON (ad.company_id = C.id) ";
          $sql .= " LEFT JOIN company_code_details as CC ON (ad.offer_id = CC.id) ";
          $sql .= " LEFT JOIN sitevariable AS SV ON (CC.discount_detail = SV.st_id) ";
          
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        $sql .= " AND  C.id <> '' ";
         
        $sql .= " AND  CC.coupon_type = 'city' ";
         $sql .= " AND  C.coupon_status='0' ";
        
        
        
        if (isset($searchArray['id'])) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
           
        }
        
        if (isset($searchArray['customer_id'])) {
            $sql .= " AND ad.customer_id = '" . $searchArray['customer_id'] . "' ";
           
        }
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND C.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }
        
        // $sql .= " GROUP BY ad.company_id ";
        
        $sql .= " GROUP BY id";
        $sql .= " ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

//        echo $sql;
        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        if ($coutOnly) {
            return $result[0]->total_count;
        }
     
//ECHO $this->db->getLastQuery();
        return $result;
    }


    
    
    public function FavouriteExist($customer_id, $company_id) {
        $arrResult = $this->asArray()
                ->where(['customer_id' => $customer_id])
                ->where(['company_id' => $company_id])
                ->countAllResults();
        return $arrResult;
    }

    public function getCustomerID($id) {
        $arrResult = $this->asArray()
                ->where(['id' => $id])
                ->first();
        return $arrResult;
    }

}

?>
