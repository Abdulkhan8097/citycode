<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardAdvertisementModel extends Model {

    protected $table = 'dashboard_advertisement';
    protected $primaryKey = 'add_id';
    protected $allowedFields = ['add_id', 'add_name', 'add_image','url','status', 'created_date', 'created_by','countview1'];

    public function getBannersId($id) {
        $arrResult = $this->asArray()
                ->where(['add_id' => $id])
                ->first();
        return $arrResult;
    }

    public function getDataAll($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.$this->primaryKey) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.add_name LIKE '" . $searchArray['txtsearch'] . "%' ";
           
        }
        $sql .= " ORDER BY $this->primaryKey DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }
        
        if($showQuery)
        { 
            echo $sql;
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }
    public function updatecount($updateCount) {
        return $this->db
                        ->table('dashboard_advertisement')
                        ->where(["add_id" =>'1'])
                        ->set($updateCount)
                        ->update();
    }


}

?>
