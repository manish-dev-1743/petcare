<?php
namespace App\Controllers;

use App\Models\UserModel;

use App\Libraries\Authorization;
use App\Models\AdoptPetModel;
use App\Models\AnimalImageModel;
use App\Models\AnimalModel;
use App\Models\BlogsModel;
use App\Models\DonationsModel;
use App\Models\NotificationModel;
use App\Models\PetModel;
use App\Models\PetProductsModel;
use PHPUnit\Util\Json;

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
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $users = new UserModel();
                    $res = $users->add($data);
                    if($res){
                        return redirect()->to('/login')->with('success','Successfully created Allies Account. You can login from your account after admin verfires it within 24 hrs.');
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
            if($user_details && $user_details['status'] == 1){
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
                return redirect()->back()->withInput()->with('errors', ['User not found or your usermail have been terminated!!']);
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
            }else{
                $sent =false;
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

    public function donateNow(){
        
        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'amount' => 'required',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $postData = $request->getPost();
        $generated_uuid = $this->generateUUID();
        $generated_signature = $this->generateSignatiure($postData['amount'],$generated_uuid);

        if(!empty($postData)){
            $data = array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'phone' => $postData['number'],
                'payment_status' => 0,
                'amount' => $postData['amount'],
                'uuid' => $generated_uuid,
                'signature' => $generated_signature,
               
            );
            $payments = new DonationsModel();
            $payments->insert($data);       
            $this->esewaPayment($postData['amount'],$generated_signature,$generated_uuid);
        }
       
    }



    protected function generateUUID(){
        return 'DONATION_'.time();
    }

    protected function generateSignatiure($amt,$uid){
        $message = 'total_amount='.$amt.',transaction_uuid='.$uid.',product_code=EPAYTEST';
        $secret = '8gBm/:&EnhH.1/q';
        $s = hash_hmac('sha256', "$message", "$secret", true);
        return base64_encode($s);
    }

    protected function esewaPayment($amount,$signature,$uuid){
        // Set the URL for the cURL request
        $url = "https://rc-epay.esewa.com.np/api/epay/main/v2/form";

        // Set the form data
        $formData = [
            'amount' => intval($amount),
            'tax_amount' => 0,
            'total_amount' => intval($amount),
            'transaction_uuid' => $uuid,
            'product_code' => 'EPAYTEST',
            'product_service_charge' => 0,
            'product_delivery_charge' => 0,
            'success_url' => base_url('donation/success'),
            'failure_url' => base_url('donation/success'),
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'signature' => $signature,
            'secret' => '8gBm/:&EnhH.1/q'
        ];


        // Initialize cURL session
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $redirect_url = null;
        if ($response) {
            list($headers, $body) = explode("\r\n\r\n", $response, 2);
            $data = (!empty($body))?$body:$headers;
            $exploded_body = explode("\r\n", $data);
            foreach ($exploded_body as $item) {
                if (strpos($item, "Location:") !== false) {
                    $redirect_url = $item;
                }
            }
            if($redirect_url){
                header($redirect_url);
                die;
            }
        }
    }

    public function donationsuccess(){
        $token = (isset($_GET['data']) && $_GET['data'] != '')?$_GET['data']:false;
        if($token){
            $payload = json_decode(base64_decode($token));

            $payments = new DonationsModel();
            $payments_details = $payments->where('uuid',$payload->transaction_uuid)->first();
            if($payments_details){
                $res = file_get_contents('https://uat.esewa.com.np/api/epay/transaction/status/?product_code=EPAYTEST&total_amount='.intval($payments_details['amount']).'&transaction_uuid='.$payload->transaction_uuid);
                $res = json_decode($res);
                if($res->status = 'COMPLETE'){
                    
                    $payments->update($payments_details['id'],['payment_status' => 1]);
                }
            }
            
        }
        return redirect()->to('/')->with('success', 'Successfully made donations.');    
    }

    public function searchpet(){
        $request = service('request');

        $formData = $request->getGet();
        
        $petlist = new AnimalModel();
        if(isset($formData['petname']) && $formData['petname'] != ''){
            $petlist->like('name',$formData['petname']);
        }
        if(isset($formData['pet']) && !empty($formData['pet'])){ 
            
           $petlist->whereIn('pet_id',$formData['pet']);
        }

        if(isset($formData['age']) && !empty($formData['age'])){ 
            $petlist->like('age',$formData['age']);
        }

        if(isset($formData['breed']) && !empty($formData['breed'])){ 
            $petlist->like('breed',$formData['breed']);
        }

        if(isset($formData['gender']) && !empty($formData['gender'])){ 
            $petlist->where('gender',$formData['gender']);
        }

        $list = $petlist->find();

        $pet_category = new PetModel();
        $pet_category = $pet_category->where('status',1)->findAll();

        return view('front/search',['title'=>'Search Results : '.$formData['petname'],'list'=>$list,'formdata'=>$formData,'pet_category'=>$pet_category]);
    }

    public function blogs(){
        $blog = new BlogsModel();

        $count = $blog->countAllResults();

        if(isset($_GET['page']) && $_GET['page'] > 1){
            $start = $_GET['page'] + 1;
            $end =  $_GET['page'] + 6;
            $offset = (int) $_GET['page'] * 6;
            $page = $_GET['page'];
        }else{
            $offset = 0;
            $page = 1;
            $start = 1;
            $end = ($count < 6)?$count:6;
        }
        $blogs = $blog->orderBy('created_at','DESC')->limit(6,$offset)->find();

        $pagination = array(
            'curr_page' => $page,
            'blog_list' => $count,
            'pages' => ceil($count/6),
            'start' => $start,
            'end' => $end

        );
        return view('front/blogs',['title'=>'Blogs','list'=>$blogs,'pagination'=>$pagination]);
    }

    public function blogdetail($id){
        $blog = new BlogsModel();
        $blog = $blog->where('id',$id)->first();
        return view('front/blogdetail',['title'=>$blog['title'],'blog'=>$blog]);
    }

    public function getNotification(){
        if(session()->get('token') !== NULL){  
            $notification = new NotificationModel();
            $user = $this->authCheck(session()->get('token'));
            $list = array();
            if($user){
                $notification_list = $notification->where('user_id',$user->id)->orderBy('created_at','DESC')->findAll();

                foreach($notification_list as $nl){
                    if($nl['type'] == 'animal_add'){
                        $animal = new AnimalModel();
                        $animal =$animal->where('id',$nl['uniq_id'])->first();
                        $pet = new PetModel();
                        $pet = $pet->where('id',$animal['pet_id'])->first();
                        $list[] = array(
                            'message' => $animal['breed'].", ".$animal['name']." is up for adoption.",
                            'link' => '/pets/'.$pet['slug'].'/'.$animal['id']    
                        );
                    }else if($nl['type'] == 'blog_add'){
                        $blog = new BlogsModel();
                        $blog = $blog->where('id',$nl['uniq_id'])->first();
                        $list[] = array(
                            'message' => 'A new blog - ' .$blog['title'],
                            'link' => 'blog/detail/'.$nl['uniq_id']
                        );
                    }else if($nl['type'] == 'adopt_pet'){
                        $animal = new AnimalModel();
                        $animal =$animal->where('id',$nl['uniq_id'])->first();

                        $list[] = array(
                            'message' => 'An adoption request has been sent to you for '.$animal['name'],
                            'link' => 'admin/animal/adoption/'.$nl['uniq_id']
                        );
                    }
                }
                echo json_encode(array('status'=>200,'data'=>$list));
            }else{
                echo json_encode(array('status'=>400,'message'=>'login required'));
            }
        }else{
            echo json_encode(array('status'=>400,'message'=>'login required'));
        }
    }

    public function about(){
        return view('front/about',['title'=>'About']);
    }
}
