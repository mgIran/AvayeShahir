<?php

/**
 * This is the model class for table "{{class_category_files}}".
 *
 * The followings are the available columns in table '{{class_category_files}}':
 * @property string $id
 * @property string $title
 * @property string $path
 * @property string $file_type
 * @property string $category_id
 *
 * The followings are the available model relations:
 * @property ClassCategories $category
 */
class ClassCategoryFiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{class_category_files}}';
	}

	/**
	* __set
	*
	* Rewrite default setter, so we can dynamically add
	* new virtual attribtues such as name_en, name_de etc.
	*
	* @param string $name
	* @param string $value
	* @return string
	*/

	public function __set($name, $value)
	{
		if (EMHelper::WinnieThePooh($name, $this->behaviors()))
			$this->{$name} = $value;
		else
			parent::__set($name, $value);
	}


	/**
	* behaviors
	*
	* @return array
	*/

	public function behaviors()
	{
		return array(
			'EasyMultiLanguage'=>array(
				'class' => 'ext.EasyMultiLanguage.EasyMultiLanguageBehavior',
				// @todo Please change those attributes that should be translated.
				'translated_attributes' => array('title'),
				// @todo Please add admin actions
				'admin_routes' => array('/courses/files/create','/courses/files/update'),
				//
				'languages' => Yii::app()->params['languages'],
				'default_language' => Yii::app()->params['default_language'],
				'translations_table' => 'ym_translations',
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, path, file_type, category_id', 'required'),
			array('title, file_type', 'length', 'max'=>50),
			array('path', 'length', 'max'=>500),
			array('category_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, category_id', 'safe'),
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
			'category' => array(self::BELONGS_TO, 'ClassCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		/* @todo if you want admin control panel be multi language active this lines ,otherwise remove it
		return array(
	'id'=>Yii::t('app','id'),
	'title'=>Yii::t('app','title'),
	'path'=>Yii::t('app','path'),
	'file_type'=>Yii::t('app','file_type'),
	'category_id'=>Yii::t('app','category_id'),
		);*/
		return array(
					'id' => 'ID',
					'title' => 'عنوان',
					'path' => 'فایل',
					'file_type' => 'نوع فایل',
					'category_id' => 'گروه',
				);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassCategoryFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}