<?php

class SiteController extends Controller
{
    public $layout = '//layouts/public';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
					'class'=>'CCaptchaAction',
					'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&views=FileName
			'page'=>array(
					'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'front-end';
        Yii::import('courses.models.*');
        Yii::import('personnel.models.*');
        Yii::import('users.models.*');
        Yii::import('pages.models.*');

        $courses = Courses::model()->findAll();
        $personnel = Personnel::model()->findAll();
        $teachers = Users::model()->findAll('role_id = 2');
        $aboutText = Pages::model()->findByPk(12);
        $this->render('index', array(
            'courses' => $courses,
            'personnel' => $personnel,
            'teachers' => $teachers,
            'aboutText' => $aboutText
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if(isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if($model->validate()) {
				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$mail->SetFrom(Yii::app()->params['no-reply-email'], Yii::app()->name);
				$mail->Subject = 'پیام از وبسایت '.Yii::app()->name;
				$msg = '<h2 style="box-sizing:border-box;display: block;width: 100%;font-family:tahoma;background-color: #a1cf01;line-height:60px;color:#f7f7f7;font-size: 24px;text-align: right;padding-right: 50px">آوای شهیر<span style="font-size: 14px;color:#dfdfdf">- موسسه زبان</span></span> </h2>';
                $msg .= '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
                $msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
                $msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;"></div>';
                $msg .= '<div style="color: #444;font-size: 13px;text-align: right;">';
                $msg .= '<p>'.$model->body.'</p>';
				$msg .= '<hr>';
				$msg .= '<p>نام فرستنده : '.$model->name.'</p>';
                $msg .= '<p>پست الکترونیک فرستنده : '.$model->email.'</p>';
                $msg .= '</div>';
                $msg .= '</div>';
                $msg .= '</div>';
				$mail->MsgHTML($msg);
				Yii::import('admins.models.Admins');
				$admins= Admins::model()->findAll();
				foreach($admins as $admin)
				{
					$mail->AddCC($admin->email ,$admin->username);
				}
				if(1) { //$mail->send()
					Yii::app()->user->setFlash('footer-success', 'پیام شما با موفقیت ارسال شد.');
					if(isset($_POST['ajax'])) {
						echo CJSON::encode(array('state' => 'ok'));
						Yii::app()->end();
					} else {
						if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl.'/')
							$this->redirect(Yii::app()->user->returnUrl);
						else
							$this->refresh();
					}
				} else {
					Yii::app()->user->setFlash('footer-failed', 'متاسفانه ثبت نام با مشکل مواجه است\r\n لطفا مجددا تلاش کنید.');
					if(isset($_POST['ajax'])) {
						echo CJSON::encode(array('state' => 'error'));
						Yii::app()->end();
					} else
						$this->refresh();
				}
			}
		}
	}

    public function actionAbout(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(2);
        $this->render('//site/pages/page',array('model' => $model));
    }

    public function actionContactUs(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(3);
        $this->render('//site/pages/page',array('model' => $model));
    }


    public function actionTerms(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(5);
        $this->render('//site/pages/page',array('model' => $model));
    }


   public function actionGuidance(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'front-end';
        $this->layout = '//layouts/public';
        $dataProvider = new CActiveDataProvider("Pages",array(
            'criteria' => array(
                'condition' => 'category_id = 2'
            ),
            'pagination' => array(
                'pageSize' => 10
            )
        ));
       $dataProvider2 = new CActiveDataProvider("Pages",array(
           'criteria' => array(
               'condition' => 'category_id = 3'
           ),
           'pagination' => array(
               'pageSize' => 10
           )
       ));
        $this->sideRender = array(
            '//layouts/_support'
        );
        $this->render('//site/pages/guidance',array('dataProvider' => $dataProvider,'dataProvider2' => $dataProvider2));
    }

}