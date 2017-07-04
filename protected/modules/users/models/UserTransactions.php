<?php

/**
 * This is the model class for table "ym_user_transactions".
 *
 * The followings are the available columns in table 'ym_user_transactions':
 * @property string $class_id
 * @property string $user_id
 * @property string $amount
 * @property string $date
 * @property string $status
 * @property string $description
 * @property string $order_id
 * @property string $ref_id
 * @property string $res_code
 * @property string $sale_reference_id
 * @property string $settle
 * @property string $verbal
 * @property string $gateway
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Classes $class
 */
class UserTransactions extends CActiveRecord
{
	const GATEWAY_MELLAT = 1;
	const GATEWAY_SINA = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_transactions}}';
	}

	public $verbalLabels = array(
		0 => 'ثبت نام اینترنتی',
		1 => 'ثبت نام حضوری'
	);

	public $gatewayLabels = array(
		self::GATEWAY_MELLAT => 'بانک ملت',
		self::GATEWAY_SINA => 'بانک سینا'
	);

	public $verbalFilter;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, class_id', 'required'),
			array('order_id', 'unique'),
			array('settle', 'default', 'value' => 0),
			array('user_id, amount', 'length', 'max' => 10),
			array('order_id', 'length', 'max' => 12),
			array('date', 'length', 'max' => 20),
			array('gateway', 'length', 'max' => 15),
			array('status', 'length', 'max' => 6),
			array('res_code', 'length', 'max' => 5),
			array('sale_reference_id, ref_id', 'length', 'max' => 50),
			array('description', 'length', 'max' => 1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gateway, class_id, verbalFilter, user_id, amount, date, status, sale_reference_id, description, order_id, ref_id, settle', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'class' => array(self::BELONGS_TO, 'Classes', 'class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'class_id' => 'کلاس',
			'user_id' => 'کاربر',
			'amount' => 'مقدار',
			'date' => 'تاریخ',
			'status' => 'وضعیت',
			'sale_reference_id' => 'کد رهگیری تراکنش',
			'description' => 'توضیحات',
			'order_id' => 'شماره فاکتور',
			'verbal' => 'نوع ثبت نام',
			'gateway' => 'درگاه',
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

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('description', $this->description,true);
		$criteria->compare('sale_reference_id', $this->sale_reference_id);
		$criteria->compare('verbal', $this->verbalFilter);
		$criteria->order = 'date DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 20)
		));
	}

	public function searchCount()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('description', $this->description,true);
		$criteria->compare('sale_reference_id', $this->sale_reference_id);
		$criteria->compare('verbal', $this->verbalFilter);
		$criteria->order = 'date DESC';
		return $this->count($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserTransactions the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord){
				$this->newOrderId();
			}
			return true;
		}else
			return false;
	}

	/**
	 * create unique order id for any transaction
	 */
	public function newOrderId()
	{
		$lastOrderId = Yii::app()->db->createCommand()
			->select("MAX(order_id) as max")
			->from("{{user_transactions}}")
			->queryScalar();
		if($this->order_id && $this->order_id <= $lastOrderId)
			$this->order_id = (int)$lastOrderId + 10;
		elseif(!$this->order_id){
			if($lastOrderId)
				$this->order_id = (int)$lastOrderId + 10;
			else
				$this->order_id = 1100;
		}
	}

	public function getHtmlAmount()
	{
		if($this->amount != 0)
			$html = Yii::app()->language == 'fa'?Controller::parseNumbers(number_format($this->amount)) . Yii::t('app', "Toman"):number_format($this->amount) . Yii::t('app', "Toman");
		else
			$html = Yii::t('app', "Free");
		return $html;
	}

	public function getGatewayLabel()
	{
		return $this->gatewayLabels[$this->gateway];
	}
}