<?php namespace App\Models;

use CodeIgniter\Model;

class ChatStatusModel extends Model{
    
     protected $table = 'chat_status';
     protected $primaryKey = 'chat_id';  
     protected $allowedFields = ['senderid', 'receiverid'];



    public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
    {
        if($coutOnly)
        {
            $sql = "SELECT COUNT(ad.chat_id) as total_count FROM $this->table AS ad ";
        }
        else
        {
            $sql = "SELECT ad.* FROM $this->table AS ad ";
        }
        
        $sql .= " ";
        $sql .= " WHERE 1 ";
       

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
    
    public function checkChatstatus($senderid,$receiver)
    {
        $count = 0;
        if($senderid && $receiver)
        {
            
            $sql = "SELECT count(*) AS total_count FROM $this->table AS ad ";
            $sql .= " ";
            $sql .= " WHERE 1 ";
            $sql .= "  AND  senderid=".$senderid;
            $sql .= "  AND  receiverid=".$receiver;
            $query = $this->db->query($sql);
            $result = $query->getResult();
            $count = $result[0]->total_count;
        }
        return $count;
    }
    
    public function inserChatstatus($senderid='',$receiverid='')
    {
        if($senderid && $receiverid)
        {
            $chatObj = $this->where("senderid",$senderid)->where("receiverid",$receiverid)->find();
            if(!$chatObj)
            {
                $insertData = array("senderid"=>$senderid,"receiverid"=>$receiverid);
                $this->insert($insertData);
            }
        }
    }


}

?>
