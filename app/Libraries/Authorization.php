<?php 
namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authorization{


    protected $key = 'example_key';

    public function genereateToken($data){
        $jwt = JWT::encode($data, $this->key, 'HS256');
        return $jwt;
    }

    public function validateToken($jwt){
        $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
        if($decoded){
            return $decoded;
        }
        return false;
    }
}