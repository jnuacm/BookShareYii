<?php
    class DBConfig{
    private $con;
    function DBConfig(){
             $this->con = new PDO("mysql:host=rdsmf2iu2jm2y2y.mysql.rds.aliyuncs.com;dbname=rk906umf9k789106","rk906umf9k789106","123456",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
             return $this;
          }
          
    function get_connect(){
    	return $this->con;
    }
    }
