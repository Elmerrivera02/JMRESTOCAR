<?php
session_start();

// Procesamiento del formulario de reserva
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['selectedTable'], $_POST['date'], $_POST['time'])) {
        // Conectar a la base de datos
        $conexion = new mysqli("localhost", "root", "", "login_register_bd");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Obtener los datos del formulario
        $usuario_id = $_SESSION['usuario_id']; // Suponiendo que el usuario autenticado tenga un id en sesión
        $mesa_id = $_POST['selectedTable'];
        $fecha = $_POST['date'];
        $hora = $_POST['time'];

        // Verificar que la mesa seleccionada existe
        $sql_check_mesa = "SELECT * FROM mesas WHERE id = ?";
        $stmt_check_mesa = $conexion->prepare($sql_check_mesa);
        $stmt_check_mesa->bind_param("i", $mesa_id);
        $stmt_check_mesa->execute();
        $result_check_mesa = $stmt_check_mesa->get_result();

        if ($result_check_mesa->num_rows == 0) {
            echo json_encode(["status" => "error", "message" => "La mesa seleccionada no existe."]);
        } else {
            // Verificar disponibilidad de la mesa
            $sql_check = "SELECT * FROM reservas WHERE mesa_id = ? AND fecha = ? AND hora = ?";
            $stmt_check = $conexion->prepare($sql_check);
            $stmt_check->bind_param("iss", $mesa_id, $fecha, $hora);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo json_encode(["status" => "error", "message" => "La mesa ya está reservada para esta fecha y hora."]);
            } else {
                // Insertar la reserva
                $sql_insert = "INSERT INTO reservas (usuario_id, mesa_id, fecha, hora) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conexion->prepare($sql_insert);
                $stmt_insert->bind_param("iiss", $usuario_id, $mesa_id, $fecha, $hora);
                if ($stmt_insert->execute()) {
                    // Redirigir a la página de confirmación
                    header("Location: http://localhost/JMRESTOCAR/confirmar_reserva.php?mesa_id=$mesa_id&fecha=$fecha&hora=$hora");
                    exit;
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Error al realizar la reserva.",
                        "sql_error" => $stmt_insert->error
                    ]);
                }
            }
        }

        // Cerrar conexiones
        $stmt_check_mesa->close();
        $stmt_check->close();
        $stmt_insert->close();
        $conexion->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Faltan datos para realizar la reserva."]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Mesa</title>
    <link rel="stylesheet" href="CSS/reserva.css">
    <style>
        .table.selected {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .table {
            cursor: pointer;
            display: inline-block;
            padding: 10px;
            margin: 5px;
            border: 1px solid #333;
            text-align: center;
        }
        .table.reserved {
            background-color: #e0e0e0;
            color: #888;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">ReservApp</div>
        <nav>
            <ul>
                <li><a href="menu.php">Inicio</a></li>
                <li><a href="menu_principal.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="reservation-form">
            <h1>Reservar Mesa</h1>
            <form id="reservationForm" method="POST">
                <label for="time">Selecciona la hora:</label>
                <select id="time" name="time" required>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:00">16:30</option>
                <option value="13:30">17:00</option>
                <option value="13:30">17:30</option>
                <option value="13:30">18:00</option>
                <option value="13:30">18:30</option>
                <option value="13:30">19:00</option>
                <option value="13:30">19:30</option>
                <option value="13:30">20:00</option>
                <option value="13:30">20:30</option>
                <option value="13:30">21:00</option>
                <option value="21:30">21:30</option>
                <option value="22:00">22:00</option>
        </select>


                <label for="date">Selecciona la fecha:</label>
                <input type="date" id="date" name="date" required>

                <label for="chairs">Cantidad de sillas:</label>
                <p id="sillasInfo">Selecciona una mesa para ver la cantidad de sillas</p>

                <label for="table">Selecciona tu mesa:</label>
                <div class="tables">
                    <div class="table available" data-table="1" data-sillas="4">Mesa 1</div>
                    <div class="table available" data-table="2" data-sillas="6">Mesa 2</div>
                    <div class="table available" data-table="3" data-sillas="4">Mesa 3</div>
                    <div class="table available" data-table="4" data-sillas="8">Mesa 4</div>
                </div>
                <div class="tables">
                    <div class="table available" data-table="5" data-sillas="10">Mesa 5</div>
                    <div class="table available" data-table="6" data-sillas="4">Mesa 6</div>
                    <div class="table available" data-table="7" data-sillas="8">Mesa 7</div>
                    <div class="table available" data-table="8" data-sillas="2">Mesa 8</div>
                </div>

                <input type="hidden" id="selectedTable" name="selectedTable" required>
                <button type="submit">Confirmar Reserva</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Contacto: info@reservapp.com</p>
        <p><a href="#">Política de Privacidad</a> | <a href="#">Términos de Servicio</a></p>
    </footer>

    <script>
        const tables = document.querySelectorAll('.table');
        const selectedTableInput = document.getElementById('selectedTable');
        const sillasInfo = document.getElementById('sillasInfo');

        tables.forEach(table => {
            table.addEventListener('click', function() {
                if (this.classList.contains('reserved')) {
                    alert("Esta mesa ya está reservada.");
                    return;
                }

                tables.forEach(t => t.classList.remove('selected'));
                this.classList.add('selected');


                selectedTableInput.value = this.dataset.table;

                const numSillas = this.dataset.sillas;
                sillasInfo.textContent = `La mesa seleccionada tiene ${numSillas} sillas.`;
            });
        });

        document.getElementById('reservationForm').addEventListener('submit', function(event) {

            const timeInput = document.getElementById('time');
            const selectedTime = timeInput.value;

            if(!selectedTime){
                alert("Por favor, selecciona una hora antes de confirmar la reserva.");
                event.preventDefault();
                return;
            }

            if (!selectedTableInput.value) {
                alert("Por favor, selecciona una mesa antes de confirmar la reserva.");
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
