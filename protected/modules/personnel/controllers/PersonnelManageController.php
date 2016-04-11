<?php

class PersonnelManageController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete', 'upload', 'deleteUpload'),
				'roles'=>array('admin'),
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
		$model=new Personnel;
		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
		$avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/personnel/";
		if (!is_dir($avatarDIR))
			mkdir($avatarDIR);

		$avatar = array();

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
			foreach($_POST['Personnel']['social_links'] as $key => $link)
			{
				if($link['value'] == '')
					unset($_POST['Personnel']['social_links'][$key]);
				elseif (!preg_match("~^(?:f|ht)tps?://~i",$link['value']))
					$_POST['Personnel']['social_links'][$key]['value'] = 'http://'.$_POST['Personnel']['social_links'][$key]['value'];
			}
			if($_POST['Personnel']['social_links'])
				$model->social_links = CJSON::encode($_POST['Personnel']['social_links']);
			else
				$model->social_links = null;
			if (isset($_POST['Personnel']['avatar'])) {
				$file = $_POST['Personnel']['avatar'];
				$avatar = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
			}
			if($model->save())
			{
				if ($model->avatar and file_exists($tmpDIR.$model->avatar)) {
					$imager = new Imager();
					$imager->resize($tmpDIR.$model->avatar ,$avatarDIR.$model->avatar,400,400);
					unlink($tmpDIR.$model->avatar);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
			'avatar' => $avatar
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

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
		$avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/personnel/";
		$avatarUrl = Yii::app()->createAbsoluteUrl('/uploads/personnel/');

		$avatar = array();
		if ($model->avatar and file_exists($avatarDIR.$model->avatar)) {
			$file = $model->avatar;
			$avatar = array(
					'name' => $file,
					'src' => $avatarUrl . '/' . $file,
					'size' => filesize($avatarDIR . $file),
					'serverName' => $file,
			);
		}

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
			foreach($_POST['Personnel']['social_links'] as $key => $link)
			{
				if($link['value'] == '')
					unset($_POST['Personnel']['social_links'][$key]);
				elseif (!preg_match("~^(?:f|ht)tps?://~i",$link['value']))
					$_POST['Personnel']['social_links'][$key]['value'] = 'http://'.$_POST['Personnel']['social_links'][$key]['value'];
			}
			if($_POST['Personnel']['social_links'])
				$model->social_links = CJSON::encode($_POST['Personnel']['social_links']);
			else
				$model->social_links = null;
			if (isset($_POST['Personnel']['avatar'])) {
				$file = $_POST['Personnel']['avatar'];
				$avatar = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
			}
			if($model->save())
			{
				if ($model->avatar and file_exists($tmpDIR.$model->avatar)) {
					$imager = new Imager();
					$imager->resize($tmpDIR.$model->avatar ,$avatarDIR.$model->avatar,400,400);
					unlink($tmpDIR.$model->avatar);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'avatar' => $avatar
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/personnel/";
		$model = $this->loadModel($id);
		if(file_exists($avatarDIR.$model->avatar))
			unlink($avatarDIR.$model->avatar);
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
			$model->attributes=$_GET['Personnel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Personnel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Personnel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Personnel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='personnel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['avatar'];
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
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/personnel/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Personnel::model()->findByAttributes(array('avatar' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->avatar)) {
					$model->updateByPk($model->id, array('avatar' => null));
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
}
