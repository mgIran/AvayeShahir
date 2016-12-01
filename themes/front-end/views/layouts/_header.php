<?
/* @var $this Controller */
// Module
if(isset($this->module))
    $menuID = $this->module->getName();
else
    // Controller
    $menuID = $this->ID;
$action = $this->action->id;
?>

<header class="header">
    <a href="https://telegram.me/joinchat/AoBISDw1SSONszrnxjb8wQ" target="_blank" class="telegram"></a>
    <a href="<?= Yii::app()->createUrl('/forum') ?>" class="forum-icon"></a>
    <div class="navbar container">
        <span class="navTrigger">
            <span class="lines"></span>
        </span>
        <div class="<?= Yii::app()->language == 'fa'?'logo':'hidden'; ?>" title="<?= $this->siteName ?>">
            <h1><?= $this->siteName ?></h1>
            <h2><?= $this->pageTitle ?></h2>
        </div>
        <ul class="nav">
            <li>
                <a class="scroll-link" href="<?= $menuID == 'site' && $action == 'index'?'#top':Yii::app()->baseUrl.'#top'; ?>" title="<?= Yii::t('app','Home');?>">
                    <?= Yii::t('app','Home');?>
                </a>
            </li>
            <li>
                <?
                $this->widget('ext.dropDown.dropDown', array(
                    'id' => 'nav_courses',
                    'name' => 'course',
                    'label' => Yii::t('app','Courses'),
                    'data' => $this->getCoursesList(),
                    'caret' => '<i class="caret"></i>',
                    'emptyOpt' => false,
                    'onchange' => 'js:
                        var $s = {id};
                        var $base = \''.Yii::app()->createUrl('/').'/\';
                        location.href = $base+$s;
                    ',
                ));
                ?>
<!--                <a class="scroll-link" href="--><?//= $menuID == 'site' && $action == 'index'?'#courses':Yii::app()->baseUrl.'#courses'; ?><!--" title="--><?//= Yii::t('app','Courses');?><!--">--><?//= Yii::t('app','Courses');?><!--</a>-->
            </li>
            <li>
                <a class="scroll-link" href="<?= $menuID == 'site' && $action == 'index'?'#classes':Yii::app()->baseUrl.'#classes'; ?>" title="<?= Yii::t('app','Classes');?>"><?= Yii::t('app','Classes');?></a>
            </li>
<!--            <li>-->
<!--                <a class="scroll-link" href="--><?//= $menuID == 'site' && $action == 'index'?'#staff':Yii::app()->baseUrl.'#staff'; ?><!--" title="--><?//= Yii::t('app','Staff');?><!--">--><?//= Yii::t('app','Staff');?><!--</a>-->
<!--            </li>-->
            <li>
                <a class="scroll-link" href="<?= $menuID == 'site' && $action == 'index'?'#teachers':Yii::app()->baseUrl.'#teachers'; ?>" title="<?= Yii::t('app','Teachers');?>"><?= Yii::t('app','Teachers');?></a>
            </li>
            <li>
                <a class="scroll-link" href="<?= $menuID == 'site' && $action == 'index'?'#about':Yii::app()->baseUrl.'#about'; ?>" title="<?= Yii::t('app','About Us');?>"><?= Yii::t('app','About Us');?></a>
            </li>
            <li>
                <a class="scroll-link" href="<?= $menuID == 'site' && $action == 'index'?'#contact':Yii::app()->baseUrl.'#contact'; ?>" title="<?= Yii::t('app','Contact Us');?>"><?= Yii::t('app','Contact Us');?></a>
            </li>
            <li>
                <a class="scroll-link" href="<?= $this->createUrl('/FAQ'); ?>" title="<?= Yii::t('app','FAQ');?>"><?= Yii::t('app','FAQ');?></a>
            </li>
            <?
            if(Yii::app()->user->isGuest ||  Yii::app()->user->type == 'admin'):
                ?>
                <li class="pull-left wide">
                    <a class="wide <?= $menuID == 'site' && $action == 'index'?'scroll-link':''; ?>" href="<?= $menuID == 'site' && $action == 'index'?'#signup':Yii::app()->baseUrl.'#signup'; ?>"
                       title="<?= Yii::t('app', 'Sign Up'); ?>"><?= Yii::t('app', 'Sign Up'); ?></a>
                </li>
                <li class="pull-left">
                    <span class="divider">|</span>
                </li>
                <li class="pull-left"
                    title="<?= Yii::t('app', 'Login'); ?>">
                    <a class="wide" href="#login-modal" data-toggle="modal"
                       data-target="#login-modal"><?= Yii::t('app', 'Login'); ?></a>
                </li>
                <?
            elseif(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
                // @todo after user login change login and register buttons
                ?>
                <li class="pull-left">
                    <a class="red-link" href="<?= Yii::app()->createUrl('logout') ?>"
                       title="<?= Yii::t('app', 'Log Out'); ?>">
                        <?= Yii::t('app', 'Log Out'); ?>
                    </a>
                </li>
                <li class="pull-left">
                    <span class="divider">|</span>
                </li>
                <li class="pull-left">
                    <a href="<?= Yii::app()->createUrl('/dashboard') ?>"
                       title="<?= Yii::t('app', 'Dashboard'); ?>">
                        <?= Yii::t('app', 'Dashboard'); ?>
                    </a>
                </li>
                <?
            endif;
            ?>
            <li class="pull-left">
                <span class="divider">|</span>
            </li>
            <li class="pull-left" data-toggle="tooltip"
                data-placement="<?= Yii::app()->language == 'fa' ? 'right' : 'left'; ?>"
                title="<?= Yii::t('app', 'Select Language'); ?>">
                <?
                $this->widget('ext.dropDown.dropDown', array(
                    'id' => 'select_lang',
                    'name' => 'select_lang',
                    'label' => Yii::t('app', 'Language'),
                    'data' => Yii::app()->params['languages'],
                    'selected' => Yii::app()->language,
                    'caret' => '<i></i>',
                    'emptyOpt' => false,
                    'onchange' => 'js:
                        var $s = {id};
                        var $base = \''.Yii::app()->baseUrl.'/\';
                        location.href = $base+$s;
                    ',
                ));
                ?>
            </li>
        </ul>
    </div>
</header>


<div id="login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= $this->renderPartial("//layouts/_loading");?>
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">
                    &times;</button>
                <div class="center-block box">
                    <h3><?= Yii::t('app','Login to Account');?></h3>
                    <?php
                    /* @var $formL CActiveForm */
                    Yii::import('users.models.UserLoginForm');
                    $loginModel = new UserLoginForm();
                    $formL=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'afterValidate' => 'js:function(form ,data ,hasError){
                                if(!hasError)
                                {
                                    var form = $("#login-form");
                                    var loading = $(".modal .loading-container");
                                    var url = \''.Yii::app()->createUrl('/login').'\';
                                    submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload(); ");
                                }
                            }'
                        )
                    ));
                    echo CHtml::hiddenField('ajax','login-form'); ?>
                    <div class="relative">
                        <?php echo $formL->emailField($loginModel,'email' ,array(
                            'placeholder' => Yii::t('app','Email'),
                            'class' => 'text-field email'
                        ));
                        echo $formL->error($loginModel,'email',array('class'=>'errorMessage tip')); ?>
                    </div>
                    <div class="relative">
                        <?php echo $formL->passwordField($loginModel,'password',array(
                            'placeholder' => Yii::t('app','Password'),
                            'class' => 'text-field password'
                        ));
                        echo $formL->error($loginModel,'password',array('class'=>'errorMessage tip'));
                        ?>
                    </div>
                    <div class="relative">
                        <div class="checkbox">
                            <label>
                                <?= $formL->checkBox($loginModel,'rememberMe'); ?>
                                <span>
                                <?= Yii::t('app' ,'Remember Me')?>
                            </span>
                            </label>
                        </div>
                    </div>
                    <?= CHtml::submitButton(Yii::t('app','Login'),array('class'=>"button-field btn")); ?>
                    <br>
                        <a href="<?= Yii::app()->createUrl('/users/public/forgetPassword'); ?>"><?= Yii::t('app','Forgot Password?');?></a>
                    <br>
                        <span><?= Yii::t('app','Are You New?');?></span>&nbsp;<a class="<?= $menuID == 'site' && $action == 'index'?'scroll-link':''; ?>" href="<?= $menuID == 'site' && $action == 'index'?'#signup':Yii::app()->baseUrl.'#signup'; ?>" <?= $menuID == 'site' && $action == 'index'?'data-dismiss="modal"':'' ?>><?= Yii::t('app','Sign Up.');?></a>
                    <? $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?
Yii::app()->clientScript->registerScript('scroll-mode',"if($(window).scrollTop() > 100)
        $(\"header.header\").addClass('scroll-mode');
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100)
            $(\"header.header\").addClass('scroll-mode');
        else
            $(\"header.header\").removeClass('scroll-mode');
        $(\"[data-toggle='tooltip']\").tooltip('hide');
    });",CClientScript::POS_HEAD);