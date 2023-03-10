
    <main class="contenedor seccion admin">
        <?php if(mostrarMensajeAdmin(intval($resultado))){?>
            <p class="alerta exito"><?php echo s(mostrarMensajeAdmin(intval($resultado))); ?></p>  
        <?php } ?>
        <h1 class="admin-h1">Administración Del Sitio Web</h1>
        <?php if(mostrarMensajeAdmin(intval($resultado))){?>
            <p class="alerta exito"><?php echo s(mostrarMensajeAdmin(intval($resultado))); ?></p>  
        <?php } ?>
        <a href="/propiedades/crear" class="boton-verde">Crear Propiedad</a>
        <a href="/vendedores/crear" class="boton-amarillo">Crear Vendedor</a>
        <h2>PROPIEDADES</h2>
        <table class="propiedad">
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
                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo s($propiedad->idpropiedad);?></td>
                    <td><?php echo s($propiedad->titulo);?></td>
                    <td>
                        <img src="/imagenes/<?php echo s($propiedad->imagen); ?>" class="imagen-tabla" alt="imagen de la propiedad">
                    </td>
                    <td>$<?php echo number_format(s($propiedad->precio));?></td>
                    <td> 
                        <form method="POST" class="w-100">
                            <input type="hidden" name='tipo' value="propiedades">
                            <input type="hidden" name='id' value="<?php echo s($propiedad->idpropiedad);?>">
                            <input type="submit" class="boton-rojo-block w-100" value="Eliminar">
                        </form>
                        <a href="/propiedades/actualizar?id=<?php echo s($propiedad->idpropiedad);?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>VENDEDORES</h2>
        <table class="propiedad">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo s($vendedor->idvendedor);?></td>
                    <td><?php echo s($vendedor->nombre)." ".s($vendedor->apellido);?></td>
                    <td><?php echo s($vendedor->telefono);?></td>
                    <td> 
                        <form method="POST" class="w-100">
                            <input type="hidden" name='tipo' value="vendedores">
                            <input type="hidden" name='id' value="<?php echo s($vendedor->idvendedor);?>">
                            <input type="submit" class="boton-rojo-block w-100" value="Eliminar">
                        </form>
                        <a href="/vendedores/actualizar?id=<?php echo s($vendedor->idvendedor);?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </main>
