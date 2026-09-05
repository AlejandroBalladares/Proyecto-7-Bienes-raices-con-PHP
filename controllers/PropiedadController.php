<?php

namespace Controller;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PropiedadController{
    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $resultado = $_GET['resultado'] ?? null;
        $router->render("propiedades/admin", ['propiedades'=>$propiedades, 'resultado'=>$resultado]);

    }
    public static function crear(Router $router){
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //debuguear($_POST);
            $propiedad = new Propiedad($_POST['propiedad']);

            //generar un nobre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new ImageManager(Driver::class);
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            $errores = $propiedad->validar();
            
            if(empty($errores)){
                if (!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
                //guardar la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad'=>$propiedad,
            'vendedores'=>$vendedores,
            'errores'=>$errores,
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarRedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
       
        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);
        $errores = $propiedad->validar();

        //generar un nobre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $manager = new ImageManager(Driver::class);
            $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }
        if (empty($errores)) {
            // Almacenar la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']){
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad->guardar();
            }
        }

        $router->render('/propiedades/actualizar',[
            'propiedad'=>$propiedad,
            'vendedores'=>$vendedores,
            'errores'=>$errores,
        ]);

    }
}