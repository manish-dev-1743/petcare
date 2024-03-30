<?php
namespace App\Models;

use CodeIgniter\Model;

class BlogsModel extends Model
{
    protected $table = 'blogs';
    protected $allowedFields = ['title','banner_image','summary','description','created_at'];

}