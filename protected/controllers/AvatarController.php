<?php

class AvatarController extends Controller
{
	private $allowedExts = array("gif", "jpeg", "jpg", "png");
	public function actionCreate()
	{
		$allowedExts = $this->allowedExts;
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ( ($_FILES["file"]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES["file"]["error"] > 0) {
		    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		  } else {
		    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		    echo "Type: " . $_FILES["file"]["type"] . "<br>";
		    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
		    if (file_exists("upload/" . $_FILES["file"]["name"])) {
		      echo $_FILES["file"]["name"] . " already exists. ";
		    } else {
		      move_uploaded_file($_FILES["file"]["tmp_name"],
		      "upload/avatar".$_GET['user']. '.' . $extension);
		      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		    }
		  }
		} else {
		  echo "Invalid file";
		}	
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionUpdate()
	{
		$this->render('update');
	}

	public function actionView()
	{
		$ext;
		foreach($this->allowedExts as $ext){
			if(file_exists("upload/avatar".$_GET['user']. '.' .$ext)){
				break;
			}
		}
		$file = "upload/avatar".$_GET['user']. '.' .$ext;
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
		exit;
	}
	
	private function transportFile(){
		//获取下载文件的大小
		$file_path='./upload/'.$_GET['user'];
		$file_size=filesize($file_path);
		$fp=fopen($file_path,"r");
		//返回的文件
		header("Content-type:application/octet-stream");
		//按照字节大小返回
		header("Accept-Ranges:bytes");
		//返回文件大小
		header("Accept-Length:".$file_size);
		//这里客户端的弹出对话框
		header("Content-Disposition:attachment;filename=".$file_name);
		//向客户端回送数据
		$buffer=1024;
		//为了下载的安全。我们最后做一个文件字节读取计数器
		$file_count=0;
		//判断文件是否结束
		while(!feof($fp)&&($file_size-$file_count>0)){
			$file_data=fread($fp,$buffer);
			//统计读了多少个字节
			$file_count+=$buffer;
			//把部分数据回送给浏览器
			echo $file_data;
		}
		fclose($fp);
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