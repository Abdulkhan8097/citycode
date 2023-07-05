<?php namespace App\Models;

use CodeIgniter\Model;

class MenuImagesModel extends Model{
    
    protected $table = 'menu_image';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'menu_id', 'menu_image'];

   public function getDataAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = "SELECT ad.*, menulist.company_id, menulist.branch_id, menulist.start_date, menulist.end_date, company_details.company_name,company_details.company_arb_name,company_details.picture AS company_picture, 
                   branch.branch_name, branch.arb_branch_name FROM $this->table AS ad ";
       }

        $sql .= "LEFT JOIN menulist ON (ad.menu_id = menulist.id) ";
        $sql .= "LEFT JOIN company_details ON (company_details.id = ad.company_id) ";
        $sql .= "LEFT JOIN branch ON (branch.branch_id = ad.branch_id) ";

       
       $sql .= " ";
       $sql .= " WHERE 1 ";
       
       
       if(isset($searchArray['id']))
       {
           $sql .= " AND ad.id = '".$searchArray['id']."' ";
       }

       
       if(isset($searchArray['menu_id']))
       {
           $sql .= " AND ad.menu_id = '".$searchArray['menu_id']."' ";
       }
       
      $sql .= " ORDER BY ad.id DESC";

       if($limit)
       {
           $sql .= " LIMIT $offset,$limit";
       }
//echo $sql;
       $query = $this->db->query($sql);
       $result = $query->getResult();
       
       if($coutOnly)
       {
           return $result[0]->total_count;
       }

       return $result;
   }


   public function getImageById($menu_id)
      {
        $sql =  "SELECT id, menu_id, menu_image FROM $this->table";						
        $sql .= " WHERE menu_id ='".$menu_id."' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
	
 }
?>
