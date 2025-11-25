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
        /* Header/Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        
        .topbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .topbar h1 {
            font-size: 24px;
        }
        
        .navbar-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .btn-dashboard {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            font-weight: 600;
        }
        
        .btn-dashboard:hover {
            background: white;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .proyecto-header {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .proyecto-nombre {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .proyecto-meta {
            display: flex;
            gap: 30px;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .proyecto-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .proyecto-descripcion {
            color: #555;
            line-height: 1.8;
            font-size: 16px;
        }
        
        .imagen-principal-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .imagen-principal {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .seccion-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .seccion-title {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .caso-estudio-content {
            line-height: 1.8;
            color: #333;
        }
        
        .caso-estudio-content h1,
        .caso-estudio-content h2,
        .caso-estudio-content h3 {
            margin-top: 25px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .caso-estudio-content p {
            margin-bottom: 15px;
        }
        
        .caso-estudio-content ul,
        .caso-estudio-content ol {
            margin-left: 25px;
            margin-bottom: 15px;
        }
        
        .contenido-seccion {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }
        
        .contenido-seccion.solo-texto {
            grid-template-columns: 1fr;
        }
        
        .seccion-media img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .seccion-media iframe {
            width: 100%;
            height: 350px;
            border-radius: 8px;
            border: none;
        }
        
        .seccion-texto {
            line-height: 1.8;
            color: #555;
        }
        
        .galeria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .galeria-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .galeria-item:hover {
            transform: scale(1.05);
        }
        
        .galeria-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }
        
        @media (max-width: 768px) {
            .contenido-seccion {
                grid-template-columns: 1fr;
            }
            
            .proyecto-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Saray Martínez</div>
            <div class="nav-links">
                <a href="<?= site_url('/') ?>">Inicio</a>
                <a href="<?= site_url('proyectos/publico') ?>">Proyectos</a>
                <a href="<?= site_url('welcome/about') ?>">Acerca de</a>
                <a href="<?= site_url('welcome/contact') ?>">Contacto</a>
                <?php if (session()->has('usuario_id')): ?>
                    <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn-login">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('auth/login') ?>" class="btn-login">
                        Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- <nav class="topbar">
        <h1>👁️ <?= esc($proyecto['nombre']) ?></h1>
        <div class="navbar-actions">
            <?php if (session()->has('usuario_id')): ?>
                <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" 
                   class="btn btn-dashboard">
                    🏠 Dashboard
                </a>
            <?php endif; ?>
            <a href="<?= site_url('proyectos/portfolio') ?>" class="btn btn-back">
                ← Volver al Portfolio
            </a>
        </div>
    </nav> -->
    
    <div class="container">
        <!-- Header del Proyecto -->
        <div class="proyecto-header">
            <h1 class="proyecto-nombre"><?= esc($proyecto['nombre']) ?></h1>
            
            <div class="proyecto-meta">
                <?php if ($proyecto['cliente']): ?>
                    <span>👤 <strong>Cliente:</strong> <?= esc($proyecto['cliente']) ?></span>
                <?php endif; ?>
                <?php if ($proyecto['anio']): ?>
                    <span>📅 <strong>Año:</strong> <?= $proyecto['anio'] ?></span>
                <?php endif; ?>
                <span>🕒 <strong>Publicado:</strong> <?= date('d/m/Y', strtotime($proyecto['created_at'])) ?></span>
            </div>
            
            <div class="proyecto-descripcion">
                <?= esc($proyecto['descripcion']) ?>
            </div>
        </div>
        
        <!-- Imagen Principal -->
        <?php if ($proyecto['imagen_principal']): ?>
            <div class="imagen-principal-container">
                <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                     alt="<?= esc($proyecto['nombre']) ?>" 
                     class="imagen-principal">
            </div>
        <?php endif; ?>
        
        <!-- Caso de Estudio -->
        <?php if ($proyecto['caso_estudio']): ?>
            <div class="seccion-content">
                <h2 class="seccion-title">📄 Caso de Estudio</h2>
                <div class="caso-estudio-content">
                    <?= $proyecto['caso_estudio'] ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Secciones de Contenido -->
        <?php if (!empty($proyecto['secciones'])): ?>
            <?php foreach ($proyecto['secciones'] as $index => $seccion): ?>
                <div class="seccion-content">
                    <h2 class="seccion-title">Sección <?= $index + 1 ?></h2>
                    
                    <div class="contenido-seccion <?= empty($seccion['media_url']) ? 'solo-texto' : '' ?>">
                        <?php if ($seccion['media_url']): ?>
                            <div class="seccion-media">
                                <?php if ($seccion['tipo_media'] == 'imagen'): ?>
                                    <img src="<?= base_url('uploads/proyectos/secciones/' . $seccion['media_url']) ?>" 
                                         alt="Sección <?= $index + 1 ?>">
                                <?php elseif ($seccion['tipo_media'] == 'video'): ?>
                                    <?php
                                    // Convertir URL de YouTube a embed
                                    $videoUrl = $seccion['media_url'];
                                    if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                                        if (isset($matches[1])) {
                                            $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                        }
                                    }
                                    ?>
                                    <iframe src="<?= $videoUrl ?>" allowfullscreen></iframe>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($seccion['contenido']): ?>
                            <div class="seccion-texto">
                                <?= $seccion['contenido'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <!-- Galería -->
        <?php if (!empty($proyecto['galeria'])): ?>
            <div class="seccion-content">
                <h2 class="seccion-title">🖼️ Galería de Imágenes</h2>
                <div class="galeria-grid">
                    <?php foreach ($proyecto['galeria'] as $imagen): ?>
                        <div class="galeria-item">
                            <img src="<?= base_url('uploads/proyectos/galeria/' . $imagen['imagen']) ?>" 
                                 alt="<?= $imagen['titulo'] ?? 'Imagen de galería' ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
