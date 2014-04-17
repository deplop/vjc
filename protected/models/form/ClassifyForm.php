<?php


class ClassifyForm extends CFormModel{
	
	public $id;
	public $title;
	public $tags;
	public $categories;
	
	
	
	public function attributeLabel(){
		
		return array(
		
		
		);
	} 
	
	public function rules(){
		
		return array(
			array('id,title, tags, categories','required'),
		
		);
		
	}
	
	
}