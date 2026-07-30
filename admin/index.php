<?php

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
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Casa en la playa</td>
                    <td><img src="/imagenes/0fcca7b521b64f2860ba0ec626091d63.jpg" class="imagen-tabla"></td>
                    <td>$12000000</td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

<?php
incluirTemplate('footer');
?>