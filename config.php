<?php
/**
 * Configuración de Conexión a Base de Datos MySQL
 * Archivo: config.php
 */

// Definir las constantes de conexión
define('DB_HOST', 'localhost');      // Servidor MySQL
define('DB_USER', 'root');           // Usuario MySQL (por defecto 'root')
define('DB_PASS', '');               // Contraseña MySQL (deja vacío si no tienes)
define('DB_NAME', 'autoevaluacion_aa'); // Nombre de la base de datos

// Crear conexión a MySQL usando mysqli
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("❌ Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8mb4");

// Mensaje de confirmación (solo para desarrollo, eliminar en producción)
// echo "✅ Conexión exitosa a la base de datos";

?>
