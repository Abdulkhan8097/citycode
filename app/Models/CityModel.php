<?php

//CityModel.php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model{

	protected $table = 'cities';

	protected $primaryKey = 'city_id';

	protected $allowedFields = ['state_id', 'city_name', 'city_id'];

        
     public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch']) && $searchArray['txtsearch']) {
            $sql .= " AND (ad.city_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.city_arb_name LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        
        if (isset($searchArray['state_id']) && $searchArray['state_id']) {
            $sql .= " AND ad.state_id = '" . $searchArray['state_id'] . "' ";
        }
        
        if (isset($searchArray['sort_by']) && $searchArray['sort_by']=="arebic") {
            $sql .= " ORDER BY city_arb_name ASC";
        }
        else
        {
         $sql .= " ORDER BY city_name ASC";
        }
        

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