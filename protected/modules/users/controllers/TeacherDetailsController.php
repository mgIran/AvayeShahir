
<?php

class TeacherDetailsController extends Controller
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
				  'actions'=>array('index','view','create','update','admin','delete', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile'),
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/teachers/";
		$avatarUrl = Yii::app()->baseUrl .'/uploads/teachers/';
		$fileDIR = Yii::getPathOfAlias("webroot") . "/uploads/teachers/files/";
		$fileUrl = Yii::app()->baseUrl .'/uploads/teachers/files/';

		if(!is_dir($fileDIR))
			mkdir($fileDIR);

		$avatar = array();
		$flag = false;
		if ($model->avatar and file_exists($avatarDIR.$model->avatar)) {
			$file = $model->avatar;
			$avatar = array(
				'name' => $file,
				'src' => $avatarUrl . '/' . $file,
				'size' => filesize($avatarDIR . $file),
				'serverName' => $file,
			);
		}

		$flag2 = false;
		$resumeFile = array();
		if ($model->file and file_exists($fileDIR.$model->file)) {
			$file = $model->file;
			$resumeFile = array(
					'name' => $file,
					'src' => $fileUrl . '/' . $file,
					'size' => filesize($fileDIR . $file),
					'serverName' => $file,
			);
		}
		if(isset($_POST['TeacherDetails']))
		{
			$model->attributes=$_POST['TeacherDetails'];
			foreach($_POST['TeacherDetails']['social_links'] as $key => $link)
			{
				if($link['value'] == '')
					unset($_POST['TeacherDetails']['social_links'][$key]);
				elseif (!preg_match("~^(?:f|ht)tps?://~i",$link['value']))
					$_POST['TeacherDetails']['social_links'][$key]['value'] = 'http://'.$_POST['TeacherDetails']['social_links'][$key]['value'];
			}
			if($_POST['TeacherDetails']['social_links'])
				$model->social_links = CJSON::encode($_POST['TeacherDetails']['social_links']);
			else
				$model->social_links = null;
			if (isset($_POST['TeacherDetails']['avatar']) && file_exists($tmpDIR.$_POST['TeacherDetails']['avatar'])) {
				$file = $_POST['TeacherDetails']['avatar'];
				$avatar = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
				$flag = true;
			}
			if (isset($_POST['TeacherDetails']['file'])&& file_exists($tmpDIR.$_POST['TeacherDetails']['file'])) {
				$file = $_POST['TeacherDetails']['file'];
				$resumeFile = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
				$flag2 = true;
			}
			if($model->save())
			{
				if ($flag && $model->avatar && file_exists($tmpDIR.$model->avatar)) {
					$imager = new Imager();
					$imager->resize($tmpDIR.$model->avatar, $avatarDIR.$model->avatar, 400, 400);
					unlink($tmpDIR.$model->avatar);
				}
				if ($flag2 && $model->file and file_exists($tmpDIR.$model->file)) {
					rename($tmpDIR.$model->file,$fileDIR.$model->file);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				if(isset($_GET['return']) && $_GET['return'] == true)
					$this->redirect(array('/users/teachers/admin?return=true'));
				else
					$this->redirect(array('/users/teachers/admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'avatar' => $avatar,
			'file' => $resumeFile
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/teachers/";
		$fileDIR = Yii::getPathOfAlias("webroot") . "/uploads/teachers/files/";
		$model = $this->loadModel($id);
		if($model->avatar && file_exists($avatarDIR.$model->avatar))
			unlink($avatarDIR.$model->avatar);
		if($model->file && file_exists($fileDIR.$model->file))
			unlink($fileDIR.$model->file);
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
		$model=new TeacherDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TeacherDetails']))
			$model->attributes=$_GET['TeacherDetails'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TeacherDetails the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TeacherDetails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TeacherDetails $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='teacher-details-form')
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
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/teachers/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = TeacherDetails::model()->findByAttributes(array('avatar' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->avatar)) {
					$model->updateByPk($model->user_id, array('avatar' => null));
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
	 * file uploader
	 */
	public function actionUploadFile()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['file'];
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

	public function actionDeleteUploadFile()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/teachers/files/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = TeacherDetails::model()->findByAttributes(array('file' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->file)) {
					$model->updateByPk($model->user_id, array('file' => null));
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
