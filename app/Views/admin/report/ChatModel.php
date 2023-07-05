<?php namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model{
    
     protected $table = 'chat';
     protected $primaryKey = 'id';  
     protected $allowedFields = ['id', 'category_id', 'chat_type','send_by', 'group_id', '    list_id', 'sender_id', 'receiver_id', 'msg', 'link', 'image','video','video_thumb','doc','caption', 'lat', 'long','type','file_size','seen_status','app_db_id','created_date','date_string','new_date_created','msg_id'];



	public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.*, IF(ad.send_by='company',(SELECT branch.branch_name FROM branch where branch.branch_id=ad.sender_id),(SELECT branch.branch_name FROM branch where branch.branch_id=ad.receiver_id)) AS branch_name , ";
            $sql .= " IF(ad.send_by='customer',(SELECT customer.name FROM customer where customer.id=ad.sender_id),(SELECT customer.name FROM customer where customer.id=ad.receiver_id)) AS customer_name  ";
            $sql .= " FROM $this->table AS ad ";
        }
        
        
        $sql .= " ";
        $sql .= " WHERE 1 ";
        if(isset($searchArray['txtsearch']))
        {
          //  $sql .= " AND ad.email LIKE '".$searchArray['txtsearch']."%' ";
          
        }
        
        if (isset($searchArray['sender_id']) && $searchArray['sender_id']) {
            
            if(is_array($searchArray['sender_id']))
            {
                $in_array = implode("','",$searchArray['sender_id']);
                
                 $sql .= " AND ad.sender_id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.sender_id = '" . $searchArray['sender_id'] . "' ";
            }
           
        }
        
        if (isset($searchArray['receiver_id']) && $searchArray['receiver_id']) {
            
            if(is_array($searchArray['receiver_id']))
            {
                $in_array = implode("','",$searchArray['receiver_id']);
                
                 $sql .= " AND ad.receiver_id IN ('" . $in_array . "') ";
            }
            else
            {
             $sql .= " AND ad.receiver_id = '" . $searchArray['receiver_id'] . "' ";
            }
           
        }
        
        if (isset($searchArray['send_by']) && $searchArray['send_by']) {
             $sql .= " AND ad.send_by = '" . $searchArray['send_by'] . "' ";
            }
            
            if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }
           
          if (!empty($searchArray['company_id']) || !empty($searchArray['branch_id'])) {
              $sql .= " GROUP BY receiver_id";
          }
        
       $sql .= " ORDER BY id DESC";

        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }
        
        if($showQuery)
        {
           echo  $sql;
        }
 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        
        if($coutOnly)
        {
            return $result[0]->total_count;
        }

        return $result;
    }

    
    public function getBothChatData($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
    {
        
            $sql = "SELECT ad.*, IF(ad.send_by='company',(SELECT branch.branch_name FROM branch where branch.branch_id=ad.sender_id),(SELECT branch.branch_name FROM branch where branch.branch_id=ad.receiver_id)) AS branch_name , ";
            $sql .= " IF(ad.send_by='customer',(SELECT customer.name FROM customer where customer.id=ad.sender_id),(SELECT customer.name FROM customer where customer.id=ad.receiver_id)) AS customer_name  ";
            $sql .= " FROM $this->table AS ad ";
            $sql .= " WHERE ad.sender_id = '" . $searchArray['sender_id'] . "' ";
            $sql .= " AND ad.receiver_id = '" . $searchArray['receiver_id'] . "' ";
            
             $sql .=  " UNION ";
            $sql .= " SELECT ad.*, IF(ad.send_by='company',(SELECT branch.branch_name FROM branch where branch.branch_id=ad.sender_id),(SELECT branch.branch_name FROM branch where branch.branch_id=ad.receiver_id)) AS branch_name , ";
            $sql .= " IF(ad.send_by='customer',(SELECT customer.name FROM customer where customer.id=ad.sender_id),(SELECT customer.name FROM customer where customer.id=ad.receiver_id)) AS customer_name  ";
            $sql .= " FROM $this->table AS ad ";
            $sql .= " WHERE ad.sender_id = '" . $searchArray['receiver_id'] . "' ";
            $sql .= " AND ad.receiver_id = '" . $searchArray['sender_id'] . "' ";
       
             $sql .= " ORDER BY id DESC";

            
        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }
        
        if($showQuery)
        {
           echo  $sql;
        }
 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        if($coutOnly)
        {
            
           return count($result);
        }
        

        return $result;
    }
    
    
     public function getChatData($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
    {
        
            $sql = "SELECT ad.*, B.branch_name,C.name ";
            $sql .= " FROM $this->table AS ad ";
            $sql .= " LEFT JOIN branch B ON (ad.sender_id=B.branch_id) ";
            $sql .= " LEFT JOIN customer C ON(ad.receiver_id=C.id) ";
            $sql .= " WHERE ad.send_by='company' ";
            
            
             if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }
           
           if ((isset($searchArray['company_id'])) && (isset($searchArray['company_id']))) {
            $sql .= " AND B.company_id= '".$searchArray['company_id']."' ";
           }
           
           if ((isset($searchArray['branch_id'])) && (isset($searchArray['branch_id']))) {
            $sql .= " AND B.branch_id= '".$searchArray['branch_id']."' ";
           }
           
            $sql .= " GROUP by ad.receiver_id ";
            
             $sql .=  " UNION ";
            $sql .= " SELECT ad.*, B.branch_name,C.name ";
            $sql .= " FROM $this->table AS ad ";
            $sql .= "  LEFT JOIN branch B ON (ad.receiver_id=B.branch_id) ";
            $sql .= "  LEFT JOIN customer C ON(ad.sender_id=C.id) ";
            $sql .= "  WHERE ad.send_by='customer'   ";
            
             if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
            $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
             $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
           }
           
            if ((isset($searchArray['company_id'])) && (isset($searchArray['company_id']))) {
            $sql .= " AND B.company_id= '".$searchArray['company_id']."' ";
           }
           
            if ((isset($searchArray['branch_id'])) && (isset($searchArray['branch_id']))) {
            $sql .= " AND B.branch_id= '".$searchArray['branch_id']."' ";
           }
           
            $sql .= "   GROUP BY ad.receiver_id  ";
       
             
           
           
             $sql .= " ORDER BY id DESC";

        if($limit)
        {
            $sql .= " LIMIT $offset,$limit";
        }
        
        if($showQuery)
        {
           echo  $sql;
        }
 
        $query = $this->db->query($sql);
        $result = $query->getResult();
        if($coutOnly)
        {
            
           return count($result);
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

    public function getUserChat($id)
    {
        $sql = "SELECT sender_id from $this->table WHERE receiver_id='".$id."' GROUP BY `sender_id`";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        //echo "<pre>";print_r($result);exit;
        return $result;
    }

    public function getUserCompanyChat($id)
    {
        $sql = "SELECT  receiver_id, created_date from $this->table WHERE sender_id='".$id."' GROUP BY `receiver_id` ORDER BY created_date desc";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        //echo "<pre>";print_r($result);exit;
        return $result;
    }
    
    public function getmessagecount($userid,$send_by="",$messagetype='unseen')
    {
         $sql = "SELECT COUNT(ad.id) as total_count FROM $this->table AS ad ";
         $sql .= " ";
         $sql .= " WHERE 1 ";
         $sql .= " AND ad.seen_status = '".$messagetype."' ";
         $sql .= " AND ad.send_by = '".$send_by."' ";
         $sql .= " AND ad.receiver_id = '".$userid."' ";
         
         $query = $this->db->query($sql);
        $result = $query->getResult();
        
        return $result[0]->total_count;
    }
    
    
   


}

?>
