<?php
/**
 * ARCHIVO DE REFERENCIA: Consultas Útiles SQL y PHP
 * Aquí encontrarás ejemplos de consultas útiles
 * NO EJECUTAR ESTE ARCHIVO - Es solo referencia
 */

// =====================================================
// CONSULTAS ÚTILES EN PHPMYADMIN
// =====================================================

/*

1. VER TODAS LAS EVALUACIONES COMPLETADAS
-------------------------------------------
SELECT 
    p.id_participante,
    p.nombre,
    p.email,
    DATE_FORMAT(p.fecha_evaluacion, '%d/%m/%Y') as fecha,
    p.estado
FROM participantes p
ORDER BY p.fecha_creacion DESC;


2. VER RESUMEN CON ESTADÍSTICAS
---------------------------------
SELECT * FROM resumen_evaluaciones;


3. VER RESPUESTAS DE UN PARTICIPANTE ESPECÍFICO
------------------------------------------------
SELECT 
    r.numero_pregunta,
    r.seccion,
    r.respuesta,
    DATE_FORMAT(r.fecha_respuesta, '%d/%m/%Y %H:%i') as fecha
FROM respuestas r
WHERE r.id_participante = 1  -- Cambiar 1 por el ID del participante
ORDER BY r.numero_pregunta;


4. CONTAR RESPUESTAS POR TIPO
------------------------------
SELECT 
    respuesta,
    COUNT(*) as cantidad,
    ROUND((COUNT(*) / (SELECT COUNT(*) FROM respuestas) * 100), 2) as porcentaje
FROM respuestas
GROUP BY respuesta;


5. VER COMENTARIOS DE UN PARTICIPANTE
--------------------------------------
SELECT 
    c.comentario,
    DATE_FORMAT(c.fecha_comentario, '%d/%m/%Y %H:%i') as fecha
FROM comentarios c
JOIN participantes p ON c.id_participante = p.id_participante
WHERE p.id_participante = 1  -- Cambiar 1 por el ID
ORDER BY c.fecha_comentario DESC;


6. VER CUÁNTAS EVALUACIONES SE HICIERON POR DÍA
-------------------------------------------------
SELECT 
    DATE_FORMAT(fecha_evaluacion, '%Y-%m-%d') as dia,
    COUNT(*) as total_evaluaciones
FROM participantes
GROUP BY DATE_FORMAT(fecha_evaluacion, '%Y-%m-%d')
ORDER BY dia DESC;


7. BUSCAR PARTICIPANTE POR EMAIL
----------------------------------
SELECT * FROM participantes 
WHERE email LIKE '%nombre@ejemplo%';


8. VER REGISTRO DE AUDITORÍA
------------------------------
SELECT 
    a.id_auditoria,
    a.accion,
    a.descripcion,
    DATE_FORMAT(a.fecha_accion, '%d/%m/%Y %H:%i') as fecha,
    a.direccion_ip
FROM auditoria a
ORDER BY a.fecha_accion DESC
LIMIT 50;


9. ESTADÍSTICAS POR SECCIÓN
-----------------------------
SELECT 
    seccion,
    SUM(CASE WHEN respuesta = 'si' THEN 1 ELSE 0 END) as respuestas_si,
    SUM(CASE WHEN respuesta = 'parcial' THEN 1 ELSE 0 END) as respuestas_parcial,
    SUM(CASE WHEN respuesta = 'no' THEN 1 ELSE 0 END) as respuestas_no
FROM respuestas
GROUP BY seccion
ORDER BY seccion;


10. EXPORTAR EVALUACIÓN A TEXTO
---------------------------------
SELECT 
    CONCAT('Evaluación #', p.id_participante, '\n',
           'Nombre: ', p.nombre, '\n',
           'Email: ', p.email, '\n',
           'Fecha: ', p.fecha_evaluacion, '\n',
           '---\n',
           GROUP_CONCAT(CONCAT('P', r.numero_pregunta, ': ', r.respuesta) 
                        SEPARATOR '\n')) as reporte
FROM participantes p
LEFT JOIN respuestas r ON p.id_participante = r.id_participante
WHERE p.id_participante = 1  -- Cambiar 1 por el ID
GROUP BY p.id_participante;

*/

// =====================================================
// CÓDIGO PHP ÚTIL
// =====================================================

// 1. OBTENER TODAS LAS EVALUACIONES
/*
<?php
require_once 'config.php';

$sql = "SELECT * FROM resumen_evaluaciones";
$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id_participante'] . "<br>";
    echo "Nombre: " . $row['nombre'] . "<br>";
    echo "% Positivo: " . $row['porcentaje_si'] . "%<br>";
    echo "---<br>";
}
?>
*/

// 2. BUSCAR UN PARTICIPANTE
/*
<?php
require_once 'config.php';

$email = "juan@example.com";
$stmt = $conexion->prepare("SELECT * FROM participantes WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $participante = $result->fetch_assoc();
    echo "Encontrado: " . $participante['nombre'];
} else {
    echo "No encontrado";
}
$stmt->close();
?>
*/

// 3. CONTAR EVALUACIONES TOTALES
/*
<?php
require_once 'config.php';

$sql = "SELECT COUNT(*) as total FROM participantes";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

echo "Total de evaluaciones: " . $row['total'];
?>
*/

// 4. OBTENER RESPUESTAS DE UN PARTICIPANTE
/*
<?php
require_once 'config.php';

$id_participante = 1;
$stmt = $conexion->prepare(
    "SELECT numero_pregunta, seccion, respuesta 
     FROM respuestas 
     WHERE id_participante = ? 
     ORDER BY numero_pregunta"
);
$stmt->bind_param("i", $id_participante);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "P" . $row['numero_pregunta'] . " (" . $row['seccion'] . "): " . $row['respuesta'] . "<br>";
}
$stmt->close();
?>
*/

// 5. ELIMINAR UNA EVALUACIÓN
/*
<?php
require_once 'config.php';

$id_participante = 1;  // Cambiar por el ID a eliminar

$stmt = $conexion->prepare("DELETE FROM participantes WHERE id_participante = ?");
$stmt->bind_param("i", $id_participante);

if ($stmt->execute()) {
    echo "Evaluación eliminada exitosamente";
} else {
    echo "Error al eliminar: " . $stmt->error;
}
$stmt->close();
?>
*/

// =====================================================
// FUNCIONES ÚTILES PARA PHP
// =====================================================

// Función para obtener todas las evaluaciones
/*
function obtener_todas_evaluaciones($conexion) {
    $sql = "SELECT * FROM resumen_evaluaciones";
    $result = $conexion->query($sql);
    
    $evaluaciones = [];
    while ($row = $result->fetch_assoc()) {
        $evaluaciones[] = $row;
    }
    return $evaluaciones;
}
*/

// Función para obtener evaluación por ID
/*
function obtener_evaluacion($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * FROM participantes WHERE id_participante = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $evaluacion = $result->fetch_assoc();
    $stmt->close();
    return $evaluacion;
}
*/

// Función para obtener respuestas de un participante
/*
function obtener_respuestas($conexion, $id_participante) {
    $stmt = $conexion->prepare(
        "SELECT numero_pregunta, seccion, respuesta 
         FROM respuestas 
         WHERE id_participante = ? 
         ORDER BY numero_pregunta"
    );
    $stmt->bind_param("i", $id_participante);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $respuestas = [];
    while ($row = $result->fetch_assoc()) {
        $respuestas[] = $row;
    }
    $stmt->close();
    return $respuestas;
}
*/

// =====================================================
// EXPORTAR A CSV (Excel)
// =====================================================

/*
<?php
require_once 'config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="evaluaciones.csv"');

$output = fopen('php://output', 'w');

// Encabezados
fputcsv($output, ['ID', 'Nombre', 'Email', 'Fecha', 'Total Respuestas', '% Positivo']);

// Datos
$sql = "SELECT * FROM resumen_evaluaciones";
$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id_participante'],
        $row['nombre'],
        $row['email'],
        $row['fecha_evaluacion'],
        $row['total_respuestas'],
        $row['porcentaje_si']
    ]);
}

fclose($output);
exit();
?>
*/

// =====================================================
// ENVIAR EMAIL (Requiere PHPMailer)
// =====================================================

/*
<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

function enviar_confirmacion($email, $nombre, $id) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tu@gmail.com';
        $mail->Password = 'tu_contraseña';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('admin@autoevaluacion.local', 'Administrador');
        $mail->addAddress($email);
        $mail->Subject = '✅ Evaluación Recibida';
        $mail->Body = "Hola $nombre,\n\nTu evaluación ha sido recibida correctamente con ID: #$id\n\nGracias.";
        
        $mail->send();
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>
*/

?>
