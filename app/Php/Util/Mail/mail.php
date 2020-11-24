<?php 

require("PHPMailer/PHPMailer.php");
require("PHPMailer/SMTP.php");
require("PHPMailer/Exception.php");
require("PHPMailer/MailProcessing.php");
  
function send($receiver,$subject,$message){

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $senderName="Royal Insurance";

    session_start();

    try { 
        //$mail->SMTPDebug = 2;                                        
        $mail->isSMTP();                                             
        $mail->Host       = 'smtp.hostinger.com';                     
        $mail->SMTPAuth   = true;                              
        $mail->Username   = MailDetail::$senderMailId;                  
        $mail->Password   = MailDetail::$senderPassword;                         
        $mail->SMTPSecure = 'tls';                               
        $mail->Port       = 587;   
      
        $mail->setFrom(MailDetail::$senderMailId, $senderName);            
        $mail->addAddress($receiver);
           
        $mail->isHTML(true);                                   
        $mail->Subject = $subject; 
        $mail->Body    = $message; 
        $mail->send();

        $_SESSION['message']='Mail has been sent successfully';
        return true;
    } catch (Exception $e) { 
        $_SESSION['message']='Sending mail failed';
        return false;
    } 
}

function sendAttachmentMail($subject,$message,$file){
    echo $file;
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    // SMTPDebug turns on error display mssg 
    //$mail->SMTPDebug = 2;
    $mail->isSMTP();                                             
    $mail->Host       = 'smtp.hostinger.com';                     
    $mail->SMTPAuth   = true;                              
    $mail->Username   = MailDetail::$senderMailId;                  
    $mail->Password   = MailDetail::$senderPassword;                         
    $mail->SMTPSecure = 'tls';                               
    $mail->Port       = 587;
    // set subject
    $mail->setFrom(MailDetail::$senderMailId, "Fund Delights");
    $mail->addAddress(MailDetail::$senderMailId);
    $mail->addAttachment($file, 'Proof');

    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    if (!$mail->send()) {
        return false;
    } else {
        unlink($file);
        return true;
    }
}
?>