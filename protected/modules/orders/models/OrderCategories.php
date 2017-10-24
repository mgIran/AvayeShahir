<?php

/**
 * This is the model class for table "{{order_categories}}".
 *
 * The followings are the available columns in table '{{order_categories}}':
 * @property string $id
 * @property string $title
 * @property string $order
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class OrderCategories extends SortableCActiveRecord
{
	const STATUS_DEACTIVE = 0;
	const STATUS_ACTIVE = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_categories}}';
	}

	public $statusLabels = [
		self::STATUS_ACTIVE => 'فعال',
		self::STATUS_DEACTIVE => 'غیر فعال'
	];

	/* @todo if project is multi language active __set & behavior functions ,otherwise remove it
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
				'admin_routes' => array('orders/categories/create', 'orders/categories/update', 'orders/categories/delete', 'orders/categories/admin'),
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
			array('title', 'length', 'max'=>150),
			array('title', 'unique'),
			array('order', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('id, title, status, order', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'status' => 'وضعیت',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		$criteria->order = 't.order';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function validCategories()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = 1');
		$criteria->order = 't.order';
		return self::model()->findAll($criteria);
	}
}
