<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sid')); ?>:</b>
	<?php echo CHtml::encode($data->sid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('about_you')); ?>:</b>
	<?php echo CHtml::encode($data->about_you); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locale')); ?>:</b>
	<?php echo CHtml::encode($data->locale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jlpt')); ?>:</b>
	<?php echo CHtml::encode($data->jlpt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('like_count')); ?>:</b>
	<?php echo CHtml::encode($data->like_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dislike_count')); ?>:</b>
	<?php echo CHtml::encode($data->dislike_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quotation')); ?>:</b>
	<?php echo CHtml::encode($data->quotation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_image')); ?>:</b>
	<?php echo CHtml::encode($data->profile_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mask_name')); ?>:</b>
	<?php echo CHtml::encode($data->mask_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hometown')); ?>:</b>
	<?php echo CHtml::encode($data->hometown); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('living')); ?>:</b>
	<?php echo CHtml::encode($data->living); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_time')); ?>:</b>
	<?php echo CHtml::encode($data->updated_time); ?>
	<br />

	*/ ?>

</div>