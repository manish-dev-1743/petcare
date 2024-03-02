<?php

namespace App\Controllers;

use App\Models\PetModel;
use App\Models\AnimalModel;
use App\Models\AnimalImageModel;
use App\Models\PetProductsModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Request;

class Allies extends BaseController
{

    protected $curr_user;
    public function __construct()
    {
        if(session()->get('token') !== NULL){    
            $user = $this->authCheck(session()->get('token'));
            if ($user) {
                if ($user->type == '1') {
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

    public function petlist(){
        $pet = new AnimalModel(); 
        if($this->curr_user->type == 1){
            $pet = $pet->findAll();
        }else{
            $pet = $pet->where('creator_id',$this->curr_user->id)->find();
        }
        return view('admin/petlist',['user' => $this->curr_user,'animal'=>$pet]);
    }

    public function animaldata(){
        $pet = array();
        $animal_images = array();
        if(isset($_GET['id'])){
            $pet = new AnimalModel();
            $pet = $pet->where('id',$_GET['id'])->find();
            $animal_images = new AnimalImageModel();
            $animal_images = $animal_images->where('animal_id',$_GET['id'])->find();
        }
        $pet_cat = new PetModel();
        $pet_cat = $pet_cat->where('status !=',0)->find();
        return view('admin/animaladd',['user' => $this->curr_user,'animal'=>$pet,'pet_cat' => $pet_cat,'animal_images' => $animal_images]);
    }

    public function doanimalupdate(){
        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required',
            'description' => 'required',
            'pet_id' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
       
        $data = [
            'name' => $request->getPost('name'),
            'description' => $request->getPost('description'),
            'status' => ($request->getPost('status') && $request->getPost('status') == 'on') ? 1 : 0,
            'pet_id' => $request->getPost('pet_id'),
            'creator_id' => $this->curr_user->id
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
        $pet = new AnimalModel();
        if($request->getPost('id') && $request->getPost('id') != ''){
            $pet->update($request->getPost('id'),$data);
            $insert_id = $request->getPost('id');
        }else{
            $pet->insert($data);
            $insert_id = $pet->insertID();
        }

        $images = $this->request->getFiles();

        foreach ($images['images'] as $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $path = 'assets/images/animalimages/';
        
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
        
                // Save the image path to the database
                $animalImageModel = new AnimalImageModel();
                $animalImageModel->insert(['image' => $imagePath, 'animal_id' => $insert_id]);
            }
        }
        

        return redirect()->to('admin/pet-lists')->with('success','Successfull Inserted Animal Details.');
    }

    public function deleteAnimalImg($id) {
        $img = new AnimalImageModel();
        $image = $img->find($id);
    
        if ($image) {
          
                unlink('./'.$image['image']);
                $img->where('id',$id)->delete();
                return redirect()->back()->with('success', 'Successfully Deleted Image.');
           
        } else {
            return redirect()->back()->with('error', 'Image not found.');
        }
    }

    public function deleteanimal($id){
        
        $pet = new AnimalModel();
        $petdata = $pet->where('id',$id)->first();
        if($petdata && $petdata['banner_image'] != ''){
           unlink('./'.$petdata['banner_image']);
        }
        $images = new AnimalImageModel();
        $imgs = $images->where("animal_id",$id)->find();
        foreach($imgs as $ai){
            if($ai['image'] != ''){
                unlink('./'.$ai['image']);
            }
        }
        $images->where("animal_id",$id)->delete();
        $pet->where('id',$id)->delete();
        
        return redirect()->to('admin/pet-lists')->with('success','Successfull Deleted Animal.');
    
    }

    public function productlist(){
        $pet = new PetProductsModel(); 
        if($this->curr_user->type == 1){
            $pet = $pet->findAll();
        }else{
            $pet = $pet->where('creator_id',$this->curr_user->id)->find();
        }
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

    public function deletedoc(){
        $user_id = $this->curr_user->id;
        $user = new UserModel();
        $user_details = $user->where('id',$user_id)->first();
        $document = $user_details['documents'];
        $path = (isset($_GET['path']))?$_GET['path']:'';
       
        if($document != NULL && $document != '[]' && $document != ''){
       
            $document = json_decode($document);
            if(in_array($path,$document) !== false){
                @unlink('./'.$path);
                unset($document[array_search($path,$document)]);
                $user_details['documents'] = json_encode($document);

                $user->update($user_id,$user_details);
            }else{
                return redirect()->back()->with('errors', 'Image Not Found');
            }
        }
        return redirect()->back()->with('success', 'Image Successfully deleted');
    }

}
