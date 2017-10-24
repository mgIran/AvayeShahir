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
        $transactionsModel->model_name ="Classes";

        $totalTransactionsPaidAmount =Yii::app()->db->createCommand()
            ->select('SUM(amount) AS sum')
            ->from('{{user_transactions}}')
            ->where('model_name = "Classes" AND status="paid"')
            ->queryScalar();

        Yii::app()->getModule('orders');
        $orders['new'] = Orders::model()->count('status > 0 AND status = :s', [":s" => Orders::ORDER_STATUS_PENDING]);
        $orders['payment'] = Orders::model()->count('status > 0 AND status = :s', [":s" => Orders::ORDER_STATUS_PAYMENT]);
        $orders['paid'] = Orders::model()->count('status > 0 AND status = :s', [":s" => Orders::ORDER_STATUS_PAID]);
        $orders['done'] = Orders::model()->count('status > 0 AND status = :s', [":s" => Orders::ORDER_STATUS_DONE]);
        $orders['total'] = Orders::model()->count('status > 0');

		$this->render('index',array(
            'transactionsModel' => $transactionsModel,
            'totalTransactionsPaidAmount' => $totalTransactionsPaidAmount,
            'orders' => $orders
        ));
	}

}