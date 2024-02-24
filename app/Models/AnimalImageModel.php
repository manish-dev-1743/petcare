<?php
namespace App\Models;

use App\Models\AnimalModel;
use CodeIgniter\Model;

class AnimalImageModel extends Model
{
    protected $table = 'animal_image';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image','animal_id'];

    public function animal()
    {
        return $this->belongsTo('AnimalModel', 'animal_id');
    }

}