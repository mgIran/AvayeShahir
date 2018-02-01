<?php

class UsersPublicController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess + dashboard, logout, setting, update', // perform access control for CRUD operations
        );
    }

    public function actions(){
        return array(
            'captcha2' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
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
            'frontend' => array('dashboard','logout','setting','update','register','login','verify','forgetPassword','changePassword','captcha'),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Login Action
     */
    public function actionLogin()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
        if(!Yii::app()->user->isGuest && Yii::app()->user->type === 'user')
            $this->redirect(Yii::app()->baseUrl);

        $model = new UserLoginForm;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }

        if(isset($_POST['UserLoginForm'])) {
            $model->attributes = $_POST['UserLoginForm'];
            if($model->validate() && $model->login()) {
                if(isset($_POST['ajax'])) {
                    echo CJSON::encode(array('state' => 'ok'));
                    Yii::app()->end();
                } else {
                    if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl.'/')
                        $this->redirect(Yii::app()->user->returnUrl);
                    else
                        $this->redirect($this->createAbsoluteUrl('//'));
                }
            } else
                if(isset($_POST['ajax'])) {
                    echo CJSON::encode(array('state' => 'error'));
                    Yii::app()->end();
                } else
                    $this->redirect($this->createAbsoluteUrl('//'));
        }
        $this->render('login', array('model' => $model));
    }

    public function actionRegister()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
        $model = new Users('agreeTerms');
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }
        if(isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = 'active';
            $model->create_date=time();
            if($model->save()) {
                // verfication Email send
//                $token=md5($model->id.'#'.$model->password.'#'.$model->email.'#'.$model->create_date);
//                $model->updateByPk($model->id, array('verification_token'=>$token));

                $msg = '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
                $msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
                $msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;">ثبت نام با موفقیت انجام شد.</div>';
                $msg .= '<div style="color: #444;font-size: 13px;text-align: right;">';
                $msg .= '<p>نام کاربری (پست الکترونیک) : '.$model->email.'</p>';
                $msg .= '<p>رمز عبور : '.$_POST['Users']['password'].'</p>';
                $msg .= '</div>';
                $msg .= '</div>';
                (new Mailer())->mail($model->email, 'ثبت نام در '.Yii::app()->name, $msg,
                    Yii::app()->params['no-reply-email']);
                $msg = Yii::t('app','Registration was successful.');

                Yii::app()->user->setFlash('success' ,$msg);
                if(isset($_POST['ajax'])) {
                    echo CJSON::encode(array('state' => 'ok'));
                    Yii::app()->end();
                } else {
                    if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl.'/')
                        $this->redirect(Yii::app()->user->returnUrl);
                    else
                        $this->redirect(Yii::app()->createAbsoluteUrl('//'));
                }
            }
            else {
                $msg = Yii::t('app','Registration Failed!!!Please try again.');
                Yii::app()->user->setFlash('failed' ,$msg);
                if(isset($_POST['ajax'])) {
                    echo CJSON::encode(array('state' => 'error'));
                    Yii::app()->end();
                } else
                    $this->redirect($this->createAbsoluteUrl('//'));
            }
        }
        $this->render('register', array('model' => $model));
    }

    /**
     * Logout Action
     */
    public function actionLogout() {
        Yii::app()->user->logout(false);
        $this->redirect(array('/'));
    }

    /**
     * Dashboard Action
     */
    public function actionDashboard()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/panel';
        Yii::app()->getModule('orders');
        $model=Users::model()->findByPk(Yii::app()->user->getId());

        $transactions=new UserTransactions('search');
        $transactions->model_name = 'Classes';
        $transactions->status = 'paid';
        $transactions->user_id = Yii::app()->user->getId();

        $totalTransactionsAmount =Yii::app()->db->createCommand()
            ->select('SUM(amount) AS sum')
            ->from('{{user_transactions}}')
            ->where('status="paid"')
            ->queryScalar();

        $this->render('dashboard', array(
            'model'=>$model,
            'transactions' => $transactions->search(),
            'totalTransactionsAmount' => $totalTransactionsAmount
        ));
    }

    /**
     * Change password
     */
    public function actionSetting()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/panel';
        $model=Users::model()->findByPk(Yii::app()->user->getId());
        $model->setScenario('update');

        if(isset($_POST['ajax']) && $_POST['ajax'] === 'change-pass-form') {
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $model->password=$_POST['Users']['newPassword'];
                if($model->save())
                {
                    Yii::app()->user->setFlash('setting-success' , Yii::t('app','Operation was successful.'));
                    if(isset($_POST['ajax']) && $_POST['ajax'] === 'change-pass-form')
                    {
                        echo CJSON::encode(['state' => 'ok' ,'url' => Yii::app()->createUrl('/dashboard?tab=setting')]);
                        Yii::app()->end();
                    }
                    else
                        $this->redirect($this->createUrl('/dashboard'));
                }
                else
                {
                    Yii::app()->user->setFlash('setting-failed' , Yii::t('app','An error occurred in data recording! Please try again.'));
                    if(isset($_POST['ajax']) && $_POST['ajax'] === 'change-pass-form')
                    {
                        echo CJSON::encode(['state' => 'error']);
                        Yii::app()->end();
                    }
                    else
                        $this->redirect($this->createUrl('/dashboard'));
                }
            }
        }

        $this->render('setting', array(
            'model'=>$model,
        ));
    }

    /**
     * Update Details
     */
    public function actionUpdate()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/panel';
        $model = UserDetails::model()->findByPk(Yii::app()->user->getId());
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'user-details-form') {
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }

        if(isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            if($model->save()) {
                Yii::app()->user->setFlash('general-success', Yii::t('app', 'Operation was successful.'));
                if(isset($_POST['ajax']) && $_POST['ajax'] === 'user-details-form') {
                    echo CJSON::encode(['state' => 'ok']);
                    Yii::app()->end();
                } else
                    $this->redirect($this->createUrl('/dashboard'));
            } else {
                Yii::app()->user->setFlash('general-failed', Yii::t('app', 'An error occurred in data recording! Please try again.'));
                if(isset($_POST['ajax']) && $_POST['ajax'] === 'user-details-form') {
                    echo CJSON::encode(['state' => 'error']);
                    Yii::app()->end();
                } else
                    $this->redirect($this->createUrl('/dashboard'));
            }
        }
    }
    /**
     * Performs the AJAX validation.
     * @param Apps $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    /**
     * Verify email
     */
    public function actionVerify()
    {
        if(!Yii::app()->user->isGuest and Yii::app()->user->type!='admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if(!Yii::app()->user->isGuest and Yii::app()->user->type =='admin')
            Yii::app()->user->logout(false);

        $token=Yii::app()->request->getQuery('token');
        $model=Users::model()->find('verification_token=:token', array(':token'=>$token));
        if($model)
        {
            if($model->status=='pending')
            {
                if(time() <= $model->create_date+259200)
                {
                    $model->updateByPk($model->id, array('status'=>'active'));
                    Yii::app()->user->setFlash('success' , 'حساب کاربری شما فعال گردید.');
                    $this->redirect($this->createUrl('/login'));
                }
                else
                {
                    Yii::app()->user->setFlash('failed' , 'لینک فعال سازی منقضی شده و نامعتبر می باشد. لطفا مجددا ثبت نام کنید.');
                    $this->redirect($this->createUrl('/register'));
                }
            }
            elseif($model->status=='active')
            {
                Yii::app()->user->setFlash('failed' , 'این حساب کاربری قبلا فعال شده است.');
                $this->redirect($this->createUrl('/login'));
            }
            else
            {
                Yii::app()->user->setFlash('failed' , 'امکان فعال سازی این کاربر وجود ندارد. لطفا مجددا ثبت نام کنید.');
                $this->redirect($this->createUrl('/register'));
            }
        }
        else
        {
            Yii::app()->user->setFlash('failed' , 'لینک فعال سازی نامعتبر می باشد.');
            $this->redirect($this->createUrl('/register'));
        }
    }

    /**
     * Forget password
     */
    public function actionForgetPassword()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        if(!Yii::app()->user->isGuest and Yii::app()->user->type!='admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if(!Yii::app()->user->isGuest and Yii::app()->user->type =='admin')
            Yii::app()->user->logout(false);

        if(isset($_POST['email']))
        {
            $model=Users::model()->findByAttributes(array('email'=>$_POST['email']));
            if($model)
            {
                if($model->status=='active')
                {
                    if($model->change_password_request_count!=3)
                    {
                        $token=md5($model->id.'#'.$model->password.'#'.$model->email.'#'.$model->create_date.'#'.time());
                        $count=intval($model->change_password_request_count);
                        $model->updateByPk($model->id, array('verification_token'=>$token, 'change_password_request_count'=>$count+1));
                        $message = '<div style="color: #2d2d2d;font-size: 14px;text-align: right;">با سلام<br>بنا به درخواست شما جهت تغییر کلمه عبور لینک زیر خدمتتان ارسال گردیده است.</div>';
                        $message .= '<div style="text-align: right;font-size: 9pt;">';
                        $message .= '<a href="'.Yii::app()->getBaseUrl(true).'/users/public/changePassword/token/'.$token.'">'.Yii::app()->getBaseUrl(true).'/users/public/changePassword/token/'.$token.'</a>';
                        $message .= '</div>';
                        $message .= '<div style="font-size: 8pt;color: #888;text-align: right;">اگر شخص دیگری غیر از شما این درخواست را صادر نموده است، یا شما کلمه عبور خود را به یاد آورده‌اید و دیگر نیازی به تغییر آن ندارید، کلمه عبور قبلی/موجود شما همچنان فعال می‌باشد و می توانید از طریق <a href="'.((strpos($_SERVER['SERVER_PROTOCOL'], 'https'))?'https://':'http://').$_SERVER['HTTP_HOST'].'/">این صفحه</a> وارد حساب کاربری خود شوید.</div>';
                        $result = (new Mailer())->mail($model->email, 'درخواست تغییر کلمه عبور در '.Yii::app()->name, $message, Yii::app()->params['no-reply-email']);
                        if($result)
                            echo CJSON::encode(array(
                                'hasError'=>false,
                                'message'=>'لینک تغییر کلمه عبور به '.$model->email.' ارسال شد.'
                            ));
                        else
                            echo CJSON::encode(array(
                                'hasError'=>true,
                                'message'=>'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.'
                            ));
                    }
                    else
                        echo CJSON::encode(array(
                            'hasError'=>true,
                            'message'=>'بیش از 3 بار نمی توانید درخواست تغییر کلمه عبور بدهید.'
                        ));
                }
                elseif($model->status=='pending')
                    echo CJSON::encode(array(
                        'hasError'=>true,
                        'message'=>'این حساب کاربری هنوز فعال نشده است.'
                    ));
                elseif($model->status=='blocked')
                    echo CJSON::encode(array(
                        'hasError'=>true,
                        'message'=>'این حساب کاربری مسدود می باشد.'
                    ));
                elseif($model->status=='deleted')
                    echo CJSON::encode(array(
                        'hasError'=>true,
                        'message'=>'این حساب کاربری حذف شده است.'
                    ));
            }
            else
                echo CJSON::encode(array(
                    'hasError'=>true,
                    'message'=>'پست الکترونیکی وارد شده اشتباه است.'
                ));
            Yii::app()->end();
        }

        $this->render('forget_password');
    }

    /**
     * Change password
     */
    public function actionChangePassword()
    {
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        if(!Yii::app()->user->isGuest and Yii::app()->user->type != 'admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if(!Yii::app()->user->isGuest and Yii::app()->user->type == 'admin')
            Yii::app()->user->logout(false);

        $token = Yii::app()->request->getQuery('token');
        $model = Users::model()->find('verification_token=:token', array(':token' => $token));
        if($model){
            $model->password = null;
            if(!$model)
                $this->redirect($this->createAbsoluteUrl('//'));
            elseif($model->change_password_request_count == 0)
                $this->redirect($this->createAbsoluteUrl('//'));

            $model->setScenario('change_password');
            $this->performAjaxValidation($model);

            if($model->status == 'active'){

                if(isset($_POST['Users'])){
                    $model->password = $_POST['Users']['password'];
                    $model->repeatPassword = $_POST['Users']['repeatPassword'];
                    $model->verification_token = null;
                    $model->change_password_request_count = 0;
                    if($model->save()){
                        Yii::app()->user->setFlash('success', 'کلمه عبور با موفقیت تغییر یافت.');
                        $this->refresh();
                    }else
                        Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                }

                $this->render('change_password', array(
                    'model' => $model
                ));
            }else
                $this->redirect($this->createAbsoluteUrl('//'));
        }else
            Yii::app()->user->setFlash('failed', 'لینک بازیابی کلمه عبور منقضی شده است. لطفا مجددا تلاش فرمایید.');
        $this->render('change_password', array(
            'model' => $model
        ));
    }
}