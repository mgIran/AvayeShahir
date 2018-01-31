<?php
Yii::import('courses.models.ClassTags');
class MultimediaVideosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $tempPath = 'uploads/temp';
	public $thumbsPath = 'uploads/multimedia/thumbnail';
	public $thumbOptions = ['thumbnail' => ['width' => 200, 'height' => 200]];
	
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
				'delete',
				'upload',
				'deleteUpload',
				'order'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + create, update, admin, delete, upload, deleteUpload, order', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'thumbnail',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('jpg','jpeg','png','gif')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Multimedia',
                'attribute' => 'thumbnail',
                'uploadDir' => '/uploads/multimedia/thumbnail',
                'storedMode' => 'field'
            ),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        Yii::app()->theme ='front-end';
        $this->layout = '//layouts/inner';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords();
		$this->description = substr(strip_tags($model->getValueLang('description', 'en')), 0, 160);
		$this->pageTitle = $model->getValueLang('title', 'en');
		Multimedia::model()->updateCounters(array('seen' => 1), 'id = :id', array(':id' => $id));
		$this->render('view', array(
			'model' => $model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Multimedia;
        $thumbnail = [];
		if(isset($_POST['Multimedia']))
		{
			$model->attributes=$_POST['Multimedia'];
            $thumbnail = new UploadedFiles($this->tempPath, $model->thumbnail, $this->thumbOptions);
			$model->type = Multimedia::TYPE_VIDEO;
			if($model->save()){
                $thumbnail->move($this->thumbsPath);

				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
            'thumbnail'=>$thumbnail
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
		$thumbnail = new UploadedFiles($this->thumbsPath, $model->thumbnail, $this->thumbOptions);

		if(isset($_POST['Multimedia']))
		{
			$oldImage = $model->thumbnail;
			$model->attributes=$_POST['Multimedia'];
			$model->type = Multimedia::TYPE_VIDEO;
			if($model->save()){
                $thumbnail->update($oldImage, $model->thumbnail,$this->tempPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
            'thumbnail'=>$thumbnail
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
    {
        $model = $this->loadModel($id);
		$thumbnail = new UploadedFiles($this->tempPath, $model->thumbnail, $this->thumbOptions);
		$thumbnail->removeAll(true);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::app()->theme = 'front-end';
		$this->layout='//layouts/inner';
        $criteria = new CDbCriteria();
        $criteria->addCondition('type = :type');
		$criteria->order = 't.order ASC';
        $criteria->params[':type']='video';
        $dataProvider = new CActiveDataProvider('Multimedia', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize' => 15),
        ));

        $this->render('index', array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Multimedia('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Multimedia']))
			$model->attributes=$_GET['Multimedia'];
		$model->type = Multimedia::TYPE_VIDEO;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Multimedia the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Multimedia::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Multimedia $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='multimedia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
