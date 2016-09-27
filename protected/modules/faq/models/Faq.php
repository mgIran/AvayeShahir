<?php

/**
 * This is the model class for table "{{faq}}".
 *
 * The followings are the available columns in table '{{faq}}':
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property string $body
 * @property string $order
 *
 * The followings are the available model relations:
 * @property FaqCategories $category
 */
class Faq extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{faq}}';
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
				'translated_attributes' => array('title' ,'body'),
				'admin_routes' => array('faq/manage/create','faq/manage/update','faq/manage/admin','faq/manage/delete'),
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
			array('category_id, title, body', 'required'),
			array('category_id, order', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, title, body, order', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'FaqCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('Faq.app','ID'),
			'category_id' => 'دسته بندی',
			'category' => 'دسته بندی',
			'title' => 'عنوان',
			'body' => "متن",
			'order' => 'ترتیب',
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
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('order',$this->order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
