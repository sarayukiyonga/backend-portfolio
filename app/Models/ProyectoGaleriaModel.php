<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoGaleriaModel extends Model
{
    protected $table = 'proyecto_galeria';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'proyecto_id',
        'imagen',
        'titulo',
        'orden'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
    
    // Obtener galería de un proyecto
    public function getGaleria($proyectoId)
    {
        return $this->where('proyecto_id', $proyectoId)
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
    
    // Eliminar galería de un proyecto
    public function eliminarGaleriaProyecto($proyectoId)
    {
        return $this->where('proyecto_id', $proyectoId)->delete();
    }
    
    // Obtener el siguiente orden
    public function getSiguienteOrden($proyectoId)
    {
        $result = $this->selectMax('orden')
                       ->where('proyecto_id', $proyectoId)
                       ->first();
        
        return ($result['orden'] ?? 0) + 1;
    }
}
