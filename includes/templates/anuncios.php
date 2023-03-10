<?php
    use App\Propiedad;
    //obtener resultados
    // debugear($_SERVER['SCRIPT_NAME']);
    if($_SERVER['SCRIPT_NAME']==="/anuncios.php"){
        $propiedades=Propiedad::all();
    }elseif($_SERVER['SCRIPT_NAME']==="/index.php"){
        $propiedades=Propiedad::get(3);

    }
    

?>

<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad):?>
            <div class="anuncio">
                <picture>
                    <!-- <source src="/build/img/anuncio1.webp" type="image/webp">
                    <source src="/build/img/anuncio1.jpg" type="image/jpg"> -->
                    <img loading="lazy" src="/imagenes/<?php echo s($propiedad->imagen);?>" alt="anuncio">
                </picture>
                <div class="contenido-anuncio">
                    <h3><?php echo s($propiedad->titulo);?></h3>
                    <p><?php echo s(substr($propiedad->descripcion,0,70));?>...</p>
                    <p class="precio">$<?php echo s(number_format($propiedad->precio));?></p>
                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                            <p><?php echo s($propiedad->wc);?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p><?php echo s($propiedad->estacionamiento);?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono dormitorio">
                            <p><?php echo s($propiedad->habitaciones);?></p>
                        </li>
                    </ul><!--lista de iconos anuncio-->
                    <a href="anuncio.php?id=<?php echo s($propiedad->idpropiedad);?>" class="boton-amarillo-block">Ver Propiedad</a>
                </div><!--contenido del anuncio-->
            </div><!--anuncio-->
        <?php endforeach; ?>
</div><!--contenedor de anuncios-->
