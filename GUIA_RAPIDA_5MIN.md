# 🚀 GUÍA RÁPIDA DE 5 MINUTOS

## Paso 1️⃣: Descargar e Instalar XAMPP (2 min)
```
1. Visita: https://www.apachefriends.org/
2. Descarga para Windows
3. Ejecuta y instala (siguiendo pasos recomendados)
4. Al terminar, abre "XAMPP Control Panel"
```

## Paso 2️⃣: Iniciar Servicios (30 seg)
```
En XAMPP Control Panel:
✅ Haz clic en "Start" junto a Apache
✅ Haz clic en "Start" junto a MySQL

Ambos deben mostrar: Running
```

## Paso 3️⃣: Crear Base de Datos (1 min)
```
1. Abre navegador → http://localhost/phpmyadmin
2. Haz clic en pestaña: SQL
3. Copia y pega TODO el contenido de: base_datos.sql
4. Haz clic en: EJECUTAR ⚡
```

## Paso 4️⃣: Copiar Archivos (1 min)
```
1. Copia la carpeta de tu proyecto
2. Pégala en: C:\xampp\htdocs\
3. Renómbrala a: autoevaluacion_aa
```

## Paso 5️⃣: Configurar (30 seg)
```
1. Abre: C:\xampp\htdocs\autoevaluacion_aa\config.php
2. Verifica que tenga:
   - DB_HOST: 'localhost'
   - DB_USER: 'root'
   - DB_PASS: '' (vacío si no tiene contraseña)
   - DB_NAME: 'autoevaluacion_aa'
3. Guarda (Ctrl + S)
```

## Paso 6️⃣: ¡A Funcionar! (30 seg)
```
1. Abre navegador
2. Dirígete a: http://localhost/autoevaluacion_aa/MarthaInesL.html
3. ¡Completa el formulario!
4. Haz clic en "Enviar Evaluación"
```

## Paso 7️⃣: Verificar Datos (1 min)
```
1. Ve a: http://localhost/phpmyadmin
2. Base de datos: autoevaluacion_aa
3. Tabla: participantes
4. Pestaña: Examinar

¡Verás tu evaluación guardada! ✅
```

---

## ⚡ ATAJOS ÚTILES

| Necesito... | Dirección | Función |
|------------|-----------|---------|
| Abrir formulario | `http://localhost/autoevaluacion_aa/MarthaInesL.html` | Responder evaluación |
| Ver datos guardados | `http://localhost/phpmyadmin` | Administrar BD |
| Controlar servidor | Ver XAMPP Control Panel | Iniciar/detener servicios |

---

## ✅ CHECKLIST DE VERIFICACIÓN

- [ ] XAMPP instalado y servicios corriendo
- [ ] phpMyAdmin accesible
- [ ] Base de datos creada
- [ ] Carpeta en `C:\xampp\htdocs\autoevaluacion_aa`
- [ ] `config.php` configurado correctamente
- [ ] Formulario carga en navegador
- [ ] Puedo enviar una evaluación
- [ ] Datos aparecen en phpMyAdmin

---

## 🆘 SI ALGO NO FUNCIONA

1. **Página no carga**
   → Abre XAMPP Control Panel y verifica que Apache esté "Running"

2. **Error de conexión a BD**
   → Verifica que MySQL esté "Running" en XAMPP

3. **No aparecen datos**
   → Comprueba que `base_datos.sql` fue ejecutado correctamente

4. **Formulario no envía**
   → Abre Consola (F12) y ve si hay errores JavaScript

---

## 📧 ESTRUCTURA DE DATOS GUARDADA

Cuando envías el formulario, se guarda:

**Tabla: participantes**
- ID única
- Tu nombre
- Tu email (único)
- Fecha de evaluación
- Fecha de creación

**Tabla: respuestas**
- 23 respuestas (una por pregunta)
- Cada una con: número, sección y tu respuesta (sí/parcial/no)

**Tabla: comentarios**
- Tus reflexiones adicionales

**Tabla: auditoria**
- Registro de que se completó

---

## 🎓 EJEMPLO DE USO

```
Nombre: Juan García
Email: juan@example.com
Fecha: 2025-11-12
Contraseña: micontraseña123

Respuestas:
- P1: Sí, completamente
- P2: Parcialmente
- P3: No
... (21 preguntas más)

Comentarios: "Muy interesante el proceso..."

✅ ENVIADO → Se guardan TODOS los datos en MySQL
```

---

## 📊 VER RESULTADOS

En phpMyAdmin, ejecuta esta consulta SQL:

```sql
SELECT nombre, email, total_respuestas, porcentaje_si 
FROM resumen_evaluaciones;
```

Esto te mostrará un resumen de todas las evaluaciones.

---

**¡Listo! Ahora tu formulario está completamente funcional con MySQL. 🎉🕊️**
