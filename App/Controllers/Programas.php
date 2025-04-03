<?php
class Programas extends Controlador {
    
    private $programaModelo;
    private $areaModelo;
    
    public function __construct() {
        $this->programaModelo = $this->modelo('Programa');
        $this->areaModelo = $this->modelo('Area');
    }

    public function index() {
        $programas = $this->programaModelo->obtenerProgramas();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($programas);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

        $programa = $this->programaModelo->obtenerProgramaPorId($id);

        if(!$programa) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Programa no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($programa);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre_programa']) || empty($datos['nombre_programa'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de programa no proporcionado']);
            return;
        }

        if(!isset($datos['area']) || empty($datos['area'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Área no proporcionada']);
            return;
        }

        // Verificar si el área existe
        $area = $this->areaModelo->obtenerAreaPorId($datos['area']);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        if($this->programaModelo->agregarPrograma($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Programa creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el programa']);
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
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

        $programa = $this->programaModelo->obtenerProgramaPorId($id);
        if(!$programa) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Programa no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_programa']) || empty($datos['nombre_programa'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de programa no proporcionado']);
            return;
        }

        if(!isset($datos['area']) || empty($datos['area'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Área no proporcionada']);
            return;
        }

        // Verificar si el área existe
        $area = $this->areaModelo->obtenerAreaPorId($datos['area']);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        if($this->programaModelo->actualizarPrograma($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Programa actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el programa']);
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
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

        $programa = $this->programaModelo->obtenerProgramaPorId($id);
        if(!$programa) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Programa no encontrado']);
            return;
        }

        if($this->programaModelo->eliminarPrograma($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Programa eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el programa. Es posible que esté siendo utilizado por fichas.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $programas = $this->programaModelo->buscarProgramasPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($programas);
    }

    public function porArea($area_id = null) {
        if(!$area_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de área no proporcionado']);
            return;
        }

        // Verificar si el área existe
        $area = $this->areaModelo->obtenerAreaPorId($area_id);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        $programas = $this->programaModelo->obtenerProgramasPorArea($area_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($programas);
    }
} 