<?php

class MultimediaModule extends CWebModule
{
	public $controllerMap = [
		'pictures' => 'multimedia.controllers.MultimediaPicturesController',
		'videos' => 'multimedia.controllers.MultimediaVideosController',
		'category' => 'multimedia.controllers.MultimediaCategoryController'
	];

	public function init()
	{
		$this->setImport(array(
			'multimedia.models.*',
			'multimedia.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
