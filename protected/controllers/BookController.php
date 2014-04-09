<?php

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','mbbooklist'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Book;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Book');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Book('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Book']))
			$model->attributes=$_GET['Book'];

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
        
        public function actionMbAddBook(){
                $model=new Book;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);
                if(isset($_POST['Book']))//第二次请求时已带上Book的其他信息
                {
                        $model= Book::model()->findByAttributes(array('isbn' => Yii::app()->request->getParam('isbn')));
                        if($model === null){
                                $model->attributes = $_POST['Book'];
                        }
                        userAddBook(Yii::app()->request->getParam('isbn'));
                }else if(null !== Yii::app()->request->getParam('isbn')){//第一次请求时只带上isbn
                        $model= Book::model()->findByAttributes(array('isbn' => Yii::app()->request->getParam('isbn')));
                        if($model === null)
                                echo 'book not exists';
                        else
                                userAddBook(Yii::app()->request->getParam('isbn'));
                }
        }
        
        public function actionMbBookList(){
            $sql='SELECT tbl_book.id, tbl_book.name, tbl_book.isbn, tbl_book.author, tbl_book.description, tbl_book.publisher, tbl_book_user_own.status 
                FROM tbl_book, tbl_book_user_own WHERE tbl_book_user_own.book_id = tbl_book.id
                AND tbl_book_user_own.owner_id ='.Yii::app()->user->id;
            $cmd=Yii::app()->db->createCommand($sql);
            $ownedResults=$cmd->queryAll();
            $sql='SELECT tbl_book.id, tbl_book.name, tbl_book.isbn, tbl_book.author, tbl_book.description, tbl_book.publisher, tbl_book_user_borrow.borrow_time 
                FROM tbl_book, tbl_book_user_borrow WHERE tbl_book_user_borrow.book_id = tbl_book.id
                AND tbl_book_user_borrow.borrower_id ='.Yii::app()->user->id;
            $cmd=Yii::app()->db->createCommand($sql);
            $borrowedResults=$cmd->queryAll();
            echo CJSON::encode(array("ownedBooks"=>$ownedResults, "borrowedBooks"=>$borrowedResults));
        }
        
        public function actionMbBorrow(){
            $ownerId = Yii::app()->request->getParam('ownerId');
            $bookId = Yii::app()->request->getParam('bookId');
            
        }
        
        protected function userAddBook($bookId){
            $sql = 'insert into tbl_book_user_own values (:bookId,:ownerId,0)';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(":bookId", $bookId, PDO::PARAM_INT); 
            $cmd->bindValue(":ownerId",Yii::app()->user->id, PDO::PARAM_INT); 
            return $cmd->execute();
        }
}
