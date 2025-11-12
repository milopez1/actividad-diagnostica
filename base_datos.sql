<?php
/**
 * Script SQL para crear la Base de Datos y Tablas
 * Ejecuta este script en phpMyAdmin o MySQL Workbench
 */

-- =====================================================
-- CREAR BASE DE DATOS
-- =====================================================
CREATE DATABASE IF NOT EXISTS autoevaluacion_aa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE autoevaluacion_aa;

-- =====================================================
-- TABLA: participantes
-- =====================================================
CREATE TABLE IF NOT EXISTS participantes (
    id_participante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    fecha_evaluacion DATE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('completado', 'incompleto', 'revisado') DEFAULT 'completado',
    INDEX idx_email (email),
    INDEX idx_fecha (fecha_evaluacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: respuestas
-- =====================================================
CREATE TABLE IF NOT EXISTS respuestas (
    id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
    id_participante INT NOT NULL,
    numero_pregunta INT NOT NULL,
    seccion VARCHAR(50) NOT NULL,
    respuesta ENUM('si', 'parcial', 'no') NOT NULL,
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_participante) REFERENCES participantes(id_participante) ON DELETE CASCADE,
    INDEX idx_participante (id_participante),
    INDEX idx_pregunta (numero_pregunta),
    INDEX idx_seccion (seccion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: comentarios
-- =====================================================
CREATE TABLE IF NOT EXISTS comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_participante INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_participante) REFERENCES participantes(id_participante) ON DELETE CASCADE,
    INDEX idx_participante (id_participante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: usuarios_admin (para acceso administrativo)
-- =====================================================
CREATE TABLE IF NOT EXISTS usuarios_admin (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    email_admin VARCHAR(120) NOT NULL UNIQUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    INDEX idx_usuario (nombre_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERTAR USUARIO ADMIN POR DEFECTO
-- =====================================================
-- Usuario: admin, Contraseña: admin123 (cambiar después del primer acceso)
INSERT INTO usuarios_admin (nombre_usuario, contraseña, email_admin) 
VALUES ('admin', '$2y$10$YIjlrTyapмикроSoft2024DefaultHashExample', 'admin@autoevaluacion.local');

-- =====================================================
-- TABLA: auditoria (para registrar cambios)
-- =====================================================
CREATE TABLE IF NOT EXISTS auditoria (
    id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
    id_participante INT,
    accion VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_accion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    direccion_ip VARCHAR(45),
    FOREIGN KEY (id_participante) REFERENCES participantes(id_participante) ON DELETE SET NULL,
    INDEX idx_fecha (fecha_accion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- VISTA: resumen_evaluaciones
-- =====================================================
CREATE VIEW resumen_evaluaciones AS
SELECT 
    p.id_participante,
    p.nombre,
    p.email,
    p.fecha_evaluacion,
    COUNT(DISTINCT r.id_respuesta) as total_respuestas,
    SUM(CASE WHEN r.respuesta = 'si' THEN 1 ELSE 0 END) as respuestas_si,
    SUM(CASE WHEN r.respuesta = 'parcial' THEN 1 ELSE 0 END) as respuestas_parcial,
    SUM(CASE WHEN r.respuesta = 'no' THEN 1 ELSE 0 END) as respuestas_no,
    ROUND((SUM(CASE WHEN r.respuesta = 'si' THEN 1 ELSE 0 END) / COUNT(DISTINCT r.id_respuesta) * 100), 2) as porcentaje_si,
    p.estado
FROM participantes p
LEFT JOIN respuestas r ON p.id_participante = r.id_participante
GROUP BY p.id_participante;

-- =====================================================
-- Mensaje de confirmación
-- =====================================================
-- ✅ Base de datos creada exitosamente
-- Tablas creadas: participantes, respuestas, comentarios, usuarios_admin, auditoria
-- Vista creada: resumen_evaluaciones
