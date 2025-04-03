<?php
class Administradores extends Controlador {
    
    private $administradorModelo;
    private $usuarioModelo;
    
    public function __construct() {
        $this->administradorModelo = $this->modelo('Administrador');
        $this->usuarioModelo = $this->modelo('Usuario');
    }

    public function index() {
        $registros = $this->administradorModelo->obtenerRegistros();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($registros);
    }

    public function ver($id = null) {
        // Validar que se proporcione un ID
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de registro no proporcionado']);
            return;
        }

        $registro = $this->administradorModelo->obtenerRegistroPorId($id);

        // Verificar si el registro existe
        if(!$registro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Registro no encontrado']);
            return;
        }

        // Configurar headers para API
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($registro);
    }

    // Método para obtener registros por usuario (GET)
    public function porUsuario($usuario_id = null) {
        // Validar que se proporcione un ID de usuario
        if(!$usuario_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

        // Verificar si el usuario existe
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($usuario_id);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        $registros = $this->administradorModelo->obtenerRegistrosPorUsuario($usuario_id);

        // Configurar headers para API
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($registros);
    }

    // Método para registrar una nueva acción (POST)
    public function registrar() {
        // Verificar que sea una solicitud POST
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['rutas']) || !isset($datos['descripcion_ruta']) || 
           !isset($datos['usuario_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['usuario_id']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        if(!isset($datos['bandera_accion'])) {
            $datos['bandera_accion'] = 0;
        }
        if(!isset($datos['mensaje_cambio'])) {
            $datos['mensaje_cambio'] = '';
        }
        if(!isset($datos['tipo_permiso'])) {
            $datos['tipo_permiso'] = 'general';
        }

        if($this->administradorModelo->registrarAccion($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Acción registrada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al registrar la acción']);
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
            echo json_encode(['error' => 'ID de registro no proporcionado']);
            return;
        }

        $registro = $this->administradorModelo->obtenerRegistroPorId($id);
        if(!$registro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Registro no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['rutas']) || !isset($datos['descripcion_ruta'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        if($this->administradorModelo->actualizarRegistro($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Registro actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el registro']);
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
            echo json_encode(['error' => 'ID de registro no proporcionado']);
            return;
        }

        $registro = $this->administradorModelo->obtenerRegistroPorId($id);
        if(!$registro) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Registro no encontrado']);
            return;
        }

        if($this->administradorModelo->eliminarRegistro($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Registro eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el registro']);
        }
    }

    public function porTipoPermiso($tipo_permiso = null) {

        if(!$tipo_permiso) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de permiso no proporcionado']);
            return;
        }

        $registros = $this->administradorModelo->obtenerRegistrosPorTipoPermiso($tipo_permiso);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($registros);
    }

    public function porBandera($bandera_accion = null) {

        if($bandera_accion === null) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Bandera de acción no proporcionada']);
            return;
        }

        $registros = $this->administradorModelo->obtenerRegistrosPorBandera($bandera_accion);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($registros);
    }
} 