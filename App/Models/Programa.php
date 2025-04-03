<?php
class Programa {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerProgramas() {
        $this->db->query('SELECT p.*, a.nombre_area 
                          FROM programas p 
                          LEFT JOIN areas a ON p.area = a.id 
                          ORDER BY p.nombre_programa ASC');
        return $this->db->registros();
    }

    public function obtenerProgramaPorId($id) {
        $this->db->query('SELECT p.*, a.nombre_area 
                          FROM programas p 
                          LEFT JOIN areas a ON p.area = a.id 
                          WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarPrograma($datos) {
        $this->db->query('INSERT INTO programas (nombre_programa, area, fecha_creacion) 
                          VALUES (:nombre_programa, :area, NOW())');
        
        $this->db->bind(':nombre_programa', $datos['nombre_programa']);
        $this->db->bind(':area', $datos['area']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarPrograma($datos) {
        $this->db->query('UPDATE programas SET 
                          nombre_programa = :nombre_programa, 
                          area = :area, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_programa', $datos['nombre_programa']);
        $this->db->bind(':area', $datos['area']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarPrograma($id) {
        // Verificar si el programa está en uso en la tabla fichas
        $this->db->query('SELECT COUNT(*) as total FROM fichas WHERE programa_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un programa que tiene fichas asociadas
        }
        
        $this->db->query('DELETE FROM programas WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarProgramasPorNombre($nombre) {
        $this->db->query('SELECT p.*, a.nombre_area 
                          FROM programas p 
                          LEFT JOIN areas a ON p.area = a.id 
                          WHERE p.nombre_programa LIKE :nombre 
                          ORDER BY p.nombre_programa ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }

    public function obtenerProgramasPorArea($area_id) {
        $this->db->query('SELECT p.*, a.nombre_area 
                          FROM programas p 
                          LEFT JOIN areas a ON p.area = a.id 
                          WHERE p.area = :area_id 
                          ORDER BY p.nombre_programa ASC');
        $this->db->bind(':area_id', $area_id);
        return $this->db->registros();
    }
} 