<?php
require_once(__DIR__ . '/../Controller/news_sources_controller.php');
require_once(__DIR__ . '/../Model/news_sources_model.php');
require_once(__DIR__ . '/../config/database.php'); // Asegúrate de incluir el archivo que contiene la clase Database

class ScriptXml
{
    private $newsSourcesController; // Asegúrate de que sea con minúscula
    private $newsSourcesModel; // Asegúrate de que sea con minúscula


    public function __construct()
    {
        $database = new Database();
        $db = $database->conectar();
        $this->newsSourcesController = new NewsSourcesController($db);
        $this->newsSourcesModel = new newsSourcesModel($db);
    }

    public function procesaXml()
    {
        echo "Entrooo\n";  // Agrega "\n" para un salto de línea
        $noticias = $this->newsSourcesController->getNewsSourcesAll();
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
                        $short_description = substr(strip_tags($item->description), 0, 200);
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
                        $this->newsSourcesModel->insertNews($xml_id, $title, $link, $short_description, $pubDate, $urlImage, $category_xml_id, $user_xml_id);
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
                            $short_description = substr(strip_tags($item->description), 0, 200);
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

                            $this->newsSourcesModel->insertNews($xml_id, $title, $link, $short_description, $pubDate, $urlImage, $category_xml_id, $user_xml_id);
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

$scriptXml = new ScriptXml();
$scriptXml->procesaXml();
