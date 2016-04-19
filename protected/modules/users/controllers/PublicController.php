<?php

class PublicController extends Controller
{
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
                'actions'=>array('dashboard','logout','setting'),
                'users' => array('@'),
            ),
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('login' ,'register','captcha'),
                'users' => array('*'),
                //'roles'=>array('admin','validator'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
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
            $this->redirect(array('/site/'));

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
            if($model->save()) {
                $msg = '<h2 style="box-sizing:border-box;display: block;width: 100%;font-family:tahoma;background-color: #a1cf01;line-height:60px;color:#f7f7f7;font-size: 24px;text-align: right;padding-right: 50px">آوای شهیر<span style="font-size: 14px;color:#dfdfdf">- موسسه زبان</span></span> </h2>';
                $msg .= '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
                $msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
                $msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;">ثبت نام با موفقیت انجام شد.</div>';
                $msg .= '<div style="color: #444;font-size: 13px;text-align: right;">';
                $msg .= '<p>نام کاربری (پست الکترونیک) : '.$model->email.'</p>';
                $msg .= '<p>رمز عبور : '.$_POST['Users']['password'].'</p>';
                $msg .= '</div>';
                $msg .= '</div>';
                $msg .= '</div>';
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail = new JPhpMailer;
                //$mail->IsSMTP();
                //$mail->Host = 'smpt.163.com';
                //$mail->SMTPAuth = true;
                //$mail->Username = 'yourname@163.com';
                //$mail->Password = 'yourpassword';
                $mail->SetFrom(Yii::app()->params['no-reply-email'], Yii::app()->name);
                $mail->Subject = 'ثبت نام در '.Yii::app()->name;
                $mail->MsgHTML($msg);
                $mail->AddAddress($model->email);
                $mail->Send();
                $msg = 'ثبت نام با موفقیت انجام شد.';

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
                Yii::app()->user->setFlash('failed' ,'متاسفانه ثبت نام با مشکل مواجه است\r\n لطفا مجددا تلاش کنید.');
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
        $this->layout = '//layouts/public';
        $model=Users::model()->findByPk(Yii::app()->user->getId());
        $this->render('dashboard', array(
            'model'=>$model,
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

        $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $model->password=$_POST['Users']['newPassword'];
                if($model->save())
                {
                    Yii::app()->user->setFlash('success' , 'اطلاعات با موفقیت ثبت شد.');
                    $this->redirect($this->createUrl('/dashboard'));
                }
                else
                    Yii::app()->user->setFlash('fail' , 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $this->render('setting', array(
            'model'=>$model,
        ));
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
}