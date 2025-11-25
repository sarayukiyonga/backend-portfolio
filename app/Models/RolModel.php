<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    
    // Obtener todos los roles para selects
    public function getRolesParaSelect()
    {
        $roles = $this->findAll();
        $options = [];
        foreach ($roles as $rol) {
            $options[$rol['id']] = $rol['nombre'];
        }
        return $options;
    }
    
    // Verificar si un rol existe
    public function rolExiste($nombre)
    {
        return $this->where('nombre', $nombre)->first() !== null;
    }
}
