<?php
namespace App\Models;


use CodeIgniter\Model;

class AdoptApprovalModel extends Model
{
    protected $table = 'adopt_approval';
    protected $allowedFields = ['adopt_id','response'];

}