<?php

class OrdersManageController extends Controller
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
			'checkAccess - index', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'view', 'index', 'create', 'update', 'admin', 'trash', 'restore', 'delete', 'upload', 'deleteUpload',
                'setting', 'verbalPay', 'pricing', 'addFile', 'deleteFile', 'changeStatus', 'uploadFile'
			)
		);
	}

    public function actions(){
        return array(
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'files',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => Orders::$acceptedFiles
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'OrderFiles',
                'attribute' => 'filename',
                'uploadDir' => '/uploads/orders',
                'storedMode' => 'record'
            ),
            'uploadFile' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'filename',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => Orders::$acceptedFiles
                )
            )
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
    {
		$model=new Orders;
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = $this->createAbsoluteUrl('/uploads/temp/');
        $filesDIR = Yii::getPathOfAlias("webroot") . "/uploads/orders/";
        if (!is_dir($filesDIR))
            mkdir($filesDIR);
        $filesArray = [];
        
		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
            $model->status = Orders::ORDER_STATUS_PENDING;
            if($model->order_price && $model->done_time)
                $model->status = Orders::ORDER_STATUS_PAYMENT;

            if(isset($_POST['Orders']['files'])) {
                foreach($_POST['Orders']['files'] as $file)
                    if ($file and is_file($tmpDIR.$file)){
                        $filesArray[] = array(
                            'name' => $file,
                            'src' => $tmpUrl . '/' . $file,
                            'size' => filesize($tmpDIR . $file),
                            'serverName' => $file,
                        );
                        $model->files[] = $file;
                    }
            }
			if($model->save()){
				foreach($model->files as $file)
					if ($file and is_file($tmpDIR.$file))
						@rename($tmpDIR.$file, $filesDIR.$file);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
            'filesArray' => $filesArray
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
        $tmpUrl = $this->createAbsoluteUrl('/uploads/temp/');
        $filesDIR = Yii::getPathOfAlias("webroot") . "/uploads/orders/";
        if (!is_dir($filesDIR))
            mkdir($filesDIR);
        $filesUrl = Yii::app()->getBaseUrl(true).'/uploads/orders';
        $filesArray = [];
        if($model->orderFiles){
            foreach($model->orderFiles as $file)
                if ($file->filename and is_file($filesDIR.$file->filename)){
                    $filesArray[] = array(
                        'name' => $file->filename,
                        'src' => $filesUrl . '/' . $file->filename,
                        'size' => filesize($filesDIR . $file->filename),
                        'serverName' => $file->filename,
                    );
                }else
                    $file->delete();
        }

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
            $model->files = $_POST['Orders']['files'];
			$model->update_date = time();
            if(isset($_POST['Orders']['files'])) {
                foreach($_POST['Orders']['files'] as $file)
                    if ($file and is_file($tmpDIR.$file)){
                        $filesArray[] = array(
                            'name' => $file,
                            'src' => $tmpUrl . '/' . $file,
                            'size' => filesize($tmpDIR . $file),
                            'serverName' => $file,
                        );
                        $model->files[] = $file;
                    }
            }
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
            'filesArray' => $filesArray
		));
	}

    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionPricing($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = 'pricing';
        if(isset($_POST['Orders'])){
            $model->attributes = $_POST['Orders'];
            $model->update_date = time();
            $model->status = Orders::ORDER_STATUS_PAYMENT;
            if($model->save()){
                $phone = $model->user->userDetails->phone;
                $time = Controller::parseNumbers(number_format($model->done_time));
                $price = Controller::parseNumbers(number_format($model->order_price));
                $smsText = "سفارش {$model->title} شما با کد شناسه {$model->id} در مدت {$time} روز کاری و مبلغ {$price} تومان زمانبندی و قیمت گذاری گردید.
لطفا جهت پرداخت هزینه به داشبورد حساب کاربری خود مراجعه فرمایید.
با تشکر
آوای شهیر";
                @Notify::Send($smsText, $phone, $model->user->email);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('view', 'id' => $model->id));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }
    }

    public function actionAddFile($id){
        $model = new OrderFiles();
        if(isset($_POST['OrderFiles']))
        {
            $model->attributes = $_POST['OrderFiles'];
            $model->order_id = $id;
            $model->file_type = OrderFiles::FILE_TYPE_DONE_FILE;
            if($model->save()) {
                if($model->filename && is_file(Yii::getPathOfAlias('webroot').'/uploads/temp/'.$model->filename))
                    rename(Yii::getPathOfAlias('webroot').'/uploads/temp/'.$model->filename,
                        Yii::getPathOfAlias('webroot').'/uploads/orders/'.$model->filename);
                echo CJSON::encode(['status' => true]);
            }else
                echo CJSON::encode(['status' => false]);
        }
        Yii::app()->end();
    }

    public function actionDeleteFile($id)
    {
        $filePath = Yii::getPathOfAlias('webroot') . '/uploads/orders/';
        $model = OrderFiles::model()->findByPk($id);
        if($model->filename && is_file($filePath . $model->filename))
            @unlink($filePath . $model->filename);
        $model->delete();

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionChangeStatus()
    {
        if(isset($_POST['order_id'])){
            /* @var $model Orders */
            $model = $this->loadModel($_POST['order_id']);
            $lastStatusLabel = $model->getStatusLabel();
            $newStatus = $_POST['newStatus'];
            $model->status = $newStatus;
            if($model->save()){
                if($model->status != Orders::ORDER_STATUS_DONE)
                    $smsText = "سفارش {$model->title} شما با کد شناسه {$model->id} از وضعیت {$lastStatusLabel} به {$model->getStatusLabel()} تغییر کرد.
با تشکر
آوای شهیر";
                else
                    $smsText = "سفارش {$model->title} شما با کد شناسه {$model->id} آماده تحویل است. لطفاًً برای دریافت فایل ها، از طریق حساب کاربری خود اقدام فرمایید.
با تشکر
آوای شهیر";
                @Notify::Send($smsText, $model->user->userDetails->phone, $model->user->email);
                echo CJSON::encode(array('status' => 'success'));
            }
        }
    }

    public function actionRestore($id)
    {
        $model = $this->loadModel($id);
        $model->status = Orders::ORDER_STATUS_PENDING;
        if($model->order_price){
            if($model->doneFiles)
                $model->status = Orders::ORDER_STATUS_DOING;
            else if($model->transaction && $model->transaction->status == 'paid')
                $model->status = Orders::ORDER_STATUS_PAID;
            elseif($model->transaction && $model->transaction->status == 'unpaid')
                $model->status = Orders::ORDER_STATUS_PAYMENT;
        }
        if($model->save()){
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;سفارش موردنظر بازیابی شد.');
            $this->redirect(array('admin'));
        }else
            Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
    }



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        if(isset($_GET['forever']) && $_GET['forever']){
            foreach($model->orderFiles as $file)
                if($file->filename && is_file(Yii::getPathOfAlias('webroot') . '/uploads/orders/' . $file->filename))
                    @unlink(Yii::getPathOfAlias('webroot') . '/uploads/orders/' . $file->filename);
            $flag = $model->delete();
            $msg = 'سفارش به طور کامل حذف گردید';
        }else{
            $model->status = Orders::ORDER_STATUS_DELETED;
            $flag = $model->save(false);
            $msg = 'سفارش به زباله دان منتقل گردید.';
        }

        if($flag)
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;'.$msg);
        else
            Yii::app()->user->setFlash('failed', 'در حذف سفارش مشکلی بوجود آمده است.');

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
        $this->layout = '//layouts/column1';
		$model=new Orders('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
	 * Manages all models.
	 */
	public function actionTrash()
	{
        $this->layout = '//layouts/column2';
		$model=new Orders('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];
        $model->status = Orders::ORDER_STATUS_DELETED;

		$this->render('trash',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionSetting(){
        Yii::app()->getModule('setting');
        if(isset($_POST['OrdersSetting'])){
            SiteSetting::setOption('order_receivers_phones',$_POST['OrdersSetting']['phones'], 'شماره تماس دریافت کنندگان اطلاعیه');
            SiteSetting::setOption('order_receivers_emails',$_POST['OrdersSetting']['emails'], 'پست الکترونیک دریافت کنندگان اطلاعیه');
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;تنظیمات ذخیره شد.');
        }
        $settings = [
            'phones' => SiteSetting::getOption('order_receivers_phones'),
            'emails' => SiteSetting::getOption('order_receivers_emails'),
        ];
        $this->render('settings',[
            'settings' => $settings
        ]);
    }

    public function actionVerbalPay($id)
    {
        $model = $this->loadModel($id);
        $model->status = Orders::ORDER_STATUS_PAID;
        $lastTransaction = $model->transaction;
        if($lastTransaction && $lastTransaction->status == 'paid'){
            Yii::app()->user->setFlash("failed", 'این سفارش قبلا پرداخت شده است.');
            $this->refresh();
        }elseif($lastTransaction && $lastTransaction->status == 'unpaid')
            $lastTransaction->delete();
        $trModel = new UserTransactions();
        $trModel->model_name = "Orders";
        $trModel->model_id = $model->id;
        $trModel->user_id = $model->user_id;
        $trModel->amount = $model->order_price;
        $trModel->description = "پرداخت هزینه سفارش ترجمه و تصحیح {$model->title} با شناسه #{$model->id}";
        $trModel->date = time();
        $trModel->status = 'paid';
        $trModel->verbal = 1;
        if($trModel->save() && $model->save()){
            Yii::app()->user->setFlash("success", 'پرداخت حضوری با موفقیت تایید شد.');
            // Send Notify to user
            $smsText = "پرداخت حضوری هزینه سفارش {$model->title} شما با کد شناسه {$model->id} با موفقیت تایید گردید.
شروع انجام سفارش متعاقباً به اطلاع شما خواهد رسید.
با تشکر
آوای شهیر";
            @Notify::Send($smsText, $model->user->userDetails->phone, $model->user->email);
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
            //
            $this->redirect(array('/orders/manage/'.$model->id));
        }
    }
}
