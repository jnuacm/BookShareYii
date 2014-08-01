<?php

/**
 * This is the model class for table "tbl_book_user_borrow".
 *
 * The followings are the available columns in table 'tbl_book_user_borrow':
 * @property integer $id
 * @property integer $book_id
 * @property string $borrower
 * @property string $borrow_time
 * @property string $due_time
 * @property string $return_time
 *
 * The followings are the available model relations:
 * @property Book $book
 * @property User $borrower0
 */
class BookUserBorrow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_book_user_borrow';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, borrower', 'required'),
			array('book_id', 'numerical', 'integerOnly'=>true),
			array('borrower', 'length', 'max'=>64),
			array('borrow_time, due_time, return_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, borrower, borrow_time, due_time, return_time', 'safe', 'on'=>'search'),
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
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'borrower0' => array(self::BELONGS_TO, 'User', 'borrower'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'book_id' => 'Book',
			'borrower' => 'Borrower',
			'borrow_time' => 'Borrow Time',
			'due_time' => 'Due Time',
			'return_time' => 'Return Time',
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
		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('borrower',$this->borrower,true);
		$criteria->compare('borrow_time',$this->borrow_time,true);
		$criteria->compare('due_time',$this->due_time,true);
		$criteria->compare('return_time',$this->return_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookUserBorrow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
