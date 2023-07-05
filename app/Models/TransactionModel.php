<?php namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model{
    
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','customer_id', 'order_id','redeem_id','points','tr_totalpoint','tr_comments','tr_type']; 
    
    
    





 }
?>
