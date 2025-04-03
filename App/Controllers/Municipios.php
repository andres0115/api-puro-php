<?php
class Municipios extends Controlador {
    
    private $municipioModelo;
    
    public function __construct() {
        $this->municipioModelo = $this->modelo('Municipio');
    }

    public function index() {
        $municipios = $this->municipioModelo->obtenerMunicipios();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($municipios);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        $municipio = $this->municipioModelo->obtenerMunicipioPorId($id);

        if(!$municipio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Municipio no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($municipio);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre_municipio']) || empty($datos['nombre_municipio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de municipio no proporcionado']);
            return;
        }

        if($this->municipioModelo->agregarMunicipio($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Municipio creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el municipio']);
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
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        $municipio = $this->municipioModelo->obtenerMunicipioPorId($id);
        if(!$municipio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Municipio no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_municipio']) || empty($datos['nombre_municipio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de municipio no proporcionado']);
            return;
        }

        if($this->municipioModelo->actualizarMunicipio($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Municipio actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el municipio']);
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
            echo json_encode(['error' => 'ID de municipio no proporcionado']);
            return;
        }

        $municipio = $this->municipioModelo->obtenerMunicipioPorId($id);
        if(!$municipio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Municipio no encontrado']);
            return;
        }

        if($this->municipioModelo->eliminarMunicipio($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Municipio eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el municipio. Es posible que esté siendo utilizado por centros.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $municipios = $this->municipioModelo->buscarMunicipiosPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($municipios);
    }
} 