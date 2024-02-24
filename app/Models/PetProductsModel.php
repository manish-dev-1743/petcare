<?php
namespace App\Models;


use CodeIgniter\Model;

class PetProductsModel extends Model
{
    protected $table = 'pet_products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title','description','created_at','status','pet_id','banner_image','quantity','price'];


}