<?php
    use App\Propiedad;
    use Intervention\Image\Drivers\Gd\Driver;
    use Intervention\Image\ImageManager;
    use App\Vendedor;

    require '../../includes/app.php';
    estadoAutenticado();

    //validar id
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header('location: /admin');
    }

    $db = conectarDB();

    $propiedad = Propiedad::find($id);
    $vendedores = Vendedor::all();

    $errores = Propiedad::getErrores();

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
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar propiedades</h1>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class= "alerta error"> <?php echo $error; ?> </div>
    <?php endforeach ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
    </main>

<?php
incluirTemplate('footer');
?>