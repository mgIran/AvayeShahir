<?php

class ClassRegisterController extends Controller
{
    public $layout='//layouts/inner';

    private $merchant = '-6194e8aa-0589-11e6-9b18-005056a205be';
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('admin'),
                'roles' => array('admin'),
            ),
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('index','bill','verify'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
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
        if(Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && Yii::app()->user->type == 'admin'))
        {
            $message = Yii::t('app','To enroll in this class, you should first become a member.');
            $message .= '&nbsp;<a class="blue-link" data-toggle="modal" href="#login-modal">'.Yii::t('app', 'Log In').'</a>';
            $message .= '&nbsp;'.Yii::t('app','or').'&nbsp;';
            $message .= '<a class="blue-link" target="_blank" href="'.Yii::app()->baseUrl.'/#signup'.'">'.Yii::t('app', 'Sign Up.').'</a>';
        }
        $class = Classes::model()->findByPk($id);
        if(!$class)
            $this->redirect(Yii::app()->baseUrl);
        $lastTransaction = UserTransactions::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(),'class_id' => $id));
        if($lastTransaction && $lastTransaction->status == 'paid')
            $message = Yii::t('app','You have already registered in this class.');
        $capacity = UserTransactions::model()->countByAttributes(array('status'=>'paid','class_id' => $id));
        if($capacity >= $class->capacity)
            $message = Yii::t('app','Sorry! This class is fully enrolled.');
        if(time() < $class->startSignupDate)
            $message = Yii::t('app','Please accept our apologies. The registration has not started yet.');
        if(time() > $class->endSignupDate)
            $message = Yii::t('app','Please accept our apologies. The deadline for registration has passed.');
        $this->render('index', array(
            'class'=>$class,
            'message' => $message
        ));
    }

    /**
     * Show bill
     */
    public function actionBill($id)
    {
        $flag = false;
        if(isset($_POST['pay']) && empty($_POST['pay'])) {
            $user = Users::model()->findByPk(Yii::app()->user->getId());
            $class = Classes::model()->findByPk($id);
            if(!$class)
                $this->redirect(Yii::app()->baseUrl);
            $capacity = UserTransactions::model()->countByAttributes(array('status'=>'paid','class_id' => $id));
            if($capacity >= $class->capacity)
                $this->redirect($this->createUrl('/courses/register/'.$id));
            if(time() < $class->startSignupDate)
                $this->redirect($this->createUrl('/courses/register/'.$id));
            if(time() > $class->endSignupDate)
                $this->redirect($this->createUrl('/courses/register/'.$id));
            $lastTransaction = UserTransactions::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(),'class_id' => $id));
            if($lastTransaction && $lastTransaction->status == 'unpaid')
                $flag = true;
            elseif($lastTransaction && $lastTransaction->status == 'paid')
                $flag = false;
            else {
                // Save payment
                $model = new UserTransactions();
                $model->class_id = $id;
                $model->user_id = Yii::app()->user->getId();
                $model->amount = $class->price;
                $model->description = 'پرداخت شهریه جهت ثبت نام در دوره '.$class->course->title.'، کلاس '.$class->title;  // Required
                $model->date = time();
                if($model->save()) {
                    $flag = true;
                    $lastTransaction = $model;
                }
            }
            if($flag){
                // Redirect to payment gateway
                $MerchantID = $this->merchant;  //Required
                $Amount = intval($lastTransaction->amount); //Amount will be based on Toman  - Required
                $Description = $lastTransaction->description;  // Required
                $Email = $user->email; // Optional
                $Mobile = $user->phone && !empty($user->phone) && intval($user->phone)?$user->phone:'0'; // Optional

                $CallbackURL = Yii::app()->getBaseUrl(true).'/courses/register/verify';  // Required

                include("lib/nusoap.php");
                $client = new NuSOAP_Client('https://ir.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
                $client->soap_defencoding = 'UTF-8';
                $result = $client->call('PaymentRequest', array(
                    array(
                        'MerchantID' => $MerchantID,
                        'Amount' => $Amount,
                        'Description' => $Description,
                        'Email' => $Email,
                        'Mobile' => $Mobile,
                        'CallbackURL' => $CallbackURL
                    )
                ));

                //Redirect to URL You can do it also by creating a form
                if ($result['Status'] == 100)
                    $this->redirect('https://www.zarinpal.com/pg/StartPay/' . $result['Authority']);
                else
                    echo 'ERR: ' . $result['Status'];
            }
        }
        else
            $this->redirect($this->createUrl('/courses/register/'.$id));
    }

    public function actionVerify()
    {
//        Yii::app()->theme='front-end';
//        $this->layout='//layouts/inner';
//        $model=UserTransactions::model()->findByAttributes(array('user_id'=>Yii::app()->user->getId(), 'status'=>'unpaid'));
//        $userClassRel = new UserClassRel();
//        $MerchantID = $this->merchant;
//        $Amount = $model->amount; //Amount will be based on Toman
//        $Authority = $_GET['Authority'];
//
//        if($_GET['Status'] == 'OK') {
//            include("lib/nusoap.php");
//            $client = new NuSOAP_Client('https://ir.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
//            $client->soap_defencoding = 'UTF-8';
//            $result = $client->call('PaymentVerification', array(
//                    array(
//                        'MerchantID' => $MerchantID,
//                        'Authority' => $Authority,
//                        'Amount' => $Amount
//                    )
//                )
//            );
//
//            if ($result['Status'] == 100) {
//                $model->status = 'paid';
//                $model->token = $result['RefID'];
//                $model->description = 'خرید اعتبار از طریق درگاه زرین پال';
//                $model->save();
//                // Increase credit
//                $userDetails->setScenario('update-credit');
//                $userDetails->credit = $userDetails->credit + $model->amount;
//                $userDetails->save();
//                Yii::app()->user->setFlash('success', 'پرداخت شما با موفقیت انجام شد.');
//            } else {
//                $errors = array(
//                    '-1' => 'اطلاعات ارسال شده ناقص است.',
//                    '-2' => 'IP یا کد پذیرنده صحیح نیست.',
//                    '-3' => 'با توجه به محدودیت ها امکان پرداخت رقم درخواست شده میسر نمی باشد.',
//                    '-4' => 'سطح تایید پذیرنده پایین تر از سطح نقره ای است.',
//                    '-11' => 'درخواست مورد نظر یافت نشد.',
//                    '-12' => 'امکان ویرایش درخواست میسر نمی باشد.',
//                    '-21' => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.',
//                    '-22' => 'تراکنش ناموفق بود.',
//                    '-33' => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.',
//                    '-34' => 'سقف تقسیم تراکنش از لحاظ تعداد یا رقم عبور نموده است.',
//                    '-40' => 'اجازه دسترسی به متد مربوطه وجود ندارد.',
//                    '-41' => 'اطلاعات ارسال شده مربوط به AdditionalData غیر معتبر می باشد.',
//                    '-42' => 'مدت زمان معتبر طول عمر شناسه پرداخت باید بین 30 دقیقه تا 45 روز باشد.',
//                    '-54' => 'درخواست مورد نظر آرشیو شده است.',
//                    '101' => 'عملیات پرداخت موفق بوده و قبلا بررسی تراکنش انجام شده است.',
//                );
//                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
//                Yii::app()->user->setFlash('transactionFailed', isset($errors[$result['Status']]) ? $errors[$result['Status']] : 'در انجام عملیات پرداخت خطایی رخ داده است.');
//            }
//        }
//        else
//            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بوده یا توسط کاربر لغو شده است.');
//
//        $this->render('verify', array(
//            'model'=>$model,
//            'userDetails'=>$userDetails,
//        ));
    }

    public function actionAdmin(){
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column1';
        $classIds = Yii::app()->db->createCommand()
            ->selectDistinct('class_id')
            ->from('{{user_transactions}}')
            ->where('status = "paid"')
            ->order('class_id DESC')
            ->queryColumn();
        $classTransactions = array();
        foreach($classIds as $id)
        {
            $class = Classes::model()->findByPk($id);
            $dataProvider = new CActiveDataProvider('UserTransactions',array(
                'criteria' => array(
                    'condition' => 'class_id = :class_id AND status = "paid"',
                    'params' => array(':class_id'=>$id)
                ),
                'pagination' => false
            ));
            $classTransactions[$id]['dataProvider'] = $dataProvider;
            $classTransactions[$id]['class'] = $class;
        }
        $this->render('admin',array(
            'courses' => Courses::model()->findAll(),
            'classTransactions' => $classTransactions
        ));
    }
}