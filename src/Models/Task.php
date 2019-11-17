<?php

namespace App\Models;

use App\DB\DBMock;

class Task {
   private $uuid = "";
   private $type = "";
   private $content = "";
   private $sortOrder = 0;
   private $done = false;
   private $dateCreated = "";
   private $errorMessage = "";
   private $typesAllowed = ["shopping", "work"];

   public function __construct($type, $content, $sortOrder){
      if($this->validateType($type) && $this->validateContent($content)){
         $this->uuid = md5(uniqid(rand(), true));
         $this->type = $type;
         $this->content = $content;
         $this->sortOrder = $sortOrder;
         $this->dateCreated = new \DateTime();
      };

   }

   private function validateType($type){
      if(!\in_array($type, $this->typesAllowed)){
         $this->setErrorMessage("The task type you provided is not supported. You can only use shopping or work.");
         return null;
      }
   }

   private function validateContent($content){
      if(!isset($content) || empty($content)){
         $this->setErrorMessage("Bad move! Try removing the task instead of deleting its content.");
         return null;
      }
   }

   public function setAsDone($uuid){
      $this->$done = true;
   }

   public function getUUID(){
      return $this->uuid;
   }

   public function setType($type){
      $this->type = $type;
   }
   
   public function getType(){
      return $this->type;
   }

   public function setContent($content){
      $this->content = $content;
   }
   
   public function getContent(){
      return $this->content;
   }

   public function setSortOrder($order){
      $this->sortOrder = $order;
   }
   
   public function getSortOrder(){
      return $this->sortOrder;
   }

   public function getTask(){
      return $this;
   }

   private function setErrorMessage($message){
      $this->errorMessage = $message;
   }

   public function getErrrorMessage(){
      return $this->errorMessage;
   }
   
   //Reflector mehods to DBMock
   public static function save($domain){
      $db = DBMock::getInstance();
      $saved = $db->add($domain);
      return $saved;
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
      return DBMock::getInstance()->findAll();
   }

   public static function findOne($uuid){
      if(!isset(self::$store)){
         self::$store = DBMock::getInstance();
      }
      return self::$store->findOne($uuid);
   }

}