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
        $transactionsModel->status ="paid";

        $totalTransactionsPaidAmount =Yii::app()->db->createCommand()
            ->select('SUM(amount) AS sum')
            ->from('{{user_transactions}}')
            ->where('status="paid"')
            ->queryScalar();

		$this->render('index',array(
            'transactionsModel' => $transactionsModel,
            'totalTransactionsPaidAmount' => $totalTransactionsPaidAmount
        ));
	}

}