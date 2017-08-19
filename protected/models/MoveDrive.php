<?php

/**
 * This is the model class for table "__move_drive__".
 *
 * The followings are the available columns in table '__move_drive__':
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $status
 * @property string $detail
 * @property string $link
 * @property string $file_id
 * @property string $file_size
 * @property string $lang
 */
class MoveDrive extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '__move_drive__';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, file_id', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('model, link, file_id', 'length', 'max'=>255),
			array('status,lang', 'length', 'max'=>1),
			array('file_size', 'length', 'max'=>50),
			array('detail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model, model_id, status, detail, link, file_id, file_size', 'safe', 'on'=>'search'),
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
			'model' => 'Model',
			'model_id' => 'Model',
			'status' => 'Status',
			'detail' => 'Detail',
			'link' => 'Link',
			'file_id' => 'File',
			'file_size' => 'File Size',
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
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('file_size',$this->file_size,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MoveDrive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
