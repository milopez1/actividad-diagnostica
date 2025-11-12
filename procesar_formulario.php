<?php
/**
 * Procesar el Formulario de Autoevaluación
 * Archivo: procesar_formulario.php
 */

// Incluir la configuración de la base de datos
require_once 'config.php';

// Variable para almacenar mensajes
$mensaje = '';
$tipo_mensaje = ''; // 'success' o 'error'

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        // ========== VALIDAR DATOS ==========
        
        // Obtener y limpiar datos del participante
        $nombre = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fecha_evaluacion = trim($_POST['date'] ?? '');
        $contraseña = trim($_POST['password'] ?? '');
        $comentarios = trim($_POST['comments'] ?? '');
        $acepta_certificacion = isset($_POST['agree']) ? true : false;
        
        // Validar campos requeridos
        if (empty($nombre)) {
            throw new Exception("El nombre es requerido");
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Por favor, ingresa un email válido");
        }
        
        if (empty($fecha_evaluacion)) {
            throw new Exception("La fecha de evaluación es requerida");
        }
        
        if (empty($contraseña) || strlen($contraseña) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres");
        }
        
        if (!$acepta_certificacion) {
            throw new Exception("Debes certificar que has respondido con honestidad");
        }
        
        // ========== VERIFICAR EMAIL ÚNICO ==========
        $stmt_verificar = $conexion->prepare("SELECT id_participante FROM participantes WHERE email = ?");
        $stmt_verificar->bind_param("s", $email);
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();
        
        if ($resultado->num_rows > 0) {
            throw new Exception("Este email ya existe en el sistema. Por favor, usa otro email");
        }
        $stmt_verificar->close();
        
        // ========== INSERTAR PARTICIPANTE ==========
        $stmt_participante = $conexion->prepare(
            "INSERT INTO participantes (nombre, email, fecha_evaluacion, estado) 
             VALUES (?, ?, ?, 'completado')"
        );
        
        if (!$stmt_participante) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        $stmt_participante->bind_param("sss", $nombre, $email, $fecha_evaluacion);
        
        if (!$stmt_participante->execute()) {
            throw new Exception("Error al guardar el participante: " . $stmt_participante->error);
        }
        
        $id_participante = $stmt_participante->insert_id;
        $stmt_participante->close();
        
        // ========== INSERTAR RESPUESTAS ==========
        $stmt_respuestas = $conexion->prepare(
            "INSERT INTO respuestas (id_participante, numero_pregunta, seccion, respuesta) 
             VALUES (?, ?, ?, ?)"
        );
        
        if (!$stmt_respuestas) {
            throw new Exception("Error en la preparación de consulta de respuestas: " . $conexion->error);
        }
        
        // Mapeo de preguntas a secciones
        $mapeo_secciones = [
            1 => 'I. Unidad y Bienestar Común',
            2 => 'I. Unidad y Bienestar Común',
            3 => 'I. Unidad y Bienestar Común',
            4 => 'I. Unidad y Bienestar Común',
            5 => 'I. Unidad y Bienestar Común',
            6 => 'II. Autoridad Espiritual y Servicio',
            7 => 'II. Autoridad Espiritual y Servicio',
            8 => 'II. Autoridad Espiritual y Servicio',
            9 => 'III. Pertenencia y Aceptación',
            10 => 'III. Pertenencia y Aceptación',
            11 => 'III. Pertenencia y Aceptación',
            12 => 'IV. Amor y Tolerancia',
            13 => 'IV. Amor y Tolerancia',
            14 => 'IV. Amor y Tolerancia',
            15 => 'V. Dinero, Propiedad y Poder',
            16 => 'V. Dinero, Propiedad y Poder',
            17 => 'V. Dinero, Propiedad y Poder',
            18 => 'VI. Anonimato y Humildad',
            19 => 'VI. Anonimato y Humildad',
            20 => 'VI. Anonimato y Humildad',
            21 => 'VII. Restauración del Espíritu de Unidad',
            22 => 'VII. Restauración del Espíritu de Unidad',
            23 => 'VII. Restauración del Espíritu de Unidad'
        ];
        
        // Procesar respuestas de preguntas (q1 a q23)
        for ($i = 1; $i <= 23; $i++) {
            $nombre_pregunta = "q" . $i;
            $respuesta = $_POST[$nombre_pregunta] ?? null;
            
            if ($respuesta) {
                $seccion = $mapeo_secciones[$i] ?? 'Sin Sección';
                $stmt_respuestas->bind_param("iiss", $id_participante, $i, $seccion, $respuesta);
                
                if (!$stmt_respuestas->execute()) {
                    throw new Exception("Error al guardar respuesta de pregunta $i: " . $stmt_respuestas->error);
                }
            }
        }
        $stmt_respuestas->close();
        
        // ========== INSERTAR COMENTARIOS ==========
        if (!empty($comentarios)) {
            $stmt_comentarios = $conexion->prepare(
                "INSERT INTO comentarios (id_participante, comentario) VALUES (?, ?)"
            );
            
            if (!$stmt_comentarios) {
                throw new Exception("Error en la preparación de consulta de comentarios: " . $conexion->error);
            }
            
            $stmt_comentarios->bind_param("is", $id_participante, $comentarios);
            
            if (!$stmt_comentarios->execute()) {
                throw new Exception("Error al guardar comentarios: " . $stmt_comentarios->error);
            }
            $stmt_comentarios->close();
        }
        
        // ========== REGISTRAR EN AUDITORIA ==========
        $accion = "FORMULARIO_ENVIADO";
        $descripcion = "Evaluación completada por " . $nombre;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        
        $stmt_auditoria = $conexion->prepare(
            "INSERT INTO auditoria (id_participante, accion, descripcion, direccion_ip) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt_auditoria->bind_param("isss", $id_participante, $accion, $descripcion, $ip);
        $stmt_auditoria->execute();
        $stmt_auditoria->close();
        
        // ========== ÉXITO ==========
        $mensaje = "✅ ¡Evaluación guardada exitosamente! ID: #" . $id_participante;
        $tipo_mensaje = "success";
        
        // Opcional: Enviar email de confirmación
        // enviar_email_confirmacion($email, $nombre, $id_participante);
        
    } catch (Exception $e) {
        $mensaje = "❌ Error: " . $e->getMessage();
        $tipo_mensaje = "error";
    }
}

// Cerrar la conexión cuando se termina el script
// $conexion->close();

// Retornar resultado como JSON (para AJAX)
if (!empty($_POST)) {
    header('Content-Type: application/json');
    echo json_encode([
        'exito' => ($tipo_mensaje === 'success'),
        'mensaje' => $mensaje,
        'tipo' => $tipo_mensaje
    ]);
    exit();
}

?>
