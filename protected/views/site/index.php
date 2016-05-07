<?
/* @var $courses Courses[] */
/* @var $personnel Personnel[] */
/* @var $teachers Users[] */
/* @var $form CActiveForm */
/* @var $aboutText Pages */
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

<section class="courses" id="courses">
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
                            margin :15,
                            dots : true,
                            stagePadding : 15
                        },
                        459 :{
                            items:2,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                        1025 :{
                            items:2,
                            nav : true,
                            margin :40,
                            dots : false,
                            stagePadding : 0
                        },
                        1201 :{
                            items:3,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                        1401 :{
                            items:3,
                            nav : true,
                            margin :40,
                            dots : false,
                            stagePadding : 0
                        },
                        1601 :{
                            items:4,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
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
                            <a href="<?= Yii::app()->createUrl('/courses/'.$course->id.'/'.urlencode($course->title)); ?>">
                                <img src="<?= Yii::app()->baseUrl.'/uploads/courses/'.$course->pic; ?>" alt="<?= $course->title ?>">
                            </a>
                        </div>
                        <div class="course-detail container-fluid">
                            <h4><a href="<?= Yii::app()->createUrl('/courses/'.$course->id.'/'.urlencode($course->title)); ?>"><?= $course->title ?></a></h4>

                            <p class="text">
                                <?= strip_tags($course->summary) ?>
                                <span class="paragraph-end"></span>
                            </p>
                            <a href="<?= Yii::app()->createUrl('/courses/'.$course->id.'/'.urlencode($course->title)); ?>"
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
    <?= $this->renderPartial("//layouts/_loading");?>
    <div class="container-fluid">
        <h2 class="yekan-text text-center"><?= Yii::t('app','Sign Up Account') ?></h2>

        <?php
        $signUpModel = new Users('agreeTerms');
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'register-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'afterValidate' => 'js:function(form ,data ,hasError){
                    if(!hasError)
                    {
                        var form = $("#register-form");
                        var loading = $(".signup .loading-container");
                        var url = \''.Yii::app()->createUrl('/register').'\';
                        submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
                    }
                }'
            ),
            'htmlOptions' => array(
                'class' => 'form-group'
            )
        ));
        Yii::app()->clientScript->registerScript('registerForm','
            document.getElementById("register-form").reset();
        ');
        echo CHtml::hiddenField('ajax','register-form');
        ?>
            <div class="center-block box">
                <?= $this->renderPartial("//layouts/_flashMessage");?>
                <div class="relative">
                    <?php echo $form->emailField($signUpModel,'email' ,array(
                        'placeholder' => Yii::t('app','Email'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($signUpModel,'email',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <?php echo $form->passwordField($signUpModel,'password',array(
                        'placeholder' => Yii::t('app','Password'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($signUpModel,'password',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <?php echo $form->telField($signUpModel,'phone',array(
                        'placeholder' => Yii::t('app','Phone'),
                        'class' => 'text-field',
                        'max-length' => 11
                    ));
                    echo $form->error($signUpModel,'phone',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <div class="checkbox">
                        <label>
                            <?= $form->checkBox($signUpModel,'agreeTerms'); ?>
                            <span>
                                <?= Yii::t('app' ,'I agree with the <a data-toggle="modal" data-target="#terms-modal" href="#">Terms and Policies</a>')?>
                            </span>
                        </label>
                        <? echo $form->error($signUpModel,'agreeTerms',array('class'=>'errorMessage tip'));?>
                    </div>
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
            <div class="<?= $teachers?'':'center-block' ?> col-lg-6 col-md-6 col-sm-12 col-xs-12  partners" id="staff">
                <h3 class="yekan-text"><?= Yii::t('app', 'Staff') ?></h3>

                <div class="slider">
                    <ul>
                        <?php
                        foreach($personnel as $person):
                        $socialLinks = CJSON::decode($person->social_links);
                            ?>
                        <li class="person-item">
                            <div class="image">
                                <img src="<?= Yii::app()->baseUrl.'/uploads/teachers/'.$person->avatar ?>" alt="<?= CHtml::encode($person->fullName) ?>">

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
                    <button class="partner-up btn"><i class="icon"></i></button>
                    <button class="partner-down btn"><i class="icon"></i></button>
                </div>
            </div>
            <?
        }
        ?>
        <?php
        if($teachers) {
            ?>
            <div class="<?= $personnel?'':'center-block' ?> col-lg-6 col-md-6 col-sm-12 col-xs-12 teachers" id="teachers">
                <h3 class="yekan-text"><?= Yii::t('app', 'Teachers') ?></h3>

                <div class="slider">
                    <ul>
                        <?php
                        foreach($teachers as $teacher):
                            $socialLinks = CJSON::decode($teacher->teacherDetails->social_links);
                            ?>
                            <li class="person-item">
                                <div class="image">
                                    <a href="<?= Yii::app()->createUrl('/teachers/'.$teacher->id.'/'.urlencode($teacher->teacherDetails->getFullName())) ?>" class="person-link"></a>
                                    <?
                                    if($teacher->teacherDetails->avatar):
                                    ?>
                                        <img src="<?= Yii::app()->baseUrl.'/uploads/teachers/'.$teacher->teacherDetails->avatar ?>" alt="<?= CHtml::encode($teacher->teacherDetails->getFullName()) ?>">
                                    <?
                                    else:
                                    ?>
                                        <div class="img-default"></div>
                                    <?
                                    endif;
                                    ?>

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
                    <button class="teacher-up btn"><i class="icon"></i></button>
                    <button class="teacher-down btn"><i class="icon"></i></button>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</section>
<section class="about" id="about">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app','About Avaye Shahir') ?></h3>
        <div class="<?= Yii::app()->language == 'fa'?'col-lg-8 col-md-8 col-sm-8 col-xs-12':'col-lg-12 col-md-12 col-sm-12 col-xs-12'; ?> text-container">
            <div class="text">
                <?
                $aboutText->summary = str_ireplace('<br />','#br#',$aboutText->summary);
                $text = strip_tags($aboutText->summary);
                $text = str_ireplace('#br#','<br>',$text);
                $length = mb_strlen($text,'utf8');
                if($length > 280) {
                    $length = ceil($length / 2);
                    $words = explode(" ", $text);
                    $c = count($words);
                    $l = 0;
                    $colOutput = '';
                    for($i = 1; $i <= 2; $i++) {
                        $new_string = "";
                        $colOutput .= "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\">";
                        for($g = $l; $g < $c; $g++) {
                            if(mb_strlen($new_string,'utf8') <= $length || $i == 2)
                                $new_string .= $words[$g]." ";
                            else {
                                $l = $g;
                                break;
                            }
                        }
                        $colOutput .= $new_string;
                        $colOutput .= "</p>";
                    }
                    echo $colOutput;
                }else {
                    echo "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\">".$text."</p>";
                    echo "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\"></p>";
                }
                ?>
            </div>
        </div>
        <div class="<?= Yii::app()->language == 'fa'?'col-lg-4 col-md-4 col-sm-4 col-xs-12':'hidden'; ?> licenses-container">
            <div class="col-md-6"><img src="<?= Yii::app()->theme->baseUrl .'/images/rasaneh.jpg';?>"></div>
            <div class="col-md-6"><img src="<?= Yii::app()->theme->baseUrl .'/images/enamad.jpg'; ?>"></div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="terms-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?= $termsText->summary ?>
            </div>
        </div>

    </div>
</div>