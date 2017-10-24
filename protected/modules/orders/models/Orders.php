<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property string $id
 * @property string $title
 * @property string $user_id
 * @property string $done_time
 * @property string $status
 * @property string $order_price
 * @property string $category_id
 * @property string $description
 * @property string $order_priority
 * @property string $create_date
 * @property string $update_date
 * @property string $files
 *
 * The followings are the available model relations:
 * @property OrderFiles[] $orderFiles
 * @property Users $user
 * @property OrderCategories $category
 */
class Orders extends CActiveRecord
{
    /**
     * constant values order priority
     */
    const ORDER_PRIORITY_NORMAL = 'normal';
    const ORDER_PRIORITY_FAST = 'fast';
    /**
     * constant values order status
     */
    const ORDER_STATUS_DELETED = 0;
    const ORDER_STATUS_PENDING = 1;
    const ORDER_STATUS_PAYMENT = 2;
    const ORDER_STATUS_PAID = 3;
    const ORDER_STATUS_DOING = 4;
    const ORDER_STATUS_DONE = 5;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}

    public $files = [];
    
    public $statusLabels = array(
        self::ORDER_STATUS_DELETED => 'حذف شده',
        self::ORDER_STATUS_PENDING => 'در انتظار بررسی',
        self::ORDER_STATUS_PAYMENT => 'در انتظار پرداخت',
        self::ORDER_STATUS_PAID => 'پرداخت شده - در انتظار انجام',
        self::ORDER_STATUS_DOING => 'در حال انجام',
        self::ORDER_STATUS_DONE => 'انجام شده',
    );

    public $statusLabelsEn = array(
        self::ORDER_STATUS_DELETED => 'Deleted',
        self::ORDER_STATUS_PENDING => 'Pending',
        self::ORDER_STATUS_PAYMENT => 'Awaiting Payment',
        self::ORDER_STATUS_PAID => 'Paid - Waiting to do',
        self::ORDER_STATUS_DOING => 'Doing',
        self::ORDER_STATUS_DONE => 'Done',
    );

    public  $orderPriorityLabels = array(
        self::ORDER_PRIORITY_FAST => 'فوری',
        self::ORDER_PRIORITY_NORMAL => 'عادی'
    );

    public  $orderPriorityLabelsEn = array(
        self::ORDER_PRIORITY_FAST => 'Fast',
        self::ORDER_PRIORITY_NORMAL => 'Normal'
    );
    
    public static $acceptedFiles = '.pdf,.doc,.docx,.ppt,.pptx,.zip,.rar';
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, category_id', 'required'),
            array('user_id, order_price, category_id', 'length', 'max'=>10),
            array('title, done_time', 'length', 'max'=>255),
            array('status', 'length', 'max'=>1),
            array('description', 'length', 'max'=>1024),
            array('order_priority', 'length', 'max'=>6),
            array('create_date, update_date', 'default', 'value' => time()),
            array('order_priority', 'default', 'value' => self::ORDER_PRIORITY_NORMAL),
            array('status', 'default', 'value' => self::ORDER_STATUS_PENDING),
            array('create_date, update_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, title, done_time, status, order_price, category_id, description, order_priority, create_date, update_date', 'safe', 'on'=>'search'),
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
            'orderFiles' => array(self::HAS_MANY, 'OrderFiles', 'order_id'),
            'category' => array(self::BELONGS_TO, 'OrderCategories', 'category_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'Order ID'),
			'title' => Yii::t('app', 'Title'),
			'user_id' => Yii::t('app', 'user_id'),
            'done_time' => Yii::t('app', 'Done Time'),
            'status' => Yii::t('app', 'Status'),
            'order_price' => Yii::t('app', 'Order Price'),
            'category_id' => Yii::t('app', 'Category'),
            'description' => Yii::t('app', 'Description'),
            'order_priority' => Yii::t('app', 'Order Priority'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'files' => Yii::t('app', 'Files'),
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

		$criteria = new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('done_time',$this->done_time,true);
        $criteria->compare('status',$this->status,true);
        $criteria->compare('order_price',$this->order_price,true);
        $criteria->compare('category_id',$this->category_id,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('order_priority',$this->order_priority,true);
        if($this->user_id){
            $criteria->with = ['user.userDetails'];
            $criteria->addCondition('userDetails.name LIKE :n OR userDetails.name LIKE :n OR user.email LIKE :n');
            $criteria->params[":n"] = "%{$this->user_id}%";
        }
		$criteria->addCondition('status > 0');
        $criteria->order = 't.create_date';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave()
    {
        $this->update_date = time();
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        parent::afterSave();
        if($this->files){
            $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
            $filesDIR = Yii::getPathOfAlias("webroot") . "/uploads/orders/";
            foreach($this->files as $file){
                if($file && file_exists($tmpDIR.$file)){
                    $fm = new OrderFiles();
                    $fm->filename = $file;
                    $fm->ext = pathinfo($tmpDIR.$file, PATHINFO_EXTENSION);
                    $fm->order_id = $this->id;
                    if(@$fm->save())
                        @rename($tmpDIR.$file, $filesDIR.$file);
                }
            }
        }
    }

    public function getOrderPriorityLabels()
    {
        return [
            self::ORDER_PRIORITY_NORMAL => Yii::t('app', 'Normal'),
            self::ORDER_PRIORITY_FAST => Yii::t('app', 'Fast')
        ];
    }

    public function getOrderPriorityLabel($translate = false)
    {
        if(!$translate)
            return $this->orderPriorityLabels[$this->order_priority];
        return Yii::t('app', $this->orderPriorityLabelsEn[$this->order_priority]);
    }

    public function getStatusLabel($translate = false){
        if(!$translate)
            return $this->statusLabels[$this->status];
        return Yii::t('app', $this->statusLabelsEn[$this->status]);
    }

    public function getOrderPrice()
    {
        if($this->order_price){
            if(Yii::app()->language == 'fa')
                return Controller::parseNumbers(number_format($this->order_price)).' '.Yii::t('app','Toman');
            else
                return number_format($this->order_price).' '.Yii::t('app','Toman');
        }
        return '-';
    }
    
    public function getDoneTime()
    {
        if($this->done_time){
            if(Yii::app()->language == 'fa')
                return Controller::parseNumbers(number_format($this->done_time)).' '.Yii::t('app','Workday(s)');
            else
                return number_format($this->done_time).' '.Yii::t('app','Workday(s)');
        }
        return '-';
    }
}