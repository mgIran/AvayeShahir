<section class="search" id="main">
    <div class="container">
        <?php
        /* @var $form CActiveForm */
        $form = $this->beginWidget("CActiveForm",array(
            'id' => 'search-form',
            'enableAjaxValidation' =>false,
            'action' =>array('search')
        ));
        ?>
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="row">
                    <?= $form->textField($this->searchModel,'text' ,array('class' => 'col-md-8 text-field' ,'placeholder' => Yii::t('app','Search for ...'))) ?>
                </div>
            </div>
            <div class="btn-group col-lg-3 col-md-3 col-sm-4 col-xs-7">
                <div class="row">
                    <?
                    $this->widget('ext.dropDown.dropDown', array(
                        'id' => 'search_type_box',
                        'model' => $this->searchModel,
                        'attribute' => 'type',
                        'label' => Yii::t('app','Search the entire site'),
                        'data' => array(
                            'all' => Yii::t('app' ,'All'),
                            'courses' => Yii::t('app' ,'Courses'),
                            'personnel' => Yii::t('app' ,'Staff'),
                            'teachers' => Yii::t('app' ,'Teachers')
                        ),
                        // @todo index page search box not work
                        'selected' => 'all',
                        'caret' => '<i class="icon icon-angle-down"></i>',
                        'emptyOpt' => false,
                    ));
                    ?>
                </div>
            </div>
            <button type="submit" class="col-lg-1 col-md-1 col-sm-2 col-xs-5 btn-search btn">
                <i class="search-icon"></i>
            </button>
        <?php $this->endWidget(); ?>
    </div>
    <div class="bg-icon"></div>
</section>