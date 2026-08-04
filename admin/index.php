<?php

    //Importar la conección
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la bd
    $resultadoConsulta = mysqli_query($db, $query);

    //mensaje condincional
    $resultado = $_GET["resultado"] ?? null; //si no hay valor, agrgo null por defecto

    require '../includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador</h1>

        <?php if($resultado == 1): ?>
           <p class="alerta exito"> Anuncio creado correctaente </p>
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
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
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