# 📖 GUÍA COMPLETA: Conectar Formulario a Base de Datos MySQL

## 🎯 Resumen de Archivos Creados

Se han generado 4 archivos principales:
- `config.php` - Configuración de conexión a MySQL
- `procesar_formulario.php` - Script que procesa y guarda los datos
- `base_datos.sql` - Script SQL para crear la base de datos
- `script.js` - Validación y envío del formulario por AJAX

---

## 📋 PASO 1: Instalar y Configurar XAMPP (Servidor Local)

### 1.1 Descargar e Instalar XAMPP
1. Ve a: https://www.apachefriends.org/
2. Descarga la versión para Windows
3. Ejecuta el instalador
4. Acepta la ruta por defecto: `C:\xampp`
5. Marca solo Apache y MySQL (las opciones recomendadas)
6. Completa la instalación

### 1.2 Iniciar los Servicios
1. Abre el **XAMPP Control Panel** (icono de XAMPP)
2. Haz clic en **Start** para:
   - Apache
   - MySQL

Debe lucir así:
```
Apache: Running [PID: 1234]
MySQL: Running [PID: 5678]
```

---

## 💾 PASO 2: Crear la Base de Datos

### 2.1 Acceder a phpMyAdmin
1. Abre tu navegador
2. Dirígete a: `http://localhost/phpmyadmin`
3. Usuario: `root`
4. Contraseña: (deja en blanco si es la primera vez)

### 2.2 Crear la Base de Datos y Tablas
1. En phpMyAdmin, haz clic en la pestaña **SQL**
2. Copia y pega TODO el contenido del archivo `base_datos.sql`
3. Haz clic en **Ejecutar**

Deberías ver el mensaje: ✅ Base de datos creada exitosamente

### 2.3 Verificar las Tablas
En el panel izquierdo, bajo "autoevaluacion_aa", deberías ver:
- ✅ participantes
- ✅ respuestas
- ✅ comentarios
- ✅ usuarios_admin
- ✅ auditoria

---

## 📂 PASO 3: Copiar Archivos al Servidor

### 3.1 Localizar la Carpeta de Servidor
1. Abre el Explorador de Archivos
2. Dirígete a: `C:\xampp\htdocs`

### 3.2 Copiar Proyecto
1. Copia TODA la carpeta de tu proyecto al escritorio
2. Renómbrala a: `autoevaluacion_aa` (sin espacios, con guiones)
3. Pega la carpeta en `C:\xampp\htdocs`

La estructura debe quedar así:
```
C:\xampp\htdocs\
└── autoevaluacion_aa\
    ├── MarthaInesL.html
    ├── MarthaInesL.css
    ├── script.js
    ├── config.php
    ├── procesar_formulario.php
    └── base_datos.sql
```

---

## ⚙️ PASO 4: Configurar la Conexión (IMPORTANTE)

### 4.1 Editar config.php
1. Abre la carpeta: `C:\xampp\htdocs\autoevaluacion_aa`
2. Abre `config.php` con un editor de texto (Notepad, VS Code, etc.)
3. Verifica que esté así:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');              // ← Si no tiene contraseña, déjalo vacío
define('DB_NAME', 'autoevaluacion_aa');
```

**IMPORTANTE**: Si configuraste contraseña para MySQL durante la instalación, agrega tu contraseña:
```php
define('DB_PASS', 'tu_contraseña_aqui');
```

4. Guarda el archivo (Ctrl + S)

---

## 🌐 PASO 5: Acceder al Formulario

### 5.1 Abrir en el Navegador
1. Abre tu navegador (Chrome, Firefox, Edge, etc.)
2. Dirígete a: `http://localhost/autoevaluacion_aa/MarthaInesL.html`

¡Deberías ver tu formulario! 🎉

### 5.2 Pruebar el Formulario
1. Completa todos los campos:
   - Nombre: Tu Nombre
   - Email: tu@email.com
   - Fecha: 2025-11-12
   - Contraseña: contraseña123
   - Responde las preguntas
   - Marca el checkbox de certificación
   
2. Haz clic en "📤 Enviar Evaluación"

3. Deberías ver: ✅ ¡Evaluación guardada exitosamente! ID: #1

---

## ✅ PASO 6: Verificar los Datos Guardados

### 6.1 En phpMyAdmin
1. Ve a: `http://localhost/phpmyadmin`
2. En el menú izquierdo, selecciona `autoevaluacion_aa`
3. Selecciona la tabla `participantes`
4. Haz clic en la pestaña **Examinar**

Deberías ver tu registro guardado! ✅

### 6.2 Ver Respuestas
1. Selecciona la tabla `respuestas`
2. Haz clic en **Examinar**
3. Verás todas las respuestas guardadas con su ID de participante

---

## 🔧 SOLUCIÓN DE PROBLEMAS

### ❌ Problema: "Cannot find server"
**Solución:**
- Verifica que Apache y MySQL estén corriendo en XAMPP Control Panel
- Asegúrate de que la carpeta está en `C:\xampp\htdocs`

### ❌ Problema: "Conexión rechazada"
**Solución:**
- Verifica el nombre de usuario y contraseña en `config.php`
- Inicia MySQL desde XAMPP Control Panel
- Abre phpMyAdmin y verifica que puedas acceder

### ❌ Problema: "Base de datos no encontrada"
**Solución:**
- Abre phpMyAdmin
- Copia el contenido de `base_datos.sql`
- Pégalo en la pestaña SQL y ejecuta
- Verifica que la BD se creó

### ❌ Problema: "Error al enviar el formulario"
**Solución:**
- Abre la Consola (F12 en el navegador) > Pestaña Console
- Verifica si hay mensajes de error
- Asegúrate de que `procesar_formulario.php` está en la carpeta correcta

---

## 📊 PASO 7: Ver un Resumen de Evaluaciones

### 7.1 Consulta SQL para Ver Resumen
En phpMyAdmin, pestaña SQL, ejecuta:

```sql
SELECT * FROM resumen_evaluaciones;
```

Verás un resumen con:
- Nombre del participante
- Total de respuestas
- Cantidad de "Sí", "Parcial" y "No"
- Porcentaje de respuestas positivas
- Estado

---

## 🚀 PASO 8: Crear Panel Administrativo (Opcional)

Puedes crear un archivo `admin.php` para ver un resumen de todas las evaluaciones:

```php
<?php
require_once 'config.php';

// Obtener todas las evaluaciones
$result = $conexion->query("SELECT * FROM resumen_evaluaciones");

echo "<h1>Resumen de Evaluaciones</h1>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Total Respuestas</th><th>% Sí</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id_participante'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['total_respuestas'] . "</td>";
    echo "<td>" . $row['porcentaje_si'] . "%</td>";
    echo "</tr>";
}
echo "</table>";
?>
```

---

## 📝 NOTAS IMPORTANTES

1. **Seguridad**: En producción, cambia la contraseña del admin en la base de datos
2. **Backup**: Realiza copias de seguridad regulares de tu base de datos
3. **Contraseñas**: Las contraseñas del formulario se guardan en texto plano; para producción, encriptalas con `password_hash()`
4. **Datos Sensibles**: No guardes datos sensibles como contraseñas en la BD sin cifrar

---

## 🆘 CONTACTO Y AYUDA

Si necesitas ayuda adicional:
1. Verifica que los archivos estén en la carpeta correcta
2. Revisa los logs de errores en `C:\xampp\apache\logs`
3. Consulta la consola del navegador (F12)
4. Verifica phpMyAdmin para confirmar que los datos se guardan

---

## ✨ ¡ÉXITO!

Tu formulario ahora está conectado a MySQL y guardando datos exitosamente. 🎉🕊️

Si tienes más preguntas, no dudes en preguntar. 💪
