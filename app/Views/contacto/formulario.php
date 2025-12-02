<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Portfolio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .required {
            color: #e74c3c;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: inherit;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .input-error {
            border-color: #e74c3c !important;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        .btn-submit.loading .loading-spinner {
            display: block;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .back-link:hover {
            opacity: 0.8;
        }

        .back-link::before {
            content: "← ";
        }

        @media (max-width: 640px) {
            .form-card {
                padding: 30px 20px;
            }

            .form-header h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('/') ?>" class="back-link">Volver al inicio</a>
        
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
</body>
</html>
