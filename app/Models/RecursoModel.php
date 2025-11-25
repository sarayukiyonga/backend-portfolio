<?php

namespace App\Models;

use CodeIgniter\Model;

class RecursoModel extends Model
{
    protected $table = 'recursos';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'titulo',
        'descripcion',
        'tipo',
        'archivo',
        'tamanio',
        'icono',
        'activo',
        'orden',
        'descargas',
        'visible_para'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Obtener recursos activos ordenados
     */
    public function getRecursosActivos($visibilidad = 'todos')
    {
        $builder = $this->where('activo', 1);
        
        if ($visibilidad !== 'admin') {
            $builder->whereIn('visible_para', [$visibilidad, 'todos']);
        }
        
        return $builder->orderBy('orden', 'ASC')
                       ->orderBy('created_at', 'DESC')
                       ->findAll();
    }
    
    /**
     * Obtener todos los recursos (admin)
     */
    public function getTodosRecursos()
    {
        return $this->orderBy('orden', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Incrementar contador de descargas
     */
    public function incrementarDescarga($id)
    {
        $recurso = $this->find($id);
        
        if ($recurso) {
            return $this->update($id, [
                'descargas' => $recurso['descargas'] + 1
            ]);
        }
        
        return false;
    }
    
    /**
     * Cambiar estado activo/inactivo
     */
    public function cambiarEstado($id, $activo)
    {
        return $this->update($id, ['activo' => $activo ? 1 : 0]);
    }
    
    /**
     * Obtener estadísticas
     */
    public function getEstadisticas()
    {
        return [
            'total' => $this->countAll(),
            'activos' => $this->where('activo', 1)->countAllResults(),
            'inactivos' => $this->where('activo', 0)->countAllResults(),
            'descargas_totales' => $this->selectSum('descargas')->first()['descargas'] ?? 0
        ];
    }
    
    /**
     * Buscar recursos por tipo
     */
    public function getPorTipo($tipo)
    {
        return $this->where('tipo', $tipo)
                    ->where('activo', 1)
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
}
