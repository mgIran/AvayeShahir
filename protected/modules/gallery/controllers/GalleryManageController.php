<?php

class GalleryManageController extends Controller
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
			'checkAccess - index', // perform access control for CRUD operations
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
			'backend' => array('create', 'update', 'delete', 'upload', 'deleteUpload' ,'order','admin'),
			'frontend' => array('index')
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
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$models = Gallery::model()->findAll();
		$this->render('index',array(
			'models' => $models,
			'title' => Yii::t('app','Pictures Gallery')
		));
	}

	public function actionCreate()
	{
		$tmpDIR = Yii::getPathOfAlias("webroot").'/uploads/temp/';
		if(!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl.'/uploads/temp/';
		$fileDIR = Yii::getPathOfAlias("webroot")."/uploads/gallery/";
		if(!is_dir($fileDIR))
			mkdir($fileDIR);
		$fileThumbDIR = Yii::getPathOfAlias("webroot")."/uploads/gallery/50x50/";
		if(!is_dir($fileThumbDIR))
			mkdir($fileThumbDIR);
		$model = new Gallery();
		$image =array();
		if(isset($_POST['Gallery'])) {
			$model->attributes = $_POST['Gallery'];
			if(isset($_POST['Gallery']['file_name']) and file_exists($tmpDIR.$_POST['Gallery']['file_name'])) {
				$file = $_POST['Gallery']['file_name'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl.'/'.$file,
					'size' => filesize($tmpDIR.$file),
					'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->file_name and file_exists($tmpDIR.$model->file_name)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR.$model->file_name,50,50,false,$fileThumbDIR.$model->file_name);
					rename($tmpDIR.$model->file_name, $fileDIR.$model->file_name);
				}
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('/gallery/manage/admin'));
			} else
				Yii::app()->user->setFlash('failed',$this->implodeErrors($model));
		}
		$this->render('create',array(
			'model' => $model,
			'image' => $image
		));
	}

	public function actionUpdate($id)
	{
		$model = Gallery::model()->findByPk($id);
		$tmpDIR = Yii::getPathOfAlias("webroot").'/uploads/temp/';
		if(!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl.'/uploads/temp/';
		$fileDIR = Yii::getPathOfAlias("webroot")."/uploads/gallery/";
		$fileUrl = Yii::app()->baseUrl.'/uploads/gallery/';
		$fileThumbDIR = Yii::getPathOfAlias("webroot")."/uploads/gallery/50x50/";

		$image = array();
		if($model->file_name and file_exists($fileDIR.$model->file_name)) {
			$file = $model->file_name;
			$image = array(
				'name' => $file,
				'src' => $fileUrl.$file,
				'size' => filesize($fileDIR.$file),
				'serverName' => $file,
			);
		}
		if(isset($_POST['Gallery'])) {
			$model->attributes = $_POST['Gallery'];
			if(isset($_POST['Gallery']['file_name']) and file_exists($tmpDIR.$_POST['Gallery']['file_name'])) {
				$file = $_POST['Gallery']['file_name'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl.$file,
					'size' => filesize($tmpDIR.$file),
					'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->file_name and file_exists($tmpDIR.$model->file_name)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR.$model->file_name,50,50,false,$fileThumbDIR.$model->file_name);
					rename($tmpDIR.$model->file_name, $fileDIR.$model->file_name);
				}
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/gallery/manage/update?id='.$model->id));
		}
		$this->render('update', array(
				'model' => $model,
				'image' => $image
		));
	}

	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['file_name'];
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
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/gallery/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Gallery::model()->findByAttributes(array('file_name' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->file_name)) {
					@unlink($Dir .'50x50/'. $model->file_name);
					$model->updateByPk($model->id,array('file_name'=>null));
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/gallery/';
		$model = Gallery::model()->findByPk($id);
		if($model->file_name && file_exists($Dir.$model->file_name))
		{
			@unlink($Dir.$model->file_name);
			@unlink($Dir.'50x50/'.$model->file_name);
		}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Gallery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}
}