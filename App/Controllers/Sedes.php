<?php
class Sedes extends Controlador {
    
    private $sedeModelo;
    private $centroModelo;
    
    public function __construct() {
        $this->sedeModelo = $this->modelo('Sede');
        $this->centroModelo = $this->modelo('Centro');
    }

    public function index() {
        $sedes = $this->sedeModelo->obtenerSedes();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($sedes);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de sede no proporcionado']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($id);

        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sede);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre_sede']) || empty($datos['nombre_sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de sede no proporcionado']);
            return;
        }

        if(!isset($datos['direccion_sede']) || empty($datos['direccion_sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Dirección de sede no proporcionada']);
            return;
        }

        if(!isset($datos['centro_sede_id']) || empty($datos['centro_sede_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Centro de sede no proporcionado']);
            return;
        }

        // Verificar si el centro existe
        $centro = $this->centroModelo->obtenerCentroPorId($datos['centro_sede_id']);
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        if($this->sedeModelo->agregarSede($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Sede creada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear la sede']);
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
            echo json_encode(['error' => 'ID de sede no proporcionado']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($id);
        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_sede']) || empty($datos['nombre_sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de sede no proporcionado']);
            return;
        }

        if(!isset($datos['direccion_sede']) || empty($datos['direccion_sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Dirección de sede no proporcionada']);
            return;
        }

        if(!isset($datos['centro_sede_id']) || empty($datos['centro_sede_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Centro de sede no proporcionado']);
            return;
        }

        // Verificar si el centro existe
        $centro = $this->centroModelo->obtenerCentroPorId($datos['centro_sede_id']);
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        if($this->sedeModelo->actualizarSede($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Sede actualizada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar la sede']);
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
            echo json_encode(['error' => 'ID de sede no proporcionado']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($id);
        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        if($this->sedeModelo->eliminarSede($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Sede eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar la sede. Es posible que esté siendo utilizada.']);
        }
    }

    public function buscarPorNombre($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $sedes = $this->sedeModelo->buscarSedesPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sedes);
    }

    public function buscarPorDireccion($direccion = null) {
        if(!$direccion) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $sedes = $this->sedeModelo->buscarSedesPorDireccion($direccion);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sedes);
    }

    public function porCentro($centro_id = null) {
        if(!$centro_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de centro no proporcionado']);
            return;
        }

        // Verificar si el centro existe
        $centro = $this->centroModelo->obtenerCentroPorId($centro_id);
        if(!$centro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Centro no encontrado']);
            return;
        }

        $sedes = $this->sedeModelo->obtenerSedesPorCentro($centro_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sedes);
    }
} 