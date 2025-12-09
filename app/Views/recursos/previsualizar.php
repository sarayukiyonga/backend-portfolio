<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <div class="header">
        <h1>📄 <?= esc($recurso['titulo']) ?></h1>
        <div class="header-actions">
            <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
               class="btn btn-download">
                ⬇️ Descargar
            </a>
            <a href="javascript:window.close()" class="btn btn-close">
                ✖ Cerrar
            </a>
        </div>
    </div>
    
    <div class="pdf-container">
        <?php 
        $rutaPDF = base_url('uploads/recursos/' . $recurso['archivo']);
        $rutaCompleta = FCPATH . 'uploads/recursos/' . $recurso['archivo'];
        
        if (file_exists($rutaCompleta)): 
        ?>
            <iframe 
                src="<?= $rutaPDF ?>#toolbar=1&navpanes=1&scrollbar=1" 
                type="application/pdf"
                title="<?= esc($recurso['titulo']) ?>">
                <div class="error-message">
                    <div class="error-icon">⚠️</div>
                    <h2>No se puede mostrar el PDF</h2>
                    <p>Tu navegador no soporta la visualización de PDFs</p>
                    <br>
                    <a href="<?= site_url('recursos/descargar/' . $recurso['id']) ?>" 
                       class="btn btn-download">
                        ⬇️ Descargar PDF
                    </a>
                </div>
            </iframe>
        <?php else: ?>
            <div class="error-message">
                <div class="error-icon">❌</div>
                <h2>Archivo no encontrado</h2>
                <p>El PDF no está disponible en este momento</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
