<?php
class Category{
    // Thuộc tính
    private $id;
    private $cat_name;

    public function __construct($id,$cat_name){
        $this->id = $id;
        $this->cat_name = $cat_name;
    }

    // Setter và Getter
    public function getId(){
        return $this->id;
    }
   
    public function getCat_name(){
        return $this->cat_name;
    }
}