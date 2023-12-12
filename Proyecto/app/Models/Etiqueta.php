<?php 
namespace App\Models;

use CodeIgniter\Model;

class Etiqueta extends Model{
    protected $table      = 'etiqueta_news';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_new', 'name_etiqueta'];

    public function getAllEtiquetas($userId)
    {
        // Modifica la consulta para obtener solo las etiquetas del usuario específico
        return $this->distinct()
            ->select('name_etiqueta')
            ->join('news', 'news.id = etiqueta_news.id_new')
            ->where('news.user_id', $userId)
            ->findAll();
    }
}