<?php

class CoursesCategoriesController extends Controller
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
			'backend' => array('index', 'create', 'update', 'admin', 'delete', 'order', 'changeStatus', 'fetch')
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
			'fetch' => array(
				'class' => 'ext.fileManager.actions.AjaxFetchFilesListAction',
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ClassCategories;

		if(isset($_POST['ClassCategories'])){
			$model->attributes = $_POST['ClassCategories'];
			$model->formTags = isset($_POST['ClassCategories']['formTags'])?explode(',', $_POST['ClassCategories']['formTags']):null;
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;	اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('/courses/categories/update/id/' . $model->id . '/step/2'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		foreach($model->tags as $tag)
			array_push($model->formTags, $tag->title);

		if(isset($_POST['ClassCategories'])){
			$model->attributes = $_POST['ClassCategories'];
			$model->formTags = isset($_POST['ClassCategories']['formTags'])?explode(',', $_POST['ClassCategories']['formTags']):null;
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update', array(
			'model' => $model,
			'fileModel' => new ClassCategoryFiles(),
			'files' => new CActiveDataProvider('ClassCategoryFiles', array(
				'criteria' => array(
					'condition' => 'category_id = :id',
					'params' => array(
						':id' => $id
					)
				)
			)),
			'fileLinkModel' => new ClassCategoryFileLinks(),
			'fileLinks' => new CActiveDataProvider('ClassCategoryFileLinks', array(
				'criteria' => array(
					'condition' => 'category_id = :id',
					'params' => array(
						':id' => $id
					)
				)
			)),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/classCategoryFiles/';
		$model = $this->loadModel($id);
		foreach($model->files as $file){
			if($file->path && file_exists($Dir . $file->path))
				unlink($Dir . $file->path);
		}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
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
		$model = new ClassCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClassCategories']))
			$model->attributes = $_GET['ClassCategories'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClassCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ClassCategories::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ClassCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'class-categories-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionChangeStatus($id)
	{
		$model = $this->loadModel($id);
		$model->scenario = 'change_status';
		if($model->status == ClassCategories::STATUS_ACTIVE)
			$model->status = ClassCategories::STATUS_DEACTIVE;
		else
			$model->status = ClassCategories::STATUS_ACTIVE;
		@$model->save();
	}
}