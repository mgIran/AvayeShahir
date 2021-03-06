<?php

class WritingsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - view, index, tag, ajaxLoad', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
//			'ajaxOnly + loadAjax', // we only allow deletion via POST request
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
			'frontend' => array('index', 'view', 'tag', 'ajaxLoad'),
			'backend' => array('create', 'update', 'admin', 'delete', 'order', 'upload', 'deleteUpload', 'fetch')
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
			'fetch' => array(
				'class' => 'ext.fileManager.actions.AjaxFetchFilesListAction',
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
//		$this->description = mb_substr(strip_tags($model->summary),0,160,'UTF-8');
		$this->description = substr(strip_tags($model->getValueLang('summary', 'en')), 0, 160);
		$this->pageTitle = $model->getValueLang('title', 'en');
		// increase seen counter
		Yii::app()->db->createCommand()->update('{{writings}}', array('seen' => ((int)$model->seen + 1)), 'id = :id', array(":id" => $model->id));

		$hash = Yii::app()->jwt->encode(array(
			'id' => $model->id,
			'csrf' => Yii::app()->request->csrfToken
		));
//		var_dump()
		// get latest writings
		$this->render('view', array(
			'model' => $model,
			'hash' => $hash,

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
		$this->keywords = 'آوای شهیر,رایتینیگ ها آموزشی ' . $model->title . ',برچسب ' . $model->title . ',' . $model->title;
		$this->pageTitle = 'برچسب ' . $model->title;

		// get latest writings
		$criteria = Writings::getValidWritings();
		$criteria->together = true;
		$criteria->compare('tagsRel.tag_id', $model->id);
		$criteria->with[] = 'tagsRel';
		$dataProvider = new CActiveDataProvider("Writings", array(
			'criteria' => $criteria
		));
		$this->render('tags', array(
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
		if(!is_dir($tmpDIR))
			mkdir($tmpDIR);
		$tmpUrl = Yii::app()->baseUrl . '/uploads/temp/';
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/writings/";
		if(!is_dir($imageDIR))
			mkdir($imageDIR);
		if(!is_dir($imageDIR . '/200x200'))
			mkdir($imageDIR . '/200x200');

		$model = new Writings;

		$image = array();
		if(isset($_POST['Writings'])){
			$model->attributes = $_POST['Writings'];
			$model->category_id = !$model->category_id || empty($model->category_id)?null:$model->category_id;
			if(isset($_POST['Writings']['image'])){
				$file = $_POST['Writings']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish')
				$model->publish_date = time();
			$model->formTags = isset($_POST['Writings']['formTags'])?explode(',', $_POST['Writings']['formTags']):null;
			if($model->save()){
				if($model->image and file_exists($tmpDIR . $model->image)){
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR . '200x200/' . $model->image);
					@rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;	اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
			'image' => $image,
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
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/writings/";
		if(!is_dir($imageDIR))
			mkdir($imageDIR);
		$imageUrl = Yii::app()->baseUrl . '/uploads/writings/';

		$image = array();
		if($model->image and file_exists($imageDIR . $model->image)){
			$file = $model->image;
			$image = array(
				'name' => $file,
				'src' => $imageUrl . '/' . $file,
				'size' => filesize($imageDIR . $file),
				'serverName' => $file,
			);
		}

		foreach($model->tags as $tag)
			array_push($model->formTags, $tag->title);

		if(isset($_POST['Writings'])){
			$model->attributes = $_POST['Writings'];
			if(isset($_POST['Writings']['image']) and file_exists($tmpDIR . $_POST['Writings']['image'])){
				$file = $_POST['Writings']['image'];
				$image = array(
					'name' => $file,
					'src' => $tmpUrl . '/' . $file,
					'size' => filesize($tmpDIR . $file),
					'serverName' => $file,
				);
			}
			if($model->status == 'publish' && !$model->publish_date)
				$model->publish_date = time();
			$model->formTags = isset($_POST['Writings']['formTags'])?explode(',', $_POST['Writings']['formTags']):null;
			if($model->save()){
				if($model->image and file_exists($tmpDIR . $model->image)){
					$thumbnail = new Imager();
					$thumbnail->createThumbnail($tmpDIR . $model->image, 200, 200, false, $imageDIR . '200x200/' . $model->image);
					@rename($tmpDIR . $model->image, $imageDIR . $model->image);
				}
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update', array(
			'model' => $model,
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
		$imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/writings/";
		$model = $this->loadModel($id);
		if(file_exists($imageDIR . $model->image)){
			@unlink($imageDIR . $model->image);
			@unlink($imageDIR . '200x200/' . $model->image);
		}
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
		$this->layout = '//layouts/inner';
		$criteria = Writings::model()->getValidWritings();
		$dataProvider = new CActiveDataProvider('Writings', array(
			'criteria' => $criteria,
			'pagination' => false
		));
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Writings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Writings']))
			$model->attributes = $_GET['Writings'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Writings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Writings::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Writings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'class-categories-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionUpload()
	{
		$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

		if(!is_dir($tempDir))
			mkdir($tempDir);
		if(isset($_FILES)){
			$file = $_FILES['image'];
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file['name'] = Controller::generateRandomString(5) . time();
			while(file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name'] . '.' . $ext))
				$file['name'] = Controller::generateRandomString(5) . time();
			$file['name'] = $file['name'] . '.' . $ext;
			if(move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
				$response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
			else
				$response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
		}else
			$response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
		echo CJSON::encode($response);
		Yii::app()->end();
	}

	public function actionDeleteUpload()
	{
		$Dir = Yii::getPathOfAlias("webroot") . '/uploads/writings/';

		if(isset($_POST['fileName'])){

			$fileName = $_POST['fileName'];

			$tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

			$model = Writings::model()->findByAttributes(array('image' => $fileName));
			if($model){
				if(@unlink($Dir . $model->image)){
					@unlink($Dir . '200x200/' . $model->image);
					$model->updateByPk($model->id, array('image' => null));
					$response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
				}else
					$response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
			}else{
				@unlink($tempDir . $fileName);
				$response = ['state' => 'ok', 'msg' => 'حذف شد.'];
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionAjaxLoad()
	{
		if(isset($_POST['hash']) && !empty($_POST['hash'])){
			$hashMap = (array)Yii::app()->jwt->decode($_POST['hash']);
			if(isset($hashMap['id']) && !empty((int)$hashMap['id']) && isset($hashMap['csrf']) && !empty($hashMap['csrf']) && $hashMap['csrf'] == Yii::app()->request->csrfToken){
				$id = $hashMap['id'];
				$model = Writings::model()->findByPk($id);
				if($model !== null){
					$this->beginClip('content');
					$this->renderPartial('_ajax_load_content', compact('model'));
					$this->endClip();
					$result = [
						'status' => true,
						'content' => $this->clips['content']
					];
				}else
					$result = [
						'status' => false,
						'message' => 'خطا در دریافت اطلاعات!'
					];
			}else
				$result = [
					'status' => false,
					'message' => 'خطای اعتبارسنجی!'
				];
		}else
			$result = [
				'status' => false,
				'message' => 'خطا در ارسال درخواست!'
			];
		echo CJSON::encode($result);
		Yii::app()->end();
	}
}