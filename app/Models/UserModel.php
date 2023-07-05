<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    
     protected $table = 'users';
     protected $primaryKey = 'id';  
     protected $allowedFields = ['id', 'name', 'password', 'family_name', 'sex', 'birth_date', 'nationality', 'governorate', 'state', 'village','language','mobile','email','user_type', 'created_date', 'profile'];




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
            $sql .= " AND ad.email LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.phone LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.sub_admin LIKE '".$searchArray['txtsearch']."%' ";
        }
       $sql .= " ORDER BY id DESC";

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

    public function getUserdetail($id)
    {
        $arrResult =  $this->asArray()
                    ->where(['id' => $id])
                    ->first();

        return $arrResult;
    }
    
    
   


}

?>
