<?php

namespace App\DB;

class DBMock {
    private $store = [];
    public static $instance;

    private function __construct(){}

    private function __clone(){}

    private function __wakeup(){}

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($domain){
        $idx = array_search($uuid, array_column($this->store, $domain['uuid']));
        if(!$idx){
            array_push($this->store, $domain);
            return $domain;
        }
    }

    public function update($uuid, $domain){
        $idx = array_search($uuid, array_column($this->store, 'uuid'));

        if($idx){
            $this->store[$idx] = $domain;
            return true;
        }

        return false;
    }

    public function delete($uuid){
        $idx = array_search($uuid, array_column($this->store, 'uuid'));
        if($idx){
           array_splice($this->store, $idx, 1);
           return true;
        }
        return false;
    }
    
    public function findAll(){
        return $this->store;
    }

    public function findById($uuid){
        $idx = array_search($uuid, array_column($this->store, 'uuid'));
        if($idx){
            return $this->store[$idx];
        }
        return null;
    }
}