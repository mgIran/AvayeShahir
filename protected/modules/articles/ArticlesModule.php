<?php

class ArticlesModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'articles.models.*',
			'articles.components.*',
			'courses.models.ClassTags',
		));
	}

	public $controllerMap = array(
		'manage' => 'articles.controllers.ArticlesManageController',
		'category' => 'articles.controllers.ArticlesCategoryController',
		'tags' => 'articles.controllers.ArticlesTagsController',
		'files' => 'articles.controllers.ArticlesFilesController',
		'links' => 'articles.controllers.ArticlesLinksController',
		'extlinks' => 'articles.controllers.ArticlesExtlinksController',
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
