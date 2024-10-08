<?php
// Configuración de cabeceras para permitir acceso desde cualquier origen y aceptar varios métodos
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Obtener la URL solicitada
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

// Enrutamiento básico
switch ($request_uri[0]) {
    // Ruta para la versión 1 de la API
    case '/v1/contenido':
        require_once __DIR__ . '/v1/contenido.php';
        break;

    default:
        // Si la ruta no coincide, devolver un error 404
        http_response_code(404);
        echo json_encode(["message" => "Endpoint no encontrado."]);
        break;
}
