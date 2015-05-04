<?php

/**
 * This is the model class for table "tbl_request".
 *
 * The followings are the available columns in table 'tbl_request':
 * @property integer $id
 * @property string $time
 * @property string $from
 * @property string $to
 * @property integer $type
 * @property string $description
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $from0
 * @property User $to0
 */
class Request extends CActiveRecord
{
	const Raised = 0, Accepted = 1, Rejected = 2,
	Done = 3, Cancelled = 4;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, type, status', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('from, to', 'length', 'max'=>64),
			array('time, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, time, from, to, type, description, status', 'safe', 'on'=>'search'),
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
			'from0' => array(self::BELONGS_TO, 'User', 'from'),
			'to0' => array(self::BELONGS_TO, 'User', 'to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time' => 'Time',
			'from' => 'From',
			'to' => 'To',
			'type' => 'Type',
			'description' => 'Description',
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
		$criteria->compare('time',$this->time,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getFromUserRequests($user){
             return Request::model()->findAllByAttributes(array('from'=>$user));
        }
        
        public static function getToUserRequests($user){
             return Request::model()->findAllByAttributes(array('to'=>$user));
        }
        
        public static function getUserAllRequests($user){
            return array('send_requests'=>self::getFromUserRequests($user), 'receive_request'=>self::getToUserRequests($user));
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Request the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
