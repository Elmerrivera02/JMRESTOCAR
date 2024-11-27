<?php
// Incluir el archivo de conexión (ajusta la ruta si es necesario)
include('php/conexion_be.php');

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    // Obtener el ID de la reserva a eliminar
    $id_reserva = $_GET['id'];

    // Crear la consulta SQL para eliminar la reserva con ese ID
    $sql = "DELETE FROM reservas WHERE id = $id_reserva";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        // Si la eliminación fue exitosa, redirigir a la página de reservas
        header("Location: v_reservas.php?mensaje=eliminada");
        exit();  // Asegúrate de usar exit() después de header para detener la ejecución
    } else {
        // Si hay un error al eliminar, mostrar un mensaje
        echo "Error al eliminar la reserva: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>