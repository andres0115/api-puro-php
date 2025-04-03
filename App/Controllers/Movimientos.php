<?php
class Movimientos extends Controlador {
    
    private $movimientoModelo;
    private $usuarioModelo;
    
    public function __construct() {
        $this->movimientoModelo = $this->modelo('Movimiento');
        $this->usuarioModelo = $this->modelo('Usuario');
    }

    public function index() {
        $movimientos = $this->movimientoModelo->obtenerMovimientos();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($movimientos);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de movimiento no proporcionado']);
            return;
        }

        $movimiento = $this->movimientoModelo->obtenerMovimientoPorId($id);

        if(!$movimiento) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Movimiento no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($movimiento);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['usuario_movimiento']) || !isset($datos['tipo_movimiento'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['usuario_movimiento']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        if($this->movimientoModelo->agregarMovimiento($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Movimiento registrado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al registrar el movimiento']);
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
            echo json_encode(['error' => 'ID de movimiento no proporcionado']);
            return;
        }

        $movimiento = $this->movimientoModelo->obtenerMovimientoPorId($id);
        if(!$movimiento) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Movimiento no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['usuario_movimiento']) || !isset($datos['tipo_movimiento'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($datos['usuario_movimiento']);
        if(!$usuario) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        if($this->movimientoModelo->actualizarMovimiento($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Movimiento actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el movimiento']);
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
            echo json_encode(['error' => 'ID de movimiento no proporcionado']);
            return;
        }

        $movimiento = $this->movimientoModelo->obtenerMovimientoPorId($id);
        if(!$movimiento) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Movimiento no encontrado']);
            return;
        }

        if($this->movimientoModelo->eliminarMovimiento($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Movimiento eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el movimiento']);
        }
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

        $movimientos = $this->movimientoModelo->obtenerMovimientosPorUsuario($usuario_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($movimientos);
    }

    public function porTipo($tipo_movimiento = null) {
        if(!$tipo_movimiento) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de movimiento no proporcionado']);
            return;
        }

        $movimientos = $this->movimientoModelo->obtenerMovimientosPorTipo($tipo_movimiento);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($movimientos);
    }

    public function porFecha() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['fecha_inicio']) || !isset($datos['fecha_fin'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Fechas no proporcionadas']);
            return;
        }

        $movimientos = $this->movimientoModelo->obtenerMovimientosPorFecha($datos['fecha_inicio'], $datos['fecha_fin']);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($movimientos);
    }
} 