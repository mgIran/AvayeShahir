<?php
/* @var $this SiteController */
?>
<?php
echo CHtml::beginForm(array('/search'),'get',array('class'=>'navbar-form navbar-center'))
?>
    <div class="form-group">
        <?php
        $this->widget('ext.dropDown.dropDown',array(
            'id' => 'search-form-type-list',
            'name' => 'type',
            'label' => 'گروه جستجو را انتخاب کنید',
            'data' => array(
                'courses' =>'دوره ها',
                'classes' => 'کلاس ها',
                'articles' => 'مطالب آموزشی',
                'news' => 'اخبار',
                'teachers' => 'اساتید'
            )
        ));
        ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::textField('term',isset($_GET['term'])?CHtml::encode($_GET['term']):'',array('id'=>'search-term','class'=>'form-control','placeholder'=>'جستجو کنید...','autocomplete' => 'off')) ?>
        <span class="search-btn-icon">
                        <?php echo CHtml::submitButton('',array('name'=>'','class'=>'btn btn-default')) ?>
                    </span>
    </div>
    <div class="search-suggest-box">
        <div class="search-entries"></div>
    </div>
<?php
echo CHtml::endForm();
?>