<?php

    //validar id valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('location: /admin');
    }

    require '../../includes/config/database.php';
    $db = conectarDB();

    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedor = '';

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

        //insertar en la base de datos
        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        //echo "<pre>";
        //var_dump($_FILES);
        //echo "</pre>";
        //exit;

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

        if(!$imagen['name']){
            $errores[] = "La imagen es obligatoria";
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

            //generar un nobre unico


            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            //Subir la imagen

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            //exit;
            
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo', 
            '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedor')";

            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                //echo "Insertado correctamente";
                header('Location: /admin?resultado=1');
            }
        }
       
    }
   
    //echo "<pre>";
    //var_dump($_SERVER);
    //echo "</pre>";
    
    require '../../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar propiedades</h1>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class= "alerta error"> <?php echo $error; ?> </div>
    <?php endforeach ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset> 
            <legend>Informacion general</legend>
            <label for="titulo"> Titulo </label>
            <input type = "text" id="titulo" name = "titulo" placeholder="Titulo propiedad" value= "<?php echo $titulo?>">

            <label for="precio"> Precio </label>
            <input type = "number" id="precio" name ="precio" placeholder="Precio propiedad" value= "<?php echo $precio ?>">

            <label for="imagen"> Imagen </label>
            <input type = "file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion"> Descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Cantidad de habitaciones</legend>
            
            <label for="habitaciones"> Habitaciones </label>
            <input type = "number" id="habitaciones" name = "habitaciones" placeholder="Ej: 3" min="1" max="9" value= "<?php echo $habitaciones ?>">

            <label for="wc"> wc </label>
            <input type = "number" id="wc" name = "wc" placeholder="Ej: 3" min="1" max="9"  value= "<?php echo $wc ?>">

            <label for="estacionamiento"> Estacionamiento </label>
            <input type = "number" id="estacionamiento" name = "estacionamiento" placeholder="Ej: 3" min="1" max="9" value= "<?php echo $estacionamiento ?>">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            
            <select name="vendedor">
                <option value=""> --Selecione un vendedor--</option>
                <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $row['id'] == $vendedor ? 'selected': ''; ?> value="<?php echo $row['id']; ?>"> <?php echo $row['nombre']." ". $row['apellido'];  ?></option>
                <?php endwhile ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
    </main>

<?php
incluirTemplate('footer');
?>