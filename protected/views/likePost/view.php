<?php
/* @var $this LikePostController */
/* @var $model LikePost */

$this->breadcrumbs=array(
	'Like Posts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LikePost', 'url'=>array('index')),
	array('label'=>'Create LikePost', 'url'=>array('create')),
	array('label'=>'Update LikePost', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LikePost', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LikePost', 'url'=>array('admin')),
);
?>

<h1>View LikePost #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'post_id',
		'username',
		'updated_time',
		'created_time',
	),
)); ?>
