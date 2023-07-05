<?php

namespace App\Models;

use CodeIgniter\Model;

class userAddressModel extends Model {

    protected $table = 'user_address';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'user_id', 'name', 'governate', 'state', 'house_no', 'phone'];

    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.cat_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.cat_arbname LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        
        
        if (isset($searchArray['cat_id']) && $searchArray['cat_id']) {
            
            if(is_array($searchArray['cat_id']))
            {
                $in_array = implode("','",$searchArray['cat_id']);
                
                 $sql .= " AND ad.cat_id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.cat_id = '" . $searchArray['cat_id'] . "' ";
            }
           
        }
        
        $sql .= " ORDER BY cat_order ASC";

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

}

?>
