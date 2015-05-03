<?php
	 require "../config/main.php";
    class User{
        private $username;
        private $email;
        private $password;
        private $area;
        private $is_group;
        private $avatar;
        
        function User($username,$email,$password,$area,$is_group,$avatar){
            $this->username = $username;
            $this->email = $email;
            $this->password = MD5($password);
            $this->area = $area;
            $this->is_group = $is_group;
            $this->avatar = $avatar;
        }
        
        public function SelectUserByName($name){
            //$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor");
            $pdo = new DBConfig();
            $pdo = $pdo->get_connect();
            $query = "SELECT * FROM tbl_user WHERE username = '".$name."';";
            $result = $pdo->query($query);
            if($result != null){
                $result = $result->fetch(PDO::FETCH_ASSOC);
                $this->username= $result["username"];
                $this->password = $result["password"];
                $this->email = $result["email"];
                $this->area = $result["area"];
                $this->is_group = $result["is_group"];
                $this->avatar = $result["avatar"];
            }else{
                $this->username= null;
                $this->password =  null;
                $this->email =  null;
                $this->area =  null;
                $this->is_group =  null;
                $this->avatar =  null;
               }
            return $this;
        }
        
        public function insterUser(){
            //$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor");
            $pdo = new DBConfig();
            $pdo = $pdo->get_connect();
            $query = "INSERT INTO tbl_user(username,email,password,area,is_group,avatar) VALUES('".$this->username."','".$this->email."','".$this->password."','".$this->area."',".$this->is_group.",".$this->avatar.");";
            $result = $pdo->query($query);
        }
        
        public function updateUser(){
            //$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor");
            $pdo = new DBConfig();
            $pdo = $pdo->get_connect();
            $query = "UPDATE tbl_user SET username = '".$this->username."',email = '".$this->email."',password = '".$this->password."',area = '".$this->area."',is_group = ".$this->is_group.",avatar = ".$this->avatar." WHERE username = '".$this->username."';";
            $result = $pdo->query($query);
        }
        
        public function deleteUser(){
            //$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor");
            $pdo = new DBConfig();
            $pdo = $pdo->get_connect();
            $query = "DELETE FROM tbl_user "." WHERE username = '".$this->username."';";
            $result = $pdo->query($query);
        }
        
        public function getUserName(){return $this->username;}
        public function getUserPassword(){return $this->password;}
        public function getUserArea(){return $this->area;}
        public function getUserEmail(){return $this->email;}
        public function getUserIs_group(){return $this->is_group;}
        public function getUserAvatar(){return $this->avatar;}
        
        public function setUserName($username){$this->username = $username;}
        public function setUserPassword($password){return $this->password = $password;}
        public function setUserArea($area){return $this->area = $area;}
        public function setUserEmail($email){return $this->email = $email;}
        public function setUserIs_group($is_group){return $this->is_group = $is_group;}
        public function setUserAvatar($avatar){return $this->avatar = $avatar;}
    }
    
    
