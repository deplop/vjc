<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $sid
 * @property string $phone
 * @property string $email
 * @property integer $gender
 * @property string $about_you
 * @property integer $locale
 * @property integer $jlpt
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $level
 * @property string $quotation
 * @property string $profile_image
 * @property string $mask_name
 * @property string $birthday
 * @property string $hometown
 * @property string $living
 * @property string $link
 * @property integer $type
 * @property integer $active
 * @property string $created_time
 * @property string $updated_time
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, created_time, updated_time', 'required'),
			array('gender, locale, jlpt, like_count, dislike_count, level, type, active', 'numerical', 'integerOnly'=>true),
			array('username, password, phone, email, profile_image, hometown, living', 'length', 'max'=>128),
			array('sid', 'length', 'max'=>16),
			array('mask_name', 'length', 'max'=>32),
			array('link', 'length', 'max'=>256),
			array('sid','unique'),
			array('about_you, quotation, birthday', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, sid, phone, email, gender, about_you, locale, jlpt, like_count, dislike_count, level, quotation, profile_image, mask_name, birthday, hometown, living, link, type, active, created_time, updated_time', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'sid' => 'Sid',
			'phone' => 'Phone',
			'email' => 'Email',
			'gender' => 'Gender',
			'about_you' => 'About You',
			'locale' => 'Locale',
			'jlpt' => 'Jlpt',
			'like_count' => 'Like Count',
			'dislike_count' => 'Dislike Count',
			'level' => 'Level',
			'quotation' => 'Quotation',
			'profile_image' => 'Profile Image',
			'mask_name' => 'Mask Name',
			'birthday' => 'Birthday',
			'hometown' => 'Hometown',
			'living' => 'Living',
			'link' => 'Link',
			'type' => 'Type',
			'active' => 'Active',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('about_you',$this->about_you,true);
		$criteria->compare('locale',$this->locale);
		$criteria->compare('jlpt',$this->jlpt);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('dislike_count',$this->dislike_count);
		$criteria->compare('level',$this->level);
		$criteria->compare('quotation',$this->quotation,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('mask_name',$this->mask_name,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('hometown',$this->hometown,true);
		$criteria->compare('living',$this->living,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('active',$this->active);
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
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
