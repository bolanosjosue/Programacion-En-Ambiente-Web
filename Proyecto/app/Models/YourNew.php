<?php

namespace App\Models;

use CodeIgniter\Model;

class YourNew extends Model
{
    protected $table      = 'news';
    protected $primaryKey = 'id'; // Descomenta si deseas especificar la clave primaria

    protected $allowedFields = ['title', 'short_description', 'permanlink', 'urlImage', 'date', 'news_source_id', 'user_id', 'category_id'];

    // Otros ajustes del modelo, si es necesario

    public function getNews($user_id)
    {
        return $this->where('user_id', $user_id)->findAll();
    }

    public function getCategoryNameById($category_id)
    {
        $categorieModel = new Categorie();
        $category = $categorieModel->find($category_id);

        return ($category) ? $category['name'] : null;
    }

    public function getNewsByCategory($user_id, $category_id)
    {
        return ($category_id && $category_id !== 'all') ?
            $this->where('user_id', $user_id)->where('category_id', $category_id)->findAll() :
            $this->where('user_id', $user_id)->findAll();
    }

    public function getNewsByEtiquetas($user_id, $etiquetas)
    {
        // Filtra las noticias por etiquetas
        return ($etiquetas) ?
            $this->select('news.*')
            ->join('etiqueta_news', 'news.id = etiqueta_news.id_new')
            ->whereIn('etiqueta_news.name_etiqueta', $etiquetas)
            ->where('news.user_id', $user_id)
            ->groupBy('news.id')
            ->findAll() :
            $this->where('user_id', $user_id)->findAll();
    }

    public function searchNews($user_id, $keyword)
    {
        return $this->like('title', $keyword)
            ->orWhere('short_description LIKE', "%$keyword%")
            ->where('user_id', $user_id)
            ->findAll();
    }

    public function deleteNews($id_news_sources)
    {

        
        return $this->where('news_source_id', $id_news_sources)->delete();
    }
}
