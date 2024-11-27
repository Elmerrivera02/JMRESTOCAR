<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit();
}

// Obtén el usuario_id del usuario autenticado
$usuario_id = $_SESSION['usuario_id'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReservApp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4c2b2b;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #4c2b2b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #4c2b2b;
            color: white;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .btn-modify {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-modify:hover {
            background-color: #45a049;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .header-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header-buttons button {
            background-color: #000;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .header-buttons button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ReservApp</h1>
        <?php
        // Mostrar el mensaje dentro del body
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] == 'actualizada') {
                echo "<p id='mensaje-flash' class='success-message'>Reserva actualizada exitosamente.</p>";
            } elseif ($_GET['mensaje'] == 'eliminada') {
                echo "<p id='mensaje-flash' class='success-message'>Reserva eliminada exitosamente.</p>";
            }
        }
        ?>
        <div class="header-buttons">
            <a href="reservas.php"><button>Reservar</button></a>
            <a href="menu.php"><button>Inicio</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>usuario_id</th>
                    <th>mesa_id</th>
                    <th>fecha</th>
                    <th>hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                $conexion = mysqli_connect("localhost", "root", "", "login_register_bd");

                if (!$conexion) {
                    die("Error de conexión: " . mysqli_connect_error());
                }

                // Consultar las reservas del usuario autenticado
                $sql = "SELECT * FROM reservas WHERE usuario_id = '$usuario_id'";
                $resultado = mysqli_query($conexion, $sql);

                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($res = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$res['id']}</td>
                                <td>{$res['usuario_id']}</td>
                                <td>{$res['mesa_id']}</td>
                                <td>{$res['fecha']}</td>
                                <td>{$res['hora']}</td>
                                <td>
                                    <button class='btn-modify' onclick='modifyReservation({$res['id']})'>Modificar</button>
                                    <button class='btn-delete' onclick='deleteReservation({$res['id']})'>Eliminar</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay reservas disponibles.</td></tr>";
                }

                // Cerrar la conexión
                mysqli_close($conexion);
                ?>
            </tbody>
        </table>
    </div>
    <!--<script>
        function modifyReservation(id) {
            // Redirige a una página para modificar la reserva con el ID proporcionado
            window.location.href = "modificar_reserva.php?id=" + id;
        }

        function deleteReservation(id) {
            // Confirma y elimina la reserva
            if (confirm("¿Estás seguro de que deseas eliminar esta reserva?")) {
                window.location.href = "eliminar_reserva.php?id=" + id;
            }
        }
    </script>-->

    <script>
        function modifyReservation(id) {
            // Redirige a una página para modificar la reserva con el ID proporcionado
            window.location.href = `modificar_reserva.php?id=${id}`;
        }

        function deleteReservation(id) {
            // Confirma y elimina la reserva
            if (confirm("¿Estás seguro de que deseas eliminar esta reserva?")) {
                window.location.href = `eliminar_reserva.php?id=${id}`;
            }
        }

       document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el elemento del mensaje
        var mensajeFlash = document.getElementById('mensaje-flash');
        if (mensajeFlash) {
            // Después de 5 segundos (5000 milisegundos), oculta el mensaje
            setTimeout(function() {
                mensajeFlash.style.display = 'none';
            }, 3000);
        }
    });
    </script>
    
</body>
</html>