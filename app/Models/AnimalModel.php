<?php
namespace App\Models;

use App\Models\PetModel;
use App\Models\AnimalImageModel;

use CodeIgniter\Model;

class AnimalModel extends Model
{
    protected $table = 'animals';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description','creator_id','status','pet_id','banner_image','age','breed','gender','size'];

    public function pet()
    {
        return $this->belongsTo('PetModel', 'pet_id');
    }

    public function animalimage()
    {
        return $this->hasMany('AnimalImageModel', 'animal_id');
    }
}