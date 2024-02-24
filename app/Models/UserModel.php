<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';

    protected $allowedFields = ['name', 'email','phone','documents', 'password','type','token','status','expiry_date','created_at','updated_at'];

    public function add($data){
        return $this->insert($data);
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function updateUser($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }
}