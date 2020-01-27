<section class="seccion contenedor">
    <h2>Nuestros Invitados</h2>

    <?php
        try {
            require_once('includes/funciones/bd_connection.php');
            $sql = " SELECT * FROM invitados ";
            $resultado = $connection->query($sql);
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    ?>

    <div class="calendario">
        <section class="invitados contenedor seccion">
            <ul class="lista-invitados clearfix">

                <?php while($invitados = $resultado->fetch_assoc()) { ?>
                    <li>
                        <div class="invitado">
                            <a class="invitado-info" href="#invitado<?php $invitados['invitado_id']; ?>">
                                <img src="img/<?php echo $invitados['url_imagen']; ?>" alt="Imagen Invitados">
                                <p><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></p>
                            </a>
                        </div>
                    </li>

                    <div style="display:none;">
                        <div class="invitado-info" id="invitado<?php $invitados['invitado_id']; ?>">
                            <h2><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></h2>
                            <img src="img/<?php echo $invitados['url_imagen']; ?>" alt="Imagen Invitados">
                            <p><?php echo $invitados['descripcion']; ?></p>
                        </div>
                    </div>
                <?php } ?>

            </ul>
        </section>

    <?php
        $connection->close();
    ?>
</section>
