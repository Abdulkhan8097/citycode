<?php

namespace App\Models;
use CodeIgniter\Model;

class SiteModel extends Model {

    protected $table = 'sitevariable';
    protected $primaryKey = 'st_id';

    protected $allowedFields = ['st_id', 'st_name', 'st_arb_name', 'st_group'];
    

}

?>
