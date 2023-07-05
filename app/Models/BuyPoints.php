<?php
namespace App\Models;

use CodeIgniter\Model;

class BuyPoints extends Model{

	protected $table = 'buy_poins';

	protected $primaryKey = 'id';

	protected $allowedFields = ['id', 'points', 'amount','created'];
        
     public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        
       //  if(isset($searchArray['date']))
       // {
       //     $sql .= " AND ( DATE_FORMAT(ad.start_date, '%Y-%m-%d') <='".$searchArray['date']."' ";
       //     $sql .= "  AND DATE_FORMAT(ad.end_date, '%Y-%m-%d') >= '".$searchArray['date']."') ";
       // }
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