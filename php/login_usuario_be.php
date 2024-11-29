<?php
session_start();
include 'conexion_be.php';

// Recibir y limpiar datos del formulario
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$contraseña = $_POST['contraseña'];

// Consulta para verificar si el usuario existe
$query = "SELECT * FROM usuarios WHERE correo = '$correo'";
$result = mysqli_query($conexion, $query);

// Verificar si el correo existe en la base de datos
if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    
    // Verificar la contraseña encriptada
    if (password_verify($contraseña, $usuario['contraseña'])) {
        // Si la contraseña es correcta, iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id']; // Guardar el ID del usuario en la sesión
        $_SESSION['usuario'] = $correo; // Opcional: guardar también el correo en la sesión
        
        // Verificar si el usuario es un administrador
        if ($usuario['is_admin'] == 1) {
            $_SESSION['is_admin'] = true; // Almacenar la sesión del admin
            header("location: ../admin.php"); // Redirigir al administrador
        } else {
            $_SESSION['is_admin'] = false;
            header("location: ../menu.php"); // Redirigir a la página principal de usuarios normales
        }
        exit;
    } else {
        // Si la contraseña es incorrecta
        mostrar_alerta_y_redireccionar("Contraseña incorrecta. Por favor, inténtalo de nuevo.", "../index.php");
    }
} else {
    // Si el correo no existe
    mostrar_alerta_y_redireccionar("Usuario no encontrado. Por favor, verifica los datos.", "../index.php");
}

// Cerrar la conexión
mysqli_close($conexion);

// Función para mostrar una alerta y redirigir
function mostrar_alerta_y_redireccionar($mensaje, $url) {
    echo "
        <script>
            alert('$mensaje');
            window.location = '$url';
        </script>
    ";
    exit();
}
?>
