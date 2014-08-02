<?php

/**
 * This is the model class for table "tbl_friendship".
 *
 * The followings are the available columns in table 'tbl_friendship':
 * @property integer $id
 * @property string $user1
 * @property string $user2
 * @property string $time
 *
 * The followings are the available model relations:
 * @property User $user10
 * @property User $user20
 */
class Friendship extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_friendship';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user1, user2', 'required'),
			array('user1, user2', 'length', 'max'=>64),
			array('time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user1, user2, time', 'safe', 'on'=>'search'),
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
			'user10' => array(self::BELONGS_TO, 'User', 'user1', 'select'=>'username,email,area,is_group'),
			'user20' => array(self::BELONGS_TO, 'User', 'user2', 'select'=>'username,email,area,is_group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user1' => 'User1',
			'user2' => 'User2',
			'time' => 'Time',
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
		$criteria->compare('user1',$this->user1,true);
		$criteria->compare('user2',$this->user2,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getUserFriends($user) {
            $friendship = Friendship::model()->findAllBySql("select * from tbl_friendship where user1=:user or user2=:user", array(':user'=>$user));
            $friends = array();
            foreach($friendship as $users) {
                if($users->attributes['user1'] == $user)
                    $friends[] = $users->attributes['user2'];
                else if($users->attributes['user2'] == $user)
                    $friends[] = $users->attributes['user1'];
            }
            $rows = array();
            foreach($friends as $friend){
                //$rows[] = User::model()->findAllByAttributes(array('username'=>$friend));
                $db = Yii::app()->db;
                $rows[] = $db->createCommand()
                ->select('username,email,area,is_group')
                ->from('tbl_user')
                ->where('username=:user', array(':user'=>$friend))
                ->queryRow();
            }
            return $rows;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Friendship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}        
}
