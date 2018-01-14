<?php

class MultimediaPicturesController extends Controller
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
                'attribute' => 'data',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('jpg','jpeg','png','gif')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Multimedia',
                'attribute' => 'data',
                'uploadDir' => '/uploads/multimedia',
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
        if(Yii::app()->request->isAjaxRequest){
            Multimedia::model()->updateCounters(array('seen' => 1), 'id = :id', array(':id' => $id));
            $this->beginClip('multimedia-view');
			$this->renderPartial('_view', array('model' => $this->loadModel($id)));
			$this->endClip();
			echo CJSON::encode(['status' => true, 'html' => $this->clips['multimedia-view']]);
			Yii::app()->end();
		}else
			$this->render('view', array(
				'model' => $this->loadModel($id)
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
    {
        $model = new Multimedia;

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl . '/uploads/temp/';
        $dataDIR = Yii::getPathOfAlias("webroot") . "/uploads/multimedia/";
        if(!is_dir($dataDIR))
            mkdir($dataDIR);

        $data = array();
        if(isset($_POST['Multimedia'])){
            $model->attributes = $_POST['Multimedia'];
            if(isset($_POST['Multimedia']['data'])){
                $file = $_POST['Multimedia']['data'];
                $data = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            $model->type = Multimedia::TYPE_PICTURE;
            if($model->save()){
                if($model->data and file_exists($tmpDIR . $model->data))
                    @rename($tmpDIR . $model->data, $dataDIR . $model->data);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create', array(
            'model' => $model,
            'data' => $data
        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if(!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl . '/uploads/temp/';
        $dataDIR = Yii::getPathOfAlias("webroot") . "/uploads/multimedia/";
        if(!is_dir($dataDIR))
            mkdir($dataDIR);
        $dataUrl = Yii::app()->baseUrl . '/uploads/multimedia/';

        $data = array();
        if($model->data and file_exists($dataDIR . $model->data)){
            $file = $model->data;
            $data = array(
                'name' => $file,
                'src' => $dataUrl . '/' . $file,
                'size' => filesize($dataDIR . $file),
                'serverName' => $file,
            );
        }
        if(isset($_POST['Multimedia'])){
            $model->attributes = $_POST['Multimedia'];
            if(isset($_POST['Multimedia']['data']) and file_exists($tmpDIR . $_POST['Multimedia']['data'])){
                $file = $_POST['Multimedia']['data'];
                $data = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
            $model->type = Multimedia::TYPE_PICTURE;
            if($model->save()){
                if($model->data and file_exists($tmpDIR . $model->data))
                    @rename($tmpDIR . $model->data, $dataDIR . $model->data);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('update', array(
            'model' => $model,
            'data' => $data
        ));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$dataDIR = Yii::getPathOfAlias("webroot") . "/uploads/multimedia/";
		$model = $this->loadModel($id);
		if($model->data && is_file($dataDIR . $model->data))
			@unlink($dataDIR . $model->data);
		if($model->thumbnail && is_file($dataDIR . 'thumbnail/' . $model->thumbnail))
			@unlink($dataDIR . 'thumbnail/' . $model->thumbnail);
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
		$criteria->params[':type']='picture';
		$dataProvider = new CActiveDataProvider('Multimedia', array(
			'criteria'=>$criteria,
			'pagination'=>false,
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
        $model->type = Multimedia::TYPE_PICTURE;
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
