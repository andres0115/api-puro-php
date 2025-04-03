<?php
class Sitios extends Controlador {
    
    private $sitioModelo;
    private $usuarioModelo;
    
    public function __construct() {
        $this->sitioModelo = $this->modelo('Sitio');
        $this->usuarioModelo = $this->modelo('Usuario');
    }

    public function index() {
        $sitios = $this->sitioModelo->obtenerSitios();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($sitios);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de sitio no proporcionado']);
            return;
        }

        $sitio = $this->sitioModelo->obtenerSitioPorId($id);

        if(!$sitio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sitio no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sitio);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre_sitio']) || empty($datos['nombre_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de sitio no proporcionado']);
            return;
        }

        if(!isset($datos['ubicacion']) || empty($datos['ubicacion'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Ubicación no proporcionada']);
            return;
        }

        if(!isset($datos['persona_encargada']) || empty($datos['persona_encargada'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Persona encargada no proporcionada']);
            return;
        }

        if(!isset($datos['tipo_sitio']) || empty($datos['tipo_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de sitio no proporcionado']);
            return;
        }

        // Verificar si el usuario encargado existe
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['persona_encargada']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario encargado no encontrado']);
            return;
        }

        if($this->sitioModelo->agregarSitio($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Sitio creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el sitio']);
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
            echo json_encode(['error' => 'ID de sitio no proporcionado']);
            return;
        }

        $sitio = $this->sitioModelo->obtenerSitioPorId($id);
        if(!$sitio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sitio no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_sitio']) || empty($datos['nombre_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de sitio no proporcionado']);
            return;
        }

        if(!isset($datos['ubicacion']) || empty($datos['ubicacion'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Ubicación no proporcionada']);
            return;
        }

        if(!isset($datos['persona_encargada']) || empty($datos['persona_encargada'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Persona encargada no proporcionada']);
            return;
        }

        if(!isset($datos['tipo_sitio']) || empty($datos['tipo_sitio'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de sitio no proporcionado']);
            return;
        }

        // Verificar si el usuario encargado existe
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['persona_encargada']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario encargado no encontrado']);
            return;
        }

        if($this->sitioModelo->actualizarSitio($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Sitio actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el sitio']);
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
            echo json_encode(['error' => 'ID de sitio no proporcionado']);
            return;
        }

        $sitio = $this->sitioModelo->obtenerSitioPorId($id);
        if(!$sitio) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sitio no encontrado']);
            return;
        }

        if($this->sitioModelo->eliminarSitio($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Sitio eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el sitio. Es posible que esté siendo utilizado por materiales.']);
        }
    }

    public function buscarPorNombre($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $sitios = $this->sitioModelo->buscarSitiosPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sitios);
    }

    public function buscarPorUbicacion($ubicacion = null) {
        if(!$ubicacion) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $sitios = $this->sitioModelo->buscarSitiosPorUbicacion($ubicacion);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sitios);
    }

    public function porEncargado($encargado_id = null) {
        if(!$encargado_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de encargado no proporcionado']);
            return;
        }

        // Verificar si el usuario existe
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($encargado_id);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario encargado no encontrado']);
            return;
        }

        $sitios = $this->sitioModelo->obtenerSitiosPorEncargado($encargado_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sitios);
    }

    public function porTipo($tipo_sitio = null) {
        if(!$tipo_sitio) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de sitio no proporcionado']);
            return;
        }

        $sitios = $this->sitioModelo->obtenerSitiosPorTipo($tipo_sitio);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($sitios);
    }
} 