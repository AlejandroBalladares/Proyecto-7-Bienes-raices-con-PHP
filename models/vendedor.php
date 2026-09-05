<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido','telefono'];

    public int $id;
    public string $nombre;
    public string $apellido;
    public int $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::$errores[] = "Debe agregar un nombre";
        }
        if(!$this->apellido){
            self::$errores[] = "Debe agregar un apellido";
        }
        if(!$this->telefono){
            self::$errores[] = "Debe agregar un telefono";
        }
        if(!preg_match('/[0-9]{10}/',$this->telefono)){
            self::$errores[] = "Debe agregar un telefono valido";
        
        }
        
        return self::$errores;
    }
}