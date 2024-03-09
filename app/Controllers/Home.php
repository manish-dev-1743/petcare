<?php
namespace App\Controllers;

use App\Models\UserModel;

use App\Libraries\Authorization;
use App\Models\AdoptPetModel;
use App\Models\AnimalImageModel;
use App\Models\AnimalModel;
use App\Models\PetModel;
use App\Models\PetProductsModel;

class Home extends BaseController
{

    protected $curr_user;


    public function __construct()
    {
        if(session()->get('token') !== NULL){    
            $user = $this->authCheck(session()->get('token'));
            if ($user) {
                $this->curr_user = $user;
            } else {
                
                $this->curr_user = false;
            }
        }else{
            $this->curr_user = false; 
        }
    }

    public function index(): string
    {
        $category = new PetModel();
        $category = $category->where('status',1)->find();

        $products = new PetProductsModel();
        $products = $products->where('status',1)->orderBy('created_at','DESC')->limit(6)->find();

        return view('front/index',['title'=>'Home','category'=>$category,'products'=>$products]);
    }

    public function register(){
        return view('auth/register',['title'=>'Sign Up']);
    }

    public function alliesregister(){
        return view('auth/allies-register',['title'=>'Allies Register']);
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

            }else{
                return redirect()->back()->withInput()->with('errors', ['Password mismatched.']);
            }

        } else {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function alliessignup(){
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
            $re_email = $this->request->getPost('re-email');
            $phone = $this->request->getPost('phone');
            $password = $this->request->getPost('password');
            $re_pass = $this->request->getPost('re-pass');

            $images = $this->request->getFiles();
            
            $documents = array();
            foreach ($images['documents'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $path = 'assets/images/allies/';
            
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
            
                    // Use getClientFilename() to get the original file name
                    $newName = $img->getClientName();
            
                    // If you still want to use getRandomName(), you can do so
                    // $newName = $img->getRandomName();
            
                    $imagePath = $path . $newName;
            
                    // Move the file only if it hasn't been moved
                    $img->move($path, $newName);
                    
                    array_push($documents,$imagePath);
                }
            }
            if(empty($documents)){
                return redirect()->back()->withInput()->with('errors', ['Document upload required.']);
            }

            if($re_email == $email){
                if($password == $re_pass){
                    $password = password_hash($password, PASSWORD_BCRYPT);

                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'password' => $password,
                        'documents' => json_encode($documents),
                        'type' => 2,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $users = new UserModel();
                    $res = $users->add($data);
                    if($res){
                        return redirect()->to('/login')->with('success','Successfully created Allies Account. Please Login to Continue.');
                    }else{
                        return redirect()->back()->withInput()->with('errors', ['something went wrong']);
                    }

                }else{
                    return redirect()->back()->withInput()->with('errors', ['Password mismatched.']);
                }
            }else{
                return redirect()->back()->withInput()->with('errors', ['Email mismatched.']);
            }

        } else {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }


    public function login(){

        if(session()->get('token')){
            $data = $this->authCheck(session()->get('token'));
            if($data){
                if($data->type == '0'){
                    return redirect()->to('/admin/dashboard');
                }else if($data->type == '1'){
                    return redirect()->to('/profile');
                }else if($data->type == '2'){
                    return redirect()->to('/allies/dashboard');
                }
            }
        }
        
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
                            session()->set('token', $token);
                            return redirect()->to('/admin/dashboard');
                        }else{
                            session()->set('token', $token);
                            return redirect()->to('/admin/dashboard');
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

    public function logout(){
        if(session()->get('token')){
            session()->destroy();
        }
        return redirect()->to('/');
    }

    public function petcat($slug){
        $petcat = new PetModel();
        $petcat = $petcat->where('slug',$slug)->first();
        $animal = array();
        $title = 'NOT FOUND';
        if($petcat){
            $animals = new AnimalModel();
            $animal = $animals->where(['pet_id'=>$petcat['id'],'status'=>1])->orderBy('id','DESC')->find();
            $title = $petcat['name'];
            // $images = new AnimalImageModel();
            // foreach($animal as &$a){
                
            //     $a['images'] = $images->where('animal_id',$a['id'])->find();
            // }  
        }

        return view('front/petcat',['title'=>$title,'animal'=>$animal]);
    }

    public function petdata($cat_slug,$animal_id){
        $animals = new AnimalModel();
        $animal = $animals->where(['id'=>$animal_id,'status'=>1])->first();
        if($animal){
            $images = new AnimalImageModel();
            $animal['images'] = $images->where('animal_id',$animal_id)->find();
            $title = $animal['name'];
            $user  = new UserModel();
            $seller = $user->where('id',$animal['creator_id'])->first();

            if($this->curr_user){
                $adpet = new AdoptPetModel();
                $exists = $adpet->where(['user_id'=>$this->curr_user->id,'pet_id'=>$animal['id']])->first();
                if($exists){
                    $sent = true;
                }else{
                    $sent = false;
                }
    
            }
        }else{
            $animal = array();
            $seller = array();
            $title = 'NOT FOUND';
            $sent= false;
        }
        
        return view('front/petdetails',['title'=>$title,'animal'=>$animal,'seller'=>$seller,'sent'=>$sent]);
    }

    public function productdetail($prod_id){
        $prodouct_details = new PetProductsModel();
        $prodouct_details = $prodouct_details->where(['id'=>$prod_id,'status'=>1])->first();
        if(!$prodouct_details){
            $prodouct_details = array();
            $title = 'NOT FOUND';
        }else{
            
            $title = $prodouct_details['title'];
        }
        return view('front/productdetail',['title'=>$title,'product'=>$prodouct_details]);
    }
}
