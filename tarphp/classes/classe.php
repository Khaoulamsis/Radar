<?php

class classe{
    private $id_classe;
    private $code;
    private $id;
    
    function __construct($id_classe, $code , $id) {
        $this->id_classe = $id_classe;
        $this->code = $code;
        $this->id = $id;
    }
    function getId_classe() {
        return $this->id_classe;
    }

    function getCode() {
        return $this->code;
    }

    function setId_classe($id_classe) {
        $this->id_classe = $id_classe;
    }

    function setCode($code) {
        $this->code = $code;
    }
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }



}
