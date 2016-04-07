<?php
/* @var $this ClassesManageController */
/* @var $model Classes */
/* @var $form CActiveForm */
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'classes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_id'); ?>
		<?php echo $form->dropDownList($model,'course_id',CHtml::listData(Courses::model()->findAll(),'id','title')); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',CHtml::listData(ClassCategories::model()->findAll(),'id','title')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startSignupDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'startSignupDate')); ?>
		<?php echo $form->hiddenField($model,'startSignupDate',array('id'=>'startSignupDateAlt')); ?>
		<?php echo $form->error($model,'startSignupDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endSignupDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'endSignupDate')); ?>
		<?php echo $form->hiddenField($model,'endSignupDate',array('id'=>'endSignupDateAlt')); ?>
		<?php echo $form->error($model,'endSignupDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startClassDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'startClassDate')); ?>
		<?php echo $form->hiddenField($model,'startClassDate',array('id'=>'startClassDateAlt')); ?>
		<?php echo $form->error($model,'startClassDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endClassDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'endClassDate')); ?>
		<?php echo $form->hiddenField($model,'endClassDate',array('id'=>'endClassDateAlt')); ?>
		<?php echo $form->error($model,'endClassDate'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php
		$this->widget("ext.ckeditor.CKEditor",array(
				'model' => $model,
				'attribute' => 'summary'
		));
		?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
				'model' => $model,
				'attribute' => 'formTags',
				'suggestType' => 'json',
				'suggestUrl' => Yii::app()->createUrl('/courses/tags/list'),
				'data' => $model->formTags
		));
		?>
		<button data-toggle="modal" data-target="#modal" class="btn btn-success btn-round btn-inverse btn-sm">
			<i class="icon-plus icon-1x"></i>
			&nbsp;&nbsp;
			افزودن تگ دلخواه
		</button>
		<?php echo $form->error($model,'formTags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="modal fade" role="dialog" id="modal">
	<div class="modal-dialog modal-sm	">
		<div class="modal-content">
			<div class="modal-body">
				<?
				$this->renderPartial('_tagForm',array(
					'model' => new ClassTags()
				)); ?>
			</div>
		</div>
	</div>
</div>
<?
Yii::app()->clientScript->registerScript('datesScript','
	$(\'#startSignupDate\').persianDatepicker({
        altField: \'#startSignupDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });


    $(\'#endSignupDate\').persianDatepicker({
        altField: \'#endSignupDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });

    $(\'#startClassDate\').persianDatepicker({
        altField: \'#startClassDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });

    $(\'#endClassDate\').persianDatepicker({
        altField: \'#endClassDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });
');
$ss = !empty($model->startSignupDate)?explode('/',JalaliDate::date("Y/m/d",$model->startSignupDate,false)):explode('/',JalaliDate::date("Y/m/d",time(),false));
$es = !empty($model->endSignupDate)?explode('/',JalaliDate::date("Y/m/d",$model->endSignupDate,false)):explode('/',JalaliDate::date("Y/m/d",time(),false));
$sc = !empty($model->startClassDate)?explode('/',JalaliDate::date("Y/m/d",$model->startClassDate,false)):explode('/',JalaliDate::date("Y/m/d",time(),false));
$ec = !empty($model->endClassDate)?explode('/',JalaliDate::date("Y/m/d",$model->endClassDate,false)):explode('/',JalaliDate::date("Y/m/d",time(),false));
Yii::app()->clientScript->registerScript('dateSets', '
	$("#startSignupDate").persianDatepicker("setDate",['.$ss[0].','.$ss[1].','.$ss[2].']);
	$("#endSignupDate").persianDatepicker("setDate",['.$es[0].','.$es[1].','.$es[2].']);
	$("#startClassDate").persianDatepicker("setDate",['.$sc[0].','.$sc[1].','.$sc[2].']);
	$("#endClassDate").persianDatepicker("setDate",['.$ec[0].','.$ec[1].','.$ec[2].']);
');