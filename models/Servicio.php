<?php

namespace Model;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];
    // Variables
    public $id;
    public $nombre;
    public $precio;
    // Constructor
    public function __construct($args = [])
    {   // Asignar los valores
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    // Validacion
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Debes añadir un nombre';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'Debes añadir un precio';
        }
        if($this->precio < 0) {
            self::$alertas['error'][] = 'El precio debe ser mayor a 0';
        }
        if(!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio debe ser un numero';
        }
        return self::$alertas;
    }
}