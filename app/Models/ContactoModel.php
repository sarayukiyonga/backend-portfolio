<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table            = 'contactos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'leido',
        'respondido',
        'ip_address',
        'user_agent'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nombre'  => 'required|min_length[3]|max_length[255]',
        'email'   => 'required|valid_email|max_length[255]',
        'telefono' => 'permit_empty|max_length[50]',
        'mensaje' => 'required|min_length[10]|max_length[5000]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres',
            'max_length' => 'El nombre no puede superar 255 caracteres'
        ],
        'email' => [
            'required'    => 'El email es obligatorio',
            'valid_email' => 'Debe proporcionar un email válido',
            'max_length'  => 'El email no puede superar 255 caracteres'
        ],
        'telefono' => [
            'max_length' => 'El teléfono no puede superar 50 caracteres'
        ],
        'mensaje' => [
            'required'   => 'El mensaje es obligatorio',
            'min_length' => 'El mensaje debe tener al menos 10 caracteres',
            'max_length' => 'El mensaje no puede superar 5000 caracteres'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Obtener todos los contactos ordenados por fecha
     * 
     * @param int $limit Límite de resultados
     * @param int $offset Offset para paginación
     * @return array
     */
    public function getContactos($limit = null, $offset = 0)
    {
        $builder = $this->orderBy('created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->findAll();
    }

    /**
     * Obtener contactos no leídos
     * 
     * @return array
     */
    public function getNoLeidos()
    {
        return $this->where('leido', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Contar contactos no leídos
     * 
     * @return int
     */
    public function contarNoLeidos()
    {
        return $this->where('leido', 0)->countAllResults();
    }

    /**
     * Marcar contacto como leído
     * 
     * @param int $id ID del contacto
     * @return bool
     */
    public function marcarComoLeido($id)
    {
        return $this->update($id, ['leido' => 1]);
    }

    /**
     * Marcar contacto como respondido
     * 
     * @param int $id ID del contacto
     * @return bool
     */
    public function marcarComoRespondido($id)
    {
        return $this->update($id, [
            'respondido' => 1,
            'leido' => 1
        ]);
    }

    /**
     * Obtener estadísticas de contactos
     * 
     * @return array
     */
    public function getEstadisticas()
    {
        $total = $this->countAll();
        $noLeidos = $this->where('leido', 0)->countAllResults();
        $respondidos = $this->where('respondido', 1)->countAllResults();
        $hoy = $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();

        return [
            'total' => $total,
            'no_leidos' => $noLeidos,
            'respondidos' => $respondidos,
            'hoy' => $hoy
        ];
    }

    /**
     * Buscar contactos
     * 
     * @param string $termino Término de búsqueda
     * @return array
     */
    public function buscar($termino)
    {
        return $this->groupStart()
                        ->like('nombre', $termino)
                        ->orLike('email', $termino)
                        ->orLike('telefono', $termino)
                        ->orLike('mensaje', $termino)
                    ->groupEnd()
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener contactos por rango de fechas
     * 
     * @param string $fechaInicio Fecha inicio (Y-m-d)
     * @param string $fechaFin Fecha fin (Y-m-d)
     * @return array
     */
    public function getPorRangoFechas($fechaInicio, $fechaFin)
    {
        return $this->where('DATE(created_at) >=', $fechaInicio)
                    ->where('DATE(created_at) <=', $fechaFin)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
