<?php
// Incluir la conexión a la base de datos
include 'php/conexion_be.php';

// Consultar las reservas de la base de datos
$query = "SELECT id, usuario_id, mesa_id, fecha, hora FROM reservas"; // Ajustar nombres según la tabla
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
    <title>ReservApp Reservas</title>
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
            transition: background-color 0.3s ease; /* Transición para el hover */
        }
        .header .button:hover {
            background-color: #333; /* Fondo gris oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>ReservApp</h1>
            <form method="GET" action="admin.php">
                <button type="submit" class="button">Usuarios</button>
            </form>
            <form method="POST" action="logout.php">
                <button type="submit" name="logout" class="button">Cerrar Sesión</button>
            </form>
        </header>
        <main class="content">
            <h2>Lista de Reservas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>Id Usuario</th>
                        <th>Mesa</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si hay resultados y mostrarlos
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['usuario_id']}</td>
                                    <td>{$row['mesa_id']}</td>
                                    <td>{$row['fecha']}</td>
                                    <td>{$row['hora']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay reservas registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
