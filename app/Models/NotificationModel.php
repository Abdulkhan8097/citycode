<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model {

    protected $table = 'notification';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'interest', 'description', 'created_date', 'company_id', 'notification_type','send_status','title','user_id','order_id','accept_status','image','aprove_status','image_url','gender','governet','state','language','coupon_type'];
	


public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(NT.$this->primaryKey) as total_count FROM $this->table AS NT ";
        }
        else
        {
            $sql = "SELECT NT.* FROM $this->table AS NT ";
        }

        $sql .= " ";
        $sql .= " WHERE 1 ";
        
        if(isset($searchArray['txtsearch']))
        {
            $sql .= " AND NT.id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.interest LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.company_id LIKE '".$searchArray['txtsearch']."%' ";
            $sql .= " OR NT.description LIKE '".$searchArray['txtsearch']."%' ";
        }

        if(isset($searchArray['id']))
       {
           $sql .= " AND NT.id = '".$searchArray['id']."' ";
       }

       if(isset($searchArray['notification_type']))
       {
           $sql .= " AND NT.notification_type = '".$searchArray['notification_type']."' ";
       }
     if(isset($searchArray['company_id']))
       {
           $sql .= " AND NT.company_id = '".$searchArray['company_id']."' ";
       }
        
        $sql .= " ORDER BY $this->primaryKey DESC"; 

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
	
	
    public function getNotificationID($id) {
       
        $sql = "SELECT * FROM notification";
        $sql .= " LEFT JOIN states ON(states.state_id  = notification.governet) ";
        $sql .= " LEFT JOIN cities ON(cities.city_id   = notification.state) ";
        $sql .= " WHERE id ='" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }

    public function getDetailsCompany($strInterest,$registerdate='',$arrSearch=array()) {
        //echo "<pre>";print_r($strInterest);exit;
        $sql = "SELECT *,notification.id as notation_id,notification.image as notifyimage, notification.company_id FROM notification"; 
        $sql .= " LEFT JOIN company_details ON(company_details.id = notification.company_id) ";
        $sql .= " LEFT JOIN branch ON(branch.company_id = company_details.id) ";
        $sql .= " LEFT JOIN orders ON(orders.od_id = notification.order_id) ";
        $sql .= "WHERE ( ".$strInterest." ) ";
        
         if(!empty($arrSearch))
        {
            if(isset($arrSearch['gender']) && $arrSearch['gender'])
            {
                $sql .= " AND (LOWER(gender)='".strtolower($arrSearch['gender'])."' ";

                $sql .= " OR  LOWER(gender)='' || gender IS NULL )";
                // print_r($sql);
                // exit;
            }
            if(isset($arrSearch['governet']) && $arrSearch['governet'])
            {
                $sql .= " AND (governet=".$arrSearch['governet'];
                $sql .= " OR governet= 0 || gender IS NULL)";
            }

            
            if(isset($arrSearch['language']) && $arrSearch['language'])
            {
                $sql .= " AND (LOWER(language)='".strtolower($arrSearch['language'])."' ";
                 $sql .= "OR LOWER(language)='' )";
               
                 

            }
            if(isset($arrSearch['state']) && $arrSearch['state'])
            {
                $sql .= " AND (notification.state=".$arrSearch['state'];
                 $sql .= " OR notification.state= 0 || gender IS NULL )";
               
            }
             
        }
        if($registerdate)
        {
             $sql .= " AND ( DATE_FORMAT(notification.created_date, '%Y-%m-%d') >= '".$registerdate."' ) ";
        }
        $sql .= " ORDER BY notation_id DESC";
//       echo $sql;exit;
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }




}

?>
