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
        $mail->isSMTP(); // Utiliser SMTP
        $mail->Host = 'mail.app.smarttech.local'; // Adresse du serveur SMTP
        $mail->SMTPAuth = true; // Activer l'authentification SMTP
        $mail->Username = 'ndeye@smarttech.local'; // Nom d'utilisateur SMTP
        $mail->Password = 'P@sser123'; // Mot de passe SMTP
        $mail->SMTPSecure = 'tls'; // Chiffrement TLS
        $mail->Port = 587; // Port SMTP

        // Destinataires
        $mail->setFrom('ndeye@smarttech.local', 'ndeye'); // Expéditeur
        $mail->addAddress($to); // Destinataire

        // Contenu de l'e-mail
        $mail->isHTML(true); // Activer le format HTML
        $mail->Subject = $subject; // Sujet de l'e-mail
        $mail->Body = $body; // Corps de l'e-mail (HTML)
        $mail->AltBody = strip_tags($body); // Corps de l'e-mail (texte brut)

        // Envoyer l'e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
    }
}
?>
