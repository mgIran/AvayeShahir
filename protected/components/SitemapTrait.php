<?php
trait SitemapTrait{
    private $sitemapClassConfig = [
        array(
            'module'=>'courses',
            'baseModel'=>'Courses',
            'frequency' => 'daily',
            'priority' => 1,
            'routeRegex'=>'/courses/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
        array(
            'module'=>'articles',
            'baseModel'=>'ArticleCategories',
            'frequency' => 'daily',
            'routeRegex'=>'/articles/category/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
        array(
            'module'=>'articles',
            'baseModel'=>'Articles',
            'frequency' => 'weekly',
            'routeRegex'=>'/articles/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
        array(
            'module'=>'news',
            'baseModel'=>'NewsCategories',
            'frequency' => 'daily',
            'routeRegex'=>'/news/category/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
        array(
            'module'=>'news',
            'baseModel'=>'News',
            'frequency' => 'weekly',
            'routeRegex'=>'/news/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
    ];
    
    public function getBaseSitePageList(){

        $list = array(
            array(
                'label' => 'صفحه اصلی',
                'loc'=>Yii::app()->createAbsoluteUrl('/'),
                'frequency'=>'weekly',
                'priority'=>'1',
            ),
            array(
                'label' => 'مطالب آموزشی',
                'loc'=>Yii::app()->createAbsoluteUrl('/articles'),
                'frequency'=>'daily',
                'priority'=>'1',
            ),
            array(
                'label' => 'اخبار',
                'loc'=>Yii::app()->createAbsoluteUrl('/news'),
                'frequency'=>'daily',
                'priority'=>'1',
            ),
            array(
                'label' => 'تبادل نظر',
                'loc'=>Yii::app()->createAbsoluteUrl('/forum'),
                'frequency'=>'daily',
                'priority'=>'0.8',
            ),
            array(
                'label' => 'درباره ما',
                'loc'=>Yii::app()->createAbsoluteUrl('/about'),
                'frequency'=>'monthly',
                'priority'=>'0.8',
            ),
            array(
                'label' => 'شرایط',
                'loc'=>Yii::app()->createAbsoluteUrl('/terms'),
                'frequency'=>'yearly',
                'priority'=>'0.3',
            ),
        );
        return $list;
    }
}