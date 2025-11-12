# 🕊️ Autoevaluación Grupal de A.A. - Formulario Web

## 📌 Descripción del Proyecto

Sistema web completo para la realización de autoevaluaciones grupales basado en "La Tradición de A.A. Cómo se desarrolló".

**Características:**
- ✅ Formulario responsive y visualmente atractivo
- ✅ Almacenamiento seguro en MySQL
- ✅ Validación de datos en tiempo real
- ✅ Panel administrativo para ver resultados
- ✅ Interfaz intuitiva y fácil de usar

---

## 📂 Estructura de Archivos

```
autoevaluacion_aa/
│
├── 📄 MarthaInesL.html          ← Formulario principal
├── 🎨 MarthaInesL.css           ← Estilos del formulario
├── 📜 script.js                 ← Validación y envío AJAX
├── ⚙️  config.php               ← Configuración MySQL
├── 💾 procesar_formulario.php   ← Procesamiento del formulario
├── 🗄️  base_datos.sql           ← Script para crear BD
└── 📖 INSTRUCCIONES_CONEXION_MySQL.md ← Guía completa
```

---

## 🚀 Inicio Rápido

### Requisitos Previos
- **XAMPP** instalado (Apache + MySQL)
- **Navegador web** moderno
- **Editor de texto** (VS Code, Notepad++, etc.)

### Pasos Rápidos

1. **Copiar proyecto a XAMPP**
   ```
   C:\xampp\htdocs\autoevaluacion_aa
   ```

2. **Crear base de datos**
   - Abrir phpMyAdmin: `http://localhost/phpmyadmin`
   - Copiar contenido de `base_datos.sql`
   - Ejecutar en la pestaña SQL

3. **Configurar conexión**
   - Editar `config.php`
   - Verificar credenciales MySQL

4. **Acceder al formulario**
   ```
   http://localhost/autoevaluacion_aa/MarthaInesL.html
   ```

---

## 📋 Secciones del Formulario

### I. Unidad y Bienestar Común
- 5 preguntas sobre cohesión grupal

### II. Autoridad Espiritual y Servicio
- 3 preguntas sobre liderazgo y decisiones

### III. Pertenencia y Aceptación
- 3 preguntas sobre inclusión

### IV. Amor y Tolerancia
- 3 preguntas sobre valores espirituales

### V. Dinero, Propiedad y Poder
- 3 preguntas sobre recursos materiales

### VI. Anonimato y Humildad
- 3 preguntas sobre principios

### VII. Restauración del Espíritu de Unidad
- 3 preguntas sobre reconciliación

---

## 🎨 Características Técnicas

### Frontend
- HTML5 semántico
- CSS3 con gradientes y animaciones
- JavaScript vanilla para validación
- Diseño responsive (Mobile First)
- AJAX para envío sin recargar página

### Backend
- PHP 7.4+
- MySQLi para conexión segura
- Prepared Statements contra SQL Injection
- Validación en servidor

### Base de Datos
- **Tablas principales:**
  - `participantes`: Datos de quien responde
  - `respuestas`: Respuestas a cada pregunta
  - `comentarios`: Reflexiones adicionales
  - `usuarios_admin`: Para acceso administrativo
  - `auditoria`: Registro de acciones

---

## 🔐 Seguridad

- ✅ Validación en cliente Y servidor
- ✅ Prepared Statements (previene SQL Injection)
- ✅ Caracteres UTF-8 configurados
- ✅ Emails únicos verificados
- ✅ Registro de auditoría

---

## 📊 Ver Resultados

### En phpMyAdmin
1. Abre: `http://localhost/phpmyadmin`
2. Selecciona base de datos: `autoevaluacion_aa`
3. Visualiza tablas:
   - Tabla `participantes`
   - Tabla `respuestas`
   - Vista `resumen_evaluaciones`

### Consulta SQL Útil
```sql
SELECT * FROM resumen_evaluaciones;
```

---

## 🛠️ Personalización

### Cambiar Colores
En `MarthaInesL.css`, edita las variables CSS:
```css
:root {
    --primary-color: #FF6B9D;      /* Cambia este color */
    --secondary-color: #FFD93D;
    --accent-color: #6BCB77;
    /* ... */
}
```

### Cambiar Preguntas
En `MarthaInesL.html`, busca `<section class="form-section">` y edita las preguntas.

### Cambiar Credenciales MySQL
En `config.php`:
```php
define('DB_USER', 'root');
define('DB_PASS', 'tu_contraseña');
```

---

## 🐛 Troubleshooting

| Problema | Solución |
|----------|----------|
| Página no carga | Verifica que Apache esté corriendo |
| Error de conexión | Revisa config.php |
| Datos no se guardan | Verifica que MySQL esté corriendo |
| Email rechazado | Usa formato válido: user@domain.com |

---

## 📈 Próximas Mejoras Posibles

- [ ] Sistema de login para administradores
- [ ] Panel de análisis de resultados
- [ ] Exportación a PDF/Excel
- [ ] Envío de correos confirmación
- [ ] Gráficos de estadísticas
- [ ] API REST
- [ ] Aplicación móvil

---

## 📄 Licencia

Este proyecto es de uso libre para la comunidad de A.A.

---

## 👤 Autor

Creado para la **Comunidad de Alcohólicos Anónimos**

---

## 📞 Soporte

Para preguntas técnicas o reportar problemas, contacta al administrador del sitio.

---

**¡Que el espíritu de A.A. nos guíe siempre hacia la unidad, el servicio y el amor!** 🕊️
