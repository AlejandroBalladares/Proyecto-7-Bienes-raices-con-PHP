<?php 

namespace Model;

use Model\ActiveRecord as ActiveRecord;

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo','precio','imagen','descripcion','habitaciones','wc','estacionamiento','creado','vendedorId'];
    
    public int $id;
    public string $titulo;
    public int $precio;
    public string  $imagen;
    public string $descripcion;
    public int $habitaciones;
    public int $wc;
    public int $estacionamiento;
    public $creado;
    public int $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    
    }

    public function validar(){
         if(!$this->titulo){
            self::$errores[] = "Debe agregar un titulo";
        }
        if(!$this->precio){
            self::$errores[] = "Debe agregar un precio";
        }
        if(strlen($this->descripcion) <= 10){
            self::$errores[] = "La descripcion debe ser obligatoria y tener más de 10 caracteres";
        }
        if(!$this->wc){
            self::$errores[] = "Debe agregar unos wc";
        }
        if(!$this->estacionamiento){
            self::$errores[] = "Debe agregar un estacionamiento";
        }
        if(!$this->vendedorId){
            self::$errores[] = "Debe agregar un vendedor";
        }

        if(!$this->imagen){
            self::$errores[] = "La imagen es obligatoria";
        }
        return self::$errores;
    }
}