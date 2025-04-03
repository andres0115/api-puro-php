<?php
class Permisos_Usuarios extends Controlador {
    
    private $permisoUsuarioModelo;
    private $usuarioModelo;
    private $permisoModelo;
    
    public function __construct() {
        $this->permisoUsuarioModelo = $this->modelo('PermisoUsuario');
        $this->usuarioModelo = $this->modelo('Usuario');
        $this->permisoModelo = $this->modelo('Permiso');
    }

    public function index() {
        $permisosUsuarios = $this->permisoUsuarioModelo->obtenerPermisosUsuarios();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($permisosUsuarios);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de asignación no proporcionado']);
            return;
        }

        $permisoUsuario = $this->permisoUsuarioModelo->obtenerPermisoUsuarioPorId($id);

        if(!$permisoUsuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Asignación no encontrada']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permisoUsuario);
    }

    public function porUsuario($usuario_id = null) {
        if(!$usuario_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($usuario_id);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        $permisos = $this->permisoUsuarioModelo->obtenerPermisosPorUsuario($usuario_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($permisos);
    }

    public function porPermiso($permiso_id = null) {
        if(!$permiso_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de permiso no proporcionado']);
            return;
        }

        $permiso = $this->permisoModelo->obtenerPermisoPorId($permiso_id);
        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        $usuarios = $this->permisoUsuarioModelo->obtenerUsuariosPorPermiso($permiso_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($usuarios);
    }

    public function asignar() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['usuario_id']) || !isset($datos['permiso_id'])) {
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

        $permiso = $this->permisoModelo->obtenerPermisoPorId($datos['permiso_id']);
        if(!$permiso) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Permiso no encontrado']);
            return;
        }

        // Verificar si ya existe la asignación
        if($this->permisoUsuarioModelo->verificarPermisoUsuario($datos['usuario_id'], $datos['permiso_id'])) {
            header('HTTP/1.0 409 Conflict');
            echo json_encode(['error' => 'El usuario ya tiene asignado este permiso']);
            return;
        }

        if($this->permisoUsuarioModelo->agregarPermisoUsuario($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Permiso asignado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al asignar el permiso']);
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
            echo json_encode(['error' => 'ID de asignación no proporcionado']);
            return;
        }

        $permisoUsuario = $this->permisoUsuarioModelo->obtenerPermisoUsuarioPorId($id);
        if(!$permisoUsuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Asignación no encontrada']);
            return;
        }

        if($this->permisoUsuarioModelo->eliminarPermisoUsuario($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Asignación eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar la asignación']);
        }
    }

    public function asignarMultiples() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['usuario_id']) || !isset($datos['permisos_ids']) || !is_array($datos['permisos_ids'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos o formato incorrecto']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['usuario_id']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        if($this->permisoUsuarioModelo->asignarPermisosUsuario($datos['usuario_id'], $datos['permisos_ids'])) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Permisos asignados exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al asignar los permisos']);
        }
    }

    public function verificar() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['usuario_id']) || !isset($datos['permiso_id'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $resultado = $this->permisoUsuarioModelo->verificarPermisoUsuario($datos['usuario_id'], $datos['permiso_id']);
        
        header('Content-Type: application/json');
        echo json_encode(['tiene_permiso' => $resultado]);
    }
} 