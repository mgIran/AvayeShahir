<?php

class AdminsDashboardController extends Controller
{

    /**
     * @return array action filters
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess', // perform access control for CRUD operations
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