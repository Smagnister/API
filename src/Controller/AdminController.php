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

class AdminController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get("Users");
        $this->Stores = TableRegistry::get("Stores");
        $this->OpenTime  = TableRegistry::get("OpenTime");
        $this->Bikers = TableRegistry::get("Bikers");
        $this->Address = TableRegistry::get('Addressbooks');
        $this->Category = TableRegistry::get('Category');
        $this->Subcategory = TableRegistry::get('Subcategory');
        $this->Units = TableRegistry::get('Units');
        $this->Products = TableRegistry::get('Products');
        $this->Transport = TableRegistry::get('Transports');
        $this->Discounts = TableRegistry::get('Discounts');


        $this->Auth->allow(['login', 'addadmin']);
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function addadmin()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['is_active'] = 1;
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $msg['msg'] = 'The user has been saved.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The user could not be saved. Please, try again.';
                $msg['status'] = 0;
                $msg['error'] = $user->getErrors();
            }
        }
        echo json_encode($msg);
        exit;
    }

    public function login()
    {
        $user = $this->Users->find()->where(["mobile" => $this->request->getData(["mobile"]), "password" => $this->request->getData(["password"]), "role" => $this->request->getData(["role"]), "is_active" => 1])->first();
        if (!$user) {
            throw new UnauthorizedException("Invalid login details");
        } else {
            $tokenId  = base64_encode(32);
            $issuedAt = time();
            $key = Security::salt();
            $token = JWT::encode(
                [
                    'alg' => 'HS256',
                    'id' => $user['id'],
                    'sub' => $user['id'],
                    'data' => [$user['role']],
                    // 'iat' => time(),
                    // 'exp' =>  time() + 86400,
                ],
                $key
            );
            echo json_encode(["msg" => "Login successfully", "success" => true, "data" => ['token' => $token]]);
            exit;
        }
    }




    // users management
    public function getuser($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $user = $this->Users->find()->where(["id" => $id])->first();
            } else {
                $user = $this->Users->find()->where(['role' => 'user']);
            }
            if ($user) {
                $msg['status'] = 1;
                $msg['data'] =   $user;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please, try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function adduser()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $user = $this->Users->newEntity();
            if ($this->request->is('post')) {
                $this->request->data['created_by'] = $tokenData->id;
                // $this->request->data['created_at'] = time();
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $msg['msg'] = 'The user has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The user could not be saved. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $user->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }

    public function edituser()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $user =  $this->Users->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
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
    public function deleteuser()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $user = $this->Users->find()->where(["id" => $id])->first();

        if ($user) {
            if ($this->Users->delete($user)) {
                $msg['msg'] = 'The user has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The user could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The user not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }

    //store management
    public function getstore($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $store = $this->Users->find()->where(['id' => $id, 'role' => 'store'])->contain(['Stores', 'OpenTime']);
            } else {
                $store = $this->Users->find()->where(['role' => 'store'])->contain(['Stores', 'OpenTime']);
            }
            if ($store) {
                $msg['status'] = 1;
                $msg['data'] =   $store;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please, try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function addstore()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $user = $this->Users->newEntity();
            $store = $this->Stores->newEntity();
            $openTime =  $this->OpenTime->newEntity();
            if ($this->request->is('post')) {
                $userData['mobile'] =  $this->request->data['mobile'];
                $userData['role'] =  $this->request->data['role'];
                $userData['email'] =  $this->request->data['email'];
                $userData['created_by'] =  $tokenData->id;
                $userData['modified_by'] =  $tokenData->id;
                $userData['is_active'] =  $this->request->data['is_active'];
                $userData['profile_img'] =  $this->request->data['profile_img'];

                $storeData['contact_person_name'] = $this->request->data['contact_person_name'];
                $storeData['contact_person_mobile'] = $this->request->data['contact_person_mobile'];
                $storeData['phone'] = $this->request->data['phone'];
                $storeData['gst_no'] = $this->request->data['gst_no'];
                $storeData['website'] = $this->request->data['website'];
                $storeData['is_approved'] = $this->request->data['is_approved'];
                $storeData['ratings'] = $this->request->data['ratings'];
                $storeData['remarks'] = $this->request->data['remarks'];

                $storeTimeData['days'] = $this->request->data['days'];
                $storeTimeData['start_hour'] = new Time($this->request->data['start_hour']);
                $storeTimeData['end_hour'] = new Time($this->request->data['end_hour']);

                $user = $this->Users->patchEntity($user, $userData);
                $userSave = $this->Users->save($user);

                if ($userSave) {
                    $storeData['user_id'] = $userSave->id;
                    $store = $this->Stores->patchEntity($store, $storeData);
                    if ($this->Stores->save($store)) {
                        $storeTimeData['user_id'] = $userSave->id;
                        $openTime = $this->OpenTime->patchEntity($openTime, $storeTimeData);
                        if ($this->OpenTime->save($openTime)) {
                            $msg['msg'] = 'The store has been saved.';
                            $msg['status'] = 1;
                            echo json_encode($msg);
                            exit;
                        } else {
                            $msg['error'] =  $openTime->getErrors();
                        }
                    } else {
                        $msg['error'] = $store->getErrors();
                    }
                } else {
                    $msg['error'] = $user->getErrors();
                }
            }
            $msg['msg'] = 'The store could not be saved. Please, try again.';
            $msg['status'] = 0;
            echo json_encode($msg);
            exit;
        }
    }

    public function editstore()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $user =  $this->Users->find()->where(['id' => $id])->first();
            $store = $this->Stores->find()->where(['user_id' => $id])->first();
            $openTime = $this->OpenTime->find()->where(['user_id' => $id])->first();
            if ($this->request->is(['patch', 'post', 'put'])) {

                $userData['mobile'] =  $this->request->data['mobile'];
                $userData['role'] =  $this->request->data['role'];
                $userData['email'] =  $this->request->data['email'];
                $userData['modified_by'] =  $tokenData->id;
                $userData['is_active'] =  $this->request->data['is_active'];
                $userData['profile_img'] =  $this->request->data['profile_img'];

                $storeData['contact_person_name'] = $this->request->data['contact_person_name'];
                $storeData['contact_person_mobile'] = $this->request->data['contact_person_mobile'];
                $storeData['phone'] = $this->request->data['phone'];
                $storeData['gst_no'] = $this->request->data['gst_no'];
                $storeData['website'] = $this->request->data['website'];
                $storeData['is_approved'] = $this->request->data['is_approved'];
                $storeData['ratings'] = $this->request->data['ratings'];
                $storeData['remarks'] = $this->request->data['remarks'];

                $storeTimeData['days'] = $this->request->data['days'];
                $storeTimeData['start_hour'] = new Time($this->request->data['start_hour']);
                $storeTimeData['end_hour'] = new Time($this->request->data['end_hour']);


                $user = $this->Users->patchEntity($user, $userData);
                if ($this->Users->save($user)) {
                    echo 'user saved';
                    $store = $this->Stores->patchEntity($store, $storeData);
                    if ($this->Stores->save($store)) {
                        echo 'store saved';
                        $openTime = $this->OpenTime->patchEntity($openTime, $storeTimeData);
                        if ($this->OpenTime->save($openTime)) {
                            echo 'time saved';
                            $msg['msg'] = 'The store has been updated.';
                            $msg['status'] = 1;
                            echo json_encode($msg);
                            exit;
                        } else {
                            $msg['error'] =  $openTime->getErrors();
                        }
                    } else {
                        $msg['error'] =  $store->getErrors();
                    }
                } else {
                    $msg['error'] = $user->getErrors();
                }
            }
            $msg['msg'] = 'The store could not be update. Please, try again.';
            $msg['status'] = 0;
            echo json_encode($msg);
            exit;
        }
    }
    public function deletestore()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $user = $this->Users->find()->where(["id" => $id])->first();
        $store = $this->Stores->find()->where(['user_id' => $id])->first();
        $openTime = $this->OpenTime->find()->where(['user_id' => $id])->first();
        if ($user) {
            if ($this->OpenTime->delete($openTime)) {
                if ($this->Stores->delete($store)) {
                    if ($this->Users->delete($user)) {
                        $msg['msg'] = 'The store has been deleted.';
                        $msg['status'] = 1;
                        echo json_encode($msg);
                        exit;
                    } else {
                        $msg['error'] = $user->getErrors();
                    }
                } else {
                    $msg['error'] = $store->getErrors();
                }
            } else {
                $msg['error'] =  $openTime->getErrors();
            }


            $msg['msg'] = 'The store could not be deleted. Please, try again.';
            $msg['status'] = 0;
            echo json_encode($msg);
            exit;
        }
    }

    // biker management
    public function getbiker($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $biker = $this->Users->find()->where(['id' => $id, 'role' => 'biker'])->contain(['Bikers']);
            } else {
                $biker = $this->Users->find()->where(['role' => 'biker'])->contain(['Bikers']);
            }
            if ($biker) {
                $msg['status'] = 1;
                $msg['data'] =   $biker;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }

    public function addbiker()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $user = $this->Users->newEntity();
            $biker = $this->Bikers->newEntity();
            if ($this->request->is('post')) {
                $userData = $this->request->data;
                unset($userData['biker']);
                $userData['created_by'] =  $tokenData->id;
                $userData['created_at'] = new Time();
                $bikerData = $this->request->data['biker'];
                $bikerData['dob'] = new Time($bikerData['dob']);
                $now = new Time();
                $interval = $now->diff($bikerData['dob']);
                if ($interval->format('%Y') >= 100 || $interval->format('%Y') < 18) {
                    $msg['msg'] = 'Invalid Date of birth for biker.';
                    $msg['status'] = 0;
                    echo json_encode($msg);
                    exit;
                }
                $user = $this->Users->patchEntity($user, $userData);
                $userSave = $this->Users->save($user);
                if ($userSave) {
                    $bikerData['user_id'] = $userSave->id;
                    $biker = $this->Bikers->patchEntity($biker, $bikerData);
                    if ($this->Bikers->save($biker)) {
                        $msg['msg'] = 'The biker has been saved.';
                        $msg['status'] = 1;
                        echo json_encode($msg);
                        exit;
                    } else {
                        $msg['error'] =  $biker->getErrors();
                    }
                } else {
                    $msg['error'] =  $user->getErrors();
                }

                $msg['msg'] = 'The biker could not be saved. Please, try again.';
                $msg['status'] = 0;
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function editbiker()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $user =  $this->Users->find()->where(['id' => $id])->first();
            $biker = $this->Bikers->find()->where(['user_id' => $id])->first();
            if ($this->request->is(['patch', 'post', 'put'])) {
                $userData = $this->request->data;
                unset($userData['biker']);
                $userData['modified_by'] =  $tokenData->id;
                $userData['modified_at'] = new Time();
                $bikerData = $this->request->data['biker'];
                $bikerData['dob'] = new Time($bikerData['dob']);
                $now = new Time();
                $interval = $now->diff($bikerData['dob']);
                if ($interval->format('%Y') >= 100 || $interval->format('%Y') < 18) {
                    $msg['msg'] = 'Invalid Date of birth for biker.';
                    $msg['status'] = 0;
                    echo json_encode($msg);
                    exit;
                }
                $user = $this->Users->patchEntity($user, $userData);
                if ($this->Users->save($user)) {
                    $biker = $this->Bikers->patchEntity($biker, $bikerData);
                    if ($this->Bikers->save($biker)) {
                        $msg['msg'] = 'The biker has been updated.';
                        $msg['status'] = 1;
                        echo json_encode($msg);
                        exit;
                    } else {
                        $msg['error'] =  $biker->getErrors();
                    }
                } else {
                    $msg['error'] =  $user->getErrors();
                }

                $msg['msg'] = 'The biker could not be updated. Please, try again.';
                $msg['status'] = 0;
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function deletebiker()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $user = $this->Users->find()->where(["id" => $id])->first();
        $biker = $this->Bikers->find()->where(['user_id' => $id])->first();
        if ($user) {
            if ($this->Bikers->delete($biker)) {
                if ($this->Users->delete($user)) {
                    $msg['msg'] = 'The biker has been deleted.';
                    $msg['status'] = 1;
                    echo json_encode($msg);
                    exit;
                } else {
                    $msg['error'] = $user->getErrors();
                }
            } else {
                $msg['error'] =  $biker->getErrors();
            }
            $msg['msg'] = 'The biker could not be deleted. Please, try again.';
            $msg['status'] = 0;
            echo json_encode($msg);
            exit;
        }
    }


    //address Management
    public function getaddress($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $address = $this->Address->find()->where(['id' => $id]);
            } else {
                $address = $this->Address->find();
            }
            if ($address) {
                $msg['status'] = 1;
                $msg['data'] =   $address;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function addaddress()
    {
        $this->request->allowMethod('Post');
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $address = $this->Address->newEntity();
            if ($this->request->is('post')) {
                $address = $this->Address->patchEntity($address, $this->request->data);
                if ($this->Address->save($address)) {
                    $msg['msg'] = 'The address has been saved.';
                    $msg['status'] = 1;
                    echo json_encode($msg);
                    exit;
                } else {
                    $msg['error'] =  $address->getErrors();
                }
                $msg['msg'] = 'The address could not be saved. Please, try again.';
                $msg['status'] = 0;
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function editaddress()
    {

        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $address =  $this->Address->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $address = $this->Address->patchEntity($address, $this->request->getData());
                if ($this->Address->save($address)) {
                    $msg['msg'] = 'The address has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The address could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $address->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function deleteaddress()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $address = $this->Address->find()->where(["id" => $id])->first();

        if ($address) {
            if ($this->Address->delete($address)) {
                $msg['msg'] = 'The address has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The address could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The address not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }

    // catogory management
    public function getcategory($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $category = $this->Category->find()->where(['id' => $id]);
            } else {
                $category = $this->Category->find();
            }
            if ($category) {
                $msg['status'] = 1;
                $msg['data'] =   $category;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please, try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function addcategory()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $category = $this->Category->newEntity();
            // echo json_encode($this->request->data);
            // exit;
            if ($this->request->is('post')) {
                $category = $this->Category->patchEntity($category, $this->request->data);
                if ($this->Category->save($category)) {
                    $msg['msg'] = 'The category has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The category could not be saved. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $category->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function editcategory()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $category =  $this->Category->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $category = $this->Category->patchEntity($category, $this->request->getData());
                if ($this->Category->save($category)) {
                    $msg['msg'] = 'The category has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The category could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $category->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function deletecategory()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $category = $this->Category->find()->where(["id" => $id])->first();

        if ($category) {
            if ($this->Category->delete($category)) {
                $msg['msg'] = 'The category has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The category could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The category not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }

    // subcategory management

    public function getsubcategory($id = null)
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
    public function addsubcategory()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $subcategory = $this->Subcategory->newEntity();
            if ($this->request->is('post')) {
                $subcategory = $this->Subcategory->patchEntity($subcategory, $this->request->data);
                if ($this->Subcategory->save($subcategory)) {
                    $msg['msg'] = 'The subcategory has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The subcategory could not be saved. Please, try again.';
                    $msg['status'] = 0;

                    $msg['error'] = $subcategory->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function editsubcategory()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $subcategory =  $this->Subcategory->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $subcategory = $this->Subcategory->patchEntity($subcategory, $this->request->getData());
                if ($this->Subcategory->save($subcategory)) {
                    $msg['msg'] = 'The subcategory has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The subcategory could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $subcategory->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function deletesubcategory()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $subcategory = $this->Subcategory->find()->where(["id" => $id])->first();

        if ($subcategory) {
            if ($this->Subcategory->delete($subcategory)) {
                $msg['msg'] = 'The subcategory has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The subcategory could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The subcategory not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }

    // unit management
    public function getunits($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $units = $this->Units->find()->where(['id', $id]);
            } else {
                $units = $this->Units->find();
            }
            if ($units) {
                $msg['status'] = 1;
                $msg['data'] = $units;
            } else {
                $msg['status'] = 0;
                $msg['msg'] = 'no records found. Please try again.';
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function addunit()
    {
        $this->request->allowMethod('Post');
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $units = $this->Units->newEntity();
            if ($this->request->is('post')) {
                $units = $this->Units->patchEntity($units, $this->request->data);
                if ($this->Units->save($units)) {
                    $msg['msg'] = 'The unit has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The unit could not be saved. Please, try again.';
                    $msg['status'] = 0;

                    $msg['error'] = $units->getErrors();
                }
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function editunit()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $units =  $this->Units->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $units = $this->Units->patchEntity($units, $this->request->getData());
                if ($this->Units->save($units)) {
                    $msg['msg'] = 'The unit has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The unit could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $units->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function deleteunit()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $units = $this->Units->find()->where(["id" => $id])->first();

        if ($units) {
            if ($this->Units->delete($units)) {
                $msg['msg'] = 'The unit has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The unit could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The unit not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }
    // products management
    public function getproduct($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $products = $this->Products->find()->where(['Products.id' => $id, 'is_deleted' => false])->contain(['Units', 'Discounts']);
            } else {
                $products = $this->Products->find()->where(['is_deleted' => false])->contain(['Units', 'Discounts']);
            }
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
    public function addproduct()
    {
        $this->request->allowMethod('Post');
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $products = $this->Products->newEntity();
            if ($this->request->is('post')) {
                $address  = $this->Address->find()->where(['user_id' => $this->request->data['user_id'], 'type' => 'primary'])->first();
                if ($address) {
                    $this->request->data['created_at'] = new Time();
                    $this->request->data['created_by'] = $tokenData->id;
                    $this->request->data['modified_at'] = new Time();
                    $this->request->data['modified_by'] = $tokenData->id;
                    $this->request->data['is_deleted'] = false;
                    $this->request->data['addressbook_id'] =  $address->id;
                    $discounts = $this->Discounts->find()->where(['Discounts.id' => $this->request->data['discount_id'],  'Discount.expired_on' > new Time()])->first();
                    $final_price = 0.0;
                    if ($discounts['unit'] == 'fixed') {
                        echo 'fixed';
                        $final_price = $this->request->data['admin_price']  - $discounts['value'];
                    } else {
                        echo 'percentage';
                        $final_price = $this->request->data['admin_price']  - (($discounts['value'] / 100) * $this->request->data['admin_price']);
                    }
                    $this->request->data['final_price'] = $final_price;

                    $products = $this->Products->patchEntity($products, $this->request->data);
                    if ($this->Products->save($products)) {
                        $msg['msg'] = 'The products has been saved.';
                        $msg['status'] = 1;
                    } else {
                        $msg['msg'] = 'The products could not be saved. Please, try again.';
                        $msg['status'] = 0;
                        $msg['error'] = $products->getErrors();
                    }
                } else {
                    $msg['msg'] = 'The products could not be saved. The store should have primary address to add product. Please, try again.';
                    $msg['status'] = 0;
                }
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function editproduct()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $products =  $this->Products->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $address  = $this->Address->find()->where(['user_id' => $this->request->data['user_id'], 'type' => 'primary'])->first();
                if ($address) {
                    $this->request->data['modified_at'] = new Time();
                    $this->request->data['modified_by'] = $tokenData->id;
                    $this->request->data['addressbook_id'] =  $address->id;
                    $discounts = $this->Discounts->find()->where(['Discounts.id' => $this->request->data['discount_id'],  'Discount.expired_on' > new Time()])->first();
                    $final_price = 0.0;
                    if ($discounts['unit'] == 'fixed') {
                        echo 'fixed';
                        $final_price = $this->request->data['admin_price']  - $discounts['value'];
                    } else {
                        echo 'percentage';
                        $final_price = $this->request->data['admin_price']  - (($discounts['value'] / 100) * $this->request->data['admin_price']);
                    }
                    $this->request->data['final_price'] = $final_price;

                    $products = $this->Products->patchEntity($products, $this->request->data);
                    if ($this->Products->save($products)) {
                        $msg['msg'] = 'The products has been saved.';
                        $msg['status'] = 1;
                    } else {
                        $msg['msg'] = 'The products could not be saved. Please, try again.';
                        $msg['status'] = 0;
                        $msg['error'] = $products->getErrors();
                    }
                } else {
                    $msg['msg'] = 'The products could not be saved. The store should have primary address to add product. Please, try again.';
                    $msg['status'] = 0;
                }


                echo json_encode($msg);
                exit;
            }
        }
    }
    public function deleteporoduct()
    {
        $this->request->allowMethod(['post', 'delete']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $this->request->data['is_deleted'] = true;
            $this->request->data['is_available'] = false;
            $products =  $this->Products->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'delete'])) {
                $products = $this->Products->patchEntity($products, $this->request->data);
                if ($this->Products->save($products)) {
                    $msg['msg'] = 'The product has been deleted.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The product could not be delete. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $products->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    // Discount management
    public function getdiscount($id = null)
    {
        $this->request->allowMethod(['get']);
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            if ($id) {
                $discounts = $this->Discounts->find()->where(['Discounts.id' => $id, 'Discount.expired_on' > new Time()])->contain(['Products', 'Transports']);
            } else {
                $discounts = $this->Discounts->find()->where(['Discount.expired_on' > new Time()])->contain(['Products', 'Transports']);
            }
            $result = array();
            foreach ($discounts as $disc) {
                array_push($result, $disc);
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
    public function adddiscount()
    {
        $this->request->allowMethod('Post');
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $discounts = $this->Discounts->newEntity();
            if ($this->request->is('post')) {
                $this->request->data['created_at'] = new Time();
                $this->request->data['created_by'] = $tokenData->id;
                $this->request->data['modified_at'] = new Time();
                $this->request->data['modified_by'] = $tokenData->id;
                $this->request->data['expired_on']   = new Time($this->request->data['expired_on']);
                $discounts = $this->Discounts->patchEntity($discounts, $this->request->data);
                if ($this->Discounts->save($discounts)) {
                    $msg['msg'] = 'The discount has been saved.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The discount could not be saved. Please, try again.';
                    $msg['status'] = 0;

                    $msg['error'] = $discounts->getErrors();
                }
                echo json_encode($msg);
                exit;
            }
        }
    }
    public function editdiscount()
    {
        $tokenData = $this->Common->getTokenData($this->request->getHeaderLine('Authorization'));
        if ($tokenData) {
            $id = $this->request->data['id'];
            $discounts =  $this->Discounts->get($id, ['contain' => []]);
            if ($this->request->is(['patch', 'post', 'put'])) {

                $this->request->data['created_at'] = new Time();
                $this->request->data['created_by'] = $tokenData->id;
                $this->request->data['modified_at'] = new Time();
                $this->request->data['modified_by'] = $tokenData->id;
                $this->request->data['expired_on']   = new Time($this->request->data['expired_on']);


                $discounts = $this->Discounts->patchEntity($discounts, $this->request->getData());
                if ($this->Discounts->save($discounts)) {
                    $msg['msg'] = 'The discount has been updated.';
                    $msg['status'] = 1;
                } else {
                    $msg['msg'] = 'The discount could not be update. Please, try again.';
                    $msg['status'] = 0;
                    $msg['error'] = $discounts->getErrors();
                }
            }
            echo json_encode($msg);
            exit;
        }
    }
    public function deletediscount()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->data['id'];
        $discounts = $this->Discounts->find()->where(["id" => $id])->first();

        if ($discounts) {
            if ($this->Discounts->delete($discounts)) {
                $msg['msg'] = 'The discount has been deleted.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The discount could not be deleted. Please, try again.';
                $msg['status'] = 0;
            }
        } else {
            $msg['msg'] = 'The discount not exist.';
            $msg['status'] = 0;
        }
        echo json_encode($msg);
        exit;
    }

    public function getuserproducts()
    {
       $center_lat = $this->request->data['lat'];
        $center_lng = $this->request->data['lng'];
        $radius = $this->request->data['radius'];
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
            ])
            ->contain(['AddressBooks']);
        echo json_encode($result);
        exit;
    }






















    public function getlatlangtoAddress()
    {
        // if (!empty($latitude) && !empty($longitude)) {
        //Send request and receive json data by address
        $latitude = '38.897952';
        $longitude = '-77.036562';
        // $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=true_or_false&key=AIzaSyDj1TBinw4rJHLqYLY1bc-WTbux3tJg6rM');
        $geocodeFromLatLong = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyDj1TBinw4rJHLqYLY1bc-WTbux3tJg6rM';
        $output = json_decode($geocodeFromLatLong);
        echo json_encode($output);
        exit;
        $status = $output->status;
        //Get address from json data
        $address = ($status == "OK") ? $output->results[1]->formatted_address : '';
        //Return address of the given latitude and longitude
        if (!empty($address)) {
            echo json_encode($address);
            exit;
        } else {
            echo 'no found';
            exit;
            return false;
        }
        // } else {
        //     return false;
        // }
    }
}





// https://maps.googleapis.com/maps/api/js?key=&callback=initMap
