<?php
    if(isset($_POST['submit'])) { 
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $regalo = $_POST['regalo'];
        $total = $_POST['total_pedido'];
        $fecha = date('Y-m-d H:i:s');

        // Pedidos

        $boletos = $_POST['boletos'];
        $camisas = $_POST['pedido_camisas'];
        $etiquetas = $_POST['pedido_etiquetas'];
        
        include_once 'includes/funciones/funciones.php';
        $pedido = productos_json($boletos, $camisas, $etiquetas);

        // Eventos

        $eventos = $_POST['registro'];
        $registro = eventos_json($eventos);

        try {
            require_once 'includes/funciones/bd_connection.php';
            $stmt = $connection->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); /* Avisa a MySql que se va a realizar una insersión a bd */
            $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
            $stmt->execute();
            $stmt->close();
            $connection->close();
            header('Location: validar_registro.php?exitoso=1'); // Nos aseguramos de que no se repitan los datos
        } catch(\Exception $e) {
            $error = $e->getMessage();
        }
    }
?>

<?php include_once('includes/templates/header.php'); ?>

<section class="contenedor seccion">
    <h2>Resumen Registro</h2>

    <?php
        if(isset($_GET{'exitoso'})) {
            if($_GET['exitoso'] == 1) {
                echo "<h3>Registro exitoso</h3>";
            }
        }
    ?>

</section>

<?php include_once('includes/templates/footer.php'); ?>