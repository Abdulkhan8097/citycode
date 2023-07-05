<?php 

namespace App\Models;

use CodeIgniter\Model;

class NotificationViewModel extends Model{
    
    protected $table = 'notification_view';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','user_id','notification_id','created_date'];

     public function getData($searchArray = array(), $offset = '', $limit = '', $coutOnly = '') {
        
    
        
        if ($coutOnly) {
            $sql = "SELECT COUNT('id') as total_count FROM $this->table AS ad ";
        } else {
            $sql = "SELECT ad.*,notification.title,notification.description,customer.name,customer.city_code  FROM $this->table AS ad ";
        }
         $sql .= " LEFT JOIN notification ON (ad.notification_id = notification.id) ";
         $sql .= " LEFT JOIN customer ON (ad.user_id = customer.id) ";

        if (isset($searchArray['txtsearch']) && $searchArray['txtsearch']) {
            $sql .= " AND (customer.name LIKE '" . $searchArray['txtsearch'] . "%' ";
            $sql .= " OR customer.city_code LIKE '" . $searchArray['txtsearch'] . "%' ) ";
        }

        $sql .= ' WHERE 1 ';
 

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
    

  













 }
?>
