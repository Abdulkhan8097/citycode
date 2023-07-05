<?php 

namespace App\Models;

use CodeIgniter\Model;

class VersionControlModel extends Model{
    
    protected $table = 'version_control';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'version_no', 'created'];

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
            $sql .= " AND ad.version_no LIKE '".$searchArray['txtsearch']."%' ";
           
            
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
       // echo $this->db->getLastQuery();exit;

        return $result;
    }

 }
?>
