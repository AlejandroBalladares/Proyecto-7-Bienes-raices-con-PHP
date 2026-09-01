<?php

    require '../../includes/app.php';

    use App\Vendedor;
    estadoAutenticado();
   
    $vendedor = new Vendedor;
    $errores = Vendedor::getErrores();


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //debuguear($_POST);
        $vendedor = new Vendedor($_POST['vendedor']);
        $errores = $vendedor->validar();
        
        if(empty($errores)){
            $vendedor->guardar();
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Registrar Vendedor/a</h1>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class= "alerta error"> <?php echo $error; ?> </div>
    <?php endforeach ?>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php">
        <?php include '../../includes/templates/formulario_vendedores.php' ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
    </main>

<?php
incluirTemplate('footer');
?>