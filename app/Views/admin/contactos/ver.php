<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 20px;
            color: #333;
        }

        .nav-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: #f0f2ff;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h2 {
            font-size: 24px;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-nuevo {
            background: #fff3cd;
            color: #856404;
        }

        .badge-leido {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-respondido {
            background: #d4edda;
            color: #155724;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            word-break: break-word;
        }

        .info-value a {
            color: #667eea;
            text-decoration: none;
        }

        .info-value a:hover {
            text-decoration: underline;
        }

        .mensaje-section {
            margin: 30px 0;
        }

        .mensaje-section h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .mensaje-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .metadata {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 13px;
            color: #999;
        }

        .metadata-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .card {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1>📧 <?= $titulo ?></h1>
        <div class="nav-links">
            <a href="<?= site_url('admin/contactos') ?>">← Volver a Contactos</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <!-- Header con estado -->
            <div class="card-header">
                <h2>Mensaje #<?= $contacto['id'] ?></h2>
                <?php if ($contacto['respondido']): ?>
                    <span class="badge badge-respondido">✓ Respondido</span>
                <?php elseif ($contacto['leido']): ?>
                    <span class="badge badge-leido">👁 Leído</span>
                <?php else: ?>
                    <span class="badge badge-nuevo">🆕 Nuevo</span>
                <?php endif; ?>
            </div>

            <!-- Información del remitente -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nombre</div>
                    <div class="info-value"><?= esc($contacto['nombre']) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">
                        <a href="mailto:<?= esc($contacto['email']) ?>">
                            <?= esc($contacto['email']) ?>
                        </a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">
                        <?php if ($contacto['telefono']): ?>
                            <a href="tel:<?= esc($contacto['telefono']) ?>">
                                <?= esc($contacto['telefono']) ?>
                            </a>
                        <?php else: ?>
                            <span style="color: #999;">No proporcionado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Fecha</div>
                    <div class="info-value">
                        <?= date('d/m/Y H:i', strtotime($contacto['created_at'])) ?>
                    </div>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="mensaje-section">
                <h3>💬 Mensaje:</h3>
                <div class="mensaje-content">
                    <?= nl2br(esc($contacto['mensaje'])) ?>
                </div>
            </div>

            <!-- Acciones -->
            <div class="actions">
                <a href="mailto:<?= esc($contacto['email']) ?>?subject=Re: Tu mensaje desde el portfolio" 
                   class="btn btn-primary"
                   onclick="marcarRespondido(<?= $contacto['id'] ?>)">
                    ✉️ Responder por Email
                </a>

                <?php if (!$contacto['respondido']): ?>
                    <button onclick="marcarRespondido(<?= $contacto['id'] ?>)" 
                            class="btn btn-success"
                            id="btnMarcar">
                        ✓ Marcar como Respondido
                    </button>
                <?php endif; ?>

                <a href="<?= site_url('admin/contactos') ?>" class="btn btn-secondary">
                    ← Volver
                </a>

                <a href="<?= site_url('admin/contactos/eliminar/' . $contacto['id']) ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Seguro que quieres eliminar este mensaje?')">
                    🗑️ Eliminar
                </a>
            </div>

            <!-- Metadata -->
            <div class="metadata">
                <strong>Información adicional:</strong>
                <div class="metadata-grid">
                    <div>
                        <strong>IP:</strong> <?= esc($contacto['ip_address']) ?>
                    </div>
                    <div>
                        <strong>Navegador:</strong> 
                        <?php
                        $userAgent = $contacto['user_agent'];
                        if (strpos($userAgent, 'Chrome') !== false) {
                            echo '🌐 Chrome';
                        } elseif (strpos($userAgent, 'Firefox') !== false) {
                            echo '🦊 Firefox';
                        } elseif (strpos($userAgent, 'Safari') !== false) {
                            echo '🧭 Safari';
                        } elseif (strpos($userAgent, 'Edge') !== false) {
                            echo '🌊 Edge';
                        } else {
                            echo '🌐 Otro';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function marcarRespondido(id) {
            if (!confirm('¿Marcar este mensaje como respondido?')) {
                return;
            }

            try {
                const response = await fetch(`<?= site_url('admin/contactos/marcarRespondido/') ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert('Error al actualizar el estado');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión');
            }
        }
    </script>
</body>
</html>
