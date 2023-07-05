<?php

namespace App\Models;
use CodeIgniter\Model;

class SitevariableModel extends Model {

    protected $table = 'sitevariable';
    protected $primaryKey = 'st_id';

    protected $allowedFields = ['st_id', 'st_name', 'st_arb_name', 'st_group'];
    

    
    public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.st_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.st_arb_name LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        
        if (isset($searchArray['st_group']) ) {
            $sql .= " AND ad.st_group = '" . $searchArray['st_group'] . "%' ";
        }
        $sql .= " ORDER BY ad.st_name ASC";

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



    public function getAll() {

        $sql = "SELECT sitevariable.* FROM sitevariable";
        $sql .= " WHERE st_group = 'discount_type' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getOfferID($id) {
        $sql = "SELECT * FROM sitevariable";
        $sql .= " WHERE st_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getofferdata(){

        $sql = "SELECT DISTINCT * FROM $this->table  GROUP By st_name ORDER BY st_name ASC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
}

?>
