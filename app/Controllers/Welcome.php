<?php

namespace App\Controllers;

use App\Models\ProyectoModel;

class Welcome extends BaseController
{
    protected $proyectoModel;
    
    public function __construct()
    {
        $this->proyectoModel = new ProyectoModel();
    }
    
    /**
     * Homepage principal del sitio público
     */
    public function index()
    {
        // Obtener proyectos destacados (públicos, autenticados y privados) - últimos 6
        $proyectosDestacados = $this->proyectoModel
            ->where('estado', 'publicado')
            ->whereIn('visibilidad', ['publico', 'autenticado', 'privado'])
            ->orderBy('orden', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->findAll();

        $data = [
            'titulo' => 'Bienvenido',
            'proyectosDestacados' => $proyectosDestacados
        ];

        return view('welcome/index', $data);
    }
    
    /**
     * Página "Acerca de"
     */
    public function about()
    {
        $data = [
            'titulo' => 'Acerca de Nosotros'
        ];
        
        return view('welcome/about', $data);
    }
    
    /**
     * Página de contacto
     */
    public function contact()
    {
        $data = [
            'titulo' => 'Contacto'
        ];
        
        return view('welcome/contact', $data);
    }
}
