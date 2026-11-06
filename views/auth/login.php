<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>
        <?php 
            foreach($errores as $error):?>
            <div class="error alerta">
                <?php 
                    echo s($error);
                ?>
            </div>
        <?php 
            endforeach;
        ?>    

        <form class="form" method="POST">
            <legend>Email y Password</legend>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Tu email" id="email" value="<?php echo s($auth->email); ?>">

            <label for="password"> Password</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password" value="">
            <input type="submit"  value="Iniciar Sesion" class="boton boton-verde">
        </form>
    </main>