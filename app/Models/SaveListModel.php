<?php
namespace App\Models;

use CodeIgniter\Model;

class SaveListModel extends Model
{
    protected $table = 'save_list';
    protected $allowedFields = ['pet_id','user_id'];

}