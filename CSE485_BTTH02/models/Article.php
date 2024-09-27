<?php
class Article{
    // Thuộc tính
    private $id;
    private $title;
    private $summary;
    private $cat_name;
    

    public function __construct($id,$title, $summary,$cat_name){
        $this->id = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->cat_name = $cat_name;
    }

    // Setter và Getter
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getSummary(){
        return $this->summary;
    }
    public function getCat_name(){
        return $this->cat_name;
    }
    
}