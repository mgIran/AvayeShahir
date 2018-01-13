<?php

class WritingsModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'writings.models.*',
			'writings.components.*',
			'courses.models.ClassTags',
		));
	}

	public $controllerMap = array(
		'manage' => 'writings.controllers.WritingsManageController',
		'category' => 'writings.controllers.WritingsCategoryController',
		'tags' => 'writings.controllers.WritingsTagsController',
	);

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
