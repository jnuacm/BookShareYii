<?php

/**
 * This is the model class for table "tbl_book".
 *
 * The followings are the available columns in table 'tbl_book':
 * @property integer $id
 * @property string $name
 * @property string $isbn
 * @property string $author
 * @property string $description
 * @property string $publisher
 * @property string $owner
 * @property string $holder
 * @property integer $status
 * @property integer $visibility
 * @property string $large_img
 * @property string $medium_img
 * @property string $small_img
 * @property string $tags
 * 
 * The followings are the available model relations:
 * @property User $owner0
 * @property User $holder0
 * @property BookUserBorrow[] $bookUserBorrows
 */
class Book extends CActiveRecord
{
	
	const VisibleToAll = 0, VisibleToFriends = 1;
	const Unavailable = 0, Borrowable = 1, Buyable = 2;//位压缩，3即为可借可买
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, isbn, owner, holder, tags', 'required'),
			array('status, visibility', 'numerical', 'integerOnly'=>true),
			array('name, author, publisher, large_img, medium_img, small_img', 'length', 'max'=>256),
			array('isbn', 'length', 'max'=>32),
			array('owner, holder', 'length', 'max'=>64),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, isbn, author, description, publisher, owner, holder, status, visibility', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'owner' => array(self::BELONGS_TO, 'User', 'owner'),
			'holder' => array(self::BELONGS_TO, 'User', 'holder'),
			'bookUserBorrows' => array(self::HAS_MANY, 'BookUserBorrow', 'book_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'isbn' => 'Isbn',
			'author' => 'Author',
			'description' => 'Description',
			'publisher' => 'Publisher',
			'owner' => 'Owner',
			'holder' => 'Holder',
			'status' => 'Status',
			'visibility' => 'Visibility',
			'large_img' => 'Large Image',
			'medium_img' => 'Medium Image',
			'small_img' => 'Small Image',
			'tags' => 'Tags',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$bookCriteria=new CDbCriteria;

		$bookCriteria->compare('name',$this->name,true);
		$bookCriteria->compare('isbn',$this->isbn,true);
		$bookCriteria->compare('author',$this->author,true);
		$bookCriteria->compare('publisher',$this->publisher,true);
		$bookCriteria->select = 'id, name, isbn, author, publisher, small_img, status, 
				visibility, holder, owner';
		$rows = Book::model()->findAll($bookCriteria);
	// 	return $rows;
		$friendCriteria = new CDbCriteria;
		$friendCriteria->condition = 'user1 = :user OR user2 = :user';
		$friendCriteria->params = array(':user'=>Yii::app()->user->id);
		$friend = array();
		if(!Yii::app()->user->isGuest){
			$friendships = Friendship::model()->findAll($friendCriteria);
			foreach($friendships as $fs){
				if($fs['user1'] === Yii::app()->user->id){
					$friend[] = $fs['user2'];
				}else{
					$friend[] = $fs['user1'];
				}
			}
		}
		$books = array();
		foreach($rows as $row){
			if($row['visibility'] == self::VisibleToAll || ($row['visibility'] === 
					self::VisibleToFriends && in_array($row['holder'], $friend))){
				$books[] = $row;
			}
		}
		return $books;
	}
	
        public static function getUserOwnBooks($user){
        	$criteria=new CDbCriteria;
			$criteria->select='id, name, isbn, author, publisher, owner, holder, status, 
        			visibility, small_img, tags'; // only select the 'title' column
			$criteria->condition='owner=:owner';
			$criteria->params=array(':owner'=>$user);
			return Book::model()->findAll($criteria);
        }
        
        public static function getUserBorrowedBooks($user){
        	$criteria=new CDbCriteria;
        	$criteria->select='id, name, isbn, author, publisher, owner, holder, status,
        			visibility, small_img, tags'; // only select the 'title' column
        	$criteria->condition='holder=:holder and owner<>holder';
        	$criteria->params=array(':holder'=>$user);
           	return Book::model()->findAll($criteria);
        }
        
        public static function getUserAllBooks($user){
            return array('own_book'=>self::getUserOwnBooks($user), 'borrowed_book'=>self::getUserBorrowedBooks($user));
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Book the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
