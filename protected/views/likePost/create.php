<?php
/* @var $this LikePostController */
/* @var $model LikePost */

$this->breadcrumbs=array(
	'Like Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LikePost', 'url'=>array('index')),
	array('label'=>'Manage LikePost', 'url'=>array('admin')),
);
?>

<h1>Create LikePost</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>