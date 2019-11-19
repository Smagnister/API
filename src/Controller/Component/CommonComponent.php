<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class CommonComponent extends Component
{
    public function check()
    {
        return 'compoent working';
    }
    
    public function getTokenData($header)
    {
        if ($header && stripos($header, 'bearer') === 0) {
            $token = ($this->_token = str_ireplace('bearer' . ' ', '', $header));
            return JWT::decode($token, Security::salt(), array('HS256'));
        }
        return false;
    }

    public function generateNumericOTP($n)
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }
    public function uploadfile($imageData)
    {
        $image = base64_decode($imageData['image']);
        $uploadPath = WWW_ROOT . 'img';
        $filename = $this->generateNumericOTP(12);
        if (file_put_contents(WWW_ROOT . 'img/uploads/' . $filename . '.' . $imageData['type'], $image)) {
            return  $filename . '.' . $imageData['type'];
        }
       return false;
    }
}
