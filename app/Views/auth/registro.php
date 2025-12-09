<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body class="bglogin">
    <div class="registro-container">
        <h1>Crear Cuenta</h1>
        
        <p class="info-text">Los nuevos usuarios se registran como visitantes</p>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('auth/registroProcesar') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                <?php if (isset($errors['nombre'])): ?>
                    <div class="error-text"><?= $errors['nombre'] ?></div>
                <?php endif; ?>
            </div>
            
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
            
            <div class="form-group">
                <label for="password_confirm">Confirmar Contraseña:</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
                <?php if (isset($errors['password_confirm'])): ?>
                    <div class="error-text"><?= $errors['password_confirm'] ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn">Registrarse</button>
        </form>
        
        <div class="links">
            <a href="<?= base_url('auth/login') ?>">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>
