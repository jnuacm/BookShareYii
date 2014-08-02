<?php
require_once 'response.php';
class FriendshipController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('list','view','friend','create','delete'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Friendship;
                if(isset($_POST['user2']))
		{
                    $model->attributes = array('user1'=>Yii::app()->user->id, 'user2'=>$_POST['user2']
                            ,'time'=>new CDbExpression('NOW()'));
                    if($model->save()){ 
                        $user = Yii::app()->user->id;
                        $friends = Friendship::getUserFriends($user);
                        _sendResponse(200, CJSON::encode($friends));
                    }else{
                        _sendResponse(403, 'Could not create relation');
                    }
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Friendship']))
		{
			$model->attributes=$_POST['Friendship'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($friend)
	{
                $user = Yii::app()->user->id;
                $friendship = Friendship::model()->findByAttributes(array());
                $friendship = Friendship::model()->findBySql("select * from tbl_friendship where user1=:user and user2=:friend", array(':user'=>$user,':friend'=>$friend));
                if($friendship === null)
                    $friendship = Friendship::model()->findBySql("select * from tbl_friendship where user1=:friend and user2=:user", array(':user'=>$user,':friend'=>$friend));
                if($friendship === null)
                    _sendResponse(400, 'User is not your friend');
                else {
                    $friendship->delete();
                    $friends = Friendship::getUserFriends($user);
                    _sendResponse(200, CJSON::encode($friends));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionlist()
	{
		$models = Friendship::model()->findAll();
                if(empty($models)) 
                    $this->_sendResponse(200, 'No Friendship');
                else
                {
                    $rows = array();
                    foreach($modelss as $model)
                    $rows[] = $model->attributes;
                    $this->_sendResponse(200, CJSON::encode($rows));
                }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Friendship('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Friendship']))
			$model->attributes=$_GET['Friendship'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionFriend($user) {
            $friends = Friendship::getUserFriends($user);
            _sendResponse(200, CJSON::encode($friends));
        }

        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Friendship the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Friendship::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Friendship $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='friendship-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
