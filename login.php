<?php

    require 'includes/config/database.php';
    $db = conectarDB();

    $errores = [];

    //autenticar el usuairo
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);
        
        if(!$email){
            $errores[] = "El email es obligatorio o no es valido";
        }

        if(!$password){
            $errores[] = "El password es obligatorio";
        }
    }

    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Iniciar sesion</h1>

        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password">

                <input type="submit", value="Iniciar sesion" class="boton boton-verde">
            </fieldset>
        </form>
    </main>

<?php
incluirTemplate('footer');
?>