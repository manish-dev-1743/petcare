<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $curr_user;

    public function __construct()
    {
        if(session()->get('token') !== NULL){    
            $user = $this->authCheck(session()->get('token'));
            if ($user) {
                $this->curr_user = $user;
            } else {
                header('Location: '.base_url('login'));
                exit;
            }
        }else{
            header('Location: '.base_url('login'));
            exit;
        }
    }

    public function profile(){
        $user = new UserModel();
        $user = $user->where('id',$this->curr_user->id)->first();
        $title = 'Profile';

        return view('auth/profile',['title' => $title,'user' => $this->curr_user,'user_details' => $user]);

    }
}