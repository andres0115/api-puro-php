<?php
class Tipos_Permisos extends Controlador {
    
    private $tipoPermisoModelo;
    
    public function __construct() {
        $this->tipoPermisoModelo = $this->modelo('TipoPermiso');
    }

    public function index() {
        $tipos = $this->tipoPermisoModelo->obtenerTiposPermisos();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($tipos);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de tipo de permiso no proporcionado']);
            return;
        }

        $tipo = $this->tipoPermisoModelo->obtenerTipoPermisoPorId($id);

        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de permiso no encontrado']);
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

        if(!isset($datos['permisos']) || empty($datos['permisos'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de permiso no proporcionado']);
            return;
        }

        if($this->tipoPermisoModelo->agregarTipoPermiso($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Tipo de permiso creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el tipo de permiso']);
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
            echo json_encode(['error' => 'ID de tipo de permiso no proporcionado']);
            return;
        }

        $tipo = $this->tipoPermisoModelo->obtenerTipoPermisoPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de permiso no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['permisos']) || empty($datos['permisos'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de permiso no proporcionado']);
            return;
        }

        if($this->tipoPermisoModelo->actualizarTipoPermiso($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de permiso actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el tipo de permiso']);
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
            echo json_encode(['error' => 'ID de tipo de permiso no proporcionado']);
            return;
        }

        $tipo = $this->tipoPermisoModelo->obtenerTipoPermisoPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de permiso no encontrado']);
            return;
        }

        if($this->tipoPermisoModelo->eliminarTipoPermiso($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de permiso eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el tipo de permiso. Es posible que esté siendo utilizado en la tabla permisos.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $tipos = $this->tipoPermisoModelo->buscarTiposPermisosPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($tipos);
    }
} 