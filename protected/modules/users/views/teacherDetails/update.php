<?php
/* @var $this TeacherDetailsController */
/* @var $model TeacherDetails */
/* @var $avatar string */
/* @var $file string */

$this->breadcrumbs=array(
		'مدیریت اساتید'=>array('/users/teachers/admin'),
		$model->name .' ' .$model->family,
		'تکمیل اطلاعات',
);

$this->menu=array(
		array('label'=>'لیست اساتید', 'url'=>array('/users/teachers/admin')),
);
if(isset($_GET['return']) && $_GET['return'] == true)
	$this->menu = array(
			array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
	);
?>

<h1>تکمیل اطلاعات <?php echo $model->name .' ' .$model->family; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'avatar' => $avatar,'file' => $file)); ?>