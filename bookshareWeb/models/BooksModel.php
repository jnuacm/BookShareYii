<?php
	require "../config/main.php";
    class Books{
        private $books;
        function Books(){
            $this->books = array();
            return $this;
          }
        
        function selectBooksByOwner($name){
            //$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            $pdo = new DBConfig();
            $pdo = $pdo->get_connect();
            $query = "SELECT * FROM tbl_book WHERE owner = '".$name."';";
            $result = $pdo->query($query);
            if($result != null){
                    $result = $result->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $owner = $row['owner'];
                        $name = $row['name'];
                        $id = $row['id'];
                        $isbn = $row['isbn'];
                        $author = $row['author'];
                        $description = $row['description'];
                        $publisher = $row['publisher'];
                        $holder = $row['holder'];
                        $visibility = $row['visibility'];
                        $large_img = $row['large_img'];
                        $medium_img = $row['medium_img'];
                        $small_img = $row['small_img'];
                        $tags = $row['tags'];
                        $book = array('owner'=>$owner,'name'=>$name,'id'=>$id,'isbn'=>$isbn,'author'=>$author,'description'=>$description,'publisher'=>$publisher,'holder'=>$holder,'visibility'=>$visibility,'large_img'=>$large_img,'medium_img'=>$medium_img,'small_img'=>$small_img,'tags'=>$tags);
                        array_push($this->books,$book);
                        }
                }
          }
          
        function selectBooksByOwnerIsLent($name){
        		//$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            	$pdo = new DBConfig();
             $pdo = $pdo->get_connect();
            	$query = "SELECT * FROM tbl_book WHERE owner = '".$name."'AND owner != holder;";
            	$result = $pdo->query($query);
            	if($result != null){
            		$result = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    $owner = $row['owner'];
                    $name = $row['name'];
                    $id = $row['id'];
                    $isbn = $row['isbn'];
                    $author = $row['author'];
                    $description = $row['description'];
                    $publisher = $row['publisher'];
                    $holder = $row['holder'];
                    $visibility = $row['visibility'];
                    $large_img = $row['large_img'];
                    $medium_img = $row['medium_img'];
                    $small_img = $row['small_img'];
                    $tags = $row['tags'];
                    $book = array('owner'=>$owner,'name'=>$name,'id'=>$id,'isbn'=>$isbn,'author'=>$author,'description'=>$description,'publisher'=>$publisher,'holder'=>$holder,'visibility'=>$visibility,'large_img'=>$large_img,'medium_img'=>$medium_img,'small_img'=>$small_img,'tags'=>$tags);
                    array_push($this->books,$book);
                    }
                }
          }
        function selectBooksByOwnerIsBorrowed($name){
        		//$pdo = new PDO("mysql:host=localhost;dbname=book_share","root","toor",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
            	$pdo = new DBConfig();
             $pdo = $pdo->get_connect();
            	$query = "SELECT * FROM tbl_book WHERE holder = '".$name."'AND owner != holder;";
            	$result = $pdo->query($query);
            	if($result != null){
            		$result = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    $owner = $row['owner'];
                    $name = $row['name'];
                    $id = $row['id'];
                    $isbn = $row['isbn'];
                    $author = $row['author'];
                    $description = $row['description'];
                    $publisher = $row['publisher'];
                    $holder = $row['holder'];
                    $visibility = $row['visibility'];
                    $large_img = $row['large_img'];
                    $medium_img = $row['medium_img'];
                    $small_img = $row['small_img'];
                    $tags = $row['tags'];
                    $book = array('owner'=>$owner,'name'=>$name,'id'=>$id,'isbn'=>$isbn,'author'=>$author,'description'=>$description,'publisher'=>$publisher,'holder'=>$holder,'visibility'=>$visibility,'large_img'=>$large_img,'medium_img'=>$medium_img,'small_img'=>$small_img,'tags'=>$tags);
                    array_push($this->books,$book);
                    }
                }
          }
          
        function getBooks(){
            return $this->books;
          }
    }


