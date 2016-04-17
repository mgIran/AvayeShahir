<header class="header">
    <div class="navbar container">
        <div class="logo" data-toggle="tooltip" data-placement="bottom" title="<?= $this->siteName ?>">
            <h1><?= $this->siteName ?></h1>
            <h2><?= $this->pageTitle ?></h2>
        </div>
        <ul class="nav">
            <li>
                <a href="<?= Yii::app()->createAbsoluteUrl('//'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Home');?>">
                    <?= Yii::t('app','Home');?>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Courses');?>"><?= Yii::t('app','Courses');?></a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Staff');?>"><?= Yii::t('app','Staff');?></a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Teachers');?>"><?= Yii::t('app','Teachers');?></a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','About Us');?>"><?= Yii::t('app','About Us');?></a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Contact Us');?>"><?= Yii::t('app','Contact Us');?></a>
            </li>
            <?
            if(Yii::app()->user->isGuest ||  Yii::app()->user->type == 'admin'):
            ?>
            <li class="pull-left wide">
                <a class="wide" href="#signup" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Sign Up');?>" ><?= Yii::t('app','Sign Up');?></a>
            </li>
            <li class="pull-left">
                <span class="divider">|</span>
            </li>
            <li class="pull-left" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Login');?>">
                <a class="wide" href="#login-modal" data-toggle="modal" data-target="#login-modal"><?= Yii::t('app','Login');?></a>
            </li>

                <li class="pull-left">
                    <span class="divider">|</span>
                </li>
            <li class="pull-left" data-toggle="tooltip" data-placement="<?= Yii::app()->language=='fa'?'right':'left'; ?>" title="<?= Yii::t('app','Select Language');?>">
                <?
                $this->widget('ext.dropDown.dropDown', array(
                    'id' => 'select_lang',
                    'name' => 'select_lang',
                    'label' => Yii::t('app','Language'),
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
            <?
            elseif(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
                // @todo after user login change login and register buttons
            ?>
                <li class="pull-left">
                    <a href="<?= Yii::app()->createUrl('/dashboard') ?>" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Dashboard');?>">
                        <span class="icon-dashboard"></span>
                        <?= Yii::t('app','Dashboard');?>
                    </a>
                </li>
                <li class="pull-left">
                    <a href="<?= Yii::app()->createUrl('logout') ?>" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Log Out');?>">
                        <span class="icon-exit"></span>
                        <?= Yii::t('app','Log Out');?>
                    </a>
                </li>
            <?
            endif;
            ?>
        </ul>
    </div>
</header>


<div id="login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="center-block box">
                    <h3><?= Yii::t('app','Login to Account');?></h3>
                    <form action="/login" method="post">
                        <input type="text" placeholder="<?= Yii::t('app','Email');?>" class="text-field email">
                        <input type="password" placeholder="<?= Yii::t('app','Password');?>" class="text-field password">
                        <button type="submit" class="button-field btn"><?= Yii::t('app','Login');?></button>
                        <a href="#"></a><br>
                        <span><?= Yii::t('app','Are You New?');?></span><a href="#"><?= Yii::t('app','Sign Up.');?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>