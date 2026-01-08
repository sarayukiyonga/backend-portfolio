<?php
$pageTitle = 'Inicio';
$pageDescription = 'Diseñadora UI/UX especializada en crear interfaces intuitivas y visualmente atractivas que combinan usabilidad, estética y coherencia técnica.';
$currentPage = 'home';
include 'includes/header.php';
?>

<section id="presentation" class="hero">
    <h1 class="animtext one">¡Hola! Soy Saray,<br>
        <span class="animtext two"><em>Diseñadora UX/UI.</em></span>
    </h1>
    <p class="animtext three">Creo interfaces intuitivas y visualmente atractivas</p>
    <p class="animtext3 four">que combinan usabilidad, estética y coherencia técnica.</p>
    <!-- <section id="contact"><p>Contacto</p><a class="whatsapp" href="https://wa.me/+34646220816" target="_blank"><i class="fab fa-whatsapp"></i></a> <a class="phone" href="tel:+34646220816"><i class="fas fa-phone"></i></a> <a href="mailto:info@saraymartinez.com"><i class="fas fa-envelope"></i></a></section> -->
    <div class="hero-buttons">
        <a href="<?= site_url('#proyectos') ?>" class="btn-hero btn-primary">
            Ver Proyectos
        </a>
        <a href="<?= site_url('contacto') ?>" class="btn-hero btn-secondary">
            Contactar
        </a>
    </div>
    <div class="anime">
        <i class="icon-code fas fa-code a"></i>
        <i class="icon-code fab fa-css3 b"></i>
        <i class="icon-code fab fa-html5 c"></i>
        <i class="icon-code fab fa-figma d"></i>
        <i class="icon-code fab fa-wordpress e"></i>
        <i class="icon-code fab fa-elementor f"></i>
        <i class="icon-code fab fa-mailchimp g"></i>
        <i class="icon-code fab fa-invision h"></i>
    </div>
</section>

<!-- Proyectos Destacados -->
<section id="proyectos" class="proyectos-section">
    <div class="section-header">
        <h2 class="titulo">Proyectos Destacados</h2>
        <p>Puedes ver una selección de mis trabajos, algunos de mis últimos trabajos están bajo un contrato de
            confidencialidad. Si deseas verlos debes solicitarme acceso al area privada rellenando el formulario de
            registro.</p>
        <?php if (session()->has('usuario_id')): ?>
            <a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>"
                class="btn-login">
                Dashboard
            </a>
        <?php else: ?>
            <a href="<?= site_url('auth/login') ?>" class="btn-login">
                Iniciar Sesión
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($proyectosDestacados)): ?>
        <div class="proyectos-grid">
                <?php foreach ($proyectosDestacados as $proyecto): ?>
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
        <!-- <div class="proyectos-grid">
            <?php foreach ($proyectosDestacados as $proyecto): ?>
                <div class="proyecto-card"
                    onclick="window.location.href='<?= site_url('proyectos/publico/' . $proyecto['id']) ?>'">
                    <?php if ($proyecto['imagen_principal']): ?>
                        <img src="<?= base_url('uploads/proyectos/' . $proyecto['imagen_principal']) ?>"
                            alt="<?= esc($proyecto['nombre']) ?>" class="proyecto-imagen">
                    <?php else: ?>
                        <div class="proyecto-imagen"></div>
                    <?php endif; ?>
                                             
                        <div class="proyecto-contenido">
                            <h3 class="proyecto-nombre">
                                <?= esc($proyecto['nombre']) ?>
                            </h3>
                            
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
                        </div> 
                </div>
            <?php endforeach; ?>
        </div> -->

        <!-- <div class="ver-mas-section">
            <a href="<?= site_url('proyectos/publico') ?>" class="btn-primary">
                Ver Todos los Proyectos →
            </a>
        </div> -->
    <?php else: ?>
        <div class="empty-state">
            <h3>Próximamente</h3>
            <p>Estamos trabajando en contenido increíble. Vuelve pronto.</p>
        </div>
    <?php endif; ?>
</section>
<!-- Sobre mi Section -->

<section id="about" class="sections">
    <h2 class="titulo">Sobre mi</h2>
    <div class="contenido">
        <p class="textsection">Soy una diseñadora UI/UX apasionada por crear experiencias digitales centradas en las
            personas. Mi formación en diseño gráfico y fotografía me da una sensibilidad especial para cuidar cada
            detalle visual, mientras que mis conocimientos de HTML y CSS me ayudan a conectar el diseño con la parte
            técnica.
        </p>
        <p>Creo en el diseño como herramienta para hacer la vida más fácil: interfaces claras, accesibles y atractivas
            que unen estética y funcionalidad. Me gusta trabajar en proyectos donde pueda aportar creatividad, empatía y
            precisión, siempre con el objetivo de ofrecer soluciones digitales útiles, bellas y memorables.
        </p>

        <hr>
        <h2 class="titulo">Referencias</h2>

        <div id="references">
            <div class="testimonios">
                <p><em>Joanna Grillo</em><br /><small>Trabajamos juntas en Dildosassorted</small></p>
                <p><q>Durante los cuatro años que trabajamos juntas con Saray, siempre me impresionó con su creatividad,
                        atención al detalle y capacidad para cumplir con los plazos. Sus contribuciones fueron
                        invaluables para nuestro equipo y no tengo ninguna duda de que se destacarán en cualquier
                        proyecto futuro.</q></p>
            </div>

            <div class="testimonios">
                <p><em>Manuel Ruiz</em><br /><small>Trabajamos juntos en Envirtual</small></p>
                <p><q>Gran creativa , responsable y muy ordenada y en los proyectos. Una verdadera profesional en el
                        sector del diseño gráfico y en todo lo que se proponga.</q></p>
            </div>

            <div class="testimonios">
                <p><em>José Manuel Villas</em><br /><small>Trabajamos juntos en Envirtual</small></p>
                <p><q>Trabajadora, detallista, comunicativa y compartidora de conocimientos además de amiga.</q></p>
            </div>
        </div>


    </div>
</section>
<!-- CTA Section -->
<!-- <section class="cta-section">
        <h2>¿Tienes un proyecto en mente?</h2>
        <p>Trabajemos juntos para hacerlo realidad</p>
        <a href="<?= site_url('contacto') ?>" class="btn-hero btn-primary">
            Contactar Ahora
        </a>
    </section> -->

<!-- Footer -->

<?php
include 'includes/footer.php';
?>