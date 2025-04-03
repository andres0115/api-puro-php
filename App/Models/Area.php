<?php
class Area {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerAreas() {
        $this->db->query('SELECT * FROM areas ORDER BY nombre_area ASC');
        return $this->db->registros();
    }

    
    public function obtenerAreaPorId($id) {
        $this->db->query('SELECT * FROM areas WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function agregarArea($datos) {
        $this->db->query('INSERT INTO areas (nombre_area, fecha_creacion) 
                          VALUES (:nombre_area, NOW())');
        
        
        $this->db->bind(':nombre_area', $datos['nombre_area']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarArea($datos) {
        $this->db->query('UPDATE areas SET 
                          nombre_area = :nombre_area, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_area', $datos['nombre_area']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarArea($id) {
        
        
        $this->db->query('SELECT COUNT(*) as total FROM usuarios WHERE area_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; 
        }
        
        $this->db->query('DELETE FROM areas WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function buscarAreasPorNombre($nombre) {
        $this->db->query('SELECT * FROM areas WHERE nombre_area LIKE :nombre ORDER BY nombre_area ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 