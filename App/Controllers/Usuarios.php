<?php
class Usuarios extends Controlador {
    
   
    private $usuarioModelo;
    
    public function __construct() {
        $this->usuarioModelo = $this->modelo('Usuario');
    }

    
    public function index() {
        $usuarios = $this->usuarioModelo->obtenerUsuarios();
        
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($usuarios);
    }

    
    public function ver($id = null) {
        
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id);

        
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($usuario);
    }

    
    public function crear() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

      
        $datos = json_decode(file_get_contents('php://input'), true);

       
        if(!isset($datos['nombre_usuario']) || !isset($datos['contrasena']) || !isset($datos['email'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        
        if($this->usuarioModelo->agregarUsuario($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Usuario creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el usuario']);
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
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

       
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

      
        if($this->usuarioModelo->actualizarUsuario($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Usuario actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el usuario']);
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
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

      
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

       
        if($this->usuarioModelo->eliminarUsuario($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Usuario eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el usuario']);
        }
    }

   
    public function login() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

      
        $datos = json_decode(file_get_contents('php://input'), true);

        
        if(!isset($datos['nombre_usuario']) || !isset($datos['contrasena'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

       
        $usuario = $this->usuarioModelo->login($datos['nombre_usuario'], $datos['contrasena']);

        if($usuario) {
            
            unset($usuario->contrasena);
            
            header('Content-Type: application/json');
            echo json_encode([
                'mensaje' => 'Login exitoso',
                'usuario' => $usuario
            ]);
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Credenciales incorrectas']);
        }
    }
} 