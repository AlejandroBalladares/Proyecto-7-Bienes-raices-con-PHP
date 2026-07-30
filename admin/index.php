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
    </main>

<?php
incluirTemplate('footer');
?>