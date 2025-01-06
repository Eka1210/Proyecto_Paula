<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $name;
    public $token;

    public function __construct($email, $name, $token){
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'ssl';

        $mail->setFrom($_ENV['EMAIL_USER'], 'PJSolutions.com');
        $mail->addAddress($this->email); // Email from user
        $mail->Subject = 'Confirma Tu Cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "!</strong>";
        $content .= " Gracias por crear una cuenta en PJ Solutions, por favor verifícala utilizando el siguiente enlace:</p>";
        $content .= "<p>Click Aquí: <a href='" . $_ENV['APP_URL'] . "/verificar?token=" . $this->token . "'>Verificar cuenta</a></p>";
        $content .= "<p> Si no has creado una cuenta, ignora este mensaje</p>";
        $content .= "</html>";

        $mail->Body = $content;
        $mail->send();
    }

    public function sendRecover(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'ssl';

        $mail->setFrom($_ENV['EMAIL_USER'], 'PJSolutions.com');
        $mail->addAddress($this->email); // Email from user
        $mail->Subject = 'Cambia Tu Contraseña';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "!</strong>";
        $content .= " Tu solicitud de cambio de contraseña ha sido procesada, da click en el siguiente enlace para modificarla:</p>";
        $content .= "<p>Click Aquí: <a href='" . $_ENV['APP_URL'] . "/reset?token=" . $this->token . "'>Cambia tu contraseña</a></p>";
        $content .= "<p> Si no has solicitado este cambio, ignora este correo.</p>";
        $content .= "</html>";

        $mail->Body = $content;
        $mail->send();
    }


}