<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Http\ServerRequest;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->OTP = TableRegistry::get('Otps');
        $this->Category = TableRegistry::get('Category');
        $this->Subcategory = TableRegistry::get('Subcategory');
        $this->Products = TableRegistry::get('Products');
        $this->Carts=TableRegistry::get('Carts');

        $this->Auth->allow(['login']);
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }


    public function login()
    {
        $this->request->allowMethod('post');
        $user = $this->Users->find()->where(["mobile" => $this->request->getData(["mobile"]), "role" => $this->request->getData(["role"]), "is_active" => 1])->first();
        if (!$user) {
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user = $this->Users->save($user);
            if (!$user) {
                $msg['msg'] = 'The user could not be saved. Please, try again.';
                $msg['status'] = 0;
                $msg['error'] = $user->getErrors();
                echo json_encode($msg);
                exit;
            }
        }

        $otp = $this->OTP->newEntity();
        $otpData['otp'] = $this->Common->generateNumericOTP(6);
        $otpData['created_at'] = new Time();
        $otpData['modified_at'] = new Time();
        $otpData['user_id'] = $user->id;
        $otpData['is_used'] = false;
        $otpData['expired_on'] = Time::now()->addHour(1);
        $otp = $this->OTP->patchEntity($otp, $otpData);
        if ($this->OTP->save($otp)) {
            $msg['msg'] = 'OTP send to your Mobile Number.';
            $msg['data'] =  $otp;
            $msg['status'] = 1;
        } else {
            $msg['msg'] = 'couldn\'t create OTP. Please, try again.';
            $msg['status'] = 0;
            $msg['error'] = $otp->getErrors();
        }
        echo json_encode($msg);
        exit;
    }
    public function verifyotp()
    {
        $this->request->allowMethod('post');
        $otp = $this->OTP->find()->where(['id' => $this->request->data['id']])->first();
        if ($otp) {
            if ($otp['expired_on'] >= new Time()) {
                if ($otp['otp'] == $this->request->data['otp']) {
                    if (!$otp['is_used']) {
                        $otp['is_used'] = true;
                        if ($this->OTP->save($otp)) {
                            $user = $this->Users->find()->where(["id" => $otp['user_id']])->first();
                            $tokenId  = base64_encode(32);
                            $issuedAt = time();
                            $key = Security::salt();
                            $token = JWT::encode(
                                [
                                    'alg' => 'HS256',
                                    'id' => $user['id'],
                                    'sub' => $user['id'],
                                    'data' => [$user['role']],
                                ],
                                $key
                            );
                            echo json_encode([
                                "msg" => "Login successfully", "success" => true,
                                "data" => [
                                    'token' => $token,
                                    'profile_img' => $user['profile_img'],
                                    'username'  => $user['username']
                                ]
                            ]);
                            exit;
                        } else {
                            $msg['msg'] = "verification failed. Please try again";
                            $msg['status'] = 0;
                        }
                    } else {
                        $msg['msg'] = "otp already used";
                        $msg['status'] = 0;
                    }
                } else {
                    $msg['msg'] = "incorrect otp";
                    $msg['status'] = 0;
                }
            } else {
                $msg['msg'] = "otp expired";
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = "invalid otp";
            $msg['status'] = 0;
        }

        echo json_encode($msg);
        exit;
    }

    public function updateprofileinfo()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $userData = [];
            $userData['username'] = $this->request->data['username'];
            if ($this->request->data['upload_image']) {
                $uploadImage = $this->Common->uploadfile($this->request->data['upload_image']);
                if ($uploadImage) {
                    $userData['profile_img'] = $uploadImage;
                } else {
                    $msg['msg'] = 'image upload failed. please try agian';
                    $msg['status'] = 0;
                }
            }
            $id = $tokenData->id;
            $user =  $this->Users->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $userData);
                if ($this->Users->save($user)) {
                    $msg['msg'] = 'The user has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The user could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $user->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }

    public function gettopcategory($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {

            if ($id) {
                $subcategory = $this->Subcategory->find()->where(['Subcategory.id' => $id])->contain(['Category']);
            } else {
                $subcategory = $this->Subcategory->find()->contain(['Category']);
            }
            $result = array();
            foreach ($subcategory as $scat) {
                array_push(
                    $result,
                    [
                        'id' => $scat->id,
                        'category_id' => $scat->category_id,
                        'category' => $scat->category->category,
                        'subcategory' => $scat->subcategory
                    ]
                );
            }
            if ($result) {
                $msg['status'] = 1;
                $msg['data'] =   $result;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please, try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }

    public function searchproducts()
    {
       $center_lat = $this->request->data['lat'];
        $center_lng = $this->request->data['lng'];
        $radius = $this->request->data['radius'];

// productname, category, subcategory, 

        $result = $this->Products
            ->find()
            ->where([
                '(6371 *
                    acos(
                        cos(radians(' . $center_lat . ')) *
                            cos(radians(latitude)) *
                            cos(radians(longitude) - radians(' . $center_lng . ')) +
                            sin(radians(' . $center_lat . ')) *
                            sin(radians(latitude))
                    )) <' .  $radius
                    ,
                    'subcategory_id'=>''] )
            ->contain(['AddressBooks']);
        echo json_encode($result);
        exit;
    }
    public function getproduct($id)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) 
                $products = $this->Products->find()->where(['Products.id' => $id, 'is_deleted' => false])->contain(['Units', 'Discounts']);            
            $result = array();
            foreach ($products as $prod) {
                $prod->unit = $prod->unit->unit;

                if ($prod->discount && new Time($prod->discount->expired_on) >= new Time() && $prod->discount->quantity == 1) {
                    if ($prod->discount['unit'] == 'fixed') {
                        $prod['final_price']  = $prod['admin_price']  - $prod->discount['value'];
                    } else {
                        $prod['final_price']  = $prod['admin_price']  - (($prod->discount['value'] / 100) * $prod['admin_price']);
                    }
                } else {
                    $prod['final_price'] = $prod['admin_price'];
                }

                array_push($result, $prod);
            }
            if ($result) {
                $msg['status'] = 1;
                $msg['data'] =   $result;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please, try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function addtocart()
    {
        $this->request->allowMethod('Post');
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $carts = $this->Carts->newEntity();

// need to find product and fetch the user_id and product id to the cart table

            if ($this->request->is('post')) {
                $carts = $this->Carts->patchEntity($carts, $this->request->data);
                if ($this->Carts->save($carts)) {
                    $msg['msg'] = 'The cart has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The cart could not be saved. Please, try again.';
                    $msg['status'] = 0;

                    $msg['error'] = $carts->getErrors();
                }
                echo json_encode($msg);
                exit;
            }
        }
    }
}
