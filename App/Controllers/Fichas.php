<?php
class Fichas extends Controlador {
    
    
    private $fichaModelo;
    
    public function __construct() {
        $this->fichaModelo = $this->modelo('Ficha');
    }

  
    public function index() {
        $fichas = $this->fichaModelo->obtenerFichas();
        
       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($fichas);
    }

   
    public function ver($id = null) {
        
        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de ficha no proporcionado']);
            return;
        }

        $ficha = $this->fichaModelo->obtenerFichaPorId($id);

       
        if(!$ficha) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Ficha no encontrada']);
            return;
        }

       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($ficha);
    }
    
    
    public function porNumero($id_ficha = null) {
        
        if(!$id_ficha) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Número de ficha no proporcionado']);
            return;
        }

        $ficha = $this->fichaModelo->obtenerFichaPorNumero($id_ficha);

        
        if(!$ficha) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Ficha no encontrada']);
            return;
        }

       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($ficha);
    }

   
    public function crear() {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

       
        $datos = json_decode(file_get_contents('php://input'), true);

        
        if(!isset($datos['id_ficha']) || empty($datos['id_ficha'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Número de ficha no proporcionado']);
            return;
        }
        
        if(!isset($datos['usuario_ficha']) || empty($datos['usuario_ficha'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }
        
        if(!isset($datos['programa']) || empty($datos['programa'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

       
        if($this->fichaModelo->agregarFicha($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Ficha creada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear la ficha']);
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
            echo json_encode(['error' => 'ID de ficha no proporcionado']);
            return;
        }

        
        $ficha = $this->fichaModelo->obtenerFichaPorId($id);
        if(!$ficha) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Ficha no encontrada']);
            return;
        }

        
        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        
        if(!isset($datos['id_ficha']) || empty($datos['id_ficha'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Número de ficha no proporcionado']);
            return;
        }
        
        if(!isset($datos['usuario_ficha']) || empty($datos['usuario_ficha'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }
        
        if(!isset($datos['programa']) || empty($datos['programa'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

        
        if($this->fichaModelo->actualizarFicha($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Ficha actualizada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar la ficha']);
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
            echo json_encode(['error' => 'ID de ficha no proporcionado']);
            return;
        }

        
        $ficha = $this->fichaModelo->obtenerFichaPorId($id);
        if(!$ficha) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Ficha no encontrada']);
            return;
        }

        
        if($this->fichaModelo->eliminarFicha($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Ficha eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar la ficha. Es posible que esté siendo utilizada.']);
        }
    }

   
    public function buscar($numero = null) {
        
        if(!$numero) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Término de búsqueda no proporcionado']);
            return;
        }

        $fichas = $this->fichaModelo->buscarFichasPorNumero($numero);

       
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($fichas);
    }
    
    
    public function porPrograma($programa_id = null) {
        
        if(!$programa_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de programa no proporcionado']);
            return;
        }

        $fichas = $this->fichaModelo->obtenerFichasPorPrograma($programa_id);

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($fichas);
    }
    
   
    public function porUsuario($usuario_id = null) {
        
        if(!$usuario_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de usuario no proporcionado']);
            return;
        }

        $fichas = $this->fichaModelo->obtenerFichasPorUsuario($usuario_id);

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($fichas);
    }
}
