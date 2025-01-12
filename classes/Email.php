<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email implements Observer{
    public function notify($event, $data) {
        if ($event === 'user_registered') {
            $this->sendConfirmation($data);
        } elseif ($event === 'password_reset') {
            $this->sendRecover($data);
        }
    }

    public function sendConfirmation($data){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'ssl';

        $mail->setFrom($_ENV['EMAIL_USER'], 'PJSolutions.com');
        $mail->addAddress($data['email']); // Email from user
        $mail->Subject = 'Confirma Tu Cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $data['name'] . "!</strong>";
        $content .= " Gracias por crear una cuenta en PJ Solutions, por favor verifícala utilizando el siguiente enlace:</p>";
        $content .= "<p>Click Aquí: <a href='" . $_ENV['APP_URL'] . "/verificar?token=" . $data['token'] . "'>Verificar cuenta</a></p>";
        $content .= "<p> Si no has creado una cuenta, ignora este mensaje</p>";
        $content .= "</html>";

        
        $mail->Body = $content;
        $mail->send();
    }

    public function sendRecover($data){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'ssl';

        $mail->setFrom($_ENV['EMAIL_USER'], 'PJSolutions.com');
        $mail->addAddress($data['email']); // Email from user
        $mail->Subject = 'Cambia Tu Contraseña';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $data['name'] . "!</strong>";
        $content .= " Tu solicitud de cambio de contraseña ha sido procesada, da click en el siguiente enlace para modificarla:</p>";
        $content .= "<p>Click Aquí: <a href='" . $_ENV['APP_URL'] . "/reset?token=" . $data['token'] . "'>Cambia tu contraseña</a></p>";
        $content .= "<p> Si no has solicitado este cambio, ignora este correo.</p>";
        $content .= "</html>";

        $mail->Body = $content;
        $mail->send();
    }


}