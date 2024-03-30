<?php
namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $allowedFields = ['user_id','type','uniq_id','created_at','seen'];

}