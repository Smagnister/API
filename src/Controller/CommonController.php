<?php
namespace App\Controller;

// use App\Controller\AppController;

class CommonController extends AppController{
    public function initialize()
    {
        parent::initialize();
       
    }
    public function check(){
        return 'common controler working';
        
    }
}