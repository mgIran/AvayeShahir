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
						'actions' => array('index', 'create', 'update', 'delete', 'upload', 'deleteUpload'),
						'roles' => array('admin'),
				),
				array(
						'deny',  // deny all users
						'users' => array('*'),
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
			$model->file_type = $ext = pathinfo($_POST['ClassCategoryFiles']['path'], PATHINFO_EXTENSION);
			if($model->save()) {
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
			} else
			{
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
				$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
			}
		}
	}

	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/classCategoryFiles/';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['path'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name']))
				$file['name'] = Controller::generateRandomString(5) . time();
			$file['name'] = $file['name'] . '.' . $ext;
			if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
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
					$model->delete();
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
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
		} else
		{
			Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/2'));
		}
	}
}