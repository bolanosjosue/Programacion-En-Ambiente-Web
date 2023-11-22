<?php
function obtenerUrlPerfil($nombre_usuario) {
    $iniciales_imagenes = array(
        'A' => 'https://static.vecteezy.com/system/resources/previews/005/064/974/original/letter-a-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'B' => 'https://static.vecteezy.com/system/resources/previews/005/064/924/original/letter-b-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'C' => 'https://static.vecteezy.com/system/resources/previews/005/064/923/original/letter-c-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'D' => 'https://static.vecteezy.com/system/resources/previews/005/064/970/original/letter-d-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'E' => 'https://static.vecteezy.com/system/resources/previews/005/064/976/original/letter-e-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'F' => 'https://static.vecteezy.com/system/resources/previews/005/064/965/original/letter-f-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'G' => 'https://static.vecteezy.com/system/resources/previews/005/064/915/original/letter-g-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'H' => 'https://static.vecteezy.com/system/resources/previews/005/064/861/original/letter-h-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'I' => 'https://static.vecteezy.com/system/resources/previews/005/064/925/non_2x/letter-i-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'J' => 'https://static.vecteezy.com/system/resources/previews/006/720/731/non_2x/letter-j-with-green-leafs-icon-logo-design-template-illustration-vector.jpg',
        'K' => 'https://static.vecteezy.com/system/resources/previews/005/064/971/original/letter-k-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'L' => 'https://static.vecteezy.com/system/resources/previews/005/064/977/non_2x/letter-l-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'M' => 'https://static.vecteezy.com/system/resources/previews/005/064/975/original/letter-m-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'N' => 'https://static.vecteezy.com/system/resources/previews/005/064/863/original/letter-n-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'Ñ' => 'https://static.vecteezy.com/system/resources/previews/005/064/863/original/letter-n-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'O' => 'https://static.vecteezy.com/system/resources/previews/005/064/877/original/letter-o-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'P' => 'https://static.vecteezy.com/system/resources/previews/005/064/963/original/letter-p-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'Q' => 'https://static.vecteezy.com/system/resources/previews/005/064/878/original/letter-q-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'R' => 'https://static.vecteezy.com/system/resources/previews/005/064/871/original/letter-r-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'S' => 'https://static.vecteezy.com/system/resources/previews/005/064/916/original/letter-s-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'T' => 'https://static.vecteezy.com/system/resources/previews/007/049/765/non_2x/letter-t-with-green-leaf-symbol-logo-vector.jpg',
        'U' => 'https://static.vecteezy.com/system/resources/previews/005/064/973/original/letter-u-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'V' => 'https://static.vecteezy.com/system/resources/previews/005/064/912/original/letter-v-alphabet-home-natural-green-icons-leaf-logo-house-free-vector.jpg',
        'W' => 'https://static.vecteezy.com/system/resources/previews/005/064/969/original/letter-w-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'X' => 'https://static.vecteezy.com/system/resources/previews/005/064/921/original/letter-x-alphabet-natural-green-icons-leaf-logo-free-vector.jpg',
        'Y' => 'https://media.istockphoto.com/id/1328852222/es/vector/plantilla-de-dise%C3%B1o-de-ilustraci%C3%B3n-de-material-de-letra-y-y-vector-de-hoja.jpg?s=612x612&w=0&k=20&c=bfGTBfA8CLOTSkTUs38bJo_yRyaw-vg7-SEVRMUHcyw=',
        'Z' => 'https://static.vecteezy.com/system/resources/previews/005/064/860/original/letter-z-alphabet-natural-green-icons-leaf-logo-free-vector.jpg'
    );

    $inicial_usuario = strtoupper(substr($nombre_usuario, 0, 1));

    if (array_key_exists($inicial_usuario, $iniciales_imagenes)) {
        return $iniciales_imagenes[$inicial_usuario];
    } else {
        return 'url_predeterminada.jpg';
    }
}
?>

