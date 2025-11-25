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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            max-width: 600px;
            margin: 30px auto;
            padding: 0 20px;
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
            text-align: center;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        
        label .required {
            color: #dc3545;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            text-align: center;
            text-decoration: none;
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .help-text {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .info-box strong {
            display: block;
            margin-bottom: 5px;
            color: #1976D2;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>✏️ Editar Usuario</h1>
        <a href="<?= site_url('admin/usuarios') ?>" class="btn-back">← Volver a Usuarios</a>
    </nav>
    
    <div class="container">
        <div class="form-card">
            <h2>Editar Información del Usuario</h2>
            
            <div class="info-box">
                <strong>ID del Usuario: <?= $usuario['id'] ?></strong>
                Registrado el: <?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?>
            </div>
            
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
            
            <form action="<?= site_url('admin/actualizarUsuario/' . $usuario['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nombre">
                        Nombre Completo <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= old('nombre', $usuario['nombre']) ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">
                        Email <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= old('email', $usuario['email']) ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        Nueva Contraseña (opcional)
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           placeholder="Dejar en blanco para mantener la actual">
                    <div class="help-text">Solo completa si deseas cambiar la contraseña. Mínimo 6 caracteres.</div>
                </div>
                
                <div class="form-group">
                    <label for="rol_id">
                        Rol <span class="required">*</span>
                    </label>
                    <select id="rol_id" name="rol_id" required>
                        <?php foreach ($roles as $id => $nombre): ?>
                            <option value="<?= $id ?>" <?= old('rol_id', $usuario['rol_id']) == $id ? 'selected' : '' ?>>
                                <?= ucfirst($nombre) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        ✅ Guardar Cambios
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
