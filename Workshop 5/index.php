<?php
$ceu = array(
    "Italia" => "Roma",
    "Luxemburgo" => "Luxemburgo",
    "Bélgica" => "Bruselas",
    "Dinamarca" => "Copenhague",
    "Finlandia" => "Helsinki",
    "Francia" => "París",
    "Eslovaquia" => "Bratislava",
    "Eslovenia" => "Ljubljana",
    "Alemania" => "Berlín",
    "Grecia" => "Atenas",
    "Irlanda" => "Dublín",
    "Países Bajos" => "Ámsterdam",
    "Portugal" => "Lisboa",
    "España" => "Madrid",
    "Suecia" => "Estocolmo",
    "Reino Unido" => "Londres",
    "Chipre" => "Nicosia",
    "Lituania" => "Vilnius",
    "República Checa" => "Praga",
    "Estonia" => "Tallin",
    "Hungría" => "Budapest",
    "Letonia" => "Riga",
    "Malta" => "Valetta",
    "Austria" => "Viena",
    "Polonia" => "Varsovia"
);

foreach ($ceu as $pais => $capital) {
    echo "La capital de $pais: es $capital \n";
}
echo"\n \n \n";

$temperaturas = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
foreach ($temperaturas as $temp) {
    echo "Temperaturas registradas $temp \n";
}

$promedio = array_sum($temperaturas) / count($temperaturas);

$temp_bajas = array_unique($temperaturas);
sort($temp_bajas);
$temp_bajas = array_slice($temp_bajas, 0, 5);

$temp_altas = array_unique($temperaturas);
rsort($temp_altas);
$temp_altas = array_slice($temp_altas, 0, 5);

// Mostrar resultados
echo "La temperatura promedio es: " . number_format($promedio, 1)."\n";
echo "Lista de las 5 temperaturas más bajas (sin duplicados): " . implode(", ", $temp_bajas)."\n";
echo "Lista de las 5 temperaturas más altas (sin duplicados): " . implode(", ", $temp_altas)."\n";
?>
