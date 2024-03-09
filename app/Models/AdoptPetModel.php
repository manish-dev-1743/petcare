<?php
namespace App\Models;


use CodeIgniter\Model;

class AdoptPetModel extends Model
{
    protected $table = 'adopt_pet';
    protected $allowedFields = ['fullname','user_id','number','email','pet_id','home_address','ownorRent','landlordPermission','ownedPetsBefore','experienceDescription','adoptionReason','openToSpecialNeeds','created_at','seen'];

}