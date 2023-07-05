<?php namespace App\Models;

use CodeIgniter\Model;

class ProductImagesModel extends Model{
    
    protected $table = 'product_image';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'product_id', 'image_type', 'image_name'];

   public function getAll($searchArray=array(), $offset='', $limit='',$coutOnly='')
   {
       if($coutOnly)
       {
           $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
       }
       else
       {
           $sql = "SELECT ad.*  FROM $this->table AS ad ";
       }
       
       $sql .= " ";
       $sql .= " WHERE 1 ";
       
       
       if(isset($searchArray['id']))
       {
           $sql .= " AND ad.id = '".$searchArray['id']."' ";
       }

       
       if(isset($searchArray['product_id']))
       {
           $sql .= " AND ad.product_id = '".$searchArray['product_id']."' ";
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


   public function getImageById($product_id)
      {
        $sql =  "SELECT id, product_id, image_name FROM $this->table";						
        $sql .= " WHERE product_id ='".$product_id."' ";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
	
 }
?>
