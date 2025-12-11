<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Saray Martínez Guzmán</title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Diseñadora UI/UX especializada en crear interfaces intuitivas y visualmente atractivas.'; ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kodchasan:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Meow+Script&family=Montserrat:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/wtr4cia.css">
    <!-- Estilos -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
<!-- Hotjar Tracking Code for https://saraymartinez.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:5197763,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>
<body>
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M4F3K9F9');</script>
<!-- End Google Tag Manager -->
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4F3K9F9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <!-- Skip link para accesibilidad -->
    <a href="#main-content" class="skip-link">Ir al contenido principal</a>

    <!-- Menu mobile -->
    <nav class="w3-sidebar w3-black w3-animate-top w3-xxlarge" style="display:none;padding-top:150px" id="mySidebar" aria-label="Menu mobile">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-black w3-xxlarge w3-padding w3-display-topright" style="padding:6px 24px" aria-label="Cerrar menu">
            <i class="fa fa-remove" aria-hidden="true"></i>
        </a>
        <div class="w3-bar-block w3-center">
            <a href="<?= site_url('/') ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-text-grey w3-hover-black">Inicio</a>
            <!-- <a href="<?= site_url('proyectos/publico') ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-text-grey w3-hover-black">Proyectos</a> -->
            <a href="<?= site_url('#proyectos') ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-text-grey w3-hover-black">Proyectos</a>
            <a href="<?= site_url('#about') ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-text-grey w3-hover-black">Sobre mi</a>
            <a href="<?= site_url('contacto') ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-text-grey w3-hover-black">Contacto</a>
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
    </nav>
                
    <!-- Header principal -->
    <header id="top-bar">
        <a href="<?= site_url('/') ?>" aria-label="Ir al inicio">
            <div id="logo" class="logo"><p>SM</p></div>
        </a>
        <nav id="menu" aria-label="Menu principal">
            <ul>
                <li><a href="<?= site_url('/') ?>" <?php echo ($currentPage === 'home') ? 'aria-current="page"' : ''; ?>>Inicio</a></li>
                <!-- <li><a href="<?= site_url('proyectos/publico') ?>">Proyectos</a></li> -->
                <li><a href="<?= site_url('#proyectos') ?>">Proyectos</a></li>
                <li><a href="<?= site_url('#about') ?>">Sobre mi</a></li>
                <li><a href="<?= site_url('contacto') ?>">Contacto</a></li>
                <?php if (session()->has('usuario_id')): ?>
                    <li><a href="<?= site_url(session()->get('usuario_rol') == 'admin' ? 'admin/dashboard' : 'visitante/dashboard') ?>" class="btn-login">
                        Dashboard
                    </a></li>
                <?php else: ?>
                    <li><a href="<?= site_url('auth/login') ?>" class="btn-login">
                        Iniciar Sesión
                    </a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <button id="menumobile" class="w3-button w3-xxlarge w3-white w3-right w3-clear" onclick="w3_open()" aria-label="Abrir menu" aria-expanded="false" aria-controls="mySidebar">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
    </header>

    <main id="main-content">
