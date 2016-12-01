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

    public function init(){
        // for multi language
        EMHelper::catchLanguage();
        Yii::app()->clientScript->registerScript('js-requirement','
            var baseUrl = "'.Yii::app()->getBaseUrl(true).'";
        ',CClientScript::POS_HEAD);
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
                    'label' => 'پیشخوان' ,
                    'url' => array('/admins/dashboard')
                ) ,
                array(
                    'label' => 'آموزش<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => ' دوره ها' ,'url' => Yii::app()->createUrl('/courses/manage/admin/')) ,
                        array('label' => ' گروه ها' ,'url' => Yii::app()->createUrl('/courses/categories/admin/')) ,
                        array('label' => ' کلاس ها' ,'url' => Yii::app()->createUrl('/courses/classes/admin/')) ,
                        array('label' => 'ثبت نام حضوری در کلاس','url' => Yii::app()->createUrl('/courses/classes/classRegister/')) ,
                        array('label' => 'کلمات کلیدی' ,'url' => Yii::app()->createUrl('/courses/tags/admin/'))
                    )
                ) ,
                array(
                    'label' => 'مطالب آموزشی<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت مطالب' ,'url' => Yii::app()->createUrl('/articles/manage/admin/')) ,
                        array('label' => 'افزودن مطلب' ,'url' => Yii::app()->createUrl('/articles/manage/create/')) ,
                        array('label' => 'دسته بندی ها' ,'url' => Yii::app()->createUrl('/articles/category/admin/')) ,
                    )
                ) ,
                array(
                    'label' => 'اخبار<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/news/manage/admin/')) ,
                        array('label' => ' افزودن خبر' ,'url' => Yii::app()->createUrl('/news/manage/create/')) ,
                        array('label' => 'مدیریت دسته بندی ها' ,'url' => Yii::app()->createUrl('/news/category/admin/')) ,
                        array('label' => 'کلمات کلیدی' ,'url' => Yii::app()->createUrl('/courses/tags/admin/'))
                    )
                ) ,
                array(
                    'label' => 'اساتید<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/users/teachers')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/users/teachers/create')) ,
                    )
                ) ,

                array(
                    'label' => 'کارمندان <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/personnel/manage')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/personnel/manage/create')) ,
                    )
                ) ,

                array(
                    'label' => 'گالری تصاویر<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/gallery/manage/admin')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/gallery/manage/create')) ,
                    )
                ) ,
                array(
                    'label' => 'FAQ<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت سوالات' ,'url' => Yii::app()->createUrl('/faq/manage/admin')) ,
                        array('label' => 'افزودن سوال' ,'url' => Yii::app()->createUrl('/faq/manage/create')) ,
                        array('label' => 'دسته بندی ها' ,'url' => Yii::app()->createUrl('/faq/categories/admin')) ,
                    )
                ) ,
                array(
                    'label' => 'مدیران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'نقش مدیران' ,'url' => Yii::app()->createUrl('/admins/roles/admin')) ,
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/admins/manage')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/admins/manage/create')) ,
                    )
                ) ,
                array(
                    'label' => 'کاربران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/users/manage')) ,
                    )
                ) ,

                array(
                    'label' => 'صفحات متنی<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'صفحات اصلی سایت' ,'url' => Yii::app()->createUrl('/pages/manage/admin/slug/base')) ,
                        array('label' => 'قوانین' ,'url' => Yii::app()->createUrl('/pages/manage/update/id/5/slug/rules')) ,
                        array('label' => 'صفحات راهنما' ,'url' => Yii::app()->createUrl('/pages/manage/admin/slug/guide')) ,
                    )
                ),
                array(
                    'label' => 'تنظیمات<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'عمومی' ,'url' => Yii::app()->createUrl('/setting/manage/changeSetting')) ,
                        array('label' => 'پیام وبسایت' ,'url' => Yii::app()->createUrl('/setting/manage/siteMessage')) ,
                        array('label' => 'گوگل ارث' ,'url' => Yii::app()->createUrl('/map/manage/update')) ,
                        array('label' => 'تغییر کلمه عبور' ,'url' => Yii::app()->createUrl('/admins/manage/changePass')) ,
                    )
                ) ,
                array(
                    'label' => 'ورود' ,
                    'url' => array('/admins/login') ,
                    'visible' => Yii::app()->user->isGuest
                ) ,
                array(
                    'label' => 'خروج' ,
                    'url' => array('/admins/login/logout') ,
                    'visible' => !Yii::app()->user->isGuest) ,
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
            $errors .= implode('<br>' ,$err) . '<br>';
        }
        return $errors;
    }

    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0;$i < $length;$i++){
            $randomString .= $characters[rand(0 ,$charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰' ,'۱' ,'۲' ,'۳' ,'۴' ,'۵' ,'۶' ,'۷' ,'۸' ,'۹');
        $english_array = array('0' ,'1' ,'2' ,'3' ,'4' ,'5' ,'6' ,'7' ,'8' ,'9');

        return str_replace($english_array ,$farsi_array ,$matches);
    }

    public static function fileSize($file){
        $size = filesize($file);
        if($size < 1024)
            return $size.' Byte';
        elseif($size < 1024*1024){
            $size = (float)$size/1024;
            return number_format($size,1). ' KB';
        }
        elseif($size < 1024*1024*1024){
            $size = (float)$size/(1024*1024);
            return number_format($size,1). ' MB';
        }else
        {
            $size = (float)$size/(1024*1024*1024);
            return number_format($size,1). ' GB';
        }
    }
}