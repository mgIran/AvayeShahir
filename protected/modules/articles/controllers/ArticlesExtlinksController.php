<?php

class ArticlesExtlinksController extends Controller
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
			'backend' => array('create', 'update', 'delete','order')
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
		$model = new ArticleLinks();
		if(isset($_POST['ArticleLinks'])) {
			if (!preg_match("~^(?:f|ht)tps?://~i",$_POST['ArticleLinks']['link']))
				$_POST['ArticleLinks']['link'] = 'http://'.$_POST['ArticleLinks']['link'];
			$model->attributes = $_POST['ArticleLinks'];
			if($model->save()) {
				Yii::app()->user->setFlash('upload-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$response = ['state' => 'ok','url'=>Yii::app()->createUrl('/articles/manage/update/id/'.$model->article_id.'/step/4')];
			} else
			{
				Yii::app()->user->setFlash('upload-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
				$response = ['state' => 'error','url'=>Yii::app()->createUrl('/articles/manage/update/id/'.$model->article_id.'/step/4')];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionUpdate($id)
	{
		$model = ArticleLinks::model()->findByPk((int)$id);
		if(isset($_POST['ArticleLinks'])) {
			$model->attributes = $_POST['ArticleLinks'];
			if($model->save())
				Yii::app()->user->setFlash('ext-link-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			else
				Yii::app()->user->setFlash('ext-link-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
			$this->redirect(array('/articles/manage/update/id/'.$model->article_id.'/step/3'));
		}
		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$model = ArticleLinks::model()->findByPk($id);
		if($model->delete())
			Yii::app()->user->setFlash('ext-link-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
		else
			Yii::app()->user->setFlash('ext-link-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		$this->redirect(array('/articles/manage/update/id/'.$model->article_id.'/step/3'));
	}
}