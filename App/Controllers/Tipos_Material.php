<?php
class Tipos_Material extends Controlador {
    
    private $tipoMaterialModelo;
    
    public function __construct() {
        $this->tipoMaterialModelo = $this->modelo('TipoMaterial');
    }

    public function index() {
        $tipos = $this->tipoMaterialModelo->obtenerTiposMaterial();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($tipos);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de tipo de material no proporcionado']);
            return;
        }

        $tipo = $this->tipoMaterialModelo->obtenerTipoMaterialPorId($id);

        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de material no encontrado']);
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

        if(!isset($datos['nombre_tipo_material']) || empty($datos['nombre_tipo_material'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de tipo de material no proporcionado']);
            return;
        }

        if($this->tipoMaterialModelo->agregarTipoMaterial($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Tipo de material creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el tipo de material']);
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
            echo json_encode(['error' => 'ID de tipo de material no proporcionado']);
            return;
        }

        $tipo = $this->tipoMaterialModelo->obtenerTipoMaterialPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de material no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['nombre_tipo_material']) || empty($datos['nombre_tipo_material'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de tipo de material no proporcionado']);
            return;
        }

        if($this->tipoMaterialModelo->actualizarTipoMaterial($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de material actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el tipo de material']);
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
            echo json_encode(['error' => 'ID de tipo de material no proporcionado']);
            return;
        }

        $tipo = $this->tipoMaterialModelo->obtenerTipoMaterialPorId($id);
        if(!$tipo) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tipo de material no encontrado']);
            return;
        }

        if($this->tipoMaterialModelo->eliminarTipoMaterial($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Tipo de material eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el tipo de material. Es posible que esté siendo utilizado en la tabla materiales.']);
        }
    }

    public function buscar($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $tipos = $this->tipoMaterialModelo->buscarTiposMaterialPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($tipos);
    }
} 