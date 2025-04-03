<?php
class Areas extends Controlador {
    
    // Declarar la propiedad explícitamente
    private $areaModelo;
    
    public function __construct() {
        $this->areaModelo = $this->modelo('Area');
    }

    // Método para obtener todas las áreas (GET)
    public function index() {
        $areas = $this->areaModelo->obtenerAreas();
        
        // Configurar headers para API
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($areas);
    }

    // Método para obtener un área por ID (GET)
    public function ver($id = null) {
        // Validar que se proporcione un ID
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de área no proporcionado']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($id);

        // Verificar si el área existe
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        // Configurar headers para API
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($area);
    }

    // Método para crear una nueva área (POST)
    public function crear() {
        // Verificar que sea una solicitud POST
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        // Obtener datos enviados
        $datos = json_decode(file_get_contents('php://input'), true);

        
        if(!isset($datos['nombre_area']) || empty($datos['nombre_area'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de área no proporcionado']);
            return;
        }

        if($this->areaModelo->agregarArea($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Área creada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el área']);
        }
    }

    public function actualizar($id = null) {

        if($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de área no proporcionado']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($id);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_area']) || empty($datos['nombre_area'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de área no proporcionado']);
            return;
        }

        if($this->areaModelo->actualizarArea($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Área actualizada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el área']);
        }
    }

    public function eliminar($id = null) {

        if($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de área no proporcionado']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($id);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        if($this->areaModelo->eliminarArea($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Área eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el área. Es posible que esté siendo utilizada.']);
        }
    }

    public function buscar($nombre = null) {

        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $areas = $this->areaModelo->buscarAreasPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($areas);
    }
} 