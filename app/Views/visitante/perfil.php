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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, <?= session()->get('usuario_rol') == 'admin' ? '#667eea 0%, #764ba2' : '#28a745 0%, #20c997' ?> 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-right {
            display: flex;
            gap: 15px;
        }
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .profile-header {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, <?= session()->get('usuario_rol') == 'admin' ? '#667eea, #764ba2' : '#28a745, #20c997' ?>);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            margin-bottom: 20px;
        }
        
        .profile-name {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .profile-email {
            color: #666;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .badge-admin {
            background: #667eea;
            color: white;
        }
        
        .badge-visitante {
            background: #28a745;
            color: white;
        }
        
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .info-card h3 {
            color: <?= session()->get('usuario_rol') == 'admin' ? '#667eea' : '#28a745' ?>;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 500;
            color: #666;
        }
        
        .info-value {
            color: #333;
        }
        
        .form-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .form-card h2 {
            color: #333;
            margin-bottom: 30px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: <?= session()->get('usuario_rol') == 'admin' ? '#667eea' : '#28a745' ?>;
        }
        
        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, <?= session()->get('usuario_rol') == 'admin' ? '#667eea 0%, #764ba2' : '#28a745 0%, #20c997' ?> 100%);
            color: white;
        }
        
        .help-text {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .section-divider {
            margin: 30px 0;
            border: none;
            border-top: 2px solid #f0f0f0;
        }
    </style>
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
