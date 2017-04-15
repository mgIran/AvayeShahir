<?php
/**
 * Extension to Payment  using Sina Bank accounts
 *
 * @author yusef mobasheri <yusef.mobasheri@gmail.com>
 * @license MIT
 * @version 1.0.1
 */

/**
 * How to use
 *
 * You at least need PHP 5.3+ adn cURL.
 *
 * Change your config/main.php to add a new component:
 *
 * 'components' => array
 *(
 *     'SinaPayment' => array
 *    (
 *         'class'    		=> 'ext.SinaPayment.SinaPayment',
 *         'merchantId'     => 'user to login',
 *         'userName'     	=> 'user to login',
 *         'userPassword'   => 'password to login',	// password to web login
 *     )
 * )
 *
 */
class SinaPayment extends CApplicationComponent
{
    // class variable definitions
    public $soapclient;
    public $soapProxy;

    protected $uri = 'https://FCP.shaparak.ir/ref-payment/jax/merchantAuth?wsdl';

    public $terminalId;
    public $merchantId;
    public $userName;
    public $userPassword;


    public $bankAmount;
    public $refNumber;
    public $orderId;
    public $transactionState;

    public $hasError;
    public $errorMsg;

    private $session_id = null;

    public function init()
    {
        require(dirname(__FILE__) . "/lib/nusoap.php");
        $this->soapclient = new nusoap_client($this->uri, 'wsdl');
        $err = $this->soapclient->getError();
        if($err){
            $this->hasError = true;
            $this->errorMsg = 'WebService Error';
        }
    }

    public function LoginRequest()
    {
        $info = new StdClass();
        $info->username = $this->userName;
        $info->password = $this->userPassword;
        $loginResponse = $this->soapclient->call('login', array('loginRequest' => $info));
        // Check for a fault

        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - AUTHENTIFICATION)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                if(isset($loginResponse['return']))
                    $this->session_id = $loginResponse['return'];
            }
        }
    }

    public function VerifyRequest()
    {
        $context = $this->makeContext();
        $requestInfo = new StdClass();
        $requestInfo->refNumList = $_POST['RefNum'];
        $verifyParams = array(
            'context' => $context,
            'verifyRequest' => $requestInfo
        );
        $verifyResponse = $this->soapclient->call("verifyTransaction", $verifyParams);
        // Check for a fault
        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - VERIFICATION)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                // Display the error
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                $this->refNumber = $verifyResponse['return']['verifyResponseResults']['refNum'];
                if(isset($verifyResponse['return']['verifyResponseResults']['amount']))
                    $this->bankAmount = $verifyResponse['return']['verifyResponseResults']['amount'];
            }
        }
        $this->LogoutRequest();
        return $verifyResponse;
    }

    public function ReverseRequest($amount, $resNum)
    {
        $context = $this->makeContext();
        $reverseParams = array(
            'context' => $context,
            'reverseRequest' => array('amount' => $amount,
                'mainTransactionRefNum' => $this->refNumber,
                'reverseTransactionResNum' => $resNum)
        );
        $reverseResponse = $this->soapclient->call('reverseTransaction', $reverseParams);

        // Check for a fault
        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - REVERSE)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                // Display the result
            }
        }
        $this->LogoutRequest();
        return $reverseResponse;
    }

    public function ReportRequest($offset, $length, $transState, $transType, $orderField, $orderType, $onlyReversed)
    {
        $context = $this->makeContext();
        $reportParams = array(
            'context' => $context,
            'reportRequest' => array('refNum' => $this->refNumber,
                'offset' => $offset,
                'length' => $length,
                'transactionState' => $transState,
                'transactionType' => $transType,
                'orderField' => $orderField,
                'orderType' => $orderType,
                'onlyReversed' => $onlyReversed)
        );
        $reportResponse = $this->soapclient->call('reportTransaction', $reportParams);

        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - REPORT)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                // Display the result
            }
        }
        $this->LogoutRequest();
        return $reportResponse;
    }

    public function DetailReportRequest($id)
    {
        $context = $this->makeContext();
        $detailReportParams = array(
            'context' => $context,
            'detailReportRequest' => array('mainTransactionId' => $id,
                'offset' => 0,
                'length' => 10,
                'orderField' => 'TRANSACTION_TIME',
                'orderType' => 'DESC')
        );
        $detailReportResponse = $this->soapclient->call('detailReportTransaction', $detailReportParams);

        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - DETAIL REPORT)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                // Display the result
            }
        }
        $this->LogoutRequest();
        return $detailReportResponse;
    }

    public function LogoutRequest()
    {
        $context = new stdClass();
        $context->data = new stdClass();
        $context->data->entry = array('key' => 'SESSION_ID', 'value' => $this->session_id);
        $this->soapclient->call('logout', array('context' => $context));
        $this->session_id = null;

        if($this->soapclient->fault){
            $this->hasError = true;
            $this->errorMsg = 'Fault (Expect - LOGOUT)';
        }else{
            // Check for errors
            $err = $this->soapclient->getError();
            if($err){
                $this->hasError = true;
                $this->errorMsg = $err;
            }else{
                // Display the result
            }
        }
        return true;
    }

    public function makeContext()
    {
        $this->LoginRequest();
        $context = new stdClass();
        $context->data = new stdClass();
        $context->data->entry = array('key' => 'SESSION_ID', 'value' => $this->session_id);
        return $context;
    }

    public function getMID()
    {
        return $this->merchantId;
    }


    public function RequestUnPack()
    {
        if($this->RequestFieldIsEmpty()) return false;
        $this->refNumber = $_POST['RefNum'];
        $this->orderId = $_POST["ResNum"];
        $this->transactionState = $_POST["State"];
        return true;
    }

    public function RequestFieldIsEmpty()
    {

        if(empty($_POST["State"])){
            $this->hasError = true;
            $this->errorMsg = "خريد شما توسط بانک تاييد شده است اما رسيد ديجيتالي شما تاييد نگشت! مشکلي در فرايند رزرو خريد شما پيش آمده است";
            return true;
        }
        if((empty($_POST["RefNum"])) && (empty($_POST["State"]))){
            $this->hasError = true;
            $this->errorMsg = "فرايند انتقال وجه با موفقيت انجام شده است اما فرايند تاييد رسيد ديجيتالي با خطا مواجه گشت";
            return true;
        }

        if((empty($_POST["ResNum"])) && (empty($_POST["RefNum"]))){
            $this->hasError = true;
            $this->errorMsg = "خطا در برقرار ارتباط با بانک";
            return true;
        }
        return false;
    }

    public function getError()
    {
        return $this->errorMsg;
    }
}