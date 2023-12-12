<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NewsSource;
use App\Models\YourNew;
use App\Models\Categorie;

class NewsSources extends Controller
{

    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        if ($userId) {

            $userRoleId = session('role_id');
            if ($userRoleId == 2) {
                // Si hay datos en la sesión, procede con la lógica actual
                $newsModel = new NewsSource();
                $categoryController = new Categorie();

                $newsSources = $newsModel->getNewsSourcesByUserId($userId);

                // Modificar el array para incluir el nombre de la categoría
                foreach ($newsSources as &$newsSource) {
                    $newsSource['category_name'] = $newsModel->getCategoryNameById($newsSource['category_id']);
                }

                $categorias = $categoryController->getCategories();

                $data['newsSources'] = $newsSources;
                $data['categorias'] = $categorias;

                return view('news_sources', $data);
            } else {    
                return redirect()->back();
            }
        } else {
            // Si no hay datos en la sesión, redirige a alguna otra página o realiza la acción deseada
            return view('login');
        }
    }

    public function agregar()
    {
        // Obtener los datos del formulario
        $fuente = $this->request->getPost('fuente');
        $rssUrl = $this->request->getPost('rssUrl');
        $categoriaId = $this->request->getPost('categoriaSelect');

        // Validar y procesar los datos según tus necesidades

        // Crear una instancia del modelo
        $newsModel = new NewsSource();

        // Crear un array con los datos a insertar
        $data = [
            'name' => $fuente,
            'url' => $rssUrl,
            'category_id' => $categoriaId,
            'user_id' => session()->get('user_id')
        ];

        // Llamar al método del modelo para insertar en la base de datos
        $newsModel->insertNewsSource($data);

        // Redirigir a la página principal o realizar alguna otra acción después de la inserción
        return redirect()->to(base_url('news_sources'));
    }


    public function delete($id)
    {
        $newsSourcesModel = new NewsSource();
        $your_new = new YourNew();
        $newsSourcesModel->deleteNewsSources($id);
        $your_new->deleteNews($id);
        return redirect()->to('/news_sources');
    }

    public function editNewsSources($id)
    {
        // Obtener los datos del formulario
        $nombreFuente = $this->request->getPost('fuenteE');
        $rssUrl = $this->request->getPost('rssUrlE');
        $categoriaId = $this->request->getPost('categoriaSelectE');

        // Validar y procesar los datos según tus necesidades

        // Crear una instancia del modelo
        $newsModel = new NewsSource();

        // Crear un array con los datos a actualizar
        $data = [
            'name' => $nombreFuente,
            'url' => $rssUrl,
            'category_id' => $categoriaId,
        ];

        // Llamar al método del modelo para actualizar la fuente de noticias
        $newsModel->updateNewsSource($id, $data);
        return redirect()->to(base_url('news_sources'));
    }
}
