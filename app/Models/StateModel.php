<?php

//StateModel.php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model{

	protected $table = 'states';

	protected $primaryKey = 'state_id';

	protected $allowedFields = ['country_id', 'state_name'];


        
       public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.state_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.arb_state_name LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        
        if (isset($searchArray['sort_by']) && $searchArray['sort_by']=="arebic") {
            $sql .= " ORDER BY arb_state_name ASC";
        }
        else
        {
          $sql .= " ORDER BY state_name ASC";
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

public function get_village($state_id) {
   
        $sql = "SELECT states.*, cities.* FROM states";
        $sql .= " LEFT JOIN cities ON (states.state_id = cities.state_id) ";
        $sql .= " WHERE states.state_id ='".$state_id."' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
       
        return $result;
   }


}	

?>