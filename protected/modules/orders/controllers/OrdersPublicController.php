<?php

class OrdersPublicController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/inner';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - index', // perform access control for CRUD operations
		);
	}

	/**
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'frontend' => array(
				'index', 'view', 'delete', 'upload', 'deleteUpload', 'payment', 'bill', 'verify'
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
	public function actionIndex()
    {
        Yii::app()->theme = 'front-end';
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
            if(Yii::app()->user->isGuest && Yii::app()->user->type == 'admin')
                $this->refresh();
			$model->attributes=$_POST['Orders'];
            $model->user_id = Yii::app()->user->getId();
            if(isset($_POST['Orders']['files'])) {
                foreach($_POST['Orders']['files'] as $file)
                    if ($file and file_exists($tmpDIR.$file)){
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
                    if ($file and file_exists($tmpDIR.$file))
                        @rename($tmpDIR.$file, $filesDIR.$file);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;'.Yii::t('app', 'Your request has successfully been registered. Having examined your paper, we will inform you about thr price through an SMS.'));
				$this->refresh();
			}else
				Yii::app()->user->setFlash('failed', Yii::t('app', 'Oops! A problem has occurred! Please try again!'));
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
                if ($file->filename and file_exists($filesDIR.$file->filename)){
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
            if(isset($_POST['Orders']['files'])) {
                foreach($_POST['Orders']['files'] as $file)
                    if ($file and file_exists($tmpDIR.$file)){
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
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;'.Yii::t('app', 'Your request has successfully been registered. Having examined your paper, we will inform you about thr price through an SMS.'));
                $this->refresh();
            }else
                Yii::app()->user->setFlash('failed', Yii::t('app', 'Oops! A problem has occurred! Please try again!'));
		}

		$this->render('update',array(
			'model'=>$model,
            'filesArray' => $filesArray
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
        $model->status = Orders::ORDER_STATUS_DELETED;
        if($model->save(false))
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;' . Yii::t('app', 'Order successfully deleted.'));
        else
            Yii::app()->user->setFlash('failed', Yii::t('app', 'Oops! A problem has occurred in deleting order! Please try again!'));
        $this->redirect(array('/dashboard?tab=orders'));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
	public function actionPayment($id)
	{
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/panel';
        $message = false;
        
        $model = $this->loadModel($id);
        if($model->status > Orders::ORDER_STATUS_PAYMENT)
            $message = Yii::t('app', 'Please accept our apologies. This order has already been paid.');
        else if($model->status == Orders::ORDER_STATUS_PENDING)
            $message = Yii::t('app', 'Please accept our apologies. This order has not yet been priced.');

        $lastTransaction = UserTransactions::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->getId(), 
            'model_id' => $id, 
            'model_name' => "Orders"
        ));
        
        if($lastTransaction && $lastTransaction->status == 'paid')
            $message = Yii::t('app', 'Please accept our apologies. You have already paid this invoice.');

        $this->render('payment', array(
            'model' => $model,
            'message' => $message
        ));
        
	}

    public function actionBill($id)
	{
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        $flag = false;
        if(isset($_POST['pay']) && empty($_POST['pay'])){
            $order = $this->loadModel($id);
            if(!$order)
                $this->redirect(array('/dashboard'));
            if($order->status != Orders::ORDER_STATUS_PAYMENT)
                $this->redirect(array('/dashboard'));
            if($order->order_price != 0){
                $lastTransaction = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'model_id' => $id, 'model_name' => "Orders"));
                if($lastTransaction && $lastTransaction->status == 'unpaid'){
                    $flag = true;
                    $model = new UserTransactions();
                    $model->model_name = "Orders";
                    $model->model_id = $id;
                    $model->user_id = Yii::app()->user->getId();
                    $model->amount = $order->order_price;
                    $model->description = "پرداخت هزینه سفارش ترجمه و تصحیح {$order->title} با شناسه #{$order->id}";
                    $model->date = time();
                    $model->newOrderId();
                    $model->gateway = (int)$_POST['gateway'];
                    $lastTransaction->delete();
                    if($model->save()){
                        $flag = true;
                        $lastTransaction = $model;
                    }
                }elseif($lastTransaction && $lastTransaction->status == 'paid')
                    $flag = false;
                else{
                    // Save payment
                    $model = new UserTransactions();
                    $model->model_name = "Orders";
                    $model->model_id = $id;
                    $model->user_id = Yii::app()->user->getId();
                    $model->amount = $order->order_price;
                    $model->description = "پرداخت هزینه سفارش ترجمه و تصحیح {$order->title} با شناسه #{$order->id}";
                    $model->date = time();
                    $model->gateway = (int)$_POST['gateway'];
                    if($model->save()){
                        $flag = true;
                        $lastTransaction = $model;
                    }
                }
                if($flag){
                    $Amount = doubleval($lastTransaction->amount) * 10;
                    $CallbackURL = Yii::app()->getBaseUrl(true) . '/order/verify';  // Required
                    if($lastTransaction->gateway == UserTransactions::GATEWAY_MELLAT){
                        $result = Yii::app()->MellatPayment->PayRequest($Amount, $lastTransaction->order_id, $CallbackURL);
                        if(!$result['error']){
                            $lastTransaction->ref_id = $result['responseCode'];
                            $lastTransaction->update();
                            $this->render('ext.MellatPayment.views._redirect', array('ReferenceId' => $result['responseCode']));
                        }else{
                            echo '<meta charset="utf-8">';
                            echo 'ERR: ' . Yii::app()->MellatPayment->getResponseText($result['responseCode']);
                        }
                    }else{
                        $this->render('ext.SinaPayment.views._redirect', array(
                            'Amount' => $Amount,
                            'ResNum' => $lastTransaction->order_id,
                            'MID' => Yii::app()->SinaPayment->MID,
                            'callbackUrl' => $CallbackURL,
                        ));
                    }
                }
            }else
                $this->redirect($this->createUrl('/order/payment/' . $id));
        }else
            $this->redirect($this->createUrl('/order/payment/' . $id));
	}

    public function actionVerify()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        $msg = '';
        $result = NULL;
        $notify = false;
        if(isset($_POST['RefId'])){
            $orderId = $_POST['RefId'];
            $model = UserTransactions::model()->findByAttributes(array('ref_id' => $orderId));
            if($_POST['ResCode'] == 0){
                $result = Yii::app()->MellatPayment->VerifyRequest($model->order_id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
            }
            if($result != NULL){
                $RecourceCode = (!is_array($result)?$result:$result['responseCode']);
                if($RecourceCode == 0){
                    $model->status = 'paid';
                    // Settle Payment
                    $settle = Yii::app()->MellatPayment->SettleRequest($model->order_id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
                    if($settle)
                    {
                        $model->settle = 1;
                        $notify = true;
                    }
                }
            }else{
                $RecourceCode = $_POST['ResCode'];
            }
            $model->res_code = $RecourceCode;
            $model->sale_reference_id = $_POST['SaleReferenceId'];
            $model->update();
        }elseif(isset($_POST['ResNum'])){
            $orderId = $_POST['ResNum'];
            $model = UserTransactions::model()->findByAttributes(array('order_id' => $orderId));
            $model->sale_reference_id = isset($_POST['RefNum'])?$_POST['RefNum']:null;
            $model->ref_id = isset($_POST['TraceNo'])?$_POST['TraceNo']:null;
            if($_POST['State'] == "OK"){
                if(Yii::app()->SinaPayment->RequestUnPack()){
                    Yii::app()->SinaPayment->VerifyRequest();
                    $model->sale_reference_id = Yii::app()->SinaPayment->refNumber;
                    if($model->amount * 10 == Yii::app()->SinaPayment->bankAmount){
                        $model->status = 'paid';
                        $model->res_code = 0;
                        $model->settle = 1;
                        $notify = true;
                    }else
                        $model->res_code = -1;
                }
            }else{
                $model->res_code = -1;
                if($_POST['State'] == 'Canceled By User'){
                    $model->res_code = 17;
                    $msg = Yii::t('rezvan', 17);
                }
            }
            $msg = Yii::app()->SinaPayment->getError();
            $model->update();
        }else
            throw new CHttpException(404, 'تراکنش پرداختی شما یافت نشد، در صورتی که مبلغی از حساب شما کسر شده طی 72 ساعت آینده به حساب شما برگردانده خواهد شد.');

        // Add Sms Schedules
        if($notify && $model->user && $model->user->userDetails && $model->user->userDetails->phone && !empty($model->user->userDetails->phone)){
            $order = $model->order;
            $phone = $model->user->userDetails->phone;
            $smsText = "هزینه سفارش {$order->title} با کد شناسه {$order->id} با موفقیت پرداخت گردید و در اختیار کارشناسان قرار گرفت، شروع انجام سفارش متعاقباً به اطلاع شما خواهد رسید. 
با تشکر
آوای شهیر";
            @Notify::Send($smsText, $phone, $model->user->email);
        }

        $this->render('verify', array(
            'model' => $model,
            'msg' => $msg,
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
}
