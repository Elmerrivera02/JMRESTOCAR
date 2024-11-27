<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtén el usuario_id del usuario autenticado
$usuario_id = $_SESSION['usuario_id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "login_register_bd");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verifica si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva_id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Preparar la consulta para actualizar la reserva
    $stmt = $conexion->prepare("UPDATE reservas SET fecha = ?, hora = ? WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ssii", $fecha, $hora, $reserva_id, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de reservas con un mensaje de éxito
        header("Location: v_reservas.php?mensaje=actualizada");
        exit();
    } else {
        echo "Error al actualizar la reserva: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    // Obtener la reserva actual para mostrar en el formulario
    if (isset($_GET['id'])) {
        $reserva_id = $_GET['id'];

        $stmt = $conexion->prepare("SELECT * FROM reservas WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $reserva_id, $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $reserva = $resultado->fetch_assoc();
        } else {
            echo "No se encontró la reserva.";
            exit();
        }
    } else {
        echo "ID de reserva no especificado.";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Reserva</title>
    <style>
        /* Estilos para el formulario */
        body {
            font-family: Arial, sans-serif;
            background-color: #4c2b2b;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #4c2b2b;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #4c2b2b;
        }
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            background-color: #4c2b2b;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modificar Reserva</h1>
        <form method="POST" action="modificar_reserva.php">
            <input type="hidden" name="id" value="<?php echo $reserva['id']; ?>">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="<?php echo $reserva['fecha']; ?>" required>

            <label for="hora">Hora:</label>
            <select name="hora" required>
                <?php
                // Lista de horas disponibles
                $horas = [
                    "11:00", "11:30", "12:00", "12:30",
                    "13:00", "13:30", "14:00", "14:30",
                    "15:00", "15:30", "16:00", "16:30",
                    "17:00", "17:30", "18:00", "18:30",
                    "19:00", "19:30", "20:00", "20:30",
                    "21:00", "21:30", "22:00"
                ];

                foreach ($horas as $hora_opcion) {
                    // Marcar como seleccionada la hora actual de la reserva
                    $selected = ($hora_opcion == $reserva['hora']) ? 'selected' : '';
                    echo "<option value='$hora_opcion' $selected>$hora_opcion</option>";
                }
                ?>
            </select>

            <input type="submit" value="Actualizar Reserva">
        </form>
    </div>
</body>
</html>
