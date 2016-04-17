<?
/* @var $courses Courses[] */
/* @var $personnel Personnel[] */
/* @var $teachers Users[] */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.easy-ticker.min.js');

Yii::app()->clientScript->registerScript("easyTicker-scripts","
        $('.persons .teachers .slider').easyTicker({
            direction: 'down',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 355,
            visible: 1,
            mousePause: 1,
            controls: {
                up: '.teacher-up',
                down: '.teacher-down'
            }
        }).data('easyTicker');

        $('.persons .partners .slider').easyTicker({
            direction: 'down',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 355,
            visible: 1,
            mousePause: 1,
            controls: {
                up: '.partner-up',
                down: '.partner-down'
            }
        }).data('easyTicker');");

?>

<section class="courses">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app' ,'Education Courses') ?></h3>
        <div class="course-carousel">
            <?
            if($courses) :
                Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');
                Yii::app()->clientScript->registerScript("owl-carousel-script","
                $('.course-carousel').owlCarousel({
                    ".(Yii::app()->language == 'fa'?'rtl:true,':'')."
                    navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
                    navClass: ['owl-prev disabled','owl-next'],
                    callbacks: true,
                    info: true,
                    margin:30,
                    responsive : {
                        0 : {
                            items:1,
                            nav : false,
                            margin :10
                        },
                        769 :{
                            items:2,
                            nav : true,
                            margin :10
                        },
                        1025 :{
                            items:2,
                            nav : true,
                            margin :40
                        },
                        1201 :{
                            items:3,
                            nav : true,
                            margin :10
                        },
                        1401 :{
                            items:3,
                            nav : true,
                            margin :40
                        },
                        1601 :{
                            items:4,
                            nav : true,
                            margin :10
                        },
                    },
                    onTranslated: $(this).on('translated.owl.carousel', function(e) {
                        var items_per_page = e.page.size;
                        var nav_container = $(\".owl-nav\");
                        var item_index = e.item.index;
                        var item_count = e.item.count;
                        var last_vis_item_index = items_per_page + item_index;
                        if(last_vis_item_index === item_count){
                            $(nav_container).find('div:last').addClass('disabled');
                        }
                        else{
                            $(nav_container).find('div:last').removeClass('disabled');
                        }
                        if(item_index != 0){
                            $(nav_container).find('div:first').removeClass('disabled');
                        }
                        else{
                            $(nav_container).find('div:first').addClass('disabled');
                        }
                    }),
                });");
                foreach($courses as $course):
                    ?>
                    <div class="course">
                        <div class="course-pic" data-toggle="tooltip" data-placement="top" title="<?= $course->title ?>">
                            <img src="<?= Yii::app()->baseUrl.'/uploads/courses/'.$course->pic; ?>" alt="<?= $course->title ?>">
                        </div>
                        <div class="course-detail container-fluid">
                            <h4><a href="<?= Yii::app()->createAbsoluteUrl('/courses/'.$course->id.'/'.urlencode($course->title)); ?>"><?= $course->title ?></a></h4>

                            <p class="text">
                                <?= CHtml::encode(strip_tags($course->summary)) ?>
                                <span class="paragraph-end"></span>
                            </p>
                            <a href="<?= Yii::app()->createAbsoluteUrl('/courses/'.$course->id.'/'.urlencode($course->title)); ?>"
                               data-toggle="tooltip" data-placement="<?= Yii::app()->language == 'fa'?'right':'left';?>" title="<?= Yii::t('app','Course Details') ?>"
                               class="btn pull-left"><?= Yii::t('app','Details')?></a>
                        </div>
                    </div>
                    <?
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<section class="signup" id="signup">
    <div class="mask"></div>
    <div class="container-fluid">
        <h2 class="yekan-text text-center"><?= Yii::t('app','Sign Up Account') ?></h2>

        <?php
        $signUpModel = new Users();
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'index-signup-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'action' => array('/signup'),
            'htmlOptions' => array(
                'class' => 'form-group'
            )
        )); ?>
            <div class="center-block box">
                <?php echo $form->emailField($signUpModel,'email' ,array(
                    'placeholder' => Yii::t('app','Email'),
                    'class' => 'text-field'
                )); ?>
                <?php echo $form->passwordField($signUpModel,'password',array(
                    'placeholder' => Yii::t('app','Password'),
                    'class' => 'text-field'
                )); ?>

                <div class="checkbox">
                    <label>
                        <input type="checkbox">
                        <span>
                            <?= Yii::t('app' ,'I agree to the Yahoo <a href="'.Yii::app()->baseUrl."/terms".'">Terms and Privacy')?>
                        </span>
                    </label>
                </div>
                <?= CHtml::submitButton(Yii::t('app','Sign Up'),array('class'=>"button-field btn")); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</section>
<section class="persons">
    <div class="bg">
        <div class="icons-set left"></div>
        <div class="icons-set right"></div>
    </div>
    <div class="container">
        <?php
        if($personnel) {
            ?>
            <div class="col-md-6 teachers" id="staff">
                <h3 class="yekan-text"><?= Yii::t('app', 'Staff') ?></h3>

                <div class="slider">
                    <ul>
                        <?php
                        foreach($personnel as $person):
                        $socialLinks = CJSON::decode($person->social_links);
                            ?>
                        <li class="person-item">
                            <div class="image">
                                <img src="<?= Yii::app()->baseUrl.$person->avatar ?>" alt="<?= CHtml::encode($person->fullName) ?>">

                                <div class="img-overlay"></div>
                            </div>
                            <span class="name"><?= CHtml::encode($person->fullName) ?></span>
                            <span class="job"><?= CHtml::encode($person->grade) ?></span>

                            <div class="socials">
                                <a href="<?= $person->email ?>" class="email" title="<?= Yii::t('app','Email') ?>"></a>
                                <a href="<?= $socialLinks[0]['value'] ?>" class="facebook" title="<?= Yii::t('app','Facebook') ?>"></a>
                                <a href="<?= $socialLinks[1]['value'] ?>" class="twitter" title="<?= Yii::t('app','Twitter') ?>"></a>
                            </div>
                            <a href="<?= Yii::app()->createUrl('/personnel/'.$person->id.'/'.urlencode($person->getFullName())) ?>" class="person-link" title="<?= CHtml::encode($person->fullName) ?>"></a>
                        </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <div class="controls">
                    <button class="teacher-up btn"><i class="icon"></i></button>
                    <button class="teacher-down btn"><i class="icon"></i></button>
                </div>
            </div>
            <?
        }
        ?>
        <?php
        if($teachers) {
            ?>
            <div class="col-md-6 partners">
                <h3 class="yekan-text"><?= Yii::t('app', 'Teachers') ?></h3>

                <div class="slider">
                    <ul>
                        <?php
                        foreach($teachers as $teacher):
                            $socialLinks = CJSON::decode($teacher->teacherDetails->social_links);
                            ?>
                            <li class="person-item">
                                <div class="image">
                                    <img src="<?= Yii::app()->baseUrl.$teacher->teacherDetails->avatar ?>" alt="<?= CHtml::encode($teacher->teacherDetails->getFullName()) ?>">

                                    <div class="img-overlay"></div>
                                </div>
                                <span class="name"><?= CHtml::encode($teacher->teacherDetails->getFullName()) ?></span>
                                <span class="job"><?= CHtml::encode($teacher->teacherDetails->grade) ?></span>

                                <div class="socials">
                                    <a href="<?= $teacher->email ?>" class="email" title="<?= Yii::t('app','Email') ?>"></a>
                                    <a href="<?= $socialLinks[0]['value'] ?>" class="facebook" title="<?= Yii::t('app','Facebook') ?>"></a>
                                    <a href="<?= $socialLinks[1]['value'] ?>" class="twitter" title="<?= Yii::t('app','Twitter') ?>"></a>
                                </div>
                                <a href="<?= Yii::app()->createUrl('/teachers/'.$teacher->id.'/'.urlencode($teacher->teacherDetails->getFullName())) ?>" class="person-link" title="<?= CHtml::encode($teacher->teacherDetails->getFullName()) ?>"></a>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <div class="controls">
                    <button class="partner-up btn"><i class="icon"></i></button>
                    <button class="partner-down btn"><i class="icon"></i></button>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</section>
<section class="about">
    <div class="container">
        <h3 class="yekan-text">درباره پردیس</h3>
        <div class="col-md-8 text-container">
            <div class="text">
                <p class="paragraph col-md-6">مرکز زبان آریانپورکه تنها دارنده مجوز از وزارت آموزش و پرورش به ایـن نام در تهران می باشد، با مطالعات و برنامه ریزی های جـامـع آمـوزشـی و بـا سـالها سابقه در برگزاری دوره های IELTS,TOEFL  تا کـنون گامهای بلند و جامعی در جهت ارایه آموزش صحیح و موثر زبان انگلیسی برداشته است .</p>
                <p class="paragraph col-md-6">در هـمین راسـتا با ایــجاد محیط آموزشی استاندارد و بهره گیری از تکنولوژی جـدید آمـوزش زبان و استادان مجرب، با بالاترین آمار نمرات در آزمونهای فوق همواره  با آغوش باز پذیرای زبان آموزان عزیز می باشد. </p>
            </div>
        </div>
        <div class="col-md-4 licenses-container">
            <div class="col-md-6"><img src="../images/rasaneh.jpg"></div>
            <div class="col-md-6"><img src="../images/enamad.jpg"></div>
        </div>
    </div>
</section>
