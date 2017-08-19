<?php

class SettingManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction = 'changeSetting';
	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array('changeSetting','siteMessage')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess',
		);
	}

	/**
	 * Change site setting
	 */
    public function actionChangeSetting()
	{
		$model = SiteSetting::model()->findAll();
		if(isset($_POST['SiteSetting'])){
			foreach($_POST['SiteSetting'] as $name => $value)
			{
				SiteSetting::setOption($name, $value);
			}
			Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
			$this->refresh();
		}
		$this->render('_general', array(
			'model' => $model
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
