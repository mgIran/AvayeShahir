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
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&views=FileName
			'page' => array(
				'class' => 'CViewAction',
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
		Yii::import('news.models.*');
		Yii::import('personnel.models.*');
		Yii::import('users.models.*');
		Yii::import('pages.models.*');
		Yii::import('setting.models.*');
		Yii::import('slideshow.models.*');
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
			'order' => 't.order'
		));

		$aboutText = Pages::model()->findByPk(12);
		$termsText = Pages::model()->findByPk(5);

		$classes = array();
		foreach(Courses::model()->findAll() as $course){
			$criteria = Classes::getValidClasses($course->id);
			$criteria->order = 't.order';
			$objects = Classes::model()->findAll($criteria);
			if($objects){
				$classes[$course->id]['title'] = $course->title;
				$classes[$course->id]['objects'] = Classes::model()->findAll($criteria);
			}
		}
		$criteria = News::getValidNews();
		$criteria->limit = 4;
		$newsProvider = new CActiveDataProvider("News", array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 6)
		));


		$this->slides = Slideshow::model()->getActiveSlides();
		$this->render('index', array(
			'courses' => $courses,
			'newsProvider' => $newsProvider,
			'classes' => $classes,
			'personnel' => $personnel,
			'teachers' => $teachers,
			'aboutText' => $aboutText,
			'termsText' => $termsText,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/error';
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
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
					$mail->AddCC($admin->email, $admin->username);
				}
				$mail->AddCC(Yii::app()->params['adminEmail']);
				$mail->AddAddress('yusef.mobasheri@gmail.com');
				if($mail->send()){
					Yii::app()->user->setFlash('footer-success', 'پیام شما با موفقیت ارسال شد.');
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
					Yii::app()->user->setFlash('footer-failed', 'متاسفانه ارسال پیام با مشکل مواجه است. لطفا مجددا تلاش کنید.');
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
		$this->render('//site/pages/page', array('model' => $model));
	}

	public function actionContactUs()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		$model = Pages::model()->findByPk(3);
		$this->render('//site/pages/page', array('model' => $model));
	}


	public function actionTerms()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = Pages::model()->findByPk(5);
		$this->render('//site/pages/page', array('model' => $model));
	}


	public function actionGuidance()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/public';
		$dataProvider = new CActiveDataProvider("Pages", array(
			'criteria' => array(
				'condition' => 'category_id = 2'
			),
			'pagination' => array(
				'pageSize' => 10
			)
		));
		$dataProvider2 = new CActiveDataProvider("Pages", array(
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
		$this->render('//site/pages/guidance', array('dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2));
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
					$title = Yii::t('app', 'Courses & Resources');
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
					$dataProviders = [];
					// courses search
					$criteria = Courses::getSearchCriteria($model->text, $words);
					$dataProviders['courses']['dataProvider']['courses'] = new CArrayDataProvider(Courses::model()->findAll($criteria), array(
						'pagination' => array('pageSize' => $pageSize)
					));
					// files search
					$criteria = ClassCategoryFiles::getSearchCriteria($model->text, $words);
					$dataProviders['courses']['dataProvider']['files'] = new CActiveDataProvider('ClassCategoryFiles', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));
					// links search
					$criteria = ClassCategoryFileLinks::getSearchCriteria($model->text, $words);
					$dataProviders['courses']['dataProvider']['links'] = new CActiveDataProvider('ClassCategoryFileLinks', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));


					$dataProviders['courses']['title'] = Yii::t('app', 'Courses & Resources');

					// article search
					$criteria = Articles::getSearchCriteria($model->text, $words);
					$dataProviders['articles']['dataProvider']['articles'] = new CActiveDataProvider('Articles', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));

					// files search
					$criteria = ArticleFiles::getSearchCriteria($model->text, $words);
					$dataProviders['articles']['dataProvider']['files'] = new CActiveDataProvider('ArticleFiles', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));

					// links search
					$criteria = ArticleFileLinks::getSearchCriteria($model->text, $words);
					$dataProviders['articles']['dataProvider']['links'] = new CActiveDataProvider('ArticleFileLinks', array(
						'criteria' => $criteria,
						'pagination' => array('pageSize' => $pageSize)
					));

					// ext links search
					$criteria = ArticleLinks::getSearchCriteria($model->text, $words);
					$dataProviders['articles']['dataProvider']['extLinks'] = new CActiveDataProvider('ArticleLinks', array(
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
					$title = Yii::t('app', 'All Site Content');
					break;
			}

		}
		$this->render('search', array(
			'model' => $model,
			'title' => $title,
			'dataProvider' => $dataProvider,
			'fileDataProvider' => $fileDataProvider,
			'linksDataProvider' => $linksDataProvider,
			'extLinksDataProvider' => $extLinksDataProvider,
			'dataProviders' => $dataProviders
		));
	}

	public function actionForum()
	{
		Yii::import('pages.models.*');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$model = Pages::model()->findByPk(2);
		$this->render('//site/pages/page', array('model' => $model, 'comment' => true));
	}

	public function actionFAQ()
	{
		Yii::app()->getModule('faq');
		Yii::app()->theme = 'front-end';
		$this->layout = '//layouts/inner';
		$FAQCategories = FaqCategories::model()->findAll(array('condition' => 'faqs.id IS NOT NULL', 'order' => 't.order', 'with' => array('faqs')));
		$this->render('FAQ', array('FAQCategories' => $FAQCategories));
	}

	public function actionDrive()
	{
		$temp = Yii::getPathOfAlias('webroot') . '/uploads/DRIVE/';
		if(!is_dir($temp))
			mkdir($temp);
		Yii::import('courses.models.*');
		$class_categories = ClassCategoryFileLinks::model()->findAll();
		foreach($class_categories as $class_category){
			$parts = parse_url($class_category->link);
			parse_str($parts['query'], $query);
			if($query){
				try{
					Yii::app()->db->createCommand()->insert('__move_drive__', array(
						'model' => get_class($class_category),
						'model_id' => $class_category->id,
						'status' => 0,
						'link' => $class_category->link,
						'file_id' => $query['id'],
						'file_size' => $class_category->link_size,
					));
				}catch(Exception $e){
				}
			}
		}

		Yii::import('articles.models.*');
		$articles = ArticleFileLinks::model()->findAll();
		foreach($articles as $article){
			$parts = parse_url($article->link);
			parse_str($parts['query'], $query);
			if($query){
				try{
					Yii::app()->db->createCommand()->insert('__move_drive__', array(
						'model' => get_class($article),
						'model_id' => $article->id,
						'status' => 0,
						'link' => $article->link,
						'file_id' => $query['id'],
						'file_size' => $article->link_size,
					));
				}catch(Exception $e){
				}
			}
		}
	}

	// Move Files From Google Drive to Our Server
	public function actionGooglereturn()
	{
		if(isset($_GET['reset']) && $_GET['reset'] == true)
			unset(Yii::app()->session['auth_token']);
		/* @var $jgoogleapi JGoogleAPI */
		Yii::app()->getModule('setting');
		$jgoogleapi = Yii::app()->JGoogleAPI;
		try{
			$client = $jgoogleapi->getClient();
			if(!isset(Yii::app()->session['auth_token'])){
				$client->authenticate();
				$model = SiteSetting::model()->findByAttributes(array('name' => 'google_auth_token'));
				if($model === null){
					$model = new SiteSetting();
					$model->name = 'google_auth_token';
					$model->title = 'توکن';
				}
				if($client->getAccessToken()){
					$model->value = $client->getAccessToken();
					Yii::app()->session['auth_token'] = $client->getAccessToken();
					$model->save(false);
					$this->refresh();
				}
			}
			echo Yii::app()->session['auth_token'];
			exit;
		}catch(Exception $exc){
			//Becarefull because the Exception you catch may not be from invalid token
			Yii::app()->session['auth_token'] = null;
			throw $exc;
		}
	}

	public function actionDownloadFromGoogle()
	{
		$this->checkToken();
		/* @var $jgoogleapi JGoogleAPI */
		/* @var $jgoogleapi2 JGoogleAPI */
		/* @var $drive Google_DriveService */
		/* @var $drive2 Google_DriveService */
		try{
			$start = time();
			Yii::app()->getModule('courses');
			Yii::app()->getModule('articles');
			// for get file content
			$jgoogleapi = Yii::app()->JGoogleAPI;
			$client = $jgoogleapi->getClient();
			$client->setAccessToken(Yii::app()->session['auth_token']);
			// for get file detail
			$jgoogleapi2 = Yii::app()->JGoogleAPI;
			$client2 = $jgoogleapi2->getClient();
			$client2->setAccessToken(Yii::app()->session['auth_token']);

			//List files from Google Drive
			$drive = $jgoogleapi->getService('Drive');
			$drive2 = $jgoogleapi2->getService('Drive');

			$move = MoveDrive::model()->find('status = 3');
			$model = call_user_func(array($move->model, 'model'));
			$model = $model->findByPk($move->model_id);
			$response = $drive2->files->get($move->file_id);
			$fileContent = $drive->files->get($move->file_id, array(
				'alt' => 'media'));
			$path = Yii::getPathOfAlias('webroot') . '/' . $response->getOriginalFilename();
			$copy = @file_put_contents($path, $fileContent, FILE_APPEND);
			$flag = false;
			$r = false;
			if($copy){
				if($move->model == 'ClassCategoryFileLinks'){
					$new = new ClassCategoryFiles();
					$new->attributes = $model->attributes;
					$new->id = null;
					$new->path = $response->getOriginalFilename();
					if($new->save()){
						$flag = true;
						$dir = Yii::getPathOfAlias('webroot') . '/uploads/classCategoryFilesTemp/';
						if(!is_dir($dir))
							mkdir($dir);
					}
				}else if($move->model == 'ArticleFileLinks'){
					$new = new ArticleFiles();
					$new->attributes = $model->attributes;
					$new->id = null;
					$new->path = $response->getOriginalFilename();
					if($new->save()){
						$flag = true;
						$dir = Yii::getPathOfAlias('webroot') . '/uploads/articles/temp/';
						if(!is_dir($dir))
							mkdir($dir);
					}
				}
				if($flag){
					$move->status = 1;
					$move->detail = $new->id;
					$move->save();
					$r = @rename($path, $dir . $new->path);
				}
			}
			$end = time();
			$o = "Copy: " . $copy;
			$o .= "\n\rMove To Destination: " . $r;
			$o .= "\n\rSave File: " . $flag;
			$o .= "\n\rMove ID: " . $move->id;
			$o .= "\n\rNew ID: " . $move->detail;
			$o .= "\n\rElapsed Time: " . ($end - $start) . "(s)";
			$o .= "\n\r----------------------------------------------------------------------------------\n\r";
			file_put_contents(Yii::getPathOfAlias('webroot') . '/drive_log.txt', $o, FILE_APPEND);
		}catch(Exception $e){
			$move->status = 2;
			$move->detail = json_encode(['error' => 1, 'message' => $e->getMessage(), 'response' => $response]);
			$move->save();

			$o = "Copy: 0";
			$o .= "\n\rMove To Destination: 0";
			$o .= "\n\rSave File: 0";
			$o .= "\n\rMove ID: " . $move->id;
			$o .= "\n\rNew ID: " . $move->detail;
			$o .= "\n\rError Message: " . $e->getMessage();
			$o .= "\n\r----------------------------------------------------------------------------------\n\r";
			file_put_contents(Yii::getPathOfAlias('webroot') . '/drive_log.txt', $o, FILE_APPEND);
		}
		$this->refresh();
	}

	private function checkToken()
	{
		Yii::app()->getModule('setting');
		if(!isset(Yii::app()->session['auth_token']))
			$this->redirect(array('/site/googlereturn'));

		$token = json_decode(Yii::app()->session['auth_token'], true);
		if(!isset($token['refresh_token'])){
			$model = SiteSetting::model()->findByAttributes(array('name' => 'google_auth_token'));
			if($model === null)
				$this->redirect(array('/site/googlereturn?reset=true'));
			$token = json_decode($model->value, true);
		}
		if($token['created'] + $token['expires_in'] < time()){
			if(!isset($token['refresh_token']))
				$this->redirect(array('/site/googlereturn?reset=true'));
			else{
				/* @var $jgoogleapi JGoogleAPI */
				$jgoogleapi = Yii::app()->JGoogleAPI;
				$client = $jgoogleapi->getClient();
				$client->setAccessToken(json_encode($token));
				$client->refreshToken($token['refresh_token']);
				if($client->getAccessToken()){
					$model = SiteSetting::model()->findByAttributes(array('name' => 'google_auth_token'));
					$model->value = $client->getAccessToken();
					Yii::app()->session['auth_token'] = $client->getAccessToken();
					$model->save(false);
					$this->refresh();
				}else
					$this->redirect(array('/site/googlereturn?reset=true'));
			}
		}
	}

	public function actionSaveOtherLanguages()
	{
		Yii::app()->getModule('courses');
		Yii::app()->getModule('articles');
		$moves = MoveDrive::model()->findAll('status = 1 AND lang = 0');
		$o = "";
		$sum=0;
		foreach($moves as $move){
			$model = call_user_func(array($move->model, 'model'));
			$model = $model->findByPk($move->model_id);
			if($move->detail && $model){
				if($move->model == 'ClassCategoryFileLinks')
					$new = ClassCategoryFiles::model()->findByPk($move->detail);
				else
					$new = ArticleFiles::model()->findByPk($move->detail);
				if($new === null)
					break;

				$title_en = $model->getValueLang('title', 'en');
				$summary_en = $model->getValueLang('summary', 'en');
				$t_f = $new->saveManual('title', $title_en, 'en');
				$s_f = $new->saveManual('summary', $summary_en, 'en');

				$move->lang = $t_f && $s_f?1:0;
				$move->save(false);

				$o .= "Title save: " . $t_f;
				$o .= "\n\rSummary save: " . $s_f;
				$o .= "\n\rTitle: " . $title_en;
				$o .= "\n\rSummary: " . $summary_en;
				$o .= "\n\rMove ID: " . $move->id;
				$o .= "\n\rNew ID: " . $move->detail;
				$o .= "\n\r----------------------------------------------------------------------------------\n\r";
			}
		}
		echo '<pre>';
		echo $sum;
		echo $o;
		echo '</pre>';exit;
	}

	// temporary actions
	public function actionCreateTable(){
//		$tableName = Yii::app()->db->tablePrefix.'slideshow';
		$flag = Yii::app()->db->createCommand("ALTER TABLE `ym_classes`
              MODIFY COLUMN `title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci;")
			->execute();
        var_dump($flag);exit;
	}
}