<?
/* @var $model Courses */
$fileUrl = Yii::app()->baseUrl.'/uploads/classCategoryFiles/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/classCategoryFiles/';
?>
<div class="page-title-container courses">
	<div class="mask"></div>
	<div class="container">
		<h2><?= $model->title ?></h2>
	</div>
</div>
<div class="page-content courses">
	<div class="container">
		<div class="basic-information">
			<div class="col-md-4">
				<div class="image row">
					<?
					if($model->pic):
					?>
						<img src="<?= Yii::app()->baseUrl.'/uploads/courses/'.$model->pic ?>" alt="<?= $model->title ?>">
					<?
					endif;
					?>
				</div>
			</div>
			<div class="col-md-8">
				<?= $model->summary; ?>
			</div>
		</div>
		<?
		if($model->categories):
		?>
		<div class="groups-container panel-group" id="collapse-parent">
			<?
			foreach($model->categories as $key => $category):
			?>
				<div class="group-item panel">
				<a class="collapse-header btn collapsed" data-toggle="collapse" href="#collapse-<?= $key ?>" data-parent="#collapse-parent">
					<span><?= $category->title ?></span>
					<i class="arrow-white"></i>
				</a>
				<div id="collapse-<?= $key ?>" class="panel-collapse collapse">
					<div class="container-fluid">
						<?
						$text = trim($category->summary);
						if(!empty($text))
							echo '<div class="text">'.$text.'</div>';
						?>
					<div class="files">
						<?
						if($category->files):
						?>
							<h3><?= Yii::t('app','Files') ?></h3>
							<h4><?= Yii::t('app','Direct Links') ?></h4>
							<ul>
							<?
							foreach($category->files as $file):
								if($file->path and file_exists($fileDir.$file->path)):
							?>
								<li>
									<a href="<?= $fileUrl.$file->path ?>"></a>
									<span><?= $file->title ?></span>
									<span class="extension"><?= strtoupper($file->file_type) ?></span>
									<span class="download">
										<i></i>
										<span><?= Yii::t('app','Download'); ?></span>
										<span class="size"><?= Controller::fileSize($fileDir.$file->path) ?></span>
									</span>
								</li>
							<?
								endif;
							endforeach;
							?>
							</ul>
						<?
						endif;
						?>
						<?
						if($category->links):
						?>
							<h4><?= Yii::t('app','Mirror Links') ?></h4>
							<ul>
							<?
							foreach($category->links as $fileLink):
								if($fileLink->link):
							?>
								<li>
									<a target="_blank" rel="nofollow" href="<?= $fileLink->link ?>"></a>
									<span><?= $fileLink->title ?></span>
									<span class="extension"><?= strtoupper($fileLink->file_type) ?></span>
									<span class="download">
										<i></i>
										<span><?= Yii::t('app','Download'); ?></span>
									</span>
								</li>
							<?
								endif;
							endforeach;
							?>
							</ul>
						<?
						endif;
						?>
					</div>

						<?
						if($category->classes):
						?>
							<div class="classes">
								<h3><?= Yii::t('app','Classes'); ?></h3>
								<div class="table text-center">
									<div class="tr thead">
										<div class="col-md-2 td"><?= Yii::t('app','Title'); ?></div>
										<div class="col-md-2 td"><?= Yii::t('app','Start of Registration'); ?></div>
										<div class="col-md-2 td"><?= Yii::t('app','Registration deadline'); ?></div>
										<div class="col-md-2 td"><?= Yii::t('app','Teacher'); ?></div>
										<div class="col-md-2 td"><?= Yii::t('app','Tuition'); ?>
											<span class="mini-label">(<?= Yii::t('app','Toman') ?>)</span>
										</div>
										<div class="col-md-2 td"></div>
									</div>
									<?
									foreach($category->classes as $key => $class):
									?>
										<div class="tr" <?= $class->summary && !empty($class->summary)?'data-toggle="collapse" data-target="#class-collapse-'.$key.'"':''; ?>>
											<div class="col-md-2 td"><?= $class->title ?></div>
											<div class="col-md-2 td"><?= Yii::app()->language == 'fa' ?JalaliDate::date("Y/m/d",$class->startSignupDate):date("Y/m/d",$class->startSignupDate); ?></div>
											<div class="col-md-2 td"><?= Yii::app()->language == 'fa' ?JalaliDate::date("Y/m/d",$class->endSignupDate):date("Y/m/d",$class->endSignupDate); ?></div>
											<div class="col-md-2 td"><?= $class->teacher->getFullName() ?></div>
											<div class="col-md-2 td"><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(number_format($class->price)):number_format($class->price); ?></div>
											<div class="col-md-2 td"><a href="#" class="disabled"><?= Yii::t('app','Register') ?></a></div>
										</div>
										<?
										if($class->summary && !empty($class->summary)):
										?>
											<div class="tr collapse" id="class-collapse-<?= $key ?>">
												<div class="col-md-12 td"><?= $class->summary ?></div>
											</div>
										<?
										endif;
										?>
									<?
									endforeach;
									?>
								</div>
							</div>
						<?
						endif;
						?>
					</div>
				</div>
			</div>
			<?
			endforeach;
			?>
		</div>
		<?
		endif;
		?>
	</div>
</div>