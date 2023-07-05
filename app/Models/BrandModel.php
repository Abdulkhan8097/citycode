<?php namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model{
    
     protected $table = 'brands';
     protected $primaryKey = 'br_id';
     protected $allowedFields = ['br_id', 'br_name', 'br_status', 'br_created' ];

	// public function savedata($arrSaveData){

    //     $this->save($arrSaveData);
        
    //     return $this->getInsertID();
    // }


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
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.br_name LIKE '".$searchArray['txtsearch']."%' ";
            // $sql .= " OR ad.phone LIKE '".$searchArray['txtsearch']."%' ";
        }
       $sql .= " ORDER BY br_id DESC";

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
