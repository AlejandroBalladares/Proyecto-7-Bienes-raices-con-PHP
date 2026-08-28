<?php
    require '../includes/funciones.php';
    estadoAutenticado();
    
    //Importar la conección
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la bd
    $resultadoConsulta = mysqli_query($db, $query);

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

                <?php while ($propiedades = mysqli_fetch_assoc($resultadoConsulta)):?>
                <tr>
                    <td> <?php echo $propiedades['id']; ?> </td>
                    <td> <?php echo $propiedades['titulo']; ?> </td>
                    <td><img src="/imagenes/<?php echo $propiedades['imagen']; ?> " class="imagen-tabla"></td>
                    <td> $<?php echo $propiedades['precio']; ?> </td>
                    <td>
                        <form class="w-100" method="POST">

                        <input type="hidden" name="id" value="<?php echo $propiedades['id']; ?>">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedades['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php

mysqli_close($db);
incluirTemplate('footer');
?>