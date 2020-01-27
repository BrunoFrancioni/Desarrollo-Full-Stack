<?php
    if(!isset($_POST['submit'])) {
        exit("Hubo un error");
    }

    use PayPal\Api\Payer;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Details;
    use PayPal\Api\Amount;
    use PayPal\Api\Transaction;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Payment;

    require 'includes/paypal.php';

    if(isset($_POST['submit'])) { 
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $regalo = $_POST['regalo'];
        $total = $_POST['total_pedido'];
        $fecha = date('Y-m-d H:i:s');

        // Pedidos

        $boletos = $_POST['boletos'];
        $numero_boletos = $boletos;
        $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
        $precioCamisa = $_POST['pedido_extra']['camisas']['precio'];

        $pedidoExtra = $_POST['pedido_extra'];

        $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
        $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];
        
        include_once 'includes/funciones/funciones.php';
        $pedido = productos_json($boletos, $camisas, $etiquetas);

        // Eventos

        $eventos = $_POST['registro'];
        $registro = eventos_json($eventos);

        exit;

        try {
            require_once 'includes/funciones/bd_connection.php';
            $stmt = $connection->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); /* Avisa a MySql que se va a realizar una insersión a bd */
            $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
            $stmt->execute();
            $ID_registro = $stmt->insert_id;
            $stmt->close();
            $connection->close();
            header('Location: validar_registro.php?exitoso=1'); // Nos aseguramos de que no se repitan los datos
        } catch(\Exception $e) {
            $error = $e->getMessage();
        }
    }


    $compra = new Payer();
    $compra->setPaymentMethod('paypal');

    $articulo = new Item();
    $articulo->setName($producto);
    $articulo->setCurrency('MXN');
    $articulo->setQuantity(1);
    $articulo->setPrice($precio);

    $i = 0;
    $arreglo_pedido = array();

    foreach($numero_boletos as $key => $value) {
        if((int) $value['cantidad'] > 0) {
            ${"articulo$i"} = new Item();
            $arreglo_pedido[] = ${"articulo$i"};
            ${"articulo$i"}->setName('Pase: ' . $key);
            ${"articulo$i"}->setCurrency('MXN');
            ${"articulo$i"}->setQuantity((int) $value['cantidad']);
            ${"articulo$i"}->setPrice((int) $value['precio']);
            $i++;
        }
    }

    foreach($pedidoExtra as $key => $value) {
        if((int) $value['cantidad'] > 0) {
            if($key === 'camisas') {
                $precio = (float) $value['precio'] * .93;
            } else{
                $precio = (int) $value['precio'];
            }

            ${"articulo$i"} = new Item();
            $arreglo_pedido[] = ${"articulo$i"};
            ${"articulo$i"}->setName('Extras: ' . $key);
            ${"articulo$i"}->setCurrency('MXN');
            ${"articulo$i"}->setQuantity((int) $value['cantidad']);
            ${"articulo$i"}->setPrice($precio);
            $i++;
        }
    }


    $listaArticulos = new ItemList();
    $listaArticulos->setItems($arreglo_pedido);

    $cantidad = new Amount();
    $cantidad->setCurrency('MXN');
    $cantidad->setTotal($total);

    $transaccion = new Transaction();
    $transaccion->setAmount($cantidad);
    $transaccion->setItemList($listaArticulos);
    $transaccion->setDescription('Pago GDLWEBCAMP');
    $transaccion->setInvoiceNumber($ID_registro);

    $redireccionar = new RedirectUrls();
    $redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$ID_registro}");
    $redireccionar->setCancelUrl(URL_SITIO . "/pago_finalizado.php?id_pago={$ID_registro}");

    $pago = new Payment();
    $pago->setIntent("sale");
    $pago->setPayer($compra);
    $pago->setRedirectUrls($redireccionar);
    $pago->setTransactions(array($transaccion));

    try {
        $pago->create($apiContext);
    } catch(PayPal\Exception\PayPalConnectionException $pce) {
        echo "<pre";
        print_r(json_decode($pce->getData()));
        exit();
    }

    $aprobado = $pago->getApprovalLink();

    header("Location: {$aprobado}");
?>