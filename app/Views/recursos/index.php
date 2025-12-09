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
        <h1>📄 Recursos y Documentos</h1>
        <div class="navbar-actions">
            <?php if ($esAdmin): ?>
                <a href="<?= site_url('recursos/admin') ?>" class="btn btn-admin">
                    🛠️ Panel Admin
                </a>
            <?php endif; ?>
            <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn btn-back">
                ← Dashboard
            </a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="header-section">
            <h2>Recursos Disponibles</h2>
            <p>Documentos y archivos para descargar</p>
        </div>
        
        <?php if (!empty($recursos)): ?>
            <div class="recursos-grid">
                <?php foreach ($recursos as $recurso): ?>
                    <div class="recurso-card">
                        <div class="recurso-header">
                            <div class="recurso-icon"><?= $recurso['icono'] ?></div>
                            <div class="recurso-info">
                                <h3 class="recurso-titulo"><?= esc($recurso['titulo']) ?></h3>
                                <span class="recurso-tipo tipo-<?= $recurso['tipo'] ?>">
                                    <?= strtoupper($recurso['tipo']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <?php if ($recurso['descripcion']): ?>
                            <p class="recurso-descripcion">
                                <?= esc($recurso['descripcion']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="recurso-meta">
                            <?php if ($recurso['tamanio']): ?>
                                <span>
                                    📦 <?= number_format($recurso['tamanio'] / 1024, 0) ?> KB
                                </span>
                            <?php endif; ?>
                            <span>
                                📥 <?= $recurso['descargas'] ?> descargas
                            </span>
                            <span>
                                📅 <?= date('d/m/Y', strtotime($recurso['created_at'])) ?>
                            </span>
                        </div>
                        
                        <div class="recurso-acciones">
                            <?php if ($recurso['tipo'] == 'pdf'): ?>
                                <a href="<?= site_url('recursos/previsualizar/' . $recurso['id']) ?>" 
                                   class="btn-accion btn-previsualizar"
                                   target="_blank">
                                    👁️ Ver PDF
                                </a>
                            <?php endif; ?>
                            <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
                               class="btn-accion btn-descargar">
                                ⬇️ Descargar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h2>No hay recursos disponibles</h2>
                <p>Vuelve pronto para ver nuevos recursos</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
