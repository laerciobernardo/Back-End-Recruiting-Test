<?php

namespace App\Models;

use App\DB\DBMock;

class Task {
   private $uui = '';
   private $type = "";
   private $content = "";
   private $sortOrder = 0;
   private $done = false;
   private $dateCreated = "";
   private static $store;

   public function __construct($type, $content, $sortOrder){
      $this->uuid = md5(uniqid(rand(), true));
      $this->type = $type;
      $this->content = $content;
      $this->sortOrder = $sortOrder;
      $this->dateCreated = new Date();
   }

   public function setAsDone($uuid){
      $this->$done = true;
   }

   public function setType($type){
      $this->$type = $type;
   }
   
   public function getType(){
      return $this->type;
   }

   public function setContent($content){
      $this->$content = $content;
   }
   
   public function getContent(){
      return $this->content;
   }

   public function setSortOrder($order){
      $this->$sortOrder = $order;
   }
   
   public function getSortOrder(){
      return $this->sortOrder;
   }

   public function getTask(){
      return $this;
   }
   
   //Reflector mehods to DBMock
   public static function save($domain){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->add($domain);
   }

   public static function update($uuid, $domain){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->update($uuid, $domain);
   }

   public static function remove($uuid){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->remove($uuid);
   }

   public static function find(){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->findAll();
   }

   public static function findOne($uuid){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->findOne($uuid);
   }

}