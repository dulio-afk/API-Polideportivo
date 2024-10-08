<?php
header('Content-Type: application/json');

// Incluir los archivos necesarios
require_once '../config/configuracion.php';
require_once '../modelos/Contenido.php';
require_once '../modelos/conexion.php';

// Inicializar la conexión
$conexionObj = new Conexion();
$conexion = $conexionObj->abrirConexion();

if (!$conexion) {
    echo json_encode(['error' => 'Error en la conexión con la base de datos']);
    exit;
}

// Inicializar el modelo Contenido
$modeloContenido = new Contenido($conexion);

// Verificar el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener un solo contenido por ID
            $id = intval($_GET['id']);
            $contenido = $modeloContenido->obtenerPorId($id);
            echo json_encode($contenido);
        } else {
            // Obtener todos los contenidos
            $contenidos = $modeloContenido->obtenerTodos();
            echo json_encode($contenidos);
        }
        break;

    case 'POST':
        // Crear un nuevo contenido
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $titulo = $data['titulo'];
            $descripcion = $data['descripcion'];
            $tipo = $data['tipo'];
            $horario = $data['horario'];
            $imagen = $data['imagen']; // Supongamos que pasas la URL de la imagen en JSON

            $modeloContenido->crear($titulo, $descripcion, $tipo, $horario, $imagen);
            echo json_encode(['message' => 'Contenido creado con éxito']);
        } else {
            echo json_encode(['error' => 'Datos no válidos']);
        }
        break;

    case 'PUT':
        // Actualizar contenido existente
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $data = json_decode(file_get_contents("php://input"), true);
            if ($data) {
                $titulo = $data['titulo'];
                $descripcion = $data['descripcion'];
                $tipo = $data['tipo'];
                $horario = $data['horario'];
                $imagen = $data['imagen']; // URL de la imagen

                $modeloContenido->editar($id, $titulo, $descripcion, $tipo, $horario, $imagen);
                echo json_encode(['message' => 'Contenido actualizado con éxito']);
            } else {
                echo json_encode(['error' => 'Datos no válidos']);
            }
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;

    case 'DELETE':
        // Eliminar un contenido
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $modeloContenido->eliminar($id);
            echo json_encode(['message' => 'Contenido eliminado con éxito']);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
