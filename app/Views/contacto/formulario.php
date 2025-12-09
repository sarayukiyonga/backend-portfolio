<?php
$pageTitle = 'Proyectos';
$pageDescription = 'Diseñadora UI/UX especializada en crear interfaces intuitivas y visualmente atractivas que combinan usabilidad, estética y coherencia técnica.';
$currentPage = 'proyectos';
include 'includes/header.php';
?>

  <div class="section-header">
        <h2>Contacto</h2>
        <p>Rellena este formulario y me pondré en contacto contigo lo antes posible.</p>
        </div>
    <div class="container">
        <!-- <a href="<?= site_url('/') ?>" class="back-link">Volver al inicio</a> -->
        
        <div class="form-card">
            <div class="form-header">
                <h1>Contacta Conmigo</h1>
                <p>Cuéntame sobre tu proyecto</p>
            </div>

            <!-- Alertas -->
            <div id="alert-success" class="alert alert-success">
                ¡Mensaje enviado correctamente! Te responderé pronto.
            </div>
            <div id="alert-error" class="alert alert-error">
                <span id="error-text"></span>
            </div>

            <!-- Formulario -->
            <form id="contactForm" method="post" novalidate>
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nombre">
                        Nombre <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Tu nombre completo"
                        required
                    >
                    <div class="error-message" id="error-nombre"></div>
                </div>

                <div class="form-group">
                    <label for="email">
                        Email <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="tu@email.com"
                        required
                    >
                    <div class="error-message" id="error-email"></div>
                </div>

                <div class="form-group">
                    <label for="telefono">
                        Teléfono
                    </label>
                    <input 
                        type="tel" 
                        id="telefono" 
                        name="telefono" 
                        placeholder="+34 600 123 456"
                    >
                    <div class="error-message" id="error-telefono"></div>
                </div>

                <div class="form-group">
                    <label for="mensaje">
                        Mensaje <span class="required">*</span>
                    </label>
                    <textarea 
                        id="mensaje" 
                        name="mensaje" 
                        placeholder="Cuéntame sobre tu proyecto o consulta..."
                        required
                    ></textarea>
                    <div class="error-message" id="error-mensaje"></div>
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span class="btn-text">Enviar Mensaje</span>
                    <div class="loading-spinner"></div>
                </button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('contactForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const alertSuccess = document.getElementById('alert-success');
        const alertError = document.getElementById('alert-error');
        const errorText = document.getElementById('error-text');

        // API Endpoint
        const API_URL = '<?= site_url('api/contacto/enviar') ?>';

        // Limpiar errores
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
                el.textContent = '';
            });
            document.querySelectorAll('input, textarea').forEach(el => {
                el.classList.remove('input-error');
            });
            alertSuccess.classList.remove('show');
            alertError.classList.remove('show');
        }

        // Mostrar error en campo
        function showFieldError(field, message) {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(`error-${field}`);
            
            if (input && errorDiv) {
                input.classList.add('input-error');
                errorDiv.textContent = message;
                errorDiv.classList.add('show');
            }
        }

        // Validación cliente
        function validateForm() {
            clearErrors();
            let isValid = true;

            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const mensaje = document.getElementById('mensaje').value.trim();

            if (!nombre || nombre.length < 3) {
                showFieldError('nombre', 'El nombre debe tener al menos 3 caracteres');
                isValid = false;
            }

            if (!email) {
                showFieldError('email', 'El email es obligatorio');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showFieldError('email', 'Email no válido');
                isValid = false;
            }

            if (!mensaje || mensaje.length < 10) {
                showFieldError('mensaje', 'El mensaje debe tener al menos 10 caracteres');
                isValid = false;
            }

            return isValid;
        }

        // Enviar formulario
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            // Estado de carga
            btnSubmit.disabled = true;
            btnSubmit.classList.add('loading');
            clearErrors();

            // Preparar datos con CSRF
            const formData = new FormData(form);

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Éxito
                    alertSuccess.classList.add('show');
                    form.reset();
                    
                    // Scroll al mensaje
                    alertSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });

                } else {
                    // Error del servidor
                    if (data.errors) {
                        // Errores de validación
                        Object.keys(data.errors).forEach(field => {
                            showFieldError(field, data.errors[field]);
                        });
                    } else {
                        // Error general
                        errorText.textContent = data.message || 'Error al enviar el mensaje';
                        alertError.classList.add('show');
                    }
                }

            } catch (error) {
                // Error de red
                console.error('Error:', error);
                errorText.textContent = 'Error de conexión. Por favor, inténtalo de nuevo.';
                alertError.classList.add('show');
            } finally {
                // Quitar estado de carga
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('loading');
            }
        });

        // Limpiar error al escribir
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('input-error');
                const errorDiv = document.getElementById(`error-${this.name}`);
                if (errorDiv) {
                    errorDiv.classList.remove('show');
                }
            });
        });
    </script>
<?php 
include 'includes/footer.php'; 
?>