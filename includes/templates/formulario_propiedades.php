<fieldset> 
            <legend>Informacion general</legend>
            <label for="titulo"> Titulo </label>
            <input type = "text" id="titulo" name = "titulo" placeholder="Titulo propiedad" value= "<?php echo sanitizar($propiedad->titulo) ?>">

            <label for="precio"> Precio </label>
            <input type = "number" id="precio" name ="precio" placeholder="Precio propiedad" value= "<?php echo sanitizar($propiedad->precio) ?>">

            <label for="imagen"> Imagen </label>
            <input type = "file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion"> Descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo sanitizar($propiedad->descripcion) ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Cantidad de habitaciones</legend>
            
            <label for="habitaciones"> Habitaciones </label>
            <input type = "number" id="habitaciones" name = "habitaciones" placeholder="Ej: 3" min="1" max="9" value= "<?php echo sanitizar($propiedad->habitaciones) ?>">

            <label for="wc"> wc </label>
            <input type = "number" id="wc" name = "wc" placeholder="Ej: 3" min="1" max="9"  value= "<?php echo sanitizar($propiedad->wc) ?>">

            <label for="estacionamiento"> Estacionamiento </label>
            <input type = "number" id="estacionamiento" name = "estacionamiento" placeholder="Ej: 3" min="1" max="9" value= "<?php echo sanitizar($propiedad->estacionamiento) ?>">

        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            
        </fieldset>