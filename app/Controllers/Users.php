<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\MyOrderModel;
use App\Models\PaymentsModel;
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
        if($this->curr_user->type == 1){
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
        }else{
            echo json_encode(array('status'=>200,'message'=>'Please Login as User.'));
        }
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

    public function proceedpayment(){
        $request = service('request');
        $postData = $request->getPost();
        $generated_uuid = $this->generateUUID();
        $product_code = 'PRODUCT_'.time();
        $generated_signature = $this->generateSignatiure($postData['amount'],$generated_uuid);
        if(!empty($postData)){
            $data = array(
                'user_id' => $this->curr_user->id,
                'cart_ids' => $postData['cart_ids'],
                'location' => $postData['location'],
                'payment_type' => $postData['payment_type'],
                'payment_status' => 0,
                'amount' => $postData['amount'],
                'uuid' => $generated_uuid,
                'signature' => $generated_signature,
               
            );
            $payments = new PaymentsModel();
            $payments->insert($data);
            if($postData['payment_type'] == 'esewa'){
                $this->esewaPayment($postData['amount'],$generated_signature,$generated_uuid);
            }else{
                $this->cashondelivery($postData);
                return redirect()->to('/')->with('success', 'Successfully placed Orders.');
            }
        }
    }

    public function paymentsuccess(){
        $token = (isset($_GET['data']) && $_GET['data'] != '')?$_GET['data']:false;
        if($token){
            $payload = json_decode(base64_decode($token));

            $payments = new PaymentsModel();
            $payments_details = $payments->where('uuid',$payload->transaction_uuid)->first();
            if($payments_details){
                $res = file_get_contents('https://uat.esewa.com.np/api/epay/transaction/status/?product_code=EPAYTEST&total_amount='.intval($payments_details['amount']).'&transaction_uuid='.$payload->transaction_uuid);
                $res = json_decode($res);
                if($res->status = 'COMPLETE'){
                    
                    $payments->update($payments_details['id'],['payment_status' => 1]);

                    $cart_ids = explode(',',$payments_details['cart_ids']);
                    $quantity = array();
                    $product_ids = array();
                    $cart = new CartModel();
                    $product = new PetProductsModel();
                    foreach($cart_ids as $cid){
                        $carts = $cart->where('id',$cid)->first();
                        $product_ids[] = $carts['product_id'];
                        $q = $carts['quantity'];
                        $prod = $product->where('id',$carts['product_id'])->first();
                        $new_q = $prod['quantity'] - $q;
                        $product->update($carts['product_id'],['quantity'=>$new_q]);
                        $quantity[] = $q;
                        $cart->where('id',$cid)->delete();
                    }

                    $data = array(
                        'user_id' => $this->curr_user->id,
                        'product_ids' => implode(',',$product_ids),
                        'quantity' => implode(',',$quantity),
                        'amount' => $payments_details['amount'],
                        'is_paid' => 1,
                        'delivery_date' => date('Y-m-d H:i:s',strtotime('+7 days'))
                    );
                    $order = new MyOrderModel();
                    $order-> insert($data);
                }
            }
            
        }
        return redirect()->to('/')->with('success', 'Successfully placed Orders.');    
    }

    protected function cashondelivery($postData){
        $cart_ids = explode(',',$postData['cart_ids']);
        $quantity = array();
        $product_ids = array();
        $cart = new CartModel();
        $product = new PetProductsModel();
        foreach($cart_ids as $cid){
            $carts = $cart->where('id',$cid)->first();
            $product_ids[] = $carts['product_id'];
            $q = $carts['quantity'];
            $prod = $product->where('id',$carts['product_id'])->first();
            $new_q = $prod['quantity'] - $q;
            $product->update($carts['product_id'],['quantity'=>$new_q]);
            $quantity[] = $q;
            $cart->where('id',$cid)->delete();
        }
        $data = array(
            'user_id' => $this->curr_user->id,
            'product_ids' => implode(',',$product_ids),
            'quantity' => implode(',',$quantity),
            'amount' => $postData['amount'],
            'is_paid' => 0,
            'delivery_date' => date('Y-m-d H:i:s',strtotime('+7 days'))
        );
        $order = new MyOrderModel();
        $order-> insert($data);  
    }

    protected function generateUUID(){
        return 'EPAY_'.time();
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
            'success_url' => base_url('payment/success'),
            'failure_url' => base_url('payment/success'),
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
            $exploded_body = explode("\r\n", $body);
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

    public function myorder(){
        if($this->curr_user->type == 1){
            $myorder = new MyOrderModel();
            $myorder_list= $myorder->where('user_id',$this->curr_user->id)->find();
            $product = new PetProductsModel();
            foreach($myorder_list as &$mol){
                $products = $product->whereIn('id',explode(',',$mol['product_ids']))->find();
                $mol['products'] = $products;
            }
            $title = 'My Order';

            return view('auth/my-order',['my_orders'=>$myorder_list,'title'=>$title,'user'=>$this->curr_user]);
        }else{
            return redirect()->to('/');
        }
    }
}