<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Visitante</title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <nav class="navbar">
        <h1>👤 Dashboard Visitante</h1>
        <div class="navbar-actions">
            <a href="<?= site_url('/') ?>" class="btn btn-home">
                🌐 Sitio publico
            </a>
            <a href="<?= site_url('auth/logout') ?>" class="btn btn-logout">
                ❌ Cerrar Sesión
            </a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <h2>¡Bienvenido, <?= esc(session()->get('usuario_nombre')) ?>!</h2>
            <p>Panel de visitante - Accede a contenido exclusivo</p>
        </div>
        
        <div class="menu-grid">
            <!-- Ver perfil -->
            <a href="<?= base_url('visitante/perfil') ?>" class="menu-card destacado">
            <span class="menu-icon">👤</span>    
            <h3>Mi Cuenta</h3>
                <p>Ver y editar mi información</p>
            </a>
            <!-- Ver Proyectos -->
            <a href="<?= site_url('proyectos/portfolio') ?>" class="menu-card destacado">
                <span class="menu-icon">🎨</span>
                <h3>Ver Proyectos</h3>
                <p>Explora algunos de mis proyectos y trabajos realizados incluidos los que no se pueden publicar.</p>
            </a>
            
            <!-- Recursos y Documentos -->
            <a href="<?= site_url('recursos') ?>" class="menu-card nuevo">
                <span class="menu-icon">📄</span>
                <h3>Documentos</h3>
                <p>Descarga documentos, PDFs, currículum y material exclusivo</p>
            </a>
            
            <!-- Volver a Homepage -->
            <a href="<?= site_url('/') ?>" class="menu-card">
                <span class="menu-icon">🌐</span>
                <h3>Sitio Público</h3>
                <p>Vuelve a la página principal del sitio web</p>
            </a>

        </div>
       
    </div>
</body>
</html>
