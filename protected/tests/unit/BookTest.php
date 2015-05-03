<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BookTest
 *
 * @author Kam
 */
class BookTest extends CTestCase{
    //put your code here
    public $fixtures=array(
      'users'=>'User',
      'books'=>'Book',
    );
    public function testGetUserOwnBooks(){
        $books = Book::getUserOwnBooks('gg');
        $this->assertTrue(is_array($books));
        $ar = array(array('id'=>1,'name'=>'大黄','isbn'=>'12234','author'=>'大黄','description'=>'大黄','publisher'=>'光复出版社','owner'=>'gg','status'=>'GOOD'),
            array('id'=>2,'name'=>'大红','isbn'=>'123542','author'=>'大黄','description'=>'大黄','publisher'=>'光复出版社','owner'=>'gg','status'=>'GOOD'),
            array('id'=>3,'name'=>'大紫','isbn'=>'3513451234','author'=>'大黄','description'=>'大黄','publisher'=>'光复出版社','owner'=>'gg','status'=>'GOOD'));
        $this->assertEquals(count($ar), count($books));
    }
}
