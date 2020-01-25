<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Aprendiendo PHP</title>
    <link href="https://fonts.googleapis.com/css?family=Proza+Libre" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css" media="screen" title="no title">
  </head>
  <body>

    <div class="contenedor">
      <h1>Aprendiendo PHP</h1>

        <div class="contenido">
          <?php
            echo "Hello World";
          ?>

          <hr>

          <?php
            // Variables

            $hola = "Hola Mundo";
            $numero = 20;

            echo $hola;
            echo $numero;

            $saludos = "<h1>Hola</h1>";
            echo $saludos;
          ?>

          <hr>

          <?php
            // Concatenar valores

            $nombre = "Bruno";
            $apellido = "Francioni";

            echo "<h1>{$nombre} . ' ' . {$apellido}</h1>";
          ?>

          <hr>

          <?php
            /* Operaciones */

            echo "10+20:" . (10+20);

            $numero1 = 10;
            $numero2 = 20;
            $numero3 = 30;
            $numero4 = 40;

            echo $numero1 + $numero2;

            echo $numero3 - $numero4;

            echo $numero4 * $numero1;

            echo $numero4 / $numero1;
          ?>

          <hr>

          <?php
            // Estructuras de control

            //If else
            if(1 < 2) {
              echo "1 es menor";
            } else {
              echo "1 es mayor";
            }

            // Switch

            $lenguaje = "PHP";

            switch($lenguaje) {
              case 'PHP':
                echo "Es PHP";
                break;
              case 'Python':
                echo "Python";
                break;
              default:
                echo "No válido";
                break;
            }

            // For

            for($i = 0; $i < 10; $i++) {
              echo $i;
            }

            // While

            $premier_league = array('Manchester City', 'Manchester United', 'Chelsea', 'Tottenham', 'Arsenal', 'Liverpool');

            $i = 0;
            while($i < count($premier_league)) {
              echo $premier_league[$i];
              $i++;
            }
          ?>

          <hr>

          <?php
            // Arreglos

            $tecnologias = array('HTML', 'CSS', 'Javascript', 'JQuery');
            foreach($tecnologias as $t) {
              echo $t;
            }

            $largo = count($tecnologias); // Cantidad de elementos del arreglo

            $tecnologias[] = 'Python'; // Agregar un elemento al arreglo

            $python = array_pop($tecnologias); // Elimina el último elemento y lo devuelve

            $css = array_shift($tecnologias); // Elimina el primer elemento y lo devuelve

            unset($tecnologias[0]); // Elimina cualquier posición que queramos

            $array = array_splice($tecnologias, 1, 1, array('AngularJS'));

            // Arreglos asociativos. Utilizan clave-valor

            $persona = array(
              'nombre' => 'Juan',
              'pais' => 'México',
              'profesion' => 'Desarrollador Web'
            );

            // 'array_values' nos convierte un array asociativo en uno con indices

            $valores = array_values($persona);

            // Arreglos multidimensionales

            $person = array(
              'datos' => array(
                'nombre' => 'Juan',
                'pais' => 'México',
                'profesion' => 'Desarrollador Web'
              ),
              'lenguajes' => array(
                'front_end' => array('HTML5', 'CSS', 'JQuery'),
                'back_end' => array('PHP', 'MySQL', 'Python')
              )
            );

            // Revisar si un elemento existe en un arreglo

            $existe = in_array('HTML', $tecnologias);

            // Recorrer un arreglo

            foreach($tecnologias as $tecnologia) {
              echo $tecnologia;
            }

            foreach($persona as $key => $val) { // Para arreglos asociativos
              echo $key. ': ' . $val;
            }

            // Recorrer arreglos multidimensionales

            foreach($persona['datos'] as $pers) {
              echo $pers;
            }

            foreach($persona['lenguajes']['front_end'] as $front) {
              echo $front;
            }
          ?>

          <hr>

          <?php
            // print_r y var_dump

            $lenguajes = array('HTML', 'CSS', 'Javascript', 'JQuery');
            
            print_r($lenguajes); // devuelve qué elemento hay en cada posición en php
            
            echo $lenguajes[2];

            var_dump($lenguajes); // devualve lo mismo pero también nos dice que tipo de archivo es cada uno

          ?>

          <hr>

          <?php
            // Funciones

            function imprimir_usuario($nombre, $telefono) {
              echo $nombre . ' ' . $telefono;
            }

            imprimir_usuario('Bruno', 12345);

            // Guardar datos en un arreglo mediante una función

            $agenda = array();

            function guardarUsuario($nombre, $tel) {
              global $agenda; // llamo a la variable global de agenda para que se guarden los datos
              $agenda[] = array($nombre, $tel);
            }

            guardarUsuario('Bruno', 1234);
          ?>

          <hr>

          // Enviar valores de una página a otra con $_GET

          <h2>Tienda en línea</h2>

          <a href="producto.php?id=20&nombre=curso">Ir a Producto</a>

          <?php
            
            
          ?>
              
        </div>
    </div>




  </body>
</html>
