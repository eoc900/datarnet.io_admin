<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__.'/../../vendor/autoload.php';

class Email{

public function sendEmail($titulo,$html_mensaje,$mensajeNoHtml,$email, $nombreUsuario){

        $mail = new PHPMailer(true);
        try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sistema@cegto.com.mx';                     //SMTP username
        $mail->Password   = 'hLOrgjkehlg_VX0@!';                               //SMTP password
        $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('sistema@cegto.com.mx', 'Centro de Estudios');
        $mail->addAddress($email, $nombreUsuario);     //Add a recipient

        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $titulo;
        $mail->Body    = $html_mensaje;
        $mail->AltBody = $mensajeNoHtml;

        if($mail->Send()){
            return true;
        }
            return false;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

        return false;

}
public function enviarDocumentoPdf($titulo="",$html_mensaje="",$mensajeNoHtml="",$email="",$nombreUsuario="",$pdfContent=""){
 $mail = new PHPMailer(true);
        try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sistema@cegto.com.mx';                     //SMTP username
        $mail->Password   = 'hLOrgjkehlg_VX0@!';                               //SMTP password
        $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('sistema@cegto.com.mx', 'Centro de Estudios');
        $mail->addAddress($email, $nombreUsuario);     //Add a recipient

        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $titulo;
        $mail->Body    = $html_mensaje;
        $mail->AltBody = $mensajeNoHtml;
        $mail->addStringAttachment($pdfContent, 'cuenta.pdf');

        if($mail->Send()){
            return true;
        }
        return false;

        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

        return false;
}


}



?>