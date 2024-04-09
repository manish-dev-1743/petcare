<?php

namespace App\Controllers;

use App\Models\BlogsModel;
use App\Models\DonationsModel;
use App\Models\NotificationModel;
use App\Models\PetModel;
use App\Models\PetProductsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Request;

class Admin extends BaseController
{

    protected $curr_user;
    public function __construct()
    {
        if(session()->get('token') !== NULL){    
            $user = $this->authCheck(session()->get('token'));
            if ($user) {
                if ($user->type != '0') {
                    header('Location: '.base_url('login'));
                    exit(); 
                }
                $this->curr_user = $user;
            } else {
                header('Location: '.base_url('login'));
                exit(); 
            }
        }else{
            header('Location: '.base_url('login'));
            exit(); 
        }
    }

    public function index()
    {
       return view('admin/dashboard',['user' => $this->curr_user]);
    }

    public function pets(){

        $pets = new PetModel(); 
        $pets = $pets->findAll();
        return view('admin/pets',['user' => $this->curr_user,'pets'=>$pets]);
    }

    public function petsdata(){
        $pet = array();
        if(isset($_GET['id'])){
            $pet = new PetModel();
            $pet = $pet->where('id',$_GET['id'])->find();
        }
        return view('admin/petsadd',['user' => $this->curr_user,'pet'=>$pet]);
    }

    public function dopetupdate(){
        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required',
            'slug' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $request->getPost('name'),
            'slug' => $request->getPost('slug'),
            'status' => ($request->getPost('status') && $request->getPost('status') == 'on') ? 1 : 0
        ];
        
        if ($request->getFile('banner_image')->getPath() != '') {
            $path = 'assets/images/pets/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $image = $request->getFile('banner_image');
            $imageName = time() . '_' . $image->getClientName();
            $image->move($path, $imageName);
            $imagePath = $path . $imageName;
            $data['banner_image'] = $imagePath;
        }
        $pet = new PetModel();
        if($request->getPost('id') && $request->getPost('id') != ''){
            $pet->update($request->getPost('id'),$data);
        }else{
            $pet->insert($data);
        }
        return redirect()->to('admin/pets')->with('success','Successfull Inserted Pet.');
    }

    public function deletePet(){

        if($_GET['id'] && $_GET['id'] != ''){
            $id = $_GET['id'];
            $pet = new PetModel();
            $petdata = $pet->where('id',$id)->first();
            if($petdata && $petdata['banner_image'] != ''){
                unlink('./'.$petdata['banner_image']);
            }
            $pet->where('id',$id)->delete();
        }
        return redirect()->to('admin/pets')->with('success','Successfull Deleted Pet.');
    }

    public function donationList(){
        $list = new DonationsModel();
        $list = $list->where('payment_status',1)->orderBy('id','DESC')->find();
        return view('admin/donations',['user' => $this->curr_user,'list'=>$list]);
    }

    public function productlist(){
        $pet = new PetProductsModel();  
        $pet = $pet->findAll();
        return view('admin/productlist',['user' => $this->curr_user,'products'=>$pet]);
    }

    public function productdata(){
        $pet = array();
       
        if(isset($_GET['id'])){
            $pet = new PetProductsModel();
            $pet = $pet->where('id',$_GET['id'])->find();
        }
        $pet_cat = new PetModel();
        $pet_cat = $pet_cat->where('status !=',0)->find();
        return view('admin/productadd',['user' => $this->curr_user,'product'=>$pet,'pet_cat' => $pet_cat]);
    }

    public function doproductupdate(){

        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'title' => 'required',
            'description' => 'required',
            'pet_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
       
        $data = [
            'title' => $request->getPost('title'),
            'description' => $request->getPost('description'),
            'status' => ($request->getPost('status') && $request->getPost('status') == 'on') ? 1 : 0,
            'pet_id' => $request->getPost('pet_id'),
            'creator_id' => $this->curr_user->id,
            'price' => $request->getPost('price'),
            'quantity' => $request->getPost('quantity')

        ];
        
        if ($request->getFile('banner_image')->getPath() != '') {
            $path = 'assets/images/animals/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $image = $request->getFile('banner_image');
            $imageName = time() . '_' . $image->getClientName();
            $image->move($path, $imageName);
            $imagePath = $path . $imageName;
            $data['banner_image'] = $imagePath;
        }
        $pet = new PetProductsModel();
        if($request->getPost('id') && $request->getPost('id') != ''){
            $pet->update($request->getPost('id'),$data);
            $insert_id = $request->getPost('id');
        }else{
            $pet->insert($data);
            $insert_id = $pet->insertID();
        }

        return redirect()->to('admin/product/lists')->with('success','Successfull Inserted Product.');

    }

    public function deleteproduct($id){
        $pet = new PetProductsModel();
        $petdata = $pet->where('id',$id)->first();
        if($petdata && $petdata['banner_image'] != ''){
           unlink('./'.$petdata['banner_image']);
        }
        $pet->where('id',$id)->delete();
        
        return redirect()->to('admin/product/lists')->with('success','Successfull Deleted Product.');
    }

    public function bloglist(){
        $blogs = new BlogsModel();  
        $blogs = $blogs->findAll();
        return view('admin/bloglist',['user' => $this->curr_user,'list'=>$blogs]);
    }

    public function blogdata(){
        $blog = array();
       
        if(isset($_GET['id'])){
            $blog = new BlogsModel();
            $blog = $blog->where('id',$_GET['id'])->find();
        }
        return view('admin/blogadd',['user' => $this->curr_user,'blog'=>$blog]);
    }

    public function doblogupdate(){

        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'title' => 'required',
            'description' => 'required',
            'summary' => 'required',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
       
        $data = [
            'title' => $request->getPost('title'),
            'description' => $request->getPost('description'),
            'summary' => $request->getPost('summary'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($request->getFile('banner_image')->getPath() != '') {
            $path = 'assets/images/blogs/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $image = $request->getFile('banner_image');
            $imageName = time() . '_' . $image->getClientName();
            $image->move($path, $imageName);
            $imagePath = $path . $imageName;
            $data['banner_image'] = $imagePath;
        }
        $pet = new BlogsModel();
        if($request->getPost('id') && $request->getPost('id') != ''){
            $pet->update($request->getPost('id'),$data);
            $insert_id = $request->getPost('id');
        }else{
            $pet->insert($data);
            $insert_id = $pet->insertID();

            $notdata = array(
                'type' => 'blog_add',
                'uniq_id' => $insert_id,
                'created_at' => date('Y-m-d H:i:s'),
                'seen' => 0
            );

            $users = new UserModel();
            $users = $users->where('type',1)->findAll();
            
            $notification_model = new NotificationModel();
            foreach($users as $u){
                $notdata['user_id'] = $u['id'];
                $notification_model->insert($notdata);
                 
            }
        }

        return redirect()->to('admin/blog/lists')->with('success','Successfull Inserted Blog.');

    }

    public function deleteblog($id){
        $pet = new BlogsModel();
        $petdata = $pet->where('id',$id)->first();
        if($petdata && $petdata['banner_image'] != ''){
           unlink('./'.$petdata['banner_image']);
        }
        $pet->where('id',$id)->delete();
        
        return redirect()->to('admin/blog/lists')->with('success','Successfull Deleted Blog.');
    }

    public function userlist(){
        $userlist = new UserModel();
        $userlist = $userlist->where('type !=',0)->find();

        $users = array();

        foreach($userlist as $u){
            $users[$u['type']][] = $u;
        }

        return view('admin/userlist',['user' => $this->curr_user,'users'=>$users]);
    }

    public function changeuserstatus($id){
        $ud = new UserModel();
        $user_details = $ud->where('id',$id)->first();

        if($user_details['status'] == 1){
            $user_details['status'] = 0;
        }else{
            $user_details['status'] = 1;
        }
        unset($user_details['id']);
        $ud->update($id,$user_details);

        return redirect()->back()->with('success','Successfull updated user status.');
    }
}
