<main class="contenedor seccion">
        <h1 class="mas-nosotros">Mas sobre nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis, enim illum dignissimos culpa eius harum tempore
                     modi sapiente doloremque.
                </p>
            </div><!--icono-->
            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono seguridad" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis, enim illum dignissimos culpa eius harum tempore
                     modi sapiente doloremque.
                </p>
            </div><!--icono-->
            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono seguridad" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis, enim illum dignissimos culpa eius harum tempore
                     modi sapiente doloremque.
                </p>
            </div><!--icono-->
        </div><!--iconos nosotros-->
    </main>
    <section class="contenedor seccion">
        <h2>Casas y Depas en venta.</h2>
        <div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad):?>
            <div class="anuncio">
                <picture>
                    <!-- <source src="/build/img/anuncio1.webp" type="image/webp">
                    <source src="/build/img/anuncio1.jpg" type="image/jpg"> -->
                    <img loading="lazy" src="/imagenes/<?php echo s($propiedad->imagen);?>" alt="anuncio">
                </picture>
                <div class="contenido-anuncio">
                    <h3 class="titulo-propiedad"><?php echo s($propiedad->titulo);?></h3>
                    <p class="descripcion-propiedad"><?php echo s(substr($propiedad->descripcion,0,70));?>...</p>
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
                    <a href="/anuncio?id=<?php echo s($propiedad->idpropiedad);?>" class="boton-amarillo-block">Ver Propiedad</a>
                </div><!--contenido del anuncio-->
            </div><!--anuncio-->
        <?php endforeach; ?>
</div><!--contenedor de anuncios-->

            
        <div class="alinear-derecha">
            <a href="/anuncios" class="boton-verde">Ver todas</a>
        </div>
    </section>
    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>LLena el formulario  de contacto y un asesor se pondra en contacto contigo a la brevedad</p>
        <a href="contacto.html" class="boton-amarillo">Contactános</a>

    </section>
    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpg">
                        <img loading="lazy" src="build/img/blog1.jpg" alt="imagen blog1">
                    </picture>
                </div>
                <div class="entrada-texto">
                    <a href="entrada.html">
                        <h4>Terraza en el techo de tu casa</h4>
                        <p class="info-meta">Escrito el:<span>24/01/2023</span> por: <span>Admin</span></p>
                        <p>consejos para construir una terraza en el techo detu casa con los
                            mejores materiales y ahorrando dinero.
                        </p>
                    </a>
                </div>
            </article>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpg">
                        <img loading="lazy" src="build/img/blog2.jpg" alt="imagen blog1">
                    </picture>
                </div>
                <div class="entrada-texto">
                    <a href="entrada.html">
                        <h4>Guia para la decoracion de tu hogar</h4>
                        <p class="info-meta">Escrito el:<span>24/01/2023</span> por: <span>Admin</span></p>
                        <p>Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles
                            y colores para darle vida a tu espacio.
                        </p>
                    </a>
                </div>
            </article>
        </section>
        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    El personal se comporto de una excelente forma, muy buena atencion y la casa que me ofrecieron 
                    cumple con todas mis expectativas.
                </blockquote>
                <p>-Aldo Allende</p>
            </div>
        </section>
    </div>