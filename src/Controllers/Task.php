<?php

namespace App\Controllers;

class Task{
    public function find($param){
        echo "no method find";
        echo "<pre>";
        var_dump($param);
        return array(statusCode => 200, data => 'Success');
    }

    public function findOne($param){
        echo "no method findOne";
        echo "<pre>";
        var_dump($param);
        return array(statusCode => 200, data => 'Success');
    }

    public function create($param, $payload){
        echo "no method create";
        echo "<pre>";
        var_dump($param);
        var_dump($payload);
        return array(statusCode => 200, data => 'Success');
    }

    public function update($param, $payload){
        echo "no method update";
        echo "<pre>";
        var_dump($param);
        var_dump($payload);
        return array(statusCode => 200, data => 'Success');
    }

    public function remove($param){
        echo "no method remove";
        echo "<pre>";
        var_dump($param);
        return array(statusCode => 200, data => 'Success');
    }
}