<?php

namespace App;

class ActiveRecord {
    
    //base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores
    protected static $errores = [];
    
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

        $query = "INSERT INTO ". static::$tabla ." (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        //debuguear($query);
        $resultado = self::$db->query($query);
        if($resultado){
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar(){
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        //debuguear($valores);
        $query = "UPDATE ". static::$tabla ." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id). "' ";
        $query .= "LIMIT 1";
        //debuguear($query);
        $resultado = self::$db->query($query);
        if($resultado){
            header('Location: /admin?resultado=2');
        }
    }

    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        //debuguear($query);
        $resultado = self::$db->query($query);
        
        if($resultado){
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }        
    }

    //definir conexion a la db
    public static function setDB($database){
        self::$db = $database;
    }

    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
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

    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public function setImagen($imagen){
        if($this->id){
            $this->borrarImagen();
        }
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
    }

    //Listar todas las propiedades
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        //debuguear($query);
        return $resultado;
    }

    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla ." WHERE id = $id";
        //debuguear($query);
        $resultado = self::consultarSQL($query);
        return $resultado[0];
    }

    public static function consultarSQL($query){
        $resultado = self::$db->query($query);

        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    public static function crearObjeto($registro){
        $objeto = new static;;
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