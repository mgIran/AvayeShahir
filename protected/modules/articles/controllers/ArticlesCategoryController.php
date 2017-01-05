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
			'frontend'=>array('index', 'view'),
			'backend' => array('create', 'update', 'admin', 'delete', 'upload','deleteUpload')
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
		$criteria->compare('category_id',$model->id);
		$dataProvider = new CActiveDataProvider("Articles",array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 8)
		));
        $categoryProvider = new CActiveDataProvider('ArticleCategories',array(
            'criteria' => array('condition' => 'parent_id = :id','params'=>[':id'=>$model->id]),
            'pagination' => false
        ));
		$this->render('view',array(
			'model' => $model,
            'categoryProvider' => $categoryProvider,
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
        $imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/articles/categories/";
        if (!is_dir($imageDIR))
            mkdir($imageDIR);
        if (!is_dir($imageDIR.'/80x80'))
            mkdir($imageDIR.'/80x80');

		$model=new ArticleCategories;
        
        $image = array();
        
		if(isset($_POST['ArticleCategories']))
		{
			$model->attributes=$_POST['ArticleCategories'];
            if (isset($_POST['ArticleCategories']['image'])) {
                $file = $_POST['ArticleCategories']['image'];
                $image = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            $model->formTags = isset($_POST['ArticleCategories']['formTags'])?explode(',',$_POST['ArticleCategories']['formTags']):null;
			if($model->save()) {
                if ($model->image and file_exists($tmpDIR.$model->image)) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->image, 80, 80, false, $imageDIR.'80x80/' . $model->image);
                    @rename($tmpDIR . $model->image, $imageDIR . $model->image);
                }
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
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
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
        $imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/articles/categories/";
        $imageUrl = Yii::app()->baseUrl .'/uploads/articles/categories/';

        $model=$this->loadModel($id);

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
        
		if(isset($_POST['ArticleCategories']))
		{
			$model->attributes=$_POST['ArticleCategories'];
            if (isset($_POST['ArticleCategories']['image']) and file_exists($tmpDIR.$_POST['ArticleCategories']['image'])) {
                $file = $_POST['ArticleCategories']['image'];
                $image = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            $model->formTags = isset($_POST['ArticleCategories']['formTags'])?explode(',',$_POST['ArticleCategories']['formTags']):null;
			if($model->save()) {
                if ($model->image and file_exists($tmpDIR.$model->image)) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->image, 80, 80, false, $imageDIR.'80x80/' . $model->image);
                    @rename($tmpDIR . $model->image, $imageDIR . $model->image);
                }
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ویرایش شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
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
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/articles/categories/';

		if (isset($_POST['fileName'])) {

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = ArticleCategories::model()->findByAttributes(array('image' => $fileName));
			if ($model) {
				if (@unlink($Dir . $model->image)) {
					@unlink($Dir .'80x80/'. $model->image);
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
