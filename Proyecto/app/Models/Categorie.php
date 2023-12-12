<?php

namespace App\Models;

use CodeIgniter\Model;

class Categorie extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name']; // Agrega otros campos si es necesario

    public function getCategories()
    {
        return $this->findAll();
    }

    public function insertCategory($data)
    {
        return $this->insert($data);
    }

    public function deleteCategory($id)
    {
        return $this->delete($id);
    }

    public function updateCategory($id, $data)
    {
        return $this->update($id, $data);
    }
}
