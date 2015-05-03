<?php
    class Book{
        private $owner;
        private $id;
        private $isbn;
        private $author;
        private $description;
        private $publisher;
        private $holder;
        private $visibility;
        private $large_img;
        private $medium_img;
        private $small_img;
        private $tags;
        
        function Book($owner,$id,$isbn,$author,$description,$publisher,$holder,$visibility,$large_img,$medium_img,$small_img,$tags){
        $this->owner = $owner;
        $this->id = $id;
        $this->isbn = $isbn;
        $this->author = $author;
        $this->description = $description;
        $this->publisher = $publisher;
        $this->holder = $holder;
        $this->visibility = $visibility;
        $this->large_img = $large_img;
        $this->medium_img = $medium_img;
        $this->small_img = $small_img;
        $this->tags = $tags;
        return $this;
        }
        
        function getBookOwner(){
        return $this->owner; 
        }
        function getBookId(){
        return $this->id;
        }
        function getBookIsbn(){
        return $this->isbn;
        }
        function getBookAuthor(){
        return $this->author;
        }
        function getBookDescription(){
        return $this->description;
        }
        function getBookPublisher(){
        return $this->publisher;
        }
         function getBookHolder(){
         return $this->holder;
        }
        function getBookVisibility(){
        return $this->visibility;
        }
        function getBookLarge_img(){
        return $this->large_img;
        }
        function getBookMedium_img(){
        return $this->medium_img;
        }
        function getBookSmall_img(){
        return $this->small_img;
        }
        function getBookTags(){
        return $this->tags;
        }
        
    }
