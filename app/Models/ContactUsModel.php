<?php

//StateModel.php

namespace App\Models;

use CodeIgniter\Model;

class ContactUsModel extends Model{

	protected $table = 'contact_us';

	protected $primaryKey = 'con_id';

	protected $allowedFields = ['con_id','user_id', 'email', 'mobile', 'enquiry', 'status', 'created_date'];


   /* public function getFeedbackID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['con_id' => $id])
                  ->first();
      return $arrResult;
    }*/


   public function getFeedbackID($id) {
        $sql = "SELECT contact_us.*, customer.name, customer.city_code, customer.gender FROM contact_us";
        $sql .= " LEFT JOIN customer ON (customer.id = contact_us.user_id) ";
        $sql .= " WHERE con_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

public function getDataAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.user_id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.*, customer.name, customer.city_code, customer.gender FROM $this->table AS ad ";
        }
        $sql .= "LEFT JOIN customer ON (ad.user_id = customer.id) ";

        $sql .= " ";
        $sql .= " WHERE 1 ";
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.email LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR customer.name LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.enquiry LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR ad.mobile LIKE '".$searchArray['txtsearch']."%' ";
        }
      $sql .= " ORDER BY con_id DESC"; 

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