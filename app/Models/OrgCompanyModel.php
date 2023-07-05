<?php

//CountryModel.php

namespace App\Models;

use CodeIgniter\Model;

class OrgCompanyModel extends Model {

    protected $table = 'org_company';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'org_id', 'created_date'];

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*, C.org_name FROM $this->table AS ad ";
        }

        // $sql .= " LEFT JOIN company_details as C ON (ad.company_id = C.id) ";
         $sql .= " LEFT JOIN org_details  as C ON(ad.org_id = C.org_id) ";

        $sql .= ' WHERE 1 ';
        
       

        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }

        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";
        }

        if (isset($searchArray['org_id'])) {
            $sql .= " AND ad.org_id = '" . $searchArray['org_id'] . "' ";
        }


        $sql .= " ORDER BY ad.id DESC";

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
    public function getVipOffers($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
           $sql = "SELECT DISTINCT ad.*,CC.coupon_type,CONCAT(CC.customer_discount,'%') AS discountdisplay,CONCAT(CC.customer_discount) AS customer_discount,CC.discount_detail,CC.description,C.company_name,C.display_name,C.company_arb_name,C.display_arb_name,C.picture as companylogo,C.view_count,C.category,C.status,DATE_FORMAT(CC.start_date,'%d-%m-%Y') as start_date,DATE_FORMAT(CC.end_date,'%d-%m-%Y') as end_date,if(SV.st_name!='',st_name,'') as discount_en_detail,if(SV.st_arb_name!='',st_arb_name,'') as discount_arb_detail, ";
            
            $sql .= " FLOOR(HOUR(TIMEDIFF(CC.end_date, '".date('Y-m-d g:i:s')."')) / 24) AS remainingday, ";
            $sql .= " MOD(HOUR(TIMEDIFF(CONCAT(CC.end_date,' 24:00:00'), '".date('Y-m-d g:i:s')."')), 24) AS remaininghours, ";
             $sql .= " MINUTE(TIMEDIFF(CC.end_date, '".date('Y-m-d g:i:s')."')) AS remainingminutes ";
             $sql .= " FROM $this->table AS ad ";
        }
        
         $sql .= " LEFT JOIN company_details AS C ON (ad.company_id = C.id) ";
         $sql .= " LEFT JOIN company_code_details AS CC ON (ad.company_id = CC.company_id) ";
          $sql .= " LEFT JOIN sitevariable AS SV ON (CC.discount_detail = SV.st_id) ";

        $sql .= ' WHERE 1 ';
        
       

        if (isset($searchArray['id']) && $searchArray['id']) {
            $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
        }

        if (isset($searchArray['company_id'])) {
            $sql .= " AND ad.company_id = '" . $searchArray['company_id'] . "' ";

        }

        if (isset($searchArray['customer_id'])) {
            $sql .= " AND ad.customer_id = '" . $searchArray['customer_id'] . "' ";

        }

        if (isset($searchArray['coupon_type']) && $searchArray['coupon_type'] ) {
            
            if(is_array($searchArray['coupon_type']))
            {
                $in_array = implode("','",$searchArray['coupon_type']);
                
                 $sql .= " AND CC.coupon_type IN ('" . $in_array . "') ";

            }
            else
            {
             $sql .= " AND CC.coupon_type = '" . $searchArray['coupon_type'] . "' ";


            }
           
        }
        if (isset($searchArray['status'])) {
            $sql .= " AND C.status = '" . $searchArray['status'] . "' ";

        }
         if (isset($searchArray['org_id'])) {
            $sql .= " AND ad.org_id = '" . $searchArray['org_id'] . "' ";

        }

        
       // echo $sql;exit;
        
        // if all  expire also the pass all as 1
        // if (!isset($searchArray['expiredoffer'])) {
        //  $sql .= " AND ( DATE_FORMAT(CC.start_date, '%Y-%m-%d') <= '".date('Y-m-d')."' ";
        //  $sql .= " AND DATE_FORMAT(CC.end_date, '%Y-%m-%d') >= '".date('Y-m-d')."' ) ";
        // }
        
        /*if (!isset($searchArray['alloffer'])) {
         $sql .= " GROUP BY ad.company_id ";
        }*/
        $sql .= " GROUP  BY ad.company_id";
        $sql .= " ORDER BY $this->primaryKey DESC";

        //echo $sql;exit;

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }
         // echo $this->db->getLastQuery();
// echo $this->db->getLastQuery();
        return $result;
    }
        
    

}

?>