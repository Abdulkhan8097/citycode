<?php 

namespace App\Models;

use CodeIgniter\Model;

class NearNotification extends Model{
    
    protected $table = 'nearNotification';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','branch_id','company_id','user_id','notify_status'];

   


 }
?>
