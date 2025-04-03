<?php
class Centro {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerCentros() {
        $this->db->query('SELECT c.*, m.nombre_municipio 
                         FROM centros c
                         LEFT JOIN municipios m ON c.municipio_id = m.id
                         ORDER BY c.nombre_centro ASC');
        return $this->db->registros();
    }

    
    public function obtenerCentroPorId($id) {
        $this->db->query('SELECT c.*, m.nombre_municipio 
                         FROM centros c
                         LEFT JOIN municipios m ON c.municipio_id = m.id
                         WHERE c.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function agregarCentro($datos) {
        $this->db->query('INSERT INTO centros (nombre_centro, municipio_id, fecha_creacion) 
                          VALUES (:nombre_centro, :municipio_id, NOW())');
        
        
        $this->db->bind(':nombre_centro', $datos['nombre_centro']);
        $this->db->bind(':municipio_id', $datos['municipio_id']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarCentro($datos) {
        $this->db->query('UPDATE centros SET 
                          nombre_centro = :nombre_centro, 
                          municipio_id = :municipio_id,
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_centro', $datos['nombre_centro']);
        $this->db->bind(':municipio_id', $datos['municipio_id']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarCentro($id) {
        
        
        $this->db->query('SELECT COUNT(*) as total FROM areas_sedes WHERE centro_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; 
        }
        
        $this->db->query('DELETE FROM centros WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function buscarCentrosPorNombre($nombre) {
        $this->db->query('SELECT c.*, m.nombre_municipio 
                         FROM centros c
                         LEFT JOIN municipios m ON c.municipio_id = m.id
                         WHERE c.nombre_centro LIKE :nombre 
                         ORDER BY c.nombre_centro ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
    
    
    public function obtenerCentrosPorMunicipio($municipio_id) {
        $this->db->query('SELECT c.*, m.nombre_municipio 
                         FROM centros c
                         LEFT JOIN municipios m ON c.municipio_id = m.id
                         WHERE c.municipio_id = :municipio_id
                         ORDER BY c.nombre_centro ASC');
        $this->db->bind(':municipio_id', $municipio_id);
        return $this->db->registros();
    }
}
