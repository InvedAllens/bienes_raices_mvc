<main class="contenedor seccion contenido-centrado">
        <h1>Contacto</h1>
        <?php 
            if($mensaje):?>
            <p class="alerta <?php echo s($claseMensaje); ?>"><?php echo s($mensaje);?></p>
        <?php endif;?>
        <picture>
            <source srcset="<?php echo BASE_PATH; ?>/build/img/destacada3.webp" type="image/webp">
            <source srcset="<?php echo BASE_PATH; ?>/build/img/destacada3.jpg" type="image/jpg">
            <img loading="lazy" width="200" height="300" src="<?php echo BASE_PATH; ?>/build/img/destacada3.jpg" alt="imagen contacto">
        </picture>
        <h2>Llene el formulario de contacto</h2>

        <form class="form" method="POST">
            <fieldset>
                <legend>Informacion General</legend>
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu nombre" id="nombre" name="contacto[nombre]" required>

                <label for="mensaje">Tu mensaje</label>
                <textarea id="mensaje" placeholder="Escribe tu mensaje..." name="contacto[mensaje]" required></textarea>
            </fieldset>
            <fieldset>
                <legend>Informacion sobre la propiedad</legend>
                <label for="opciones">Vende o compra:</label>
                <select id="opciones" name="contacto[tipo]" required>
                    <option value="" disabled selected>--Selecione--</option>
                    <option value="comprar">Compra</option>
                    <option value="vender">Vende</option>
                </select>

                <label for="presupuesto">Precio o presupuesto</label>
                <input type="number" placeholder="Tu precio o presupuesto" id="presupuesto" name="contacto[presupuesto]">
            </fieldset>

            <fieldset>
                <legend>Informacion para contactar</legend>
                <p>¿Como desea ser contactado?</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">Telefono</label>
                    <input  type="radio" id="contactar-telefono" value="telefono" name="contacto[contacto]">
                    <label for="contactar-email">Email</label>
                    <input  type="radio" id="contactar-email" value="email" name="contacto[contacto]">
                </div>
                <div id="contactoSeleccion">

                </div>
                <!--elejir ser contactado -->

            </fieldset>
            <!-- campo trampa para robots: las personas no lo ven -->
            <div style="position:absolute;left:-9999px" aria-hidden="true">
                <label for="sitio_web">No llenar este campo</label>
                <input type="text" id="sitio_web" name="sitio_web" tabindex="-1" autocomplete="off">
            </div>
            <input type="submit" class="boton-verde">

        </form>
    </main>
