<?php

class ClassCategoryFilesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'create', 'update', 'delete', 'upload', 'deleteUpload', 'uploadImage', 'deleteUploadImage' ,'order'),
				'roles' => array('admin'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
		);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate()
	{
		$model = new ClassCategoryFiles();
		if(isset($_POST['ClassCategoryFiles'])) {
			$model->attributes = $_POST['ClassCategoryFiles'];
			$model->file_type = pathinfo($_POST['ClassCategoryFiles']['path'], PATHINFO_EXTENSION);
			if($model->save()) {
				Yii::app()->user->setFlash('upload-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$response = ['state' => 'ok','url'=>Yii::app()->createUrl('/courses/categories/update/id/'.$model->category_id.'/step/2')];
			} else
			{
				Yii::app()->user->setFlash('upload-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
				$response = ['state' => 'error','url'=>Yii::app()->createUrl('/courses/categories/update/id/'.$model->category_id.'/step/2')];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionUpdate($id)
	{
		$model = ClassCategoryFiles::model()->findByPk((int)$id);
		$tmpDIR = Yii::getPathOfAlias("webroot").'/uploads/temp/';
		if(!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl.'/uploads/temp/';
		$fileDIR = Yii::getPathOfAlias("webroot")."/uploads/classCategoryFiles/";
		$fileUrl = Yii::app()->baseUrl.'/uploads/classCategoryFiles/';

		$fileArr = array();
		if($model->path and file_exists($fileDIR.$model->path)) {
			$file = $model->path;
			$fileArr = array(
				'name' => $file,
				'src' => $fileUrl.'/'.$file,
				'size' => filesize($fileDIR.$file),
				'serverName' => $file,
			);
		}
		if(isset($_POST['ClassCategoryFiles'])) {
			$model->attributes = $_POST['ClassCategoryFiles'];
			$model->file_type = pathinfo($_POST['ClassCategoryFiles']['path'], PATHINFO_EXTENSION);
			if(isset($_POST['ClassCategoryFiles']['path']) and file_exists($tmpDIR.$_POST['ClassCategoryFiles']['path'])) {
				$file = $_POST['ClassCategoryFiles']['path'];
				$fileArr = array(
					'name' => $file,
					'src' => $tmpUrl.'/'.$file,
					'size' => filesize($tmpDIR.$file),
					'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->path and file_exists($tmpDIR.$model->path)) {
					rename($tmpDIR.$model->path, $fileDIR.$model->path);
				}
				Yii::app()->user->setFlash('upload-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			} else
				Yii::app()->user->setFlash('upload-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
		}
		$this->render('update', array(
			'model' => $model,
			'file' => $fileArr
		));
	}

	public function actionUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/classCategoryFiles/';

		if (!is_dir($Dir))
			mkdir($Dir);
		if (isset($_FILES)) {
			$file = $_FILES['path'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = str_ireplace('.'.$ext,'',$file['name']);
			$i=1;
			if(file_exists($Dir . DIRECTORY_SEPARATOR . $file['name']. '.' . $ext))
			{
				while(file_exists($Dir . DIRECTORY_SEPARATOR . $file['name'].'-'.$i. '.' . $ext))
					$i++;
				$file['name'] = $file['name'].'-'.$i;
			}
			$file['name'] = $file['name'] . '.' . $ext;
			if (move_uploaded_file($file['tmp_name'], $Dir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/classCategoryFiles/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = ClassCategoryFiles::model()->findByAttributes(array('path' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->path)) {
					$model->updateByPk($model->id,array('path'=>null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir . $fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionDelete($id){
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/classCategoryFiles/';
		$model = ClassCategoryFiles::model()->findByPk($id);
		if($model->path && file_exists($Dir.$model->path))
			unlink($Dir.$model->path);
		if($model->delete()) {
			Yii::app()->user->setFlash('upload-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
		} else
		{
			Yii::app()->user->setFlash('upload-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
		}
	}


	public function actionUploadImage()
	{
		$_POST = CJSON::decode($_POST['data']);
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/fileImages';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['image'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
				$file['name'] = Controller::generateRandomString(5) . time();
			$file['name'] = $file['name'] . '.' . $ext;
			$model = ClassCategoryFiles::model()->findByPk((int)$_POST['id']);
			if ($model && move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . strip_tags($file['name']))){
				ClassCategoryFiles::model()->updateByPk($model->id,array('image'=> strip_tags($file['name'])));
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			}
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUploadImage()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/fileImages/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];
			$model = ClassCategoryFiles::model()->findByAttributes(array('image' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->image)) {
					$model->updateByPk($model->id, array('image' => null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			}else
				$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}
}