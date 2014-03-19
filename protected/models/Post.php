<?php

/**
 * This is the model class for table "tbl_post".
 *
 * The followings are the available columns in table 'tbl_post':
 * @property string $id
 * @property string $sid
 * @property string $message
 * @property string $title
 * @property string $author_id
 * @property string $author_sid
 * @property integer $like_count
 * @property integer $dislike_count
 * @property string $picture
 * @property string $link
 * @property integer $type
 * @property string $last_comment_time
 * @property string $updated_time
 * @property string $created_time
 */
class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, message, title, author_id, author_sid, last_comment_time, updated_time, created_time', 'required'),
			array('like_count, dislike_count, type', 'numerical', 'integerOnly'=>true),
			array('sid, author_id, author_sid', 'length', 'max'=>20),
			array('title, picture, link', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, message, title, author_id, author_sid, like_count, dislike_count, picture, link, type, last_comment_time, updated_time, created_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sid' => 'Sid',
			'message' => 'Message',
			'title' => 'Title',
			'author_id' => 'Author',
			'author_sid' => 'Author Sid',
			'like_count' => 'Like Count',
			'dislike_count' => 'Dislike Count',
			'picture' => 'Picture',
			'link' => 'Link',
			'type' => 'Type',
			'last_comment_time' => 'Last Comment Time',
			'updated_time' => 'Updated Time',
			'created_time' => 'Created Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('author_sid',$this->author_sid,true);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('dislike_count',$this->dislike_count);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('last_comment_time',$this->last_comment_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
