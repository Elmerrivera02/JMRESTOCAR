<?php
session_start();
include 'conexion_be.php';

// Recibir y limpiar datos del formulario
$nombre_completo = mysqli_real_escape_string($conexion, $_POST['nombre_completo']);
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
$contraseña = mysqli_real_escape_string($conexion, $_POST['contraseña']);

if (
    strlen($contraseña) < 8 ||
    !preg_match('/[A-Z]/', $contraseña) || // Al menos una letra mayúscula
    !preg_match('/[0-9]/', $contraseña) || // Al menos un número
    !preg_match('/[\W_]/', $contraseña)   // Al menos un carácter especial
) {
    mostrar_alerta_y_redireccionar(
        "La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, un número y un carácter especial",
        "../menu_principal.php"
    );
}

// Verificar que el correo tenga un formato válido
if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $correo)) {
    mostrar_alerta_y_redireccionar("Por favor, ingresa un correo válido", "../menu_principal.php");
}

// Verificación de correos repetidos
$verificar_correo = mysqli_query($conexion, "SELECT correo FROM usuarios WHERE correo='$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    mostrar_alerta_y_redireccionar("Este correo ya está registrado, intenta con otro diferente", "../menu_principal.php");
}

// Verificación de usuarios repetidos
$verificar_usuario = mysqli_query($conexion, "SELECT usuario FROM usuarios WHERE usuario='$usuario'");
if (mysqli_num_rows($verificar_usuario) > 0) {
    mostrar_alerta_y_redireccionar("Este usuario ya está registrado, intenta con otro diferente", "../menu_principal.php");
}

// Encriptar la contraseña antes de almacenarla
$contraseña_hashed = password_hash($contraseña, PASSWORD_BCRYPT);

// Inserción de usuario en la base de datos
$query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contraseña) 
          VALUES('$nombre_completo', '$correo', '$usuario', '$contraseña_hashed')";
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    $usuario_id = mysqli_insert_id($conexion);
    $_SESSION['usuario_id'] = $usuario_id;
    mostrar_alerta_y_redireccionar("Usuario almacenado exitosamente", "../menu.php");
} else {
    mostrar_alerta_y_redireccionar("Inténtalo de nuevo. Usuario no almacenado", "../menu_principal.php");
}

// Cerrar la conexión
mysqli_close($conexion);

// Función para mostrar alerta y redirigir
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