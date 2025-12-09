<!DOCTYPE html>
<html lang="es">
<head>
    <?php include(APPPATH . 'Views/components/head.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/components/sidebar.php'); ?>
   <div class="main-content">
       <?php include(APPPATH . 'Views/components/navbar.php'); ?>

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
    </div>
    <?php include(APPPATH . 'Views/components/sidebar_js.php'); ?>
</body>
</html>