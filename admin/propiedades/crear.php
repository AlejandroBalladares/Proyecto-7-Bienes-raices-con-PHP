<?php

    require '../../includes/app.php';

    use App\Propiedad;
    
    estadoAutenticado();
   
    $db = conectarDB();

    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    $errores = Propiedad::getErrores();

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedor = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST);
        $errores = $propiedad->validad();
        
        if(empty($errores)){

            $propiedad->guardar();

            $imagen = $_FILES['imagen'];
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
   

            //$resultado = mysqli_query($db, $query);

            if($resultado){
                //echo "Insertado correctamente";
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
            
            <select name="vendedorId">
                <option value=""> --Selecione un vendedor--</option>
                <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $row['id'] == $vendedor ? 'selected': ''; ?> value="<?php echo $row['id']; ?>"> <?php echo $row['nombre']." ". $row['apellido'];  ?></option>
                <?php endwhile ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
    </main>

<?php
incluirTemplate('footer');
?>