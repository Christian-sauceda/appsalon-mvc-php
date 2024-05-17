<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    // Variables
    public $email;
    public $nombre;
    public $token;
    // Constructor
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        //configurar el email
        $mail->setFrom($_ENV['EMAIL_FROM']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<!DOCTYPE html>";
        $contenido .= "<html lang='es'>";
        $contenido .= "<head>";
        $contenido .= "<meta charset='UTF-8'>";
        $contenido .= "<style>";
        $contenido .= "body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }";
        $contenido .= ".container { max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.2); }";
        $contenido .= "p { font-size: 18px; line-height: 1.6; color: #555; }";
        $contenido .= "strong { color: #007bff; }";
        $contenido .= "a { display: inline-block; color: #fff; background-color: #007bff; padding: 12px 24px; margin-top: 20px; text-decoration: none; border-radius: 6px; transition: background-color 0.3s ease; }";
        $contenido .= "a:hover { background-color: #0056b3; }";
        $contenido .= "</style>";
        $contenido .= "</head>";
        $contenido .= "<body>";
        $contenido .= "<div class='container'>";
        $contenido .= "<p><strong>Hola ' . $this->nombre . '</strong>, ¡gracias por unirte a AppSalon!</p>";
        $contenido .= "<p>Para confirmar tu cuenta, haz clic en el siguiente enlace:</p>";
        $contenido .= "<a href='". $_ENV['APP_URL'] . "/confirmar-cuenta?token=' . $this->token . ''>Confirmar Cuenta</a>";
        $contenido .= "<p>Si no has creado una cuenta en AppSalon, por favor ignora este mensaje.</p>";
        $contenido .= "</div>";
        $contenido .= "</body>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        //enviar el email
        $mail->send();
    }

    public function enviarRecuperacion(){
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = $_ENV['EMAIL_HOST'];
                $mail->SMTPAuth = true;
                $mail->Port = $_ENV['EMAIL_PORT'];
                $mail->Username = $_ENV['EMAIL_USER'];
                $mail->Password = $_ENV['EMAIL_PASS'];
                //configurar el email
                $mail->setFrom($_ENV['EMAIL_FROM']);
                $mail->addAddress($this->email, $this->nombre);
                $mail->Subject = 'Reestrablece tu password';
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $contenido = "<!DOCTYPE html>";
                $contenido .= "<html lang='es'>";
                $contenido .= "<head>";
                $contenido .= "<meta charset='UTF-8'>";
                $contenido .= "<style>";
                $contenido .= "body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }";
                $contenido .= ".container { max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.2); }";
                $contenido .= "p { font-size: 18px; line-height: 1.6; color: #555; }";
                $contenido .= "strong { color: #007bff; }";
                $contenido .= "a { display: inline-block; color: #fff; background-color: #007bff; padding: 12px 24px; margin-top: 20px; text-decoration: none; border-radius: 6px; transition: background-color 0.3s ease; }";
                $contenido .= "a:hover { background-color: #0056b3; }";
                $contenido .= "</style>";
                $contenido .= "</head>";
                $contenido .= "<body>";
                $contenido .= "<div class='container''>";
                $contenido .= "<p><strong>Hola ' . $this->nombre . '</strong>, has solicitado Reestablecer tu password</p>";
                $contenido .= "<p>Para Reestablecer tu password, haz clic en el siguiente enlace:</p>";
                $contenido .= "<a href='". $_ENV['APP_URL']."/recuperar?token=' . $this->token . ''>Reestablecer password</a>";
                $contenido .= "<p>Si no has creado una cuenta en AppSalon, por favor ignora este mensaje.</p>";
                $contenido .= "</div>";
                $contenido .= "</body>";
                $contenido .= "</html>";
                $mail->Body = $contenido;
                $mail->send();
    }
}
