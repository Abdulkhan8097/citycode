<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerImpressionModel extends Model {

    protected $table = 'customer_impression';
    protected $primaryKey = 'cm_id';
    protected $allowedFields = ['cm_id', 'cm_userid', 'cm_count', 'cm_created'];

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        
      
        
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.cm_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* , C.* ";
            
            $sql .= " FROM $this->table AS ad ";
        }

        $sql .= " LEFT JOIN customer as C ON (C.id = ad.cm_userid) ";
        

        $sql .= ' WHERE 1 ';
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND ( C.name LIKE '" . $searchArray['txtsearch'] . "%' ";
        }
        
         if (isset($searchArray['mobile'])) {
            $sql .= " AND C.mobile = '" . $searchArray['mobile'] . "' ";
        }
        if (isset($searchArray['gender'])) {
            $sql .= " AND C.gender = '" . $searchArray['gender'] . "' ";
        }
        if (isset($searchArray['city_code'])) {
            $sql .= " AND C.city_code = '" . $searchArray['city_code'] . "' ";
        }
        if (isset($searchArray['vip_code'])) {
            $sql .= " AND C.vip_code = '" . $searchArray['vip_code'] . "' ";
        }
        if (isset($searchArray['stateid'])) {
            $sql .= " AND C.stateid = '" . $searchArray['stateid'] . "' ";
        }
        if (isset($searchArray['cityid'])) {
            $sql .= " AND C.cityid = '" . $searchArray['cityid'] . "' ";
        }
        
        if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.cm_created, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.cm_created, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }

        $sql .= ' ORDER BY cm_id DESC';

      // echo $sql;

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
    
    public function getTodayimpression($userId)
    {
            $today = date('Y-m-d');
            $sql = "SELECT ad.* ";
            $sql .= " FROM $this->table AS ad ";
            $sql .= ' WHERE 1 ';
            
            $sql .= " AND cm_userid = ".$userId; 
            $sql .= " AND DATE_FORMAT(ad.cm_created, '%Y-%m-%d') = '".$today."'  "; 
            
            $query = $this->db->query($sql);
            $result = $query->getResult();
            return $result;
    }
    
    

}

?>