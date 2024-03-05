<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymentsModel extends Model
{
    protected $table = 'payments';
    protected $allowedFields = ['user_id','cart_ids','location','payment_type','payment_status','amount','signature','uuid'];

}