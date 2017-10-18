<?php

class CoursesRegisterController extends Controller
{
    public $layout = '//layouts/inner';

    private $merchant = '';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess + admin, inquiry', // perform access control for CRUD operations
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
            'frontend' => array('index', 'bill', 'verify'),
            'backend' => array('admin', 'inquiry')
        );
    }

    /**
     * Buy ClassRegister
     */
    public function actionIndex($id)
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        $message = '';
        if(Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && Yii::app()->user->type == 'admin')){
            $message = Yii::t('app', 'To enroll in this class, you should first become a member.');
            $message .= '&nbsp;<a class="blue-link" data-toggle="modal" href="#login-modal">' . Yii::t('app', 'Log In') . '</a>';
            $message .= '&nbsp;' . Yii::t('app', 'or') . '&nbsp;';
            $message .= '<a class="blue-link" target="_blank" href="' . Yii::app()->baseUrl . '/#signup' . '">' . Yii::t('app', 'Sign Up.') . '</a>';
        }
        $class = Classes::model()->findByPk($id);
        if(!$class)
            $this->redirect(Yii::app()->baseUrl);
        $lastTransaction = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'model_id' => $id, 'model_name' => "Classes"));
        if($lastTransaction && $lastTransaction->status == 'paid')
            $message = Yii::t('app', 'You have already registered in this class.');
        if(!$class->remainingCapacity)
            $message = Yii::t('app', 'Sorry! This class is fully enrolled.');
        if(time() < $class->startSignupDate)
            $message = Yii::t('app', 'Please accept our apologies. The registration has not started yet.');
        if(time() > $class->endSignupDate)
            $message = Yii::t('app', 'Please accept our apologies. The deadline for registration has passed.');

        $this->render('index', array(
            'class' => $class,
            'message' => $message
        ));
    }

    /**
     * Show bill
     */
    public function actionBill($id)
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        $flag = false;
        if(isset($_POST['pay']) && empty($_POST['pay'])){
            $class = Classes::model()->findByPk($id);
            if(!$class)
                $this->redirect(Yii::app()->baseUrl);
            if(!$class->remainingCapacity)
                $this->redirect($this->createUrl('/courses/register/' . $id));
            if(time() < $class->startSignupDate)
                $this->redirect($this->createUrl('/courses/register/' . $id));
            if(time() > $class->endSignupDate)
                $this->redirect($this->createUrl('/courses/register/' . $id));
            if($class->price != 0){
                $lastTransaction = UserTransactions::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'model_id' => $id, 'model_name' => "Classes"));
                if($lastTransaction && $lastTransaction->status == 'unpaid'){
                    $flag = true;
                    $model = new UserTransactions();
                    $model->model_name = "Classes";
                    $model->model_id = $id;
                    $model->user_id = Yii::app()->user->getId();
                    $model->amount = $class->price;
                    $model->description = "پرداخت شهریه جهت ثبت نام در دوره {$class->course->title} کلاس {$class->title}";
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
                    $model->model_name = "Classes";
                    $model->model_id = $id;
                    $model->user_id = Yii::app()->user->getId();
                    $model->amount = $class->price;
                    $model->description = "پرداخت شهریه جهت ثبت نام در دوره {$class->course->title} کلاس {$class->title}";
                    $model->date = time();
                    $model->gateway = (int)$_POST['gateway'];
                    if($model->save()){
                        $flag = true;
                        $lastTransaction = $model;
                    }
                }
                if($flag){
                    $Amount = doubleval($lastTransaction->amount) * 10; //Amount will be based on Toman  - Required
                    $CallbackURL = Yii::app()->getBaseUrl(true) . '/courses/register/verify';  // Required
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
            }else{
                $model = new UserTransactions();
                $model->model_name = "Classes";
                $model->model_id = $id;
                $model->user_id = Yii::app()->user->getId();
                $model->amount = 0;
                $startDate = JalaliDate::date('Y/m/d', $class->startClassDate);
                $endDate = JalaliDate::date('Y/m/d', $class->endClassDate);
                $time = Controller::parseNumbers($class->startClassTime);
                $endTime = Controller::parseNumbers($class->endClassTime);
                $model->description = "پرداخت شهریه جهت ثبت نام در دوره {$class->course->title} کلاس {$class->title}";
                $model->date = time();
                $model->status = 'paid';
                $model->settle = 1;
                if($model->save()){
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
                }
                $this->render('free_register');
            }
        }else
            $this->redirect($this->createUrl('/courses/register/' . $id));
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
            $class = $model->class;
            $startDate = JalaliDate::date('Y/m/d', $class->startClassDate);
            $endDate = JalaliDate::date('Y/m/d', $class->endClassDate);
            $time = Controller::parseNumbers($class->startClassTime);
            $endTime = Controller::parseNumbers($class->endClassTime);
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

        $this->render('verify', array(
            'model' => $model,
            'msg' => $msg,
        ));
    }

    public function actionInquiry($id)
    {
        $model = UserTransactions::model()->findByAttributes(array('order_id' => $id));
        if($model){
            $result = Yii::app()->MellatPayment->InquiryRequest($model->order_id, $model->order_id, $model->sale_reference_id);
            var_dump($result);
            exit;
        }else
            echo 'Model is not found';
    }

    public function actionAdmin()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column1';
        $classIds = Yii::app()->db->createCommand()
            ->selectDistinct('model_id')
            ->from('{{user_transactions}}')
            ->where('model_name = "Classes" AND status = "paid"')
            ->order('model_id DESC')
            ->queryColumn();
        $classTransactions = array();
        foreach($classIds as $id){
            $class = Classes::model()->findByPk($id);
            $dataProvider = new CActiveDataProvider('UserTransactions', array(
                'criteria' => array(
                    'condition' => 'model_name = "Classes" AND model_id = :class_id AND status = "paid"',
                    'params' => array(':class_id' => $id),
                    'order' => 'date DESC'
                ),
                'pagination' => false
            ));
            $classTransactions[$id]['dataProvider'] = $dataProvider;
            $classTransactions[$id]['class'] = $class;
        }
        $this->render('admin', array(
            'courses' => Courses::model()->findAll(),
            'classTransactions' => $classTransactions
        ));
    }
}