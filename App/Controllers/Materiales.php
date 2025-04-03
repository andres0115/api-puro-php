<?php
class Materiales extends Controlador {
    
    private $materialModelo;
    
    public function __construct() {
        $this->materialModelo = $this->modelo('Material');
    }

    public function index() {
        $materiales = $this->materialModelo->obtenerMateriales();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($materiales);
    }

    public function ver($id = null) {
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de material no proporcionado']);
            return;
        }

        $material = $this->materialModelo->obtenerMaterialPorId($id);

        if(!$material) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Material no encontrado']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($material);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['codigo_serial_material']) || !isset($datos['nombre_material']) || 
           !isset($datos['stock']) || !isset($datos['unidad_medida']) || 
           !isset($datos['categoria']) || !isset($datos['tipo_material'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        if($this->materialModelo->agregarMaterial($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Material creado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear el material']);
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
            echo json_encode(['error' => 'ID de material no proporcionado']);
            return;
        }

        $material = $this->materialModelo->obtenerMaterialPorId($id);
        if(!$material) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Material no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['codigo_serial_material']) || !isset($datos['nombre_material']) || 
           !isset($datos['stock']) || !isset($datos['unidad_medida']) || 
           !isset($datos['categoria']) || !isset($datos['tipo_material'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        if($this->materialModelo->actualizarMaterial($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Material actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el material']);
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
            echo json_encode(['error' => 'ID de material no proporcionado']);
            return;
        }

        $material = $this->materialModelo->obtenerMaterialPorId($id);
        if(!$material) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Material no encontrado']);
            return;
        }

        if($this->materialModelo->eliminarMaterial($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Material eliminado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar el material']);
        }
    }

    public function buscarPorNombre($nombre = null) {
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $materiales = $this->materialModelo->buscarMaterialesPorNombre($nombre);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function buscarPorCodigo($codigo = null) {
        if(!$codigo) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Código de material no proporcionado']);
            return;
        }

        $materiales = $this->materialModelo->buscarMaterialesPorCodigo($codigo);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function porCategoria($categoria_id = null) {
        if(!$categoria_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de categoría no proporcionado']);
            return;
        }

        $materiales = $this->materialModelo->obtenerMaterialesPorCategoria($categoria_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function porTipo($tipo_material = null) {
        if(!$tipo_material) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Tipo de material no proporcionado']);
            return;
        }

        $materiales = $this->materialModelo->obtenerMaterialesPorTipo($tipo_material);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function porSitio($sitio_id = null) {
        if(!$sitio_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de sitio no proporcionado']);
            return;
        }

        $materiales = $this->materialModelo->obtenerMaterialesPorSitio($sitio_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function porVencer($dias = 30) {
        $materiales = $this->materialModelo->obtenerMaterialesPorVencer($dias);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($materiales);
    }

    public function actualizarStock($id = null) {
        if($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de material no proporcionado']);
            return;
        }

        $material = $this->materialModelo->obtenerMaterialPorId($id);
        if(!$material) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Material no encontrado']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['cantidad'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Cantidad no proporcionada']);
            return;
        }

        if($this->materialModelo->actualizarStock($id, $datos['cantidad'])) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Stock actualizado exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar el stock']);
        }
    }
} 