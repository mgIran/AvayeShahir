<?
/* @var $this CoursesManageController */
/* @var $model Courses */
Yii::app()->clientScript->registerScript('active-collapse','
	var url = window.location.hash, idx = url.indexOf("#")
	var hash = idx != -1 ? url.substring(idx) : -1;
	if(hash != -1){
		$(hash).collapse("show");
		$(\'html, body\').animate({
			scrollTop: ($(hash).offset().top-124)
		},0);
	}
',CClientScript::POS_LOAD);
?>
<div class="page-title-container courses personnel-page-header ">
	<div class="mask"></div>
	<div class="container">
		<h2><?= $model->title ?></h2>
		<div class="details">
			<span><?= Yii::t('app','Views') ?></span>
			<span><?= Yii::app()->language == 'fa'?Controller::parseNumbers($model->seen):$model->seen ?></span>
			<span class="svg svg-eye pull-right"></span>
		</div>
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
						<img src="<?= Yii::app()->baseUrl.'/uploads/courses/'.$model->pic ?>" alt="<?= $model->title ?>" title="<?= $model->title ?>">
					<?
					endif;
					?>
				</div>
			</div>
			<div class="col-md-8 text-justify">
				<?= $model->summary; ?>
			</div>
		</div>
		<?
		if($model->categories):
		?>
		<div class="groups-container panel-group category-show" id="collapse-parent">
			<?
			foreach($model->categories as $key => $category):
			?>
				<div class="group-item panel">
				<a class="collapse-header btn collapsed" data-toggle="collapse" href="#collapse-category-<?= $category->id ?>" data-parent="#collapse-parent">
					<span><?= $category->title ?></span>
					<i class="arrow-white"></i>
				</a>
				<div id="collapse-category-<?= $category->id ?>" class="panel-collapse collapse">
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
							<?php // print file items
                            foreach($category->files as $file):
                                $this->renderPartial('//site/_file_item', array('file' => $file));
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
                                $this->renderPartial('//site/_link_item', array('fileLink' => $fileLink));
							endforeach;
							?>
							</ul>
						<?
						endif;
						?>
					</div>

						<?
						if($category->getValidClasses()):
						?>
							<div class="classes table-responsive" id="class-list-<?= $category->id ?>">
								<h3><?= Yii::t('app','Classes'); ?></h3>
								<table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th><?= Yii::t('app','Title'); ?></th>
                                            <th><?= Yii::t('app','Start of Registration'); ?></th>
                                            <th><?= Yii::t('app','Registration deadline'); ?></th>
                                            <th><?= Yii::t('app','Class Hours'); ?></th>
                                            <th><?= Yii::t('app','Teacher'); ?></th>
                                            <th><?= Yii::t('app','Tuition'); ?>
                                                <span class="mini-label">(<?= Yii::t('app','Toman') ?>)</span>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
									<?
									foreach($category->getValidClasses() as $key => $class):
									?>
										<tr>
											<td><?= $class->title ?></td>
											<td><?= Yii::app()->language == 'fa' ?JalaliDate::date("Y/m/d",$class->startSignupDate):date("Y/m/d",$class->startSignupDate); ?></td>
											<td><?= Yii::app()->language == 'fa' ?JalaliDate::date("Y/m/d",$class->endSignupDate):date("Y/m/d",$class->endSignupDate); ?></td>
											<td><?= (Yii::app()->language == 'fa' ?Controller::parseNumbers($class->startClassTime):$class->startClassTime).' '.Yii::t('app','up to').' '.(Yii::app()->language == 'fa' ?Controller::parseNumbers($class->endClassTime):$class->endClassTime) ?></td>
											<td><?= $class->getTeachersFullName() ?></td>
											<td><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(number_format($class->price)):number_format($class->price); ?></td>
											<td>
												<a href="<?= Yii::app()->createUrl('/courses/register/'.$class->id) ?>"
												   class="btn btn-success"><?= Yii::t('app','Register')?>
												</a>
												<?php if($class->summary && !empty($class->summary)): ?>
													<span class="clearfix"></span>
													<a href="#" class="btn btn-info show-class-details"><?= Yii::t('app','Description')?>
                                                    </a>
                                                    <div class="hidden class-details"><?
                                                        $purifier = new CHtmlPurifier();
                                                        $purifier->setOptions(array(
                                                            'HTML.Allowed'=> 'p,a[href|target],b,i,br',
                                                            'HTML.AllowedAttributes'=> 'style,id,class,src,dir',
                                                        ));
                                                        echo $text = $purifier->purify($class->summary);
                                                        ?>
                                                        <div class="clearfix"></div>
                                                        <a href="<?= Yii::app()->createUrl('/courses/register/'.$class->id) ?>"
                                                           class="btn btn-success"><?= Yii::t('app','Register')?>
                                                        </a>
                                                    </div>
												<?php
												endif;
												?>
											</td>
										</tr>
									<?
									endforeach;
									?>
								</table>
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
<div id="show-class-detail-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid #eee;">
                <h4 style="margin-top: 0" class="pull-right"><?= Yii::t('app','Class Description') ?></h4>
                <button type="button" class="close pull-left" style="color: #000 !important;font-size: 20px" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>
        </div>

    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('show-class-details','
    $("body").on("click", ".show-class-details", function(e){
        e.preventDefault();
        var $this = $(this),
            $text = $this.parent().find(".class-details").html();
        if($text){
            $("#show-class-detail-modal .modal-body").html($text);
            $("#show-class-detail-modal").modal("show");
        }
    });
');