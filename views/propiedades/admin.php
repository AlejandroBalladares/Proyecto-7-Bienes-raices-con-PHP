<main class="contenedor seccion">
        <h1>Administrador</h1>

        <?php 
            if($resultado){
                 $mensaje = mostrarNotificacion(intval($resultado));
                if($mensaje){ ?>
                    <p class="alerta exito"> <?php echo sanitizar($mensaje); ?> </p>
            <?php }
            } ?>
            
        <a href="/propiedades/crear.php" class="boton boton-verde"> Nueva propiedad</a>
        <a href="/vendedores/crear.php" class="boton-amarillo"> Nuevo vendedor</a>

        <h2>Propiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>