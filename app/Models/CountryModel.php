<?php

//CountryModel.php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model{

	protected $table = 'countries';

	protected $primaryKey = 'country_id';

	protected $allowedFields = ['country_code','country_enName','country_arName','country_enNationality','country_arNationality'];
        
        
        public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch']) && $searchArray['txtsearch']) {
            $sql .= " AND (ad.country_enName LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.country_arName LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        
        if (isset($searchArray['sort_by']) && $searchArray['sort_by']=="arebic") {
            $sql .= " ORDER BY country_arName ASC";
        }
        else
        {
          $sql .= " ORDER BY country_enName ASC";
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