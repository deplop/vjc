<?php

/**
 * This is the model class for table "tbl_comment".
 *
 * The followings are the available columns in table 'tbl_comment':
 * @property integer $id
 * @property integer $sid
 * @property string $message
 * @property integer $author_id
 * @property integer $author_sid
 * @property integer $post_id
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $type
 * @property string $created_time
 * @property string $updated_time
 */
class Comment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, message, author_id, author_sid, post_id, created_time, updated_time', 'required'),
			array('sid, author_id, author_sid, post_id, like_count, dislike_count, type', 'numerical', 'integerOnly'=>true),
			array('sid','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, message, author_id, author_sid, post_id, like_count, dislike_count, type, created_time, updated_time', 'safe', 'on'=>'search'),
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
			'author_id' => 'Author',
			'author_sid' => 'Author Sid',
			'post_id' => 'Post',
			'like_count' => 'Like Count',
			'dislike_count' => 'Dislike Count',
			'type' => 'Type',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('author_sid',$this->author_sid);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('dislike_count',$this->dislike_count);
		$criteria->compare('type',$this->type);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
