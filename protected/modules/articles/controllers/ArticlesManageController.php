<?php

class ArticlesManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - view, index, tag', // perform access control for CRUD operations
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
			'frontend' => array('index','view','tag'),
			'backend' => array('create','update','admin','delete','order','upload','deleteUpload')
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
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords();
		$this->description = mb_substr(strip_tags($model->summary),0,160,'UTF-8');
		$this->pageTitle = $model->title;
		// increase seen counter
		Yii::app()->db->createCommand()->update('{{articles}}',array('seen'=>((int)$model->seen+1)),'id = :id',array(":id"=>$model->id));

		// get latest articles
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionTag($id)
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';

		$model = ClassTags::model()->findByPk($id);
		$this->keywords = 'آوای شهیر,مطالب آموزشی '.$model->title.',برچسب '.$model->title.','.$model->title;
		$this->pageTitle = 'برچسب '.$model->title;

		// get latest articles
		$criteria = Articles::getValidArticles();
		$criteria->together = true;
		$criteria->compare('tagsRel.tag_id',$model->id);
		$criteria->with[] = 'tagsRel';
		$dataProvider = new CActiveDataProvider("Articles",array(
			'criteria' => $criteria
		));
		$this->render('tags',array(
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
		$tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
		if (!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/articles/";
		if (!is_dir($imageDIR))
			mkdir($imageDIR);
		if (!is_dir($imageDIR.'/200x200'))
			mkdir($imageDIR.'/200x200');

		$model=new Articles;

		$image = array();
		if(isset($_POST['Articles']))
		{
			$model->attributes=$_POST['Articles'];
			$model->category_id=!$model->category_id||empty($model->category_id)?null:$model->category_id;
			if (isset($_POST['Articles']['image'])) {
				$file = $_POST['Articles']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish')
				$model->publish_date = time();
			$model->formTags = isset($_POST['Articles']['formTags'])?explode(',',$_POST['Articles']['formTags']):null;
			if($model->save())
			{
				if ($model->image and file_exists($tmpDIR.$model->image)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR.'200x200/' . $model->image);
					rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;	اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('/articles/manage/update/id/'.$model->id.'/step/2'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
			'image'=>$image,
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
		$tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/articles/";
		$imageUrl = Yii::app()->baseUrl .'/uploads/articles/';

		$image = array();
		if ($model->image and file_exists($imageDIR.$model->image)) {
			$file = $model->image;
			$image = array(
				'name' => $file,
				'src' => $imageUrl . '/' . $file,
				'size' => filesize($imageDIR . $file),
				'serverName' => $file,
			);
		}

		foreach($model->tags as $tag)
			array_push($model->formTags,$tag->title);

		if(isset($_POST['Articles']))
		{
			$model->attributes=$_POST['Articles'];
			if (isset($_POST['Articles']['image']) and file_exists($tmpDIR.$_POST['Articles']['image'])) {
				$file = $_POST['Articles']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish' && !$model->publish_date)
				$model->publish_date = time();
			$model->formTags = isset($_POST['Articles']['formTags'])?explode(',',$_POST['Articles']['formTags']):null;
			if($model->save())
			{
				if ($model->image and file_exists($tmpDIR.$model->image)) {
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR.'200x200/' . $model->image);
					rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
			'fileModel' => new ArticleFiles(),
			'files' => new CActiveDataProvider('ArticleFiles',array(
				'criteria' => array(
					'condition' => 'article_id = :id',
					'params' => array(
						':id' => $id
					)
				)
			)),
			'fileLinkModel' => new ArticleFileLinks(),
			'fileLinks' => new CActiveDataProvider('ArticleFileLinks',array(
				'criteria' => array(
					'condition' => 'article_id = :id',
					'params' => array(
						':id' => $id
					)
				)
			)),
			'image' => $image
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/articles/";
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/articles/files/';
		$model = $this->loadModel($id);
		if(file_exists($imageDIR.$model->image))
		{
			@unlink($imageDIR.$model->image);
			@unlink($imageDIR.'200x200/'.$model->image);
		}
		foreach($model->files as $file)
		{
			if($file->path && file_exists($Dir.$file->path))
				unlink($Dir.$file->path);
		}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$criteria = Articles::model()->getValidArticles();
		$dataProvider=new CActiveDataProvider('Articles',array(
			'criteria' => $criteria,
			'pagination' => false
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Articles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Articles']))
			$model->attributes=$_GET['Articles'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Articles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Articles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Articles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='class-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

		if (!is_dir($tempDir))
			mkdir($tempDir);
		if (isset($_FILES)) {
			$file = $_FILES['image'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name'].'.'.$ext))
				$file['name'] = Controller::generateRandomString(5) . time();
			$file['name'] = $file['name'] . '.' . $ext;
			if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		} else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/articles/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Articles::model()->findByAttributes(array('image' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->image)) {
					@unlink($Dir .'200x200/'. $model->image);
					$model->updateByPk($model->id,array('image'=>null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				} else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			} else {
				@unlink($tempDir . $fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}
}