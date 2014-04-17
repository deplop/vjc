<div class="form"><?php

$form = $this->beginWidget("CActiveForm",
array(
		"id"=>"post-form",
		"enableAjaxValidation"=>false,

));
?>
<?php $this->renderPartial("_postContent",array("model"=>$model));?>

<hr>
<div id="edit-box">

<div class="row"><?php echo $form->labelEx($formModel,"title");?> 
<?php echo $form->textField($formModel,"title",array("size"=>70));?>
<?php echo $form->error($formModel,"title");?>
</div>

<div class=row>
<?php echo $form->labelEx($formModel,"categories");?>
<?php echo $form->checkBoxList($formModel,"categories",Category::model()->getCategories(),array(
'labelOptions'=>array('style'=>'display:inline-block'),
));?>
<?php echo $form->error($formModel,"categories");?>
</div>

<div class="row"><?php
echo $form->labelEx($formModel,"tags");?><div>(các tag bắt đầu bằng 1 dấu "#". Ví dụ: #du học#việc làm#nhà ở)</div><br>
<?php echo $form->textField($formModel,"tags",array("size"=>70));?>
<?php echo $form->error($formModel,"tags");?></div>

</div>

<?php echo $form->hiddenField($formModel,"id",array("value"=>$model->id));?>
<!-- end of edit-box -->


<?php
echo CHtml::ajaxButton ("Update data",
CController::createUrl('post/updateClassify'),
array('update' => '#data',
	  'type'=>'post'));
?>
<?php
$this->endWidget();
?> 

</div>
