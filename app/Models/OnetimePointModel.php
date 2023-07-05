<?php
namespace App\Models;

use CodeIgniter\Model;

class OnetimePointModel extends Model{

	protected $table = 'one_time_point';

	protected $primaryKey = 'point_id';

	protected $allowedFields = ['point_id', 'start_date1', 'end_date1','initial_point1'];
        
     public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.point_id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if(isset($searchArray['date']))
       {
           $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') <='".$searchArray['date']."' ";
           $sql .= "  AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') >= '".$searchArray['date']."') ";
       }
        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }

        $query = $this->db->query($sql);
        $result = $query->getResult();
        
        if($coutOnly)
        {
            return $result[0]->total_count;
        }

        return $result;
    }

}

?>