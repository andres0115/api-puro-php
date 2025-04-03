<?php
class CategoriasElementos extends Controlador {
    
    private $categoriaElementoModelo;
    
    public function __construct() {
        $this->categoriaElementoModelo = $this->modelo('CategoriaElemento');
    }

    public function index() {
        $categorias = $this->categoriaElementoModelo->obtenerCategoriasElementos();
        
      
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($categorias);
    }

   
    public function ver($id = null) {
      
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de categoría no proporcionado']);
            return;
        }

        $categoria = $this->categoriaElementoModelo->obtenerCategoriaElementoPorId($id);

        
        if(!$categoria) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Categoría no encontrada']);
            return;
        }

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($categoria);
    }

    
    public function crear() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);

       
        if(!isset($datos['nombre_categoria']) || empty($datos['nombre_categoria'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de categoría no proporcionado']);
            return;
        }

        
        if($this->categoriaElementoModelo->agregarCategoriaElemento($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Categoría creada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear la categoría']);
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
            echo json_encode(['error' => 'ID de categoría no proporcionado']);
            return;
        }

        
        $categoria = $this->categoriaElementoModelo->obtenerCategoriaElementoPorId($id);
        if(!$categoria) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Categoría no encontrada']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        
        if(!isset($datos['nombre_categoria']) || empty($datos['nombre_categoria'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Nombre de categoría no proporcionado']);
            return;
        }

        
        if($this->categoriaElementoModelo->actualizarCategoriaElemento($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Categoría actualizada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar la categoría']);
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
            echo json_encode(['error' => 'ID de categoría no proporcionado']);
            return;
        }

        
        $categoria = $this->categoriaElementoModelo->obtenerCategoriaElementoPorId($id);
        if(!$categoria) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Categoría no encontrada']);
            return;
        }

        
        if($this->categoriaElementoModelo->eliminarCategoriaElemento($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Categoría eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar la categoría. Es posible que esté siendo utilizada.']);
        }
    }

   
    public function buscar($nombre = null) {
        
        if(!$nombre) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $categorias = $this->categoriaElementoModelo->buscarCategoriasElementosPorNombre($nombre);

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($categorias);
    }
}
