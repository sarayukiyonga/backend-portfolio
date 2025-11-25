<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta por defecto
$routes->get('/', 'Welcome::index');
$routes->get('welcome', 'Welcome::index');

// Tu formulario login existente (MANTENER)
$routes->get('home', 'Home::index');
$routes->get('home/index', 'Home::index');


// Rutas de autenticación
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('loginProcesar', 'Auth::loginProcesar');
    $routes->get('registro', 'Auth::registro');
    $routes->post('registroProcesar', 'Auth::registroProcesar');
    $routes->get('logout', 'Auth::logout');
});

// Rutas de administrador
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('usuariosPendientes', 'Admin::usuariosPendientes');
    $routes->get('aprobarUsuario/(:num)', 'Admin::aprobarUsuario/$1');
    $routes->get('rechazarUsuario/(:num)', 'Admin::rechazarUsuario/$1');
    $routes->get('crearUsuario', 'Admin::crearUsuario');
    $routes->post('guardarUsuario', 'Admin::guardarUsuario');
    $routes->get('editarUsuario/(:num)', 'Admin::editarUsuario/$1');
    $routes->post('actualizarUsuario/(:num)', 'Admin::actualizarUsuario/$1');
    $routes->get('eliminarUsuario/(:num)', 'Admin::eliminarUsuario/$1');
    $routes->get('cambiarEstado/(:num)', 'Admin::cambiarEstado/$1');
});



// ===== RUTAS PÚBLICAS (Sin autenticación) =====
// Portfolio público
$routes->get('proyectos/publico', 'Proyectos::publico');
$routes->get('proyectos/publico/(:num)', 'Proyectos::publicoDetalle/$1');

// ===== RUTAS AUTENTICADAS (Visitantes logueados) =====
$routes->group('visitante', function($routes) {
    $routes->get('dashboard', 'Visitante::dashboard');
    $routes->get('perfil', 'Visitante::perfil');
    $routes->post('editarPerfil', 'Visitante::editarPerfil');
});

// ===== RUTAS AUTENTICADAS (Visitantes logueados) =====
$routes->get('proyectos/portfolio', 'Proyectos::portfolio');
$routes->get('proyectos/detalle/(:num)', 'Proyectos::detalle/$1');


// ==================== RUTAS DE PROYECTOS ====================
$routes->group('proyectos', function($routes) {
    $routes->get('/', 'Proyectos::index');
    $routes->get('ver/(:num)', 'Proyectos::ver/$1');
    $routes->get('crear', 'Proyectos::crear');
    $routes->post('guardar', 'Proyectos::guardar');
    $routes->get('editar/(:num)', 'Proyectos::editar/$1');
    $routes->post('actualizar/(:num)', 'Proyectos::actualizar/$1');
    $routes->get('eliminar/(:num)', 'Proyectos::eliminar/$1');
    $routes->delete('eliminarImagenGaleria/(:num)', 'Proyectos::eliminarImagenGaleria/$1');
    $routes->delete('eliminarSeccion/(:num)', 'Proyectos::eliminarSeccion/$1');
    // Nuevas rutas AJAX
    $routes->post('cambiarEstado/(:num)', 'Proyectos::cambiarEstado/$1');
    $routes->post('cambiarVisibilidad/(:num)', 'Proyectos::cambiarVisibilidad/$1');
    // Nueva ruta para subir imágenes de TinyMCE
    $routes->post('subirImagenTinymce', 'Proyectos::subirImagenTinymce');
});

// ============================================
// RECURSOS - Sin filtros (verificación en controlador)
// ============================================

$routes->group('recursos', function($routes) {
    // Para visitantes (requieren verificación en controlador)
    $routes->get('/', 'Recursos::index');
    $routes->get('descargar/(:num)', 'Recursos::descargar/$1');
    $routes->get('previsualizar/(:num)', 'Recursos::previsualizar/$1');
    
    // Para admin (requieren verificación en controlador)
    $routes->get('admin', 'Recursos::admin');
    $routes->get('crear', 'Recursos::crear');
    $routes->post('guardar', 'Recursos::guardar');
    $routes->get('editar/(:num)', 'Recursos::editar/$1');
    $routes->post('actualizar/(:num)', 'Recursos::actualizar/$1');
    $routes->get('eliminar/(:num)', 'Recursos::eliminar/$1');
    $routes->post('cambiarEstado/(:num)', 'Recursos::cambiarEstado/$1');
});

// Ruta genérica para dashboard según rol
$routes->get('dashboard', function() {
    if (!session()->has('usuario_id')) {
        return redirect()->to('/auth/login');
    }
    
    if (session()->get('usuario_rol') == 'admin') {
        return redirect()->to('/admin/dashboard');
    } else {
        return redirect()->to('/visitante/dashboard');
    }
});
