<?php

/**
 * This is the model class for table "ym_users".
 *
 * The followings are the available columns in table 'ym_users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role_id
 * @property string $status
 * @property string $verification_token
 * @property integer $change_password_request_count
 * @property string $repeatPassword
 * @property string $oldPassword
 * @property string $newPassword
 * @property string $fullName
 * @property string $create_date
 * @property string $order
 * @property string $name
 * @property string $family
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property UserDetails $userDetails
 * @property TeacherDetails $teacherDetails
 * @property UserRoles $role
 * @property UserTransactions $register
 */
class Users extends SortableCActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{users}}';
    }

    public $statusLabels = array(
        'pending' => 'در انتظار تایید',
        'active' => 'فعال',
        'blocked' => 'مسدود',
        'deleted' => 'حذف شده'
    );
    public $fullName;
    public $statusFilter;
    public $repeatPassword;
    public $oldPassword;
    public $newPassword;
    public $roleId;
    public $agreeTerms;
    public $phone;

    public $name;
    public $family;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password, email', 'required', 'on' => 'insert,agreeTerms,ajaxInsert'),
            array('name, family, phone', 'required', 'on' => 'ajaxInsert'),
            array('agreeTerms', 'compare', 'compareValue' => 1, 'operator' => '==', 'message' => Yii::t('app', 'You Rejected the Terms and Policies'), 'on' => 'agreeTerms'),
            array('email', 'unique', 'on' => 'insert,create,agreeTerms,ajaxInsert'),
            array('change_password_request_count', 'numerical', 'integerOnly' => true),
            array('role_id', 'default', 'value' => 1, 'on' => 'insert,agreeTerms,ajaxInsert'),
            array('status', 'default', 'value' => 1, 'on' => 'insert,agreeTerms'),
            array('status', 'default', 'value' => 2, 'on' => 'ajaxInsert'),
            array('email', 'required', 'on' => 'email'),
            array('email', 'email'),
            array('oldPassword ,newPassword ,repeatPassword', 'required', 'on' => 'update'),
            array('email', 'filter', 'filter' => 'trim', 'on' => 'insert,agreeTerms,ajaxInsert'),
            array('username, password, verification_token', 'length', 'max' => 100, 'on' => 'insert,agreeTerms'),
            array('oldPassword', 'oldPass', 'on' => 'update'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'operator' => '==', 'message' => 'رمز های عبور همخوانی ندارند', 'on' => 'update'),
            array('email', 'length', 'max' => 255),
            array('role_id', 'length', 'max' => 10),
            array('status', 'length', 'max' => 8),
            array('phone', 'length', 'min' => 11, 'on' => 'agreeTerms,ajaxInsert'),
            array('name, family', 'length', 'max' => 50, 'on' => 'ajaxInsert'),
            array('create_date', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('fullName ,email ,statusFilter,phone, create_date, verification_token, change_password_request_count', 'safe', 'on' => 'search,searchTeachers'),
        );
    }

    /**
     * Check this username is exist in database or not
     */
    public function oldPass($attribute, $params)
    {
        $bCrypt = new bCrypt();
        $record = Users::model()->findByAttributes(array('email' => $this->email));
        if(!$bCrypt->verify($this->$attribute, $record->password))
            $this->addError($attribute, 'رمز عبور فعلی اشتباه است');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userDetails' => array(self::BELONGS_TO, 'UserDetails', 'id'),
            'teacherDetails' => array(self::BELONGS_TO, 'TeacherDetails', 'id'),
            'role' => array(self::BELONGS_TO, 'UserRoles', 'role_id'),
            'register' => array(self::HAS_ONE, 'UserTransactions', 'user_id', 'on' => 'register.model_name = "Classes" AND register.status = "paid"'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'role_id' => 'نقش',
            'repeatPassword' => Yii::t('app', 'Repeat Password'),
            'oldPassword' => Yii::t('app', 'Current Password'),
            'newPassword' => Yii::t('app', 'New Password'),
            'status' => 'وضعیت کاربر',
            'verification_token' => 'Verification Token',
            'change_password_request_count' => 'تعداد درخواست تغییر کلمه عبور',
            'name' => 'نام',
            'family' => 'نام خانوادگی',
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

        $criteria = new CDbCriteria;
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role_id', 1);
        $criteria->compare('status', $this->statusFilter, true);
        $criteria->order = 'status ,t.id DESC';
        $criteria->addSearchCondition('userDetails.phone', $this->phone);
        $criteria->with = array('userDetails');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchTeachers()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('email', $this->email, true);
        $criteria->addSearchCondition('teacherDetails.name', $this->fullName, true, 'OR', "LIKE");
        $criteria->addSearchCondition('teacherDetails.family', $this->fullName, true, 'OR', "LIKE");
        $criteria->with = array('teacherDetails');
        $criteria->addCondition('role_id = 2');
        $criteria->order = 't.order';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterValidate()
    {
        $this->password = $this->encrypt($this->password);
        return parent::afterValidate();
    }

    public function encrypt($value)
    {
        $enc = NEW bCrypt();
        return $enc->hash($value);
    }

    public function afterSave()
    {
        if($this->isNewRecord){
            if($this->role_id == 1){
                $model = new UserDetails;
                $model->user_id = $this->id;
                $model->name = $this->name && !empty($this->name)?$this->name:null;
                $model->family = $this->family && !empty($this->family)?$this->family:null;
                $model->phone = $this->phone && !empty($this->phone)?$this->phone:null;
                $model->save(false);
            }elseif($this->role_id == 2){
                $model = new TeacherDetails();
                $model->user_id = $this->id;
                $model->save(false);
            }
        }
        parent::afterSave();
    }
}