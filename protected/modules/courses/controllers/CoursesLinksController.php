<?php

class CoursesLinksController extends Controller
{
	public $layout = '//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array('create', 'update', 'delete','order','upload','deleteUpload')
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

	public function actionCreate()
	{
		$model = new ClassCategoryFileLinks();
		if(isset($_POST['ClassCategoryFileLinks'])) {
			if (!preg_match("~^(?:f|ht)tps?://~i",$_POST['ClassCategoryFileLinks']['link']))
				$_POST['ClassCategoryFileLinks']['link'] = 'http://'.$_POST['ClassCategoryFileLinks']['link'];
			$model->attributes = $_POST['ClassCategoryFileLinks'];
			if($model->save()) {
				Yii::app()->user->setFlash('upload-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$response = ['state' => 'ok','url'=>Yii::app()->createUrl('/courses/categories/update/id/'.$model->category_id.'/step/3')];
			} else
			{
				Yii::app()->user->setFlash('upload-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
				$response = ['state' => 'error','url'=>Yii::app()->createUrl('/courses/categories/update/id/'.$model->category_id.'/step/3')];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionUpdate($id)
	{
		$model = ClassCategoryFileLinks::model()->findByPk((int)$id);
		if(isset($_POST['ClassCategoryFileLinks'])) {
			$model->attributes = $_POST['ClassCategoryFileLinks'];
			if($model->save())
				Yii::app()->user->setFlash('link-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			else
				Yii::app()->user->setFlash('link-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/3'));
		}
		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$model = ClassCategoryFileLinks::model()->findByPk($id);
		if($model->delete())
			Yii::app()->user->setFlash('link-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
		else
			Yii::app()->user->setFlash('link-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		$this->redirect(array('/courses/categories/update/id/'.$model->category_id.'/step/3'));
	}

	public function actionUpload()
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
			$model = ClassCategoryFileLinks::model()->findByPk((int)$_POST['id']);
			if ($model && move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . strip_tags($file['name']))){
				ClassCategoryFileLinks::model()->updateByPk($model->id,array('image'=> strip_tags($file['name'])));
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			}
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/fileImages/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];
			$model = ClassCategoryFileLinks::model()->findByAttributes(array('image' => $fileName));
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