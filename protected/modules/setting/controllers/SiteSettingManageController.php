<?php

class SiteSettingManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction = 'changeSetting';
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
				'actions'=>array('changeSetting','siteMessage'),
                'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Change site setting
	 */
    public function actionChangeSetting(){
        if(isset($_POST['SiteSetting'])){
            foreach($_POST['SiteSetting'] as $name => $value)
            {
                $field = SiteSetting::model()->findByAttributes(array('name'=>$name));
				SiteSetting::model()->updateByPk($field->id,array('value'=>$value));
            }
            Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $model = SiteSetting::model()->findAll();
        $this->render('_general',array(
            'model'=>$model
        ));
    }

	/**
	 * Change site setting
	 */
    public function actionSiteMessage(){
		$model = SiteSetting::model()->findAll(array(
			'condition' => 'name = "message" OR name = "message_en" OR name = "message_state"',
			'order' => 'id'
		));
        if(isset($_POST['SiteSetting'])){
			foreach($_POST['SiteSetting'] as $name => $value)
			{
				$field = SiteSetting::model()->findByAttributes(array('name'=>$name));
				SiteSetting::model()->updateByPk($field->id,array('value'=>$value));
			}
            Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $this->render('_message',array(
            'model'=>$model
        ));
    }
}
