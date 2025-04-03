<?php
class Roles extends Controlador {
    
  
    private $rolModelo;
    private $usuarioModelo;
    
    public function __construct() {
        $this->rolModelo = $this->modelo('Rol');
        $this->usuarioModelo = $this->modelo('Usuario');
    }

   
    public function index() {
        $roles = $this->rolModelo->obtenerRoles();
        
       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($roles);
    }

    
    public function activos() {
        $roles = $this->rolModelo->obtenerRolesActivos();
        
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($roles);
    }

   
    public function ver($id = null) {
        
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de rol no proporcionado']);
            return;
        }

        $rol = $this->rolModelo->obtenerRolPorId($id);

       
        if(!$rol) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Rol no encontrado']);
            return;
        }

       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($rol);
    }

    
    public function crear() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

       
        $datos = json_decode(file_get_contents('php://input'), true);

       
        if(!isset($datos['nombre_rol']) || !isset($datos['descripcion'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        
        if($this->rolModelo->agregarRol($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Rol creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el rol']);
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
            echo json_encode(['error' => 'ID de rol no proporcionado']);
            return;
        }

       
        $rol = $this->rolModelo->obtenerRolPorId($id);
        if(!$rol) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Rol no encontrado']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        
        if($this->rolModelo->actualizarRol($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Rol actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el rol']);
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
            echo json_encode(['error' => 'ID de rol no proporcionado']);
            return;
        }

        
        $rol = $this->rolModelo->obtenerRolPorId($id);
        if(!$rol) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Rol no encontrado']);
            return;
        }

       
        if($this->rolModelo->eliminarRol($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Rol eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el rol. Es posible que esté siendo utilizado por usuarios.']);
        }
    }

    
    public function usuarios($id = null) {
        
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de rol no proporcionado']);
            return;
        }

        
        $rol = $this->rolModelo->obtenerRolPorId($id);
        if(!$rol) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Rol no encontrado']);
            return;
        }

       
        $db = new BaseConexion;
        $db->query('SELECT * FROM usuarios WHERE rol = :rol_id');
        $db->bind(':rol_id', $id);
        $usuarios = $db->registros();

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($usuarios);
    }
} 