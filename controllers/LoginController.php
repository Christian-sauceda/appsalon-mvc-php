<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    // Método para iniciar sesión
    public static function login(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            // Revisar si no hay errores en el arreglo de alertas
            if (empty($alertas)) {
                // Verificar si el usuario existe
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    // verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        // Iniciar la sesión
                        if(!isset($_SESSION)) {
                            session_start();
                        };
                        // Crear la sesión
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre.' '.$usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        // Redireccionar
                        if($usuario->admin === '1'){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }                    }
                } else {
                    // Usuario no existe
                    if(Usuario::setAlerta('error', 'Usuario o Password Incorrecto')) {
                    }
                } 
            }
        }
        //obtener alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    // Método para cerrar sesión
    public static function logout() {
        $_SESSION = [];
        header('Location: /');
    }

    // Método para olvidar contraseña
    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if (empty($alertas)) {
                //verificar si el usuario existe
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === '1'){
                    //generar un token único
                    $usuario->generarToken();
                    //guardar en la base de datos
                    $usuario->guardar();
                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarRecuperacion();
                    //mostar mensaje 
                    Usuario::setAlerta('exito', 'Se ha enviado un correo para restablecer tu contraseña');
                } else{
                    Usuario::setAlerta('error', 'El usuario no existe o no ha sido confirmado');
                }
            }
        };
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    // Método para recuperar contraseña
    public static function recuperar(Router $router) {
        //alertas vacias
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        } 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //leer el nuevo password y guardarlo en la base de datos
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)){
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if ($resultado) {
                    Usuario::setAlerta('exito', 'Password Actualizado');
                    header('Location: /');
                }
            } 
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    // Método para crear cuenta
    public static function crear(Router $router) {
        $usuario = new Usuario;
        //alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                //verificar si el usuario existe
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //hashear el password
                    $usuario->hashPassword();
                    //generar un token único
                    $usuario->generarToken();
                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    //crear el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    // Método para confirmar cuenta
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            // mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // confirmar cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }
        // obtener alertas
        $alertas = Usuario::getAlertas();
        // renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }

}
