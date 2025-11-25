<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'email', 'password', 'rol_id', 'activo'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email',
        'rol_id' => 'required|integer'
    ];
    
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es requerido',
            'min_length' => 'El nombre debe tener al menos 3 caracteres'
        ],
        'email' => [
            'required' => 'El email es requerido',
            'valid_email' => 'Debe proporcionar un email válido'
        ],
        'rol_id' => [
            'required' => 'El rol es requerido',
            'integer' => 'El rol debe ser un número válido'
        ]
    ];
    
    // Hashear password antes de guardar
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        // Solo hashear si el campo password está presente y no está vacío
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        } else {
            // Si está vacío en una actualización, quitarlo para no actualizar
            if (isset($data['data']['password'])) {
                unset($data['data']['password']);
            }
        }
        return $data;
    }
    
    // Obtener usuario con su rol
    public function getUsuarioConRol($id)
    {
        if (empty($id)) {
            log_message('error', 'UsuarioModel::getUsuarioConRol - ID vacío o nulo');
            return null;
        }
        
        try {
            $resultado = $this->select('usuarios.*, roles.nombre as rol_nombre')
                             ->join('roles', 'roles.id = usuarios.rol_id', 'left')
                             ->where('usuarios.id', $id)
                             ->first();
            
            if (!$resultado) {
                log_message('error', "UsuarioModel::getUsuarioConRol - Usuario no encontrado con ID: {$id}");
            }
            
            return $resultado;
        } catch (\Exception $e) {
            log_message('error', 'UsuarioModel::getUsuarioConRol - Error: ' . $e->getMessage());
            return null;
        }
    }
    
    // Obtener usuario por email con rol
    public function getUsuarioPorEmail($email)
    {
        if (empty($email)) {
            log_message('error', 'UsuarioModel::getUsuarioPorEmail - Email vacío o nulo');
            return null;
        }
        
        try {
            return $this->select('usuarios.*, roles.nombre as rol_nombre')
                        ->join('roles', 'roles.id = usuarios.rol_id', 'left')
                        ->where('usuarios.email', $email)
                        ->first();
        } catch (\Exception $e) {
            log_message('error', 'UsuarioModel::getUsuarioPorEmail - Error: ' . $e->getMessage());
            return null;
        }
    }
    
    // Verificar credenciales
    public function verificarCredenciales($email, $password)
    {
        $usuario = $this->getUsuarioPorEmail($email);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['activo'] == 1) {
                return $usuario;
            }
        }
        return false;
    }
    
    // Listar todos los usuarios con sus roles
    public function listarUsuarios()
    {
        try {
            return $this->select('usuarios.*, roles.nombre as rol_nombre')
                        ->join('roles', 'roles.id = usuarios.rol_id', 'left')
                        ->orderBy('usuarios.created_at', 'DESC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'UsuarioModel::listarUsuarios - Error: ' . $e->getMessage());
            return [];
        }
    }
    
    // Método para actualizar sin hashear contraseña vacía
    public function actualizarSinPassword($id, $data)
    {
        // Si password está vacío o no existe, quitarlo del array
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }
        
        return $this->update($id, $data);
    }
}