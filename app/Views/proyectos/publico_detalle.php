<?php
$pageTitle = 'Inicio';
$pageDescription = 'Diseñadora UI/UX especializada en crear interfaces intuitivas y visualmente atractivas que combinan usabilidad, estética y coherencia técnica.';
$currentPage = 'home';
include 'includes/header.php';
?>
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
    
    <div class="container section-header">
        <!-- Header del Proyecto -->
        <div class="proyecto-header">
            <h1><?= esc($proyecto['nombre']) ?></h1>
            
            <div class="proyecto-meta">
                <?php if ($proyecto['cliente']): ?>
                    <span><strong>Cliente:</strong> <?= esc($proyecto['cliente']) ?></span>
                <?php endif; ?>
                <?php if ($proyecto['anio']): ?>
                    <span><strong>Año:</strong> <?= $proyecto['anio'] ?></span>
                <?php endif; ?>
                <span><strong>Publicado:</strong> <?= date('d/m/Y', strtotime($proyecto['created_at'])) ?></span>
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
<?php 
include 'includes/footer.php'; 
?>