<?php
require_once 'response.php';
require_once 'PushMessage.php';
class RequestController extends Controller
{
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
				'actions'=>array('list','view','fromUserList','toUserList','delete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
             _sendResponse(404, 'Request ID is missing');
        }
        $request = Request::model()->findByPk($id);
        if(is_null($request)){
            _sendResponse(404, 'No Request found');
        }else{
            _sendResponse(200, CJSON::encode($request));
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$request=new Request;
		if(isset($_POST['to']))
		{
            $request->attributes = array('time'=>new CDbExpression('NOW()'),'from'=>Yii::app()->user->id,'to'=>$_POST['to']
                    ,'type'=>$_POST['type'],'description'=>$_POST['description'],'status'=>Request::Raised);
            if($request->save()){
                $uid = Userid::model()->findByAttributes(array('username'=>$_POST['to']));
            	if($uid !== null){
            		pushMessage_android($uid->userid, array('subject'=>'request', 'id'=>$request->id));
            	}
            	_sendResponse(200, CJSON::encode($request));
            }else{
                _sendResponse(404, 'Could not Create Request');
          	}
		}
	}

    private function lendBook($request){
        $from = $request->from;
        $desc = CJSON::decode($request->description);
        $bookId = $desc['bookid'];
        $book = Book::model()->findByPk($bookId);
        $borrow = new BookUserBorrow;
        $borrow->attributes = array('book_id'=>$bookId, 'borrower'=>$from, 'borrow_time' => new CDbExpression('NOW()'), 'due_time'=>null, 'return_time'=>null);
        $book->holder = $from;
        $book->status = Book::Unavailable;
        $request->status = Request::Done;
        $transaction = Yii::app()->db->beginTransaction();
        try{
        	$book->save();
        	$request->save();
        	$transaction->commit();
        	return true;
        }catch(Exception $e){
        	$transaction->rollback();
        	return false;
        }
    }
        
    private function regainBook($request){
        $desc = CJSON::decode($request->description);
        $bookId = $desc['bookid'];
        $book = Book::model()->findByPk($bookId);
        $sql = 'SELECT MAX(id), book_id, borrower, borrow_time, due_time, return_time FROM tbl_book_user_borrow WHERE book_id=:book_id';
        $borrow = BookUserBorrow::model()->findBySql($sql, array(':book_id' => $bookId));
        $borrow->return_time = new CDbExpression('NOW()');
        $book->holder = $book->owner;
        $book->status = Book::Borrowable;
        $request->status = Request::Done;
        $transaction = Yii::app()->db->beginTransaction();
        try {
        	$book->save();
        	$request->save();
        	$transaction->commit();
        	return true;
        } catch (Exception $e) {
        	$transaction->rollback();
        	return false;
        }
    }
        
    private function buyBook($request) {
        $desc = CJSON::decode($request->description);
        $bookId = $desc['bookid'];
        $book = Book::model()->findByPk($bookId);
        $book->owner = $book->holder = $request->from;
        $book->status = Book::Unavailable;
        $request->status = Request::Done;
        $transaction = Yii::app()->db->beginTransaction();
        try{
        	$book->save();
        	$request->save();
        	$transaction->commit();
        	return true;
        }catch(Exception $e){
        	$transaction->rollback();
        	return false;
        }
    }


    private function makeFriend($request) {
        $friendship = new Friendship;
        $friendship->attributes = array('user1'=>$request->from, 'user2'=>$request->to, 'time'=>new CDbExpression('NOW()'));
        $request->status = Request::Done;
        $transaction = Yii::app()->db->beginTransaction();
        try{
        	$friendship->save();
        	$request->save();
        	$transaction->commit();
        	return true;
        }catch(Exception $e){
        	$transaction->rollback();
        	return false;
        }
    }

     /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            $motion = array(1=>'lendBook', 2=>'regainBook', 3=>'makeFriend', 4=>'buyBook');
            $request = Request::model()->findByPk($id);
            if($request == null){
                _sendResponse(404);
            }
            $data = array();
            $flag = false;
            parse_str(file_get_contents('php://input'), $data);
            if(isset($data['status'])){
                if($data['status'] == Request::Done){
                    $flag = $this->$motion[$request->type]($request);
                }else if($data['status'] == Request::Rejected || $data['status'] == Request::Accepted
                		 || $data['status'] == Request::Cancelled){
                    $flag = $this->turnDownOrAcknowledge($request, $data['status']);
                }
                if($flag){
	                $target = $request->from === Yii::app()->user->id? $request->to : $request->from;
	                $uid = Userid::model()->findByAttributes(array('username'=>$target));
	                if($uid !== null){
	                	pushMessage_android($uid->userid, array('subject'=>'request', 'id'=>$id));
	                }
	                _sendResponse(200);
                }else{
                	_sendResponse(404);
                }
            }
	}

        private function turnDownOrAcknowledge($request, $status){
            $request->status = $status;
            if($request->save()){
                return true;
            }else{
            	return false;
            }
        }
       
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
	}

	/**
	 * Lists all models.
	 */
	public function actionList($user)
	{
		$from_user_requests = Request::getSendRequests($user);
                $to_user_requests = Request::getReceiveRequests($user);
                _sendResponse(200, CJSON::encode(array('send_requests'=>$from_user_requests, 'receive_request'=>$to_user_requests)));
	}
        
        public function actionFromUserList($user){
            $requests = Request::getFromUserRequests($user);
            _sendResponse(200, CJSON::encode($requests));
        }
        
        public function actionToUserList($user){
            $requests = Request::getToUserRequests($user);
            _sendResponse(200, CJSON::encode($requests));
        }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Request('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Request']))
			$model->attributes=$_GET['Request'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Request the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Request::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Request $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
