<?php

/**
 * This is the model class for table "{{order_files}}".
 *
 * The followings are the available columns in table '{{order_files}}':
 * @property string $id
 * @property string $order_id
 * @property string $title
 * @property string $filename
 * @property string $ext
 * @property string $file_type
 *
 * The followings are the available model relations:
 * @property Orders $order
 */
class OrderFiles extends CActiveRecord
{
	const FILE_TYPE_USER = 1;
	const FILE_TYPE_DONE_FILE = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_files}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filename', 'required'),
			array('order_id', 'length', 'max'=>10),
			array('filename, ext, title', 'length', 'max'=>255),
			array('file_type', 'length', 'max'=>1),
			array('file_type', 'default', 'value'=>self::FILE_TYPE_USER),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, filename, ext, title, file_type', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'سفارش',
			'title' => 'عنوان فایل',
			'filename' => 'نام فایل',
			'ext' => 'پسوند',
			'file_type' => 'نوع فایل',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
