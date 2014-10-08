<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $area
 * @property integer $is_group
 * @property integer $avatar
 *
 * The followings are the available model relations:
 * @property Book[] $books
 * @property Book[] $books1
 * @property BookUserBorrow[] $bookUserBorrows
 * @property Friendship[] $friendships
 * @property Friendship[] $friendships1
 * @property Request[] $requests
 * @property Request[] $requests1
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password, is_group, avatar', 'required'),
			array('is_group, avatar', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>64),
			array('email, password, area', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('username, email, area, is_group', 'safe', 'on'=>'search'),
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
			'books' => array(self::HAS_MANY, 'Book', 'owner'),
			'books1' => array(self::HAS_MANY, 'Book', 'holder'),
			'bookUserBorrows' => array(self::HAS_MANY, 'BookUserBorrow', 'borrower'),
			'friendships' => array(self::HAS_MANY, 'Friendship', 'user1'),
			'friendships1' => array(self::HAS_MANY, 'Friendship', 'user2'),
			'requests' => array(self::HAS_MANY, 'Request', 'from'),
			'requests1' => array(self::HAS_MANY, 'Request', 'to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'area' => 'Area',
			'is_group' => 'Is Group',
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

		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('is_group',$this->is_group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
        * perform one-way encryption on the password before we store it in the database
        */
        protected function afterValidate() {
            parent::afterValidate();
            $this->password = $this->encrypt($this->password);
        }
        
        public function encrypt($value) {
            return md5($value);
        }
}
