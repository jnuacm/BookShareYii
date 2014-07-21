<?php
require_once 'response.php';
class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        // Members
        /**
         * Key which has to be in HTTP USERNAME and PASSWORD headers 
         */
        Const APPLICATION_ID = 'ASCCPE';

        /**
         * Default response format
         * either 'json' or 'xml'
         */
        private $format = 'json';
    
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
		// Check if id was submitted via GET
                if(!isset($_GET['id']))
                    _sendResponse(500, 'Error: Parameter <b>id</b> is missing' );

                $user = User::model()->findByPk($_GET['id']);
                // Did we find the requested user? If not, raise an error
                if(is_null($user))
                    _sendResponse(404, 'No User found with id '.$_GET['id']);
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// Try to assign POST values to attributes
                foreach($_POST as $var=>$value) {
                    // Does the user have this attribute? If not raise an error
                    if($user->hasAttribute($var))
                        $user->$var = $value;
                    else
                        $this->_sendResponse(500, 
                            sprintf('Parameter <b>%s</b> is not allowed for user', $var ));
                }
                // Try to save the user
                if($user->save())
                    $this->_sendResponse(200, CJSON::encode($user));
                else {
                    // Errors occurred
                    $msg = "<h1>Error</h1>";
                    $msg .= sprintf("Couldn't create user");
                    $msg .= "<ul>";
                    foreach($user->errors as $attribute=>$attr_errors) {
                        $msg .= "<li>Attribute: $attribute</li>";
                        $msg .= "<ul>";
                        foreach($attr_errors as $attr_error)
                            $msg .= "<li>$attr_error</li>";
                        $msg .= "</ul>";
                    }
                    $msg .= "</ul>";
                    $this->_sendResponse(500, $msg);
                }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		// Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
                $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
                $put_vars = CJSON::decode($json,true);  //true means use associative array
                
                $user = User::model()->findByPk($_GET['username']);
                // Did we find the requested user? If not, raise an error
                if($user === null)
                    $this->_sendResponse(400, 
                            sprintf("Error: Didn't find any user <b>%s</b> with ID <b>%s</b>.",
                            $_GET['username']));

                // Try to assign PUT parameters to attributes
                foreach($put_vars as $var=>$value) {
                    // Does model have this attribute? If not, raise an error
                    if($user->hasAttribute($var))
                        $user->$var = $value;
                    else {
                        $this->_sendResponse(500, 
                            sprintf('Parameter <b>%s</b> is not allowed for user <b>%s</b>',
                            $var, $_GET['user']) );
                    }
                }
                // Try to save the user
                if($user->save())
                    $this->_sendResponse(200, CJSON::encode($user));
                else
                    // prepare the error $msg
                    // see actionCreate
                    // ...
                    $this->_sendResponse(500, $msg);
        }
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$user = User::model()->findByPk($_GET['id']);
                // Was a user found? If not, raise an error
                if($user === null)
                    $this->_sendResponse(400, 
                            sprintf("Error: Didn't find any user <b>%s</b> with ID <b>%s</b>.",
                            $_GET['user'], $_GET['id']) );

                // Delete the user
                $num = $user->delete();
                if($num>0)
                    $this->_sendResponse(200, $num);    //this is the only way to work with backbone
                else
                    $this->_sendResponse(500, 
                            sprintf("Error: Couldn't delete user <b>%s</b> with ID <b>%s</b>.",
                            $_GET['user'], $_GET['id']) );
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
