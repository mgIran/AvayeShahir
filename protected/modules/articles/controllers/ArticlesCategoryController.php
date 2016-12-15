<?php

class ArticlesCategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public static function actionsType()
	{
		return array(
			'frontend'=>array(
				'index',
				'view'
			),
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + create, update, admin, delete', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
		$this->keywords = 'آوای شهیر,مطالب آموزشی,دسته بندی مطالب آموزشی,دسته بندی '.$model->title.','.$model->title;
		$this->pageTitle = $model->title;

		// get latest articles
		$criteria = Articles::getValidArticles();
		$criteria->addInCondition('category_id',$model->getCategoryChildes());
		$dataProvider = new CActiveDataProvider("Articles",array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 8)
		));
		$this->render('view',array(
			'model' => $model,
			'dataProvider' => $dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ArticleCategories;
		if(isset($_POST['ArticleCategories']))
		{
			$model->attributes=$_POST['ArticleCategories'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
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
		if(isset($_POST['ArticleCategories']))
		{
			$model->attributes=$_POST['ArticleCategories'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ویرایش شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ArticleCategories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ArticleCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ArticleCategories']))
			$model->attributes=$_GET['ArticleCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ArticleCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ArticleCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ArticleCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='articles-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
