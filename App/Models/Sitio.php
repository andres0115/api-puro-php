<?php
class Sitio {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerSitios() {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          ORDER BY s.nombre_sitio ASC');
        return $this->db->registros();
    }

    public function obtenerSitioPorId($id) {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          WHERE s.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarSitio($datos) {
        $this->db->query('INSERT INTO sitios (nombre_sitio, ubicacion, ficha_tecnica, 
                          persona_encargada, tipo_sitio, fecha_creacion) 
                          VALUES (:nombre_sitio, :ubicacion, :ficha_tecnica, 
                          :persona_encargada, :tipo_sitio, NOW())');
        
        $this->db->bind(':nombre_sitio', $datos['nombre_sitio']);
        $this->db->bind(':ubicacion', $datos['ubicacion']);
        $this->db->bind(':ficha_tecnica', $datos['ficha_tecnica'] ?? null);
        $this->db->bind(':persona_encargada', $datos['persona_encargada']);
        $this->db->bind(':tipo_sitio', $datos['tipo_sitio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarSitio($datos) {
        $this->db->query('UPDATE sitios SET 
                          nombre_sitio = :nombre_sitio, 
                          ubicacion = :ubicacion, 
                          ficha_tecnica = :ficha_tecnica, 
                          persona_encargada = :persona_encargada, 
                          tipo_sitio = :tipo_sitio, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_sitio', $datos['nombre_sitio']);
        $this->db->bind(':ubicacion', $datos['ubicacion']);
        $this->db->bind(':ficha_tecnica', $datos['ficha_tecnica'] ?? null);
        $this->db->bind(':persona_encargada', $datos['persona_encargada']);
        $this->db->bind(':tipo_sitio', $datos['tipo_sitio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarSitio($id) {
        // Verificar si el sitio está siendo utilizado en materiales
        $this->db->query('SELECT COUNT(*) as total FROM materiales WHERE sitio = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un sitio que está siendo utilizado
        }
        
        $this->db->query('DELETE FROM sitios WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarSitiosPorNombre($nombre) {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          WHERE s.nombre_sitio LIKE :nombre 
                          ORDER BY s.nombre_sitio ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }

    public function buscarSitiosPorUbicacion($ubicacion) {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          WHERE s.ubicacion LIKE :ubicacion 
                          ORDER BY s.nombre_sitio ASC');
        $this->db->bind(':ubicacion', '%' . $ubicacion . '%');
        return $this->db->registros();
    }

    public function obtenerSitiosPorEncargado($encargado_id) {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          WHERE s.persona_encargada = :encargado_id 
                          ORDER BY s.nombre_sitio ASC');
        $this->db->bind(':encargado_id', $encargado_id);
        return $this->db->registros();
    }

    public function obtenerSitiosPorTipo($tipo_sitio) {
        $this->db->query('SELECT s.*, u.nombre as nombre_encargado, u.apellido as apellido_encargado 
                          FROM sitios s 
                          LEFT JOIN usuarios u ON s.persona_encargada = u.id 
                          WHERE s.tipo_sitio = :tipo_sitio 
                          ORDER BY s.nombre_sitio ASC');
        $this->db->bind(':tipo_sitio', $tipo_sitio);
        return $this->db->registros();
    }
} 