<?php

/**
 * This is the model class for table "{{slideshow}}".
 *
 * The followings are the available columns in table '{{slideshow}}':
 * @property string $id
 * @property string $image
 * @property string $status
 * @property string $order
 * @property string $description
 */
class Slideshow extends SortableCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{slideshow}}';
	}

	public $statusLabels = [
		1 => 'فعال',
		0 => 'غیرفعال'
	];

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
                'translated_attributes' => array('description'),
                'admin_routes' => array('slideshow/manage/create','slideshow/manage/update','slideshow/manage/admin','slideshow/manage/delete','slideshow/manage/changeStatus'),
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
			array('image, status', 'required'),
			array('image', 'length', 'max'=>255),
			array('status', 'length', 'max'=>1),
			array('order', 'length', 'max'=>10),
			array('description', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, status, order', 'safe', 'on'=>'search'),
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
			'image' => 'تصویر',
			'status' => 'وضعیت',
			'order' => 'Order',
			'description' => 'متن تصویر',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('order',$this->order,true);
		$criteria->order = 't.order';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Slideshow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function changeStatus()
    {
        if($this->status == 0)
            $this->status = 1;
        else
            $this->status = 0;
        $this->save(false);
    }
	
	public function getActiveSlides(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = 1');
		$criteria->order = 't.order';
		return $this->findAll($criteria);
	}
}
