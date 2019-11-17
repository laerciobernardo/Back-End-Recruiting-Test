<?php

namespace App\DB;

use App\DB\Singleton;

class DBMock extends Singleton
{
    const COLLECTION_NAME = 'tasks.json';
    const DB_FILES = __DIR__ . '/Collections/';

    private $collection;

    protected function __construct()
    {
        $this->collection = array();
    }

    public function add($domain)
    {
        array_push($this->$collection, $domain);
        $this->store(COLLECTION_NAME, $this->$collection);
        return $this->$collection;
    }

    public function update($uuid, $domain)
    {
        $idx = array_search($uuid, array_column(get_object_vars($this->$collection), 'uuid'));
        if ($idx) {
            $this->$collection[$idx] = $domain;
            $this->store(COLLECTION_NAME, $this->$collection);
            return true;
        }
        return false;
    }

    public function delete($uuid)
    {
        $idx = array_search($uuid, array_column(get_object_vars($this->$collection), 'uuid'));
        if ($idx) {
            array_splice($this->$collection, $idx, 1);
            $this->store(self::COLLECTION_NAME, $this->$collection);
            return true;
        }
        return false;
    }

    public function findAll()
    {
        $file = $this->read(self::COLLECTION_NAME);
        return $file;
    }

    public function findById($uuid)
    {
        $idx = array_search($uuid, array_column($this->$collection, 'uuid'));
        if ($idx) {
            return $this->$collection[$idx];
        }
        return null;
    }

    private function store($fileName, $content)
    {
        $file = fopen(self::DB_FILES . self::COLLECTION_NAME, 'w');
        fwrite($file, $content);
        fclose($file);
    }

    private function read($fileName)
    {
      $content = file_get_contents(self::DB_FILES . $fileName);
      if(empty($content)){
         return null;
      }
      return json_encode($content);
    }
}
