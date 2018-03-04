<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language ?>">
<head>
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

    <link rel="shortcut icon" href="<?= Yii::app()->theme->baseUrl; ?>/images/logo.ico">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/error.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/bootstrap-select.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/script.js', CClientScript::POS_END);
    ?>
</head>
<body>
    <?php echo $content;?>
</body>
</html>