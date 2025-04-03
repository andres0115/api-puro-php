<?php
class Tipos_Sitio extends Controlador {
    
    private $tipoSitioModelo;
    
    public function __construct() {
        $this->tipoSitioModelo = $this->modelo('TipoSitio');
    }

    public function index() {
        $tipos = $this->tipoSitioModelo->obtenerTiposSitio();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($tipos);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de tipo de sitio no proporcionado']);
            return;
        }

        $tipo = $this->tipoSitioModelo->obtenerTipoSitioPorId($id);

        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de sitio no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($tipo);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre_tipo_sitio']) || empty($datos['nombre_tipo_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de tipo de sitio no proporcionado']);
            return;
        }

        if($this->tipoSitioModelo->agregarTipoSitio($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Tipo de sitio creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el tipo de sitio']);
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
            echo json_encode(['error' => 'ID de tipo de sitio no proporcionado']);
            return;
        }

        $tipo = $this->tipoSitioModelo->obtenerTipoSitioPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de sitio no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_tipo_sitio']) || empty($datos['nombre_tipo_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de tipo de sitio no proporcionado']);
            return;
        }

        if($this->tipoSitioModelo->actualizarTipoSitio($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de sitio actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el tipo de sitio']);
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
            echo json_encode(['error' => 'ID de tipo de sitio no proporcionado']);
            return;
        }

        $tipo = $this->tipoSitioModelo->obtenerTipoSitioPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de sitio no encontrado']);
            return;
        }

        if($this->tipoSitioModelo->eliminarTipoSitio($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de sitio eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el tipo de sitio. Es posible que esté siendo utilizado en la tabla sitios.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $tipos = $this->tipoSitioModelo->buscarTiposSitioPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($tipos);
    }
} 