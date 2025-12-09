<?php
$pageTitle = 'Proyectos';
$pageDescription = 'Diseñadora UI/UX especializada en crear interfaces intuitivas y visualmente atractivas que combinan usabilidad, estética y coherencia técnica.';
$currentPage = 'proyectos';
include 'includes/header.php';
?>
         <div class="section-header">
        <h2>Proyectos Destacados</h2>
        <p>Descubre mi trabajo y experiencia</p>
        </div>

    <div class="container">
        <?php if (!empty($proyectos)): ?>
            <div class="proyectos-grid">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="proyecto-card" onclick="window.location.href='<?= site_url('proyectos/publico/' . $proyecto['id']) ?>'">
                        <?php if ($proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <div class="proyecto-imagen"></div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <h2 class="proyecto-nombre">
                                <?= esc($proyecto['nombre']) ?>
                            </h2>
                            
                            <p class="proyecto-descripcion">
                                <?= esc($proyecto['descripcion']) ?>
                            </p>
                            
                            <div class="proyecto-meta">
                                <?php if ($proyecto['cliente']): ?>
                                    <span>👤 <?= esc($proyecto['cliente']) ?></span>
                                <?php endif; ?>
                                <?php if ($proyecto['anio']): ?>
                                    <span>📅 <?= $proyecto['anio'] ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="<?= site_url('proyectos/publico/' . $proyecto['id']) ?>" 
                               class="btn-proyecto"
                               onclick="event.stopPropagation()">
                                Ver Proyecto Completo →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎨</div>
                <h2>Próximamente nuevos proyectos</h2>
                <p>Estamos trabajando en contenido increíble. Vuelve pronto.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->

<?php 
include 'includes/footer.php'; 
?>
