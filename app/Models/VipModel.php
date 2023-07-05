<?php namespace App\Models;

use CodeIgniter\Model;

class VipModel extends Model{
    
    protected $table = 'vip';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'vip_code', 'status', 'created_date', 'updated_date','type','org_status'];
    

  

    public function getVipID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }

    public function getbyid($id){

$arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
}

     public function checkVipCodeExist($vip_code)
    {
        $arrResult =  $this->asArray()
                     ->where('vip_code' , $vip_code)
                    ->countAllResults();
					
		  // echo $this->getLastQuery(); die;
					
        return $arrResult;
    }



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
            $sql .= " AND ad.vip_code LIKE '".$searchArray['txtsearch']."%' ";
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




	public function checkVipExist($vip_code)
    {
        $arrResult =  $this->asArray()
                    ->where(['vip_code' => $vip_code])
                    ->countAllResults();
        return $arrResult;
    }


///////////////// vip and customer details //////////////////

public function getDetails($id)
    {
	$sql =  "SELECT customer.name, customer.family_name, customer.city_code, customer.vip_code, customer.gender, customer.date_of_birth, customer.nationality, customer.governorate,
               customer.state, customer.language, customer.mobile, customer.email, customer.profile, customer.commission, customer.start_date, customer.end_date, customer.status, customer.created_date, customer.updated_date, vip.id,vip.vip_code, vip.status,org_details.* FROM $this->table";	
        $sql .= " LEFT JOIN customer  ON (vip.vip_code = customer.vip_code) ";
	 $sql .= " LEFT JOIN org_details  ON (vip.id = org_details.vip) ";					
        $sql .= " WHERE vip.id ='".$id."' "; 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        //echo "<pre>";print_r($query);exit;
        return $result;
    }


/*public function getVipCustomer()
    {
	$sql =  "SELECT customer.name, customer.vip_code, vip.id, vip.status FROM $this->table";	
        $sql .= " JOIN customer  ON (vip.vip_code = customer.vip_code) ";					
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }*/

        public function org_code($code) {
        $sql = "SELECT vip_code,id FROM $this->table";
        $sql .= " WHERE vip_code ='" . $code . "' ";
        $sql .= " AND org_status ='1' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }





 }
?>
