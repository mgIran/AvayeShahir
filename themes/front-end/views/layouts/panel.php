<?
/* @var $content string */
/* @var $cs CClientScript */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-site-verification" content="eLig20wuueY0sZTGCnc8lSvjKPFW_bqNtfgl3UivuI0" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>" />
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <!-- The above 3.2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?
        if($this->siteName)
            echo (!empty($this->pageTitle)?$this->pageTitle.' - ':'').$this->siteName;
        elseif(!empty($this->pageTitle))
            echo $this->pageTitle;
        else
            echo Yii::app()->name;
        ?>
    </title>
    <link rel="shortcut icon" href="<?= Yii::app()->theme->baseUrl.'/images/favicon.ico'; ?>">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-material-design.min.css');
    $cs->registerCssFile($baseUrl.'/css/ripples.min.css');
    $cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?9.3');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css?9.3');
    if (Yii::app()->params['default_language'] !== Yii::app()->language)
    {
        // @todo add css for multi language
        $cs->registerCssFile($baseUrl.'/css/bootstrap-theme-'.Yii::app()->language.'.css?9.3');
    }
    $cs->registerCssFile($baseUrl.'/css/panel.css?9.3');
    if (Yii::app()->params['default_language'] !== Yii::app()->language)
    {
        // @todo add css for multi language
        $cs->registerCssFile($baseUrl.'/css/panel-'.Yii::app()->language.'.css?9.3');
    }
    $cs->registerCssFile($baseUrl.'/css/panel-responsive-theme.css?9.3');
    
    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/material.min.js');
    $cs->registerScriptFile($baseUrl.'/js/ripples.min.js');
    $cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.mousewheel.min.js');
    $cs->registerScriptFile($baseUrl.'/js/scripts.js?9.3');
    ?>
</head>
<body class="inner-page" id="top">
<?= $this->renderPartial('//layouts/_header'); ?>
<section class="inner-page-content">
    <?= $content ?>
</section>
<?= $this->renderPartial('//layouts/_innerFooter'); ?>
</body>
</html>