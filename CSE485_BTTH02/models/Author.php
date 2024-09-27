<?php
class Author{
    // Thuộc tính
    private $id;

    private $au_name;

    public function __construct($id,$au_name){
        $this->id = $id;
        $this->au_name = $au_name;
    }

    // Setter và Getter
    public function getId(){
        return $this->id;
    }
        public function getAu_name(){
        return $this->au_name;
    }
}