<?php

class SlideshowManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete',
				'order',
				'changeStatus',
				'upload',
				'deleteUpload'
			)
		);
	}

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

	public function actions(){
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
			'upload' => array(
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'image',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('jpg','jpeg','png')
				)
			),
			'deleteUpload' => array(
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'Slideshow',
				'attribute' => 'image',
				'uploadDir' => '/uploads/slideshow',
				'storedMode' => 'field'
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Slideshow;

		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->getBaseUrl(true)."/uploads/temp/";
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/slideshow/";
		if (!is_dir($imageDIR))
			mkdir($imageDIR);
		$image = array();

		if(isset($_POST['Slideshow'])) {
			$model->attributes = $_POST['Slideshow'];
			if(isset($_POST['Slideshow']['image'])) {
				$file = $_POST['Slideshow']['image'];
				$image = array(
						'name' => $file,
						'src' => $tmpUrl.'/'.$file,
						'size' => filesize($tmpDIR.$file),
						'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->image)
					rename($tmpDIR.$model->image, $imageDIR.$model->image);
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
			'image' => $image,
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
		$tmpUrl = Yii::app()->getBaseUrl(true)."/uploads/temp/";

		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/slideshow/";
		$imageUrl = Yii::app()->getBaseUrl(true)."/uploads/slideshow/";

		$image = array();
		if($model->image && file_exists($imageDIR . $model->image))
			$image = array(
					'name' => $model->image,
					'src' => $imageUrl . '/' . $model->image,
					'size' => filesize($imageDIR . $model->image),
					'serverName' => $model->image,
			);
		if(isset($_POST['Slideshow']))
		{
			$model->attributes=$_POST['Slideshow'];
			if(isset($_POST['Slideshow']['image']) && file_exists($tmpDIR.$_POST['Slideshow']['image'])) {
				$file = $_POST['Slideshow']['image'];
				$image = array(
						'name' => $file,
						'src' => $tmpUrl.'/'.$file,
						'size' => filesize($tmpDIR.$file),
						'serverName' => $file,
				);
			}
			if($model->save()) {
				if($model->image && file_exists($tmpDIR.$model->image))
					rename($tmpDIR.$model->image, $imageDIR.$model->image);
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}
		$this->render('update',array(
			'model'=>$model,
			'image' => $image,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Slideshow('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Slideshow']))
			$model->attributes=$_GET['Slideshow'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Slideshow the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Slideshow::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionChangeStatus($id){
        $this->loadModel($id)->changeStatus();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
}

