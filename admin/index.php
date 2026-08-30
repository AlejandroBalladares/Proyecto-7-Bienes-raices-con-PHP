<?php
    require '../includes/app.php';
    estadoAutenticado();
    use App\Propiedad;
    
    $propiedades = Propiedad::all();
    //mensaje condincional
    $resultado = $_GET["resultado"] ?? null; //si no hay valor, agrgo null por defecto

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            //Eliminar archivo
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            $propiedades = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/'. $propiedades['imagen']);

            //Eliminar propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";

            $resultado = mysqli_query($db, $query);
            if($resultado){
                header('location: /admin?resultado=3');
            }
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador</h1>

        <?php if($resultado == 1): ?>
           <p class="alerta exito"> Anuncio Creado Correctaente </p>
        <?php endif; ?>

        <?php if ($resultado == 2): ?>
           <p class="alerta exito"> Anuncio Actualizado Correctaente </p>
        <?php endif; ?>
        <?php if ($resultado == 3): ?>
           <p class="alerta exito"> Anuncio Eliminado Correctaente </p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde"> Nueva propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados-->

                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?> " class="imagen-tabla"></td>
                    <td> $<?php echo $propiedad->precio; ?> </td>
                    <td>
                        <form class="w-100" method="POST">

                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="./propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php

mysqli_close($db);
incluirTemplate('footer');
?>