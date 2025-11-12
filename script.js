/**
 * Script para procesar el formulario de autoevaluación
 * Archivo: script.js
 */

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('evaluationForm');
    const mensajeDiv = document.getElementById('mensaje');

    // Escuchar el envío del formulario
    formulario.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validar que al menos una pregunta esté respondida
        let preguntasRespondidas = 0;
        for (let i = 1; i <= 23; i++) {
            const radio = document.querySelector(`input[name="q${i}"]:checked`);
            if (radio) {
                preguntasRespondidas++;
            }
        }

        if (preguntasRespondidas === 0) {
            mostrarMensaje('❌ Debes responder al menos algunas preguntas', 'error');
            return;
        }

        // Enviar el formulario por AJAX
        enviarFormulario();
    });

    /**
     * Función para enviar el formulario por AJAX
     */
    function enviarFormulario() {
        // Mostrar indicador de carga
        mostrarMensaje('⏳ Enviando evaluación...', 'info');
        const botonSubmit = document.querySelector('.btn-submit');
        botonSubmit.disabled = true;

        // Crear FormData del formulario
        const formData = new FormData(formulario);

        // Enviar por AJAX
        fetch('procesar_formulario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            botonSubmit.disabled = false;

            if (data.exito) {
                mostrarMensaje(data.mensaje, 'success');
                
                // Limpiar el formulario después de 2 segundos
                setTimeout(() => {
                    formulario.reset();
                    // Scroll al inicio
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 2000);
            } else {
                mostrarMensaje(data.mensaje, 'error');
            }
        })
        .catch(error => {
            botonSubmit.disabled = false;
            console.error('Error:', error);
            mostrarMensaje('❌ Error al enviar el formulario. Por favor, intenta de nuevo.', 'error');
        });
    }

    /**
     * Función para mostrar mensajes al usuario
     * @param {string} texto - El mensaje a mostrar
     * @param {string} tipo - El tipo de mensaje: 'success', 'error', 'info'
     */
    function mostrarMensaje(texto, tipo) {
        mensajeDiv.textContent = texto;
        mensajeDiv.className = `mensaje-estado mensaje-${tipo}`;
        mensajeDiv.style.display = 'block';

        // Auto-ocultarse después de 5 segundos (excepto en error)
        if (tipo !== 'error') {
            setTimeout(() => {
                mensajeDiv.style.display = 'none';
            }, 5000);
        }

        // Scroll al mensaje
        mensajeDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Validación en tiempo real del email
     */
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email && !isEmailValido(email)) {
                mostrarMensaje('❌ Por favor, ingresa un email válido', 'error');
            }
        });
    }

    /**
     * Validación de la contraseña
     */
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            const password = this.value;
            if (password && password.length < 6) {
                mostrarMensaje('⚠️ La contraseña debe tener al menos 6 caracteres', 'info');
            }
        });
    }

    /**
     * Función para validar formato de email
     * @param {string} email
     * @returns {boolean}
     */
    function isEmailValido(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    /**
     * Contar respuestas en tiempo real
     */
    document.addEventListener('change', function(e) {
        if (e.target.name.startsWith('q')) {
            actualizarContador();
        }
    });

    /**
     * Función para actualizar contador de respuestas
     */
    function actualizarContador() {
        let respondidas = 0;
        for (let i = 1; i <= 23; i++) {
            const radio = document.querySelector(`input[name="q${i}"]:checked`);
            if (radio) {
                respondidas++;
            }
        }
        
        // Aquí puedes agregar un indicador visual del progreso
        console.log(`Preguntas respondidas: ${respondidas}/23`);
    }
});

/**
 * Función para exportar respuestas a PDF (opcional)
 * Requiere una librería como jsPDF
 */
function exportarAPDF() {
    // Esta función se implementaría con una librería como jsPDF o html2pdf
    alert('Función de exportación a PDF próximamente disponible');
}

/**
 * Función para limpiar el mensaje de estado
 */
function limpiarMensaje() {
    const mensajeDiv = document.getElementById('mensaje');
    if (mensajeDiv) {
        mensajeDiv.style.display = 'none';
    }
}
