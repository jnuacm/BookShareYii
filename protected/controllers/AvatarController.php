<?php
require 'response.php';
class AvatarController extends Controller
{
	private static $topSize = 2048000;
	public function actionCreate()
	{
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ( ($_FILES["file"]["size"] <= self::$topSize)
		&& $extension === 'jpg') {
		  if ($_FILES["file"]["error"] > 0) {
		    _sendResponse(404, 'error');
		  } else {
		    if (file_exists("upload/" . $_FILES["file"]["name"])) {
		      echo $_FILES["file"]["name"] . " already exists. ";
		    } else {
		      move_uploaded_file($_FILES["file"]["tmp_name"],
		      "upload/avatar".$_GET['user']. '.' . $extension);
		      $user = User::model()->findByAttributes(array('username'=>$_GET['user']));
		      $user->avatar = $user->avatar + 1;
		      $user->save();
		      _sendResponse(200);
		    }
		  }
		} else {
		  	_sendResponse(404, 'over sized or format error');
		}	
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionUpdate()
	{
		actionCreate();
	}

	public function actionView()
	{

		if(file_exists("upload/avatar".$_GET['user']. '.jpg')){
			$file = "upload/avatar".$_GET['user']. '.jpg';
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
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