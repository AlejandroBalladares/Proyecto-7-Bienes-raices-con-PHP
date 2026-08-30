<?php
use App\Propiedad;
    require '../../includes/app.php';
    estadoAutenticado();
    

    //validar id valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('location: /admin');
    }

    $db = conectarDB();

    $propiedad = Propiedad::find($id);


    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    $errores = [];

    $titulo = $propiedad->titulo;
    $precio = $propiedad->precio;
    $descripcion = $propiedad->descripcion;
    $habitaciones = $propiedad->habitaciones;
    $wc = $propiedad->wc;
    $estacionamiento = $propiedad->estacionamiento;
    $vendedor = $propiedad->vendedorId;
    $imagenPropiedad = $propiedad->imagen;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $titulo =  mysqli_real_escape_string( $db,  $_POST['titulo']);
        $precio =  mysqli_real_escape_string( $db, $_POST['precio']);
        $descripcion =  mysqli_real_escape_string( $db, $_POST['descripcion']);
        $habitaciones =  mysqli_real_escape_string( $db, $_POST['habitaciones']);
        $wc =  mysqli_real_escape_string( $db, $_POST['wc']);
        $estacionamiento =  mysqli_real_escape_string( $db, $_POST['estacionamiento']);
        $vendedor =  mysqli_real_escape_string( $db, $_POST['vendedor']);
        $creado = date('Y/m/d');

        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = "Debe agregar un titulo";
        }
        if(!$precio){
            $errores[] = "Debe agregar un precio";
        }
        if(strlen($descripcion) <= 10){
            $errores[] = "La descripcion debe ser obligatoria y tener más de 10 caracteres";
        }
        if(!$wc){
            $errores[] = "Debe agregar unos wc";
        }
        if(!$estacionamiento){
            $errores[] = "Debe agregar un estacionamiento";
        }
        if(!$vendedor){
            $errores[] = "Debe agregar un vendedor";
        }

        //validar por tamaño
        $media = 1000 * 100;
        if(!$imagen['size'] > $media){
            $errores[] = "La imagen es muy pesada";
        }
        
        if(empty($errores)){
            /*Subida de archivos*/
            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            if($imagen['name']){
                //elimino la imagen previa

                unlink($carpetaImagenes . $propiedad->imagen);

                //generar un nobre unico
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                
                //Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);    
            }
            else{
                $nombreImagen = $propiedad->imagen;
            }

            //exit;
            
            $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', 
            habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedor
            WHERE id = $id";
            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                //echo "Insertado correctamente";
                header('Location: /admin?resultado=2');
            }
        }
       
    }
   
    //echo "<pre>";
    //var_dump($_SERVER);
    //echo "</pre>";
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