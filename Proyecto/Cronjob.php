<?php

class Database
{
    private $host = "localhost";
    private $usuario = "root";
    private $contrasena = "";
    private $nombre_bd = "newscover";
    private $conexion;

    public function conectar()
    {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->nombre_bd", $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            die();
        }
    }
}



class NewsSourcesModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function insertNews($id, $title, $url, $short_description, $pubDate, $urlImage, $category_id, $user_id)
    {
        // Verificar si ya existe un registro con los mismos valores
        $checkQuery = "SELECT COUNT(*) FROM news WHERE title = ? AND permanlink = ? AND news_source_id = ? AND user_id = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([$title, $url, $id, $user_id]);
        $count = $checkStmt->fetchColumn();

        // Si ya existe un registro, no realizar la inserción
        if ($count > 0) {
            return false;
        }

        // Si no existe, proceder con la inserción
        $insertQuery = "INSERT INTO news (title, short_description, permanlink, urlImage, date, news_source_id, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $this->db->prepare($insertQuery);
        $insertStmt->execute([$title, $short_description, $url, $urlImage, $pubDate, $id, $user_id, $category_id]);

        return $insertStmt->rowCount() > 0;
    }

    public function optenerIndice()
    {
        $query = "SELECT id FROM news_sources ORDER BY id DESC LIMIT 1;";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener el ID del último registro
        $lastId = $stmt->fetchColumn();

        return $lastId;
    }

    public function getNewsSources($userId)
    {
        $query = "SELECT n.id, n.url, n.name, c.name AS category_id, n.user_id 
        FROM news_sources n 
        INNER JOIN categories c ON n.category_id = c.id 
        WHERE n.user_id = $userId
        LIMIT 0, 25";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewsSourcesAll()
    {
        $query = "SELECT n.id, n.url, n.name, c.name AS category_id_name,n.category_id, n.user_id 
        FROM news_sources n 
        INNER JOIN categories c ON n.category_id = c.id 
        LIMIT 0, 25";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getLastInsertedId()
    {
        // Utiliza el método lastInsertId de PDO para obtener el ID de la última inserción
        return $this->db->lastInsertId();
    }

    public function insertCategoryForNews($newsId, $categoryName)
    {
        // Asegurarse de que $categoryName sea seguro para la base de datos, puedes sanitizarlo según sea necesario
        $safeCategoryName = htmlspecialchars($categoryName);

        // Verificar si ya existe una etiqueta con el mismo id_new y name_etiqueta
        $checkQuery = "SELECT COUNT(*) FROM etiqueta_news WHERE id_new = ? AND name_etiqueta = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([$newsId, $safeCategoryName]);
        $existingCount = $checkStmt->fetchColumn();

        if ($existingCount == 0) {
            // No existe la etiqueta, proceder con la inserción
            $insertQuery = "INSERT INTO etiqueta_news (id_new, name_etiqueta) VALUES (?, ?)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->execute([$newsId, $safeCategoryName]);
        }
        // Si $existingCount es mayor que 0, la etiqueta ya existe y no es necesario insertarla nuevamente
    }

    public function optenerIndiceNews()
    {
        $query = "SELECT id FROM news ORDER BY id DESC LIMIT 1;";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener el ID del último registro
        $lastId = $stmt->fetchColumn();

        return $lastId;
    }
}

class Cronjob
{
    private $newsSourcesController; // Asegúrate de que sea con minúscula
    private $newsSourcesModel; // Asegúrate de que sea con minúscula


    public function __construct()
    {
        $database = new Database();
        $db = $database->conectar();
        $this->newsSourcesModel = new newsSourcesModel($db);
    }

    public function procesaXml()
    {
        echo "Entrooo\n";  // Agrega "\n" para un salto de línea
        $noticias = $this->newsSourcesModel->getNewsSourcesAll();
        // Obtiene el enlace del archivo XML desde el formulario
        foreach ($noticias as $noticia) {
            $xml_id = $noticia['id'];
            $xml_url = $noticia['url'];
            $xml_name = $noticia['name'];;
            $category_xml_name = $noticia['category_id_name'];
            $category_xml_id = $noticia['category_id'];
            $user_xml_id = $noticia['user_id'];
            echo '"' . $xml_id . '","' . $xml_url . '", "' . $xml_name . '","' . $category_xml_name . '", "' . $category_xml_id . '","' . $user_xml_id . '"';

            // Intenta cargar el contenido XML con el espacio de nombres "media"
            $xml = @simplexml_load_file($xml_url, null, LIBXML_NOCDATA);


            if ($xml !== false) {
                // La palabra clave a buscar en minúsculas
                $category_search_lower = strtolower($category_xml_name);

                // Verifica si la categoría está presente en el título del canal
                $channel_title_lower = strtolower((string)$xml->channel->title);
                $channel_title_words = array_map('strtolower', preg_split('/[\s-]+/', trim((string)$xml->channel->title)));
                $entro = false;
                foreach ($channel_title_words as $word) {
                    $category_search_lower = strtolower($category_xml_name);
                    if ($word === $category_search_lower) {
                        $entro = true;
                    }
                }

                if ($entro === true) {

                    foreach ($xml->channel->item as $item) {
                        // Las categorías del elemento en minúsculas

                        $title = htmlspecialchars($item->title);
                        $link = htmlspecialchars($item->link);
                        $short_description = strip_tags($item->description);
                        $pubDate = (new DateTime($item->pubDate))->format('Y-m-d H:i:s');

                        $item->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
                        $media_content = $item->xpath('media:content');

                        if (!empty($media_content)) {
                            $urlImage = htmlspecialchars((string)$media_content[0]['url']);
                        } else {
                            $enclosure_url = (string)$item->enclosure['url'];

                            if (!empty($enclosure_url)) {
                                $urlImage = htmlspecialchars($enclosure_url);
                            } else {
                                $description = $item->description;

                                // Modifica la expresión regular para adaptarse a las posibles variaciones
                                preg_match('/<img[^>]+?src=[\'"]([^\'"]+)[\'"][^>]*>/i', $description, $matches);
                                $urlImage = htmlspecialchars($matches[1] ?? 'No especificada');
                            }
                        }

                        $categories = []; // Crear un arreglo para almacenar las categorías

                        // Obtener las categorías del elemento en minúsculas
                        foreach ($item->category as $category) {
                            $categoryName = (string)$category;
                            $categories[] = $categoryName;
                        }
                        $this->newsSourcesModel->insertNews($xml_id, $title, $link, $short_description, $pubDate, $urlImage, $category_xml_id, $user_xml_id);

                        $lastInsertedId = $this->newsSourcesModel->optenerIndiceNews();

                        foreach ($categories as $categoryName) {
                            // Asegurarse de que $categoryName sea seguro para la base de datos, puedes sanitizarlo según sea necesario
                            $safeCategoryName = htmlspecialchars($categoryName);

                            // Insertar en la tabla 'etiqueta_news'
                            $this->newsSourcesModel->insertCategoryForNews($lastInsertedId, $safeCategoryName);
                        }
                    }
                } else {
                    foreach ($xml->channel->item as $item) {
                        $categories_in_tags = array_map('strtolower', array_map('htmlspecialchars', iterator_to_array($item->category)));
                        $url_parts = parse_url($item->link);
                        $categories_in_url = array_map('strtolower', array_map('htmlspecialchars', array_filter(explode('/', $url_parts['path']))));
                        $titleParts = array_map('strtolower', explode(' – ', htmlspecialchars($item->title)));

                        $all_categories = array_merge($categories_in_tags, $categories_in_url, $titleParts);

                        $category_search_lower = strtolower($category_xml_name);

                        if (in_array($category_search_lower, $all_categories)) {

                            $title = htmlspecialchars($item->title);
                            $link = htmlspecialchars($item->link);
                            $short_description = strip_tags($item->description);
                            $pubDate = (new DateTime($item->pubDate))->format('Y-m-d H:i:s');
                            $item->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');

                            $media_content = $item->xpath('media:content');
                            if (!empty($media_content)) {
                                $urlImage = htmlspecialchars((string)$media_content[0]['url']);
                            } else {
                                $enclosure_url = (string)$item->enclosure['url'];

                                if (!empty($enclosure_url)) {
                                    $urlImage = htmlspecialchars($enclosure_url);
                                } else {
                                    $description = $item->description;

                                    // Modifica la expresión regular para adaptarse a las posibles variaciones
                                    preg_match('/*>/i', $description, $matches);
                                    $urlImage = htmlspecialchars($matches[1] ?? 'No especificada');
                                }
                            }

                            $categories = []; // Crear un arreglo para almacenar las categorías

                            // Obtener las categorías del elemento en minúsculas
                            foreach ($item->category as $category) {
                                $categoryName = (string)$category;
                                $categories[] = $categoryName;
                            }
                            $this->newsSourcesModel->insertNews($xml_id, $title, $link, $short_description, $pubDate, $urlImage, $category_xml_id, $user_xml_id);

                            $lastInsertedId = $this->newsSourcesModel->optenerIndiceNews();

                            foreach ($categories as $categoryName) {
                                // Asegurarse de que $categoryName sea seguro para la base de datos, puedes sanitizarlo según sea necesario
                                $safeCategoryName = htmlspecialchars($categoryName);

                                // Insertar en la tabla 'etiqueta_news'
                                $this->newsSourcesModel->insertCategoryForNews($lastInsertedId, $safeCategoryName);
                            }
                        }
                    }
                }
            } else {
                // Retorna un mensaje de error en lugar de imprimirlo
                echo 'Error: No se pudo cargar el archivo XML. Comprueba la validez del enlace.';
            }
        }
    }
}

$database = new Database();
$db = $database->conectar();

$cronjob = new Cronjob();
$cronjob->procesaXml();
