<?php
  include_once('includes/templates/header.php');

  use Paypal\Rest\ApiContext;
  use Paypal\Api\PaymentExecution;
  use Paypal\Api\Payment;

  require 'includes/paypal.php';
?>

<section class="contenedor seccion">
    <h2>Resumen Registro</h2>

    <?php
        $paymentId = $_GET['paymentId'];
        $id_pago =(int) $_GET['id_pago'];

        // Petición a REST Api
        $pago = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        // Resultado tiene la información de la transacción
        $resultado = $pago->execute($execution, $apiContext);

        $respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;
        
        if($respuesta === 'completed') {
            "El pago se realizó correctamente";

            require_once 'includes/funciones/bd_conexion.php';
            $stmt = $conn->prepare('UPDATE registrados SET pagado = ? WHERE ID_registrado = ?');
            $pagado = 1;
            $stmt->bind_param('ii', $pagado, $id_pago);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        } else {
            "El pago no se realizó";
        }
    ?>

</section>

<?php include_once('includes/templates/footer.php'); ?>