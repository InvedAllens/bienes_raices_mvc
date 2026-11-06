<main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>
        <a href="<?php echo BASE_PATH; ?>/admin" class="boton-amarillo boton">volver</a>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo s($error);?>
            </div>    
        <?php endforeach; ?>
        <form class="form" method="POST">
            <fieldset>
                <legend>Informacion general del vendedor</legend>
                
                <label for="nombre">Nombre</label>
                <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre del vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">
                
                <label for="apellido">Apellido</label>
                <input type="text" name="vendedor[apellido]" id="apellido" placeholder="apellido del vendedor(a)" value="<?php echo s($vendedor->apellido); ?>">

            </fieldset>
            <fieldset>
                <legend>Informacion Extra</legend>
                
                <label for="nombre">Teléfono</label>
                <input type="text" name="vendedor[telefono]" id="telefono" placeholder="Telefono del vendedor(a)" value="<?php echo s($vendedor->telefono); ?>">

            </fieldset>
                      
            <input type="submit" class="boton boton-amarillo" value="Guardar Cambios">

        </form>
    </main>