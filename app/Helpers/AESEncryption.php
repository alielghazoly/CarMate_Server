<?php
namespace App\Helpers;

use Exception;

class AESEncryption {

    protected $key;
    protected $data;
    protected $method;
    protected $iv;

 
    protected $options = 0;


    public function __construct($data = null, $key = null, $iv = null, $blockSize = null, $mode = 'CBC') {
        $this->setData($data);
        $this->setKey($key);
        $this->setInitializationVector($iv);
        $this->setMethod($blockSize, $mode);
    }

  
    public function setData($data) {
        $this->data = $data;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function setMethod($blockSize, $mode = 'CBC') {
        if($blockSize==192 && in_array('', array('CBC-HMAC-SHA1','CBC-HMAC-SHA256','XTS'))){
            $this->method=null;
            throw new Exception('Invalid block size and mode combination!');
        }
        $this->method = 'AES-' . $blockSize . '-' . $mode;
    }


    public function setInitializationVector($iv) {
        $this->iv = $iv;
    }

    public function validateParams() {
        if ($this->data != null &&
                $this->method != null ) {
            return true;
        } else {
            return FALSE;
        }
    }

    protected function getIV() { 
        return $this->iv;
    }

   
    public function encrypt() {

        if ($this->validateParams()) { 
            return trim(openssl_encrypt($this->data, $this->method, $this->key, $this->options,$this->getIV()));
        } else {
            throw new Exception('Invalid params!');
        }
    }

  
    public function decrypt() {
        if ($this->validateParams()) {
            $ret=openssl_decrypt($this->data, $this->method, $this->key, $this->options,$this->getIV());
            return   trim($ret); 
        } else {
            throw new Exception('Invalid params!');
        }
    }

}
