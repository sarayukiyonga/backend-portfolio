<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body class="bglogin">
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php 
        $error = session()->getFlashdata('error');
        if ($error): ?>
            <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <strong>⚠️ Error:</strong> <?= esc($error) ?>
            </div>
        <?php endif; ?>
        
        <?php 
        $errors = session()->getFlashdata('errors');
        if ($errors && is_array($errors)): ?>
            <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <strong>⚠️ Errores:</strong>
                <ul style="margin: 5px 0 0 20px;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('auth/loginProcesar') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-text"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-text"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
        
        <div class="links">
            <a href="<?= base_url('auth/registro') ?>">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
    
    <script>
        // Asegurar que los mensajes de error se muestren
        document.addEventListener('DOMContentLoaded', function() {
            const errorAlert = document.querySelector('.alert-error');
            if (errorAlert) {
                errorAlert.style.display = 'block';
                // Hacer scroll al mensaje de error
                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    </script>
</body>
</html>
