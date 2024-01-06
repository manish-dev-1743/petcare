<?php
namespace App\Controllers;

use App\Libraries\Authorization;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        if(session('token')){
            $token = session('token');
            $auth = new Authorization();
            $decoded = $auth->validateToken($token);
            // print_r($decoded);
        }


        // var_dump($decoded);die;
        
        return view('welcome_message');
    }

    public function register(){
        return view('auth/register',['title'=>'Sign Up']);
    }

    public function signup(){
        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[5]|max_length[50]',
            'email'     => 'required|valid_email|is_unique[user.email]',
            'phone'     => 'required|numeric|exact_length[10]', 
            'password'  => 'required|min_length[8]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d).+$/]',
        ];

        $validation->setRules($rules);

        if ($validation->withRequest($this->request)->run()) {
           
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $password = $this->request->getPost('password');
            $re_pass = $this->request->getPost('re-pass');
            if($password == $re_pass){
                $password = password_hash($password, PASSWORD_BCRYPT);

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password,
                    'type' => 1,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $users = new UserModel();
                $res = $users->add($data);
                if($res){
                    return redirect()->to('/login')->with('success','Successfully created an account. Please Login to Continue.');
                }else{
                    return redirect()->back()->withInput()->with('errors', ['something went wrong']);
                }

            }

        } else {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function login(){
        return view('auth/login',['title'=>'Login']);
    }

    public function dologin(){
        $validation = \Config\Services::validation();

        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required|min_length[8]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d).+$/]',
        ];

        $validation->setRules($rules);

        if ($validation->withRequest($this->request)->run()) {
            $email = $this->request->getPost('email');
            $user = new UserModel();
            $user_details = $user->findByEmail($email);
            if($user_details){
                $password = $this->request->getPost('password');
                if(password_verify($password,$user_details['password'])){
                    $expiry_date = date('Y-m-d H:i:s',strtotime('+1 days'));
                    $payload = array(
                        'id' => $user_details['id'],
                        'email' => $user_details['email'],
                        'name' => $user_details['name'],
                        'phone' => $user_details['phone'],
                        'type' => $user_details['type'],
                        'status' => $user_details['status'],
                        'expiry_date' => $expiry_date
                    );
                    $auth = new Authorization();
                    $token = $auth->genereateToken($payload);
                    $data = array(
                        'token' => $token,
                        'expiry_date' => $expiry_date
                    );
                    $res = $user->update($user_details['id'],$data);
                    if($res){
                        if($user_details['type'] == 1){
                            session()->set('token', $token);
                            return redirect()->to('/');
                        }else if($user_details['type'] == 0){
                            echo 'admin-login';die;
                        }else{
                            echo 'allies-login';die;
                        }
                    }
                }else{
                    return redirect()->back()->withInput()->with('errors', ['Enter correct password to continue !!']);
                }
            }else{
                return redirect()->back()->withInput()->with('errors', ['User not found. Please signup to continue!!']);
            }
            
        }else{
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


    }
}
