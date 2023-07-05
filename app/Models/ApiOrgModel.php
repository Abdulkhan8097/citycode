<?php 

namespace App\Models;

use CodeIgniter\Model;

class ApiOrgModel extends Model{
    
    protected $table = 'org_details';
    protected $primaryKey = 'org_id';
    protected $allowedFields = ['org_id', 'vip', 'org_name','org_phone','org_email'];

     public function getData2($searchArray = array(), $offset = '', $limit = '', $coutOnly = '',$showQuery='') {
        
    
        
        if ($coutOnly) {
            $sql = "SELECT COUNT(org_id) as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.org_id as id,ad.org_name as name ,vip.vip_code,vip.status,vip.org_status,vip.type  FROM $this->table AS ad ";
        }
         $sql .= " LEFT JOIN vip ON (ad.vip = vip.id) ";

       

        $sql .= ' WHERE 1 ';
         if (isset($searchArray['vip_code'])) {
            $sql .= " AND vip.vip_code = '" . $searchArray['vip_code'] . "' ";

            
        }
       
                                
        // if (isset($searchArray['onlyvipcustomer']) && $searchArray['onlyvipcustomer']) {
        //     $sql .= " AND ad.vip <>'' ";
        // }
        
     
       

        if ($limit) {
            $sql .= " LIMIT $offset,$limit";
        }

        if($showQuery)
        { 
            echo $sql;
        }
        //echo $sql;die;
        $query = $this->db->query($sql);
        $result = $query->getResult();

        if ($coutOnly) {
            return $result[0]->total_count;
        }

        return $result;
    }
    

  

    public function getVipID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }



     public function checkVipCodeExist($organization_code)
    {
        $arrResult =  $this->asArray()
                     ->where('org_code' , $organization_code)
                    ->countAllResults();
					
		  // echo $this->getLastQuery(); die;
					
        return $arrResult;
    }



public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.org_id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND ad.org_code LIKE '".$searchArray['txtsearch']."%' ";
        }
       $sql .= " ORDER BY org_id DESC";

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

public function getbyid($id){

$arrResult =  $this->asArray()
                  ->where(['org_id' => $id])
                  ->first();
      return $arrResult;
}


	public function checkorgExist($organization_code)
    {

        $arrResult =  $this->asArray()
                    ->where(['org_code' => $organization_code])
                    ->countAllResults();
        return $arrResult;
    }


///////////////// vip and customer details //////////////////

public function getDetails($id)
    {
	$sql =  "SELECT customer.name, customer.family_name, customer.city_code, customer.vip_code, customer.gender, customer.date_of_birth, customer.nationality, customer.governorate,
               customer.state, customer.language, customer.mobile, customer.email, customer.profile, customer.commission, customer.start_date, customer.end_date, customer.status, customer.created_date, customer.updated_date, vip.id, vip.status FROM $this->table";	
        $sql .= " LEFT JOIN customer  ON (vip.vip_code = customer.vip_code) ";					
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

  public function checkVipExist($vip_code)
    {
        $arrResult =  $this->asArray()
                    ->where(['vip' => $vip_code])
                    ->countAllResults();
        return $arrResult;
    }



 }
?>
