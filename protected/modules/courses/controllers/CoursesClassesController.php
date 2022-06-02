<?php

class CoursesClassesController extends Controller
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
			'checkAccess', // perform access control for CRUD operations
			'postOnly + delete,deleteRegister', // we only allow deletion via POST request
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
			'backend' => array('index', 'classRegister', 'deleteRegister', 'view', 'create', 'update', 'admin', 'delete', 'order', 'getCategories',
				'recycleBin', 'restore')
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
		$this->render('view', array(
				'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Classes;
		if(isset($_POST['Classes'])) {
			$model->attributes = $_POST['Classes'];
			$model->formTags = isset($_POST['Classes']['formTags']) ? explode(',', $_POST['Classes']['formTags']) : null;
			$model->teachers = isset($_POST['Classes']['teachers']) ? $_POST['Classes']['teachers']: null;
			$model->classDays = isset($_POST['Classes']['classDays']) ? explode(',', $_POST['Classes']['classDays']) : null;
			$model->price = isset($_POST['Classes']['price']) ? $_POST['Classes']['price'] : 0;
			$model->teacher_id = 0;

			if($model->save()) {
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
				'model' => $model,
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
		if($model->tags)
			foreach($model->tags as $tag)
				array_push($model->formTags, $tag->title);
//var_dump($model->teacherModels);exit;
		if($model->teacherModels)
			foreach($model->teacherModels as $teacher)
				array_push($model->teachers, $teacher->id);
		
		$model->classDays = $model->classDays ? explode(',', $model->classDays) : null;
		if(isset($_POST['Classes'])) {
			$model->attributes = $_POST['Classes'];
			$model->formTags = isset($_POST['Classes']['formTags']) ? explode(',', $_POST['Classes']['formTags']) : null;
            $model->teachers = isset($_POST['Classes']['teachers']) ? $_POST['Classes']['teachers']: null;
			$model->classDays = isset($_POST['Classes']['classDays']) ? explode(',', $_POST['Classes']['classDays']) : null;
			$model->price = isset($_POST['Classes']['price']) ? $_POST['Classes']['price'] : 0;

			if($model->save()) {
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update', array(
				'model' => $model,
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
		if($model->deleted){
			$model->delete();
		}else{
			$model->scenario = 'delete';
			$model->deleted = 1;
			$model->update();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Classes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Classes']))
			$model->attributes = $_GET['Classes'];
		$model->deleted = 0;
		$this->render('admin', array(
				'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionRecycleBin()
	{
		$model=new Classes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Classes']))
			$model->attributes=$_GET['Classes'];
		$model->deleted = 1;
		$this->render('recycle_bin',array(
			'model'=>$model,
		));
	}

	/**
	 * Restore deleted course from recycle bin
	 * @param $id
	 * @throws CDbException
	 * @throws CHttpException
	 */
	public function actionRestore($id)
	{
		$model = $this->loadModel($id);
		$model->scenario = 'delete';
		$model->deleted = 0;
		if($model->update())
			Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;با موفقیت بازیابی شد.');
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('recycleBin'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Classes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Classes::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Classes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'classes-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetCategories($id)
	{
		$categories = ClassCategories::model()->findAll('course_id = ?', array($id));
		foreach($categories as $category) {
			echo '<option value="'.$category->id.'">'.$category->title.'</option>';
		}
		Yii::app()->end();
	}

	public function actionClassRegister()
	{
		$model = new UserTransactions();

		$criteria = Classes::getValidClasses();
		$validClasses = Classes::model()->findAll($criteria);

		if(isset($_POST['UserTransactions'])){
			$class = Classes::model()->findByPk($_POST['UserTransactions']['model_id']);
			$startDate = JalaliDate::date('Y/m/d', $class->startClassDate);
			$endDate = JalaliDate::date('Y/m/d', $class->endClassDate);
			$time = Controller::parseNumbers($class->startClassTime);
			$endTime = Controller::parseNumbers($class->endClassTime);
			$lastTransaction = UserTransactions::model()->findByAttributes(array('user_id' => $_POST['UserTransactions']['user_id'], 'model_id' => $class->id, 'model_name' => "Classes"));
			if($lastTransaction && $lastTransaction->status == 'paid'){
				Yii::app()->user->setFlash("failed", 'این کاربر قبلا در این کلاس ثبت نام کرده است.');
				$this->refresh();
			}elseif($lastTransaction && $lastTransaction->status == 'unpaid')
				$lastTransaction->delete();
			$model = new UserTransactions();
			$model->model_name = "Classes";
			$model->model_id = $class->id;
			$model->user_id = $_POST['UserTransactions']['user_id'];
			$model->amount = $class->price;
			$model->description = "پرداخت شهریه جهت ثبت نام در دوره {$class->course->title} کلاس {$class->title}";
			$model->date = time();
			$model->status = 'paid';
			$model->verbal = 1;
			if($model->save()){
				Yii::app()->user->setFlash("success", 'ثبت نام باموفقیت انجام شد.');
				// Add Sms Schedules
				if($model->user && $model->user->userDetails && $model->user->userDetails->phone && !empty($model->user->userDetails->phone)){
					$phone = $model->user->userDetails->phone;
					$smsText = "ثبت نام شما در دوره {$class->course->title} کلاس {$class->title} با موفقیت انجام شد.
تاریخ شروع کلاس از {$startDate} تا {$endDate} هر هفته روزهای \"{$class->classDays}\" از ساعت {$time} الی {$endTime} می باشد.
با تشکر
آوای شهیر";
					@Notify::Send($smsText, $phone, $model->user->email);
					$smsScheduleText = "دانشجوی گرامی
زمان برگزاری کلاس {$class->title} شما از تاریخ {$startDate} تا {$endDate} هر هفته روزهای \"{$class->classDays}\" از ساعت {$time} الی {$endTime} می باشد.
با تشکر
آوای شهیر";
					@SmsSchedules::AddSchedule(
						$class->startClassDate - (2 * 24 * 60 * 60),
						$smsScheduleText,
						array($phone),
						array($model->user->email)
					);
				}
				//
				$this->refresh();
			}
		}

		$this->render('register', array(
				'model' => $model,
				'validClasses' => $validClasses
		));
	}

	public function actionDeleteRegister()
	{
		if($_POST['order_id']) {
			$model = UserTransactions::model()->findByAttributes(array('order_id'=>(int)$_POST['order_id']));
			if($model)
				$model->delete();
			elseif($model === null)
				throw new CHttpException(404, 'The requested page does not exist.');

		}
	}
}