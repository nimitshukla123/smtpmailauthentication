<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
error_reporting(0);
$username = 'acousticare@bhlabs.co.uk';
$password = 'K7aqw9~2';
$senderEmail = 'acousticare@bhlabs.co.uk';
$senderName = 'The AcoustiCare Team';

    $recieverMail = $_POST['reciever_email'];
    $recieverName = $_POST['reciever_name'];
    $subject = 'Hearing Test Results';
    $msg = $_POST['message'];
    if (!isset($recieverMail)) {
        $result['status'] = FALSE;
        $result['msg'] = 'Recievers Email not found';
        echo json_encode($result);
                exit(0);
    }
    if (filter_var($_POST['reciever_email'], FILTER_VALIDATE_EMAIL) === false) {
        $result['status'] = FALSE;
        $result['msg'] = 'Recievers Email is not correct';
        echo json_encode($result);exit(0);
    }
    date_default_timezone_set('Etc/UTC');

    require './PHPMailerAutoload.php';

//Create a new PHPMailer instance
    $mail = new PHPMailer;

//Tell PHPMailer to use SMTP
    $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

//Set the hostname of the mail server
    $mail->Host = 'mail.bhlabs.co.uk';
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $username;

//Password to use for SMTP authentication
    $mail->Password = $password;

//Set who the message is to be sent from
    $mail->setFrom($senderEmail, $senderName);

//Set an alternative reply-to address
    $mail->addReplyTo($senderEmail, $senderName);

//Set who the message is to be sent to
    $mail->addAddress($recieverMail, $recieverName);

//Set the subject line
    $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($msg);

//Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//send the message, check for errors
    if (!$mail->send()) {
        $result['status'] = FALSE;
        $result['msg'] = $mail->ErrorInfo;
        echo json_encode($result);exit(0);
    } else {
        $result['status'] = TRUE;
        $result['msg'] = 'Email has been successfully sent';
        echo json_encode($result);exit(0);
    }