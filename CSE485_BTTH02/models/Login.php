<?php
class Login{
    // Thuộc tính

    private $id;
    private $username;
    private $pwd;


    public function __construct($id, $username,$pwd){
        $this->id = $id;
        $this->username = $username;
        $this->pwd = $pwd;
    }

    // Setter và Getter
    public function getIdUser(){
        return $this->id;
    }

    public function setIdUser($id){
        return $this->id = $id;
    }

    public function getUserNam(){
        return $this->username;
    }

    public function setUserName($username){
        return $this->username = $username;
    }

    public function getPwd(){
        return $this->pwd;
    }

    public function setPwd($pwd){
        return $this->pwd = $pwd;
    }
}