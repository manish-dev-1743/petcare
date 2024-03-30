<?php
namespace App\Models;

use CodeIgniter\Model;

class DonationsModel extends Model
{
    protected $table = 'donations';
    protected $allowedFields = ['name','email','phone','amount','payment_status','signature','uuid'];

}