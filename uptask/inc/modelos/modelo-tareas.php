<?php
    $accion = $_POST['accion'];
    $id_proyecto = (int) $_POST['id_proyecto'];
    $tarea = $_POST['tarea'];
    $estado = $_POST['estado'];
    $id_tarea = $_POST['id'];

    if($accion === 'crear') {
        // Importar la conexión
        include '../funciones/conexion.php';

        try {
            // Realizar la consulta a la base de datos
            $stmt = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) VALUES (?, ?)");
            $stmt->bind_param('si', $tarea, $id_proyecto);
            $stmt->execute();

            if($stmt->affected_rows > 0) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'tipo' => $accion,
                    'tarea' => $tarea
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
                'error' => $e->getMessage();
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

    if($accion === 'actualizar') {
        // Importar la conexión
        include '../funciones/conexion.php';

        try {
            // Realizar la consulta a la base de datos
            $stmt = $conn->prepare("UPDATE tareas set estado = ? WHERE id = ? ");
            $stmt->bind_param('ii', $estado, $id_tarea);
            $stmt->execute();

            if($stmt->affected_rows > 0) {
                $respuesta = array(
                    'respuesta' => 'correcto'
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
                'error' => $e->getMessage();
            );
        }

        echo json_encode($respuesta);
    }

    if($accion === 'eliminar') {
        // Importar la conexión
        include '../funciones/conexion.php';

        try {
            // Realizar la consulta a la base de datos
            $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ? ");
            $stmt->bind_param('i', $id_tarea);
            $stmt->execute();

            if($stmt->affected_rows > 0) {
                $respuesta = array(
                    'respuesta' => 'correcto'
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
                'error' => $e->getMessage();
            );
        }

        echo json_encode($respuesta);
    }
?>