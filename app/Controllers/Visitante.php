<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Visitante extends BaseController
{
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        helper(['form', 'url']);
    }
    
    // Verificar que el usuario esté logueado
    private function verificarLogin()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to('/auth/login')->with('error', 'Debe iniciar sesión');
        }
        return null;
    }
    
    // Dashboard del visitante
    public function dashboard()
    {
        $redirect = $this->verificarLogin();
        if ($redirect) return $redirect;
        
        $usuario = $this->usuarioModel->getUsuarioConRol(session()->get('usuario_id'));
        
        // Verificar que el usuario existe
        if (!$usuario) {
            session()->destroy();
            return redirect()->to('/auth/login')->with('error', 'Usuario no encontrado. Por favor inicia sesión nuevamente.');
        }
        
        $data = [
            'titulo' => 'Panel de Visitante',
            'usuario' => $usuario
        ];
        
        return view('visitante/dashboard', $data);
    }
    
    // Ver perfil
    public function perfil()
    {
        $redirect = $this->verificarLogin();
        if ($redirect) return $redirect;
        
        $usuarioId = session()->get('usuario_id');
        
        // Debug: verificar ID de usuario
        if (!$usuarioId) {
            return redirect()->to('/auth/login')->with('error', 'Sesión inválida. Por favor inicia sesión nuevamente.');
        }
        
        $usuario = $this->usuarioModel->getUsuarioConRol($usuarioId);
        
        // Verificar que el usuario existe
        if (!$usuario) {
            session()->destroy();
            return redirect()->to('/auth/login')->with('error', 'Usuario no encontrado. Por favor inicia sesión nuevamente.');
        }
        
        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario
        ];
        
        return view('visitante/perfil', $data);
    }
    
    // Editar perfil
    public function editarPerfil()
    {
        $redirect = $this->verificarLogin();
        if ($redirect) return $redirect;
        
        $validation = \Config\Services::validation();
        
        $id = session()->get('usuario_id');
        
        // Reglas base
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,{$id}]"
        ];
        
        $messages = [
            'nombre' => [
                'required' => 'El nombre es requerido',
                'min_length' => 'El nombre debe tener al menos 3 caracteres'
            ],
            'email' => [
                'required' => 'El email es requerido',
                'valid_email' => 'Debe ingresar un email válido',
                'is_unique' => 'Este email ya está registrado'
            ]
        ];
        
        // Solo validar password si se proporciona
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
            
            $messages['password'] = [
                'min_length' => 'La contraseña debe tener al menos 6 caracteres'
            ];
            $messages['password_confirm'] = [
                'matches' => 'Las contraseñas no coinciden'
            ];
        }
        
        $validation->setRules($rules, $messages);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email')
        ];
        
        // Solo actualizar password si se proporciona
        if (!empty($password)) {
            $data['password'] = $password;
        }
        
        if ($this->usuarioModel->update($id, $data)) {
            // Actualizar sesión
            session()->set('usuario_nombre', $data['nombre']);
            session()->set('usuario_email', $data['email']);
            
            return redirect()->to('/visitante/perfil')->with('success', 'Perfil actualizado correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil');
        }
    }
}