<?php
namespace App\Models;

use App\Models\AnimalModel;
use CodeIgniter\Model;

class PetModel extends Model
{
    protected $table = 'pets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','slug','banner_image','status'];

    public function getAll(){
        return $this->findAll();
    }

    public function animal()
    {
        return $this->hasMany('AnimalModel', 'pet_id');
    }
}