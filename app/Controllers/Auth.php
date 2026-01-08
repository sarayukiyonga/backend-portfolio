<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
    }
    
    // Mostrar formulario de login
    public function login()
    {
        // Si ya está logueado, redirigir al dashboard
        if (session()->has('usuario_id')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }
    
    // Procesar login
    public function loginProcesar()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ], [
            'email' => [
                'required' => 'El email es requerido',
                'valid_email' => 'Debe ingresar un email válido'
            ],
            'password' => [
                'required' => 'La contraseña es requerida'
            ]
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/auth/login')->withInput()->with('errors', $validation->getErrors());
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $usuarioModel = new UsuarioModel();
        
        // Primero verificar si el usuario existe
        $usuarioPorEmail = $usuarioModel->getUsuarioPorEmail($email);
        
        if (!$usuarioPorEmail) {
            log_message('info', "Intento de login fallido - Usuario no encontrado: {$email}");
            return redirect()->to('/auth/login')->withInput()->with('error', 'No existe una cuenta con ese email.');
        }
        
        // Verificar contraseña
        if (!password_verify($password, $usuarioPorEmail['password'])) {
            log_message('info', "Intento de login fallido - Contraseña incorrecta para: {$email}");
            return redirect()->to('/auth/login')->withInput()->with('error', 'Contraseña incorrecta.');
        }
        
        // Verificar si el usuario está activo
        if ($usuarioPorEmail['activo'] != 1) {
            log_message('info', "Intento de login fallido - Usuario inactivo: {$email}");
            return redirect()->to('/auth/login')->withInput()->with('error', 'Tu cuenta está pendiente de aprobación por un administrador.');
        }
        
        // Verificar que tenga rol asignado
        if (empty($usuarioPorEmail['rol_id']) || empty($usuarioPorEmail['rol_nombre'])) {
            log_message('error', "Usuario sin rol asignado: {$email} (ID: {$usuarioPorEmail['id']})");
            return redirect()->to('/auth/login')->withInput()->with('error', 'Tu cuenta no tiene un rol asignado. Contacta al administrador.');
        }
        
        // Todo correcto, crear sesión
        $sessionData = [
            'usuario_id' => $usuarioPorEmail['id'],
            'usuario_nombre' => $usuarioPorEmail['nombre'],
            'usuario_email' => $usuarioPorEmail['email'],
            'usuario_rol' => $usuarioPorEmail['rol_nombre'],
            'usuario_rol_id' => $usuarioPorEmail['rol_id'],
            'isLoggedIn' => true
        ];
        
        session()->set($sessionData);
        
        log_message('info', "Login exitoso - Usuario: {$email} (Rol: {$usuarioPorEmail['rol_nombre']})");
        
        // Redirigir según el rol
        if ($usuarioPorEmail['rol_nombre'] == 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Bienvenido ' . $usuarioPorEmail['nombre']);
        } else {
            return redirect()->to('/visitante/dashboard')->with('success', 'Bienvenido ' . $usuarioPorEmail['nombre']);
        }
    }
    
    // Cerrar sesión
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sesión cerrada correctamente');
    }
    
    // Mostrar formulario de registro
    public function registro()
    {
        if (session()->has('usuario_id')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/registro');
    }
    
    // Procesar registro
    public function registroProcesar()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ], [
            'nombre' => [
                'required' => 'El nombre es requerido',
                'min_length' => 'El nombre debe tener al menos 3 caracteres'
            ],
            'email' => [
                'required' => 'El email es requerido',
                'valid_email' => 'Debe ingresar un email válido',
                'is_unique' => 'Este email ya está registrado'
            ],
            'password' => [
                'required' => 'La contraseña es requerida',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres'
            ],
            'password_confirm' => [
                'required' => 'Debe confirmar la contraseña',
                'matches' => 'Las contraseñas no coinciden'
            ]
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $usuarioModel = new UsuarioModel();
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'rol_id' => 2, // Por defecto es visitante
            'activo' => 0  // CAMBIO: Desactivado por defecto, necesita aprobación
        ];
        
        if ($usuarioModel->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Registro exitoso. Tu cuenta está pendiente de aprobación por un administrador. Te notificaremos cuando sea activada.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario');
        }
    }
}
