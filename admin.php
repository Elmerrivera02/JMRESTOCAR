<?php
// Incluir la conexión a la base de datos
include 'php/conexion_be.php';

session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
    header("Location: index.php"); // Redirigir al inicio de sesión si no es administrador
    exit();
}

// Verificar si se ha recibido el ID del usuario para eliminar
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Primero eliminar las reservas asociadas al usuario
    $delete_reservas_query = "DELETE FROM reservas WHERE usuario_id = $user_id";
    if (mysqli_query($conexion, $delete_reservas_query)) {
        // Ahora eliminar al usuario
        $delete_user_query = "DELETE FROM usuarios WHERE id = $user_id";
        if (mysqli_query($conexion, $delete_user_query)) {
            echo "Usuario y reservas eliminados exitosamente.";
            // Redireccionar para evitar reenvío del formulario
            header("Location: admin.php");
            exit();
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al eliminar las reservas: " . mysqli_error($conexion);
    }
}

// Consultar los usuarios de la base de datos
$query = "SELECT id, nombre_completo, correo, usuario FROM usuarios"; // Nombres correctos según la tabla
$result = mysqli_query($conexion, $query);

// Verificar si la consulta falló
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReservApp</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <style>
        .header form {
            display: inline;
        }
        .header .button {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Letra blanca */
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px; /* Espacio entre los botones */
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease; /* Transición para efecto hover */
        }
        .header .button:hover {
            background-color: #333; /* Fondo gris oscuro al pasar el mouse */
        }
        .delete-button {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>ReservApp</h1>
            <form method="GET" action="admin_reservas.php">
                <button type="submit" class="button">Reservas</button>
            </form>
            <form method="POST" action="index.php">
                <button type="submit" name="logout" class="button">Cerrar Sesión</button>
            </form>
        </header>
        <main class="content">
            <h2>Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si hay resultados y mostrarlos
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nombre_completo']}</td>
                                    <td>{$row['correo']}</td>
                                    <td>{$row['usuario']}</td>
                                    <td>
                                        <form method='POST' action=''>
                                            <input type='hidden' name='user_id' value='{$row['id']}'>
                                            <button type='submit' name='delete_user' class='delete-button'>Eliminar</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay usuarios registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
