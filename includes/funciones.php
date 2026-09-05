<?php

define('TEMPLATES_URL', __DIR__. '/templates');
define('FUNCIONES_URL', __DIR__. 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] .'/imagenes/');

function incluirTemplate($nombre, $inicio = false){
    include TEMPLATES_URL."/{$nombre}.php";
}

function estadoAutenticado(){
    session_start();

    if(!$_SESSION['login']){
        header('location: /');
    }
}

function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre";
    exit;
}

function sanitizar($html):string{
    $sanitizado = htmlspecialchars($html);
    return $sanitizado;
}

function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

function mostrarNotificacion($codigo){
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = "Creado correctamemte";
            break;
        case 2:
            $mensaje = "Actualizado correctamemte";
            break;
        case 3:
            $mensaje = "Eliminado correctamemte";
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarRedireccionar(string $url){
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header("Location: $url");
    }
    return $id;
}