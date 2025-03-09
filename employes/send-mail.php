<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/smarttech/vendor/PHPMailer/src/Exception.php';
require '/var/www/html/smarttech/vendor/PHPMailer/src/PHPMailer.php';
require '/var/www/html/smarttech/vendor/PHPMailer/src/SMTP.php';

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.app.smarttech.local'; // Adresse du serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'ndeye@smarttech.local'; // Nom d'utilisateur SMTP
        $mail->Password = 'P@sser123'; // Mot de passe SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataires
        $mail->addAddress($to);

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        // Envoyer l'e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
    }
}
?>
