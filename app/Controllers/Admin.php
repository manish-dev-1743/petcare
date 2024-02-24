<?php

namespace App\Controllers;

use App\Models\PetModel;
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
}
