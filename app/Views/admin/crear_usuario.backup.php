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
        <h1>➕ Crear Nuevo Usuario</h1>
        <a href="<?= site_url('admin/usuarios') ?>" class="btn-back">← Volver a Usuarios</a>
    </nav>
    
    <div class="container">
        <div class="form-card">
            <h2>Información del Usuario</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
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
            
            <form action="<?= site_url('admin/guardarUsuario') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nombre">
                        Nombre Completo <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= old('nombre') ?>" 
                           required
                           placeholder="Ej: Juan Pérez">
                    <div class="help-text">Nombre y apellidos del usuario</div>
                </div>
                
                <div class="form-group">
                    <label for="email">
                        Email <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= old('email') ?>" 
                           required
                           placeholder="usuario@ejemplo.com">
                    <div class="help-text">Dirección de correo electrónico única</div>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        Contraseña <span class="required">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="Mínimo 6 caracteres">
                    <div class="help-text">Mínimo 6 caracteres</div>
                </div>
                
                <div class="form-group">
                    <label for="rol_id">
                        Rol <span class="required">*</span>
                    </label>
                    <select id="rol_id" name="rol_id" required>
                        <option value="">-- Seleccione un rol --</option>
                        <?php foreach ($roles as $id => $nombre): ?>
                            <option value="<?= $id ?>" <?= old('rol_id') == $id ? 'selected' : '' ?>>
                                <?= ucfirst($nombre) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-text">
                        <strong>Admin:</strong> Acceso completo al sistema<br>
                        <strong>Visitante:</strong> Acceso limitado
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        ✅ Crear Usuario
                    </button>
                    <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
