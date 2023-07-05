<?php namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model{
    
    protected $table = 'menulist';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'company_id', 'branch_id', 'start_date', 'end_date', 'status'];
   
	  
    public function getMenuID($id)
    {
      $arrResult =  $this->asArray()
                  ->where(['id' => $id])
                  ->first();
      return $arrResult;
    }

	
    public function getBranchName($id) {
        $sql = "SELECT menulist.company_id, branch.branch_id, branch.branch_name, branch.arb_branch_name FROM menulist";
        $sql .= " LEFT JOIN branch ON (branch.company_id = menulist.company_id) ";
        $sql .= " WHERE id ='" . $id . "' "; 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
	

public function getAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = "SELECT  ad.company_id, ad.branch_id,ad.id,company_details.company_name,company_details.company_arb_name, company_details.picture AS company_picture,menu_image.menu_image AS menu_image,
                   branch.branch_name,branch.arb_branch_name, ad.start_date, ad.end_date FROM $this->table AS ad ";
       }
       
        $sql .= "LEFT JOIN company_details ON (company_details.id = ad.company_id) ";
        $sql .= "LEFT JOIN branch ON (branch.branch_id = ad.branch_id) ";
        $sql .= "LEFT JOIN menu_image ON (ad.id = menu_image.menu_id) ";
        
       $sql .= " ";
       $sql .= " WHERE 1 ";
       if(isset($searchArray['txtsearch']))
       {
           $sql .= " AND company_details.company_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR branch.branch_name LIKE '".$searchArray['txtsearch']."%' ";
       }
       
       if(isset($searchArray['id']))
       {
           $sql .= " AND ad.id = '".$searchArray['id']."' ";
       }
    
       if(isset($searchArray['branch_id']))
       {
           $sql .= " AND ad.branch_id = '".$searchArray['branch_id']."' ";
       }
              
       if(isset($searchArray['company_id']))
       {
           $sql .= " AND ad.company_id = '".$searchArray['company_id']."' ";
       }
      
       
      $sql .= " ORDER BY ad.id DESC";

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

   

  public function getCompanyBranch($id) {
        $sql = "SELECT branch.branch_id, branch.company_id, branch.branch_name, branch.arb_branch_name FROM branch";
        $sql .= " WHERE branch.company_id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }



public function getApiAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = "SELECT menu_image.id, ad.company_id, ad.branch_id, company_details.company_name,company_details.company_arb_name, company_details.picture AS company_picture, 
                   branch.branch_name,branch.arb_branch_name, ad.start_date, ad.end_date, menu_image.menu_image FROM $this->table AS ad ";
       }
       
        $sql .= "LEFT JOIN menu_image ON (ad.id = menu_image.menu_id) ";
        $sql .= "LEFT JOIN company_details ON (company_details.id = ad.company_id) ";
        $sql .= "LEFT JOIN branch ON (branch.branch_id = ad.branch_id) ";
        
       $sql .= " ";
       $sql .= " WHERE 1 ";
       if(isset($searchArray['txtsearch']))
       {
           $sql .= " AND company_details.company_name LIKE '".$searchArray['txtsearch']."%' ";
           $sql .= " OR branch.branch_name LIKE '".$searchArray['txtsearch']."%' ";
       }
       
       if(isset($searchArray['id']))
       {
           $sql .= " AND ad.id = '".$searchArray['id']."' ";
       }
    
       if(isset($searchArray['branch_id']))
       {
           $sql .= " AND ad.branch_id = '".$searchArray['branch_id']."' ";
       }
       
       
       if(isset($searchArray['company_id']))
       {
           $sql .= " AND ad.company_id = '".$searchArray['company_id']."' ";
       }
       
      $sql .= " ORDER BY ad.id DESC";

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
