<?php
require_once 'response.php';
class UserController extends Controller
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
				'actions'=>array('view','create', 'update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','list'),
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
	public function actionView()
	{
                if(!isset($_GET['id']))
                    _sendResponse(500, 'User ID is missing');
                $user = User::model()->findByPk($_GET['id']);
                if(is_null($user))
                    _sendResponse(404, 'No User found');
                else
                    _sendResponse(200, CJSON::encode($user));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$user=new User;
                if(isset($_POST['username']))
		{
                    $user->attributes = array('username'=>$_POST['username'], 'password'=>$_POST['password']
                            ,'email'=>$_POST['email'],'area'=>$_POST['area']);
                    if($user->save()){ 
                        _sendResponse(200, CJSON::encode($user));
                    }else{
                        _sendResponse(403, 'Could not register user');
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
                $json = file_get_contents('php://input'); 
                $put_vars = CJSON::decode($json,true);
                $user = User::model()->findByPk($id);
                if($user === null)
                    $this->_sendResponse(400, 'No User found');
                
                foreach($put_vars as $var=>$value)
                    if($user->hasAttribute($var))
                        $user->$var = $value;
                if($user->save())
                    $this->_sendResponse(200, CJSON::encode($user));
                else
                    $this->_sendResponse(500, 'Could not Update User');
        }
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
                $users = $this->actionList();
                _sendResponse(200, CJSON::encode(array('user'=>$users)));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$users = User::model()->findAll();
                if(empty($users)) 
                    $this->_sendResponse(200, 'No Users');
                else
                {
                    $rows = array();
                    foreach($users as $user)
                    $rows[] = $user->attributes;
                    $this->_sendResponse(200, CJSON::encode($rows));
                }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
