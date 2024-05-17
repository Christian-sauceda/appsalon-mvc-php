<?php
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        isAdmin();
        $servicios = Servicio::all();
        $alertas = [];
        
        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicios' => $servicios
        ]);
    }
    public static function crear(Router $router) {
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar(); 
            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
    public static function actualizar(Router $router) {
        isAdmin();
        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($_GET['id']); 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }
    public static function eliminar() {
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_numeric($_POST['id'])) return;
            $servicio = Servicio::find($_POST['id']);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}