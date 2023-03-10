<main class="contenedor seccion contenido-centrado">
        <h1><?php echo s($propiedad->titulo) ?></h1>
        <picture>
            <!-- <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpg"> -->
            <img loading="lazy" src="imagenes/<?php echo s($propiedad->imagen);  ?>" alt="imagen de la propiedad">
        </picture>
        <div class="resumen-propiedad">
            <p class="precio">$<?php echo number_format(s($propiedad->precio));  ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo s($propiedad->wc);  ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo s($propiedad->estacionamiento);  ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                    <p><?php echo s($propiedad->habitaciones);  ?></p>
                </li>
            </ul><!--lista de iconos anuncio-->
            <p>
            <?php echo s($propiedad->descripcion); ?>
            <hr>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                Nemo, maxime nobis! Ipsum reprehenderit, similique fuga 
                tenetur nobis harum distinctio quam excepturi qui dolorum 
                quidem velit tempore officiis voluptate consequuntur ipsa!
            </p>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                Nemo, maxime nobis! Ipsum reprehenderit, similique fuga 
                tenetur nobis harum distinctio quam excepturi qui dolorum 
                quidem velit tempore officiis voluptate consequuntur ipsa!
            </p>
        </div>
    </main>