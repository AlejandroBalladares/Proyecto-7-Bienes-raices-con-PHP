        <fieldset> 
            <legend>Informacion general</legend>
            
            <label for="nombre"> Titulo </label>
            <input type = "text" id="nombre" name = "vendedor[nombre]" placeholder="Nombre del vendeor" value= "<?php echo sanitizar($vendedor->nombre) ?>">

            <label for="apellido"> Apellido </label>
            <input type = "text" id="apellido" name ="vendedor[apellido]" placeholder="Apellido del vendedor" value= "<?php echo sanitizar($vendedor->apellido) ?>">

        </fieldset>

        <fieldset>
            <legend>Información extra</legend>
            
            <label for="telefono"> Telefono </label>
            <input type = "number" id="telefono" name = "vendedor[telefono]" placeholder="47734623" min="1" max="9" value= "<?php echo sanitizar($vendedor->telefono) ?>">
        </fieldset>
