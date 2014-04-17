<?php
/* @var $this LikePostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Like Posts',
);

$this->menu=array(
	array('label'=>'Create LikePost', 'url'=>array('create')),
	array('label'=>'Manage LikePost', 'url'=>array('admin')),
);
?>

<h1>Like Posts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
