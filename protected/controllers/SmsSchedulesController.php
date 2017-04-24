<?php

class SmsSchedulesController extends Controller
{
	public function actionSend()
	{
		$floorTime = strtotime(date('Y/m/d', time()).' 00:00');
		$ceilTime = $floorTime + 86400;

		$criteria = new CDbCriteria();
		$criteria->addCondition('send_date <= :ceil AND status = 0');
		$criteria->params[':ceil'] = $ceilTime;
		$schedules = SmsSchedules::model()->findAll($criteria);
		foreach($schedules as $schedule){
			$sms = new SendSMS();
			$receivers = CJSON::decode($schedule->receivers);
			foreach($receivers as $receiver){
				$sms->AddNumber($receiver);
				$sms->AddMessage($schedule->text);
			}
			$response = $sms->SendWithLine();
			if(empty($response->message)){
				$responses = CJSON::encode($response->SendMessageWithLineNumberResult->long);
				$schedule->responses = $responses;
				$schedule->status = SmsSchedules::SEND_SUCCESSFUL;
			}else
				$schedule->status = $response->message;
			$result[]=$schedule->save();
		}
		var_dump($result);
		Yii::app()->end();
	}
}