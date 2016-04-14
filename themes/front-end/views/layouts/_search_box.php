<section class="search" id="main">
    <div class="container">
        <form action="/search" method="post">
            <div class="col-md-8">
                <div class="row">
                    <input type="text" class="col-md-8 text-field" placeholder="<?= Yii::t('app','Search for ...')?>">
                </div>
            </div>
            <div class="btn-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="row">
                    <?
                    $this->widget('ext.dropDown.dropDown', array(
                        'id' => 'search_box',
                        'name' => 'search_type',
                        'label' => Yii::t('app','Search the entire site'),
                        'data' => array(
                            'all' => Yii::t('app' ,'All'),
                            'courses' => Yii::t('app' ,'Courses'),
                            'personnel' => Yii::t('app' ,'Staff'),
                            'teachers' => Yii::t('app' ,'Teachers')
                        ),
                        // @todo index page search box not work
                        'selected' => Yii::app()->language,
                        'caret' => '<i class="icon icon-angle-down"></i>',
                        'emptyOpt' => false,
                    ));
                    ?>
                </div>
            </div>
            <button type="submit" class="col-md-1 btn-search btn">
                <i class="search-icon"></i>
            </button>
        </form>
    </div>
    <div class="bg-icon"></div>
</section>