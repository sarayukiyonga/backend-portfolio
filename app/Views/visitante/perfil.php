<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <nav class="navbar">
        <h1>👤 Mi Perfil</h1>
        <div class="navbar-right">
            <?php if (session()->get('usuario_rol') == 'admin'): ?>
                <a href="<?= site_url('admin/dashboard') ?>" class="btn-back">← Dashboard</a>
            <?php else: ?>
                <a href="<?= site_url('visitante/dashboard') ?>" class="btn-back">← Dashboard</a>
            <?php endif; ?>
            <a href="<?= site_url('auth/logout') ?>" class="btn-back">Cerrar Sesión</a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <!-- Información del Perfil -->
        <div class="profile-header">
            <div class="profile-avatar">
                <?= strtoupper(substr($usuario['nombre'], 0, 1)) ?>
            </div>
            <h2 class="profile-name"><?= esc($usuario['nombre']) ?></h2>
            <p class="profile-email"><?= esc($usuario['email']) ?></p>
            <span class="badge badge-<?= $usuario['rol_nombre'] ?>">
                <?= strtoupper($usuario['rol_nombre']) ?>
            </span>
        </div>
        
        <!-- Tarjetas de Información -->
        <div class="info-cards">
            <div class="info-card">
                <h3>📊 Información de la Cuenta</h3>
                <div class="info-row">
                    <span class="info-label">ID de Usuario:</span>
                    <span class="info-value">#<?= $usuario['id'] ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado:</span>
                    <span class="info-value"><?= $usuario['activo'] ? '✅ Activo' : '❌ Inactivo' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Rol:</span>
                    <span class="info-value"><?= ucfirst($usuario['rol_nombre']) ?></span>
                </div>
            </div>
            
            <div class="info-card">
                <h3>📅 Fechas</h3>
                <div class="info-row">
                    <span class="info-label">Registrado:</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Última actualización:</span>
                    <span class="info-value">
                        <?= $usuario['updated_at'] ? date('d/m/Y', strtotime($usuario['updated_at'])) : 'N/A' ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Formulario de Edición -->
        <div class="form-card">
            <h2>✏️ Editar Perfil</h2>
            
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-error">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="<?= site_url('visitante/editarPerfil') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= old('nombre', $usuario['nombre']) ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= old('email', $usuario['email']) ?>" 
                           required>
                </div>
                
                <hr class="section-divider">
                
                <h3 style="color: #333; margin-bottom: 20px;">🔒 Cambiar Contraseña (Opcional)</h3>
                <p style="color: #666; margin-bottom: 20px;">Deja estos campos vacíos si no deseas cambiar tu contraseña.</p>
                
                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           placeholder="Mínimo 6 caracteres">
                    <div class="help-text">Solo completa si deseas cambiar tu contraseña</div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Confirmar Nueva Contraseña</label>
                    <input type="password" 
                           id="password_confirm" 
                           name="password_confirm"
                           placeholder="Repite la nueva contraseña">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    ✅ Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</body>
</html>
