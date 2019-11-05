<?php

namespace App\DB;

use App\DB\Singleton;

class DBMock extends Singleton{
   private $store;

   protected function __construct(){
      var_dump("CONSTRUCT");
      echo(date_format(new \DateTime(), 'Y-m-d H:i:s'));
      $this->$store = array();
   }

   public function add($domain){
      array_push($this->$store, $domain);
      return $this->store;
   }
   
   public function update($uuid, $domain){
      $idx = array_search($uuid, array_column(get_object_vars($this->$store), 'uuid'));
      if($idx){
         $this->$store[$idx] = $domain;
         return true;
      }
      return false;
   }
   
   public function delete($uuid){
      $idx = array_search($uuid, array_column(get_object_vars($this->$store), 'uuid'));
      if($idx){
         array_splice($this->$store, $idx, 1);
         return true;
      }
      return false;
   }
   
   public function findAll(){
      return $this->$store;
   }
   
   public function findById($uuid){
      $idx = array_search($uuid, array_column($this->$store, 'uuid'));
      if($idx){
         return $this->$store[$idx];
      }
      return null;
   }
}
