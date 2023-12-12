<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsSource extends Model
{
    protected $table = 'news_sources';
    protected $primaryKey = 'id';
    protected $allowedFields = ['url', 'name', 'category_id', 'user_id']; // Asegúrate de especificar los campos permitidos

    public function getNewsSourcesByUserId($user_id)
    {
        return $this->where('user_id', $user_id)->findAll();
    }

    public function insertNewsSource($data)
    {
        return $this->insert($data);
    }

    public function deleteNewsSources($id)
    {
        return $this->delete($id);
    }

    public function getCategoryNameById($category_id)
    {
        $categorieModel = new Categorie();
        $category = $categorieModel->find($category_id);

        return ($category) ? $category['name'] : null;
    }

    public function updateNewsSource($id, $data)
    {

        return $this->update($id, $data);
    }
}
