<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\YourNew;
use App\Models\Categorie;
use App\Models\Etiqueta;
use App\Models\User;



class YourNews extends Controller
{
    public function index()
    {
        // Verifica si hay datos en la sesión con la clave 'user_id'
        $session = session();
        $userId = $session->get('user_id');

        if ($userId) {
            $userRoleId = session('role_id');

            if ($userRoleId == 2) {
                $YournewsModel = new YourNew();
                $categoryController = new Categorie();
                $etiquetaModel = new Etiqueta();
                $userModel = new User();

                // Obtener la categoría seleccionada
                $selectedCategory = $this->request->getGet('category');

                // Obtener las etiquetas seleccionadas
                $selectedEtiquetas = $this->request->getGet('etiquetas');

                // Filtrar las noticias por categoría si se selecciona una categoría
                $YourNews = ($selectedCategory && $selectedCategory !== 'all') ?
                    $YournewsModel->getNewsByCategory($userId, $selectedCategory) :
                    $YournewsModel->getNews($userId);

                // Filtrar las noticias por etiquetas seleccionadas
                $YourNewsByEtiquetas = $YournewsModel->getNewsByEtiquetas($userId, $selectedEtiquetas);

                // Fusionar los resultados de las dos consultas
                if (!empty($YourNewsByEtiquetas)) {
                    $YourNews = array_intersect_key($YourNews, $YourNewsByEtiquetas);
                }

                $categorias = $categoryController->getCategories();
                $etiquetas = $etiquetaModel->getAllEtiquetas($userId);
                $user = $userModel->getUser($userId);

                foreach ($YourNews as &$YourNew) {
                    $YourNew['category_name'] = $YournewsModel->getCategoryNameById($YourNew['category_id']);
                }

                $data['YourNews'] = $YourNews;
                $data['categorias'] = $categorias;
                $data['etiquetas'] = $etiquetas;
                $data['user'] = $user;

                return view('your_unique_news', $data);
            }else{
                return redirect()->back();

            }
        } else {
            // Si no hay datos en la sesión, redirige a alguna otra página o realiza la acción deseada
            return view('login');
        }
    }

    public function search()
    {
        $YournewsModel = new YourNew();
        $categoryController = new Categorie();
        $etiquetaModel = new Etiqueta();
        $userModel = new User();

        $session = session();
        $userId = $session->get('user_id');

        // Obtener la palabra clave de búsqueda
        $keyword = $this->request->getGet('q');

        // Obtener las noticias que coinciden con la palabra clave
        $YourNews = $YournewsModel->searchNews($userId, $keyword);

        $categorias = $categoryController->getCategories();
        $etiquetas = $etiquetaModel->getAllEtiquetas($userId);
        $user = $userModel->getUser($userId);

        foreach ($YourNews as &$YourNew) {
            $YourNew['category_name'] = $YournewsModel->getCategoryNameById($YourNew['category_id']);
        }

        $data['YourNews'] = $YourNews;
        $data['categorias'] = $categorias;
        $data['etiquetas'] = $etiquetas;
        $data['user'] = $user;
        $data['searchKeyword'] = $keyword;

        return view('your_unique_news', $data);
    }

    public function portadaPublica($nombre, $apellido, $userid)
    {
        $YournewsModel = new YourNew();
        $categoryController = new Categorie();
        $etiquetaModel = new Etiqueta();
        $userModel = new User();

        $userId = $userid;

        // Obtener la categoría seleccionada
        $selectedCategory = $this->request->getGet('category');

        // Obtener las etiquetas seleccionadas
        $selectedEtiquetas = $this->request->getGet('etiquetas');

        // Filtrar las noticias por categoría si se selecciona una categoría
        $YourNews = ($selectedCategory && $selectedCategory !== 'all') ?
            $YournewsModel->getNewsByCategory($userId, $selectedCategory) :
            $YournewsModel->getNews($userId);

        // Filtrar las noticias por etiquetas seleccionadas
        $YourNewsByEtiquetas = $YournewsModel->getNewsByEtiquetas($userId, $selectedEtiquetas);

        // Fusionar los resultados de las dos consultas
        if (!empty($YourNewsByEtiquetas)) {
            $YourNews = array_intersect_key($YourNews, $YourNewsByEtiquetas);
        }

        $categorias = $categoryController->getCategories();
        $etiquetas = $etiquetaModel->getAllEtiquetas($userId);
        $user = $userModel->getUser($userId);

        foreach ($YourNews as &$YourNew) {
            $YourNew['category_name'] = $YournewsModel->getCategoryNameById($YourNew['category_id']);
        }

        $data['YourNews'] = $YourNews;
        $data['categorias'] = $categorias;
        $data['etiquetas'] = $etiquetas;
        $data['user'] = $user;

        if ($user['publica'] == 1) {
            return view('portada_publica', $data);
        } else {
            return view('portada_publica', $data);
        }
    }
}
