<?php
    class DBConfig{
    private $con;
    function DBConfig(){
             $this->con = new PDO("mysql:host=localhost;dbname=book_share","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
             return $this;
          }
          
    function get_connect(){
    	return $this->con;
    }
    }
