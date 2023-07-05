<?php namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model{
    
     protected $table = 'orders';
     protected $primaryKey = 'od_id';
     protected $allowedFields = ['od_id', 'od_userid', 'od_companyid', 'od_branchid', 'od_number', 'od_totalamount', 'od_saveamount', 'od_paidamount','od_point','od_description','od_recieptphoto','created_date'];


	public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='')
	{
		if($coutOnly)
		{
		    $sql = "SELECT COUNT(ad.od_id) as total_count FROM $this->table AS ad ";
		}
		else
		{
		    $sql = "SELECT ad.* FROM $this->table AS ad ";
		}
		$sql .= " ";
		$sql .= " WHERE 1 ";
		if(isset($searchArray['txtsearch']))
		{
		    $sql .= " AND ad.id LIKE '".$searchArray['txtsearch']."%' ";
		    // $sql .= " OR ad.phone LIKE '".$searchArray['txtsearch']."%' ";
		    // $sql .= " OR ad.admin_type LIKE '".$searchArray['txtsearch']."%' ";
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

}

?>
