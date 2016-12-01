<?php
/* @var $this ArticlesManageController */
/* @var $model ArticleFileLinks */
/* @var $form CActiveForm */
$image = array();
$uploadDir = Yii::getPathOfAlias('webroot').'/uploads/articles/fileimages';
$uploadUrl = Yii::app()->baseUrl.'/uploads/articles/fileimages';
if($model->image && file_exists($uploadDir.DIRECTORY_SEPARATOR.$model->image))
	$image = array(
		'name' => $model->image,
		'src' => $uploadUrl . '/' . $model->image,
		'size' => filesize($uploadDir .DIRECTORY_SEPARATOR. $model->image),
		'serverName' => $model->image,
	);
?>
<div class="form">
	<div class='row'>
		<?php echo CHtml::activeLabel($model,'image', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderImage',
			'model' => $model,
			'name' => 'image',
			'maxFiles' => 1,
			'maxFileSize' => 0.2, //MB
			'url' => Yii::app()->createUrl('/articles/links/upload'),
			'deleteUrl' => Yii::app()->createUrl('/articles/links/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png',
			'serverFiles' => $image,
			'data' => array('id'=>$model->id),
			'onSuccess' => '
			var responseObj = JSON.parse(res);
			if(responseObj.state == "ok")
			{
				{serverName} = responseObj.fileName;
			}else if(responseObj.state == "error"){
				console.log(responseObj.msg);
			}
		',
		));
		Yii::app()->clientScript->registerCss('dropZone','.dropzone.single{width:100%}');
		?>
		<span class="description">تصویر موردنظر را آپلود کنید</span>
	</div>
</div><!-- form -->