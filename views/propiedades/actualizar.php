<main class="contenedor seccion">
        <h1>Actualizar propiedad</h1>
        <a href="/admin" class="boton-verde boton">volver</a>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>    
        <?php endforeach; ?>
        <form class="form" method="POST"  enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion general de la propiedad</legend>
                
                <label for="titulo">Titulo</label>
                <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Titulo de la propiedad" value="<?php echo s($propiedad->titulo); ?>">
                
                <label for="precio">Precio</label>
                <input type="text" name="propiedad[precio]" id="precio" placeholder="Precio de la propiedad" value="<?php echo s($propiedad->precio); ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg,image/png">
                <?php 
                    if($propiedad->imagen):?>
                        <img src="../../imagenes/<?php echo $propiedad->imagen ?>" alt="imagen de la propiedad a actualizar" class="imagen-actualizar">
                    <?php endif;?>
                
                <label for="descripcion">Descripcion:</label>
                <textarea  id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
            </fieldset>
            <fieldset>
                <legend>Informacion de la propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" placeholder="Ej:3" min="1" max="9" name="propiedad[habitaciones]" value="<?php echo s($propiedad->habitaciones); ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Ej:3" min="1" max="9" name="propiedad[wc]" value="<?php echo s($propiedad->wc); ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Ej:3" min="1" max="9" name="propiedad[estacionamiento]" value="<?php echo s($propiedad->estacionamiento); ?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="propiedad[vendedores_idvendedor]">
                    <option value="">--Seleccione--</option>
                    <?php foreach($vendedores as $vendedor): ?>
                        <option <?php echo $propiedad->vendedores_idvendedor===$vendedor->idvendedor ? 'selected':'' ?> 
                        value="<?php echo s($vendedor->idvendedor); ?>" >
                        <?php echo $vendedor->nombre." ".$vendedor->apellido;?></option>
                    <?php endforeach; ?>
                    
                </select>
            </fieldset>
            <input type="submit" class="boton boton-verde" value="Actualizar Propiedad">

        </form>
    </main>