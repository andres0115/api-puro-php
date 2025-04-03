<?php
class Sede {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerSedes() {
        $this->db->query('SELECT s.*, c.nombre_centro 
                          FROM sedes s 
                          LEFT JOIN centros c ON s.centro_sede_id = c.id 
                          ORDER BY s.nombre_sede ASC');
        return $this->db->registros();
    }

    public function obtenerSedePorId($id) {
        $this->db->query('SELECT s.*, c.nombre_centro 
                          FROM sedes s 
                          LEFT JOIN centros c ON s.centro_sede_id = c.id 
                          WHERE s.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarSede($datos) {
        $this->db->query('INSERT INTO sedes (nombre_sede, direccion_sede, centro_sede_id, fecha_creacion) 
                          VALUES (:nombre_sede, :direccion_sede, :centro_sede_id, NOW())');
        
        $this->db->bind(':nombre_sede', $datos['nombre_sede']);
        $this->db->bind(':direccion_sede', $datos['direccion_sede']);
        $this->db->bind(':centro_sede_id', $datos['centro_sede_id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarSede($datos) {
        $this->db->query('UPDATE sedes SET 
                          nombre_sede = :nombre_sede, 
                          direccion_sede = :direccion_sede, 
                          centro_sede_id = :centro_sede_id, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_sede', $datos['nombre_sede']);
        $this->db->bind(':direccion_sede', $datos['direccion_sede']);
        $this->db->bind(':centro_sede_id', $datos['centro_sede_id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarSede($id) {
        // Verificar si la sede está siendo utilizada en areas_sedes
        $this->db->query('SELECT COUNT(*) as total FROM areas_sedes WHERE sede = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar una sede que está siendo utilizada
        }
        
        // Verificar si la sede está siendo utilizada en materiales
        $this->db->query('SELECT COUNT(*) as total FROM materiales WHERE sitio = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar una sede que está siendo utilizada
        }
        
        $this->db->query('DELETE FROM sedes WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarSedesPorNombre($nombre) {
        $this->db->query('SELECT s.*, c.nombre_centro 
                          FROM sedes s 
                          LEFT JOIN centros c ON s.centro_sede_id = c.id 
                          WHERE s.nombre_sede LIKE :nombre 
                          ORDER BY s.nombre_sede ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }

    public function buscarSedesPorDireccion($direccion) {
        $this->db->query('SELECT s.*, c.nombre_centro 
                          FROM sedes s 
                          LEFT JOIN centros c ON s.centro_sede_id = c.id 
                          WHERE s.direccion_sede LIKE :direccion 
                          ORDER BY s.nombre_sede ASC');
        $this->db->bind(':direccion', '%' . $direccion . '%');
        return $this->db->registros();
    }

    public function obtenerSedesPorCentro($centro_id) {
        $this->db->query('SELECT s.*, c.nombre_centro 
                          FROM sedes s 
                          LEFT JOIN centros c ON s.centro_sede_id = c.id 
                          WHERE s.centro_sede_id = :centro_id 
                          ORDER BY s.nombre_sede ASC');
        $this->db->bind(':centro_id', $centro_id);
        return $this->db->registros();
    }
} 