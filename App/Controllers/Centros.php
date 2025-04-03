<?php
class Centros extends Controlador {
    
    private $centroModelo;
    
    public function __construct() {
        $this->centroModelo = $this->modelo('Centro');
    }

    public function index() {
        $centros = $this->centroModelo->obtenerCentros();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($centros);
    }

    public function ver($id = null) {
        
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de centro no proporcionado']);
            return;
        }

        $centro = $this->centroModelo->obtenerCentroPorId($id);

       
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($centro);
    }

    
    public function crear() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);

        
        if(!isset($datos['nombre_centro']) || empty($datos['nombre_centro'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de centro no proporcionado']);
            return;
        }
        
        if(!isset($datos['municipio_id']) || empty($datos['municipio_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        
        if($this->centroModelo->agregarCentro($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Centro creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el centro']);
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
            echo json_encode(['error' => 'ID de centro no proporcionado']);
            return;
        }

        
        $centro = $this->centroModelo->obtenerCentroPorId($id);
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        
        if(!isset($datos['nombre_centro']) || empty($datos['nombre_centro'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de centro no proporcionado']);
            return;
        }
        
        if(!isset($datos['municipio_id']) || empty($datos['municipio_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        
        if($this->centroModelo->actualizarCentro($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Centro actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el centro']);
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
            echo json_encode(['error' => 'ID de centro no proporcionado']);
            return;
        }

        
        $centro = $this->centroModelo->obtenerCentroPorId($id);
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        
        if($this->centroModelo->eliminarCentro($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Centro eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el centro. Es posible que esté siendo utilizado.']);
        }
    }

    
    public function buscar($nombre = null) {
        
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $centros = $this->centroModelo->buscarCentrosPorNombre($nombre);

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($centros);
    }
    
    
    public function porMunicipio($municipio_id = null) {
        
        if(!$municipio_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        $centros = $this->centroModelo->obtenerCentrosPorMunicipio($municipio_id);

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($centros);
    }
}
