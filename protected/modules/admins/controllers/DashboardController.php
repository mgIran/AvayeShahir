<?php

class DashboardController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'views' actions
                'actions'=>array('index'),
                'roles' => array('admin'),
                //'roles'=>array('admin','validator'),
            ),
            array('deny',  // deny all users
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
    {
        $transactionsModel=new UserTransactions('search');
        $transactionsModel->unsetAttributes();
        if(isset($_GET['UserTransactions']))
            $transactionsModel->attributes=$_GET['UserTransactions'];
        $criteria = new CDbCriteria;
        $criteria->addCondition('status = "paid"');
        $criteria->compare('sale_reference_id', $transactionsModel->sale_reference_id);
        $criteria->compare('verbal', $transactionsModel->verbalFilter);
        $criteria->order = 'date DESC';
        $transactionsPaid = new CActiveDataProvider($transactionsModel, array(
            'criteria' => $criteria,
        ));

        $totalTransactionsPaidAmount =Yii::app()->db->createCommand()
            ->select('SUM(amount) AS sum')
            ->from('{{user_transactions}}')
            ->where('status="paid"')
            ->queryScalar();

		$this->render('index',array(
            'transactionsPaid' => $transactionsPaid,
            'totalTransactionsPaidAmount' => $totalTransactionsPaidAmount
        ));
	}

}