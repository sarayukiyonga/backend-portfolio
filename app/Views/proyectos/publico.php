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
                    <?php 
                    $esPublico = $proyecto['visibilidad'] === 'publico';
                    $esAutenticado = $proyecto['visibilidad'] === 'autenticado';
                    $esPrivado = $proyecto['visibilidad'] === 'privado';
                    $esRestringido = $esAutenticado || $esPrivado;
                    ?>
                    <div class="proyecto-card <?= $esRestringido ? 'proyecto-privado' : '' ?>" 
                         onclick="window.location.href='<?= site_url('proyectos/publico/' . $proyecto['id']) ?>'">
                        <?php if ($esPublico && $proyecto['imagen_principal']): ?>
                            <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>" 
                                 alt="<?= esc($proyecto['nombre']) ?>" 
                                 class="proyecto-imagen">
                        <?php else: ?>
                            <!-- Imagen predefinida para proyectos autenticados y privados -->
                            <div class="proyecto-imagen proyecto-imagen-privada" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                🔒
                            </div>
                        <?php endif; ?>
                        
                        <div class="proyecto-contenido">
                            <?php if ($esRestringido): ?>
                                <div style="background: #fff3cd; padding: 8px; border-radius: 4px; margin-bottom: 10px; text-align: center; font-size: 12px; color: #856404;">
                                    🔒 <?= $esPrivado ? 'Proyecto Exclusivo' : 'Proyecto Privado' ?>
                                </div>
                            <?php else: ?>
                                <!-- Solo mostrar nombre para proyectos públicos -->
                                <h2 class="proyecto-nombre">
                                    <?= esc($proyecto['nombre']) ?>
                                </h2>
                            <?php endif; ?>
                            
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
                                <?= $esPublico ? 'Ver Proyecto Completo →' : 'Ver Detalles →' ?>
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
    
    <style>
        .proyecto-privado {
            position: relative;
        }
        
        .proyecto-imagen-privada {
            min-height: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 64px;
            border-radius: 8px 8px 0 0;
        }
        
        .proyecto-privado .proyecto-contenido {
            position: relative;
        }
        
        .proyecto-privado:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
    
    <!-- Footer -->

<?php 
include 'includes/footer.php'; 
?>
