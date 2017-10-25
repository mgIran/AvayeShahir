<?php
class Mailer
{

    public $host = 'mail.avayeshahir.com';
    public $username = 'noreply@avayeshahir.com';
    public $password = '!@avayeshahir1395';
    public $port = '587';
    public $secure = '';

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $from
     * @param array $SMTP
     * @param null $attachment
     * @return bool
     * @throws CException
     * @throws phpmailerException
     */
    public function mail($to, $subject, $message, $from, $SMTP = array(), $attachment = NULL)
    {
        $mail_theme = Yii::app()->params['mailTheme'];
        $message = str_replace('{MessageBody}', $message, $mail_theme);
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        if($SMTP && isset($SMTP['Host']) && isset($SMTP['Secure']) && isset($SMTP['Username']) && isset($SMTP['Password']) && isset($SMTP['Port'])){
            $mail->Host = $SMTP['Host'];
            $mail->SMTPSecure = $SMTP['Secure'];
            $mail->Username = $SMTP['Username'];
            $mail->Password = $SMTP['Password'];
            $mail->Port = (int)$SMTP['Port'];
            $mail->SetFrom($from, Yii::app()->name);
        }else{
            $mail->Host = $this->host;
            $mail->SMTPSecure = $this->secure;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->Port = (int)$this->port;
            $mail->SetFrom($this->username, Yii::app()->name);
        }
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        if(is_array($to))
            foreach($to as $address)
                $mail->AddAddress($address);
        else
            $mail->AddAddress($to);
        if($attachment)
            $mail->AddAttachment($attachment);
        return $mail->Send();
    }
}