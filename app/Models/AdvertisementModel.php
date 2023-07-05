<?php

namespace App\Models;

use CodeIgniter\Model;

class AdvertisementModel extends Model {

    protected $table = 'advertisement';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_name', 'governorate', 'start_date', 'end_date', 'url', 'banner', 'status', 'created_date', 'created_by', 'location', 'gender', 'banner_type', 'in_app', 'company_id','count'];

    public function getBannersID($id) {
        $arrResult = $this->asArray()
                ->where(['id' => $id])
                ->first();
        return $arrResult;
    }

    public function getDataAll($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        if ($coutOnly) {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
            
        }

        $sql .= " ";
        $sql .= " WHERE 1 ";
if (isset($searchArray['id']) && $searchArray['id']) {
            
            if(is_array($searchArray['id']))
            {
                $in_array = implode("','",$searchArray['id']);

                 $sql .= " AND ad.id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.id = '" . $searchArray['id'] . "' ";
            }

        }
        
        
        if (isset($searchArray['txtsearch'])) {
            $sql .= " AND (ad.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.banner_type LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR ad.id LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }
        $sql .= " ORDER BY id DESC";

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
//print_r($coutOnly); die('aa');
            return $result[0]->total_count;
        }

        return $result;
    }
public function updateCount($val, $bannerId){
         $sql = "UPDATE advertisement SET count=$val WHERE id=$bannerId";
         $query = $this->db->query($sql);
          $result = $query->getRow();
          return $result;

    }


}

?>
