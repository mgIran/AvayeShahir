<?
/* @var $content string */
/* @var $cs CClientScript */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">

    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <!-- The above 3.2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?
        if($this->siteName)
            echo $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:Yii::app()->name);
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
    $cs->registerCssFile($baseUrl.'/css/svg.css?4.5');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?4.5');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css?4.5');
    if (Yii::app()->params['default_language'] !== Yii::app()->language)
    {
        // @todo add css for multi language
        $cs->registerCssFile($baseUrl.'/css/bootstrap-theme-'.Yii::app()->language.'.css?4.5');
    }

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/material.min.js');
    $cs->registerScriptFile($baseUrl.'/js/ripples.min.js');
    $cs->registerScriptFile($baseUrl.'/js/scripts.js?4.5');
    ?>
</head>
<body id="top" class="inner-page">
<?= $this->renderPartial('//layouts/_page_loading'); ?>
<?= $this->renderPartial('//layouts/_header'); ?>
<section class="inner-page-content">
    <?= $content ?>
</section>
<?= $this->renderPartial('//layouts/_innerFooter'); ?>
</body>
</html>