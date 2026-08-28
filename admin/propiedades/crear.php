<?php

    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\Drivers\Gd\Driver;
    use Intervention\Image\ImageManager;

    estadoAutenticado();
   
    $db = conectarDB();
    $propiedad = new Propiedad;
    
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    $errores = Propiedad::getErrores();


    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST);

        //generar un nobre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        if($_FILES['imagen']['tmp_name']){
            $manager = new ImageManager(Driver::class);
            $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }
        $errores = $propiedad->validad();
        
        if(empty($errores)){
            if (!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //guardar la imagen en el servidor
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            $resultado = $propiedad->guardar();

            if($resultado){
                header('Location: /admin?resultado=1');
            }
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class= "alerta error"> <?php echo $error; ?> </div>
    <?php endforeach ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
    </main>

<?php
incluirTemplate('footer');
?>