<?php
class Permisos extends Controlador {
    
    private $permisoModelo;
    
    public function __construct() {
        $this->permisoModelo = $this->modelo('Permiso');
    }

    public function index() {
        $permisos = $this->permisoModelo->obtenerPermisos();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($permisos);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de permiso no proporcionado']);
            return;
        }

        $permiso = $this->permisoModelo->obtenerPermisoPorId($id);

        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permiso);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['nombre']) || !isset($datos['tipo_permiso']) || !isset($datos['codigo_nombre'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        // Verificar si ya existe un permiso con el mismo código
        $permisoExistente = $this->permisoModelo->obtenerPermisoPorCodigo($datos['codigo_nombre']);
        if($permisoExistente) {
            header('HTTP/1.0 409 Conflict');
            echo json_encode(['error' => 'Ya existe un permiso con ese código']);
            return;
        }

        if($this->permisoModelo->agregarPermiso($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Permiso creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el permiso']);
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
            echo json_encode(['error' => 'ID de permiso no proporcionado']);
            return;
        }

        $permiso = $this->permisoModelo->obtenerPermisoPorId($id);
        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre']) || !isset($datos['tipo_permiso']) || !isset($datos['codigo_nombre'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        // Verificar si ya existe otro permiso con el mismo código
        $permisoExistente = $this->permisoModelo->obtenerPermisoPorCodigo($datos['codigo_nombre']);
        if($permisoExistente && $permisoExistente->id != $id) {
            header('HTTP/1.0 409 Conflict');
            echo json_encode(['error' => 'Ya existe otro permiso con ese código']);
            return;
        }

        if($this->permisoModelo->actualizarPermiso($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Permiso actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el permiso']);
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
            echo json_encode(['error' => 'ID de permiso no proporcionado']);
            return;
        }

        $permiso = $this->permisoModelo->obtenerPermisoPorId($id);
        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        if($this->permisoModelo->eliminarPermiso($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Permiso eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el permiso. Es posible que esté siendo utilizado.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $permisos = $this->permisoModelo->buscarPermisosPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permisos);
    }

    public function porTipo($tipo_permiso = null) {
        if(!$tipo_permiso) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de permiso no proporcionado']);
            return;
        }

        $permisos = $this->permisoModelo->obtenerPermisosPorTipo($tipo_permiso);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permisos);
    }

    public function porCodigo($codigo_nombre = null) {
        if(!$codigo_nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Código de permiso no proporcionado']);
            return;
        }

        $permiso = $this->permisoModelo->obtenerPermisoPorCodigo($codigo_nombre);

        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permiso);
    }
} 