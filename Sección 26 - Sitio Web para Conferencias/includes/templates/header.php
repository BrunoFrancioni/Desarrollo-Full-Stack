<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"/>

  <?php
    $archivo = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace('.php', '', $archivo);

    if($pagina == 'invitados' || $pagina == 'index') {
      echo '<link rel="stylesheet" href="css/colobox.css">';
    } elseif ($pagina == 'conferencia') {
      echo '<link rel="stylesheet" href="css/colobox.css">';
    }
  ?>

  <link rel="stylesheet" href="css/main.css">
  

  <meta name="theme-color" content="#fafafa">
</head>

<body class="<?php echo $pagina; ?>">
  <header class="site-header">
    <div class="hero">
      <div class="contenido-header">
        <nav class="redes-sociales">
          <a href=""><i class="fab fa-facebook-square"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </nav>
      </div>

      <div class="informacion-evento">
        <p class="fecha"><i class="far fa-calendar-alt"></i> 10-12 Dic</p>
        <p class="ciudad"><i class="fas fa-map-marker-alt"></i> Guadalajara, MX</p>
      </div>

      <h1 class="nombre-sitio">GdlWebCamp</h1>
      <p class="slogan">la mejor conferencia de <span>diseño web</span></p>
    </div>
  </header>

  <div class="barra">
    <div class="contenedor clearfix">
      <div class="logo">
          <a href="index.php">
          <img src="img/logo.svg" alt="Imagen Logo">
        </a>
      </div>

      <div class="menu-movil">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <nav class="navegacion-principal clearfix">
        <a href="conferencias.php">Conferencia</a>
        <a href="calendario.php">Calendario</a>
        <a href="invitados.php">Invitados</a>
        <a href="registro.php">Reservaciones</a>
      </nav>
    </div>
  </div>