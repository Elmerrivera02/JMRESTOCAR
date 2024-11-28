<?php
    session_start();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION["usuario_id"])) {
        header("location: index.php");
        exit();
    }

    // Verificar si se pasaron los parámetros requeridos
    if (!isset($_GET['mesa_id']) || !isset($_GET['fecha']) || !isset($_GET['hora'])) {
        echo "<p>Error: Información de reserva incompleta.</p>";
        exit();
    }

    // Obtener los datos de la reserva desde la URL
    $mesa_id = htmlspecialchars($_GET['mesa_id']); // Sanitizar los valores
    $fecha = htmlspecialchars($_GET['fecha']);
    $hora = htmlspecialchars($_GET['hora']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReservApp - Confirmación de Reserva</title>
    <link rel="stylesheet" href="CSS/reserva_comprobada.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ReservApp</h1>
            <div class="menu">
                <a href="menu.php"><button>Inicio</button></a>
            </div>
        </header>

        <section class="reservation">
            <div class="title">Reserva</div>
            <div class="confirmation">
                <div class="message">
                    <img src="IMG/check.png" alt="Check" class="checkmark-icon">
                    <p>Su reserva se realizó con éxito y fue notificado a su correo.</p>    
                </div>
                <hr>
                <!-- Mostrar la información dinámica de la reserva -->
                <p><strong>Fecha:</strong> <?php echo $fecha; ?></p>
                <p><strong>Hora:</strong> <?php echo $hora; ?></p>
                <p><strong>Ubicación:</strong> Mesa <?php echo $mesa_id; ?></p>
                <button class="my-reservations" onclick="window.location.href='v_reservas.php';">Mis Reservas</button>
            </div>
        </section>

        <footer>
            <div class="contact">
                <p>Contacto</p>
                <p>999999999</p>
            </div>
            <div class="social">
                <p>Redes Sociales</p>
                <a href="#">Instagram</a> | <a href="#">Facebook</a>
            </div>
        </footer>
    </div>
</body>
</html>
