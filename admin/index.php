<?php
    require '../includes/app.php';
    estadoAutenticado();
    use App\Propiedad;
    use App\Vendedor;

    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();
    
    //mensaje condincional
    $resultado = $_GET["resultado"] ?? null; //si no hay valor, agrgo null por defecto

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $tipo = $_POST['tipo'];
            if(validarTipoContenido($tipo)){
                if($tipo == 'propiedad'){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
                else{
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }            
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador</h1>

        <?php if($resultado == 1): ?>
           <p class="alerta exito"> Creado Correctaente </p>
        <?php endif; ?>

        <?php if ($resultado == 2): ?>
           <p class="alerta exito"> Actualizado Correctaente </p>
        <?php endif; ?>
        <?php if ($resultado == 3): ?>
           <p class="alerta exito"> Eliminado Correctaente </p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde"> Nueva propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton-amarillo"> Nuevo vendedor</a>

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

        <h2>Venderores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados-->

                <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?> </td>
                    <td>
                        <form class="w-100" method="POST">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

<?php

incluirTemplate('footer');
?>