<?
// Module
if(isset($this->module))
    $menuID = $this->module->getName();
else
    // Controller
    $menuID = $this->ID;
$action = $this->action->id;
?>
<header class="header">
    <div class="navbar container">
        <div class="<?= Yii::app()->language == 'fa'?'logo':'hidden'; ?>" title="<?= $this->siteName ?>">
            <h1><?= $this->siteName ?></h1>
            <h2><?= $this->pageTitle ?></h2>
        </div>
        <ul class="nav">
            <li>
                <a href="<?= $menuID == 'site' && $action == 'index'?'#top':Yii::app()->baseUrl.'#top'; ?>" title="<?= Yii::t('app','Home');?>">
                    <?= Yii::t('app','Home');?>
                </a>
            </li>
            <li>
                <a href="<?= $menuID == 'site' && $action == 'index'?'#courses':Yii::app()->baseUrl.'#courses'; ?>" title="<?= Yii::t('app','Courses');?>"><?= Yii::t('app','Courses');?></a>
            </li>
            <li>
                <a href="<?= $menuID == 'site' && $action == 'index'?'#staff':Yii::app()->baseUrl.'#staff'; ?>" title="<?= Yii::t('app','Staff');?>"><?= Yii::t('app','Staff');?></a>
            </li>
            <li>
                <a href="<?= $menuID == 'site' && $action == 'index'?'#teachers':Yii::app()->baseUrl.'#teachers'; ?>" title="<?= Yii::t('app','Teachers');?>"><?= Yii::t('app','Teachers');?></a>
            </li>
            <li>
                <a href="<?= $menuID == 'site' && $action == 'index'?'#about':Yii::app()->createUrl('about'); ?>" title="<?= Yii::t('app','About Us');?>"><?= Yii::t('app','About Us');?></a>
            </li>
            <li>
                <a href="#contact" title="<?= Yii::t('app','Contact Us');?>"><?= Yii::t('app','Contact Us');?></a>
            </li>
            <?
            if(Yii::app()->user->isGuest ||  Yii::app()->user->type == 'admin'):
                ?>
                <li class="pull-left wide">
                    <a class="wide" href="#signup"
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
                    <a href="<?= Yii::app()->createUrl('logout') ?>"
                       title="<?= Yii::t('app', 'Log Out'); ?>">
                        <span class="icon-exit"></span>
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
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal">
                    &times;</button>
            </div>
            <div class="modal-body">
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
                    <?php echo $formL->emailField($loginModel,'email' ,array(
                        'placeholder' => Yii::t('app','Email'),
                        'class' => 'text-field email'
                    ));
                    echo $formL->error($loginModel,'email'); ?>
                    <?php echo $formL->passwordField($loginModel,'password',array(
                        'placeholder' => Yii::t('app','Password'),
                        'class' => 'text-field password'
                    ));
                    echo $formL->error($loginModel,'password');
                    ?>
                    <?= CHtml::submitButton(Yii::t('app','Login'),array('class'=>"button-field btn")); ?>
                    <br>
                        <span><?= Yii::t('app','Are You New?');?></span>&nbsp;<a href="#signup" data-dismiss="modal"><?= Yii::t('app','Sign Up.');?></a>
                    <? $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>