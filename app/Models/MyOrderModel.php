<?php
namespace App\Models;

use CodeIgniter\Model;

class MyOrderModel extends Model
{
    protected $table = 'my_order';
    protected $allowedFields = ['product_ids','user_id','quantity','amount','is_paid','delivery_date'];

}