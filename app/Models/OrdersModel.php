<?php namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model{
    
     protected $table = 'orders';
     protected $primaryKey = 'od_id';
     protected $allowedFields = ['od_id', 'od_userid', 'od_companyid', 'od_branchid', 'od_number', 'product_id','od_totalamount', 'od_saveamount', 'od_paidamount','od_point', 'od_discount', 'od_description','od_recieptphoto','created_date', 'image', 'status', 'notification_id', 'usertransactioncode', 'usertransactionstatus','citycode_commission','reddem_point','receiptimg','receipt_no','coupon_purchase_id','coupon_id'];



 	public function getOrdersApi($id) {
        $sql = "SELECT ad.*, DATE_FORMAT(ad.created_date,'%d-%m-%Y'), ST.name,CD.company_name, CD.picture ,BR.branch_name,coupon.coupon_amount,coupon.coupon_price FROM $this->table AS ad ";
        $sql .= " LEFT JOIN customer as ST ON (ad.od_userid = ST.id) ";
        $sql .= " LEFT JOIN company_details as CD ON (ad.od_companyid = CD.id) ";
        $sql .= " LEFT JOIN branch as BR ON (ad.od_branchid = BR.branch_id) ";
        $sql .= " LEFT JOIN coupon_purchase as cp ON (ad.coupon_purchase_id = cp.id) ";
        $sql .= " LEFT JOIN coupon as coupon ON (cp.coupon_id = coupon.id) ";
        $sql .= " WHERE ST.id ='" . $id . "' "; 
        // $sql .= " WHERE ST.id ='" . $id . "' AND  ad.usertransactionstatus = 'false' "; 
        $sql .= " ORDER BY od_id DESC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }



 public function getlast($uid) {
        $sql = "SELECT ad.*, DATE_FORMAT(ad.created_date,'%d-%m-%Y'), ST.name,CD.company_name, CD.picture,CD.company_arb_name,BR.branch_name,BR.arb_branch_name FROM $this->table AS ad ";
        $sql .= " LEFT JOIN customer as ST ON (ad.od_userid = ST.id) ";
        $sql .= " LEFT JOIN company_details as CD ON (ad.od_companyid = CD.id) ";
        $sql .= " LEFT JOIN branch as BR ON (ad.od_branchid = BR.branch_id) ";

        $sql .= " WHERE od_userid ='" . $uid . "' "; 
        $sql .= " ORDER BY od_id DESC";
        
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }
	
	
	public function reportdetail($id) {
        $sql = "SELECT ad.*, ST.username, ST.city_code, ST.vip_code, CD.company_name, CD.picture ,BR.branch_name FROM $this->table AS ad ";
        $sql .= " LEFT JOIN customer as ST ON (ad.od_userid = ST.id) ";
        $sql .= " LEFT JOIN company_details as CD ON (ad.od_companyid = CD.id) ";
        $sql .= " LEFT JOIN branch as BR ON (ad.od_branchid = BR.branch_id) ";
       $sql .= " WHERE ad.od_id ='" . $id . "' "; 
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result;
    }


  public function generateusercode() {
        helper('text');
        $codetrue = false;
        do {            
            $Letter = random_string('alpha', 2, 'nozero', 4);
            $Number = random_string('nozero', 4);
            $usercode = strtoupper($Letter).$Number;      
          } while ($codetrue);

        return $usercode;
    }



public function getData($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
	{
	
		
                $sql  = $this->generateQuery($searchArray, $offset, $limit,$coutOnly,$showQuery);
                
//		echo $sql;

		$query = $this->db->query($sql);
		$result = $query->getResult();

		if($coutOnly)
		{
		    return $result ? $result[0]->total_count : 0;
		}
                else if(isset($searchArray['sumcommision']))
                {
                    return $result ? $result[0]->total_commision : 0;
                }
                else if(isset($searchArray['sumpaidamount']))
                {
                    return $result ? $result[0]->total_paidamount : 0;
                }

		return $result;
	}


	
    
    
    public function generateQuery($searchArray=array(), $offset='', $limit='',$coutOnly='',$showQuery='')
    {
        
        if(isset($searchArray['sumpaidamount']))
        {
           
             $sql = "SELECT round(sum(ad.od_paidamount),3) as total_paidamount FROM $this->table AS ad ";
        }
        else if(isset($searchArray['sumcommision']))
        {
           
             $sql = "SELECT round(sum(ad.citycode_commission),3) as total_commision FROM $this->table AS ad ";
        }
        
        else if($coutOnly)
		{
		    $sql = "SELECT COUNT(ad.od_id) as total_count FROM $this->table AS ad ";
		}
		else
		{
		   // $sql = "SELECT DISTINCT ad.*,cd.company_name,cd.email,cd.mobile,branch.branch_name,customer.end_date, customer.name,customer.mobile,customer.gender, customer.city_code, customer.vip_code, customer.stateid, customer.cityid, code.coupon_type, code.start_date, code.end_date, ST.state_name,ST.arb_state_name,CT.city_name,CT.city_arb_name,CN.country_enNationality,CN.country_arNationality FROM $this->table AS ad  ";			
		    $sql = "SELECT  ad.*,cd.company_name,cd.email,cd.mobile,branch.branch_name,customer.end_date, customer.name,customer.mobile,customer.gender, customer.city_code, customer.vip_code, customer.stateid, customer.cityid,  ";			
		    $sql .= "  ST.state_name,ST.arb_state_name,CT.city_name,CT.city_arb_name,CN.country_enNationality,CN.country_arNationality  ";			
		//    $sql .= " code.coupon_type, code.start_date, code.end_date  ";			
		    $sql .= "  FROM $this->table AS ad  ";			
		}
		
		$sql .= " LEFT JOIN company_details as cd ON (cd.id = ad.od_companyid) ";
	//	$sql .= " LEFT JOIN company_code_details as code ON (ad.od_companyid =code.company_id) ";
                 $sql .= " LEFT JOIN branch ON ( ad.od_branchid = branch.branch_id ) ";
		$sql .= " LEFT JOIN customer ON (ad.od_userid = customer.id) ";
		
		$sql .= " LEFT JOIN states as ST ON (customer.stateid = ST.state_id) ";
                $sql .= " LEFT JOIN cities as CT ON (customer.cityid = CT.city_id) ";
                $sql .= " LEFT JOIN countries as CN ON (customer.nationality = CN.country_id) ";
		
		//$sql .= " ";
        //$sql .= " WHERE usertransactionstatus='false' "; 

		$sql .= " WHERE 1 ";
		if(isset($searchArray['txtsearch']))
		{
                        $sql .= " AND ad.od_id LIKE '".$searchArray['txtsearch']."%' ";
			//$sql .= " OR ad.od_companyid LIKE '" . $searchArray['txtsearch'] . "%' ";
			$sql .= " OR cd.company_name LIKE '" . $searchArray['txtsearch'] . "%' ";
			$sql .= " OR branch.branch_name LIKE '" . $searchArray['txtsearch'] . "%'"; 
                        $sql .= " OR customer.username LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.end_date LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.mobile LIKE '" . $searchArray['txtsearch'] . "%' ) ";
                        $sql .= " OR customer.gender LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.vip_code LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.city_code LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.stateid LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR customer.cityid LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR code.coupon_type LIKE '" . $searchArray['txtsearch'] . "%' ";
                        $sql .= " OR code.end_date LIKE '" . $searchArray['txtsearch'] . "%' )";		            
		}
		
		if (isset($searchArray['city_code'])) {
                    $sql .= " AND customer.city_code = '" . $searchArray['city_code'] . "' ";
                 }
		
		if (isset($searchArray['vip_code'])) {
                    $sql .= " AND customer.vip_code = '" . $searchArray['vip_code'] . "' ";
                 }
		
		if (isset($searchArray['gender'])) {
                    $sql .= " AND customer.gender = '" . $searchArray['gender'] . "' ";
                 }
		
		if (isset($searchArray['mobile'])) {
                $sql .= " AND customer.mobile = '" . $searchArray['mobile'] . "' ";
                }
		
		 if (isset($searchArray['stateid'])) {
                    $sql .= " AND customer.stateid = '" . $searchArray['stateid'] . "' ";
                }
                if (isset($searchArray['cityid'])) {
                    $sql .= " AND customer.cityid = '" . $searchArray['cityid'] . "' ";
                }
		
                //this is for 
//		if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
//                    $sql .= " AND ( DATE_FORMAT(customer.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
//                    $sql .= " AND DATE_FORMAT(customer.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
//                }
                
                if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
                    $sql .= " AND ( DATE_FORMAT(ad.created_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
                    $sql .= " AND DATE_FORMAT(ad.created_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
                }
		
		if (isset($searchArray['company_name']) && $searchArray['company_name']!='city_code') {
                    $sql .= " OR cd.company_name = '" . $searchArray['company_name'] . "' ";
                }

//                if (isset($searchArray['company_name']) && $searchArray['company_name']=='city_code' ) {
//                        $sql .= " OR cd.id <>'' ";
//                }
                
                if (isset($searchArray['company_id']) && $searchArray['company_id'] && $searchArray['company_id']!='city_code') {
            
                    if(is_array($searchArray['company_id']))
                    {
                        $in_array = implode("','",$searchArray['company_id']);

                         $sql .= " AND ad.od_companyid IN ('" . $in_array . "') ";
                    }
                    else
                    {
                     $sql .= " AND ad.od_companyid = '" . $searchArray['company_id'] . "' ";
                    }

                }
		
                if (isset($searchArray['branch_id']) && $searchArray['branch_id']) {
            
                    if(is_array($searchArray['branch_id']))
                    {
                        $in_array = implode("','",$searchArray['branch_id']);

                         $sql .= " AND ad.od_branchid IN ('" . $in_array . "') ";
                    }
                    else
                    {
                     $sql .= " AND ad.od_branchid = '" . $searchArray['branch_id'] . "' ";
                    }

                }
		if (isset($searchArray['coupon_type'])) {
                    $sql .= " OR code.coupon_type = '" . $searchArray['coupon_type'] . "' ";
                }
		
//		if ((isset($searchArray['start_date'])) && (isset($searchArray['end_date']))) {
//                    $sql .= " OR ( DATE_FORMAT(code.start_date, '%Y-%m-%d') >= '".$searchArray['start_date']."' ";
//                    $sql .= " OR DATE_FORMAT(code.end_date, '%Y-%m-%d') <= '".$searchArray['end_date']."' ) "; 
//                }

				
		// $sql .= " AND ad.usertransactionstatus='false' ";
                
//                if(isset($searchArray['sumcommision']) && $coutOnly=='')
//                {
//                  //  $sql .= "  GROUP BY od_id ORDER BY od_id DESC";
//                }
                  $sql .= "   ORDER BY od_id DESC";
		if($limit)
		{
		    $sql .= " LIMIT $offset,$limit";
		}
                
                if($showQuery)
                { 
                    echo $sql;
                }
//                 echo $sql;die;
                return $sql ;
    }


    public function getMostPopularcode($searchArray=array(),$offset="",$limit="",$showQuery="")
    {
        
        $sql  = "SELECT COUNT(ad.od_userid) as total_userorder,ad.od_userid FROM $this->table AS ad ";
        
        $sql .= " GROUP BY ad.od_userid  ";
        $sql .= " ORDER BY total_userorder DESC ";
        if($limit)
          {
              $sql .= " LIMIT $offset,$limit";
          }
          
          if($showQuery)
                { 
                    echo $sql;
                }
       
        $query = $this->db->query($sql);
        $result = $query->getResult();
         return $result;
		
    }
    
    
    public function do_upload($image,$order_id,$receipt_no){
        $sql = "update $this->table set receiptimg='".$image."',receipt_no=".$receipt_no." WHERE od_id=".$order_id;
        $query = $this->db->query($sql);
        //$result = $query->getRow();
        //echo "<pre>";print_r($result);exit;
        return $query;
    }
    
    public function todayTrasactionCost()
    {
        //$sql="SELECT SUM(od_totalamount) AS TodaysSale FROM $this->table WHERE STR_TO_DATE('created_date', '%d/%m/%Y') > CURDATE( )";
        $TodayDate=date('Y-m-d');
        $sql1="SELECT SUM(od_totalamount) AS TodaysSale From $this->table where 'created_date' >= STR_TO_DATE(SYSDATE(), '%Y-%m-%d')";
        $sql="SELECT SUM(od_totalamount) AS TodaysSale From $this->table where 'created_date' >=". $TodayDate;
        //$sql = "SELECT count(id) as 'ActiveCompany' from $this->table WHERE ";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        //$result = $query->getResult();

        //echo "<pre>";print_r($sql);exit;
        return $result;
    }

    public function geteditS($od_id){ 
     
     $this->select('orders.*');
     $this->where('orders.od_id',$od_id);
     $result = $this->get()->getRowArray();
     return $result;
    }
    

}

?>

