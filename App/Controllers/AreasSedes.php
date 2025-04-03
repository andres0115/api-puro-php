<?php
class AreasSedes extends Controlador {
    
    private $areaSedeModelo;
    private $areaModelo;
    private $usuarioModelo;
    private $sedeModelo;
    
    public function __construct() {
        $this->areaSedeModelo = $this->modelo('AreaSede');
        $this->areaModelo = $this->modelo('Area');
        $this->usuarioModelo = $this->modelo('Usuario');
        $this->sedeModelo = $this->modelo('Sede');
    }

    public function index() {
        $areasSedes = $this->areaSedeModelo->obtenerAreasSedes();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode($areasSedes);
    }

    public function ver($id = null) {

        if(!$id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de asignación no proporcionado']);
            return;
        }

        $areaSede = $this->areaSedeModelo->obtenerAreaSedePorId($id);

        if(!$areaSede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Asignación no encontrada']);
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($areaSede);
    }

    public function crear() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if(!isset($datos['area']) || !isset($datos['persona_administrativa']) || !isset($datos['sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($datos['area']);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        $persona = $this->usuarioModelo->obtenerUsuarioPorId($datos['persona_administrativa']);
        if(!$persona) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Persona administrativa no encontrada']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($datos['sede']);
        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        if($this->areaSedeModelo->agregarAreaSede($datos)) {
            header('HTTP/1.0 201 Created');
            echo json_encode(['mensaje' => 'Asignación creada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al crear la asignación']);
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
            echo json_encode(['error' => 'ID de asignación no proporcionado']);
            return;
        }

        $areaSede = $this->areaSedeModelo->obtenerAreaSedePorId($id);
        if(!$areaSede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Asignación no encontrada']);
            return;
        }

        $datos = json_decode(file_get_contents('php://input'), true);
        $datos['id'] = $id;

        if(!isset($datos['area']) || !isset($datos['persona_administrativa']) || !isset($datos['sede'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'Faltan datos requeridos']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($datos['area']);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        $persona = $this->usuarioModelo->obtenerUsuarioPorId($datos['persona_administrativa']);
        if(!$persona) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Persona administrativa no encontrada']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($datos['sede']);
        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        if($this->areaSedeModelo->actualizarAreaSede($datos)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Asignación actualizada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al actualizar la asignación']);
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

        $areaSede = $this->areaSedeModelo->obtenerAreaSedePorId($id);
        if(!$areaSede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Asignación no encontrada']);
            return;
        }

        if($this->areaSedeModelo->eliminarAreaSede($id)) {
            header('Content-Type: application/json');
            echo json_encode(['mensaje' => 'Asignación eliminada exitosamente']);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['error' => 'Error al eliminar la asignación']);
        }
    }

    public function porArea($area_id = null) {

        if(!$area_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de área no proporcionado']);
            return;
        }

        $area = $this->areaModelo->obtenerAreaPorId($area_id);
        if(!$area) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Área no encontrada']);
            return;
        }

        $areasSedes = $this->areaSedeModelo->obtenerAreaSedesPorArea($area_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($areasSedes);
    }

    public function porSede($sede_id = null) {

        if(!$sede_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de sede no proporcionado']);
            return;
        }

        $sede = $this->sedeModelo->obtenerSedePorId($sede_id);
        if(!$sede) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Sede no encontrada']);
            return;
        }

        $areasSedes = $this->areaSedeModelo->obtenerAreaSedesPorSede($sede_id);

      
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($areasSedes);
    }

    public function porPersona($persona_id = null) {
    
        if(!$persona_id) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['error' => 'ID de persona no proporcionado']);
            return;
        }

        $persona = $this->usuarioModelo->obtenerUsuarioPorId($persona_id);
        if(!$persona) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Persona no encontrada']);
            return;
        }

        $areasSedes = $this->areaSedeModelo->obtenerAreaSedesPorPersona($persona_id);

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        echo json_encode($areasSedes);
    }
} 