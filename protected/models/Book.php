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
 * @property string $status
 *
 * The followings are the available model relations:
 * @property User $owner0
 */
class Book extends CActiveRecord
{
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
			array('name, isbn, owner, holder, status', 'required'),
			array('name, author, publisher', 'length', 'max'=>256),
			array('isbn, status', 'length', 'max'=>32),
			array('owner, holder', 'length', 'max'=>64),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, isbn, author, description, publisher, owner, holder, status', 'safe', 'on'=>'search'),
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
                        'book' => array(self::HAS_ONE, 'BookUserBorrow', 'book_id'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('owner',$this->owner,true);
                $criteria->compare('holder',$this->holder,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public static function getUserOwnBooks($user){
             return Book::model()->findAllByAttributes(array('owner'=>$user));
        }
        
        public static function getUserBorrowedBooks($user){
             return BookUserBorrow::model()->findAllByAttributes(array('borrower'=>$user));
        }
        
        public static function getUserAllBooks($user){
            return array('own_book'=>self::getUserOwnBooks($user), 'borrowed_book'=>self::getUserBorrowedBooksBooks($user));
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
