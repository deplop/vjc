<?php
/* @var $this LikePostController */
/* @var $model LikePost */

$this->breadcrumbs=array(
	'Like Posts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LikePost', 'url'=>array('index')),
	array('label'=>'Create LikePost', 'url'=>array('create')),
	array('label'=>'View LikePost', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LikePost', 'url'=>array('admin')),
);
?>

<h1>Update LikePost <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>