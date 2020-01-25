<?php
    $accion = $_POST['accion'];
    $password = $_POST['password'];
    $usuario = $_POST['usuario'];

    if($accion === 'crear') {
        // Código para crear los administradores

        // Hasear passwords
        $opciones = array(
            'cost' => 12
        );
        $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

        // Importar la conexión
        include '../funciones/conexion.php';

        try {
            // Realizar la consulta a la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $usuario, $hash_password);
            $stmt->execute();

            if($stmt->affected_rows > 0) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'tipo' => $accion
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }

            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'pass' => $e->getMessage();
            );
        }

        echo json_encode($respuesta);
    }

    if($accion === 'login') {
        // Escribir código que loguee a los administradores

        include '../funciones/conexion.php';

        try {
            // Seleccionar el administrador de la base de datos
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
            $stmt->bind_param('s', $usuario);
            $stmt->execute();

            // Loguear al usuario
            $stmt->bind_result($id_usuario, $nombre_usuario, $password_usuario); // Trae el resultado y guarda en las variables que le indicamos el resultado
            $stmt->fetch();
            
            if($nombre_usuario) {
                // El usuario existe, verificar el password
                if(password_verify($password, $password_usuario)) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION['nombre'] = $usuario;
                    $_SESSION['id'] = $id_usuario;
                    $_SESSION['login'] = true;
                    // Login correcto
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => $nombre_usuario,
                        'tipo' => $accion
                    );
                } else {
                    // Login incorrecto
                    $respuesta = array(
                        'error' => 'Password Incorrecto'
                    );
                }
            } else {
                $respuesta = array(
                    'error' => 'Usuario no existe'
                );
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'pass' => $e->getMessage();
            );
        }

        echo json_encode($respuesta);
    }
?>