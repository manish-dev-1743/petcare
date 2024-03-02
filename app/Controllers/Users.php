<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\PetProductsModel;
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

    public function updateProfile(){
        $user = new UserModel();
        $user_details = $user->where('id',$this->curr_user->id)->first();
        $user_details['name'] = $this->request->getPost('name');
        $user_details['email'] = $this->request->getPost('email');   
        $user_details['phone'] = $this->request->getPost('phone');
     
        $images = $this->request->getFiles();
        $documents = ($user_details['documents'] != NULL && $user_details['documents'] != '')?$user_details['documents']:'[]';
        $documents = json_decode($documents);
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
        
        $user_details['documents'] = json_encode($documents);
        $user->update($this->curr_user->id,$user_details);
        return redirect()->back()->with('success', 'Successfully updated profile.');
    }

    public function changeuserpass(){
        $validation = \Config\Services::validation();

        $rules = [
            'curr_pass'  => 'required|min_length[8]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d).+$/]',
            'new_pass'  => 'required|min_length[8]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d).+$/]',
            're_pass'  => 'required|min_length[8]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d).+$/]',
        ];

        $validation->setRules($rules);

        if ($validation->withRequest($this->request)->run()) {
            $curr_pass = $this->request->getPost('curr_pass');
            $new_pass = $this->request->getPost('new_pass');
            $re_pass = $this->request->getPost('re_pass');

            $user = new UserModel();
            $user_details = $user->where('id',$this->curr_user->id)->first();
            if(password_verify($curr_pass,$user_details['password'])){
                if($new_pass == $re_pass){
                    $user_details['password'] = password_hash($new_pass, PASSWORD_BCRYPT);
                    $user->update($this->curr_user->id,$user_details);
                    return redirect()->to('/logout')->with('success', 'Successfully Changed Password. Please Login Again.');   
                }
            }else{
                return redirect()->back()->with('errors', 'Incorrect Password Entered.');   
            }
        }else{
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function addtocart(){
        $request = service('request');

        $product_id = $request->getPost('product_id');  
        $user_id = $this->curr_user->id;
        $cart = new CartModel();
        $cart_exists = $cart->where(['product_id'=>$product_id,'user_id'=>$user_id])->first();
        if($cart_exists){
            $quantity = (int) $request->getPost('quantity')?$request->getPost('quantity'):1;
            $cart_id = (int) $cart_exists['id'];
            $updated_quantity = (int) $cart_exists['quantity'] + $quantity;

            $cart->update($cart_id,['quantity' => $updated_quantity]);
        }else{
            $quantity = $request->getPost('quantity')?$request->getPost('quantity'):1;
            $cart->insert(array('product_id'=>$product_id,'user_id'=>$user_id,'quantity'=>$quantity));
        }
        echo json_encode(array('status'=>200,'message'=>'Successfully added to Cart.'));
        die;
    }

    public function mycart(){
        $user_id = $this->curr_user->id;
        $cart = new CartModel();
        $cart_lists = $cart->where('user_id',$user_id)->find();
        $list_array = array();
        $produt = new PetProductsModel();
        foreach($cart_lists as $cl){
            $list_array[] = array(
                'details' => $produt->where('id',$cl['product_id'])->first(),
                'cart_detail' => $cl
            );
        }
        $title = 'My Cart';

        return view('auth/my-cart',['cart_list'=>$list_array,'title'=>$title,'user'=>$this->curr_user]);
    }

    public function deletecart($id){
        $cart = new CartModel();
        if($cart->delete($id)){
            return redirect()->back()->with('success', 'Successfully Deleted from cart.');   
        }
        return redirect()->back()->with('error', 'Unable to delete from cart');   
    }
}