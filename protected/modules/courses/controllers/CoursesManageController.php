<?php

class CoursesManageController extends Controller
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
			'checkAccess - view', // perform access control for CRUD operations
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
			'frontend' => array('view'),
			'backend' => array('create','update','admin','delete', 'upload', 'deleteUpload','order', 'recycleBin', 'restore')
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords().','.$model->getCategoriesKeywords();
		$this->description = substr(strip_tags($model->getValueLang('summary', 'en')),0,160);
		$this->pageTitle = $model->getValueLang('title', 'en');
		Yii::app()->db->createCommand()->update('{{courses}}',array('seen'=>((int)$model->seen+1)),'id = :id',array(":id"=>$model->id));
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Courses;

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$picDIR = Yii::getPathOfAlias("webroot") . "/uploads/courses/";
		if (!is_dir($picDIR))
			mkdir($picDIR);

		$pic = array();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Courses']))
		{
			$model->attributes=$_POST['Courses'];
			if (isset($_POST['Courses']['pic'])) {
				$file = $_POST['Courses']['pic'];
				$pic = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
			}
			$model->formTags = isset($_POST['Courses']['formTags'])?explode(',',$_POST['Courses']['formTags']):null;
			if($model->save())
			{
				if ($model->pic and is_file($tmpDIR.$model->pic)) {
					$imager = new Imager();
					$imager->resize($tmpDIR.$model->pic ,$picDIR.$model->pic,600,600);
					unlink($tmpDIR.$model->pic);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
			'pic' => $pic
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
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$picDIR = Yii::getPathOfAlias("webroot") . "/uploads/courses/";
		$picUrl = Yii::app()->baseUrl .'/uploads/courses/';

		$pic = array();
		if ($model->pic and is_file($picDIR.$model->pic)) {
			$file = $model->pic;
			$pic = array(
				'name' => $file,
				'src' => $picUrl . '/' . $file,
				'size' => filesize($picDIR . $file),
				'serverName' => $file,
			);
		}

		foreach($model->tags as $tag)
			array_push($model->formTags,$tag->title);

		if(isset($_POST['Courses']))
		{
			$model->attributes=$_POST['Courses'];
			if (isset($_POST['Courses']['pic']) and is_file($tmpDIR.$_POST['Courses']['pic'])) {
				$file = $_POST['Courses']['pic'];
				$pic = array(
						'name' => $file,
						'src' => $tmpUrl . '/' . $file,
						'size' => filesize($tmpDIR . $file),
						'serverName' => $file,
				);
			}
			$model->formTags = isset($_POST['Courses']['formTags'])?explode(',',$_POST['Courses']['formTags']):null;
			if($model->save())
			{
				if ($model->pic and is_file($tmpDIR.$model->pic)) {
					$imager = new Imager();
					$imager->resize($tmpDIR.$model->pic ,$picDIR.$model->pic,600,600);
					unlink($tmpDIR.$model->pic);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'pic' => $pic
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$picDIR = Yii::getPathOfAlias("webroot") . "/uploads/courses/";
		$model = $this->loadModel($id);
		if($model->deleted){
			if(is_file($picDIR . $model->pic))
				unlink($picDIR . $model->pic);
			$model->delete();
		}else{
			$model->scenario = 'delete';
			$model->deleted = 1;
			$model->update();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Courses('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
        $model->deleted = 0;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
	 * Manages all models.
	 */
	public function actionRecycleBin()
	{
		$model=new Courses('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
        $model->deleted = 1;
		$this->render('recycle_bin',array(
			'model'=>$model,
		));
	}

    /**
     * Restore deleted course from recycle bin
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
	public function actionRestore($id)
	{
        $model = $this->loadModel($id);
        $model->scenario = 'delete';
        $model->deleted = 0;
        if($model->update())
            Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;با موفقیت بازیابی شد.');
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('recycleBin'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Courses the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Courses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Courses $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='courses-form')
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
			$file = $_FILES['pic'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while (is_file($tempDir . DIRECTORY_SEPARATOR . $file['name']))
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
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/courses/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Courses::model()->findByAttributes(array('pic' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->pic)) {
					$model->updateByPk($model->id, array('pic' => null));
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

