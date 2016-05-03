<?php

class ClassCategoryFileLinksController extends Controller
{
	public $layout = '//layouts/column2';
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
				'actions' => array('create', 'update', 'delete','order'),
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
}