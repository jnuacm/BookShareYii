<?php
include 'protected/controllers/response.php';
include 'protected/controllers/PushMessage.php';
class CommentController extends Controller
{
	public function actionListOnIsbn(){
		$model = Comment::model()->findAllByAttributes(array('isbn'=>$_GET['isbn']));
		_sendResponse(200, CJSON::encode($model));
	}
	
	public function actionCreate()
	{
		$model = new Comment;
		$model->attributes = array('author'=>Yii::app()->user->id, 'isbn'=>$_GET['isbn'],
			'content'=>$_POST['content'], 'time'=>new CDbExpression('NOW()'));
		if($model->save()){
			pushMessage_android(null, array("subject"=>"comment", "isbn"=>$_GET['isbn']), 3);
			_sendResponse(200);
		}else{
			_sendResponse(404);
		}
	}

	public function actionDelete()
	{
		$model = Comment::model()->findByPk($id);
		if($model->delete()){
			pushMessage_android(null, array("subject"=>"comment", "isbn"=>$_GET['isbn']), 3);
			_sendResponse(200);
		}else{
			_sendResponse(404);
		}
	}

	public function actionUpdate()
	{
		$model = Comment::model()->findByPk($_GET['id']);
		$data = array();
		parse_str(file_get_contents('php://input'), $data);
		$model->content = $data['content'];
		if($model->save()){
			pushMessage_android(null, array("subject"=>"comment", "isbn"=>$_GET['isbn']), 3);
			_sendResponse(200);
		}else{
			_sendResponse(404);
		}
	}

	public function actionView()
	{
		$model = Comment::model()->findByPk($id);
		if($model != null){
			_sendResponse(200, CJSON::encode($model));
		}else{
			_sendResponse(404);
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}