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
			'captcha' => array(
				'class' => 'CCaptchaAction' ,
				'backColor' => 0xFFFFFF ,
			) ,
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&views=FileName
			'page' => array(
				'class' => 'CViewAction' ,
			) ,
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
		Yii::import('news.models.*');
		Yii::import('personnel.models.*');
		Yii::import('users.models.*');
		Yii::import('pages.models.*');
		Yii::import('setting.models.*');
		if(SiteSetting::model()->findByAttributes(array('name' => 'message_state'))->value == 1)
			if(Yii::app()->language == 'fa')
				$this->message = CHtml::encode(SiteSetting::model()->findByAttributes(array('name' => 'message'))->value);
			else
				$this->message = CHtml::encode(SiteSetting::model()->findByAttributes(array('name' => 'message_en'))->value);

		$criteria = new CDbCriteria();
		$criteria->addCondition('deleted = 0');
		$criteria->order = 't.order';
		$courses = Courses::model()->findAll($criteria);
        // teachers
		$personnel = Personnel::model()->findAll();
		$teachers = Users::model()->findAll(array(
			'condition' => 'role_id = 2',
			'with' => array('teacherDetails'),
			'order' => 'teacherDetails.name'
		));

		$aboutText = Pages::model()->findByPk(12);
		$termsText = Pages::model()->findByPk(5);

		$classes = array();
		foreach(Courses::model()->findAll() as $course){
			$criteria = Classes::getValidClasses($course->id);
			$criteria->order = 'startSignupDate DESC,t.order';
			$objects = Classes::model()->findAll($criteria);
			if($objects){
				$classes[$course->id]['title'] = $course->title;
				$classes[$course->id]['objects'] = Classes::model()->findAll($criteria);
			}
		}
		$criteria = News::getValidNews();
		$criteria->limit = 4;
		$newsProvider = new CActiveDataProvider("News",array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 4)
		));
		$this->render('index' ,array(
			'courses' => $courses ,
			'newsProvider' => $newsProvider,
			'classes' => $classes ,
			'personnel' => $personnel ,
			'teachers' => $teachers ,
			'aboutText' => $aboutText ,
			'termsText' => $termsText ,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		if($error = Yii::app()->errorHandler->error){
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error' ,$error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if(isset($_POST['ContactForm'])){
			$model->attributes = $_POST['ContactForm'];
			if($model->validate()){
				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$msg = '<div style="display: block;width: 100%;"><h2 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;width: 100%;font-family:tahoma;background-color: #0b3762;line-height:60px;color:#f7f7f7;font-size: 24px;text-align: right;padding-right: 50px">آوای شهیر<span style="font-size: 14px;color:#dfdfdf">- بخش تماس با ما</span></span> </h2></div>';
				$msg .= '<div style="display: inline-block;width: 100%;font-family:tahoma;">';
				$msg .= '<div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;margin:10px 20px;padding:15px;">';
				$msg .= '<div style="color: #2d2d2d;font-size: 20px;text-align: right;"></div>';
				$msg .= '<div style="color: #444;font-size: 13px;text-align: right;">';
				$msg .= '<p>' . $model->body . '</p>';
				$msg .= '<hr>';
				$msg .= '<p>نام فرستنده : ' . $model->name . '</p>';
				$msg .= '<p>پست الکترونیک فرستنده : ' . $model->email . '</p>';
				$msg .= '</div>';
				$msg .= '</div>';
				$msg .= '</div>';
				$mail->ContentType = 'html';
				$mail->Subject = 'پیام از بخش تماس با ما وبسایت ' . Yii::app()->name;
				$mail->IsSMTP();
				$mail->Host = 'mail.avayeshahir.com';
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Username = 'noreply@avayeshahir.com';
				$mail->Password = '!@avayeshahir1395';
				$mail->Port = 465;
				$mail->isHTML(true);
				$mail->SetFrom('noreply@avayeshahir.com', Yii::app()->name);
				$mail->AltBody = '';
				$mail->Body = $msg;
				Yii::import('admins.models.Admins');
				$admins = Admins::model()->findAll();
				foreach($admins as $admin){
					$mail->AddCC($admin->email ,$admin->username);
				}
				$mail->AddCC(Yii::app()->params['adminEmail']);
				$mail->AddAddress('yusef.mobasheri@gmail.com');
				if($mail->send()){
					Yii::app()->user->setFlash('footer-success' ,'پیام شما با موفقیت ارسال شد.');
					if(isset($_POST['ajax'])){
						echo CJSON::encode(array('state' => 'ok'));
						Yii::app()->end();
					}else{
						if(Yii::app()->user->returnUrl != Yii::app()->request->baseUrl . '/')
							$this->redirect(Yii::app()->user->returnUrl);
						else
							$this->refresh();
					}
				}else{
					Yii::app()->user->setFlash('footer-failed' ,'متاسفانه ارسال پیام با مشکل مواجه است. لطفا مجددا تلاش کنید.');
					if(isset($_POST['ajax'])){
						echo CJSON::encode(array('state' => 'error'));
						Yii::app()->end();
					}else
						$this->refresh();
				}
			}
		}
	}

	public function actionAbout()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		$model = Pages::model()->findByPk(2);
		$this->render('//site/pages/page' ,array('model' => $model));
	}

	public function actionContactUs()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		$model = Pages::model()->findByPk(3);
		$this->render('//site/pages/page' ,array('model' => $model));
	}


	public function actionTerms()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = Pages::model()->findByPk(5);
		$this->render('//site/pages/page' ,array('model' => $model));
	}


	public function actionGuidance()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		$dataProvider = new CActiveDataProvider("Pages" ,array(
			'criteria' => array(
				'condition' => 'category_id = 2'
			) ,
			'pagination' => array(
				'pageSize' => 10
			)
		));
		$dataProvider2 = new CActiveDataProvider("Pages" ,array(
			'criteria' => array(
				'condition' => 'category_id = 3'
			) ,
			'pagination' => array(
				'pageSize' => 10
			)
		));
		$this->sideRender = array(
			'//layouts/_support'
		);
		$this->render('//site/pages/guidance' ,array('dataProvider' => $dataProvider ,'dataProvider2' => $dataProvider2));
	}

	public function actionSearch()
	{
		$this->layout = '//layouts/inner';
		Yii::app()->theme = 'front-end';
		$model = new SearchForm();
        $title = '';
        $dataProvider = false;
        $dataProviders = false;
        $fileDataProvider = false;
        $linksDataProvider = false;
        $extLinksDataProvider = false;
		if(isset($_GET['SearchForm'])){
            $model->attributes = $_GET['SearchForm'];
            $pageSize = 10;
            $words = explode(' ', $model->text);
            switch($model->type){
                case 'courses':
                    Yii::app()->getModule('courses');
                    $criteria = Courses::getSearchCriteria($model->text, $words);
                    $dataProvider = new CActiveDataProvider('Courses', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));
                    // files search
					$criteria = ClassCategoryFiles::getSearchCriteria($model->text, $words);
					$fileDataProvider = new CActiveDataProvider('ClassCategoryFiles', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));
                    // links search
                    $criteria = ClassCategoryFileLinks::getSearchCriteria($model->text, $words);
					$linksDataProvider = new CActiveDataProvider('ClassCategoryFileLinks', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));
                    $title = Yii::t('app', 'Courses');
                    break;
                case 'articles':
                    Yii::app()->getModule('articles');
                    $criteria = Articles::getSearchCriteria($model->text, $words);
                    $dataProvider = new CActiveDataProvider('Articles', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));

                    // files search
                    $criteria = ArticleFiles::getSearchCriteria($model->text, $words);
                    $fileDataProvider = new CActiveDataProvider('ArticleFiles', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));

                    // links search
                    $criteria = ArticleFileLinks::getSearchCriteria($model->text, $words);
                    $linksDataProvider = new CActiveDataProvider('ArticleFileLinks', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));

                    // ext links search
                    $criteria = ArticleLinks::getSearchCriteria($model->text, $words);
                    $extLinksDataProvider = new CActiveDataProvider('ArticleLinks', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));

                    $title = Yii::t('app', 'Educational Materials');
                    break;
                case 'news':
                    Yii::app()->getModule('news');
                    $criteria = News::getSearchCriteria($model->text, $words);
                    $dataProvider = new CActiveDataProvider('News', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));
                    $title = Yii::t('app', 'News');
                    break;
                case 'all':
                default:
                    Yii::app()->getModule('courses');
                    Yii::app()->getModule('articles');
                    Yii::app()->getModule('news');
                    $dataProvider = [];
                    // courses search
                    $criteria = Courses::getSearchCriteria($model->text, $words);
                    $dataProviders['courses']['dataProvider'] = new CActiveDataProvider('Courses', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));
                    $dataProviders['courses']['title'] = Yii::t('app', 'Courses');

                    // article search
                    $criteria = Articles::getSearchCriteria($model->text, $words);
                    $dataProviders['articles']['dataProvider'] = new CActiveDataProvider('Articles', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));
                    $dataProviders['articles']['title'] = Yii::t('app', 'Educational Materials');

                    // news search
                    $criteria = News::getSearchCriteria($model->text, $words);
                    $dataProviders['news']['dataProvider'] = new CActiveDataProvider('News', array(
                        'criteria' => $criteria,
                        'pagination' => array('pageSize' => $pageSize)
                    ));
                    $dataProviders['news']['title'] = Yii::t('app', 'News');
                    $title = 'تمام مطالب سایت';
                    break;
            }

        }
		$this->render('search',array(
			'model' => $model,
			'title' => $title,
			'dataProvider' => $dataProvider,
			'fileDataProvider' => $fileDataProvider,
			'linksDataProvider' => $linksDataProvider,
			'extLinksDataProvider' => $extLinksDataProvider,
			'dataProviders' => $dataProviders
		));
	}

	public function actionForum(){
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = Pages::model()->findByPk(2);
		$this->render('//site/pages/page' ,array('model' => $model,'comment'=>true));
	}

	public function actionFAQ(){
		Yii::app()->getModule('faq');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$FAQCategories = FaqCategories::model()->findAll(array('condition'=>'faqs.id IS NOT NULL','order'=>'t.order','with'=>array('faqs')));
		$this->render('FAQ' ,array('FAQCategories' => $FAQCategories));
	}
}