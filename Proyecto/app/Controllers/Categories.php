<?php

namespace App\Controllers;

use App\Models\Categorie;
use CodeIgniter\Controller;

class Categories extends Controller
{
    public function index()
    {
        if (session()->has('user_id')) {
            // Obtén el ID del rol del usuario desde la sesión
            $userRoleId = session('role_id');
    
            // Comprueba si el ID del rol es igual a 1 (o ajusta según tu lógica)
            if ($userRoleId == 1) {
                // Si es el rol con ID 1, continúa con la lógica actual
                $categoryModel = new Categorie();
                $categories = $categoryModel->getCategories();
    
                $data['categories'] = $categories;
    
                return view('categories', $data);
            } else {
                // Si el usuario no tiene el rol con ID 1, redirige o realiza la acción deseada
                return redirect()->back();
            }
        } else {
            // Si no hay datos en la sesión, redirige a alguna otra página o realiza la acción deseada
            return view('login');
        }
    }

    public function agregar()
    {
        // Carga el modelo de categorías
        $categoryModel = new Categorie();

        // Obtiene los datos del formulario
        $nombreCategoria = $this->request->getPost('categoriaModal');

        // Valida si el nombre de la categoría no está vacío
        if (!empty($nombreCategoria)) {
            // Construye los datos para la nueva categoría
            $data = [
                'name' => $nombreCategoria,
            ];

            // Inserta la nueva categoría en la base de datos
            $categoryModel = new Categorie();
            $categoryModel->insertCategory($data);

            // Redirecciona a la página de categorías con un mensaje de éxito
            return redirect()->to(base_url('categories'))->with('success', 'Categoría agregada exitosamente.');
        } else {
            // Si el nombre de la categoría está vacío, redirecciona con un mensaje de error
            return redirect()->to(base_url('categories'))->with('error', 'El nombre de la categoría no puede estar vacío.');
        }
    }

    public function delete($id)
    {
        $categoryModel = new Categorie();
        $categoryModel->deleteCategory($id);
        return redirect()->to('/categories');
    }
    public function editCategory($id)
    {
        $categoryModel = new Categorie();

        // Obtiene los datos del formulario
        $nombreCategoria = $this->request->getPost('categoriaModalEditar');

        // Valida si el nombre de la categoría no está vacío
        if (!empty($nombreCategoria)) {
            // Construye los datos para la nueva categoría
            $data = [
                'name' => $nombreCategoria,
            ];

            // Inserta la nueva categoría en la base de datos
            $categoryModel->updateCategory($id, $data);

            // Redirecciona a la página de categorías con un mensaje de éxito
            return redirect()->to(base_url('categories'))->with('success', 'Categoría editada exitosamente.');
        } 
    }
}
