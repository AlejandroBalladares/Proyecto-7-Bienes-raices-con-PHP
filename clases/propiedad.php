<?php 

namespace App;

class Propiedad {

//base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo','precio','imagen','descripcion','habitaciones','wc','estacionamiento','creado','vendedorId'];
    
    //Errores
    protected static $errores = [];
    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

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
        $this->vendedorId = $args['vendedorId'] ?? 1;
    
    }

    public function guardar(){
        if ($this->id) {
            //Actualizar
            $this->actualizar();
        } else{
            //Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear(){

        //sanitizar datos
        $atributos = $this->sanitizarDatos();

        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        //debuguear($query);
        $resultado = self::$db->query($query);
    }

    public function actualizar(){
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        //debuguear($valores);
        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id). "' ";
        $query .= "LIMIT 1";
        //debuguear($query);
        $resultado = self::$db->query($query);
        if($resultado){
            header('Location: /admin?resultado=2');
        }
    }

    //definir conexion a la db
    public static function setDB($database){
        self::$db = $database;
    }

    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //validacion
    public static function getErrores(){
        return self::$errores;
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

    public function setImagen($imagen){
        if(isset($this->id)){
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Listar todas las propiedades
    public static function all(){
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return $resultado[0];
    }

    public static function consultarSQL($query){
        $resultado = self::$db->query($query);

        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    public static function crearObjeto($registro){
        $objeto = new Self;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}