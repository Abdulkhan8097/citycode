<?php namespace App\Models;

use CodeIgniter\Model;

class ApiMedicineModel extends Model{
    
     protected $table = 'medicines';
     protected $primaryKey = 'id';
     protected $allowedFields = ['id', 'medicine_name', 'item_price', 'medicine_icon', 'medicine_images', 'medicine_desc', 'status'];

	// public function savedata($arrSaveData){

    //     $this->save($arrSaveData);
        
    //     return $this->getInsertID();
    // }


	public function getDataByMedicineName($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.id,ad.medicine_name,ad.item_price,ad.medicine_icon,ad.status FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.medicine_name LIKE '".$searchArray['txtsearch']."%' ";
            // $sql .= " OR ad.phone LIKE '".$searchArray['txtsearch']."%' ";
        }
       $sql .= " ORDER BY id ASC";

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

    public function getMedicinedetail($id)
    {
        $arrResult =  $this->asArray()
                    ->where(['id' => $id])
                    ->first();

        return $arrResult;
    }

    public function getMedicinedescription($id)
    {
        $arrResult =  $this->asArray()
                    ->where(['id' => $id])
                    ->first();

        return $arrResult;
    }

    




}

?>
