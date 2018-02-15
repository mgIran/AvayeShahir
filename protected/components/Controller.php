<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @property SearchForm $searchModel
 */
class Controller extends AuthController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $town = null;
    public $place = null;
    public $description;
    public $keywords;

    public $siteName;
    public $pageTitle;

    public $searchModel;
    public $sideRender = null;
    public $message = null;
    public $courses = null;
    public $newsCategories = null;
    public $articleCategories = null;
    public $writingCategories = null;
    public $multimediaCategories = null;
    /**
     * @var Slideshow[]
     */
    public $slides = null;

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

    public function init()
    {
        // for multi language
        EMHelper::catchLanguage();
        Yii::app()->clientScript->registerScript('js-requirement', '
            var baseUrl = "' . Yii::app()->getBaseUrl(true) . '";
        ', CClientScript::POS_HEAD);
        // set default meta tag values
        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();
        $this->searchModel = new SearchForm();
        parent::init();
    }

    public static function createAdminMenu()
    {
        if(Yii::app()->user->type === 'admin')
            return array(
                array(
                    'label' => 'پیشخوان',
                    'url' => array('/moderators/dashboard')
                ),
                array(
                    'label' => 'اسلایدشو<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/slideshow/manage/admin')),
                        array('label' => 'افزودن', 'url' => Yii::app()->createUrl('/slideshow/manage/create')),
                    )
                ),
                array(
                    'label' => 'آموزش<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => ' دوره ها و منابع', 'url' => Yii::app()->createUrl('/courses/manage/admin/')),
                        array('label' => ' گروه ها', 'url' => Yii::app()->createUrl('/courses/categories/admin/')),
                        array('label' => ' کلاس ها', 'url' => Yii::app()->createUrl('/courses/classes/admin/')),
                        array('label' => 'ثبت نام حضوری در کلاس', 'url' => Yii::app()->createUrl('/courses/classes/classRegister/')),
                        array('label' => 'نمونه های رایتینگ', 'url' => Yii::app()->createUrl('/writings/manage/admin/')),
                        array('label' => 'کلمات کلیدی', 'url' => Yii::app()->createUrl('/courses/tags/admin/'))
                    )
                ),
                array(
                    'label' => 'مطالب آموزشی<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت مطالب', 'url' => Yii::app()->createUrl('/articles/manage/admin/')),
                        array('label' => 'افزودن مطلب', 'url' => Yii::app()->createUrl('/articles/manage/create/')),
                        array('label' => 'دسته بندی ها', 'url' => Yii::app()->createUrl('/articles/category/admin/')),
                    )
                ),
                array(
                    'label' => 'اخبار<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/news/manage/admin/')),
                        array('label' => ' افزودن خبر', 'url' => Yii::app()->createUrl('/news/manage/create/')),
                        array('label' => 'مدیریت دسته بندی ها', 'url' => Yii::app()->createUrl('/news/category/admin/')),
                        array('label' => 'کلمات کلیدی', 'url' => Yii::app()->createUrl('/courses/tags/admin/'))
                    )
                ),
                array(
                    'label' => 'ترجمه و تصحیح<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت سفارشات', 'url' => Yii::app()->createUrl('/orders/manage/admin/')),
                        array('label' => 'سفارش جدید', 'url' => Yii::app()->createUrl('/orders/manage/create/')),
                        array('label' => 'مدیریت دسته بندی ها', 'url' => Yii::app()->createUrl('/orders/categories/admin/')),
                        array('label' => 'زباله دان', 'url' => Yii::app()->createUrl('/orders/manage/trash')),
                        array('label' => 'تنظیمات سفارشات', 'url' => Yii::app()->createUrl('/orders/manage/setting')),
                    )
                ),
                array(
                    'label' => 'چند رسانه ای <span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت دسته بندی ها', 'url' => Yii::app()->createUrl('/multimedia/category/admin/')),
                        array('label' => 'افزودن ویدئو', 'url' => Yii::app()->createUrl('/multimedia/videos/create')),
                        array('label' => 'مدیریت ویدئو ها', 'url' => Yii::app()->createUrl('/multimedia/videos/admin')),
//                        array('label' => 'افزودن تصویر', 'url' => Yii::app()->createUrl('/multimedia/pictures/create')),
//                        array('label' => 'مدیریت تصاویر', 'url' => Yii::app()->createUrl('/multimedia/pictures/admin')),
                    )
                ),
                array(
                    'label' => 'FAQ<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت سوالات', 'url' => Yii::app()->createUrl('/faq/manage/admin')),
                        array('label' => 'افزودن سوال', 'url' => Yii::app()->createUrl('/faq/manage/create')),
                        array('label' => 'دسته بندی ها', 'url' => Yii::app()->createUrl('/faq/categories/admin')),
                    )
                ),
                array(
                    'label' => 'مدیران <span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'نقش مدیران', 'url' => Yii::app()->createUrl('/moderators/roles/admin')),
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/moderators/manage')),
                        array('label' => 'افزودن', 'url' => Yii::app()->createUrl('/moderators/manage/create')),
                    )
                ),
                array(
                    'label' => 'کاربران <span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'مدیریت', 'url' => Yii::app()->createUrl('/users/manage')),
                    )
                ),
                array(
                    'label' => 'تنظیمات<span class="caret"></span>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'عمومی', 'url' => Yii::app()->createUrl('/setting/manage/changeSetting')),
                        array('label' => 'پیام وبسایت', 'url' => Yii::app()->createUrl('/setting/manage/siteMessage')),
                        array('label' => 'گوگل ارث', 'url' => Yii::app()->createUrl('/map/manage/update')),
                        array('label' => 'صفحات اصلی سایت', 'url' => Yii::app()->createUrl('/pages/manage/admin/slug/base')),
                        array('label' => 'قوانین', 'url' => Yii::app()->createUrl('/pages/manage/update/id/5/slug/rules')),
                        array('label' => 'صفحات راهنما', 'url' => Yii::app()->createUrl('/pages/manage/admin/slug/guide')),
                        array('label' => 'مدیریت اساتید', 'url' => Yii::app()->createUrl('/users/teachers')),
                        array('label' => 'مدیریت کارمندان', 'url' => Yii::app()->createUrl('/personnel/manage')),
                        array('label' => 'مدیریت گالری تصاویر', 'url' => Yii::app()->createUrl('/gallery/manage/admin')),
                        array('label' => 'تغییر کلمه عبور', 'url' => Yii::app()->createUrl('/moderators/manage/changePass')),
                    )
                ),
                array(
                    'label' => 'ورود',
                    'url' => array('/moderators/login'),
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label' => 'خروج',
                    'url' => array('/moderators/login/logout'),
                    'visible' => !Yii::app()->user->isGuest),
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach($model->getErrors() as $err){
            $errors .= implode('<br>', $err) . '<br>';
        }
        return $errors;
    }

    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0;$i < $length;$i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($english_array, $farsi_array, $matches);
    }

    public static function fileSize($file)
    {
        $size = filesize($file);
        if($size < 1024)
            return $size . ' Byte';
        elseif($size < 1024 * 1024){
            $size = (float)$size / 1024;
            return number_format($size, 1) . ' KB';
        }elseif($size < 1024 * 1024 * 1024){
            $size = (float)$size / (1024 * 1024);
            return number_format($size, 1) . ' MB';
        }else{
            $size = (float)$size / (1024 * 1024 * 1024);
            return number_format($size, 1) . ' GB';
        }
    }

    public function getCoursesList()
    {
        Yii::import('courses.models.*');
        if(!$this->courses)
            $this->courses = CHtml::listData(Courses::model()->findAll(array(
                'order' => 't.order')),
                function ($model){
                    return 'courses/' . $model->id . '/' . urlencode($model->getValueLang('title', 'en'));
                }
                , 'title');
        return $this->courses;
    }

    public function getArticleCategories()
    {
        Yii::import('articles.models.*');
        if(!$this->articleCategories)
            $this->articleCategories = CHtml::listData(ArticleCategories::model()->findAll(array(
                'condition' => 'parent_id IS NULL',
                'order' => 't.order'
            )),
                function ($model){
                    return 'articles/category/' . $model->id . '/' . urlencode($model->getValueLang('title', 'en'));
                }
                , 'title');
        return $this->articleCategories;
    }

    public function getWritingCategories($array = true)
    {
        Yii::import('writings.models.*');
        if($array) {
            $models = WritingCategories::model()->findAll(array(
                'condition' => 'parent_id IS NOT NULL',
                'order' => 't.order'
            ));
            $this->writingCategories = CHtml::listData($models,
                function ($model) {
                    return 'writings/category/' . $model->id . '/' . urlencode($model->getValueLang('title', 'en'));
                }
                , 'title');
        }else{
            $this->writingCategories = new CActiveDataProvider("WritingCategories", array(
                'criteria' => array(
                    'condition' => 'parent_id IS NOT NULL',
                    'order' => 't.order'
                )
            ));
        }
        return $this->writingCategories;
    }

    public function getMultimediaCategories()
    {
        Yii::import('multimedia.models.*');
        if(!$this->multimediaCategories){
            $models = MultimediaCategories::model()->findAll(array(
                'condition' => 'parent_id IS NULL',
                'order' => 't.order'
            ));
            $this->multimediaCategories = CHtml::listData($models,
                function ($model){
                    return 'multimedia/category/' . $model->id . '/' . urlencode($model->getValueLang('title', 'en'));
                }
                , 'title');
        }
        return $this->multimediaCategories;
    }

    public function getNewsCategories()
    {
        Yii::import('news.models.*');
        if(!$this->newsCategories)
            $this->newsCategories = CHtml::listData(NewsCategories::model()->findAll(array(
                'condition' => 'parent_id IS NULL',
                'order' => 't.order'
            )),
                function ($model){
                    return 'news/category/' . $model->id . '/' . urlencode($model->getValueLang('title', 'en'));
                }
                , 'title');
        return $this->newsCategories;
    }

    public function actionBackup()
    {
        $dbPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'db_backup';
        if(!is_dir($dbPath))
            mkdir($dbPath);

        Yii::import('ext.yii-database-dumper.SDatabaseDumper');
        $dumper = new SDatabaseDumper;
        // Get path to backup file

        // Gzip dump
        $file = $dbPath . DIRECTORY_SEPARATOR . 'sql-dump-' . date('Y-m-d');
        if(isset($_GET['gz']) && function_exists('gzencode'))
            file_put_contents($file . '.sql.gz', gzencode($dumper->getDump()));
        else
            file_put_contents($file . '.sql', $dumper->getDump());

        if(file_exists($file . '.sql') || file_exists($file . '.sql.gz'))
            echo 'OK';
        else
            echo 'NOK';

        $files = scandir($dbPath);
        unset($files[0]);
        unset($files[1]);
        $expireTime = time() - 7 * 24 * 60 * 60;
        $index = 0;
        foreach($files as $key => $file){
            if(strpos($file, 'sql-dump-' . date('Y-m-d', $expireTime)) !== false){
                $index = $key;
                break;
            }
        }
        for($i = 2;$i <= $index;$i++)
            @unlink($dbPath . DIRECTORY_SEPARATOR . $files[$i]);
    }
}