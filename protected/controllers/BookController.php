<?php
require_once 'response.php';
class BookController extends Controller
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
		//	'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('allList','ownList','borrowedList','history','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'create','delete'),
				'users'=>array('@'),
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
		if(!isset($id)){
                    _sendResponse(500, 'Book ID is missing');
                }
                $book = Book::model()->findByPk($id);
                if(is_null($book)){
                    _sendResponse(404, 'No Book found');
                }else{
                    _sendResponse(200, CJSON::encode($book));
                }
	}

	public function actionCreate()
	{
		$model=new Book;
		if(isset($_POST['isbn']))
		{
                    $model->attributes = array('isbn'=>$_POST['isbn'], 'name'=>$_POST['name'],'description'=>$_POST['description']
                            ,'author'=>$_POST['author'],'publisher'=>$_POST['publisher'],'owner'=> Yii::app()->user->id,'holder'=>Yii::app()->user->id
                            ,'status'=>'GOOD');
                    if($model->save()){ 
                        $user = Yii::app()->user->id;
                        $own_books = Book::getUserOwnBooks($user);
                        $borrowed_books = Book::getUserBorrowedBooks($user);
                        _sendResponse(200, CJSON::encode(array('own_book'=>$own_books, 'borrowed_book'=>$borrowed_books)));
                    }else{
                        _sendResponse(404, 'Could not Create Book');
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

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
                $user = Yii::app()->user->id;
                $own_books = Book::getUserOwnBooks($user);
                $borrowed_books = Book::getUserBorrowedBooks($user);
                _sendResponse(200, CJSON::encode(array('own_book'=>$own_books, 'borrowed_book'=>$borrowed_books)));
	}

	/**
	 * Lists all models.
	 */
	public function actionAllList($user)
	{
            $own_books = Book::getUserOwnBooks($user);
            $borrowed_books = Book::getUserBorrowedBooks($user);
            _sendResponse(200, CJSON::encode(array('own_book'=>$own_books, 'borrowed_book'=>$borrowed_books)));
	}

        public function actionOwnList($user){
            $books = Book::getUserOwnBooks($user);
            _sendResponse(200, CJSON::encode($books));
        }
        
        public function actionBorrowedList($user){
            $books = Book::getUserBorrowedBooks($user);
            _sendResponse(200, CJSON::encode($books));
        }
        
        public function actionHistory($id) {
            $history = BookUserBorrow::getBookHistory($id);
            _sendResponse(200, CJSON::encode($history));
        }

        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Book('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Book'])){
			$model->attributes=$_GET['Book'];
                }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Book the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Book::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Book $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
