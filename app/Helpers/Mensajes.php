<?php

namespace App\Helpers;

class Mensajes{
    public $log = array(); //["type"=>"error","mensaje"=>""]

    public function add($respuesta){

        if($respuesta["response"]){
            $insert = array("type"=>"success","message"=>$respuesta["message"]);
            array_push($this->log,$insert);
        }
        if(!$respuesta["response"]){
            $insert = array("type"=>"error","message"=>$respuesta["message"]);
            array_push($this->log,$insert);
        }
        return $this;
    }

}