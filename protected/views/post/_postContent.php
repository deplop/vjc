
<div id="post-content-box">

<div id="author-box">

<div id="author-image">
<?php 
$profile_image=Yii::app()->getBaseUrl(true)."/images/profile_s/".$model->author->id.".jpeg";
if(!file_exists($profile_image)){
	$profile_image=Yii::app()->getBaseUrl(true)."/images/profile_s/default.jpeg";
}
echo CHtml::image($profile_image,$model->author->id,array("width"=>"40px","height"=>"40px"));
?>
</div>
<div id="author-name">

<?php echo CHtml::link($model->author->username,array("http://www.google.com/"));?>
</div>

</div>
<div>

<div><?php 
echo CHtml::encode($model->message);
echo "<br />";
?></div>

<div><?php echo CHtml::link($model->link,$model->link);?><br>
<?php if(isset($model->picture))echo CHtml::image($model->picture,$model->message,array("width"=>"100px","height"=>"100px"))?>
</div>

<div>

<?php echo $model->author_id;?>

</div>

<div>
<?php echo $model->id;?>
</div>
</div>
</div>
<!-- end of post-content-box -->






